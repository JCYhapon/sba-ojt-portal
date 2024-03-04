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

    <script>
        function togglePasswordVisibility() {
            var passwordField1 = document.getElementById("password");
            var passwordField2 = document.getElementById("password_confirmation");
            var toggleButton = document.getElementById("toggleButton");

            if (passwordField1.type === "password") {
                passwordField1.type = "text";
                passwordField2.type = "text";
                toggleButton.textContent = "Hide";
            } else {
                passwordField1.type = "password";
                passwordField2.type = "password";
                toggleButton.textContent = "Show";
            }
        }

        function validatePassword() {
            var password = document.getElementById("password").value;
            var uppercaseRegex = /[A-Z]/;
            var lowercaseRegex = /[a-z]/;
            var symbolRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;

            if (!uppercaseRegex.test(password) || !lowercaseRegex.test(password)) {
                alert("Password must contain both uppercase and lowercase letters.");
                return false;
            }

            if (!symbolRegex.test(password)) {
                alert("Password must contain at least one symbol.");
                return false;
            }

            return true;
        }
    </script>
</head>

<body class="">
    <section class="min-h-screen flex justify-center items-center mx-auto text-white">
        <div class="w-full py-6">
            <div class="lg:w-[25%] w-full mx-auto bg-white p-6 shadow-lg rounded-lg">
                <h1 class="text-center mb-5">
                    <span class="font-bold text-3xl text-black">Set your new password</span>
                </h1>
                <form method="POST" action="{{ route('reset.password.post') }}" onsubmit="return validatePassword()">
                    @csrf
                    <input type="text" hidden name="token" value="{{ $token }}">
                    <span class="block text-center text-gray-600 mt-4 pb-5">Your new password should be different from passwords previously used.</span>
                    <div class="my-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input id="email" type="email" class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 border-2 rounded-md text-gray-700" name="email" required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Enter New Password</label>
                        <div class="relative">
                            <input id="password" type="password" class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 border-2 rounded-md text-gray-700" name="password" required autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <div class="relative">
                            <input id="password_confirmation" type="password" class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 border-2 rounded-md text-gray-700" name="password_confirmation" required autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <button type="button" onclick="togglePasswordVisibility()" id="toggleButton" class="w-[20%] flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-800">Show</button>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#AD974F]  focus:outline-none focus:ring-2 focus:ring-offset-2 ">
                            Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>