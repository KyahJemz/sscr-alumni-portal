@extends('master')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg max-w-2xl mx-auto space-y-4">
                <div class="bg-white p-4 text-gray-900 border border-gray-200 shadow-md rounded-md">
                    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data" class="flex gap-4">
                        @csrf
                        @method('post')

                        <img src="{{ $user->image ? asset('storage/profile/images/' . $user->image) : asset('storage/profile/images/default.jpg') }}"
                            onerror="this.onerror=null;this.src='{{ asset('storage/profile/images/default.jpg') }}';"
                            alt=""
                            class="border border-gray-300 dark:border-gray-700 w-16 h-16 rounded-full bg-gray-200">
                        <div class="w-full space-y-2">
                            <select id="post-type-selector" name="type"
                                class="text-xs font-light px-2 py-1 pr-8 cursor-pointer rounded">
                                <option class="cursor-pointer" value="post">Create Post</option>
                                <option class="cursor-pointer" value="announcement">Create Announcement</option>
                                <option class="cursor-pointer" value="event">Create Event</option>
                                <option class="cursor-pointer" value="news">Create News</option>
                            </select>
                            <p class="text-xs font-light pb-2">Creating as: {{ $user->alumniInformation->getFullName() ?? $user->adminInformation->getFullName() }}</p>

                            <div id="post-form" class="w-full space-y-2">
                                <textarea placeholder="What's on your mind?" class="w-full p-2 rounded" name="content" id="" rows="3"></textarea>
                            </div>

                            <div id="news-announcement-form" class="w-full hidden space-y-2">
                                <input type="text" name="title" class="w-full p-2 rounded" placeholder="Title... *">
                                <textarea placeholder="What's on your mind? *" class="w-full p-2 rounded" name="description" id=""
                                    rows="3"></textarea>
                            </div>

                            <div id="event-form" class="w-full hidden space-y-2">
                                <input type="text" name="location" class="w-full p-2 rounded -mt-2"
                                    placeholder="Event location...">
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
                                    class="w-full p-2 rounded -mt-2" placeholder="Thumbnail" accept="image/*">
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


                @forelse ($posts as $post)
                    <div class="bg-white p-4 text-gray-900 border border-gray-200 shadow-md rounded-md">
                        <div class="flex gap-4 border-b-2 mb-2 pb-2 relative">
                            <img src="{{ asset('storage/profile/images/' . $post->postedBy->image) ?? asset('storage/profile/images/default.png') }}" alt="" class="border border-gray-300 dark:border-gray-700 w-16 h-16 rounded-full bg-gray-200">
                            <div>
                                <p class="text-md font-bold">{{ $post->postedBy->alumniInformation->getFullName() ?? $post->postedBy->adminInformation->getFullName() }}</p>
                                <p class="text-xs font-light">{{ ucfirst($post->type) . " on " . $post->created_at->format('M. j, Y \a\t g:ia') }}</p>
                                <p class="text-xs font-light">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                            <button class="text-sscr-red absolute top-0 right-0" onclick="openPostOptions({{ $post->id }})">@include('components.icons.more')</button>
                            <div class="absolute top-7 right-0 border border-gray-300 dark:border-gray-700 rounded-m-2 px-4 py-2 space-y-2 bg-white rounded-md" id="post-options-{{ $post->id }}">
                                <div class="text-sm font-light course-pointer">Delete</div>
                                <div class="text-sm font-light course-pointer">Edit</div>
                            </div>
                        </div>

                        <p class="text-sm font-light mb-2">{{ $post->content }}</p>

                        <div class="flex gap-2 flex-col">
                            @if ($post->videos && is_array(json_decode($post->videos)))
                                @foreach (json_decode($post->videos) as $video)
                                    <video controls class="w-32 h-32 rounded-md"><source src="{{ asset('storage/posts/videos/' . $video) }}" type="video/mp4"></video>
                                @endforeach
                            @else
                            @endif
                            @if ($post->images && is_array(json_decode($post->images)))
                                @foreach (json_decode($post->images) as $image)
                                    <img src="{{ asset('storage/posts/images/' . $image) }}" class="w-32 h-32 rounded-md object-cover" alt="">
                                @endforeach
                            @else
                            @endif
                        </div>

                        <div class="flex gap-2 flex-col">
                            @if ($post->files && is_array(json_decode($post->files)))
                                @foreach (json_decode($post->files) as $file)
                                    <a href="{{ asset('storage/posts/files/' . $file) }}" class="text-blue-600 underline w-max flex items-center gap-2" download>
                                        @include('components.icons.document')
                                        <p class="text-sm font-light">{{ $file }}</p>
                                    </a>
                                @endforeach
                            @else
                            @endif
                        </div>

                        <div class="text-sscr-red flex gap-2">
                            @include('components.icons.heart-filled')
                            <div class="text-sm font-light text-gray-500 flex gap-2">
                                {#} Comments @include('components.icons.comment')
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No posts</p>
                @endforelse



<div id="gallery" class="relative w-full" data-carousel="slide">
    <!-- Carousel wrapper -->
    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
         <!-- Item 1 -->
        <div class=" duration-700 ease-in-out" data-carousel-item>
            <img src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg" class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="">
        </div>
        <!-- Item 2 -->
        <div class="duration-700 ease-in-out" data-carousel-item="active">
            <img src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-2.jpg" class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="">
        </div>
        <!-- Item 3 -->
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg" class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="">
        </div>
        <!-- Item 4 -->
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-4.jpg" class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="">
        </div>
        <!-- Item 5 -->
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-5.jpg" class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="">
        </div>
    </div>
    <!-- Slider controls -->
    <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
            </svg>
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
            <span class="sr-only">Next</span>
        </span>
    </button>
</div>

            </div>
        </div>
    </div>

    <script></script>
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

        document.getElementById('image-upload').addEventListener('change', function() {
            handleFilePreview(this, 'image');
        });

        document.getElementById('video-upload').addEventListener('change', function() {
            handleFilePreview(this, 'video');
        });

        document.getElementById('file-upload').addEventListener('change', function() {
            handleFilePreview(this, 'file');
        });

        document.getElementById('thumbnail-upload').addEventListener('change', function() {
            handleFilePreview(this, 'thumbnail');
        });

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
        document.getElementById('post-type-selector').addEventListener('change', changePostType);



    </script>
@endsection
