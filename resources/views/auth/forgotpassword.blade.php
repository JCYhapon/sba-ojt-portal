<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwindcss CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/loginpage.css') }}">

    <title>SBA-OJT PORTAL</title>
</head>

<body>

    <!-- BACK BUTTON -->
    <div class="absolute mt-6 ml-6">
        <a href="{{ url()->previous() }}">
            <button class=" mb-8 flex font-semibold underline">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAMNJREFUSEvtlDEKwkAQRV8OIWiv4BlE8BaCteB1xFrwMArewcZe8BD6wYUtss5Mku2SMizv/fnZSUPlp6nMZxSYDUcqmgI74GhSswNegeBXYAEcgLNX4hEIfgPmwBNYAa+hBDn8AWwicIX4N8EEuP+SC74G3t7k6VxJILg6X34/bGd4aYIcHgncGrbtZXWBUletKNUyiMTag943yRJoml674BEkSfpV7IGL93p5BeLNgC1w8sKtTY5wimcjE3QSjgKztg/ExiAZuzHo1gAAAABJRU5ErkJggg==" />
                Back
            </button>
        </a>
    </div>

    <div class="w-full md:w-[50%] flex flex-col justify-center mx-auto h-screen relative">
        <div class="lg:w-[60%] mx-auto flex flex-col items-center gap-10">
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 lg:top-[27%] md:top-[20%] sm:top-[15%] xs:top-[10%]">
                <img src="{{ asset('assets/logo.png') }}" alt="">
            </div>
            <div class="bg-white p-8 rounded-lg shadow-lg flex flex-col gap-6">
                <span class="flex justify-center text-lg font-semibold">Forgot Password?</span>
                <p class="text-justify">If you're unable to access your account, please reach out to your designated coordinator for assistance in resetting your password. They'll be able to guide you through the process and help you regain access to your account.</p>
            </div>
        </div>
    </div>



</body>

</html>