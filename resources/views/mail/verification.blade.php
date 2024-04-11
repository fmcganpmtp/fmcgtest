<html>
<head></head>
<body>
<p>Dear {{ $name }},</p>
<br>
<p>To verify your email address, please click the following link.</p>
<br>
<a href="{{ route('verification', ['code' => $code]) }}">{{ route('verification', ['code' => $code]) }}</a>
<br>
<p>Sincerely,</p>
<p>{{ config('app.name') }}</p>
</body>
</html>
 