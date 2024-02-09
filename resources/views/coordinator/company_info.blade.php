<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{----alphinejs----}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.js"></script>
    @vite('resources/css/app.css')

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/background.css') }}">

    <title>Company List</title>
</head>

<body>

    <!-- CODE FOR NAVBAR -->
    <div class="w-full bg-gray-800 text-gray-200">
        <div x-data="{ open: false }" class="mx-auto flex max-w-screen-xl flex-col px-4 md:flex-row md:items-center md:justify-between md:px-6 lg:px-8">
            <div class="flex flex-row items-center justify-between p-4">
                <a href="#" class="focus:shadow-outline rounded-lg text-lg font-semibold uppercase tracking-widest text-white focus:outline-none">SBA-OJT Portal</a>
                <button class="focus:shadow-outline rounded-lg focus:outline-none md:hidden" @click="open = !open">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="h-6 w-6">
                        <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <nav :class="{'flex': open, 'hidden': !open}" class="hidden flex-grow flex-col pb-4 md:flex md:flex-row md:justify-end md:pb-0">
                <a class="focus:shadow-outline mt-2 rounded-lg bg-transparent px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0" href="{{ route('coordinator') }}">Dashboard</a>
                <a class="focus:shadow-outline mt-2 rounded-lg bg-gray-700 px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('coordinator_company-list') }}">Company List</a>
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

                            <a class="" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <!-- END OF NAVBAR -->

    <div class="w-full container mx-auto max-w-screen-xl mt-8 px-12">
        <div class="min-h-80vh bg-white rounded-md border-0 shadow-md p-5 ">

            <div class="">

                <!-- Back Button -->
                <div class="mb-8">
                    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                </div>

                <h1 class="lg:text-2xl text-xl font-bold mb-4">{{ $companies->name }} Information</h1>

                <!-- Display Success Message -->
                @if(session()->has('success'))
                <div class="bg-green-200 text-green-800 p-4 mb-4">
                    {{ session('success') }}
                </div>
                @endif


            </div>

            <!-- coordinator_company_info.blade.php -->

            <table class=" ">
                <tr class="flex gap-8">
                    <td>Email:</td>
                    <td>{{ $companies->email }}</td>
                </tr>
                <tr class="flex gap-3">
                    <td>Address:</td>
                    <td>{{ $companies->address }}</td>
                </tr>
                <tr class="flex gap-6">
                    <td>Status:</td>
                    <td>
                        @if($companies->status == 1)
                        Active
                        @elseif($companies->status == 2)
                        For Renewal
                        @endif
                    </td>
                </tr>
                <tr class="flex gap-2">
                    <td>Position:</td>
                    <td>
                        @if ($companies->position)
                        <ul class="flex flex-wrap  dark:border-gray-600">
                            @foreach($companies->position as $position)
                            <li style="background-color: #202c34; color: white;" class="rounded-md text-sm p-[2px] dark:placeholder-gray-400 m-2">{{ $position }}</li>
                            @endforeach
                        </ul>
                        @else
                        No Available Position
                        @endif
                    </td>
                </tr>
                {{-- <tr>
            <td>Matched Students:</td>
            
                <table class="w-full">
                    <tr>
                        <th class="px-4 py-4">Hired Students</th>
                        <th class="px-4 py-4">Section & Major</th>
                        <th class="px-4 py-4">Email</th>
                    </tr>
                    @if (!empty($companies->hiredStudents) && is_array($companies->hiredStudents) && count($companies->hiredStudents) > 0)
                        @foreach ($companies->hiredStudents as $studentID)
                            @php
                                $student = \App\Models\Students::where('studentID', $studentID)->first();
                            @endphp
                            <tr>
                                <td>
                                    @if ($student)
                                        {{ $student->firstName }} {{ $student->lastName }}
                @endif
                </td>

                <td>
                    @if ($student)
                    {{ $student->section }} {{ $student->major }}
                    @endif
                </td>

                <td>
                    @if ($student)
                    {{ $student->email }}
                    @endif
                </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="3">No hired students</td>
                </tr>
                @endif
            </table>


            </tr> --}}
            <tr>


                </td>
            </tr>
            </table>

            <!-- HIRED STUDENTS -->

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-6 ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-4">Hired Students</th>
                            <th class="px-4 py-4">Section & Major</th>
                            <th class="px-4 py-4">Email</th>
                        </tr>
                    </thead>

                    @if (!empty($companies->hiredStudents) && is_array($companies->hiredStudents) && count($companies->hiredStudents) > 0)
                    @foreach ($companies->hiredStudents as $studentID)
                    @php
                    $student = \App\Models\Student::where('studentID', $studentID)->first();
                    @endphp
                    <tr>
                        <td class="py-2 px-4 border-b">
                            @if ($student)
                            {{ $student->firstName }} {{ $student->lastName }}
                            @endif
                        </td>

                        <td class="py-2 px-4 border-b">
                            @if ($student)
                            {{ $student->section }} {{ $student->major }}
                            @endif
                        </td>

                        <td class="py-2 px-4 border-b">
                            @if ($student)
                            {{ $student->email }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="3">No hired students</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

</body>

</html>