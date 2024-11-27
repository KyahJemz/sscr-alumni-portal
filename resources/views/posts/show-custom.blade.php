@extends('master')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-6">
            <div class="overflow-hidden sm:rounded-lg max-w-2xl mx-auto space-y-4">
                <div id="posts-container">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
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

            const type = `${getHumanReadableDate(new Date(post.created_at))}`;
            const hrs = getTimeAgo(new Date(post.approved_at ?? post.created_at));

            const images = ((post.videos && Array.isArray(JSON.parse(post.videos)) && JSON.parse(post.videos).length > 0) ||
                    (post.images && Array.isArray(JSON.parse(post.images)) && JSON.parse(post.images).length > 0))  ||
                    (post.event && post.event.thumbnail)  ||
                    (post.news && post.news.thumbnail)  ||
                    (post.announcement && post.announcement.thumbnail) ? `
                    <div class="space-y-4 mt-4">
                        <div id="media-slider-${post.id}" class="relative w-full" data-carousel="slide">
                            <div class="relative h-56 overflow-hidden rounded-lg">
                                ${post.event && post.event.thumbnail ? (() => {
                                    sliderCount++;
                                    return `
                                        <div class="duration-700 ease-in-out flex items-center justify-center w-full h-full" data-carousel-item>
                                            <img src="{{ asset('storage/posts/thumbnails') }}/${post.event.thumbnail}" class="max-w-full max-h-full object-cover rounded-md" alt="Post Image">
                                        </div>`;
                                })() : ''}

                                ${post.news && post.news.thumbnail ? (() => {
                                    sliderCount++;
                                    return `
                                        <div class="duration-700 ease-in-out flex items-center justify-center w-full h-full" data-carousel-item>
                                            <img src="{{ asset('storage/posts/thumbnails') }}/${post.news.thumbnail}" class="max-w-full max-h-full object-cover rounded-md" alt="Post Image">
                                        </div>`;
                                })() : ''}

                                ${post.announcement && post.announcement.thumbnail ? (() => {
                                    sliderCount++;
                                    return `
                                        <div class="duration-700 ease-in-out flex items-center justify-center w-full h-full" data-carousel-item>
                                            <img src="{{ asset('storage/posts/thumbnails') }}/${post.announcement.thumbnail}" class="max-w-full max-h-full object-cover rounded-md" alt="Post Image">
                                        </div>`;
                                })() : ''}

                                ${post.videos && Array.isArray(JSON.parse(post.videos)) ?
                                    JSON.parse(post.videos).map(video => {
                                        sliderCount++;
                                        return `
                                            <div class="duration-700 ease-in-out flex items-center justify-center w-full h-full" data-carousel-item>
                                                <video controls class="max-w-full max-h-full rounded-md">
                                                    <source src="{{ asset('storage/posts/videos') }}/${video}" type="video/mp4">
                                                </video>
                                            </div>`;
                                    }).join('')
                                : ''}

                                ${post.images && Array.isArray(JSON.parse(post.images)) ?
                                    JSON.parse(post.images).map(image => {
                                        sliderCount++;
                                        return `
                                            <div class="duration-700 ease-in-out flex items-center justify-center w-full h-full" data-carousel-item>
                                                <img src="{{ asset('storage/posts/images') }}/${image}" class="max-w-full max-h-full object-cover rounded-md" alt="Post Image">
                                            </div>`;
                                    }).join('')
                                : ''}

                                ${post.event && post.event.url ? (() => {
                                    sliderCount++;
                                    return `
                                        <div id="qr-code-container-${post.id}" class="duration-700 ease-in-out flex items-center justify-center w-full h-full" data-carousel-item></div>
                                    `;
                                })() : ''}
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
                ` : '';

            const files = post.files && Array.isArray(JSON.parse(post.files)) ? `
                <div class="flex flex-wrap gap-2 mt-4">
                    ${JSON.parse(post.files).map(file => `
                        <a href="storage/posts/files/${file}" class="text-blue-600 underline flex items-center gap-2" download>
                            @include('components.icons.document')
                            <p class="text-sm font-light">${file}</p>
                        </a>
                    `).join('')}
                </div>
            ` : '';

            console.log(post);

            const likeSection = `
                <div class="flex justify-around items-center mt-4 text-gray-700 border-y-2 border-gray-300 py-2 w-full">
                    ${userHasLiked ? `
                        <form onsubmit="deleteLike(event)" class="flex items-center gap-2 text-sscr-red">
                            <input type="hidden" name="post_id" value="${post.id}">
                            <button type="submit" class="like">@include('components.icons.heart-filled')</button>
                            <a class="text-sm hover:text-sscr-red text-gray-600">${post.likes.length > 1 ? "you and " + (post.likes.length - 1) + " others" : "you"} liked</a>
                        </form>
                    ` : `
                        <form onsubmit="sendLike(event)" class="flex items-center gap-2 text-sscr-red">
                            <input type="hidden" name="post_id" value="${post.id}">
                            <button type="submit" class="like">@include('components.icons.heart')</button>
                            <a class="text-sm hover:text-sscr-red text-gray-600">${post.likes.length} Likes</a>
                        </form>
                    `}
                    <a class="flex items-center gap-2 text-sscr-red text-sm">
                        @include('components.icons.comment')
                        <span class="text-sm hover:text-sscr-red text-gray-600">${post.comments.length} Comments</span>
                    </a>
                </div>
            `;

            const commentSection = `
                <div class="mt-4 space-y-2">
                    <div class="bg-gray-100 p-2 rounded-md shadow-md flex gap-2 items-start">
                        <img src="{{ asset('storage/profile/images/' . (Auth::user()->image ?? 'default.jpg')) }}" alt="Profile Image" class="w-8 h-8 rounded-full object-cover bg-gray-200">
                        <div class="flex-1">
                            <p class="text-sm font-bold mb-1">${userFullName}</p>
                            <form onsubmit="sendComment(event)" class="flex flex-row gap-2 content-center">
                                <textarea name="comment" class="w-full p-2 text-xs border border-gray-300 rounded-md" rows="2" placeholder="Add a comment..."></textarea>
                                <input type="hidden" name="post_id" value="${post.id}">
                                <button type="submit" class="bg-sscr-red text-white px-2 py-1 rounded-md mt-2 text-nowrap">Send</button>
                            </form>
                        </div>
                    </div>
                    ${post.comments.map(comment => `
                        <div class="bg-gray-100 p-2 rounded-md mb-2 flex gap-2 items-start shadow-md">
                            <img src="{{ asset('storage/profile/images') }}/${comment.user.image || 'default.jpg'}" alt="Profile Image" class="w-8 h-8 rounded-full object-cover bg-gray-200">
                            <div class="flex-1 relative">
                                <p class="text-sm font-bold">${(comment.user.alumni_information?.first_name || comment.user.admin_information?.first_name || '') + ' ' + (comment.user.alumni_information?.last_name || comment.user.admin_information?.last_name || '')}</p>
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
                <div class="bg-white p-4 text-gray-900 border border-gray-200 shadow-md rounded-md mb-6">

                    ${post?.announcement || post?.news || post?.event ? `
                        <div class="text-2xl font-bold mb-2 flex justify-center">
                            ${post.announcement ? post.announcement.title.replace(/\n/g, '<br>') : ''}
                            ${post.news ? post.news.title.replace(/\n/g, '<br>') : ''}
                            ${post.event ? post.event.title.replace(/\n/g, '<br>') : ''}
                        </div>
                    `: ""}

                    <div class="flex flex-row gap-4 pb-4 relative">
                        <div class="flex-1 border-y-2 border-gray-300 py-2 flex gap-2 md:items-center sm:flex-col md:flex-row sm:items:left">
                            <span class="text-xs font-bold text-left">Posted by ${postFullName}</span>
                            <div class="flex gap-2 items-center">
                                <span class="sm:hidden md:inline" style=" font-size: 10px; color: #000000;">●</span>
                                <span class="text-xs font-light">${type}</span>
                                <span style=" font-size: 10px; color: #000000;">●</span>
                                <span class="text-xs font-light">${hrs}</span>
                            </div>
                        </div>
                    </div>

                    ${post?.content ? `<div class="text-sm font-light mb-4">${post?.content ? post.content.replace(/\n/g, '<br>') : ''}</div>` : ""}

                    ${post?.event ? `
                        <div class="bg-gray-100 p-4 border border-gray-300 rounded-lg flex flex-row gap-4 items-center">
                            @include('components.icons.calendar')
                            <div>
                                <div class="md:text-md sm:text-sm font-bold text-sscr-red">${getHumanReadableDate(new Date(post.event.start_date))}${post?.event?.end_date ? ' to ' + getHumanReadableDate(new Date(post.event.end_date)) : ''}</div>
                                <div class="md:text-sm sm:text-sm text-gray-500 ">${post.event.location}</div>
                            </div>
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

                    ${post?.announcement || post?.news || post?.event  ? `
                        <div class="text-sm font-light mb-2">
                            ${post.announcement ? post.announcement.description.replace(/\n/g, '<br>') : ''}
                            ${post.news ? post.news.description.replace(/\n/g, '<br>') : ''}
                            ${post.event ? post.event.description.replace(/\n/g, '<br>') : ''}
                        </div>
                    `: ""}

                    ${images}

                    ${post.files !== '[]' ? files : ""}

                    ${likeSection}

                    ${commentSection}

                </div>
            `;

            return template;
        }

        async function getPosts() {
            const postsContainer = document.getElementById('posts-container');
            const url = "{{ route('api.posts.show', ['id' => $post_id]) }}";

            try {
                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const json = await response.json();

                postsContainer.innerHTML = PostTemplate(json.data.post);
                if (json.data.post.event && json.data.post.event.url) {
                    const qrContainer = document.getElementById(`qr-code-container-${json.data.post.id}`);
                    console.log(json.data.post.event.url)
                    console.log(qrContainer)
                    setTimeout(() => {
                        const qrContainer = document.getElementById(`qr-code-container-${json.data.post.id}`);
                        if (qrContainer) {
                            qrContainer.innerHTML = '';
                            new QRCode(qrContainer, {
                                text: json.data.post.event.url,
                                width: 200,
                                height: 200,
                                colorDark: "#000000",
                                colorLight: "#ffffff",
                                correctLevel: QRCode.CorrectLevel.H
                            });
                        } else {
                            console.error(`QR code container not found for post ID ${json.data.post.id}`);
                        }
                    }, 100);
                }

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
                        'X-R    equested-With': 'XMLHttpRequest',
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
@endsection
