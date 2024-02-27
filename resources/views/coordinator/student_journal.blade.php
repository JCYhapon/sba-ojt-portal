<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  {{----alphinejs----}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.js"></script>

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/background.css') }}">

  <!-- Tailwindcss CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    th.asc::after {
      content: " ↑";
    }

    th.desc::after {
      content: " ↓";
    }
  </style>

  <title>Student Journals</title>
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
        <a class="focus:shadow-outline mt-2 text-[#AD974F] font-bold rounded-lg bg-gray-700 px-4 py-2 text-sm  hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('coordinator_student-journal') }}">Student Journals</a>

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

  <div class="w-full container mx-auto max-w-screen-xl mt-8  lg:px-12">
    <div class="min-h-[80vh] bg-white rounded-md border-0 shadow-md p-5 overflow-auto">

      <div class="container overflow-x-auto">
        {{-- Left-aligned h1 --}}

        {{-- Loop through journals --}}

        <!-- SEARCH AND FILTER -->
        <div class="flex gap-6 w-full">
          <!-- SEARCH -->
          <label for="simple-search" class="sr-only">Search</label>
          <div class="relative w-[40%]">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
              </svg>
            </div>
            <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search" required="">
          </div>

          <!-- FILTERING -->

          <div class="flex flex-row gap-4">
            <div>
              <select id="dropdown" name="dropdown" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  block w-[100%] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white ">
                <option value="option1">All Section</option>
                <option value="option2">MT - 102</option>
                <option value="option3">MT - 103</option>
              </select>
            </div>

            <div>
              <form method="GET" action="{{ route('journals.index') }}" class="flex gap-4">

                <select id="dropdown-status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-[100%] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                  <option value="">All</option>
                  <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                  <option value="graded" {{ request('status') == 'graded' ? 'selected' : '' }}>Graded</option>
                </select>
                <div>
                  <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">Filter</button>
                </div>

              </form>
            </div>



          </div>
        </div>

        <div class="flex flex-col flex-wrap gap-2 mt-4">

          @foreach($journals as $journal)
          <a href="{{ route('student.journal.grade', ['journal' => $journal->journalID]) }}">
            @php
            $student = \App\Models\Student::where('studentID', $journal->studentID)->first();
            @endphp

            @if($student)

            <div class="border rounded-md p-[20px]">
              <div class="flex items-center justify-between">
                <h2 class="card-title text-lg font-bold hover:underline">Journal {{ $journal->journalNumber }}</h2>
                <div class="flex gap-4 items-center justify-evenly">
                  @if($journal->status != 1 && $journal->status != 3)
                  <a href="{{ route('mark.unread', ['journalID' => $journal->journalID]) }}" class="bg-gray-800 text-white  text-center p-[5px] rounded-md text-[13px]">Mark as Unread</a>
                  @endif
                  <p class="bg-gray-800 text-white  text-center p-[5px] rounded-md text-[13px]">
                    @if($journal->status == 1)
                    Unread
                    @elseif($journal->status == 2)
                    Seen
                    @elseif($journal->status == 3)
                    Graded
                    @endif
                  </p>
                  @if($journal->status != 1 && $journal->status != 3)
                  @endif
                </div>
              </div>
              <div class="flex flex-col gap-4">
                <div class="flex flex-row gap-4">
                  <h1 class="card-title"><span class="font-semibold">Name: </span>{{ $student->firstName }} {{ $student->lastName }}</h1>
                  <h1 class="card-title"><span class="font-semibold">Section: </span>{{ $student->section }}</h1>
                  <p class="card-text"><span class="font-semibold">Score: </span>{{ $journal->grade ?? 'Not graded yet' }}</p>
                </div>
                <div>
                  <p class="overflow-x-auto ">{{ $journal->reflection }}</p>
                </div>
              </div>
              @endif
            </div>
          </a>
          @endforeach
        </div>
      </div>
    </div>
  </div>



  <!-- FOR FILTER -->
  <script src="{{ asset('js/journal.js') }}">
  </script>



</body>

</html>