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

    <!-- FLOWBITE CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>

    <title>Journal</title>
</head>

<body>

    <!-- CODE FOR NAVBAR -->
    <div class="w-full bg-gray-800 text-gray-200">
        <div x-data="{ open: false }" class="mx-auto flex max-w-screen-xl flex-col px-4 md:flex-row md:items-center md:justify-between md:px-6 lg:px-8">
            <div class="flex flex-row items-center justify-between p-4">
                <a href="#" class="focus:shadow-outline rounded-lg text-lg font-semibold uppercase tracking-widest text-white focus:outline-none">SBA-OJT
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
                <a class="focus:shadow-outline mt-2 rounded-lg bg-gray-700 px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('student_journal') }}">Journal</a>

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

    <div class="w-full container mx-auto max-w-screen-xl mt-8 px-12 ">
        <div class="min-h-80vh bg-white rounded-md border-0 shadow-md p-5 ">
            <form method="POST" action="{{ route('update_journal', ['journalID' => $journal->journalID]) }}" class="overflow-x-auto">
                @csrf
                @method('PUT')
                <div class="flex lg:flex-row justify-between mb-[1.5rem] xs:flex-col">
                    <div class="flex items-end">
                        <div class="form-group w-[10rem]">
                            <label for="" class="text-md font-medium">Journal Number</label>
                            <input type="text" name="journalNumber" class="form-control rounded-md w-[15rem] border-neutral-400 bg-gray-50" value="{{ $journal->journalNumber }}" readonly>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <div class="form-group">
                            <label for="coverage_start_date" class="text-md font-medium">Start Date</label>
                            <input type="date" name="coverage_start_date" class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-[15rem] mb-3" value="{{ $journal->coverage_start_date }}" required>
                        </div>


                        <div class="form-group">
                            <label for="coverage_end_date" class="text-md font-medium">End Date</label>
                            <input type="date" name="coverage_end_date" class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-[15rem] p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $journal->coverage_end_date }}" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="reflection" class="text-md font-medium">Reflection</label>
                    <textarea name="reflection" class="form-control block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-6" rows="10">{{ $journal->reflection }}</textarea>
                </div>

                <div class="flex lg:flex-row justify-between xs:flex-col xs:mb-6">
                    <div class="form-group">
                        <label for="hoursRendered" class="text-md font-medium">Hours Rendered</label>
                        <input type="text" name="hoursRendered" class="form-control rounded-md w-[15rem] border-neutral-400 bg-gray-50" value="{{ $journal->hoursRendered }}" required>
                    </div>

                    <div>
                        <label for="" class="text-md font-medium">Student Signature</label>
                        <img src="/{{ $journal->studentSignature }}" width="100px">
                    </div>

                    <div>
                        <label for="" class="text-md font-medium">Documentation</label>
                        <img src="/{{ $journal->supervisorSignature }}" width="100px">
                    </div>

                </div>


                <div class="form-group flex flex-row items-center gap-4 mb-4">
                    <label for="grade" class="text-md font-medium">Grade</label>
                    <input type="text" name="grade" class="form-control rounded-md bg-gray-50 text-gray-400 overflow-x-auto" value="{{ $journal->grade ?: 'Not Graded Yet' }}/30" readonly>
                </div>

                <div class="form-group flex flex-col">
                    <label for="comments" class="text-md font-medium">Coordinators Comment</label>
                    <textarea name="comments" class="form-control rounded-md bg-gray-50 text-gray-400" readonly>{{ $journal->comments }}</textarea>
                </div>

                <div class="flex align-middle justify-end mt-8">
                    <a class="bg-gray-800 text-white px-4 py-2 rounded-xl hover:bg-gray-600 text-sm">
                        <button type="submit" class=" btn btn-primary flex items-center justify-center text-white   font-medium rounded-lg text-sm px-2 py-0 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                            @if($journal->grade !== null)
                            Back
                            @else
                            Update Journal
                            @endif
                        </button>
                    </a>

                    @if($journal->grade !== null)
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var formElements = document.querySelectorAll('form input, form textarea');
                            formElements.forEach(function(element) {
                                element.setAttribute('readonly', true);
                            });
                        });
                    </script>
                    @endif
            </form>
        </div>
    </div>

</body>

</html>