@extends('master')

@section('content')
<div class="container mx-auto max-w-7xl sm:p-2 md:p-6 space-y-6">
        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col gap-6">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
                    Graduates Accounts Management
                </h2>
                <div class="md:flex gap-2 sm:hidden">
                    <button onclick="document.getElementById('add-account-modal').classList.toggle('hidden');" class="text-xs items-center transition duration-150 ease-in-out flex gap-1 text-white bg-sscr-red hover:bg-sscr-red/80 active:bg-sscr-red/60 border border-sscr-red px-3 py-1 rounded">
                        @include('components.icons.add')Add Account
                    </button>
                    <button onclick="document.getElementById('add-bulk-account-modal').classList.toggle('hidden');" class="text-xs items-center transition duration-150 ease-in-out flex gap-1 text-white bg-sscr-red hover:bg-sscr-red/80 active:bg-sscr-red/60 border border-sscr-red px-3 py-1 rounded">
                        @include('components.icons.add')Bulk Add Account
                    </button>
                </div>
            </div>
            <div id="alumni-section" class="tab-content">
                <div id=search class="flex mb-4 gap-4 items-center">
                    <label for="search" class="text-SM text-gray-500">Search: </label>
                    <input name="search" id="search" type="text" oninput="searchAlumni(event)" placeholder="Search alumni..." class="border rounded-lg p-2 w-full text-xs" />
                </div>
                <div id="filters" class="flex justify-between w-full sm:flex-col md:flex-row my-4">
                    <div class="flex mb-4 gap-4 items-center">
                        <p class="text-md">Filters:</p>
                        <div class="relative">
                            <button id="batch-filter-dropdown-btn" class="bg-gray-200 text-gray-700 rounded-md px-4 py-2 inline-flex items-center text-xs">
                                Batch Numbers
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                                </svg>
                            </button>
                            <div id="batch-filter-dropdown" class="absolute z-10 hidden bg-white border border-gray-300 rounded-md mt-1 w-48 shadow-lg">
                                <div class="py-1">
                                    @forelse ($batches as $batch)
                                        <label class="flex items-center px-4 py-2 text-xs">
                                            <input type="checkbox" onchange="filterAlumniAccounts(event)" value="{{$batch['batch']}}" class="alumni-batch-filter mr-2 text-sscr-red border-gray-300 focus:ring-0 hover:ring-0 active:ring-0" />
                                            {{$batch['display']}}
                                        </label>
                                    @empty
                                        <p>No batches found</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <button id="course-filter-dropdown-btn" class="bg-gray-200 text-gray-700 rounded-md px-4 py-2 inline-flex items-center text-xs">
                                Courses
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                                </svg>
                            </button>
                            <div id="course-filter-dropdown" class="absolute z-10 hidden bg-white border border-gray-300 rounded-md mt-1 w-48 shadow-lg">
                                <div class="py-1">
                                    @forelse ($courses as $course)
                                        <label class="flex items-center px-4 py-2 text-xs">
                                            <input type="checkbox" onchange="filterAlumniAccounts(event)" value="{{$course->course}}" class="alumni-course-filter mr-2 text-sscr-red border-gray-300 focus:ring-0 hover:ring-0 active:ring-0" />
                                            {{$course->course}}
                                        </label>
                                    @empty
                                        <p>No courses found</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a class="bg-sscr-red text-white rounded-md h-max py-2 px-4 inline-flex items-center text-xs cursor-pointer w-max" onclick="exportTable()">Export Table</a>
                        <a class="bg-sscr-red text-white rounded-md h-max py-2 px-4 inline-flex items-center text-xs cursor-pointer w-max" onclick="generatePDF()">Print Table</a>
                        <button onclick="document.getElementById('add-account-modal').classList.toggle('hidden');" class="sm:flex md:hidden w-max text-xs items-center transition duration-150 ease-in-out gap-1 text-white bg-sscr-red hover:bg-sscr-red/80 active:bg-sscr-red/60 border border-sscr-red px-3 py-1 rounded">
                            Add
                        </button>
                        <button onclick="document.getElementById('add-bulk-account-modal').classList.toggle('hidden');" class="sm:flex md:hidden w-max text-xs items-center transition duration-150 ease-in-out gap-1 text-white bg-sscr-red hover:bg-sscr-red/80 active:bg-sscr-red/60 border border-sscr-red px-3 py-1 rounded">
                            Bulk Add
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-800 shadow-md rounded-lg border border-gray-200 rounded" id="alumni-accounts-table">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">#</th>
                                <th class="px-4 py-2 w-12 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Profile Image</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Fullname</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Alumni ID</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Batch</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Course</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 dark:text-gray-300" id="alumni-table-body">

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div id="add-bulk-account-modal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 z-50">
        <div id="add-account-form" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg p-6 relative">
            <form method="POST" onsubmit="onBulkAdd(event)">
                @csrf
                <h2
                    class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4 flex justify-between items-center">
                    Add Bulk Account Form
                    <button type="button"
                        onclick="document.getElementById('add-bulk-account-modal').classList.toggle('hidden');"
                        class="text-sscr-red">
                        @include('components.icons.x')
                    </button>
                </h2>

                <div class="grid grid-cols gap-4">
                    <div>
                        <label for="file" class="text-sm font-semibold text-gray-700 dark:text-gray-200">Input excel file</label>
                        <input type="file" name="file" id="file" class="block w-full text-sm text-slate-500" />
                    </div>
                    <p>Download template excel file: <a href="{{ asset('storage/bulk-account-template.xlsx') }}" class="text-blue-600 underline">click here</a></p>
                    <div>
                        <textarea id="errors" name="errors" cols="30" rows="10" class="hidden block w-full text-sm text-slate-500"></textarea>
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit"
                        class="bg-sscr-red hover:bg-sscr-red/80 text-white font-bold py-2 px-4 rounded">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>


    <div id="add-account-modal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 z-50">
        <div id="add-account-form" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg p-6 relative">
            <form method="POST" onsubmit="onAdd(event)">
                @csrf
                <h2
                    class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4 flex justify-between items-center">
                    Add Account Form
                    <button type="button"
                        onclick="document.getElementById('add-account-modal').classList.toggle('hidden');"
                        class="text-sscr-red">
                        @include('components.icons.x')
                    </button>
                </h2>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="text-sm font-semibold text-gray-700 dark:text-gray-200">First Name</label>
                        <input id="first_name" type="text" name="first_name"
                            class="mt-1 block w-full text-sm border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm"
                            required>
                    </div>
                    <div>
                        <label for="middle_name" class="text-sm font-semibold text-gray-700 dark:text-gray-200">Middle Name</label>
                        <input id="middle_name" type="text" name="middle_name"
                            class="mt-1 block w-full text-sm border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="last_name" class="text-sm font-semibold text-gray-700 dark:text-gray-200">Last Name</label>
                        <input id="last_name" type="text" name="last_name"
                            class="mt-1 block w-full text-sm border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm"
                            required>
                    </div>
                    <div>
                        <label for="suffix" class="text-sm font-semibold text-gray-700 dark:text-gray-200">Suffix</label>
                        <input id="suffix" type="text" name="suffix"
                            class="mt-1 block w-full text-sm border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="name" class="text-sm font-semibold text-gray-700 dark:text-gray-200">Role</label>
                        <select id="role" type="text" name="role" class="mt-1 block w-full text-sm border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm" required>
                            <option value="alumni">Alumni</option>
                        </select>
                    </div>
                    <div>
                        <label for="email" class="text-sm font-semibold text-gray-700 dark:text-gray-200">Email</label>
                        <input id="email" type="email" name="email"
                            class="mt-1 block w-full text-sm border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm"
                            required>
                    </div>
                    <div>
                        <label for="course" class="text-sm font-semibold text-gray-700 dark:text-gray-200">Course</label>
                        <input id="course" type="text" name="course"
                            class="mt-1 block w-full text-sm border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm"
                            required>
                    </div>
                    <div>
                        <label for="batch" class="text-sm font-semibold text-gray-700 dark:text-gray-200">Batch</label>
                        <input id="batch" type="text" name="batch" maxlength="4" minlength="4"
                            class="mt-1 block w-full text-sm border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm"
                            required>
                    </div>
                    <div class="hidden">
                        <input id="batch" type="text" name="approved" value="no">
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit"
                        class="bg-sscr-red hover:bg-sscr-red/80 text-white font-bold py-2 px-4 rounded">
                        Add Account
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')

