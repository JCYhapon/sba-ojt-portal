<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{----alphinejs----}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

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

    <div class="w-full container mx-auto max-w-screen-xl mt-8  lg:px-12 px-2">
        <div class="min-h-[80vh] bg-white rounded-md border-0 shadow-md p-5 ">

            <!-- Back Button -->
            <button class="mb-8">
                <a href="{{ url()->previous() }}"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAMNJREFUSEvtlDEKwkAQRV8OIWiv4BlE8BaCteB1xFrwMArewcZe8BD6wYUtss5Mku2SMizv/fnZSUPlp6nMZxSYDUcqmgI74GhSswNegeBXYAEcgLNX4hEIfgPmwBNYAa+hBDn8AWwicIX4N8EEuP+SC74G3t7k6VxJILg6X34/bGd4aYIcHgncGrbtZXWBUletKNUyiMTag943yRJoml674BEkSfpV7IGL93p5BeLNgC1w8sKtTY5wimcjE3QSjgKztg/ExiAZuzHo1gAAAABJRU5ErkJggg==" /></a>
            </button>

            <form method="post" action="{{ route('coordinator.company_update', ['company' => $company->id]) }}">
                @csrf
                @method('put')
                <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                    <div class="sm:col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Name</label>
                        <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" name="name" placeholder="{{ $company->name }}" value="{{ $company->name }}" />
                    </div>

                    <div class="sm:col-span-2">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Email:</label>
                        <input type="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" name="email" placeholder="{{ $company->email }}" value="{{ $company->email }}" />
                    </div>

                    <div class="sm:col-span-2">
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Address:</label>
                        <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" name="address" placeholder="{{ $company->address }}" value="{{ $company->address }}" />
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Description:</label>
                        <textarea class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 h-40 resize-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" name="description" placeholder="{{ $company->description ?: 'Company Description' }}" required>{{ $company->description }}</textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Status:</label>
                        <select name="status" id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="" disabled {{ empty($company->status) ? 'selected' : '' }}></option>
                            <option value="1" {{ $company->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="2" {{ $company->status == 2 ? 'selected' : '' }}>For Renewal</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="workType" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Work Type Offered:</label>
                        <select name="workType" id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="" disabled {{ empty($company->workType) ? 'selected' : '' }}>Choose Work Type Offered</option>
                            <option value="1" {{ $company->workType == 1 ? 'selected' : '' }}>On Site</option>
                            <option value="2" {{ $company->workType == 2 ? 'selected' : '' }}>From Home</option>
                            <option value="3" {{ $company->workType == 3 ? 'selected' : '' }}>Hybrid</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <!-- Hidden Modal for Custom Position -->
                        <div id="customPositionModal" class="modal hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center">
                            <div class="modal-content bg-white p-6 rounded-lg shadow-lg">
                                <span class="close-modal absolute top-4 right-4 cursor-pointer">&times;</span>
                                <h2 class="text-lg font-semibold mb-4">Enter Custom Position</h2>
                                <input type="text" id="customPositionInput" class="border border-gray-300 rounded-md p-2 w-full mb-4" placeholder="Enter custom position...">
                                <input type="button" id="addCustomPositionBtn" class="flex items-center justify-center text-white font-medium rounded-lg text-lg px-3 py-1.5 bg-[#AD974F] hover:bg-gray-800 dark:bg-primary-600 dark:hover:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-opacity-50" value="Add Position">
                            </div>
                        </div>

                        <label for="position">Positions:</label>
                        <ul class="flex flex-wrap p-2.5 dark:border-gray-600 position-container items-center">
                            @php
                            $positions = $company->position;
                            $availablePositions = [
                            'Administration',
                            'Accountancy',
                            'Internal Auditing',
                            'Bookkeeping',
                            'Management Accounting',
                            'Financial Management',
                            'Human Resource Management',
                            'Marketing Management',
                            'Legal Management'
                            ];

                            // Remove positions that are already selected
                            if (is_array($positions)) {
                            $availablePositions = array_diff($availablePositions, $positions);
                            }
                            @endphp

                            @if(empty($positions))
                            <li style="background-color: #AD974F; color: white;" class="rounded-lg p-2.5 dark:placeholder-gray-400 m-2">No Positions Available</li>
                            @endif

                            @foreach($positions ?? [] as $position)
                            <div class="position-item flex items-center mt-2 mr-2">
                                <span style="background-color: #AD974F; color: white;" class="rounded-lg p-2.5 dark:placeholder-gray-400">{{ $position }}<input type="button" class="remove pl-2 pr-1 cursor-pointer" data-position="{{ $position }}" value="×"></input></span>
                            </div>
                            <!-- Hidden input fields to store positions -->
                            <input type="hidden" name="positions[]" value="{{ $position }}">
                            @endforeach

                            @if(empty($positions))
                            <li>
                                @endif

                                <select name="position" id="addPosition" class="bg-gray-50 border mt-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-[25vh] p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 mr-2">
                                    <option value="">Choose a position</option>
                                    @foreach($availablePositions as $availablePosition)
                                    <option value="{{ $availablePosition }}">{{ $availablePosition }}</option>
                                    @endforeach
                                    <option value="custom">Other (Please specify)</option>
                                </select>

                                @if(empty($positions))
                            </li>
                            @endif
                        </ul>
                    </div>


                    <div class="flex items-center space-x-4">
                        <button type="submit" class="text-white bg-[#AD974F] hover:bg-[#736023] focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            Update Company
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

<script src="{{ asset('js/coordinator/company_list-edit.js') }}">
</script>

</html>