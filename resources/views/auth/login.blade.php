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

<body>
    <section class="min-h-screen flex justify-center items-center text-white ">
        <div class="w-full flex">

            <div class="w-[100%]">
                <div id="background" class="w-[100%] h-full ">

                </div>
            </div>

            <!-- Laravel login form -->

            <div class="w-[80%] h-[100vh] mx-auto bg-white p-[10rem]">
                <div class="w-full">
                    <img src="{{ asset('logo.png') }}" alt="" class="w-full">
                </div>
                <h1 class="text-center mb-5">
                    <span class="font-bold text-3xl text-black ">SBA OJT Portal</span>
                </h1>
                <form method="POST" action="{{ route('login') }}" class="mb-4">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="text-sm font-medium text-black">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus class="w-full px-4 py-2 border rounded-md text-black bg-gray-100 focus:border-black focus:outline-none focus:shadow-outline-blue @error('email') border-red-500 @enderror">
                        @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="text-sm font-medium text-black">Password</label>
                        <input id="password" type="password" placeholder="Entern your password" name="password" required class="w-full px-4 py-2 border rounded-md text-black bg-gray-100 focus:border-black focus:outline-none focus:shadow-outline-blue @error('password') border-red-500 @enderror">
                        @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="text-black focus:black border-gray-700 rounded">
                            <span class="ml-2 text-sm text-gray-500">Remember me</span>
                        </label>
                    </div>
                    <button type="submit" class="w-full bg-gray-800 text-gray-200 p-2 rounded-md hover:bg-gray-800 focus:outline-none focus:shadow-outline-blue">
                        Log in
                    </button>
                </form>
            </div>
            <!-- End of Laravel login form -->
        </div>

    </section>
</body>

</html>