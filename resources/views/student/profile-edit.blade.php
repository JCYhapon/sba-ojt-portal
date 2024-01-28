<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{----alphinejs----}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.js"></script>
    @vite('resources/css/app.css')
    <title>Profile</title>
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

    <div class="w-full container mx-auto max-w-screen-xl mt-8 p-12 h-auto">
        @foreach (explode(',',Auth::user()->schoolID) as $studentID)
            @php
                $student = \App\Models\Student::where('studentID', $studentID)->first();
            @endphp
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-rows-3">
                    <!--  FIRST ROW -->
                    <div class="bg-white row-span-1 grid grid-cols-3 p-8 shadow-md rounded-md h-48 py-12">
                        <div class="flex flex-col justify-between">
                            <h1 class="text-3xl">{{ $student->lastName }} {{ $student->firstName }}</h1>
                            <div class="form-group">
                                <label for="profilePicture">Profile Picture</label>
                                <input type="file" name="profilePicture" accept="image/*">
                            </div>
                            <p class="text-lg capitalize"><span class="font-semibold">Section:</span> {{ $student->section }}</p>
                        </div>
                        <div class="flex items-end">
                            <div>
                                <p class="text-lg"><span class="font-semibold">Email:</span> {{ $student->email }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col justify-between">
                            <p class="text-lg"><span class="font-semibold">Status:</span> {{ $student->status == 1 ? 'Active' : ($student->status == 2 ? 'Drop' : 'Unknown') }}</p>
                            <p class="text-lg capitalize"><span class="font-semibold">Course:</span> {{ $student->major }}</p>
                        </div>
                    </div>

                    <!-- SECOND ROW -->
                    <div class="row-span-1 bg-white p-8 shadow-md rounded-md grid grid-cols-2 h-56">
                        <div class="flex flex-col justify-between gap-2">
                            @php
                                $company = \App\Models\Company::find($student->hiredCompany);
                            @endphp
                            <div>
                                @if(isset($companies->name) && !empty($companies->name))
                                    <p class="text-lg font-semibold">Company: {{ $companies->name }}</p>
                                @else
                                    <p class="text-lg font-semibold">Company: Not Hired</p>
                                @endif
                            </div>
                            <!-- Add input fields for position and supervisor -->
                            <div class="sm:col-span-2">
                                <label for="position">Positions:</label>
                                <ul class="flex flex-wrap p-2.5 dark:border-gray-600">
                                    @if (!empty($company->position) && is_array($company->position) && count($company->position) > 0)
                                        @foreach($company->position as $position)
                                            <li style="background-color: #202c34; color: white;" class="rounded-lg p-2.5 dark:placeholder-gray-400 m-2">{{ $position }}</li>
                                        @endforeach
                                        <li>
                                            <select name="position" class="rounded-lg p-2.5 dark:placeholder-gray-400 m-2">
                                                <option value="">Choose a position</option>
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

                            <div>
                                <label for="supervisor">Supervisor:</label>
                                <input type="text" id="supervisor" name="supervisor" value="{{ old('supervisor') }}" placeholder="Enter new supervisor">
                            </div>
                            <button type="submit">Update Profile</button>
                        </div>
                    </div>
                </div>
            </form>
        @endforeach
    </div>


</body>

</html>
