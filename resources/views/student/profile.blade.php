<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{----alphinejs----}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

    <div class="w-full container mx-auto max-w-screen-xl mt-8 lg:px-12 px-2 h-auto overflow-x-auto ">
        <!-- Display Success Message -->
        @if(session()->has('success'))
        <div class="bg-green-200 text-green-800 p-4 mb-4">
            {{ session('success') }}
        </div>
        @endif
        @foreach (explode(',',Auth::user()->schoolID) as $studentID)
        @php
        $student = \App\Models\Student::where('studentID', $studentID)->first();
        @endphp

        <div class="flex flex-col xs:max-h-screen xs:gap-8 gap-4 h-auto">
            <!--  FIRST ROW -->
            <div class="bg-white row-span-1 flex justify-between lg:flex-row md:flex-row sm:flex-row flex-col gap-4 p-8 shadow-md rounded-md h-auto py-12">
                <div class="flex flex-col justify-between">
                    <div class="flex flex-row gap-10">
                        <h1 class="text-3xl">{{ $student->lastName }} {{ $student->firstName }}</h1>
                    </div>
                    <div>
                        <p class="text-lg capitalize"><span class="font-semibold">Section:</span> {{ $student->section }}</p>
                    </div>
                </div>
                <div class="flex items-end">
                    <div>
                        <p class="text-lg"><span class="font-semibold">Email:</span> {{ $student->email }}</p>
                    </div>
                </div>
                <div class="flex flex-col justify-between">
                    <p class="text-lg"><span class="font-semibold">Status:</span> {{ $student->status == 1 ? 'Active' : ($student->status == 2 ? 'Drop' : 'Unknown') }}</p>
                    <p class="text-lg capitalize"><span class="font-semibold">Course:</span> {{ $student->major }}</p>
                </div>
            </div>

            <!-- SECOND ROW -->
            <div class=" bg-white p-8 shadow-md rounded-md flex justify-between lg:flex-row md:flex-row sm:flex-row flex-col">
                <div class="flex flex-col justify-between gap-2">
                    <div>
                        @if(isset($companies->name) && !empty($companies->name))
                        <p class="text-lg "><span class="font-semibold">Company:</span> {{ $companies->name }}</p>
                        @else
                        <p class="text-lg font-semibold"><span class="font-semibold">Company:</span> Not Hired</p>
                        @endif
                    </div>

                    <div>
                        @if($student->hiredCompany !== null)
                        @if($student->supervisor !== null)
                        <label for="supervisor"><span class="font-semibold text-lg">Supervisor:</span> {{$student->supervisor}}</label>
                        @else
                        <form method="post" action="{{ route('add.supervisor') }}" class="p-4 md:p-1">
                            @csrf
                            <label for="supervisor" class="text-lg font-semibold">Supervisor:</label>

                        </form>

                        @endif
                        @endif
                    </div>

                    <div>
                        <p class="text-lg font-semibold">Position:</p>
                        {{-- Collect the position in an array first --}}
                        <form method="post" action="{{ route('student.remove-positions') }}" class="p-4 md:p-1">
                            @csrf
                            @method('post')

                            <div class="position-container flex flex-wrap">
                                @php
                                $positions = $student->position ?? [];
                                @endphp

                                @forelse($positions as $position)
                                <div class="position-item flex items-center mt-2 mr-2">
                                    <span style="background-color: #AD974F; color: white;" class="bg-[#AD974F] text-white p-1 rounded-md text-sm w-36 mb-4 text-center">{{ $position }} <button class="remove pl-2 pr-1" data-position="{{ $position }}"><b>×</b></button> </span>
                                </div>
                                <!-- Hidden input fields to store positions -->
                                <input type="hidden" name="positions[]" value="{{ $position }}">
                                @empty
                                <button style="background-color:#AD974F; color: white;" class="rounded-md text-sm p-[5px] dark:placeholder-gray-400 m-2 my-auto">
                                    <a href="{{ route('profile.edit') }}"><b>+</b> Add Position</a>
                                </button>
                                @endforelse
                            </div>

                            <div class="flex mt-4 space-x-4">
                                <!-- Save Changes button initially hidden -->
                                <button type="submit" id="saveChangesBtn" style="display: none; background-color: #202c34; color: white;" class="bg-[#202c34] text-white p-1 rounded-md text-sm w-36 mb-4">
                                    Save Changes
                                </button>

                                <!-- Cancel Changes button initially hidden -->
                                <button type="button" id="cancelChangesBtn" style="display: none; background-color: #ff4d4d; color: white;" class="bg-[#202c34] text-white p-1 rounded-md text-sm w-36 mb-4">
                                    Cancel Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="flex flex-row gap-6">
                    <div>
                        <h1 class="text-lg font-bold">Total Hours Tracker</h1>
                        <div class="mx-auto w-11/12 overflow-hidden md:w-3/5 h-22">
                            <canvas data-te-chart="doughnut" data-te-dataset-data='[
                                        {{ $totalRenderedHours }},
                                        {{ $remainingHours }}]' data-te-dataset-background-color='["#AD974F", "#1F2937"]'>
                            </canvas>
                        </div>
                    </div>

                    <div class="flex flex-col justify-end">
                        <p class="text-sm font-semibold">Hours Rendered: {{ $totalRenderedHours }}</p>
                        <p class="text-sm font-semibold">Hours Left: {{ $remainingHours }}</p>
                        <p class="text-sm font-semibold text-[#AD974F]">Needed Hours: {{ $neededHours }}</p>
                    </div>
                </div>
            </div>

            <!--  THIRD ROW -->
            <div class="grid lg:grid-cols-2 xs:grid-rows-2 xs:gap-10 gap-10">
                <div class="xs:row-span-1 bg-white p-8 shadow-md rounded-md h-48 flex">
                    <div class="flex flex-col gap-4">
                        <div>
                            <h1 class="text-lg font-semibold">Update Password</h1>
                        </div>
                        <div>
                            <p class="lg:text-lg text-sm xs:text-sm">Ensure your account is using a long, random password to stay secure.</p>
                        </div>
                        <div>
                            <button class="bg-[#AD974F] hover:bg-[#736023] text-white p-1 rounded-md text-sm w-36 mb-4"><a href="{{ route('password.edit') }}">Update Password</a></button>
                        </div>
                    </div>
                </div>

                <div class="xs:row-span-1 bg-white p-8 shadow-md rounded-md h-48 flex">
                    <div class="flex flex-col gap-4">
                        <div>
                            <h1 class="text-lg font-semibold">Update Profile</h1>
                        </div>
                        <div>
                            <p class="lg:text-lg text-sm xs:text-sm">Edit Profile to match into a company</p>
                        </div>
                        <div>
                            <button class="bg-[#AD974F] hover:bg-[#736023] text-white p-1 rounded-md text-sm w-36 mb-4"><a href="{{ route('profile.edit') }}">Edit Profile</a></button>


                        </div>
                    </div>
                </div>
            </div>

            <!--  END OF THIRD ROW -->

        </div>
        @endforeach
    </div>

    <script src="{{ asset('js/student/profile.js') }}"></script>

</body>

</html>