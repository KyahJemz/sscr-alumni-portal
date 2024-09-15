@extends('master')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg max-w-2xl mx-auto space-y-6">
            <div class="bg-white p-4 text-gray-900 border border-gray-200 shadow-md rounded-md">
                <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data" class="flex gap-4">
                    @csrf
                    @method('post')

                    <img src="" alt="" class="border border-gray-300 dark:border-gray-700 w-16 h-16 rounded-full bg-gray-200">
                    <div class="w-full space-y-2">
                        <select name="type" class="text-xs font-light px-2 py-1 pr-8 cursor-pointer rounded">
                            <option class="cursor-pointer" value="post">Create Post</option>
                            <option class="cursor-pointer" value="announcement">Create Announcement</option>
                            <option class="cursor-pointer" value="event">Create Event</option>
                            <option class="cursor-pointer" value="news">Create News</option>
                        </select>
                        <p class="text-xs font-light pb-2">Creating as: paw patrol</p>
                        <textarea placeholder="What's on your mind?" class="w-full p-2 rounded" name="content" id="" rows="3"></textarea>

                        <div class="w-full space-y-2">
                            <div id="images-preview" class="hidden w-full space-x-2 overflow-x-auto">
                                <p id="images-count" class="text-xs cursor-pointer underline" onclick="document.getElementById('images-dropdown').classList.toggle('hidden');">images: </p>
                                <div id="images-dropdown" class="flex items-center gap-2 hidden"></div>
                                <button type="button" class="text-xs text-red-600 underline" onclick="clearMedia('image');">Remove all images</button>
                            </div>

                            <div id="videos-preview" class="hidden w-full space-x-2 overflow-x-auto">
                                <p id="videos-count" class="text-xs cursor-pointer underline" onclick="document.getElementById('videos-dropdown').classList.toggle('hidden');">videos: </p>
                                <div id="videos-dropdown" class="flex items-center gap-2 hidden"></div>
                                <button type="button" class="text-xs text-red-600 underline" onclick="clearMedia('video');">Remove all videos</button>
                            </div>

                            <div id="files-preview" class="hidden w-full space-x-2 overflow-x-auto">
                                <p id="files-count" class="text-xs cursor-pointer underline" onclick="document.getElementById('files-dropdown').classList.toggle('hidden');">files: </p>
                                <div id="files-dropdown" class="flex items-center gap-2 hidden"></div>
                                <button type="button" class="text-xs text-red-600 underline" onclick="clearMedia('file');">Remove all files</button>
                            </div>

                            <div id="schedule-preview" class="hidden w-full flex text-xs gap-2">
                                <input type="datetime-local" name="startDate" id="startDate" class="text-xs cursor-pointer">
                                <input type="datetime-local" name="endDate" id="endDate" class="text-xs cursor-pointer">
                                <button type="button" onclick="document.getElementById('schedule-preview').classList.toggle('hidden');">@include('components.icons.x')</button>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 items-center">
                            <input type="file" name="images[]" id="image-upload" class="hidden" accept="image/*" multiple>
                            <input type="file" name="videos[]" id="video-upload" class="hidden" accept="video/*" multiple>
                            <input type="file" name="files[]" id="file-upload" class="hidden" accept=".pdf,.doc,.docx,.txt" multiple>

                            <button type="button" title="Add images" onclick="document.getElementById('image-upload').click();">@include('components.icons.image')</button>
                            <button type="button" title="Add video" onclick="document.getElementById('video-upload').click();">@include('components.icons.video')</button>
                            <button type="button" title="Add attachment" onclick="document.getElementById('file-upload').click();">@include('components.icons.attachment')</button>
                            <button type="button" title="Add schedule" onclick="document.getElementById('schedule-preview').classList.toggle('hidden');">@include('components.icons.calendar')</button>
                            <button title="Post" class="flex bg-sscr-red px-4 py-1 rounded-md text-white items-center">Post&nbsp;&nbsp; @include('components.icons.send')</button>
                        </div>
                    </div>
                </form>
            </div>

            <script>
                function handleFilePreview(input, fileType) {
                    const imagesContainer = document.getElementById('images-preview');
                    const videosContainer = document.getElementById('videos-preview');
                    const filesContainer = document.getElementById('files-preview');
                    const imagesDropdown = document.getElementById('images-dropdown');
                    const videosDropdown = document.getElementById('videos-dropdown');
                    const filesDropdown = document.getElementById('files-dropdown');
                    const imagesCount = document.getElementById('images-count');
                    const videosCount = document.getElementById('videos-count');
                    const filesCount = document.getElementById('files-count');
                    const files = input.files;

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
                    }

                    Array.from(files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            let mediaElement;
                            if (fileType === 'image') {
                                mediaElement = `<span class="flex items-center"><img src="${e.target.result}" class="w-12 h-12 rounded-md object-cover"></span>`;
                                imagesDropdown.innerHTML += mediaElement;
                            } else if (fileType === 'video') {
                                mediaElement = `<span class="flex items-center"><video controls class="w-12 h-12 rounded-md"><source src="${e.target.result}" type="${file.type}"></video></span>`;
                                videosDropdown.innerHTML += mediaElement;
                            } else if (fileType === 'file') {
                                mediaElement = `<span class="flex items-center"><a href="${e.target.result}" class="text-blue-600 underline w-max" download>${file.name}</a></span>`;
                                filesDropdown.innerHTML += mediaElement;
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
            </script>





            <div class="p-4 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-700">
                <div class="flex gap-4 border-b-2 mb-4 pb-4">
                    <img src="" alt="" class="border border-gray-300 dark:border-gray-700 w-16 h-16 rounded-full bg-gray-200">
                    <div>
                        <p class="text-md font-bold">Paw Patrol</p>
                        <p class="text-xs font-light">Announcmeent</p>
                        <p class="text-xs font-light">September 23, 204 at 3:00 PM</p>
                    </div>
                </div>
                <div>
                    <p>caption if any</p>
                    <div>Files if any</div>
                    <div>images if any</div>
                    <div>video if any</div>
                    image and videos combine in a single post
                </div>

                 data first for here

                the cretion layoud should be same with the post view etself

            </div>



        </div>
    </div>
</div>

<script>
    function handlePostTypeChange() {
        const postType = document.getElementById('postType').value;
        const eventFields = document.getElementById('eventFields');

        if (postType === 'event') {
            eventFields.style.display = 'block';
        } else {
            eventFields.style.display = 'none';
        }
    }
</script>
@endsection


@section('css')
{{-- <style>
    /* Styles for scrollable previews */
    #images-preview,
    #videos-preview,
    #files-preview {
        max-height: 150px; /* Adjust as needed */
        overflow-x: auto;
        white-space: nowrap;
        padding: 10px;
    }

    /* Hide scrollbars for better aesthetics, but still allow scrolling */
    #images-preview::-webkit-scrollbar,
    #videos-preview::-webkit-scrollbar,
    #files-preview::-webkit-scrollbar {
        display: none;
    }

    #images-preview,
    #videos-preview,
    #files-preview {
        -ms-overflow-style: none;  /* Internet Explorer 10+ */
        scrollbar-width: none;  /* Firefox */
    }

    /* Prevent preview items from wrapping to new lines */
    #images-preview img,
    #videos-preview video,
    #files-preview a {
        display: inline-block;
    }
</style> --}}

@endsection
