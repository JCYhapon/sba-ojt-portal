<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{----alphinejs----}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.js"></script>

    <!-- Tailwindcss CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/loginpage.css') }}">

    <title>SBA-OJT PORTAL Reset Password</title>

</head>

<body class="bg-gray-100 p-8">
    <h1 class="text-2xl font-bold mb-4">Reset Password</h1>
    <p class="text-gray-700 mb-4">Click the button below to reset your password.</p>
    <a href="{{ route('reset.password', $token) }}" class="inline-block bg-indigo-500 text-white font-semibold px-4 py-2 rounded-md hover:bg-indigo-600">Reset Password</a>
</body>

</html>