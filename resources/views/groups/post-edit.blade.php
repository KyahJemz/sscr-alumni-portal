@extends('master')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-2 md:px-8">
            <div class="overflow-hidden sm:rounded-lg max-w-2xl mx-auto space-y-4">
                @if(Auth::user()->role !== 'alumni' || Auth::user()->id === $post->created_by)
                <div class="bg-white p-4 text-gray-900 border border-gray-200 shadow-md rounded-md">
                    <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="post" enctype="multipart/form-data" class="flex gap-4">
                        @csrf
                        @method('patch')
                        <img src="{{ $user->image ? asset('storage/profile/images/' . $user->image) : asset('storage/profile/images/default.jpg') }}"
                            onerror="this.onerror=null;this.src='{{ asset('storage/profile/images/default.jpg') }}';"
                            alt=""
                            class="border border-gray-300 dark:border-gray-700 w-16 h-16 rounded-full bg-gray-200 sm:hidden md:block">
                        <div class="w-full space-y-2">
                            <select id="post-type-selector" name="type"
                                class="text-xs font-light px-2 py-1 pr-8 cursor-pointer rounded" disabled>
                                <option class="cursor-pointer" value="post">Create Post</option>
                                <option class="cursor-pointer" value="announcement">Create Announcement</option>
                                <option class="cursor-pointer" value="event">Create Event</option>
                                <option class="cursor-pointer" value="news">Create News</option>
                            </select>
                            <p class="text-xs font-light pb-2">Editing as:
                                {{ optional($user->alumniInformation)->getName() ??
                                    (optional($user->adminInformation)->getName() ?? $user->username) }}
                            </p>

                            <div id="post-form" class="w-full space-y-2">
                                <textarea placeholder="What's on your mind?" class="w-full p-2 rounded" name="content" id="" rows="3">{{$post->content}}</textarea>
                            </div>

                            <div id="news-announcement-form" class="w-full hidden space-y-2">
                                <input type="text" name="title" class="w-full p-2 rounded text-sm" value="{{optional($post->news)->title ?? optional($post->announcement)->title ?? optional($post->event)->title ?? ''}}" placeholder="Title... *">
                                <textarea placeholder="What's on your mind? *" class="w-full p-2 rounded text-sm" name="description" id=""
                                    rows="3">{{optional($post->news)->description ?? optional($post->announcement)->description ?? optional($post->event)->description ?? ''}}</textarea>
                            </div>

                            <div id="event-form" class="w-full hidden space-y-2">
                                <input type="text" name="contributions" class="w-full p-2 rounded text-sm" placeholder="Contributions (optional)" value="{{optional($post->event)->contribution ?? ''}}">
                                <input type="text" name="amount" class="w-full p-2 rounded text-sm" placeholder="Amount (optional)" value="{{optional($post->event)->amount ?? ''}}">
                                <input type="text" name="location" class="w-full p-2 rounded -mt-2 text-sm"
                                    placeholder="Event location (optional)" value="{{optional($post->event)->location ?? ''}}">
                                <div class="w-full flex text-xs gap-2">
                                    <input type="datetime-local" name="startDate" id="startDate"
                                        class="text-xs cursor-pointer rounded p-2"
                                        value="{{ optional($post->event) ? date('Y-m-d\TH:i', strtotime($post->event->start_date ?? '')) ?? '' : null }}">
                                    <input type="datetime-local" name="endDate" id="endDate"
                                        class="text-xs cursor-pointer rounded p-2"
                                        value="{{ optional($post->event) ? date('Y-m-d\TH:i', strtotime($post->event->end_date ?? '')) ?? '' : null }}">
                                </div>
                            </div>

                            <div id="thumbnail-form" class="w-full hidden space-y-2">
                                <p class="">Thumbnail:</p>
                                <input id="thumbnail-upload" type="file" name="thumbnail"
                                    class="w-full p-2 rounded -mt-2 text-sm" placeholder="Thumbnail" accept="image/*" value="{{optional($post->news)->thumbnail ?? optional($post->announcement)->thumbnail ?? optional($post->event)->thumbnail ?? ''}}">
                                <input id="thumbnail-current" type="text" name="thumbnail_current"
                                    class="hidden" value="{{optional($post->news)->thumbnail ?? optional($post->announcement)->thumbnail ?? optional($post->event)->thumbnail ?? ''}}">
                                <div id="thumbnail-preview">
                                    @if(optional($post->news)->thumbnail ?? optional($post->announcement)->thumbnail ?? optional($post->event)->thumbnail)
                                        <span class="flex items-center"><img src="{{ asset('storage/posts/thumbnails') }}/{{optional($post->news)->thumbnail ?? optional($post->announcement)->thumbnail ?? optional($post->event)->thumbnail ?? ''}}" class="w-12 h-12 rounded-md object-cover"></span>
                                    @endif
                                </div>
                            </div>

                            <div class="w-full space-y-2">
                                @if (json_decode($post->images))
                                    <div id="images-preview" class="w-full space-x-2 overflow-x-auto">
                                        <p id="images-count" class="text-xs cursor-pointer underline"
                                            onclick="document.getElementById('images-dropdown').classList.toggle('hidden');">
                                            images: {{ count(json_decode($post->images)) }}</p>
                                        <div id="images-dropdown" class="flex items-center gap-2 hidden">
                                            @forelse (json_decode($post->images) as $image)
                                                <img src="{{ asset('storage/posts/images') }}/{{ $image }}" class="w-12 h-12 rounded-md object-cover">
                                            @empty
                                            @endforelse
                                        </div>
                                        <button type="button" class="text-xs text-red-600 underline"
                                            onclick="clearMedia('image');">Remove all images</button>
                                    </div>
                                @else
                                    <div id="images-preview" class="hidden w-full space-x-2 overflow-x-auto">
                                        <p id="images-count" class="text-xs cursor-pointer underline"
                                            onclick="document.getElementById('images-dropdown').classList.toggle('hidden');">
                                            images: </p>
                                        <div id="images-dropdown" class="flex items-center gap-2 hidden"></div>
                                        <button type="button" class="text-xs text-red-600 underline"
                                            onclick="clearMedia('image');">Remove all images</button>
                                    </div>
                                @endif

                                @if (json_decode($post->videos))
                                    <div id="videos-preview" class="w-full space-x-2 overflow-x-auto">
                                        <p id="videos-count" class="text-xs cursor-pointer underline"
                                            onclick="document.getElementById('videos-dropdown').classList.toggle('hidden');">
                                            videos: {{ count(json_decode($post->videos)) }}</p>
                                        <div id="videos-dropdown" class="flex items-center gap-2 hidden">
                                            @forelse (json_decode($post->videos) as $video)
                                                <span class="flex items-center"><video controls class="w-12 h-12 rounded-md"><source src="{{ asset('storage/posts/videos') }}/{{ $video }}" type="video/mp4"></video></span>
                                            @empty
                                            @endforelse
                                        </div>
                                        <button type="button" class="text-xs text-red-600 underline"
                                            onclick="clearMedia('video');">Remove all videos</button>
                                    </div>
                                @else
                                    <div id="videos-preview" class="hidden w-full space-x-2 overflow-x-auto">
                                        <p id="videos-count" class="text-xs cursor-pointer underline"
                                            onclick="document.getElementById('videos-dropdown').classList.toggle('hidden');">
                                            videos: </p>
                                        <div id="videos-dropdown" class="flex items-center gap-2 hidden"></div>
                                        <button type="button" class="text-xs text-red-600 underline"
                                            onclick="clearMedia('video');">Remove all videos</button>
                                    </div>
                                @endif

                                @if (json_decode($post->files))
                                    <div id="files-preview" class="w-full space-x-2 overflow-x-auto">
                                        <p id="files-count" class="text-xs cursor-pointer underline"
                                            onclick="document.getElementById('files-dropdown').classList.toggle('hidden');">
                                            files: {{ count(json_decode($post->files)) }}</p>
                                        <div id="files-dropdown" class="flex items-center gap-2 hidden">
                                            @forelse (json_decode($post->files) as $file)
                                                <span class="flex items-center"><a href="{{ asset('storage/posts/files') }}/{{ $file }}" class="text-blue-600 underline w-max" download>{{ $file }}</a></span>
                                            @empty
                                            @endforelse
                                        </div>
                                        <button type="button" class="text-xs text-red-600 underline"
                                            onclick="clearMedia('file');">Remove all files</button>
                                    </div>
                                @else
                                    <div id="files-preview" class="hidden w-full space-x-2 overflow-x-auto">
                                        <p id="files-count" class="text-xs cursor-pointer underline"
                                            onclick="document.getElementById('files-dropdown').classList.toggle('hidden');">
                                            files: </p>
                                        <div id="files-dropdown" class="flex items-center gap-2 hidden"></div>
                                        <button type="button" class="text-xs text-red-600 underline"
                                            onclick="clearMedia('file');">Remove all files</button>
                                    </div>
                                @endif
                            </div>

                            <div class="flex justify-between gap-4 items-center">
                                <div class="flex gap-4">

                                    <input type="file" name="images[]" id="image-upload" class="hidden"
                                        accept="image/*" multiple>
                                    <input type="file" name="videos[]" id="video-upload" class="hidden"
                                        accept="video/*" multiple>
                                    <input type="file" name="files[]" id="file-upload" class="hidden"
                                        accept=".pdf,.doc,.docx,.txt">

                                    <input type="text" name="images_current" id="images-current" class="hidden" value="{{$post->images}}">
                                    <input type="text" name="videos_current" id="videos-current" class="hidden" value="{{$post->videos}}">
                                    <input type="text" name="files_current" id="files-current" class="hidden" value="{{$post->files}}">

                                    <button type="button" title="Add images"
                                        onclick="document.getElementById('image-upload').click();">@include('components.icons.image')</button>
                                    <button type="button" title="Add video"
                                        onclick="document.getElementById('video-upload').click();">@include('components.icons.video')</button>
                                    <button type="button" title="Add attachment"
                                        onclick="document.getElementById('file-upload').click();">@include('components.icons.attachment')</button>
                                </div>
                                <button title="Post"
                                    class="flex bg-sscr-red px-4 py-1 rounded-md text-white items-center">Update&nbsp;&nbsp;
                                    @include('components.icons.send')</button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif
            </div>
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
                            `<span class="flex items-center"><video controls class="w-12 h-12 rounded-md"><source src="${e.target.result}" type="video/mp4"></video></span>`;
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
                    document.getElementById('images-current').value = '';
                    break;
                case 'video':
                    document.getElementById('video-upload').value = '';
                    document.getElementById('videos-preview').classList.add('hidden');
                    document.getElementById('videos-dropdown').innerHTML = '';
                    document.getElementById('videos-current').value = '';
                    break;
                case 'file':
                    document.getElementById('file-upload').value = '';
                    document.getElementById('files-preview').classList.add('hidden');
                    document.getElementById('files-dropdown').innerHTML = '';
                    document.getElementById('files-current').value = '';
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
            document.getElementById('post-type-selector').value = '{{ $post->type }}';
            changePostType({target: {value: '{{ $post->type }}'}})
        }
    </script>

    <script>
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
                // redirect
            } catch (error) {
                alertModal(error.message);
                console.error(error.message);
            }
        }

        console.log(@json($post));
    </script>
@endsection
