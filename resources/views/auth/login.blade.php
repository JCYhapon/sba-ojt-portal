<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{----alphinejs----}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/loginpage.css') }}">

    @vite('resources/css/app.css')
    <title>SBA-OJT PORTAL</title>

</head>

<body>
    <section class="min-h-screen flex justify-center items-center mx-auto  text-white ">
        <div class="w-full py-6">

            <!-- Laravel login form -->
            <div class="w-[40vh] mx-auto bg-white p-[2rem] shadow-lg rounded-md">
                <h1 class="text-center mb-5">
                    <span class="font-bold text-3xl text-black ">Welcome Back!</span>
                </h1>
                <form method="POST" action="{{ route('login') }}" class="mb-4">
                    @csrf
                    <div class="mb-4">
                        <!-- <label for="email" class="text-sm font-medium text-gray-500">Email Address</label> -->
                        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus class="w-full px-4 py-2 border rounded-md text-black focus:border-black focus:outline-none focus:shadow-outline-blue @error('email') border-red-500 @enderror">
                        @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <!-- <label for="password" class="text-sm font-medium text-gray-500">Password</label> -->
                        <input id="password" type="password" placeholder="Password" name="password" required class="w-full px-4 py-2 border rounded-md  text-black focus:border-black focus:outline-none focus:shadow-outline-blue @error('password') border-red-500 @enderror">
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
                    <button type="submit" class="w-full bg-blue-500 text-gray-200 p-2 rounded-md hover:bg-blue-400 focus:outline-none focus:shadow-outline-blue">
                        Log in
                    </button>
                </form>
            </div>
            <!-- End of Laravel login form -->
        </div>

    </section>
</body>

</html>