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

    <title>Student List</title>
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
                <a class="focus:shadow-outline mt-2 rounded-lg bg-gray-700 px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('coordinator_student-list') }}">Student List</a>
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
            <h2 class="mb-10 text-xl font-bold text-gray-900 dark:text-white">Update student</h2>
            <form method="post" action="{{ route('coordinator_student-list.update',['students' => $students]) }}">
                @csrf
                @method('put')
                <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                    {{-- Student Table FirstName --}}
                    <div class="sm:col-span-2">
                        <label for="firstName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                        <input type="text" name="firstName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $students->firstName }}" required>
                    </div>
                    {{-- Student Table LastName --}}
                    <div class="sm:col-span-2">
                        <label for="lastName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                        <input type="text" name="lastName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $students->lastName }}" required>
                    </div>
                    {{-- Student Table Email --}}
                    <div class="w-full">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $students->email }}" required>
                    </div>
                    {{-- Student Table Major --}}
                    <div class="w-full">
                        <label for="major" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Major</label>
                        <select name="major" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                            <option value="Accounting" {{ $students->major === 'Accounting' ? 'selected' : '' }}>Accounting</option>
                            <option value="Management" {{ $students->major === 'Management' ? 'selected' : '' }}>Management</option>
                        </select>
                    </div>
                    {{-- Student Table Section --}}
                    <div class="w-full">
                        <label for="section" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Section</label>
                        <select name="section" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                            <option value="AT-101" {{ $students->section === 'AT-101' ? 'selected' : '' }}>AT-101</option>
                            <option value="MT-101" {{ $students->section === 'MT-101' ? 'selected' : '' }}>MT-101</option>
                        </select>
                    </div>

                    {{-- Student Table Stats --}}
                    <div class="w-full">
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                        <select name="status" id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="" disabled {{ empty($students->status) ? 'selected' : '' }}></option>
                            <option value="1" {{ $students->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="2" {{ $students->status == 2 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    {{-- Student Table Matched Company --}}
                    <div class="w-full">
                        <label for="matchedCompany" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Matched Company</label>
                        <ul class="flex flex-wrap p-2.5 dark:border-gray-600">
                            @if(count($students->matchedCompany) > 0)
                            @foreach($students->matchedCompany as $matchedCompany)
                            @php
                            $company = \App\Models\Company::where('id', $matchedCompany)->first();
                            @endphp
                            <li style="background-color: #202c34; color: white;" class="rounded-lg p-2.5 dark:placeholder-gray-400 m-2">{{ $company->name }}</li>
                            @endforeach
                            @else
                            <li style="background-color: #202c34; color: white;" class="rounded-lg p-2.5 dark:placeholder-gray-400 m-2">No Matched Company</li>
                            @endif

                            <li>
                                <select name="matchedCompany" class="rounded-lg p-2.5 dark:placeholder-gray-400 w-full">
                                    <option value="">Choose a Matched Company</option>
                                    @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </li>
                        </ul>
                    </div>




                    {{-- Student Table Hired Company --}}
                    <div class="w-full">
                        <label for="hiredCompany" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hired Company</label>
                        <ul class="flex flex-wrap p-2.5 dark:border-gray-600">
                            @php
                            $company = \App\Models\Company::find($students->hiredCompany);
                            @endphp

                            @if ($students->hiredCompany && $company)
                            <li style="background-color: #202c34; color: white;" class="rounded-lg p-2.5 dark:placeholder-gray-400 m-2">{{ $company->name }}</li>
                            @else
                            <li style="background-color: #202c34; color: white;" class="rounded-lg p-2.5 dark:placeholder-gray-400 m-2">Not Yet Hired</li>
                            @endif

                            <li>
                                <select name="hiredCompany" class="rounded-lg p-2.5 dark:placeholder-gray-400 w-full">
                                    <option value="">Choose a Hired Company</option>
                                    @foreach($companies as $company)
                                    <option value="{{ $company->id }}" @if($students->hiredCompany == $company->id) selected @endif>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </li>
                        </ul>
                    </div>



                    {{-- User Table Password --}}
                    <div class="w-full">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    </div>

                    <div class="w-full">

                    </div>

                    <div class="flex items-center space-x-4">
                        <button type="submit" class="text-white bg-indigo-500  hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            Update student
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

</body>

</html>