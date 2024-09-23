@extends('master')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl sm:px-6 lg:px-8 space-y-6">
    <div class="bg-white shadow-md rounded-lg p-6 flex flex-col gap-6">
        <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
            Accounts Management
        </h2>

        <!-- Tab Navigation -->
        <div class="flex gap-4 w-full border border-sscr-red rounded-lg">
            <p id="alumni-tab" class="cursor-pointer px-4 py-2 text-sscr-red font-bold" onclick="changeTab('alumni')">Alumni Accounts</p>
            <p id="admin-tab" class="cursor-pointer px-4 py-2 " onclick="changeTab('admin')">Admin Accounts</p>
        </div>

        <!-- Tab Content -->
        <div id="alumni-section" class="tab-content">
            @include('accounts.alumni-accounts')
        </div>

        <div id="admin-section" class="tab-content hidden">
            @include('accounts.admin-accounts')
        </div>
    </div>
</div>
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
    function searchUsers() {
        const query = document.getElementById('search').value.toLowerCase();
        const rows = document.querySelectorAll('#alumni-table-body tr');
        rows.forEach(row => {
            const fullname = row.cells[2].innerText.toLowerCase();
            const email = row.cells[3].innerText.toLowerCase();
            const username = row.cells[4].innerText.toLowerCase();
            const course = row.cells[6].innerText.toLowerCase();
            const batch = row.cells[7].innerText.toLowerCase();
            if (fullname.includes(query) || email.includes(query) || username.includes(query || course.includes(query) || batch.includes(query))) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function filterAccounts(status) {
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

    function editUser(userId) {
        console.log(`Edit user with ID: ${userId}`);
    }

    function deactivateUser(userId) {
        console.log(`Deactivate user with ID: ${userId}`);
    }

    function deleteUser(userId) {
        console.log(`Delete user with ID: ${userId}`);
    }

    function updateAlumniTable (account, index, status) {
        const table = document.getElementById('alumni-table-body');
        const template = `
            <tr class="border-t dark:border-gray-700" data-status="active">
                <td class="px-6 py-4 whitespace-nowrap text-sm ">${index + 1}</td>
                <td class="px-6 py-4 w-12 whitespace-nowrap text-sm">
                    <img class="h-12 m-auto w-12 rounded-full object-cover" src="{{asset('storage/profile/images')}}/${account.image ?? 'default.jpg'}" alt="User Image">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.alumni_information.first_name} ${account.alumni_information.middle_name ?? ''} ${account.alumni_information.last_name}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.email}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.username}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${status}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.alumni_information.course}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">${account.alumni_information.batch}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">2 days ago</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center h-full">
                        <button class="text-xs bg-blue-500 hover:bg-blue-600 py-1 px-2 rounded-lg" onclick="editUser(1)">Edit</button>
                        <button class="text-xs bg-yellow-500 hover:bg-yellow-600 py-1 px-2 rounded-lg" onclick="deactivateUser(1)">Deactivate</button>
                        <button class="text-xs bg-red-500 hover:bg-red-600  py-1 px-2 rounded-lg" onclick="deleteUser(1)">Delete</button>
                    </div>
                </td>
            </tr>
        `;
        table.innerHTML += template;
    }

    function getAccounts (accounts) {

        const table = document.getElementById('alumni-table-body');
        table.innerHTML = '';
        accounts.forEach((alumni, index) => {
            let status = 'for approval';
            if (alumni.approved_at) {
                if(alumni.alumni_information) {
                    status = 'active';
                } else {
                    status = 'inactive';
                }
            } else {
                if(alumni.disabled_at) {
                    status = 'disabled';
                } else {
                    if(alumni.rejected_at) {
                    status = 'rejected';
                } else {
                    status = 'for approval';
                }
                }
            }
            updateAlumniTable(alumni, index, status)
        });

    }

    getAccounts(@json($alumni_list))
</script>

@endsection
