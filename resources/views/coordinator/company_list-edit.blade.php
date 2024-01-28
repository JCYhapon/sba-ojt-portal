<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  {{----alphinejs----}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.js"></script>
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  @vite('resources/css/app.css')
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

    <section class="bg-#f9fafb dark:bg-gray-900">
        <div class="max-w-2xl rounded-md shadow-md container px-4 mt-12 py-4 mx-auto lg:py-12 bg-white">


        <h2 class="mb-10 text-xl font-bold text-gray-900 dark:text-white">Update company</h2>

        <form method="post" action="{{ route('coordinator.company_update', ['company' => $company->id]) }}">
            @csrf
            @method('put')
            <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
            <div class="sm:col-span-2">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" name="name" placeholder="{{ $company->name }}" value="{{ $company->name }}" />
            </div>

            <div class="sm:col-span-2">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email:</label>
                <input type="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" name="email" placeholder="{{ $company->email }}" value="{{ $company->email }}" />
            </div>

            <div class="sm:col-span-2">
                <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address:</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" name="address" placeholder="{{ $company->address }}" value="{{ $company->address }}" />
            </div>

            <div class="sm:col-span-2">
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status:</label>
                <select name="status" id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option value="" disabled {{ empty($company->status) ? 'selected' : '' }}></option>
                <option value="1" {{ $company->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="2" {{ $company->status == 2 ? 'selected' : '' }}>For Renewal</option>
                </select>
            </div>

            <div class="sm:col-span-2">
                <label for="position" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Positions:</label>
                <ul class="flex flex-wrap p-2.5 dark:border-gray-600">
                    @if (!empty($company->position) && is_array($company->position) && count($company->position) > 0)
                        @foreach($company->position as $position)
                            <li style="background-color: #202c34; color: white;" class="rounded-lg p-2.5 dark:placeholder-gray-400 m-2">{{ $position }}</li>
                        @endforeach
                        <li>
                            <select name="position" class="rounded-lg p-2.5 dark:placeholder-gray-400 m-2">
                                <option value="">Choose a position</option>
                                <option value="Administration">Administration </option>
                                <option value="Accountancy">Accountancy</option>
                                <option value="Internal Auditing">Internal Auditing</option>
                                <option value="Bookkeeping">Bookkeeping</option>
                                <option value="Management Accounting">Management Accounting</option>
                                <option value="Financial Management">Financial Management</option>
                                <option value="Human Resource Management">Human Resource Management</option>
                                <option value="Marketing Managements ">Marketing Managements</option>
                                <option value="Legal Managements">Legal  Managements</option>
                            </select>
                        </li>
                    @else
                        <li style="background-color: #202c34; color: white;" class="rounded-lg p-2.5 dark:placeholder-gray-400 m-2">No Positions Available</li>
                        <li>
                            <select name="position" class="rounded-lg p-2.5 dark:placeholder-gray-400 m-2">
                                <option value="">Choose a position</option>
                                <option value="Administration">Administration </option>
                                <option value="Accountancy">Accountancy</option>
                                <option value="Internal Auditing">Internal Auditing</option>
                                <option value="Bookkeeping">Bookkeeping</option>
                                <option value="Management Accounting">Management Accounting</option>
                                <option value="Financial Management">Financial Management</option>
                                <option value="Human Resource Management">Human Resource Management</option>
                                <option value="Marketing Managements ">Marketing Managements</option>
                                <option value="Legal Managements">Legal  Managements</option>
                            </select>
                        </li>
                    @endif
                </ul>
            </div>


            <div class="sm:col-span-2">
                <label for="hiredStudents" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hired Students:</label>
                <ul class="flex flex-wrap p-2.5 dark:border-gray-600">
                    @if (!empty($company->hiredStudents) && is_array($company->hiredStudents) && count($company->hiredStudents) > 0)
                        @foreach ($company->hiredStudents as $studentID)
                            @php
                                $student = \App\Models\Student::where('studentID', $studentID)->first();
                            @endphp
                             <li style="background-color: #202c34; color: white;" class="rounded-lg p-2.5 dark:placeholder-gray-400 m-2">
                                @if ($student)
                                    {{ $student->firstName }} {{ $student->lastName }}
                                @endif
                            </li>
                        @endforeach

                        <li>
                            <select name="hiredStudents" class="rounded-lg p-2.5 dark:placeholder-gray-400 m-2">
                                <option value="">Choose a Hired Students</option>
                                @foreach($users as $user)
                                    @foreach (explode(',', $user->schoolID) as $studentID)
                                        @php
                                            $student = \App\Models\Student::where('studentID', $studentID)->first();
                                        @endphp
                                        <option value="{{ $student->studentID }}">{{ $student->firstName }} {{ $student->lastName }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </li>
                    @else
                        <li style="background-color: #202c34; color: white;" class="rounded-lg p-2.5 dark:placeholder-gray-400 m-2">No Hired Students</li>
                        <li>
                            <select name="hiredStudents" class="rounded-lg p-2.5 dark:placeholder-gray-400 m-2">
                                <option value="">Choose a Hired Students</option>
                                @foreach($users as $user)
                                    @foreach (explode(',', $user->schoolID) as $studentID)
                                        @php
                                            $student = \App\Models\Student::where('studentID', $studentID)->first();
                                        @endphp
                                        <option value="{{ $student->studentID }}">{{ $student->firstName }} {{ $student->lastName }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </li>
                    @endif
                </ul>
            </div>


            <div class="flex items-center space-x-4">
                <button type="submit" class="text-white bg-indigo-500  hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                Update company
                </button>
            </div>
            </div>
        </form>
    </section>


</body>

</html>
