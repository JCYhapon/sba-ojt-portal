<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{----alphinejs----}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.js"></script>
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

    <div class="w-full lg:container mx-auto lg:max-w-screen-xl  mt-8 p-12 h-auto">

        <div class="grid grid-rows-3 lg:gap-12 md:gap-6 gap-4">
            <!--  FIRST ROW -->
            <div class="bg-white grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-2 ss:grid-cols-2 xs:grid-cols-1 p-8 shadow-md rounded-md lg:h-40">
                <div class="grid lg:gap-2 md:gap-0 ss:gap-0">
                    <h1 class="lg:text-3xl md:text-[1.5em] sm:text-[1.5em] ss:text-[18px] xs:text-[18px]"><span class="font-bold">Welcome,</span> {{ Auth::user()->name }}</h1>
                    <p class="lg:text-lg md:text-[18px] md:mt-3 ss:text-[15px] xs:text-[15px] ss:mt-0">
                        @if(($companyName == 0))
                        Do well on your internship
                        @else
                        Do well on your internship at {{ $companyName }}
                        @endif
                    </p>
                </div>
                <div class="flex flex-col lg:justify-end lg:row-span-2 md:row-span-2 md:justify-end sm:justify-end ss:justify-end xs:items-center xs:justify-end">
                    <div class=" grid justify-items-end">
                        <a href=" {{ route('student_profile') }}"><button class="bg-black text-white p-1 rounded-md lg:text-sm lg:w-40 md:text-[14px] md:w-[9rem] sm:text-[13px] sm:w-[9rem] ss:text-[13px] ss:w-[9rem] xs:text-[13px] xs:w-[9rem]">Go to your
                                Profile</button></a>
                    </div>
                </div>
            </div>

            <!--  SECOND ROW -->
            <div class="lg:row-span-1">
                <div class="bg-white  p-8 shadow-md rounded-md h-40 flex flex-col justify-center items-center gap-6">
                    <div>
                        <h1 class="lg:text-2xl md:text-lg sm:text-lg ss:text-lg font-semibold">View Partner Companies Here:</h1>
                    </div>
                    <div><button class="bg-black text-white p-1 rounded-md lg:text-sm lg:w-36 md:text-[14px] md:w-[9rem] sm:text-[14px] sm:w-[9rem] ss:text-[14px] ss:w-[9rem] xs:text-[14px] xs:w-[9rem]">
                            <a href="{{ route('student_company-list') }}">Company List</a></button></div>
                </div>
            </div>

            <!--  THIRD ROW -->
            <div class="lg:row-span-3">
                <div class="grid grid-cols-2 lg:gap-16 md:gap-10 gap-6">
                    <div class="bg-white shadow-md rounded-md h-auto flex flex-col items-center justify-center gap-6">
                        <div>
                            <h1 class="font-semibold lg:text-2xl mt-5">Journal Entry</h1>
                        </div>
                        <div>
                            <a href="{{ route('student_journal') }}"><button class="bg-black text-white p-1 rounded-md text-sm w-36 lg:mb-4 ">Journal</button>
                        </div></a>
                        <div>
                            <p class="lg:text-sm md:text-[13px] sm:text-[12px] mb-2 text-center ss:text-[12px]">Please submit your Daily Journal entry here and input your working hours
                            </p>
                        </div>
                    </div>
                    <div class="bg-white shadow-md rounded-md lg:h-48 flex flex-col items-center justify-center gap-6">
                        <div>
                            <h1 class="font-semibold lg:text-2xl mt-5">Company Matches</h1>
                        </div>
                        <div>
                            <button class="bg-black text-white p-1 rounded-md text-sm lg:w-36 lg:mb-4 md:w-[9rem]  sm:w-[9rem]  ss:w-[9rem]"><a href="{{ route('matched.company.list') }}">Matched Companies</a></button>
                        </div>
                        <div>
                            <p class="lg:text-sm md:text-[13px] sm:text-[12px] ss:text-[12px] mb-2 text-center">Contact your coordinator for more information about your company matches
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!--  END OF THIRD ROW -->
        </div>


</body>

</html>