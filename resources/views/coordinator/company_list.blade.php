<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{----alphinejs----}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <!-- Tailwindcss CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/background.css') }}">

    <style>
        th.asc::after {
            content: " ↑";
        }

        th.desc::after {
            content: " ↓";
        }
    </style>

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
                <a class="focus:shadow-outline mt-2 rounded-lg text-[#AD974F] font-bold bg-gray-700 px-4 py-2 text-sm  hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('coordinator_company-list') }}">Company List</a>
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
            <!-- Display Success Message -->
            @if(session()->has('success'))
            <div class="bg-green-200 text-green-800 p-4 mb-4">
                {{ session('success') }}
            </div>
            @endif

            <!-- Add New Student Button -->
            <div class="mb-4 w-full flex justify-between lg:flex-row md:flex-row   flex-col gap-2">
                <div class="lg:w-2/4 md:w-2/4">
                    <form class="flex items-center">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search" required="">
                        </div>
                    </form>
                </div>

                <div class="flex lg:flex-row lg:gap-4 gap-2 justify-center">
                    <div class="flex align-middle justify-center">
                        <a href="{{ route('company_bulk_list') }}" class="bg-[#AD974F] hover:bg-[#736023] text-white px-4 py-2 rounded-xl  text-sm">
                            <button type="button" id="createProductModalButton" data-modal-target="createProductModal" data-modal-toggle="createProductModal" class="flex items-center justify-center text-white font-medium rounded-lg text-sm px-2 py-0 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                </svg>
                                Bulk Upload
                            </button>
                        </a>
                    </div>

                    <div class="flex align-middle justify-center">
                        <a href="{{ route('coordinator.company_create') }}" data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="bg-[#AD974F] hover:bg-[#736023] text-white px-4 py-2 rounded-xl  text-sm">
                            <button type="button" id="createProductModalButton" data-modal-target="createProductModal" data-modal-toggle="createProductModal" class="flex items-center justify-center text-white   font-medium rounded-lg text-sm px-2 py-0 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                </svg>
                                New Company
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex flex-col justify-between min-h-[70vh] ">

                <!-- Students Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-4">Company Name</th>
                                <th scope="col" class="px-4 py-4">Email</th>
                                <th scope="col" class="px-4 py-4">Address</th>
                                <th scope="col" class="px-4 py-4">Status</th>
                                <th scope="col" class="px-4 py-4">Position</th>
                                <th scope="col" class="px-4 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companies as $company)
                            <tr>
                                <td onclick="window.location='{{ route('coordinator_company_info', ['id' => $company->id]) }}'" class="py-2 px-4 border-b cursor-pointer hover:text-black hover:font-semibold">{{ $company->name }}</td>
                                <td onclick="window.location='{{ route('coordinator_company_info', ['id' => $company->id]) }}'" class="py-2 px-4 border-b">{{ $company->email }}</td>
                                <td onclick="window.location='{{ route('coordinator_company_info', ['id' => $company->id]) }}'" class="py-2 px-4 border-b">{{ $company->address }}</td>
                                <td onclick="window.location='{{ route('coordinator_company_info', ['id' => $company->id]) }}'" class="py-2 px-4 border-b">
                                    {{ $company->status === 1 ? 'Active' : 'For Renewal' }}
                                </td>

                                <td onclick="window.location='{{ route('coordinator_company_info', ['id' => $company->id]) }}'" class="py-2 px-4 border-b">
                                    @if ($company->position)
                                    {{ implode(', ', $company->position) }}
                                    @else
                                    No Available Position
                                    @endif
                                </td>

                                <td class="py-2 px-4 border-b ">
                                    <!-- Edit Button -->
                                    <a class="btn btn-primary mb-2 lg:mb-0 lg:mr-2" href="{{ route('coordinator.company_edit', $company->id) }}">
                                        <box-icon name='edit' color='#AD974F'></box-icon>
                                    </a>

                                    <!-- Toggle Status Button -->
                                    <div x-data="{ isOpen: false }">
                                        <!-- Button trigger modal -->
                                        <button @click="isOpen = true" type="button" class="btn btn-warning">
                                            <box-icon name='message-alt-x' color='#AD974F'></box-icon>
                                        </button>

                                        <div x-show="isOpen" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
                                            <div class="bg-white p-8 rounded shadow-md">
                                                <h3 class="text-lg font-semibold mb-4">Confirmation</h3>
                                                @if($company->status === 1)
                                                <p>Are you sure you want to set the status to For Renewal?</p>
                                                @elseif($company->status === 2)
                                                <p>Are you sure you want to set the status to Active?</p>
                                                @endif
                                                <div class="mt-4 flex justify-center space-x-4">
                                                    <button @click="isOpen = false" class="btn btn-secondary text-lg px-3 py-1.5">Cancel</button>
                                                    <form id="confirmationForm" action="{{ route('coordinator.company_toggle_status', $company->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="flex items-center justify-center text-white font-medium rounded-lg text-lg px-3 py-1.5 bg-[#AD974F] hover:bg-gray-800 dark:bg-primary-600 dark:hover:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-opacity-50">
                                                            Proceed
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {!! $companies->links() !!}
                </div>

                <!-- FOR FILTER -->
                <script src="{{ asset('js/coordinator.js') }}">
                </script>

            </div>
        </div>
    </div>
</body>

</html>