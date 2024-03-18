<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{----alphinejs----}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.js"></script>

    <!-- Tailwindcss CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/background.css') }}">

    <title>Company List</title>
</head>

<body>
    <!-- CODE FOR NAVBAR -->
    <div class="w-full bg-gray-800 text-gray-200">
        <div x-data="{ open: false }" class="mx-auto flex max-w-screen-xl flex-col px-4 md:flex-row md:items-center md:justify-between md:px-6 lg:px-8">
            <div class="flex flex-row items-center justify-between p-4">
                <a href="{{ route('student') }}" class="focus:shadow-outline rounded-lg text-lg font-semibold uppercase tracking-widest text-white focus:outline-none">SBA-OJT
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
                <a class="focus:shadow-outline mt-2 text-[#AD974F] font-bold rounded-lg bg-gray-700 px-4 py-2 text-sm  hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('student_company-list') }}">Company List</a>
                <a class="focus:shadow-outline mt-2 rounded-lg bg-transparent px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('student_journal') }}">Journal</a>

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

    <div class="w-full container mx-auto max-w-screen-xl mt-8  lg:px-12">
        <div class="min-h-[80vh] bg-white rounded-md border-0 shadow-md p-5">
            @if(!$student || !$student->workType)
            @if (empty($student->position))
            <div class="bg-red-200 text-red-800 p-4 mb-4">
                No Company Matched
                <button class="bg-red p-1 rounded-md text-sm">
                    <a href="{{ route('profile.edit') }}" class="text-red-1000 font-bold">Click Here</a>
                </button>
                to Set preferred Position and Work Type
            </div>
            @elseif (empty($student->workType))
            <div class="bg-red-200 text-red-800 p-4 mb-4">
                No Company Matched
                <button class="bg-red p-1 rounded-md text-sm">
                    <a href="{{ route('profile.edit') }}" class="text-red-1000 font-bold">Click Here</a>
                </button>
                to Set preferred Work Type
            </div>
            @endif
            @endif


            <div class="flex flex-col justify-between min-h-70vh overflow-x-auto">
                <!-- Company Table -->
                <div style="display: flex; flex-direction: row;">
                    <div style="flex: 1; margin-right: 20px;">
                        <h1><b>Suggested Company</b></h1>
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-4">Company Name</th>
                                    <th scope="col" class="px-4 py-4">Email</th>
                                    <th scope="col" class="px-4 py-4">Address</th>
                                    <th scope="col" class="px-4 py-4">Status</th>
                                    <th scope="col" class="px-4 py-4">Position</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($student->suggestedCompany as $companyId)
                                @php
                                $company = \App\Models\Company::find($companyId);
                                @endphp

                                @if ($company)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $company->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $company->email }}</td>
                                    <td class="py-2 px-4 border-b">{{ $company->address }}</td>
                                    <td class="py-2 px-4 border-b">
                                        @if($company->status == 1)
                                        Active
                                        @elseif($company->status == 2)
                                        Renewal
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        @if ($company->position)
                                        {{ implode(', ', $company->position) }}
                                        @else
                                        No Available Position
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div style="flex: 1;">
                        <h1><b>Matched Company</b></h1>
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-4">Company Name</th>
                                    <th scope="col" class="px-4 py-4">Email</th>
                                    <th scope="col" class="px-4 py-4">Address</th>
                                    <th scope="col" class="px-4 py-4">Status</th>
                                    <th scope="col" class="px-4 py-4">Position</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($student->matchedCompany as $companyId)
                                @php
                                $company = \App\Models\Company::find($companyId);
                                @endphp

                                @if ($company)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $company->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $company->email }}</td>
                                    <td class="py-2 px-4 border-b">{{ $company->address }}</td>
                                    <td class="py-2 px-4 border-b">
                                        @if($company->status == 1)
                                        Active
                                        @elseif($company->status == 2)
                                        Renewal
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        @if ($company->position)
                                        {{ implode(', ', $company->position) }}
                                        @else
                                        No Available Position
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>