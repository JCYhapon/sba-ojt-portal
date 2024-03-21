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

    <!-- Boxicon CDN -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/background.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>Dashboard</title>
</head>

<body>

    <!-- CODE FOR NAVBAR -->
    <div class="w-full bg-gray-800 text-gray-200">
        <div x-data="{ open: false }" class="mx-auto flex max-w-screen-xl flex-col px-4 md:flex-row md:items-center md:justify-between md:px-6 lg:px-8">
            <div class="flex flex-row items-center justify-between p-4">
                <a href="{{ route('student') }}" class="focus:shadow-outline rounded-lg text-lg font-semibold uppercase tracking-widest text-white focus:outline-none">SBA-OJT
                    Portal</a>
                <button class="focus:shadow-outline rounded-lg focus:outline-none md:hidden" @click="open = !open">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="h-6 w-6">
                        <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <nav :class="{'flex': open, 'hidden': !open}" class="hidden flex-grow flex-col pb-4 md:flex md:flex-row md:justify-end md:pb-0">
                <a class="focus:shadow-outline mt-2 text-[#AD974F] font-bold rounded-lg bg-gray-700 px-4 py-2 text-sm  hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0" href="{{ route('student') }}">Dashboard</a>
                <a class="focus:shadow-outline mt-2 rounded-lg bg-transparent px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('student_company-list') }}">Company List</a>
                <a class="focus:shadow-outline mt-2 rounded-lg bg-transparent px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('student_journal') }}">Journal</a>

                <div @click.away="open = false" class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="focus:shadow-outline mt-2 flex w-full flex-row items-center rounded-lg bg-transparent px-4 py-2 text-left text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4 md:inline md:w-auto">
                        <span>{{ Auth::user()->name }} </span>
                        <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="mt-1 ml-1 inline h-4 w-4 transform transition-transform duration-200 md:-mt-1">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="relative right-0 mt-2 w-full origin-top-right rounded-md shadow-lg md:w-48">

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

    <div class="w-full lg:container mx-auto lg:max-w-screen-xl  mt-4 lg:px-12 px-4 h-auto">
        @foreach (explode(',',Auth::user()->schoolID) as $studentID)
        @php
        $student = \App\Models\Student::where('studentID', $studentID)->first();
        @endphp

        <div class="flex flex-col gap-8 h-auto">
            <!--  FIRST ROW -->
            <div class=" flex lg:flex-row flex-col justify-between">
                <div class="flex flex-col gap-8 z-0 bg-white p-6 lg:w-[68%] shadow-md rounded-md lg:mb-0 md:mr-2 mb-2" data-aos="fade-right" data-aos-delay="600" data-aos-duration="1000">
                    <div class="grid lg:gap-2 md:gap-0 ss:gap-0 border-b">
                        <div class="flex justify-between lg:flex-row flex-col">
                            <h1 class="lg:text-3xl md:text-[1.5em] sm:text-[1.5em] ss:text-[1.5em] xs:text-[18px] text-[1.5em]"><span class="font-bold text-[#AD974F]">Welcome,</span> <span class="capitalize"> {{$student->firstName }}</span> 👋</h1>
                            <div>
                                <a href=" {{ route('student_profile') }}"><button class="bg-[#AD974F] hover:bg-[#736023] text-white text-sm p-1 rounded-md lg:text-sm lg:w-40 md:text-[14px] md:w-[9rem] sm:text-[13px] sm:w-[9rem] ss:text-[13px] ss:w-[9rem] xs:text-[13px] xs:w-[9rem]">Go to your
                                        Profile</button></a>
                            </div>
                        </div>
                        <p class="lg:text-lg md:text-[18px] md:mt-3 ss:text-[15px] xs:text-[15px] ss:mt-0">
                            @if(($companyName == 0))
                            Do well on your internship
                            @else
                            Do well on your internship at {{ $companyName }}
                            @endif
                        </p>
                    </div>

                    <div class="flex gap-6">
                        <h1 class="lg:text-xl md:text-lg sm:text-lg ss:text-lg font-semibold">View Partner Companies Here</h1>
                        <div>
                            <button class="bg-[#AD974F] hover:bg-[#736023] text-white p-1 rounded-md lg:text-sm lg:w-36 md:text-[14px] md:w-[9rem] sm:text-[14px] sm:w-[9rem] ss:text-[14px] ss:w-[9rem] xs:text-[14px] xs:w-[9rem]">
                                <a href="{{ route('student_company-list') }}">Company List</a></button>
                        </div>
                    </div>

                    <h2 class="mt-8 text-lg font-semibold text-[#AD974F]">Coordinator:
                        @if ($major === 'Accounting')
                        <span>Robin G. Santos</span>
                        @elseif ($major === 'Management')
                        <span>Michelle M. Estralla</span>
                        @endif
                    </h2>
                    <div class="grid lg:grid-cols-2 grid-rows-2 gap-6">
                        <div class="flex flex-col gap-5">
                            <h2 class="border-b lg:w-[80%]">Coordinator Contact Details</h2>
                            <div class="ml-3 flex flex-col gap-1">
                                <div>
                                    @if ($major === 'Accounting')
                                    <span class="flex items-center gap-1"> <box-icon name='envelope'></box-icon>rgsantos@hau.edu.ph</span>
                                    @elseif ($major === 'Management')
                                    <span class="flex items-center gap-1"> <box-icon name='envelope'></box-icon>mestralla@hau.edu.ph</span>
                                    @endif
                                </div>
                                <div>
                                    <span class="flex items-center gap-1"><box-icon name='phone'></box-icon>(1234) 12351</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-5">
                            <h2 class="border-b lg:w-[80%]">SBA Social Page</h2>
                            <div class="flex flex-col ml-3 gap-1">
                                <span class="underline">
                                    <a href="" class="flex gap-1"><box-icon name='facebook-square' type='logo'></box-icon>SBA Facebook Link</a>
                                </span>
                                <span class="underline">
                                    <a href="" class="flex gap-1"><box-icon name='facebook-square' type='logo'></box-icon>SBA Student Council Facebook Link</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-6 bg-white p-6 items-center shadow-lg rounded-md">
                    <div>
                        <h1 class="text-lg font-bold ">Total Hours Tracker</h1>
                        <div class="">
                            <canvas data-te-chart="doughnut" data-te-dataset-data='[
                                        {{ $totalRenderedHours }},
                                        {{ $remainingHours }}]' data-te-dataset-background-color='["#AD974F", "#1F2937"]'>
                            </canvas>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <p class="text-md font-semibold ">Hours Rendered: <span class="">{{ $totalRenderedHours }}</span></p>
                        <p class="text-md font-semibold ">Hours Left: <span class="">{{ $remainingHours }}</span></p>
                        <p class="text-md font-semibold ">Needed Hours: <span class="">{{ $neededHours }}</span></p>
                    </div>
                </div>
            </div>


            <div class="lg:grid lg:grid-cols-2 md:gap-10 gap-2">
                <div class="bg-white shadow-md rounded-md h-auto flex flex-col items-center justify-center gap-6 mb-2" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
                    <div>
                        <h1 class="font-semibold lg:text-2xl md:text-2xl sm:text-xl ss:text-2xl xs:text-xl text-[13px] mt-5">Journal Entry</h1>
                    </div>
                    <div>
                        <a href="{{ route('student_journal') }}"><button class="bg-[#AD974F] hover:bg-[#736023] text-white p-1 rounded-md lg:text-sm md:text-sm ss:text-sm sm:text-sm xs:text-sm text-[12px] lg:mb-4 w-[6rem] ">Journal</button>
                    </div></a>
                    <div>
                        <p class="lg:text-sm md:text-[13px] sm:text-[12px] mb-2 text-center ss:text-[12px] xs:text-[10px] text-[10px] p-2">Please submit your Daily Journal entry here and input your working hours
                        </p>
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-md lg:h-48 flex flex-col items-center justify-center gap-6 mb-2" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
                    <div>
                        <h1 class="font-semibold lg:text-2xl md:text-2xl sm:text-2xl ss:text-2xl xs:text-xl text-[13px] mt-5">Company Matches</h1>
                    </div>
                    <div>
                        <button class="bg-[#AD974F] hover:bg-[#736023] text-white p-1 rounded-md lg:text-sm md:text-sm ss:text-sm sm:text-sm xs:text-sm text-[12px] lg:w-36 lg:mb-4 md:w-[9rem]  sm:w-[9rem]  ss:w-[9rem] w-[6rem]"><a href="{{ route('match-students') }}">Matched Companies</a></button>
                    </div>
                    <div>
                        <p class="lg:text-sm md:text-[13px] sm:text-[12px] ss:text-[12px] xs:text-[10px] text-[10px] mb-2 text-center p-2">Contact your coordinator for more information about your company matches
                        </p>
                    </div>
                </div>
            </div>

            @endforeach
            <!--  END OF THIRD ROW -->
        </div>
    </div>





    <script src="{{ asset('js/student/dashboard.js') }}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init()
    </script>
</body>


</html>