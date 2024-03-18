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

  <title>Company List</title>
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
        <a class="focus:shadow-outline mt-2 text-[#AD974F] font-bold rounded-lg bg-gray-700 px-4 py-2 text-sm  hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('coordinator_company-list') }}">Company List</a>
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

  <!-- Your Blade view file -->
  <!-- Your Blade view file -->
  <section class="bg-#f9fafb dark:bg-gray-900">
    <div class="w-full container mx-auto max-w-screen-xl mt-8  lg:px-12">
      <div class="min-h-[80vh] bg-white rounded-md border-0 shadow-md p-5 ">

        <!-- BACK BUTTON -->
        <button class="mb-8">
          <a href="{{ url()->previous() }}"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAMNJREFUSEvtlDEKwkAQRV8OIWiv4BlE8BaCteB1xFrwMArewcZe8BD6wYUtss5Mku2SMizv/fnZSUPlp6nMZxSYDUcqmgI74GhSswNegeBXYAEcgLNX4hEIfgPmwBNYAa+hBDn8AWwicIX4N8EEuP+SC74G3t7k6VxJILg6X34/bGd4aYIcHgncGrbtZXWBUletKNUyiMTag943yRJoml674BEkSfpV7IGL93p5BeLNgC1w8sKtTY5wimcjE3QSjgKztg/ExiAZuzHo1gAAAABJRU5ErkJggg==" /></a>
        </button>



        <form method="post" action="{{ route('coordinator.company_store') }}">
          @csrf
          @method('post')
          <div class="flex flex-col gap-6">
            <div class="flex flex-col">
              <label for="name" class="text-sm font-semibold">Name <span class="text-red-600">*</span></label>
              <input type="text" name="name" placeholder="Company's name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required />
            </div>

            <div class="flex flex-col">
              <label for="email" class="text-sm font-semibold">Email <span class="text-red-600">*</span></label>
              <input type="email" name="email" placeholder="Company's email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required />
            </div>

            <div class="flex flex-col">
              <label for="address" class="text-sm font-semibold">Address <span class="text-red-600">*</span></label>
              <input type="text" name="address" placeholder="Company's address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required />
            </div>

            <div class="flex flex-col">
              <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Description:</label>
              <textarea class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 h-40 resize-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" name="description"></textarea>
            </div>

            <div class="flex items-center space-x-4">
              <button type="submit" class="text-white bg-[#AD974F] hover:bg-[#736023] focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                Save
              </button>
            </div>
          </div>

        </form>
      </div>
  </section>
  </div>
</body>

</html>