@extends('master')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden max-w-2xl mx-auto space-y-4">
                <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center mb-4 bg-white p-2 shadow rounded">
                    Pending Group Posts Approvals
                </h2>
                <div id="posts-container">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function PostTemplate(post) {
            const postFullName =
                    (post.posted_by.alumni_information?.first_name ?? post.posted_by.admin_information?.first_name) +
                ' ' +
                    (post.posted_by.alumni_information?.last_name ?? post.posted_by.admin_information?.last_name);

            const type = `${post.type.charAt(0).toUpperCase() + post.type.slice(1)} on ${getHumanReadableDate(new Date(post.created_at))}`;
            const hrs = getTimeAgo(new Date(post.approved_at ?? post.created_at));

            const images = ((post.videos && Array.isArray(JSON.parse(post.videos)) && JSON.parse(post.videos).length > 0) ||
                    (post.images && Array.isArray(JSON.parse(post.images)) && JSON.parse(post.images).length > 0))  ||
                    (post.event && post.event.thumbnail)  ||
                    (post.news && post.news.thumbnail)  ||
                    (post.announcement && post.announcement.thumbnail) ? `
                    <div class="space-y-4">
                        <div id="media-slider-${post.id}" class="relative w-full" data-carousel="slide">
                            <div class="relative h-56 overflow-hidden rounded-lg">
                                ${post.event && post.event.thumbnail ? `
                                    <div class="duration-700 ease-in-out flex items-center justify-center w-full h-full" data-carousel-item>
                                        <img src="{{ asset('storage/posts/thumbnails') }}/${post.event.thumbnail}" class="max-w-full max-h-full object-cover rounded-md" alt="Post Image">
                                    </div>
                                ` : ''}

                                ${post.news && post.news.thumbnail ? `
                                    <div class="duration-700 ease-in-out flex items-center justify-center w-full h-full" data-carousel-item>
                                        <img src="{{ asset('storage/posts/thumbnails') }}/${post.news.thumbnail}" class="max-w-full max-h-full object-cover rounded-md" alt="Post Image">
                                    </div>
                                ` : ''}

                                ${post.announcement && post.announcement.thumbnail ? `
                                    <div class="duration-700 ease-in-out flex items-center justify-center w-full h-full" data-carousel-item>
                                        <img src="{{ asset('storage/posts/thumbnails') }}/${post.announcement.thumbnail}" class="max-w-full max-h-full object-cover rounded-md" alt="Post Image">
                                    </div>
                                ` : ''}

                                ${post.videos && Array.isArray(JSON.parse(post.videos)) ?
                                    JSON.parse(post.videos).map(video => `
                                        <div class="duration-700 ease-in-out flex items-center justify-center w-full h-full" data-carousel-item>
                                            <video controls class="max-w-full max-h-full rounded-md">
                                                <source src="{{ asset('storage/posts/videos') }}/${video}" type="video/mp4">
                                            </video>
                                        </div>
                                    `).join('') : ''}

                                ${post.images && Array.isArray(JSON.parse(post.images)) ?
                                    JSON.parse(post.images).map(image => `
                                        <div class="duration-700 ease-in-out flex items-center justify-center w-full h-full" data-carousel-item>
                                            <img src="{{ asset('storage/posts/images') }}/${image}" class="max-w-full max-h-full object-cover rounded-md" alt="Post Image">
                                        </div>
                                    `).join('') : ''}
                            </div>

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
                        </div>
                    </div>
                ` : '';

            const files = post.files && Array.isArray(JSON.parse(post.files)) ? `
                <div class="flex flex-wrap gap-2 mt-4">
                    ${JSON.parse(post.files).map(file => `
                        <a href="{{asset('storage/posts/files')}}/${file}" class="text-blue-600 underline flex items-center gap-2" download>
                            @include('components.icons.document')
                            <p class="text-sm font-light">${file}</p>
                        </a>
                    `).join('')}
                </div>
            ` : '';

            const template = `
                <div class="bg-white p-4 text-gray-900 border border-gray-200 shadow-md rounded-md mb-6">
                    <div class="flex gap-4 border-b-2 border-gray-300 mb-4 pb-4 relative">
                        <img src="{{ asset('storage/profile/images') }}/${post.posted_by.image ?? 'default.jpg'}"
                            onerror="this.onerror=null;this.src='{{ asset('storage/profile/images/default.jpg') }}';"
                            alt="Profile Image"
                            class="border border-gray-300 dark:border-gray-700 w-12 h-12 rounded-full bg-gray-200">
                        <div class="flex-1 relative">
                            <p class="text-md font-bold">${postFullName}</p>
                            <p class="text-xs font-light">${type}</p>
                            <p class="text-xs font-light">${hrs}</p>
                            <div class="absolute top-0 right-0 flex gap-3">
                                <a class="text-xs font-light hover:underline cursor-pointer border border-sscr-red px-2 py-1 rounded" onclick="rejectPost(${post.id},${post.group_id})">Reject</a>
                                <a class="text-xs font-light hover:underline cursor-pointer border border-sscr-red px-2 py-1 rounded" onclick="approvePost(${post.id},${post.group_id})">Approve</a>
                            </div>
                        </div>
                    </div>

                    ${post?.content ? `<div class="text-sm font-light mb-4">${post?.content ? post.content.replace(/\n/g, '<br>') : ''}</div>` : ""}

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
                            ${post.event.description.replace(/\n/g, '<br>')}
                        </div>
                        ${post.event?.contributions || post.event?.amount ? `
                            <div class="text-sm text-gray-700 my-4 font-bold">Notes:
                            ${post.event?.contributions ? `
                                <div class="text-sm text-gray-700 font-light px-4">
                                    Contributions: ${post.event.contributions}
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
                            ${post.announcement ? post.announcement.description.replace(/\n/g, '<br>') : ''}
                            ${post.news ? post.news.description.replace(/\n/g, '<br>') : ''}
                        </div>
                    `: ""}

                    ${images}

                    ${post.files !== '[]' ? files : ""}

                </div>
            `;

            return template;
        }

        function addEvents() {
            document.querySelectorAll('[data-carousel="slide"]').forEach(slider => {
                const prevButton = slider.querySelector('[data-carousel-prev]');
                const nextButton = slider.querySelector('[data-carousel-next]');
                const items = slider.querySelectorAll('[data-carousel-item]');
                let currentIndex = 0;

                const showItem = (index) => {
                    items.forEach((item, i) => {
                        item.classList.toggle('hidden', i !== index);
                    });
                };

                prevButton.addEventListener('click', () => {
                    currentIndex = (currentIndex > 0) ? currentIndex - 1 : items.length - 1;
                    showItem(currentIndex);
                });

                nextButton.addEventListener('click', () => {
                    currentIndex = (currentIndex < items.length - 1) ? currentIndex + 1 : 0;
                    showItem(currentIndex);
                });

                showItem(currentIndex);
            });
        }

        async function getPosts() {
            const postsContainer = document.getElementById('posts-container');
            const url = "{{ route('api.post-approvals.index', ['group' => $group->id]) }}";

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
                });
                addEvents();
            } catch (error) {
                console.error('Error fetching posts:', error.message);
            }
        }

        getPosts()

        async function approvePost(postId,groupId) {
            const formData = new FormData();
            formData.append('status', 'approved')
            formData.append('_method', 'PATCH');
            const url = `/api/post-approvals/${postId}/${groupId}`;
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

        async function rejectPost(postId,groupId) {
            const formData = new FormData();
            formData.append('status', 'reject')
            formData.append('_method', 'PATCH');
            const url = `/api/post-approvals/${postId}/${groupId}`;
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
@endsection
