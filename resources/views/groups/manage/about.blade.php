<h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex justify-between items-center mb-4">
    <p>About</p>
    <a onclick="document.getElementById('update-group-modal').classList.toggle('hidden');" class="text-gray-800 font-bold py-2 px-4 rounded cursor-pointer">
        @include('components.icons.edit')
    </a>
</h2>

<div class="">
    <div class="md:col-span-2 pt-2 mt-4">
        <p class="text-md font-bold text-gray-700">Information</p>
        <p class="text-gray-600">Name: {{ $group->name }}</p>
        <p class="text-gray-600">Description: {{ $group->description }}</p>
    </div>

    <div class="md:col-span-2 pt-2 mt-4">
        <p class="text-md font-bold text-gray-700">History</p>
        <p class="text-gray-600">Founded: {{ $group->created_at->format('F j, Y') }}</p>
        <p class="text-gray-600">Last Modified: {{ $group->updated_at->format('F j, Y') }}</p>
    </div>

    <div class="md:col-span-2 pt-2 mt-4">
        <p class="text-md font-bold text-gray-700">Summary</p>
        <div class="grid grid-cols-2 gap-4 mt-2">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-700 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12a4 4 0 01-8 0 4 4 0 018 0zm0 0a4 4 0 004 4h0a4 4 0 000-8h0a4 4 0 00-4 4zm5 0a4 4 0 014 4h0a4 4 0 000-8h0a4 4 0 00-4 4z" />
                </svg>
                <p class="text-gray-600">Total Members: {{ $group->group_admins->whereNull('deleted_at')->count() + $group->group_members->whereNotNull('approved_at')->whereNull('deleted_at')->count() }}</p>
            </div>

            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-700 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v5a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 0v5m0 0h16M3 9v11a1 1 0 001 1h16a1 1 0 001-1V9m-9 4v4" />
                </svg>
                <p class="text-gray-600">Total Posts: {{ $group->posts->where('type', 'post')->whereNull('deleted_at')->whereNotNull('approved_at')->count() }}</p>
            </div>

            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-700 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2h6v2a4 4 0 010 8h-6a4 4 0 01-6 0v-2h16v2" />
                </svg>
                <p class="text-gray-600">Total Events: {{ $group->posts->where('type', 'event')->whereNull('deleted_at')->whereNotNull('approved_at')->count() }}</p>
            </div>

            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-700 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20a4 4 0 01-4 4H7a4 4 0 01-4-4V10a4 4 0 014-4h6a4 4 0 014 4v10z" />
                </svg>
                <p class="text-gray-600">Total News: {{ $group->posts->where('type', 'news')->whereNull('deleted_at')->whereNotNull('approved_at')->count() }}</p>
            </div>

            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-700 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12l4-4m0 0l4 4m-4-4v12" />
                </svg>
                <p class="text-gray-600">Total Announcements: {{ $group->posts->where('type', 'announcement')->whereNull('deleted_at')->whereNotNull('approved_at')->count() }}</p>
            </div>
        </div>
    </div>
</div>

<div id="update-group-modal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 z-50">
    <div class="fixed inset-0 bg-black opacity-50"></div>
    <div id="update-group-form" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <form action="{{ route('api.groups.update', ['group' => $group->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4 flex justify-between items-center">
                Update Form
                <button type="button" onclick="document.getElementById('update-group-modal').classList.toggle('hidden');" class="text-sscr-red">
                    @include('components.icons.x')
                </button>
            </h2>

            <div class="flex flex-row gap-4">
                <div class="flex w-max flex-col items-start">
                    <img id="image-preview" src="{{ asset('storage/groups/images/' . $group->image ?? 'default.jpg') }}" onerror="this.onerror=null;this.src='{{ asset('storage/groups/images/default.jpg') }}';" alt="Group Image" class="rounded-md w-32 h-32 border border-gray-300 dark:border-gray-700 mb-4">
                    <input id="image-upload" class="hidden block cursor-pointer w-32" type="file" name="image" accept="image/png, image/jpeg" />
                    <button type="button" class="flex" onclick="document.getElementById('image-upload').click();">@include('components.icons.image')&nbsp;
                        Upload Image
                    </button>
                </div>

                <div class="flex flex-col flex-1 space-y-4">
                    <div>
                        <label for="name" class="text-sm font-semibold text-gray-700 dark:text-gray-200">Club Name</label>
                        <input id="name" placeholder="{{ $group->name }}" value="{{ $group->name }}"  type="text" name="name" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm" required>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <label for="description" class="text-sm font-semibold text-gray-700 dark:text-gray-200">Description</label>
                <textarea id="description" name="description" placeholder="{{ $group->description }}" required class="w-full p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-100" rows="4" placeholder="Enter club description...">{{ $group->description }}</textarea>
            </div>

            <div class="mt-6">
                <input type="submit" class="w-full bg-sscr-red text-white font-light py-2 px-4 rounded-md cursor-pointer hover:bg-red-600 transition duration-150" value="Update">
            </div>
        </form>
    </div>
</div>
