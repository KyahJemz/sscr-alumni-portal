<div class="flex mb-4 gap-4 items-center">
    <input type="text" oninput="searchAdmin(event)" placeholder="Search admin..." class="border rounded-lg p-2 w-full text-xs" />
    <p class="text-md">Filters:</p>
    <div class="flex gap-2">
        <button onclick="filterAdminAccounts(event,'all')" class="whitespace-nowrap text-sm bg-sscr-red text-white bg-gray-200 hover:bg-sscr-red/50 hover:text-white py-1 px-3 rounded transition duration-150 ease-in-out">All</button>
        <button onclick="filterAdminAccounts(event,'deactivated')" class="whitespace-nowrap text-sm bg-gray-200 hover:bg-sscr-red/50 hover:text-white py-1 px-3 rounded transition duration-150 ease-in-out">Deactivated</button>
    </div>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full bg-white dark:bg-gray-800 shadow-md rounded-lg border border-gray-200 rounded">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">#</th>
                <th class="px-4 py-2 w-12 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Profile Image</th>
                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Fullname</th>
                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Email</th>
                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Username</th>
                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Status</th>
                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">department</th>
                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Role</th>
                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Last Active</th>
                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 dark:text-gray-300" id="admin-table-body">

        </tbody>
    </table>
</div>
