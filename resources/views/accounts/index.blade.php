@extends('master')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col gap-6">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
                    Account Management
                </h2>
                @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
                    <button onclick="document.getElementById('add-account-modal').classList.toggle('hidden');"
                        class="text-sm items-center transition duration-150 ease-in-out flex gap-1 text-white bg-sscr-red hover:bg-sscr-red/80 active:bg-sscr-red/60 border border-sscr-red px-3 py-1 rounded">
                        @include('components.icons.add')Add Account
                    </button>
                @endif
            </div>
            <div class="flex gap-4 w-full border border-sscr-red rounded-lg">
                <p id="alumni-tab" class="cursor-pointer px-4 py-2 text-sscr-red font-bold" onclick="changeTab('alumni')">
                    Alumni Accounts</p>
                <p id="admin-tab" class="cursor-pointer px-4 py-2 " onclick="changeTab('admin')">Admin Accounts</p>
            </div>

            <div id="alumni-section" class="tab-content">
                @include('accounts.alumni-accounts')
            </div>

            <div id="admin-section" class="tab-content hidden">
                @include('accounts.admin-accounts')
            </div>
        </div>
    </div>

    @if (Auth::user()->role === 'cict_admin'|| Auth::user()->role === 'program_chair')
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
                                @if (Auth::user()->role === 'cict_admin')
                                    <option value="cict_admin">CICT Admin</option>
                                    <option value="program_chair">Program Chair</option>
                                    <option value="alumni_coordinator">Alumni Coordinator</option>
                                @endif
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
                            <input id="batch" type="text" name="batch"
                                class="mt-1 block w-full text-sm border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm"
                                required>
                        </div>
                        <div>
                            <label for="alumni_id" class="text-sm font-semibold text-gray-700 dark:text-gray-200">Alumni Id</label>
                            <input id="alumni_id" type="text" name="alumni_id"
                                class="mt-1 block w-full text-sm border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm"
                                required>
                        </div>
                        <div>
                            <label for="password" class="text-sm font-semibold text-gray-700 dark:text-gray-200">Password</label>
                            <input id="password" type="password" name="password"
                                class="mt-1 block w-full text-sm border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm"
                                required>
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
    @endif
@endsection