<style>

</style>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        function generatePDF() {
        let originalTable = document.getElementById('alumni-accounts-table');

        let clonedTable = originalTable.cloneNode(true);

        let columnsToKeep = [0, 1, 2, 3, 4, 5, 6];

        Array.from(clonedTable.rows).forEach(row => {
            Array.from(row.cells).forEach((cell, index) => {
                if (!columnsToKeep.includes(index)) {
                    cell.style.display = 'none';
                }
            });
        });

        let container = document.createElement('div');
        container.appendChild(clonedTable);

        let PdfOptions = {
            margin: 0.5,
            filename: `Graduates_${new Date().toISOString().slice(0, 10)}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: {
                scale: 1,
                useCORS: true,
                scrollY: 1,
            },
            jsPDF: {
                unit: 'in',
                format: 'legal',
                orientation: 'landscape',
            },
            pagebreak: {
                mode: ['css', 'legacy'],
                before: '.page-break',
            },
        };

        html2pdf().set(PdfOptions).from(container).save();
    }
    </script>

    <script>
        document.getElementById('batch-filter-dropdown-btn').addEventListener('click', function() {
            const dropdown = document.getElementById('batch-filter-dropdown');
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('batch-filter-dropdown');
            if (!event.target.closest('#batch-filter-dropdown-btn') && !event.target.closest('#batch-filter-dropdown')) {
                dropdown.classList.add('hidden');
            }
        });

        document.getElementById('course-filter-dropdown-btn').addEventListener('click', function() {
            const dropdown = document.getElementById('course-filter-dropdown');
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('course-filter-dropdown');
            if (!event.target.closest('#course-filter-dropdown-btn') && !event.target.closest('#course-filter-dropdown')) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

    <script>
        function searchAlumni(e) {
            const query = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#alumni-table-body tr');
            rows.forEach(row => {
                const fullname = row.cells[2].innerText.toLowerCase();
                const email = row.cells[3].innerText.toLowerCase();
                const username = row.cells[4].innerText.toLowerCase();
                const course = row.cells[5].innerText.toLowerCase();
                const batch = row.cells[6].innerText.toLowerCase();
                if (fullname.includes(query) || email.includes(query) || username.includes(query) || course.includes(query) || batch.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function filterAlumniAccounts(e) {
            const selectedBatches = Array.from(document.querySelectorAll('.alumni-batch-filter:checked')).map(batch => batch.value);
            const selectedCourses = Array.from(document.querySelectorAll('.alumni-course-filter:checked')).map(course => course.value);

            const rows = document.querySelectorAll('#alumni-table-body tr');

            const shouldDisplayRow = (row) => {
                const rowBatch = row.getAttribute('data-batch');
                const rowCourse = row.getAttribute('data-course');
                const isBatchMatched = selectedBatches.length === 0 || selectedBatches.includes(rowBatch);
                const isCourseMatched = selectedCourses.length === 0 || selectedCourses.includes(rowCourse);
                return isBatchMatched && isCourseMatched;
            };

            rows.forEach(row => {
                row.style.display = shouldDisplayRow(row) ? '' : 'none';
            });
        }

        function updateAlumniTable(account, index, status) {
            const table = document.getElementById('alumni-table-body');
            const template = `
            <tr class="border-t dark:border-gray-700" data-batch="${account.alumni_information?.batch ?? ''}" data-course="${account.alumni_information?.course ?? ''}">
                <td class="px-6 py-4 whitespace-nowrap text-sm ">${index + 1}</td>
                <td class="px-6 py-4 w-12 whitespace-nowrap text-sm">
                    <img class="h-12 m-auto w-12 rounded-full object-cover" src="{{ asset('storage/profile/images') }}/${account.image ?? 'default.jpg'}" alt="User Image" onerror="this.onerror=null; this.src='{{ asset('storage/profile/images/default.jpg') }}';">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.alumni_information?.first_name ?? ''} ${account.alumni_information?.middle_name ?? ''} ${account.alumni_information?.last_name ?? ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.email}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.username}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.alumni_information?.batch ?? ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.alumni_information?.course ?? ''}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center h-full">
                        <button class="text-xs bg-blue-500 hover:bg-blue-600 py-1 px-2 rounded-lg underline" onclick="editAccount(${account.id})">Edit</button>
                        @if(Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
                            ${account.approved_at ?
                            account.disabled_at
                                ? `<button class="text-xs bg-yellow-500 hover:bg-yellow-600 py-1 px-2 rounded-lg underline" onclick="activateAccount(${account.id})">Activate</button>`
                                : `<button class="text-xs bg-yellow-500 hover:bg-yellow-600 py-1 px-2 rounded-lg underline" onclick="deactivateAccount(${account.id})">Deactivate</button>`
                                : `<button class="text-xs bg-yellow-500 hover:bg-yellow-600  py-1 px-2 rounded-lg underline" onclick="approveAccount(${account.id})">Approve</button>
                                <button class="text-xs bg-yellow-500 hover:bg-yellow-600  py-1 px-2 rounded-lg underline" onclick="rejectAccount(${account.id})">Reject</button>`
                            }
                        @endif
                        <button class="text-xs bg-red-500 hover:bg-red-600  py-1 px-2 rounded-lg underline" onclick="deleteAccount(${account.id})">Delete</button>
                    </div>
                </td>
            </tr>
        `;
            table.innerHTML += template;
        }

        function getAlumniAccounts(accounts) {

            const table = document.getElementById('alumni-table-body');
            table.innerHTML = '';
            accounts.forEach((alumni, index) => {
                let status = 'for approval';
                if (alumni.approved_at) {
                    if (alumni.disabled_at) {
                        status = 'deactivated';
                    } else {
                        if (alumni.alumni_information) {
                            status = 'active';
                        } else {
                            status = 'inactive';
                        }
                    }
                } else {
                    if (alumni.disabled_at) {
                        status = 'deactivated';
                    } else {
                        if (alumni.rejected_at) {
                            status = 'rejected';
                        } else {
                            status = 'for approval';
                        }
                    }
                }
                updateAlumniTable(alumni, index, status)
            });

        }
    </script>

    <script>
        async function exportTable() {
            const data = [];
            const headers = ["#", "Fullname", "Email", "Alumni Id", "Course", "Batch"];

            const rows = document.querySelectorAll('#alumni-table-body tr');

            rows.forEach(row => {
                if (getComputedStyle(row).display !== 'none') {
                    data.push([
                        row.cells[0].innerText,
                        row.cells[2].innerText,
                        row.cells[3].innerText,
                        row.cells[4].innerText,
                        row.cells[5].innerText,
                        row.cells[6].innerText
                    ]);
                }
            });

            const payload = {
                headers: headers,
                data: data
            };

            confirmation(`Are you sure you want to export (${data.length}) records?`, async function () {
                const url = `{{ route('account.export') }}`;
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(payload)
                    });
                    if (!response.ok) {
                        throw new Error(`Response status: ${response.status}`);
                    }
                    const fileName = `export-graduates-${(new Date()).toISOString()}.xlsx`;
                    const blob = await response.blob();
                    const link = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = link;
                    a.download = fileName;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    alertModal('Exported successfully!');
                } catch (error) {
                    alertModal(error.message);
                    console.error(error.message);
                }
            });
        }

        async function getAccounts() {
            const url = "{{ route('api.account.index', ['type' => 'graduates']) }}";

            try {
                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const json = await response.json();

                getAlumniAccounts(json.alumni_list);
            } catch (error) {
                console.error('Error fetching posts:', error.message);
            }
        }
        getAccounts()

        async function onAdd(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const url = "{{ route('api.account.store') }}";
            try {
                document.getElementById('add-account-modal').classList.toggle('hidden');
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                });
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }
                const json = await response.json();
                alertModal(json.message);
                getAccounts();
            } catch (error) {
                document.getElementById('add-account-modal').classList.toggle('hidden');
                alertModal(error.message);
                console.error(error.message);
            }
        }

        async function onBulkAdd(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const errorText = document.querySelector('#add-bulk-account-modal #errors');
            const url = "{{ route('api.account.import') }}";
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                });
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }
                const json = await response.json();
                alertModal(json.message, 5);
                errorText.value = json.failed;
                if (json.failed) {
                    errorText.classList.remove('hidden');
                } else {
                    errorText.classList.add('hidden');
                }
                getAccounts();
            } catch (error) {
                alertModal(error.message, 5);
                if (error.message) {
                    errorText.classList.remove('hidden');
                } else {
                    errorText.classList.add('hidden');
                }
                errorText.value = error.message;
                console.error(error.message);
            }
        }

        function editAccount(userId) {
            window.location.href = `/user/${userId}`;
        }

        function approveAccount(userId) {
            confirmation('Are you sure you want to approve this account?', async function () {
                const formData = new FormData();
                formData.append("status", "approve");
                const url = `/api/accounts/approval/${userId}`;
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    });
                    if (!response.ok) {
                        throw new Error(`Response status: ${response.status}`);
                    }
                    const json = await response.json();
                    alertModal(json.message);
                    getAccounts();
                } catch (error) {
                    alertModal(error.message);
                    console.error(error.message);
                }
            });
            console.log(`Edit user with ID: ${userId}`);
        }

        function rejectAccount(userId) {
            confirmation('Are you sure you want to reject this account?', async function () {
                const formData = new FormData();
                formData.append("status", "reject");
                const url = `/api/accounts/approval/${userId}`;
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    });
                    if (!response.ok) {
                        throw new Error(`Response status: ${response.status}`);
                    }
                    const json = await response.json();
                    alertModal(json.message);
                    getAccounts();
                } catch (error) {
                    alertModal(error.message);
                    console.error(error.message);
                }
            });
            console.log(`Edit user with ID: ${userId}`);
        }

        function deleteAccount(userId) {
            confirmation('Are you sure you want to delete this account?', async function () {
                const formData = new FormData();
                formData.append('_method', 'DELETE');
                formData.append("_token", "{{ csrf_token() }}");
                const url = `/api/accounts/${userId}`;
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    });
                    if (!response.ok) {
                        throw new Error(`Response status: ${response.status}`);
                    }
                    const json = await response.json();
                    alertModal(json.message);
                    getAccounts();
                } catch (error) {
                    alertModal(error.message);
                    console.error(error.message);
                }
            });
        }
    </script>
@endsection
