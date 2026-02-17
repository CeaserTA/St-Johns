<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Service Registration Receipt</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #2c5282;">Service Registration Confirmed ✓</h2>

        <p>Dear {{ $registration->guest_full_name ?? $registration->member->full_name ?? 'Valued Member' }},</p>

        <p>Thank you for registering for <strong>{{ $registration->service->name }}</strong>. Your payment has been confirmed and your registration is now complete.</p>

        <div style="background-color: #f7fafc; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #2c5282;">Registration Details</h3>
            
            <p style="margin: 8px 0;"><strong>Receipt Number:</strong> {{ $registration->receipt_number }}</p>
            <p style="margin: 8px 0;"><strong>Service:</strong> {{ $registration->service->name }}</p>
            <p style="margin: 8px 0;"><strong>Schedule:</strong> {{ $registration->service->schedule }}</p>
            
            @if(!$registration->service->isFree())
                <p style="margin: 8px 0;"><strong>Amount Paid:</strong> {{ $registration->service->formatted_fee }}</p>
                <p style="margin: 8px 0;"><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $registration->payment_method ?? 'N/A')) }}</p>
                @if($registration->transaction_reference)
                    <p style="margin: 8px 0;"><strong>Transaction Reference:</strong> {{ $registration->transaction_reference }}</p>
                @endif
            @else
                <p style="margin: 8px 0;"><strong>Fee:</strong> <span style="color: #38a169;">FREE</span></p>
            @endif
            
            <p style="margin: 8px 0;"><strong>Confirmed On:</strong> {{ optional($registration->paid_at)->format('d M Y H:i') ?? now()->format('d M Y H:i') }}</p>
        </div>

        <div style="background-color: #edf2f7; padding: 15px; border-left: 4px solid #4299e1; margin: 20px 0;">
            <p style="margin: 0;"><strong>Next Steps:</strong></p>
            <p style="margin: 8px 0 0 0;">Please arrive at the church on the scheduled date. If you have any questions, feel free to contact us.</p>
        </div>

        <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;">

        <p style="font-style: italic; color: #718096;">"Come to me, all you who are weary and burdened, and I will give you rest." – Matthew 11:28</p>

        <p>God bless you,<br>
        <strong>St. John's Parish Church Entebbe</strong></p>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0; font-size: 12px; color: #718096;">
            <p>This is an automated receipt. Please keep it for your records.</p>
            <p>For inquiries, contact us at: <a href="mailto:info@stjohnsentebbe.org">info@stjohnsentebbe.org</a></p>
        </div>
    </div>

</body>
</html>
