<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Giving Receipt</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">

    <h2>Thank You for Your Generosity 🙏</h2>

    <p>Dear {{ $giving->giver_name }},</p>

    <p>We have received your {{ ucfirst($giving->giving_type) }}.</p>

    <hr>

    <p><strong>Receipt Number:</strong> {{ $giving->receipt_number }}</p>
    <p><strong>Amount:</strong> {{ $giving->formatted_amount }}</p>
    <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_',' ', $giving->payment_method)) }}</p>
    <p><strong>Date:</strong> {{ $giving->payment_date->format('d M Y H:i') }}</p>

    <hr>

    <p>“Each one must give as he has decided in his heart...” – 2 Corinthians 9:7</p>

    <p>God bless you abundantly.</p>

</body>
</html>
