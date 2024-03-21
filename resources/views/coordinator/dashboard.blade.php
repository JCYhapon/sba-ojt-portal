<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{----alphinejs----}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Tailwindcss CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/background.css') }}">

    <title>Dashboard</title>
</head>

<body>

    <!-- CODE FOR NAVBAR -->
    <div class="w-full bg-gray-800 text-gray-200">
        <div x-data="{ open: false }" class="mx-auto flex max-w-screen-xl flex-col px-4 md:flex-row md:items-center md:justify-between md:px-6 lg:px-8">
            <div class="flex flex-row items-center justify-between p-4">
                <a href="{{ route('coordinator') }}" class="focus:shadow-outline rounded-lg text-lg font-semibold uppercase tracking-widest text-white focus:outline-none">SBA-OJT Portal</a>
                <button class="focus:shadow-outline rounded-lg focus:outline-none md:hidden" @click="open = !open">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="h-6 w-6">
                        <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <nav :class="{'flex': open, 'hidden': !open}" class="hidden flex-grow flex-col pb-4 md:flex md:flex-row md:justify-end md:pb-0">
                <a class="focus:shadow-outline mt-2 text-[#AD974F] font-bold rounded-lg bg-gray-700 px-4 py-2 text-sm  hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0" href="{{ route('coordinator') }}">Dashboard</a>
                <a class="focus:shadow-outline mt-2 rounded-lg bg-transparent px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('coordinator_company-list') }}">Company List</a>
                <a class="focus:shadow-outline mt-2 rounded-lg bg-transparent px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('coordinator_student-list') }}">Student List</a>
                <a class="focus:shadow-outline mt-2 rounded-lg bg-transparent px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('coordinator_student-journal') }}">Student Journals</a>

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
                                <a href="{{ route('coordinator_profile') }}">Profile</a>
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

    <div class="w-full container mx-auto max-w-screen-xl mt-8 lg:p-12 p-2 h-auto">

        <div class="lg:grid lg:grid-rows-3 gap-12 flex flex-col">
            <!--  FIRST ROW -->
            <div class="bg-white flex flex-col gap-4 p-8 shadow-md rounded-md h-auto">
                <div class="flex flex-col gap-4">
                    <h1 class="lg:text-3xl text-2xl"><span class="font-bold">Welcome,</span> {{ Auth::user()->name }}</h1>
                    <p class="lg:text-lg text-sm">You are using <span class="capitalize">{{ Auth::user()->major }}</span> Coordinator Account</p>
                </div>
                <div class="flex flex-col justify-end">
                    <div class="lg:grid lg:justify-items-end  ">
                        <a href="{{ route('coordinator_student-list') }}"><button class="bg-[#AD974F] hover:bg-[#736023] text-white p-1 rounded-md text-sm w-40">Manage Student</button></a>
                    </div>
                </div>
            </div>

            <!--  SECOND ROW -->
            <div class="row-span-3">
                <div class="lg:grid lg:grid-cols-3 gap-12 h-auto flex flex-col">
                    <div class="bg-white shadow-md rounded-md p-8 col-span-1 lg:h-[26rem] h-auto flex flex-col justify-between">
                        <div>
                            @php
                            $userMajor = auth()->user()->major;
                            @endphp

                            <p class="text-center font-bold">Student Status Tracker</p>
                            <div class="mx-auto w-11/12 overflow-hidden md:w-3/5 h-22">
                                <canvas data-te-chart="doughnut" data-te-dataset-data='[
                                        {{ $totalHiredStudents }},
                                        {{ $totalNonHiredStudents }}]' data-te-dataset-background-color='["#AD974F", "#1F2937"]'>
                                </canvas>
                            </div>


                        </div>

                        {{-- Display for Student Tracker --}}
                        <div>
                            <p id="deployedCount" class="font-semibold cursor-pointer hover:underline">Deployed: {{ $totalHiredStudents }} Counts</p>
                            <p id="undeployedCount" class="font-semibold cursor-pointer hover:underline">Undeployed: {{ $totalNonHiredStudents }} Counts</p>
                            <p onclick="window.location='{{ route('coordinator_student-list') }}';" class="text-[#AD974F] font-semibold  cursor-pointer hover:underline">Total Enrolled Students: {{ $totalEnrolledStudents }} Students</p>
                        </div>
                    </div>
                    <div class="grid grid-rows-2 gap-8 col-span-2">
                        <div class="bg-white shadow-md rounded-md p-8">
                            <div class="lg:grid lg:grid-cols-2 justify-center text-center flex flex-col">
                                <div class="flex flex-col lg:gap-7 gap-2 mb-3">
                                    <div>
                                        <p>Partner Companies</p>
                                    </div>
                                    <div>
                                        <a href="{{ route('coordinator_company-list') }}"> <button class="bg-[#AD974F] hover:bg-[#736023] text-white p-1 rounded-md text-sm w-36">Manage
                                                Company</button></a>
                                    </div>
                                </div>

                                <div class="flex flex-row justify-center gap-10">
                                    <div id="activeCompany" class="flex flex-col gap-7 cursor-pointer hover:border-black border-2 border-transparent p-1 rounded-md">
                                        <div>
                                            <p>Active</p>
                                        </div>
                                        <div>
                                            <p class="font-bold text-xl">{{ $totalCompaniesWithStatus1 }}</p>
                                        </div>
                                    </div>

                                    <div id="inactiveCompany" class="flex flex-col gap-7 cursor-pointer hover:border-black border-2 border-transparent p-1 rounded-md">
                                        <div>
                                            <p>Inactive</p>
                                        </div>
                                        <div>
                                            <p class="font-bold text-xl">{{ $totalCompaniesWithStatus2 }}</p>
                                        </div>
                                    </div>

                                    <div onclick="window.location='{{ route('coordinator_company-list') }}';" class="flex flex-col gap-7 cursor-pointer hover:border-black border-2 border-transparent p-1 rounded-md">
                                        <div>
                                            <p>Total</p>
                                        </div>
                                        <div>
                                            <p class="font-bold text-xl">{{ $totalCompanies }}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="bg-white shadow-md rounded-md p-8">
                            <div class="grid grid-cols-2 justify-center text-center ">
                                <div class="flex flex-col gap-7">
                                    <div>
                                        <p>Journal Entries</p>
                                    </div>
                                    <div>
                                        <a href="{{ route('coordinator_student-journal') }}"> <button class=" bg-[#AD974F] hover:bg-[#736023] text-white p-1 rounded-md text-sm w-36">
                                                Journal</button></a>
                                    </div>
                                </div>

                                <div class=" flex flex-col gap-7">
                                    <div>
                                        <p>Unmarked Journals</p>
                                    </div>
                                    <div>
                                        <p class="font-bold text-xl">{{ $totalUnreadJournals }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/coordinator/dashboard.js') }}">
    </script>

</body>

</html>