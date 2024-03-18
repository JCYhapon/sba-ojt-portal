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

  <title>Student Journals</title>
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
        <a class="focus:shadow-outline mt-2 rounded-lg bg-transparent px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0" href="{{ route('coordinator') }}">Dashboard</a>
        <a class="focus:shadow-outline mt-2  rounded-lg bg-transparent px-4 py-2 text-sm  hover:bg-gray-200 hover:text-gray-900 font-semibold focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('coordinator_company-list') }}">Company List</a>
        <a class="focus:shadow-outline mt-2 rounded-lg  px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('coordinator_student-list') }}">Student List</a>
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
  <!-- END OF NAVBAR -->

  <div class="w-full container mx-auto max-w-screen-xl mt-8  lg:px-12">
    <div class="min-h-80vh bg-white rounded-md border-0 shadow-md p-5 ">
      <div class="container mt-5">

        <button class="mb-8">
          <a href="{{ url()->previous() }}"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAMNJREFUSEvtlDEKwkAQRV8OIWiv4BlE8BaCteB1xFrwMArewcZe8BD6wYUtss5Mku2SMizv/fnZSUPlp6nMZxSYDUcqmgI74GhSswNegeBXYAEcgLNX4hEIfgPmwBNYAa+hBDn8AWwicIX4N8EEuP+SC74G3t7k6VxJILg6X34/bGd4aYIcHgncGrbtZXWBUletKNUyiMTag943yRJoml674BEkSfpV7IGL93p5BeLNgC1w8sKtTY5wimcjE3QSjgKztg/ExiAZuzHo1gAAAABJRU5ErkJggg==" /></a>
        </button>
        <br>


        <form method="POST" action="{{ route('grade.journal', ['journalID' => $journal->journalID]) }}">
          @csrf
          @method('POST')

          <div class="flex flex-col gap-4 ">
            <div class="form-group overflow-x-auto">
              <label for="created_at" class="font-mono text-sm font-semibold">Date Submitted: </label>
              {{ \Carbon\Carbon::parse($journal->created_at)->format('M j, Y') }}</ </div>

              <div class="flex flex-row gap-[5em]">
                <div class="form-group">
                  <label for="studentID" class="font-mono text-sm font-semibold">Student Number: </label>
                  {{ $journal->studentID }}
                </div>

                <div class="form-group">
                  <label for="hoursRendered" class="font-mono text-sm font-semibold">Weekly Hours Rendered: </label>
                  {{ $journal->hoursRendered }}
                </div>

                <div class="flex gap-8">
                  <div class="flex gap-4">
                    <label for="" class="font-mono text-sm font-semibold">Student Signature:</label>
                    <img src="/{{ $journal->studentSignature }}" class="clickable-image rounded cursor-pointer transition duration-300 hover:opacity-70" style="max-width:100px;" data-toggle="modal" data-target="#imageModal">

                    <div class="flex gap-4">
                      <label for="" class="font-mono text-sm font-semibold">Documentation:</label>
                      <img src="/{{ $journal->supervisorSignature }}" class="clickable-image rounded cursor-pointer transition duration-300 hover:opacity-70" style="max-width:100px;" data-toggle="modal" data-target="#imageModal">
                    </div>
                  </div>

                  <!-- Image Modal -->
                  <div class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center hidden">
                    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

                    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

                      <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
                        <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                          <path d="M18 1.5L16.5 0 9 7.5 1.5 0 0 1.5 7.5 9 0 16.5 1.5 18 9 10.5 16.5 18 18 16.5 10.5 9z" />
                        </svg>
                      </div>

                      <!-- Modal content -->
                      <img src="" class="modal-content p-4" id="modalImage">
                    </div>
                  </div>
                </div>
              </div>


              <div class="form-group flex flex-col">
                <label for="reflection" class="font-mono text-sm font-semibold">Reflection</label>
                <textarea name="" id="" cols="30" rows="10" class="mt-5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" readonly> {{ $journal->reflection }}</textarea>
              </div>

              <div class="form-group">
                <textarea name="comments" class="mt-5 form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Coordinators comment....">{{ $journal->comments }}</textarea>
              </div>

              <div class="form-group flex items-center gap-4 mt-2">
                <label for="grade" class="font-mono text-sm font-semibold">Grade:</label>
                <input type="number" name="grade" class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-[8%] p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $journal->grade }}" min="0" max="30">
              </div>

              <div class="flex align-middle justify-center">
                <a class="bg-[#AD974F] hover:bg-[#736023] text-white px-4 py-2 rounded-xl  text-sm">
                  <button type="submit" id="createProductModalButton" data-modal-target="createProductModal" data-modal-toggle="createProductModal" class="flex items-center justify-center text-white   font-medium rounded-lg text-sm px-2 py-0 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                    Update
                  </button>
                </a>
              </div>
        </form>
      </div>

    </div>
  </div>

  <script src="{{ asset('js/coordinator/student_journal-grade.js') }}">
  </script>

</body>

</html>