@section('scripts')
    <script>
        let currentTab = 'alumni';

        function changeTab(tab) {
            document.getElementById('alumni-tab').classList.toggle('text-sscr-red', tab === 'alumni');
            document.getElementById('alumni-tab').classList.toggle('font-bold', tab === 'alumni');
            document.getElementById('admin-tab').classList.toggle('text-sscr-red', tab === 'admin');
            document.getElementById('admin-tab').classList.toggle('font-bold', tab === 'admin');

            document.getElementById('alumni-section').classList.toggle('hidden', tab !== 'alumni');
            document.getElementById('admin-section').classList.toggle('hidden', tab !== 'admin');
        }

        document.addEventListener('DOMContentLoaded', function() {
            changeTab(currentTab);
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
                const course = row.cells[6].innerText.toLowerCase();
                const batch = row.cells[7].innerText.toLowerCase();
                if (fullname.includes(query) || email.includes(query) || username.includes(query) || course.includes(query) || batch.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function filterAlumniAccounts(e, status) {
            e.target.parentElement.querySelectorAll('button').forEach(button => {
                button.classList.remove('bg-sscr-red', 'text-white');
            });
            e.target.classList.add('bg-sscr-red', 'text-white');

            const rows = document.querySelectorAll('#alumni-table-body tr');
            rows.forEach(row => {
                if (status === 'all') {
                    row.style.display = '';
                } else {
                    const rowStatus = row.getAttribute('data-status');
                    row.style.display = rowStatus === status ? '' : 'none';
                }
            });
        }

        function updateAlumniTable(account, index, status) {
            const table = document.getElementById('alumni-table-body');
            const template = `
            <tr class="border-t dark:border-gray-700" data-status="${status}">
                <td class="px-6 py-4 whitespace-nowrap text-sm ">${index + 1}</td>
                <td class="px-6 py-4 w-12 whitespace-nowrap text-sm">
                    <img class="h-12 m-auto w-12 rounded-full object-cover" src="{{ asset('storage/profile/images') }}/${account.image ?? 'default.jpg'}" alt="User Image">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.alumni_information?.first_name ?? ''} ${account.alumni_information?.middle_name ?? ''} ${account.alumni_information?.last_name ?? ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.email}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.username}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${status}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.alumni_information?.course ?? ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.alumni_information?.batch ?? ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">2 days ago</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center h-full">
                        <button class="text-xs bg-blue-500 hover:bg-blue-600 py-1 px-2 rounded-lg" onclick="editAccount(${account.id})">Edit</button>
                        ${account.approved_at ?
                        account.disabled_at
                            ? `<button class="text-xs bg-yellow-500 hover:bg-yellow-600 py-1 px-2 rounded-lg" onclick="activateAccount(${account.id})">Activate</button>`
                            : `<button class="text-xs bg-yellow-500 hover:bg-yellow-600 py-1 px-2 rounded-lg" onclick="deactivateAccount(${account.id})">Deactivate</button>`
                            : `<button class="text-xs bg-yellow-500 hover:bg-yellow-600  py-1 px-2 rounded-lg" onclick="approveAccount(${account.id})">Approve</button>
                            <button class="text-xs bg-yellow-500 hover:bg-yellow-600  py-1 px-2 rounded-lg" onclick="rejectAccount(${account.id})">Reject</button>`
                        }
                        <button class="text-xs bg-red-500 hover:bg-red-600  py-1 px-2 rounded-lg" onclick="deleteAccount(${account.id})">Delete</button>
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
        function updateAdminTable(account, index, status) {
            const table = document.getElementById('admin-table-body');
            const template = `
            <tr class="border-t dark:border-gray-700" data-status="${status}">
                <td class="px-6 py-4 whitespace-nowrap text-sm ">${index + 1}</td>
                <td class="px-6 py-4 w-12 whitespace-nowrap text-sm">
                    <img class="h-12 m-auto w-12 rounded-full object-cover" src="{{ asset('storage/profile/images') }}/${account.image ?? 'default.jpg'}" alt="User Image">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.admin_information?.first_name ?? ''} ${account.admin_information?.middle_name ?? ''} ${account.admin_information?.last_name ?? ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.email}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.username}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${status}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.admin_information?.department ?? ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.role}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">2 days ago</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center h-full">
                        <button class="text-xs bg-blue-500 hover:bg-blue-600 py-1 px-2 rounded-lg" onclick="editAccount(${account.id})">Edit</button>
                        ${account.disabled_at
                            ? `<button class="text-xs bg-yellow-500 hover:bg-yellow-600 py-1 px-2 rounded-lg" onclick="activateAccount(${account.id})">Activate</button>`
                            : `<button class="text-xs bg-yellow-500 hover:bg-yellow-600 py-1 px-2 rounded-lg" onclick="deactivateAccount(${account.id})">Deactivate</button>`}
                        <button class="text-xs bg-red-500 hover:bg-red-600  py-1 px-2 rounded-lg" onclick="deleteAccount(${account.id})">Delete</button>
                    </div>
                </td>
            </tr>
        `;
            table.innerHTML += template;
        }

        function searchAdmin(e) {
            const query = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#admin-table-body tr');
            rows.forEach(row => {
                const fullname = row.cells[2].innerText.toLowerCase();
                const email = row.cells[3].innerText.toLowerCase();
                const username = row.cells[4].innerText.toLowerCase();
                const department = row.cells[6].innerText.toLowerCase();
                if (fullname.includes(query) || email.includes(query) || username.includes(query || department.includes(query))) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function filterAdminAccounts(e,status) {
            e.target.parentElement.querySelectorAll('button').forEach(button => {
                button.classList.remove('bg-sscr-red', 'text-white');
            });
            e.target.classList.add('bg-sscr-red', 'text-white');

            const rows = document.querySelectorAll('#admin-table-body tr');
            rows.forEach(row => {
                if (status === 'all') {
                    row.style.display = '';
                } else {
                    const rowStatus = row.getAttribute('data-status');
                    row.style.display = rowStatus === status ? '' : 'none';
                }
            });
        }

        function getAdminAccounts(accounts) {
            const table = document.getElementById('admin-table-body');
            table.innerHTML = '';
            accounts.forEach((admin, index) => {
                let status = 'inactive';
                if (admin.disabled_at) {
                        status = 'deactivated';
                } else {
                    if (admin.admin_information) {
                        status = 'active';
                    } else {
                        status = 'inactive';
                    }
                }
                updateAdminTable(admin, index, status)
            });
        }
    </script>

    <script>
        async function getAccounts() {
            const alumniContainer = document.getElementById('posts-container');
            const adminContainer = document.getElementById('posts-container');
            const url = "{{ route('api.account.index') }}";

            try {
                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const json = await response.json();

                getAdminAccounts(json.admin_list);
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

        function deactivateAccount(userId) {
            confirmation('Are you sure you want to deactivate this account?', async function () {
                const formData = new FormData();
                formData.append("status", "deactivate");
                const url = `/api/accounts/activation/${userId}`;
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

        function activateAccount(userId) {
            confirmation('Are you sure you want to activate this account?', async function () {
                const formData = new FormData();
                formData.append("status", "activate");
                const url = `/api/accounts/activation/${userId}`;
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
