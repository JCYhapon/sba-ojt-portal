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
                <a class="focus:shadow-outline mt-2 rounded-lg bg-transparent px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('coordinator_company-list') }}">Company List</a>
                <a class="focus:shadow-outline mt-2 rounded-lg bg-transparent px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('coordinator_student-list') }}">Student List</a>
                <a class="focus:shadow-outline mt-2 rounded-lg bg-transparent px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('coordinator_student-journal') }}">Student Journals</a>

                <div @click.away="open = false" class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="focus:shadow-outline mt-2 flex w-full flex-row items-center rounded-lg bg-transparent px-4 py-2 text-left text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4 md:inline md:w-auto">
                        <span>{{ Auth::user()->name }}</span>
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

    <div class="w-full container mx-auto max-w-screen-xl mt-8 p-12 h-auto overflow-x-auto ">
        <!--  FIRST ROW -->
        <div class="bg-white row-span-1 grid grid-cols-3 x p-8 shadow-md rounded-md h-48 py-12">
            @php
            $user = Auth::user();
            @endphp
            <div class="flex flex-col justify-between">
                <div class="flex flex-row gap-10">
                    <h1 class="text-3xl">{{ $user->name }}</h1>
                </div>
                <div>
                    <p class="text-lg capitalize"><span class="font-semibold">School ID:</span> {{ $user->schoolID }}</p>
                </div>
                <div>
                    <p class="text-lg capitalize"><span class="font-semibold">Handled Students:</span> {{ $user->major }}</p>
                </div>

            </div>
            <div class="flex items-end">
                <div>
                    <p class="text-lg"><span class="font-semibold">Email:</span> {{ $user->email }}</p>
                </div>
            </div>
        </div>

        {{-- 2nd Row --}}
        <div class="bg-white p-4 shadow-md rounded-md">
            <h1>Student Grades</h1>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">Student Name</th>
                            @for ($i = 1; $i <= 15; $i++) <th class="px-4 py-2 border">{{ $i }}</th>
                                @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        // Fetch all students corresponding to the schoolIDs of users, sorted by last name
                        $studentIDs = $users->pluck('schoolID')->flatten()->toArray();
                        $sortedStudents = \App\Models\Student::whereIn('studentID', $studentIDs)
                        ->orderBy('lastName', 'asc')
                        ->get();
                        @endphp
                        @foreach($sortedStudents as $student)
                        <tr>
                            <td class="px-4 py-2 border">{{ $student->lastName }} {{ $student->firstName }}</td>
                            @php
                            // Search the journal table using the schoolID
                            $journals = \App\Models\Journal::where('studentId', $student->studentID)->get();
                            @endphp
                            @for ($i = 1; $i <= 15; $i++) <td class="px-4 py-2 border">
                                @foreach($journals as $journal)
                                @if ($journal->journalNumber == $i)
                                {{ $journal->grade }}
                                @endif
                                @endforeach
                                </td>
                                @endfor
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <a href="{{ route('export.journal.grades') }}" class="btn btn-primary">Download Journal Grades</a>
        </div>
    </div>
</body>

</html>