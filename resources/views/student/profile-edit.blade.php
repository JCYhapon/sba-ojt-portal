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
    <link rel="stylesheet" href="{{ asset('css/background.css') }}">

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

    <div class="w-full container mx-auto max-w-screen-xl mt-8 p-12 h-auto">
        @foreach (explode(',',Auth::user()->schoolID) as $studentID)
        @php
        $student = \App\Models\Student::where('studentID', $studentID)->first();
        @endphp
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex flex-col gap-4 h-auto">
                <!--  FIRST ROW -->
                <div class="bg-white row-span-1 grid grid-cols-3 p-8 shadow-md rounded-md h-[15rem] py-12">
                    <div class="flex flex-col justify-between">
                        <h1 class="text-3xl">{{ $student->lastName }} {{ $student->firstName }}</h1>

                        <div class="form-group">
                            <label for="profilePicture">Profile Picture</label>
                            <input type="file" name="profilePicture" accept="image/*">
                        </div>

                        <p class="text-lg capitalize"><span class="font-semibold">Section:</span> {{ $student->section }}</p>
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
                <div class="row-span-1 bg-white p-8 shadow-md rounded-md  h-auto">
                    <div class="flex flex-col justify-between gap-2">
                        @php
                        $company = \App\Models\Company::find($student->hiredCompany);
                        @endphp
                        <div>
                            @if($student->hiredCompany !== null)
                            <p class="text-lg font-semibold">Company: {{ $company->name }}</p>
                            @else
                            <ul class="flex flex-wrap p-2.5 dark:border-gray-600">
                                @php
                                $company = \App\Models\Company::find($student->hiredCompany);
                                @endphp

                                <li class="flex items-center"> <!-- Added flex and items-center -->
                                    <p class="text-lg font-semibold">Company:</p>
                                    <select name="hiredCompany" class="text-lg font-semibold ml-2"> <!-- Added ml-2 for margin -->
                                        <option value="">Choose a Hired Company</option>
                                        @php
                                        $companies = \App\Models\Company::all();
                                        @endphp
                                        @foreach($companies as $company)
                                        <option value="{{ $company->id }}" @if($student->hiredCompany == $company->id) selected @endif>{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </li>
                            </ul>
                            @endif
                        </div>

                        {{-- Display only If hired --}}
                        <div class="flex items-center gap-4">
                            @if($student->hiredCompany !== null)
                            <label for="supervisor text-center " class="text-lg font-semibold">Supervisor:</label>
                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-[40%] p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" type="text" id="supervisor" name="supervisor" placeholder="{{$student->supervisor}}">
                            @endif
                        </div>

                        <!-- Hidden Modal for Custom Position -->
                        <div id="customPositionModal" class="modal hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center">
                            <div class="modal-content bg-white p-6 rounded-lg shadow-lg">
                                <span class="close-modal absolute top-4 right-4 cursor-pointer">&times;</span>
                                <h2 class="text-lg font-semibold mb-4">Enter Custom Position</h2>
                                <input type="text" id="customPositionInput" class="border border-gray-300 rounded-md p-2 w-full mb-4" placeholder="Enter custom position...">
                                <input type="button" id="addCustomPositionBtn" class="flex items-center justify-center text-white font-medium rounded-lg text-lg px-3 py-1.5 bg-[#AD974F] hover:bg-gray-800 dark:bg-primary-600 dark:hover:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-opacity-50" value="Add Position">
                            </div>
                        </div>

                        <!-- Add input fields for position -->
                        <div class="sm:col-span-2">
                            <label for="position" class="text-lg font-semibold">Positions:</label>
                            <ul class="flex flex-wrap p-2.5 dark:border-gray-600 position-container items-center">
                                @php
                                $positions = $student->position;

                                $availablePositions = [
                                'Administration',
                                'Accountancy',
                                'Internal Auditing',
                                'Bookkeeping',
                                'Management Accounting',
                                'Financial Management',
                                'Human Resource Management',
                                'Marketing Managements ',
                                'Legal Managements'
                                ];

                                // Remove positions that are already selected
                                if (is_array($positions)) {
                                $availablePositions = array_diff($availablePositions, $positions);
                                }
                                @endphp

                                @if(empty($positions))
                                <div>
                                    <li style="background-color: #202c34; color: white;" class="bg-[#202c34] text-white p-1 rounded-md text-sm w-38 mb-4 text-center">No Positions Available</li>
                                    @endif

                                    @foreach($positions ?? [] as $position)
                                    <div class="position-item flex items-center mt-2 mr-2">
                                        <span style="background-color: #202c34; color: white;" class="rounded-lg p-2.5 dark:placeholder-gray-400">{{ $position }} <input type="button" class="remove pl-2 pr-1" data-position="{{ $position }}" value="×"></input> </span>
                                    </div>
                                    <!-- Hidden input fields to store positions -->
                                    <input type="hidden" name="positions[]" value="{{ $position }}">
                                    @endforeach

                                    @if(empty($positions))
                                    <li>
                                        @endif

                                        <select name="position" id="addPosition" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-[25vh] p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 mr-2">
                                            <option value="">Choose a position</option>
                                            @foreach($availablePositions as $availablePosition)
                                            <option value="{{ $availablePosition }}">{{ $availablePosition }}</option>
                                            @endforeach
                                            <option value="custom">Other (Please specify)</option> <!-- Add this option for custom position -->
                                        </select>

                                        @if(empty($positions))
                                    </li>
                                </div>
                                @endif
                            </ul>
                        </div>


                        {{-- Preferred Work Type --}}
                        <div class="flex flex-col gap-2">
                            <label for="workType">Preferred Work Type: </label>
                            <div class="flex items-center">
                                @if($student->workType !== null)
                                <span style="background-color: #202c34; color: white;" class="rounded-md p-2.5 dark:placeholder-gray-400 m-2.5">
                                    @if ($student->workType === 1)
                                    On Site
                                    @elseif ($student->workType === 2)
                                    Work From home
                                    @else
                                    Hybrid
                                    @endif
                                </span>
                                @endif

                                <select name="workType" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-[30vh] p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                    @if($student->workType !== null)
                                    <option value="{{ $student->workType }}">Choose New Work Type</option>
                                    <option value="1">On Site</option>
                                    <option value="2">Work from Home</option>
                                    <option value="3">Hybrid</option>
                                    @else
                                    <option value="">Choose Work Type</option>
                                    <option value="1">On Site</option>
                                    <option value="2">Work from Home</option>
                                    <option value="3">Hybrid</option>
                                    @endif
                                </select>
                            </div>

                        </div>

                        {{-- Submit Form --}}
                        <div class="flex align-start justify-end mb-4">
                            <a class="bg-gray-800 text-white px-4 py-2 rounded-xl hover:bg-gray-600 text-sm">
                                <button type="submit" class="flex items-center justify-center text-white   font-medium rounded-lg text-sm px-2 py-0 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                                    <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                    </svg>
                                    Update Profile
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endforeach
    </div>

    <script src="{{ asset('js/student/profile-edit.js') }}"></script>

</body>

</html>