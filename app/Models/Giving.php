<?php

namespace App\Models;
use Illuminate\Support\Facades\Mail;
use App\Mail\GivingReceiptMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Giving extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'giving_type',
        'amount',
        'currency',
        'purpose',
        'notes',
        'payment_method',
        'transaction_reference',
        'payment_provider',
        'payment_account',
        'status',
        'payment_date',
        'confirmed_at',
        'confirmed_by',
        'receipt_number',
        'receipt_sent',
        'processing_fee',
        'net_amount',
        'ip_address',
        'user_agent',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'processing_fee' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'payment_date' => 'datetime',
        'confirmed_at' => 'datetime',
        'receipt_sent' => 'boolean',
        'metadata' => 'array',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    // Accessors & Mutators
    public function getGiverNameAttribute(): string
    {
        return $this->member ? $this->member->full_name : $this->guest_name;
    }

    public function getGiverEmailAttribute(): ?string
    {
        return $this->member ? $this->member->email : $this->guest_email;
    }

    public function getGiverPhoneAttribute(): ?string
    {
        return $this->member ? $this->member->phone : $this->guest_phone;
    }

    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 2) . ' ' . $this->currency;
    }

    public function getIsGuestAttribute(): bool
    {
        return is_null($this->member_id);
    }

    public function getIsMemberAttribute(): bool
    {
        return !is_null($this->member_id);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('giving_type', $type);
    }

    public function scopeByMember($query, $memberId)
    {
        return $query->where('member_id', $memberId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('payment_date', [$startDate, $endDate]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('payment_date', now()->month)
                    ->whereYear('payment_date', now()->year);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('payment_date', now()->year);
    }

    // Methods
    public function generateReceiptNumber(): string
    {
        $prefix = strtoupper(substr($this->giving_type, 0, 1)); // T, O, D, S
        $year = now()->year;
        $sequence = str_pad($this->id, 6, '0', STR_PAD_LEFT);
        
        return "{$prefix}{$year}{$sequence}";
    }

    public function markAsCompleted($confirmedBy = null): void
    {
        $this->update([
            'status' => 'completed',
            'confirmed_at' => now(),
            'confirmed_by' => $confirmedBy?->id,
            'receipt_number' => $this->receipt_number ?: $this->generateReceiptNumber(),
        ]);
    }

    public function markAsFailed(): void
    {
        $this->update([
            'status' => 'failed',
        ]);
    }

    public function calculateNetAmount(): void
    {
        $netAmount = $this->amount;
        
        if ($this->processing_fee) {
            $netAmount -= $this->processing_fee;
        }
        
        $this->update(['net_amount' => $netAmount]);
    }

    public function sendReceipt(): bool
    {
        $email = $this->giver_email;

        if (!$email) {
            \Log::warning('Cannot send receipt - no email address', [
                'giving_id' => $this->id,
                'giver_name' => $this->giver_name
            ]);
            return false;
        }

        try {
            Mail::to($email)->queue(new GivingReceiptMail($this));

            $this->update(['receipt_sent' => true]);

            \Log::info('Giving receipt queued successfully', [
                'giving_id' => $this->id,
                'email' => $email,
                'receipt_number' => $this->receipt_number
            ]);

            return true;

        } catch (\Throwable $e) {
            \Log::error('Giving receipt failed', [
                'giving_id' => $this->id,
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }
}
