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
        <div class="w-full flex flex-row">

            <div class="lg:w-[100%] md:w-[70%]  md:hidden ssm:hidden sm:hidden ss:hidden xs:hidden lg:block llg:block">
                <div id="background" class="w-[100%] h-full ">

                </div>
            </div>

            <!-- Laravel login form -->

            <div id="form" class="w-[80%] md:[100%] lg:w-[70%] h-[100vh] mx-auto  lg:p-[10rem] flex flex-col justify-center gap-[3rem] items-center">
                <div class="flex flex-row justify-center ">
                    <img src="{{ asset('assets/sba-logo.png') }}" alt="sba-logo" class="">
                </div>



                <div class="bg-white h-auto p-[3rem] w-[100%] llg:w-[70%] lg:w-[100%] mmd:w-[100%] md:w-[100%]  rounded-[6%]">
                    <h1 class="text-center mb-[30px]">
                        <span class="font-bold text-2xl text-black ">SBA OJT Portal</span>
                    </h1>

                    @if(session()->has('error'))
                    <div class="bg-red-500 text-green-red p-4 mb-2 rounded-sm w-full text-center">
                        {{ session('error') }}
                    </div>
                    @endif

                    @if(session()->has('email'))
                    <div class="bg-green-500 text-white p-4 mb-2 rounded-sm w-full text-center">
                        {{ session('email') }}
                    </div>
                    @endif

                    @if(session()->has('status'))
                    <div class="bg-green-500 text-white p-4 mb-2 rounded-sm w-full text-center">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="mb-4">
                        @csrf
                        <div class="mb-4">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus class="w-full px-4 py-2 border rounded-md text-black bg-gray-100 focus:border-black focus:outline-none focus:shadow-outline-blue @error('email') border-red-500 @enderror">
                            @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <input id="password" type="password" placeholder="Password" name="password" required class="w-full px-4 py-2 border rounded-md text-black bg-gray-100 focus:border-black focus:outline-none focus:shadow-outline-blue @error('password') border-red-500 @enderror">
                            @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full mb-8 font-semibold bg-[#AD974F] text-white p-2 rounded-md hover:bg-[#736023] focus:outline-none focus:shadow-outline-blue">
                            Login
                        </button>
                        <div class="text-center">
                            <a href="{{ route('forget.password') }}" class="text-gray-500 cursor-pointer underline pt-6">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>

                    </form>
                </div>

            </div>
            <!-- End of Laravel login form -->
        </div>

    </section>
</body>

</html>