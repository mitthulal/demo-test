<!DOCTYPE html>
<html>
<head>
    <title>Payment Link</title>
</head>
<body>
    <h1>Payment Request</h1>
    <p>Click the button below to complete your payment:</p>
    <p><a href="{{ $link }}" style="padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none;">Pay Now</a></p>
    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>
</html>
