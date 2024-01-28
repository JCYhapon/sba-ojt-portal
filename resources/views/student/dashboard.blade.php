<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{----alphinejs----}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.js"></script>
    <!-- FAVICON -->
    <link rel="icon" href="{{ url('assets/logo.png') }}">
    @vite('resources/css/app.css')
    <title>Dashboard</title>
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
                <a class="focus:shadow-outline mt-2 rounded-lg bg-gray-700 px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0" href="{{ route('student') }}">Dashboard</a>
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

    <div class="w-full container mx-auto max-w-screen-xl mt-8 p-12 h-auto">

        <div class="grid grid-rows-3 gap-12">
            <!--  FIRST ROW -->
            <div class="bg-white grid grid-cols-2 p-8 shadow-md rounded-md h-40">
                <div class="grid gap-2">
                    <h1 class="text-3xl"><span class="font-bold">Welcome,</span> {{ Auth::user()->name }}</h1>
                    <p class="text-lg">
                        @if(($companyName == 0))
                        Do well on your internship
                        @else
                        Do well on your internship at {{ $companyName }}
                        @endif
                    </p>
                </div>
                <div class="flex flex-col justify-end">
                    <div class="grid justify-items-end">
                        <a href="{{ route('student_profile') }}"><button class="bg-black text-white p-1 rounded-md text-sm w-40">Go to your
                                Profile</button></a>
                    </div>
                </div>
            </div>

            <!--  SECOND ROW -->
            <div class="row-span-1">
                <div class="bg-white  p-8 shadow-md rounded-md h-40 flex flex-col justify-center items-center gap-6">
                    <div>
                        <h1 class="text-2xl font-semibold">View Partner Companies Here:</h1>
                    </div>
                    <div><button class="bg-black text-white p-1 rounded-md text-sm w-36">
                            <a href="{{ route('student_company-list') }}">Company List</a></button></div>
                </div>
            </div>

            <!--  THIRD ROW -->
            <div class="row-span-3">
                <div class=" grid grid-cols-2 gap-16 ">
                    <div class="bg-white shadow-md rounded-md h-48 flex flex-col items-center justify-center gap-6">
                        <div>
                            <h1 class="font-semibold text-2xl">Journal Entry</h1>
                        </div>
                        <div>
                            <a href="{{ route('student_journal') }}"><button class="bg-black text-white p-1 rounded-md text-sm w-36 mb-4">Journal</button>
                        </div></a>
                        <div>
                            <p class="text-sm">Please submit your Daily Journal entry here and input your working hours
                            </p>
                        </div>
                    </div>
                    <div class="bg-white shadow-md rounded-md h-48 flex flex-col items-center justify-center gap-6">
                        <div>
                            <h1 class="font-semibold text-2xl">Company Matches</h1>
                        </div>
                        <div>
                            <button class="bg-black text-white p-1 rounded-md text-sm w-36 mb-4"><a href="{{ route('matched.company.list') }}">Matched Companies</a></button>
                        </div>
                        <div>
                            <p class="text-sm">Contact your coordinator for more information about your company matches
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!--  END OF THIRD ROW -->
        </div>


</body>

</html>