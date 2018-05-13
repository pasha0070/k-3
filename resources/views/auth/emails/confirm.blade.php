<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hello</title>
</head>
<body>
<h1>Thank you for registering, {{$user->name}}!</h1>

<p>
    Follow the <a href='{{ url("register/confirm/{$user->token}") }}'>link</a> to complete the registration!
</p>
</body>
</html>
