<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    @vite('resources/css/app.css')
</head>

<body>
    <div>
        @session("success")
            <div class="success-message">{{ session("success") }}</div>
        @endsession

        {{ $slot }}
    </div>
</body>

</html>