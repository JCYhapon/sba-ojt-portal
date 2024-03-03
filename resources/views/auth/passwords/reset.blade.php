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

    <title>SBA-OJT PORTAL</title>

</head>

<body class="bg-gray-800">
    <section class="min-h-screen flex justify-center items-center mx-auto text-white">
        <div class="w-full py-6">
            <!-- Laravel login form -->
            <div class="w-80 mx-auto bg-white p-8 shadow-lg rounded-md">
                <h1 class="text-center mb-5">
                    <span class="font-bold text-3xl text-black">SBA OJT Portal</span>
                </h1>
                @if(session()->has('error'))
                <div class="bg-red-500 text-green-red p-4 mb-4 rounded-full">
                    {{ session('error') }}
                </div>
                @endif
                <form method="POST" action="{{ route('forget.password.post') }}">
                    @csrf
                    <span class="block text-center text-gray-600 mt-4 pb-5">Create a new password</span>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input id="email" type="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-700" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Send Password Reset Link
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>


</html>