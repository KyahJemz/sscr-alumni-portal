<h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex justify-between items-center">
    <p>Admins</p>
</h2>

<div id=search class="flex mb-4 gap-4 items-center mt-4 w-full justify-between">
    <div class="flex-1 flex gap-4 items-center">
        <label for="search" class="text-SM text-gray-500">Search: </label>
        <input name="search" id="search" type="text" oninput="searchAdmins(event)" placeholder="Search admins..." class="border rounded-lg p-2 w-full text-xs" />
    </div>
    <a class="bg-sscr-red text-white rounded-md h-max py-2 px-4 inline-flex items-center text-xs cursor-pointer" onclick="exportTable('group-admins-table-body')">Export Table</a>
    <a class="bg-sscr-red text-white rounded-md h-max py-2 px-4 inline-flex items-center text-xs cursor-pointer" onclick="document.getElementById('add-admin-modal').classList.toggle('hidden')">New admin</a>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full bg-white shadow-md rounded-lg border border-gray-200 rounded">
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
        <tbody class="text-gray-700 dark:text-gray-300" id="group-admins-table-body">

        </tbody>
    </table>
</div>


