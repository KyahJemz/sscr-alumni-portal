@extends('master')

@section('content')
<div class="container mx-auto max-w-7xl sm:p-2 md:p-6 space-y-6">
        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col gap-6">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
                    Admin Accounts Management
                </h2>
                <button onclick="document.getElementById('add-account-modal').classList.toggle('hidden');" class="sm:hidden md:flex text-xs items-center transition duration-150 ease-in-out gap-1 text-white bg-sscr-red hover:bg-sscr-red/80 active:bg-sscr-red/60 border border-sscr-red px-3 py-1 rounded">
                    @include('components.icons.add')Add Account
                </button>
            </div>
            <div id="admin-section" class="tab-content">
                <div id=search class="flex mb-4 gap-4 items-center">
                    <label for="search" class="text-SM text-gray-500">Search: </label>
                    <input name="search" id="search" type="text" oninput="searchAdmin(event)" placeholder="Search admin..." class="border rounded-lg p-2 w-full text-xs" />
                </div>
                <button onclick="document.getElementById('add-account-modal').classList.toggle('hidden');" class="sm:flex md:hidden text-xs mb-4 items-center transition duration-150 ease-in-out gap-1 text-white bg-sscr-red hover:bg-sscr-red/80 active:bg-sscr-red/60 border border-sscr-red px-3 py-1 rounded">
                    @include('components.icons.add')Add Account
                </button>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-800 shadow-md rounded-lg border border-gray-200 rounded">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">#</th>
                                <th class="px-4 py-2 w-12 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Profile Image</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Fullname</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Role</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 dark:text-gray-300" id="admin-table-body">

                        </tbody>
                    </table>
                </div>

            </div>
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
                            <option value="cict_admin">CICT Admin</option>
                            <option value="program_chair">Program Chair</option>
                            <option value="alumni_coordinator">Alumni Coordinator</option>
                        </select>
                    </div>

                    <div>
                        <label for="email" class="text-sm font-semibold text-gray-700 dark:text-gray-200">Email</label>
                        <input id="email" type="email" name="email"
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
@endsection

@section('scripts')

    <script>
        function searchAdmin(e) {
            const query = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#admin-table-body tr');
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

        function updateAdminTable(account, index, role) {
            const table = document.getElementById('admin-table-body');
            const template = `
            <tr class="border-t">
                <td class="px-6 py-4 whitespace-nowrap text-sm ">${index + 1}</td>
                <td class="px-6 py-4 w-12 whitespace-nowrap text-sm">
                    <img class="h-12 m-auto w-12 rounded-full object-cover" src="{{ asset('storage/profile/images') }}/${account.image ?? 'default.jpg'}" alt="User Image" onerror="this.onerror=null; this.src='{{ asset('storage/profile/images/default.jpg') }}';">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.admin_information?.first_name ?? ''} ${account.admin_information?.middle_name ?? ''} ${account.admin_information?.last_name ?? ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.email}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${role}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center h-full">
                        <button class="text-xs bg-blue-500 hover:bg-blue-600 py-1 px-2 rounded-lg underline" onclick="editAccount(${account.id})">Edit</button>
                        ${account.disabled_at
                            ? `<button class="text-xs bg-yellow-500 hover:bg-yellow-600 py-1 px-2 rounded-lg underline" onclick="activateAccount(${account.id})">Activate</button>`
                            : `<button class="text-xs bg-yellow-500 hover:bg-yellow-600 py-1 px-2 rounded-lg underline" onclick="deactivateAccount(${account.id})">Deactivate</button>`
                        }
                        <button class="text-xs bg-red-500 hover:bg-red-600  py-1 px-2 rounded-lg underline" onclick="deleteAccount(${account.id})">Delete</button>
                    </div>
                </td>
            </tr>
        `;
            table.innerHTML += template;
        }

        function getAdminAccounts(accounts) {
            const table = document.getElementById('admin-table-body');
            table.innerHTML = '';
            accounts.forEach((admin, index) => {
                let role = 'CICT Admin';
                switch (admin.role) {
                    case 'program_chair':
                        role = 'Program Chair';
                        break;
                    case 'alumni_coordinator':
                        role = 'Alumni Coordinator';
                        break;
                    case 'cict_admin':
                        role = 'CICT Admin';
                        break;
                    default:
                        role = 'Unknown';
                        break;
                }
                updateAdminTable(admin, index, role)
            });
        }

        async function getAccounts() {
            const url = "{{ route('api.account.index', ['type' => 'admins']) }}";

            try {
                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const json = await response.json();

                getAdminAccounts(json.admin_list);
            } catch (error) {
                console.error('Error fetching posts:', error.message);
            }
        }
        getAccounts()
    </script>

    <script>

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
