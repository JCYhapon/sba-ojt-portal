<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
{{----alphinejs----}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.js" ></script>
  @vite('resources/css/app.css')
    <title>SBA-OJT PORTAL</title>
</head>
<body>
    <section class="min-h-screen flex items-stretch text-white ">
        <div class="lg:flex w-1/2 hidden bg-gray-500 bg-no-repeat bg-cover relative items-center" style="background-image: url(https://images.unsplash.com/photo-1577495508048-b635879837f1?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=675&q=80);">
            <!-- ... (existing content) ... -->
        </div>
        <div class="lg:w-1/2 w-full flex items-center justify-center text-center md:px-16 px-0 z-0" style="background-color: #161616;">
            <div class="absolute lg:hidden z-10 inset-0 bg-gray-500 bg-no-repeat bg-cover items-center" style="background-image: url(https://images.unsplash.com/photo-1577495508048-b635879837f1?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=675&q=80);">
                <!-- ... (existing content) ... -->
            </div>
            <div class="w-full py-6 z-20">
                <h1 class="my-6">
                    <span class="font-bold text-3xl text-white">Welcome Back!</span>
                </h1>
                <!-- Laravel login form -->
                <div class="container p-24">
                <form method="POST" action="{{ route('login') }}" class="mb-4">
                    @csrf
                    <div class="mb-4">
                        <!-- <label for="email" class="text-sm font-medium text-gray-500">Email Address</label> -->
                        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus
                            class="w-full px-4 py-2 border rounded-md bg-gray-700 text-gray-300 focus:border-blue-500 focus:outline-none focus:shadow-outline-blue @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <!-- <label for="password" class="text-sm font-medium text-gray-500">Password</label> -->
                        <input id="password" type="password" placeholder="Password" name="password" required
                            class="w-full px-4 py-2 border rounded-md bg-gray-700 text-gray-300 focus:border-blue-500 focus:outline-none focus:shadow-outline-blue @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                                class="text-blue-500 focus:ring-blue-400 border-gray-700 rounded">
                            <span class="ml-2 text-sm text-gray-500">Remember me</span>
                        </label>
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-500 text-gray-200 p-2 rounded-md hover:bg-blue-400 focus:outline-none focus:shadow-outline-blue">
                        Log in
                    </button>
                </form>
                </div>
                <!-- End of Laravel login form -->
                
            </div>
        </div>
    </section>
</body>
</html>
