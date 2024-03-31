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

    <title>Dashboard</title>
</head>

<body>
    <!-- CODE FOR NAVBAR -->
    <div class="w-full bg-gray-800 text-gray-200">
        <!-- Display Success Message -->
        @if(session()->has('success'))
        <div class="bg-green-200 text-green-800 p-4 mb-4">
        {{ session('success') }}
        </div>
        @endif
        <div x-data="{ open: false }" class="mx-auto flex max-w-screen-xl flex-col px-4 md:flex-row md:items-center md:justify-between md:px-6 lg:px-8">
        <div class="flex flex-row items-center justify-between p-4">
            <a href="{{ route ('admin') }}" class="focus:shadow-outline rounded-lg text-lg font-semibold uppercase tracking-widest text-white focus:outline-none">SBA-OJT Portal</a>
            <button class="focus:shadow-outline rounded-lg focus:outline-none md:hidden" @click="open = !open">
            <svg fill="currentColor" viewBox="0 0 20 20" class="h-6 w-6">
                <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
            </button>
        </div>
        <nav :class="{'flex': open, 'hidden': !open}" class="hidden flex-grow flex-col pb-4 md:flex md:flex-row md:justify-end md:pb-0">
            <a class="focus:shadow-outline mt-2 rounded-lg bg-transparent px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route ('admin') }}">Dashboard</a>
            <a class="focus:shadow-outline mt-2 rounded-lg bg-transparent px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('admin_company-page') }}">Company</a>
            <a class="focus:shadow-outline mt-2 rounded-lg bg-transparent px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('admin_coordinator-page') }}">Coordinator</a>
            <a class="focus:shadow-outline mt-2 rounded-lg bg-transparent px-4 py-2 text-sm font-semibold text-gray-200 hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4" href="{{ route('admin_student-page') }}">Student</a>
            <a class="focus:shadow-outline mt-2 text-[#AD974F] font-bold rounded-lg bg-gray-700 px-4 py-2 text-sm  hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0" href="{{ route ('history_logs') }}">Activity Log</a>
            <div @click.away="open = false" class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="focus:shadow-outline mt-2 flex w-full flex-row items-center rounded-lg bg-transparent px-4 py-2 text-left text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4 md:inline md:w-auto">
                <span>{{ Auth::user()->name }} </span>
                <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="mt-1 ml-1 inline h-4 w-4 transform transition-transform duration-200 md:-mt-1">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-full origin-top-right rounded-md shadow-lg md:w-48">
                <div class="rounded-md bg-gray-800 px-2 py-2 shadow flex flex-col"> <!-- Added flex and flex-col classes -->
                <a href="{{ route('password.edit') }}" class="py-1">Update Password</a> <!-- Added padding top and bottom -->
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="py-1"> <!-- Added padding top and bottom -->
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                </div>
            </div>
            </div>
        </nav>
        </div>
    </div>
    <!-- {{-- End of Nav Bar --}} -->

    <div class="w-full container mx-auto max-w-screen-xl mt-8  lg:px-12 px-2">
        <div class="min-h-[80vh] bg-white rounded-md border-0 shadow-md p-5 overflow-auto">
            {{-- Add filter here --}}
                <div class="flex gap-6 w-full justify-between">
                    <div class="flex gap-4 lg:flex-row md:flex-row sm:flex-row ss:flex-row xs:flex-row flex-col">
                        <select id="major_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-[100%] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            <option value="">All Major</option>
                            <option value="Accounting">Accounting</option>
                            <option value="Management">Management</option>
                        </select>

                    <!-- Role Filter -->
                        <select id="role_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-[100%] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            <option value="">All Role</option>
                            <option value="1">Admin</option>
                            <option value="2">Coordinator</option>
                            <option value="3">Student</option>
                        </select>

                    <!-- Time Filter -->
                        <select id="time_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-[100%] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            <option value="">All</option>
                            <option value="1_month">1 Month Ago</option>
                            <option value="2_month">2 Months Ago</option>
                            <option value="3_month">3 Months Ago</option>
                            <option value="4_month">4 Months Ago</option>
                            <option value="5_month">5 Months Ago</option>
                        </select>
                    </div>
                </div>

                <!-- History Logs Table -->
                <div class="flex flex-col flex-wrap gap-2 mt-4">
                    <table id="history_logs_table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                        <!-- Table Headers -->
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-4">User</th>
                                <th scope="col" class="px-4 py-4">Major</th>
                                <th scope="col" class="px-4 py-4">Activity</th>
                                <th scope="col" class="px-4 py-4">Date</th>
                                <th scope="col" class="px-4 py-4">Time</th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                            @foreach ($historyLogs as $historylog)
                                @php
                                    $user = \App\Models\User::where('schoolID', $historylog->userID)->first();
                                    $createdAt = $historylog->created_at;
                                    $diffInMonths = $createdAt->diffInMonths(now());
                                @endphp
                                <tr data-major="{{ $user->major }}" data-role="{{ $user->role }}" data-created-at="{{ $createdAt }}">
                                    <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->major }}</td>
                                    <td class="py-2 px-4 border-b">{{ $historylog->activity }}</td>
                                    <td class="py-2 px-4 border-b">{{ $createdAt->format('F d Y') }}</td>
                                    <td class="py-2 px-4 border-b">{{ $createdAt->setTimezone('Asia/Manila')->format('h:i A') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="">
                    {!! $historyLogs->links() !!}
                </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var majorFilter = document.getElementById('major_filter');
            var roleFilter = document.getElementById('role_filter');
            var timeFilter = document.getElementById('time_filter');

            majorFilter.addEventListener('change', filterTable);
            roleFilter.addEventListener('change', filterTable);
            timeFilter.addEventListener('change', filterTable);

            function filterTable() {
                var selectedMajor = majorFilter.value.toLowerCase();
                var selectedRole = roleFilter.value.toLowerCase();
                var selectedTime = timeFilter.value.toLowerCase();

                var rows = document.querySelectorAll('#history_logs_table tbody tr');

                rows.forEach(function (row) {
                    var rowMajor = row.getAttribute('data-major').toLowerCase();
                    var rowRole = row.getAttribute('data-role').toLowerCase();
                    var rowCreatedAt = new Date(row.getAttribute('data-created-at'));

                    var majorMatch = selectedMajor === '' || selectedMajor === rowMajor;
                    var roleMatch = selectedRole === '' || selectedRole === rowRole;

                    var timeMatch = true;
                    if (selectedTime !== '') {
                        var cutoffDate = new Date();
                        cutoffDate.setMonth(cutoffDate.getMonth() - parseInt(selectedTime));
                        timeMatch = rowCreatedAt <= cutoffDate;
                    }

                    if (majorMatch && roleMatch && timeMatch) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        });
    </script>






</body>

</html>