<h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex justify-between items-center">
    <p>Members Approval</p>
</h2>

<div id=search class="flex mb-4 gap-4 items-center mt-4">
    <label for="search" class="text-SM text-gray-500">Search: </label>
    <input name="search" id="search" type="text" oninput="searchMembersApproval(event)" placeholder="Search members..." class="border rounded-lg p-2 w-full text-xs" />
</div>
<div id="filters" class="flex justify-between w-full sm:flex-col md:flex-row my-4">
    <div class="flex mb-4 gap-4 items-center">
        <p class="text-md">Filters:</p>
        <div class="relative">
            <button id="batch-filter-dropdown-btn" class="dropdown-btn bg-gray-200 text-gray-700 rounded-md px-4 py-2 inline-flex items-center text-xs">
                Batch Numbers
                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
            <div id="batch-filter-dropdown" class="dropdown absolute z-10 hidden bg-white border border-gray-300 rounded-md mt-1 w-48 shadow-lg">
                <div class="py-1">
                    @forelse ($batches as $batch)
                        <label class="flex items-center px-4 py-2 text-xs">
                            <input type="checkbox" onchange="filterMembersApproval(event)" value="{{$batch->batch}}" class="group-members-approval-batch-filter mr-2 text-sscr-red border-gray-300 focus:ring-0 hover:ring-0 active:ring-0" />
                            {{$batch->batch}}
                        </label>
                    @empty
                        <p>No batches found</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="relative">
            <button id="course-filter-dropdown-btn" class="dropdown-btn bg-gray-200 text-gray-700 rounded-md px-4 py-2 inline-flex items-center text-xs">
                Courses
                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
            <div id="course-filter-dropdown" class="dropdown absolute z-10 hidden bg-white border border-gray-300 rounded-md mt-1 w-48 shadow-lg">
                <div class="py-1">
                    @forelse ($courses as $course)
                        <label class="flex items-center px-4 py-2 text-xs">
                            <input type="checkbox" onchange="filterMembersApproval(event)" value="{{$course->course}}" class="group-members-approval-course-filter mr-2 text-sscr-red border-gray-300 focus:ring-0 hover:ring-0 active:ring-0" />
                            {{$course->course}}
                        </label>
                    @empty
                        <p>No courses found</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <a class="bg-sscr-red text-white rounded-md h-max py-2 px-4 inline-flex items-center text-xs cursor-pointer w-max" onclick="exportTable('group-members-approval-table-body')">Export Table</a>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full bg-white dark:bg-gray-800 shadow-md rounded-lg border border-gray-200 rounded">
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
        <tbody class="text-gray-700 dark:text-gray-300" id="group-members-approval-table-body">

        </tbody>
    </table>
</div>


