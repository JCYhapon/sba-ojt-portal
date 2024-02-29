<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{----alphinejs----}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/background.css') }}">

    <!-- Tailwindcss CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Profile</title>


</head>

<body>

    <!-- CODE FOR NAVBAR -->
    <div class="w-full bg-gray-800 text-gray-200">
        <div x-data="{ open: false }" class="mx-auto flex max-w-screen-xl flex-col px-4 md:flex-row md:items-center md:justify-between md:px-6 lg:px-8">
            <div class="flex flex-row items-center justify-between p-4">
                <a href="#" class="focus:shadow-outline rounded-lg text-lg font-semibold uppercase tracking-widest text-white focus:outline-none">SBA-OJT
                    Portal</a>
                <button class="focus:shadow-outline rounded-lg focus:outline-none md:hidden" @click="open = !open">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="h-6 w-6">
                        <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <nav :class="{'flex': open, 'hidden': !open}" class="hidden flex-grow flex-col pb-4 md:flex md:flex-row md:justify-end md:pb-0">
                <a class="focus:shadow-outline mt-2 rounded-lg bg-transparent px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0" href="{{ route('student') }}">Dashboard</a>
                <a class="focus:shadow-outline mt-2 rounded-lg bg-transparent px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('student_company-list') }}">Company List</a>
                <a class="focus:shadow-outline mt-2 rounded-lg bg-transparent px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('student_journal') }}">Journal</a>

                <div @click.away="open = false" class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="focus:shadow-outline mt-2 flex w-full flex-row items-center rounded-lg bg-transparent px-4 py-2 text-left text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4 md:inline md:w-auto">
                        <span>{{ Auth::user()->name }} </span>
                        <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="mt-1 ml-1 inline h-4 w-4 transform transition-transform duration-200 md:-mt-1">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-full origin-top-right rounded-md shadow-lg md:w-48">

                        <div class="rounded-md bg-gray-800 px-2 py-2 shadow">
                            <div>
                                <a href="{{ route('student_profile') }}">Profile</a>
                            </div>
                            <div>
                                <a class="" href="{{ route('logout') }}" onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>



                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- END OF NAVBAR -->


    <div class="w-full container mx-auto max-w-screen-xl mt-8  lg:px-12">
        <div class="min-h-[80vh] bg-white rounded-md border-0 shadow-md p-5">
            <button class="mb-8">
                <a href="{{ url()->previous() }}"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAMNJREFUSEvtlDEKwkAQRV8OIWiv4BlE8BaCteB1xFrwMArewcZe8BD6wYUtss5Mku2SMizv/fnZSUPlp6nMZxSYDUcqmgI74GhSswNegeBXYAEcgLNX4hEIfgPmwBNYAa+hBDn8AWwicIX4N8EEuP+SC74G3t7k6VxJILg6X34/bGd4aYIcHgncGrbtZXWBUletKNUyiMTag943yRJoml674BEkSfpV7IGL93p5BeLNgC1w8sKtTY5wimcjE3QSjgKztg/ExiAZuzHo1gAAAABJRU5ErkJggg==" /></a>
            </button>
            <br>

            <!--  FIRST ROW -->
            <form action="{{ route('password.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
                @csrf
                @method('PUT')
                <!-- Label and Input for Old Password -->
                <div class="flex flex-col">
                    <label for="old_password" class="mb-2 font-semibold">Old Password:</label>
                    <input type="password" id="old_password" name="old_password" placeholder="Enter your old password" class="border rounded-md px-3 py-2">
                </div>

                <!-- Label and Input for New Password -->
                <div class="flex flex-col">
                    <label for="new_password" class="mb-2 font-semibold">New Password:</label>
                    <input type="password" id="new_password" name="new_password" placeholder="Enter your new password" class="border rounded-md px-3 py-2">
                </div>

                <!-- Label and Input for Re-enter New Password -->
                <div class="flex flex-col">
                    <label for="confirm_password" class="mb-2 font-semibold">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Enter your confirm password" class="border rounded-md px-3 py-2">
                </div>

                <div id="passwordRequirements" class="flex-col">
                    <div class="flex items-center">
                        <input type="checkbox" id="checkbox1" style="width: 20px; height: 20px; border-radius: 50%; border: 2px solid gray;">
                        <label for="checkbox1" class="ml-2">8 - 12 characters</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="checkbox2" style="width: 20px; height: 20px; border-radius: 50%; border: 2px solid gray;">
                        <label for="checkbox2" class="ml-2">Capital Letter</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="checkbox3" style="width: 20px; height: 20px; border-radius: 50%; border: 2px solid gray;">
                        <label for="checkbox3" class="ml-2">Numerical</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="checkbox4" style="width: 20px; height: 20px; border-radius: 50%; border: 2px solid gray;" class="bg-gray-800">
                        <label for="checkbox4" class="ml-2">With Special character</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="checkbox5" style="width: 20px; height: 20px; border-radius: 50%; border: 2px solid gray;">
                        <label for="checkbox5" class="ml-2">Confirm Password</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <button id="submitButton" type="submit" class="w-[30%] bg-[#AD974F] hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mt-4">Update Password</button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const passwordInput = document.getElementById('new_password');
                    const confirmInput = document.getElementById('confirm_password');
                    const checkboxes = document.querySelectorAll('#passwordRequirements input[type="checkbox"]');
                    const submitButton = document.getElementById('submitButton');

                    function validatePassword() {
                        const password = passwordInput.value;
                        const confirm = confirmInput.value;

                        const isLengthValid = password.length >= 8 && password.length <= 12;
                        const hasUpperCase = /[A-Z]/.test(password);
                        const hasNumber = /\d/.test(password);
                        const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
                        const isConfirmed = password === confirm;

                        checkboxes[0].checked = isLengthValid;
                        checkboxes[1].checked = hasUpperCase;
                        checkboxes[2].checked = hasNumber;
                        checkboxes[3].checked = hasSpecialChar;
                        checkboxes[4].checked = isConfirmed;

                        // Enable/disable submit button based on password requirements
                        submitButton.disabled = !(isLengthValid && hasUpperCase && hasNumber && hasSpecialChar && isConfirmed);

                        // Change button color based on password requirements
                        submitButton.classList.toggle('bg-gray-800', isLengthValid && hasUpperCase && hasNumber && hasSpecialChar && isConfirmed);
                        submitButton.classList.toggle('bg-gray-800', !(isLengthValid && hasUpperCase && hasNumber && hasSpecialChar && isConfirmed));
                    }

                    passwordInput.addEventListener('input', validatePassword);
                    confirmInput.addEventListener('input', validatePassword);
                });
            </script>
        </div>
    </div>



</body>
<script>

</script>

</html>