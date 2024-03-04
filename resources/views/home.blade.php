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
                <div class="bg-white h-auto p-[3rem] w-[100%] llg:w-[70%] lg:w-[100%] mmd:w-[100%] md:w-[100%]  rounded-[6%]">
                    <h1 class="text-center mb-[30px]">
                        <span class="font-bold text-2xl text-black ">Oops! Session Time Out.</span>
                    </h1>
                    <div class="flex flex-row justify-center m-10">
                        <img src="{{ asset('assets/sba-logo.png') }}" alt="sba-logo" class="">
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mb-4">
                        @csrf
                        <button type="submit" class="w-full mb-8 font-semibold bg-[#AD974F] text-white p-2 rounded-md hover:bg-[#736023] focus:outline-none focus:shadow-outline-blue">
                            Try to re-login again.
                        </button>
                    </form>
                </div>

            </div>
            <!-- End of Laravel login form -->
        </div>

    </section>
</body>

</html>