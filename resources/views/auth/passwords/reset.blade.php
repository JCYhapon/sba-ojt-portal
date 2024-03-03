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

<body class="">
    <!-- BACK BUTTON -->
    <div class="absolute mt-6 ml-6">
        <a href="{{ url()->previous() }}">
            <button class=" mb-8 flex font-semibold underline">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAMNJREFUSEvtlDEKwkAQRV8OIWiv4BlE8BaCteB1xFrwMArewcZe8BD6wYUtss5Mku2SMizv/fnZSUPlp6nMZxSYDUcqmgI74GhSswNegeBXYAEcgLNX4hEIfgPmwBNYAa+hBDn8AWwicIX4N8EEuP+SC74G3t7k6VxJILg6X34/bGd4aYIcHgncGrbtZXWBUletKNUyiMTag943yRJoml674BEkSfpV7IGL93p5BeLNgC1w8sKtTY5wimcjE3QSjgKztg/ExiAZuzHo1gAAAABJRU5ErkJggg==" />
                Back
            </button>
        </a>
    </div>
    <section class="min-h-screen flex justify-center items-center mx-auto text-white">
        <div class="w-full lg:py-6">
            <!-- Laravel login form -->
            <div class="absolute top-[10%] left-1/2 transform -translate-x-1/2  lg:top-[18%] md:top-[20%] sm:top-[15%] xs:top-[10%]">
                <img src="{{ asset('assets/logo.png') }}" alt="">
            </div>
            <div class="lg:w-[25%] w-full md:w-[50%] mmd:w-[50%] sm:w-[50%] ssm:w-[50%] mx-auto bg-white p-8 shadow-lg rounded-md">

                @if(session()->has('error'))
                <div class="bg-red-500 text-green-red p-4 mb-4 rounded-full">
                    {{ session('error') }}
                </div>
                @endif
                <form method="POST" action="{{ route('forget.password.post') }}">
                    @csrf
                    <div class="flex flex-col gap-8">
                        <span class="block text-justify text-gray-600 mt-4 pb-5">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to create a new one.</span>
                        <div class="mb-4">

                            <input id="email" type="email" class="p-3 mt-1  block w-full  sm:text-sm border-b-2 border-gray-500  text-gray-800" placeholder="Email Address" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-4">
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#AD974F]  focus:outline-none focus:ring-2 focus:ring-offset-2 ">
                            Send Password Reset Link
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>


</body>


</html>