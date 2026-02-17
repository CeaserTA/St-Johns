<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRegistration extends Model
{
    protected $table = 'service_registrations';

    protected $fillable = [
        'service_id',
        'member_id',
        'guest_full_name',
        'guest_email',
        'guest_address',
        'guest_phone',
        'amount_paid',
        'payment_status',
        'payment_method',
        'transaction_reference',
        'paid_at',
        'payment_notes',
        'receipt_number',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the service that this registration belongs to
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the member that this registration belongs to (if any)
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Check if this is a guest registration
     */
    public function isGuest()
    {
        return is_null($this->member_id);
    }

    /**
     * Get the registrant's name (member or guest)
     */
    public function getRegistrantNameAttribute()
    {
        return $this->member ? $this->member->full_name : $this->guest_full_name;
    }

    /**
     * Get the registrant's email (member or guest)
     */
    public function getRegistrantEmailAttribute()
    {
        return $this->member ? $this->member->email : $this->guest_email;
    }

    /**
     * Get the registrant's phone (member or guest)
     */
    public function getRegistrantPhoneAttribute()
    {
        return $this->member ? $this->member->phone : $this->guest_phone;
    }

    /**
     * Check if payment is completed
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Check if payment is pending
     */
    public function isPending(): bool
    {
        return $this->payment_status === 'pending';
    }

    /**
     * Get payment status badge color
     */
    public function getPaymentStatusColorAttribute(): string
    {
        return match($this->payment_status) {
            'paid' => 'green',
            'pending' => 'yellow',
            'failed' => 'red',
            'refunded' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Generate receipt number
     */
    public function generateReceiptNumber(): string
    {
        $prefix = 'SVC'; // Service
        $year = now()->year;
        $sequence = str_pad($this->id, 6, '0', STR_PAD_LEFT);
        
        return "{$prefix}-{$year}-{$sequence}";
    }

    /**
     * Send receipt email
     */
    public function sendReceipt(): bool
    {
        $email = $this->guest_email ?? $this->member->email ?? null;

        if (!$email) {
            \Log::warning('Cannot send receipt - no email address', [
                'registration_id' => $this->id,
                'registrant_name' => $this->guest_full_name ?? $this->member->full_name ?? 'Unknown'
            ]);
            return false;
        }

        try {
            \Mail::to($email)->queue(new \App\Mail\ServiceRegistrationReceipt($this));

            \Log::info('Service registration receipt queued successfully', [
                'registration_id' => $this->id,
                'email' => $email,
                'receipt_number' => $this->receipt_number
            ]);

            return true;

        } catch (\Throwable $e) {
            \Log::error('Service registration receipt failed', [
                'registration_id' => $this->id,
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }
}

