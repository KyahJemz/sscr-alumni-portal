@extends('master')

@section('content')

<div class="container mx-auto max-w-7xl sm:p-2 md:px-8 md:py-6 space-y-6">
    <div class="rounded-lg flex flex-col md:gap-6 sm:gap-2">
        <div class="flex flex-row gap-6 bg-white p-6 shadow-lg rounded-lg">
            <img src="{{ asset('storage/groups/images/' . $group->image ?? 'default.jpg') }}" alt="" class="sm:w-20 sm:h-20 md:w-48 md:h-48 rounded-lg" onerror="this.onerror=null;this.src='{{ asset('storage/groups/images/default.jpg') }}';">
            <div class="flex flex-col relative w-full">
                <p class="md:text-2xl sm:text-lg text-sscr-red font-bold">{{ $group->name }}</p>
                <p class="text-gray-900"> {{ $group->description }}</p>
                <div class="flex gap-4 absolute right-0 bottom-0">
                    @if($isAdmin | Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
                        <a href="{{ route('groups.edit', ['group' => $group->id]) }}" class="cursor-pointer px-4 py-2 bg-sscr-red text-white rounded-lg">Manage</a>
                    @else
                        @if($status === 'not a member')
                            <form action="{{ route('group-members.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="group_id" value="{{ $group->id }}">
                                <button type="submit" class="px-4 py-2 bg-sscr-red text-white rounded">Join Group</button>
                            </form>
                        @elseif($status === 'pending')
                            <form action="{{ route('group-members.destroy', ['groupMember' => $groupMember->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="px-4 py-2 bg-sscr-red text-white rounded">Cancel Request</button>
                                @if(session('status') && session('errors'))
                                    <p>{{ session('status') }} {{ session('errors') }}</p>
                                @endif
                            </form>
                        @endif
                    @endif
                    @if(!$isAdmin && !Auth::user()->role === 'cict_admin' && !Auth::user()->role === 'alumni_coordinator' || $status === 'member')
                        <a class="text-sscr-red cursor-pointer sm:block md:hidden" href="{{ route('groups.edit', ['group' => $group->id]) }}">About</a>
                    @endif
                </div>
            </div>
        </div>
        <div class=" pb-6 flex flex-row">
            <div class="overflow-hidden sm:rounded-lg max-w-2xl mx-auto space-y-4 flex-1 w-3/4">
                @if($isAdmin || Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator' || $status === 'member')
                <div class="bg-white p-4 text-gray-900 border border-gray-300 shadow-lg rounded-lg">
                    <form action="{{ route('api.group.posts.store', ['group' => $group->id]) }}" method="post" enctype="multipart/form-data" class="flex gap-4">
                        @csrf
                        @method('post')
                        <img src="{{ $user->image ? asset('storage/profile/images/' . $user->image) : asset('storage/profile/images/default.jpg') }}"
                            onerror="this.onerror=null;this.src='{{ asset('storage/profile/images/default.jpg') }}';"
                            alt=""
                            class="border border-gray-300 dark:border-gray-700 w-16 h-16 rounded-full bg-gray-200">
                        <div class="w-full space-y-2">
                            <div class="flex justify-between">
                                <select id="post-type-selector" name="type"
                                    class="text-xs font-light px-2 py-1 pr-8 cursor-pointer rounded">
                                    <option class="cursor-pointer" value="post">Create Post</option>
                                    <option class="cursor-pointer" value="announcement">Create Announcement</option>
                                    <option class="cursor-pointer" value="event">Create Event</option>
                                    <option class="cursor-pointer" value="news">Create News</option>
                                </select>
                                @if ($isAdmin || Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
                                    <a class="text-xs font-light px-2 py-1 rounded bg-sscr-red text-white shadow" href="{{ route('post-approvals.index', ['group' => $group->id]) }}">View aprovals</a>
                                @endif
                            </div>

                            <p class="text-xs font-light pb-2">Creating as:
                                {{ optional($user->alumniInformation)->getName() ??
                                    (optional($user->adminInformation)->getName() ?? $user->username) }}
                            </p>

                            <div id="post-form" class="w-full space-y-2">
                                <textarea placeholder="What's on your mind?" class="w-full p-2 rounded text-sm" name="content" id="" rows="3"></textarea>
                            </div>

                            <div id="news-announcement-form" class="w-full hidden space-y-2">
                                <input type="text" name="title" class="w-full p-2 rounded text-sm" placeholder="Title... *">
                                <textarea placeholder="What's on your mind? *" class="w-full p-2 rounded" name="description" id=""
                                    rows="3"></textarea>
                            </div>

                            <div id="event-form" class="w-full hidden space-y-2">
                                <input type="text" name="contributions" class="w-full p-2 rounded text-sm" placeholder="Contributions (optional)">
                                <input type="text" name="amount" class="w-full p-2 rounded text-sm" placeholder="Amount (optional)">
                                <input type="text" name="location" class="w-full p-2 rounded -mt-2 text-sm"
                                    placeholder="Event location (optional)">
                                <input type="text" name="url" class="w-full p-2 rounded -mt-2 text-sm"
                                    placeholder="Event url (converted to QR code, optional)">
                                <div class="w-full flex text-xs gap-2">
                                    <input type="datetime-local" name="startDate" id="startDate"
                                        class="text-xs cursor-pointer rounded p-2">
                                    <input type="datetime-local" name="endDate" id="endDate"
                                        class="text-xs cursor-pointer rounded p-2">
                                </div>
                            </div>

                            <div id="thumbnail-form" class="w-full hidden space-y-2">
                                <p class="">Thumbnail:</p>
                                <input id="thumbnail-upload" type="file" name="thumbnail"
                                    class="w-full p-2 rounded -mt-2 text-sm" placeholder="Thumbnail" accept="image/*">
                                <div id="thumbnail-preview"> </div>
                            </div>

                            <div class="w-full space-y-2">
                                <div id="images-preview" class="hidden w-full space-x-2 overflow-x-auto">
                                    <p id="images-count" class="text-xs cursor-pointer underline"
                                        onclick="document.getElementById('images-dropdown').classList.toggle('hidden');">
                                        images: </p>
                                    <div id="images-dropdown" class="flex items-center gap-2 hidden"></div>
                                    <button type="button" class="text-xs text-red-600 underline"
                                        onclick="clearMedia('image');">Remove all images</button>
                                </div>

                                <div id="videos-preview" class="hidden w-full space-x-2 overflow-x-auto">
                                    <p id="videos-count" class="text-xs cursor-pointer underline"
                                        onclick="document.getElementById('videos-dropdown').classList.toggle('hidden');">
                                        videos: </p>
                                    <div id="videos-dropdown" class="flex items-center gap-2 hidden"></div>
                                    <button type="button" class="text-xs text-red-600 underline"
                                        onclick="clearMedia('video');">Remove all videos</button>
                                </div>

                                <div id="files-preview" class="hidden w-full space-x-2 overflow-x-auto">
                                    <p id="files-count" class="text-xs cursor-pointer underline"
                                        onclick="document.getElementById('files-dropdown').classList.toggle('hidden');">
                                        files: </p>
                                    <div id="files-dropdown" class="flex items-center gap-2 hidden"></div>
                                    <button type="button" class="text-xs text-red-600 underline"
                                        onclick="clearMedia('file');">Remove all files</button>
                                </div>
                            </div>

                            <div class="flex justify-between gap-4 items-center">
                                <div class="flex gap-4">
                                    <input type="file" name="images[]" id="image-upload" class="hidden"
                                        accept="image/*" multiple>
                                    <input type="file" name="videos[]" id="video-upload" class="hidden"
                                        accept="video/*" multiple>
                                    <input type="file" name="files[]" id="file-upload" class="hidden"
                                        accept=".pdf,.doc,.docx,.txt" multiple>
                                    <button type="button" title="Add images"
                                        onclick="document.getElementById('image-upload').click();">@include('components.icons.image')</button>
                                    <button type="button" title="Add video"
                                        onclick="document.getElementById('video-upload').click();">@include('components.icons.video')</button>
                                    <button type="button" title="Add attachment"
                                        onclick="document.getElementById('file-upload').click();">@include('components.icons.attachment')</button>
                                </div>
                                <button title="Post"
                                    class="flex bg-sscr-red px-4 py-1 rounded-md text-white items-center">Post&nbsp;&nbsp;
                                    @include('components.icons.send')</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="posts-container">

                </div>
                @else
                    <div class="w-full bg-white border border-gray-300 shadow-lg rounded-lg p-6 shadow-lg">
                        @include('groups.manage.about')
                    </div>
                @endif
            </div>
            <div class="w-1/4 bg-white border border-gray-300 shadow-lg rounded-lg sm:hidden md:block">
                <p class="p-2 border-b border-gray-300 flex text-sscr-red font-bold flex-row justify-between text-md">
                    Founded {{ $group->created_at->format('F j, Y') }}
                    @if($isAdmin || Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator' || $status === 'member')
                        <a href="{{ route('groups.edit', ['group' => $group->id]) }}">@include('components.icons.more')</a>
                    @endif
                </p>
                <div class="flex flex-row w-full justify-around border-b border-gray-300">
                    <div class="flex flex-col items-center p-2 flex-1">
                        <p class="text-sscr-red font-bold text-xl">{{ (count($group_data['members'] ?? []) + count($group_data['admins'] ?? [])) ?? 0 }}</p>
                        <p class="font-light text-xs">Members</p>
                    </div>
                    <div class="flex flex-col items-center p-2 border-x border-gray-300 flex-1">
                        <p class="text-sscr-red font-bold text-xl">{{ (count($group_data['posts']  ?? [])) ?? 0 }}</p>
                        <p class="font-light text-xs">Posts</p>
                    </div>
                    <div class="flex flex-col items-center p-2 flex-1">
                        <p class="text-sscr-red font-bold text-xl">{{ (count($group_data['events']  ?? [])) ?? 0 }}</p>
                        <p class="font-light text-xs">Events</p>
                    </div>
                </div>
                <div class="w-full p-2 flex flex-col gap-2 border-b border-gray-300">
                    <p class="font-bold text-sscr-red">Admins ({{$group_data['admins'] ? count($group_data['admins']) : 0}})</p>
                    @forelse ($group_data['admins'] as $admin)

                        <div class="flex gap-2 items-center p-1 ">
                            <img class="w-8 h-8 rounded-full" src="{{ $admin->user->image ? asset('storage/profile/images/' . $admin->user->image) : asset('storage/profile/images/default.jpg') }}" alt="">
                            {{ $admin->user->alumniInformation->first_name ?? $admin->user->adminInformation->first_name }} {{ $admin->user->alumniInformation->last_name ?? $admin->user->adminInformation->last_name }}
                        </div>
                    @empty
                        <p>No Admins</p>
                    @endforelse
                </div>
                <div class="w-full p-2 flex flex-col gap-2">
                    <p class="font-bold text-sscr-red">Members ({{$group_data['members'] ? count($group_data['members']) : 0}})</p>
                    @forelse ($group_data['members'] as $member)
                        <div class="flex gap-2 items-center p-1 ">
                            <img class="w-8 h-8 rounded-full" src="{{ $member->user->image ? asset('storage/profile/images/' . $member->user->image) : asset('storage/profile/images/default.jpg') }}" alt="">
                            {{ $member->user->alumniInformation->first_name ?? $member->user->adminInformation->first_name }} {{ $member->user->alumniInformation->last_name ?? $member->user->adminInformation->last_name }}
                        </div>
                    @empty
                        <p>No Member</div>
                    @endforelse
            </div>
        </div>
    </div>
</div>

<div id="mediaModal" class="fixed inset-0 bg-sscr-red bg-opacity-80 flex items-center justify-center hidden z-50">
    <div class="relative w-full h-full flex items-center justify-center">
        <a
            id="downloadButton"
            href="#"
            download
            title="Download"
            class="absolute top-4 right-16 text-white bg-gray-800 hover:bg-gray-700 rounded-full w-10 h-10 flex items-center justify-center z-10"
        >
            ↓
        </a>
        <button
            title="Close"
            class="absolute top-4 right-4 text-white bg-gray-800 hover:bg-gray-700 rounded-full w-10 h-10 flex items-center justify-center z-10"
            onclick="closeImageModal()"
        >
            ✕
        </button>

        <button id="modalPrev" class="absolute left-4 text-white bg-gray-800 hover:bg-gray-700 rounded-full w-10 h-10 flex items-center justify-center z-10"><</button>
        <button id="modalNext" class="absolute right-4 text-white bg-gray-800 hover:bg-gray-700 rounded-full w-10 h-10 flex items-center justify-center z-10">></button>

        <div
            id="slideCounter"
            class="absolute bottom-4 text-white bg-gray-800 bg-opacity-75 rounded-md px-4 py-1 text-sm"
        >
        </div>

        <div id="modalContent" class="w-full h-full flex items-center justify-center"></div>
    </div>
</div>

@endsection

@section('scripts')
    <script>
        function handleFilePreview(input, fileType) {
            const imagesContainer = document.getElementById('images-preview');
            const videosContainer = document.getElementById('videos-preview');
            const filesContainer = document.getElementById('files-preview');
            const imagesDropdown = document.getElementById('images-dropdown');
            const videosDropdown = document.getElementById('videos-dropdown');
            const filesDropdown = document.getElementById('files-dropdown');
            const thumnailDropdown = document.getElementById('thumbnail-preview');
            const imagesCount = document.getElementById('images-count');
            const videosCount = document.getElementById('videos-count');
            const filesCount = document.getElementById('files-count');
            const files = input.files ?? [input.file];

            switch (fileType) {
                case 'image':
                    imagesContainer.classList.remove('hidden');
                    imagesDropdown.innerHTML = '';
                    imagesCount.innerHTML = 'Images: ' + Array.from(files).length;
                    break;
                case 'video':
                    videosContainer.classList.remove('hidden');
                    videosDropdown.innerHTML = '';
                    videosCount.innerHTML = 'Videos: ' + Array.from(files).length;
                    break;
                case 'file':
                    filesContainer.classList.remove('hidden');
                    filesDropdown.innerHTML = '';
                    filesCount.innerHTML = 'Files: ' + Array.from(files).length;
                    break;
                case 'thumbnail':
                    thumnailDropdown.innerHTML = '';
                    break;
            }

            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let mediaElement;
                    if (fileType === 'image') {
                        mediaElement =
                            `<span class="flex items-center"><img src="${e.target.result}" class="w-12 h-12 rounded-md object-cover"></span>`;
                        imagesDropdown.innerHTML += mediaElement;
                    } else if (fileType === 'video') {
                        mediaElement =
                            `<span class="flex items-center"><video controls class="w-12 h-12 rounded-md"><source src="${e.target.result}" type="${file.type}"></video></span>`;
                        videosDropdown.innerHTML += mediaElement;
                    } else if (fileType === 'file') {
                        mediaElement =
                            `<span class="flex items-center"><a href="${e.target.result}" class="text-blue-600 underline w-max" download>${file.name}</a></span>`;
                        filesDropdown.innerHTML += mediaElement;
                    } else if (fileType === 'thumbnail') {
                        mediaElement =
                            `<span class="flex items-center"><img src="${e.target.result}" class="w-12 h-12 rounded-md object-cover"></span>`;
                        thumnailDropdown.innerHTML += mediaElement;
                    }
                };
                reader.readAsDataURL(file);
            });
        }

        function clearMedia(fileType) {
            switch (fileType) {
                case 'image':
                    document.getElementById('image-upload').value = '';
                    document.getElementById('images-preview').classList.add('hidden');
                    document.getElementById('images-dropdown').innerHTML = '';
                    break;
                case 'video':
                    document.getElementById('video-upload').value = '';
                    document.getElementById('videos-preview').classList.add('hidden');
                    document.getElementById('videos-dropdown').innerHTML = '';
                    break;
                case 'file':
                    document.getElementById('file-upload').value = '';
                    document.getElementById('files-preview').classList.add('hidden');
                    document.getElementById('files-dropdown').innerHTML = '';
                    break;
            }
        }

        if (document.getElementById('image-upload')) {
            document.getElementById('image-upload').addEventListener('change', function() {
                handleFilePreview(this, 'image');
            });
        }

        if (document.getElementById('video-upload')) {
            document.getElementById('video-upload').addEventListener('change', function() {
                handleFilePreview(this, 'video');
            });
        }

        if (document.getElementById('file-upload')) {
            document.getElementById('file-upload').addEventListener('change', function() {
                handleFilePreview(this, 'file');
            });
        }

        if (document.getElementById('thumbnail-upload')) {
            document.getElementById('thumbnail-upload').addEventListener('change', function() {
                handleFilePreview(this, 'thumbnail');
            });
        }

        function changePostType(e) {
            const postForm = document.getElementById('post-form');
            const eventForm = document.getElementById('event-form');
            const newsAnnouncementForm = document.getElementById('news-announcement-form');
            const thumbnailForm = document.getElementById('thumbnail-form');

            postForm.classList.add('hidden');
            eventForm.classList.add('hidden');
            newsAnnouncementForm.classList.add('hidden');
            thumbnailForm.classList.add('hidden');

            switch (e.target.value) {
                case 'post':
                    postForm.classList.remove('hidden');
                    break;
                case 'news':
                case 'announcement':
                    newsAnnouncementForm.classList.remove('hidden');
                    thumbnailForm.classList.remove('hidden');
                    break;
                case 'event':
                    eventForm.classList.remove('hidden');
                    newsAnnouncementForm.classList.remove('hidden');
                    thumbnailForm.classList.remove('hidden');
                    break;
                default:
                    break;
            }
        }

        if (document.getElementById('post-type-selector')) {
            document.getElementById('post-type-selector').addEventListener('change', changePostType);
        }
    </script>

    <script>
        function openPostOptions(postId) {
            const optionsElement = document.getElementById(`post-options-${postId}`);
            optionsElement.classList.toggle('hidden');
        }

        function deletePostConfirmation(postId) {
            confirmation('Are you sure you want to delete this post?', () => deletePost(postId));
        }

        async function deletePost(postId) {
            const formData = new FormData();
            formData.append('post_id', postId);
            formData.append("_method", "DELETE");
            const url = `/posts/${postId}`;
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
                getPosts();
            } catch (error) {
                alertModal(error.message);
                console.error(error.message);
            }
        }
    </script>

    <script>
        function PostTemplate(post) {
            const userHasLiked = post.likes.some(like => like.liked_by === +"{{ Auth::user()->id }}");

            let sliderCount = 0;
            let sliderPosition = 0;

            const postFullName =
                    (post.posted_by.alumni_information?.first_name ?? post.posted_by.admin_information?.first_name) +
                ' ' +
                    (post.posted_by.alumni_information?.last_name ?? post.posted_by.admin_information?.last_name);

            const userFullName = "{{ optional($user->alumni_information)->first_name ?? optional($user->admin_information)->first_name }} {{ optional($user->alumni_information)->last_name ?? optional($user->admin_information)->last_name }}";

            const type = `${post.type.charAt(0).toUpperCase() + post.type.slice(1)} on ${getHumanReadableDate(new Date(post.created_at))}`;
            const hrs = getTimeAgo(new Date(post.approved_at ?? post.created_at));

            let imageStrings = "";
            let videoStrings = "";
            const images = ((post.videos && Array.isArray(JSON.parse(post.videos)) && JSON.parse(post.videos).length > 0) ||
                    (post.images && Array.isArray(JSON.parse(post.images)) && JSON.parse(post.images).length > 0))  ||
                    (post.event && post.event.thumbnail)  ||
                    (post.news && post.news.thumbnail)  ||
                    (post.announcement && post.announcement.thumbnail) ? `

                                ${post.event && post.event.thumbnail ? (() => {
                                    sliderCount++;
                                    imageStrings=imageStrings+`{{ asset('storage/posts/thumbnails') }}/${post.event.thumbnail}|`;
                                    return `
                                        <div class="duration-700 ease-in-out flex items-center justify-center w-full h-full" data-carousel-item>
                                            <img src="{{ asset('storage/posts/thumbnails') }}/${post.event.thumbnail}" class="max-w-full max-h-full object-cover rounded-md" alt="Post Image"
                                            >
                                        </div>`;
                                })() : ''}

                                ${post.news && post.news.thumbnail ? (() => {
                                    sliderCount++;
                                    imageStrings=imageStrings+`{{ asset('storage/posts/thumbnails') }}/${post.news.thumbnail}|`;
                                    return `
                                        <div class="duration-700 ease-in-out flex items-center justify-center w-full h-full" data-carousel-item>
                                            <img src="{{ asset('storage/posts/thumbnails') }}/${post.news.thumbnail}" class="max-w-full max-h-full object-cover rounded-md" alt="Post Image"
                                            >
                                        </div>`;
                                })() : ''}

                                ${post.announcement && post.announcement.thumbnail ? (() => {
                                    sliderCount++;
                                    imageStrings=imageStrings+`{{ asset('storage/posts/thumbnails') }}/${post.announcement.thumbnail}|`;
                                    return `
                                        <div class="duration-700 ease-in-out flex items-center justify-center w-full h-full" data-carousel-item>
                                            <img src="{{ asset('storage/posts/thumbnails') }}/${post.announcement.thumbnail}" class="max-w-full max-h-full object-cover rounded-md" alt="Post Image"
                                            >
                                        </div>`;
                                })() : ''}

                                ${post.videos && Array.isArray(JSON.parse(post.videos)) ?
                                    JSON.parse(post.videos).map(video => {
                                        sliderCount++;
                                        videoStrings=videoStrings+`{{ asset('storage/posts/videos') }}/${video}|`;
                                        return `
                                            <div class="duration-700 ease-in-out flex items-center justify-center w-full h-full" data-carousel-item>
                                                <video controls class="max-w-full max-h-full rounded-md"
                                                >
                                                    <source src="{{ asset('storage/posts/videos') }}/${video}" type="video/mp4">
                                                </video>
                                            </div>`;
                                    }).join('')
                                : ''}

                                ${post.images && Array.isArray(JSON.parse(post.images)) ?
                                    JSON.parse(post.images).map(image => {
                                        sliderCount++;
                                        imageStrings=imageStrings+`{{ asset('storage/posts/images') }}/${image}|`;
                                        return `
                                            <div class="duration-700 ease-in-out flex items-center justify-center w-full h-full" data-carousel-item>
                                                <img src="{{ asset('storage/posts/images') }}/${image}" class="max-w-full max-h-full object-cover rounded-md" alt="Post Image"
                                               >
                                            </div>`;
                                    }).join('')
                                : ''}

                                ${post.event && post.event.url ? (() => {
                                    sliderCount++;
                                    return `
                                        <div id="qr-code-container-${post.id}" class="duration-700 ease-in-out flex items-center justify-center w-full h-full" data-carousel-item></div>
                                    `;
                                })() : ''}

                ` : '';

            const files = post.files && Array.isArray(JSON.parse(post.files)) ? `
                <div class="flex flex-wrap gap-2 mt-4">
                    ${JSON.parse(post.files).map(file => `
                        <a href="{{ asset('storage/posts/files') }}/${file}" class="text-blue-600 underline flex items-center gap-2" download>
                            @include('components.icons.document')
                            <p class="text-sm font-light">${file}</p>
                        </a>
                    `).join('')}
                </div>
            ` : '';

            const likeSection = `
                <div class="flex justify-around items-center mt-4 text-gray-700 border-y-2 border-gray-300 py-2 w-full">
                    ${userHasLiked ? `
                        <form onsubmit="deleteLike(event)" class="flex items-center gap-2 text-sscr-red">
                            <input type="hidden" name="post_id" value="${post.id}">
                            <button type="submit" class="like">@include('components.icons.heart-filled')</button>
                            <a href="/group/{{$group->id}}/posts/${post.id}" class="text-sm hover:text-sscr-red text-gray-600 hover:underline">${post.likes.length > 1 ? "you and " + (post.likes.length - 1) + " others" : "you"} liked</a>
                        </form>
                    ` : `
                        <form onsubmit="sendLike(event)" class="flex items-center gap-2 text-sscr-red">
                            <input type="hidden" name="post_id" value="${post.id}">
                            <button type="submit" class="like">@include('components.icons.heart')</button>
                            <a class="text-sm hover:text-sscr-red text-gray-600 hover:underline">${post.likes.length} Likes</a>
                        </form>
                    `}
                    <a class="flex items-center gap-2 text-sscr-red text-sm" href="/group/{{$group->id}}/posts/${post.id}">
                        @include('components.icons.comment')
                        <span class="text-sm hover:text-sscr-red text-gray-600 hover:underline">${post.comments.length} Comments</span>
                    </a>
                </div>
            `;

            const commentSection = `
                <div class="mt-4 space-y-2">
                    <div class="bg-gray-100 p-2 rounded-md shadow-md flex gap-2 items-start">
                        <img src="{{ asset('storage/profile/images/' . ($user->image ?? 'default.jpg')) }}" alt="Profile Image" class="w-8 h-8 rounded-full object-cover bg-gray-200">
                        <div class="flex-1">
                            <p class="text-sm font-bold mb-1">${userFullName}</p>
                            <form onsubmit="sendComment(event)" class="flex flex-row gap-2 content-center">
                                <textarea name="comment" class="w-full p-2 text-xs border border-gray-300 rounded-md" rows="2" placeholder="Add a comment..."></textarea>
                                <input type="hidden" name="post_id" value="${post.id}">
                                <button type="submit" class="bg-sscr-red text-white px-2 py-1 rounded-md mt-2 text-nowrap">Send</button>
                            </form>
                        </div>
                    </div>
                    ${post.comments.slice(-2).map(comment => `
                        <div class="bg-gray-100 p-2 rounded-md mb-2 flex gap-2 items-start shadow-md">
                            <img src="{{ asset('storage/profile/images/') }}/${comment.user.image || 'default.jpg'}" alt="Profile Image" class="w-8 h-8 rounded-full object-cover bg-gray-200">
                            <div class="flex-1 relative">
                                <p class="text-sm font-bold">${(comment.user.alumni_information?.first_name ?? comment.user.admin_information?.first_name) + ' ' + (comment.user.alumni_information?.last_name ?? comment.user.admin_information?.last_name)}</p>
                                <p class="text-xs font-light">${comment.content.replace(/\n/g, '<br>')}</p>
                                <p class="text-xs text-gray-400">${getTimeAgo(new Date(comment.created_at))}</p>
                                ${comment.user.id === +"{{Auth::user()->id}}" || "{{Auth::user()->role}}" === 'cict_admin' || "{{Auth::user()->role}}" === 'alumni_coordinator' ? `
                                    <button class="absolute bottom-0 right-0 text-xs text-gray-400 hover:text-sscr-red" type="button" onclick="deleteCommentConfirmation(${comment.id})">Delete Comment</button>
                                ` : ''}
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;

            const template = `
                <div class="bg-white p-4 text-gray-900 border border-gray-300 shadow-lg rounded-lg mb-6">
                    <div class="flex gap-4 border-b-2 border-gray-300 mb-4 pb-4 relative">
                        <img src="{{ asset('storage/profile/images') }}/${post.posted_by.image ?? 'default.jpg'}"
                            alt="Profile Image"
                            class="border border-gray-300 dark:border-gray-700 w-12 h-12 rounded-full bg-gray-200">
                        <div class="flex-1">
                            <p class="text-md font-bold">${postFullName}</p>
                            <p class="text-xs font-light">${type}</p>
                            <p class="text-xs font-light">${hrs}</p>
                        </div>
                        ${post.posted_by.id === +"{{Auth::user()->id}}" || "{{Auth::user()->role}}" === 'cict_admin' || "{{Auth::user()->role}}" === 'alumni_coordinator' ? `
                            <button class="text-sscr-red absolute top-0 right-0" onclick="openPostOptions(${post.id})">
                                @include('components.icons.more')
                            </button>
                            <div class="hidden absolute top-7 right-0 border border-gray-300 dark:border-gray-700 rounded-md px-4 py-2 space-y-2 bg-white"
                                id="post-options-${post.id}">
                                <a href="/group/{{$group->id}}/posts/${post.id}/edit" class="text-sm font-light cursor-pointer">Edit</a>
                                <div onclick="deletePostConfirmation(${post.id})" class="text-sm font-light cursor-pointer">Delete</div>
                            </div>
                        ` : ''}
                    </div>

                    ${post?.content ? `<div class="text-sm font-light mb-4">${post?.content ? nl2br(convert_links_to_anchor(post.content)) : ''}</div>` : ""}

                    ${post?.event ? `
                        <div class="bg-gray-100 p-4 border border-gray-300 rounded-lg flex flex-row gap-4 items-center">
                            @include('components.icons.calendar')
                            <div>
                                <div class="text-md font-bold text-sscr-red">${getHumanReadableDate(new Date(post.event.start_date))}${post?.event?.end_date ? ' to ' + getHumanReadableDate(new Date(post.event.end_date)) : ''}</div>
                                <div class="text-md text-gray-500 font-semibold">${post.event.title}</div>
                                ${post.event.location
                                    ? `<div class="text-sm text-gray-500 ">${post.event.location}</div>`
                                    : ''}
                            </div>
                        </div>
                        <div class="text-md text-gray-700 font-light my-4 ">
                            ${post.event ? nl2br(convert_links_to_anchor(post.event.description)) : ''}
                        </div>
                        ${post.event?.contribution || post.event?.amount ? `
                            <div class="text-sm text-gray-700 my-4 font-bold">Notes:
                            ${post.event?.contribution ? `
                                <div class="text-sm text-gray-700 font-light px-4">
                                    Contributions: ${post.event.contribution}
                                </div>
                            ` : ""}
                            ${post.event?.amount ? `
                                <div class="text-sm text-gray-700 font-light px-4">
                                    Amount: ${post.event.amount}
                                </div>
                            </div>` : ""}
                        ` : ""}
                    ` : ""}

                    ${post?.announcement || post?.news ? `
                        <div class="text-md font-bold mb-2">
                            ${post.announcement ? post.announcement.title.replace(/\n/g, '<br>') : ''}
                            ${post.news ? post.news.title.replace(/\n/g, '<br>') : ''}
                        </div>
                    `: ""}

                    ${post?.announcement || post?.news ? `
                        <div class="text-sm font-light mb-2">
                            ${post.announcement ? nl2br(convert_links_to_anchor(post.announcement.description)) : ''}
                            ${post.news ? nl2br(convert_links_to_anchor(post.news.description)) : ''}
                        </div>
                    `: ""}

                    ${((post.videos && Array.isArray(JSON.parse(post.videos)) && JSON.parse(post.videos).length > 0) ||
                    (post.images && Array.isArray(JSON.parse(post.images)) && JSON.parse(post.images).length > 0))  ||
                    (post.event && post.event.thumbnail)  ||
                    (post.news && post.news.thumbnail)  ||
                    (post.announcement && post.announcement.thumbnail) ? `
                        <div class="space-y-4">
                            <div id="media-slider-${post.id}" class="relative w-full" data-carousel="slide">
                                <div class="relative h-56 overflow-hidden rounded-lg cursor-pointer" onclick="openCarouselModal('${imageStrings}|-|${videoStrings}')">
                                    ${images}
                                </div>
                                ${sliderCount > 1 ? `
                                    <button type="button" class="absolute top-0 start-0 z-1 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                            <svg class="w-4 h-4 text-sscr-red" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                            </svg>
                                            <span class="sr-only text-sscr-red">Previous</span>
                                        </span>
                                    </button>
                                    <button type="button" class="absolute top-0 end-0 z-1 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                            <svg class="w-4 h-4 text-sscr-red" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                            </svg>
                                            <span class="sr-only text-sscr-red">Next</span>
                                        </span>
                                    </button>
                                    <div class="absolute bottom-4 right-4 bg-white/50 text-black px-2 py-1 rounded-lg text-sm">
                                        <span id="slider-position-${post.id}">1</span> / ${sliderCount}
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    ` : ""}

                    ${post.files !== '[]' ? files : ""}

                    ${likeSection}

                    ${commentSection}

                </div>
            `;

            return template;
        }

        async function getPosts() {
            const postsContainer = document.getElementById('posts-container');
            const url = "{{ route('api.group.posts.index', ['group'=>$group->id]) }}";

            try {
                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const json = await response.json();

                postsContainer.innerHTML = '';

                json.data.posts.forEach(post => {
                    const postElement = PostTemplate(post);
                    postsContainer.innerHTML += postElement;
                    if (post.event && post.event.url) {
                        const qrContainer = document.getElementById(`qr-code-container-${post.id}`);
                        console.log(post.event.url)
                        console.log(qrContainer)
                        setTimeout(() => {
                            const qrContainer = document.getElementById(`qr-code-container-${post.id}`);
                            if (qrContainer) {
                                qrContainer.innerHTML = '';
                                new QRCode(qrContainer, {
                                    text: post.event.url,
                                    width: 200,
                                    height: 200,
                                    colorDark: "#000000",
                                    colorLight: "#ffffff",
                                    correctLevel: QRCode.CorrectLevel.H
                                });
                            } else {
                                console.error(`QR code container not found for post ID ${post.id}`);
                            }
                        }, 100);
                    }
                });
                addEvents();
            } catch (error) {
                console.error('Error fetching posts:', error.message);
            }
        }

        function addEvents() {
            document.querySelectorAll('[data-carousel="slide"]').forEach(slider => {
                const prevButton = slider.querySelector('[data-carousel-prev]');
                const nextButton = slider.querySelector('[data-carousel-next]');
                const items = slider.querySelectorAll('[data-carousel-item]');
                const progressIndicator = slider.querySelector(`[id^="slider-position"]`);
                let currentIndex = 0;

                if (!items || items.length === 0) return;

                const showItem = (index) => {
                    items.forEach((item, i) => {
                        item.classList.toggle('hidden', i !== index);
                    });
                    if (progressIndicator) {
                        progressIndicator.textContent = index + 1;
                    }
                };

                if (prevButton) {
                    prevButton.addEventListener('click', () => {
                        currentIndex = (currentIndex > 0) ? currentIndex - 1 : items.length - 1;
                        showItem(currentIndex);
                    });
                }

                if (nextButton) {
                    nextButton.addEventListener('click', () => {
                        currentIndex = (currentIndex < items.length - 1) ? currentIndex + 1 : 0;
                        showItem(currentIndex);
                    });
                }

                showItem(currentIndex);
            });
        }

        async function sendComment(e) {
            e.preventDefault();
            const commentBox = e.target.querySelector('textarea');
            const formData = new FormData(e.target);
            const url = "{{ route('api.comment.store') }}";
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
                commentBox.value = '';
                alertModal(json.message);
                getPosts();
            } catch (error) {
                alertModal(error.message);
                console.error(error.message);
            }
        }

        function deleteCommentConfirmation(commentId) {
            confirmation('Are you sure you want to delete this comment?', () => deleteComment(commentId));
        }

        async function deleteComment(commentId) {
            const formData = new FormData();
            formData.append("_method", "DELETE");
            formData.append("comment_id", commentId);
            const url = "/api/comment/";
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
                getPosts();
            } catch (error) {
                alertModal(error.message);
                console.error(error.message);
            }
        }

        async function sendLike(e) {
            e.preventDefault();
            const likeBox = e.target.querySelector('.like');
            const formData = new FormData(e.target);
            const url = "{{ route('api.like.store') }}";
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
                likeBox.innerHTML = `@include('components.icons.heart-filled')`;
                getPosts();
            } catch (error) {
                console.error(error.message);
            }
        }

        async function deleteLike(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            formData.append("_method", "DELETE");
            const url = "{{ route('api.like.destroy') }}";
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
                getPosts();
            } catch (error) {
                console.error(error.message);
            }
        }

        getPosts()
    </script>

    <script>
        let currentModalIndex = 0;

        function openCarouselModal(contents) {
            const passedData = contents.split('|-|');
            const passedImages = passedData[0] ? passedData[0].split('|').filter((url) => url.trim() !== '') : [];
            const passedVideos = passedData[1] ? passedData[1].split('|').filter((url) => url.trim() !== '') : [];

            const carouselData = [
                ...passedImages.map((image) => [image, 'image']),
                ...passedVideos.map((video) => [video, 'video']),
            ];

            if (!carouselData || carouselData.length === 0) {
                console.error("No contents available for this modal.");
                return;
            }

            const modal = document.getElementById('mediaModal');
            const modalContent = document.getElementById('modalContent');
            const prevButton = document.getElementById('modalPrev');
            const nextButton = document.getElementById('modalNext');
            const slideCounter = document.getElementById('slideCounter');

            currentModalIndex = 0;
            renderModalContent(carouselData[currentModalIndex], modalContent);

            slideCounter.textContent = `${currentModalIndex + 1} / ${carouselData.length}`;

            if (carouselData.length === 1) {
                prevButton.classList.add('hidden');
                nextButton.classList.add('hidden');
            } else {
                prevButton.classList.remove('hidden');
                nextButton.classList.remove('hidden');
            }

            prevButton.onclick = () => navigateCarousel(-1, carouselData, modalContent, slideCounter);
            nextButton.onclick = () => navigateCarousel(1, carouselData, modalContent, slideCounter);

            modal.classList.remove('hidden');
        }

        function closeImageModal() {
            const modal = document.getElementById('mediaModal');
            modal.classList.add('hidden');
        }

        function navigateCarousel(direction, carouselData, modalContent, slideCounter) {
            currentModalIndex = (currentModalIndex + direction + carouselData.length) % carouselData.length;
            renderModalContent(carouselData[currentModalIndex], modalContent);

            slideCounter.textContent = `${currentModalIndex + 1} / ${carouselData.length}`;
        }

        function renderModalContent(content, modalContent) {
            const [src, type] = content;

            if (type === 'image') {
                modalContent.innerHTML = `<img src="${src}" class="max-w-full max-h-[70vh] rounded-md">`;
            } else if (type === 'video') {
                modalContent.innerHTML = `
                    <video controls class="max-w-full max-h-[70vh] rounded-md">
                        <source src="${src}" type="video/mp4">
                    </video>`;
            }

            const downloadButton = document.getElementById('downloadButton');
            downloadButton.href = src;
        }

    </script>
@endsection
