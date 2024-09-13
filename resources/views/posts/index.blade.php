@extends('master')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg max-w-2xl mx-auto space-y-6">
            <div class="p-4 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-700">
                <div class="flex gap-4 border-b-2 mb-4 pb-4">
                    <img src="" alt="" class="border border-gray-300 dark:border-gray-700 w-16 h-16 rounded-full bg-gray-200">
                    <div class="w-full">
                        <select class="text-xs font-light px-2 py-1 pr-8 cursor-pointer" value="Announcmeent">
                            <option class="cursor-pointer" value="post">Create Post</option>
                            <option class="cursor-pointer" value="announcement">Create Announcement</option>
                            <option class="cursor-pointer" value="event">Create Event</option>
                            <option class="cursor-pointer" value="news">Create News</option>
                        </select>
                        <p class="text-xs font-light pb-2">Creating as: Stephen Regan James</p>
                        <textarea class="w-full p-2" name="" id="" rows="3"></textarea>
                        <div class="flex justify-between">
                            <button>image</button>
                            <button>videos</button>
                            <button>file</button>
                            <button>schedule</button>
                        </div>
                    </div>
                </div>


                create dummy data first for here

                the cretion layoud should be same with the post view itself

            </div>

            <div class="p-4 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-700">
                <div class="flex gap-4 border-b-2 mb-4 pb-4">
                    <img src="" alt="" class="border border-gray-300 dark:border-gray-700 w-16 h-16 rounded-full bg-gray-200">
                    <div>
                        <p class="text-md font-bold">Stephen Regan James </p>
                        <p class="text-xs font-light">Announcmeent</p>
                        <p class="text-xs font-light">September 23, 204 at 3:00 PM</p>
                    </div>
                </div>
                <div>
                    <p>caption if any</p>
                    <div>Files if any</div>
                    <div>images if any</div>
                    <div>video if any</div>
                    image and videos must be combine in a single post
                </div>

                create dummy data first for here

                the cretion layoud should be same with the post view itself

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
