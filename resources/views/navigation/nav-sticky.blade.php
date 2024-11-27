<div id="sticky-navbar"
    class="sm:hidden md:flex lg:flex border-y border-sscr-red sticky top-0 z-10 transition ease-in-out duration-500 bg-sscr-yellow text-sscr-red font bold">
    <div class="max-w-7xl mx-auto sm:flex md:flex lg:flex justify-between py-1 w-full">
        <div class="sm:-my-px sm:flex">
            <a href="{{ route('home') }}"
                class='inline-flex hover:opacity-50 items-center px-8 border-indigo-400 dark:border-indigo-600 text-sm leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                Home
            </a>
            <a href="{{ route('groups.index') }}"
                class='inline-flex hover:opacity-50 items-center px-8 border-indigo-400 dark:border-indigo-600 text-sm leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                {{ (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator') ? 'Organizations' : 'My Organizations' }}
            </a>
            <a href="{{ route('news.index') }}"
                class='inline-flex hover:opacity-50 items-center px-8 border-indigo-400 dark:border-indigo-600 text-sm leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                News
            </a>
            <a href="{{ route('events.index') }}"
                class='inline-flex hover:opacity-50 items-center px-8 border-indigo-400 dark:border-indigo-600 text-sm leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                Events
            </a>
            <a href="{{ route('announcements.index') }}"
                class='inline-flex hover:opacity-50 items-center px-8 border-indigo-400 dark:border-indigo-600 text-sm leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                Announcements
            </a>
            @if (Auth::user()->role !== 'alumni')
                <div class="relative">
                    <button id="dropdownToggle" class='inline-flex hover:opacity-50 items-center px-8 border-indigo-400 dark:border-indigo-600 text-sm leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                        Accounts
                        <svg id="nav-accounts-dropdown-arrow" xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5 transform transition duration-150 ease-in-out" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.292 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div id="dropdownMenu" class="hidden absolute mt-2 w-48 bg-sscr-red rounded-md shadow-lg z-20 transform transition duration-150 ease-in-out">
                        @if(Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
                            <a href="{{ route('account.index', ['type'=>'alumni']) }}"
                                class='block px-4 py-2 text-sscr-yellow hover:opacity-50 transition duration-150 ease-in-out'>
                                Alumni Accounts
                            </a>
                        @endif
                        <a href="{{ route('account.index', ['type'=>'graduates']) }}"
                            class='block px-4 py-2 text-sm text-sscr-yellow hover:opacity-50 transition duration-150 ease-in-out'>
                            Graduation List
                        </a>
                        @if(Auth::user()->role === 'cict_admin')
                            <a href="{{ route('account.index', ['type'=>'admins']) }}"
                                class='block px-4 py-2 text-sm text-sscr-yellow hover:opacity-50 transition duration-150 ease-in-out'>
                                Management Accounts
                            </a>
                        @endif
                    </div>
                </div>
                <script>
                    const dropdownToggle = document.getElementById('dropdownToggle');
                    const dropdownMenu = document.getElementById('dropdownMenu');
                    const dropdownarrow = document.getElementById('nav-accounts-dropdown-arrow');

                    dropdownToggle.addEventListener('click', function() {
                        dropdownMenu.classList.toggle('hidden');
                        dropdownarrow.classList.toggle('rotate-180');

                    });

                    window.addEventListener('click', function(event) {
                        if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                            dropdownMenu.classList.add('hidden');
                            dropdownarrow.classList.remove('rotate-180');
                        }
                    });
                </script>
            @endif
        </div>

        <div class="sm:flex sm:items-center gap-2">
            <a href="{{ route('messages.index') }}" title="Messages"
                class='inline-flex relative hover:opacity-50 items-center border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                @include('components.icons.chat')
                <span id="messages-count" class=" absolute -top-1 -right-0 inline-flex items-center justify-center w-3 h-3 text-xs leading-none text-white bg-sscr-red rounded-full">•</span>
            </a>
            <a onclick="document.getElementById('notifications-modal').classList.toggle('hidden');" title="Notifications"
                class='relative cursor-pointer inline-flex hover:opacity-50 items-center text-sm leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                @include('components.icons.bell')
                <span id="notification-count" class=" absolute -top-1 -right-0 inline-flex items-center justify-center w-3 h-3 text-xs leading-none text-white bg-sscr-red rounded-full">•</span>
            </a>
            <div id="dropdown" class="relative" title="Profile">
                <button id="sticky-navbar-dropdown-trigger"
                    class="flex gap-2 items-center px-3 text-sm font-medium rounded-md hover:opacity-50 cursor-pointer focus:outline-none transition ease-in-out duration-150">
                    <img class="w-6 h-6 rounded-full m-0 p-0"
                        src="{{ Auth::user()->image ? asset('storage/profile/images/' . Auth::user()->image) : asset('storage/profile/images/default.jpg') }}"
                        onerror="this.onerror=null;this.src='{{ asset('storage/profile/images/default.jpg') }}';"
                        alt="Profile">
                        {{ optional(Auth::user()->alumniInformation)->getName() ?? optional(Auth::user()->adminInformation)->getName() ?? Auth::user()->username }}

                </button>

                <div id="sticky-navbar-dropdown"
                    class="absolute z-50 mt-2 hidden rounded-md shadow-lg bg-sscr-red ring-1 ring-black ring-opacity-5">
                    <a href="{{ route('user.index') }}"
                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-sscr-yellow hover:opacity-50 transition duration-150 ease-in-out">
                        Profile
                    </a>
                    @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator' || Auth::user()->role === 'program_chair')
                        <a href="{{ route('feedback.index') }}"
                            class="block w-full px-4 py-2 text-start text-sm leading-5 text-sscr-yellow hover:opacity-50 transition duration-150 ease-in-out">
                            Feedback
                        </a>
                    @else
                        <button id="send-feedback-trigger"
                            type="button"
                            onclick="document.getElementById('send-feedback-modal').classList.toggle('hidden');"
                            class="block w-full px-4 py-2 text-start text-sm leading-5 text-sscr-yellow hover:opacity-50 transition duration-150 ease-in-out">
                            Send Feedback
                        </button>
                    @endif
                    @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
                        <hr class="border-sscr-yellow" />
                        <a href="{{ route('hobbies.index') }}"
                            class="block w-full px-4 py-2 text-start text-sm leading-5 text-sscr-yellow hover:opacity-50 transition duration-150 ease-in-out">
                            Hobbies Management
                        </a>
                    @endif
                    <hr class="border-sscr-yellow" />
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="block w-full px-4 py-2 text-start text-sm leading-5 text-sscr-yellow hover:opacity-50 transition duration-150 ease-in-out">
                            Log Out
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if (Auth::user()->role === 'alumni')
    <div id="send-feedback-modal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 z-50">
        <div class="fixed inset-0 bg-black opacity-50"></div>
        <div id="send-feedback-form" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-96 p-4 relative">
            <form action="{{ route('feedback.store') }}" method="POST">
                @csrf
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Send Feedback
                    <button type="button" onclick="document.getElementById('send-feedback-modal').classList.toggle('hidden');" class="absolute top-4 right-4 text-sscr-red">@include('components.icons.x')</button>
                </h2>
                <div id="feedback-stars-container" class="flex gap-2 justify-center my-4">
                    <a id="star-1" class="star text-sscr-red cursor-pointer" onclick="setRating(1)">@include('components.icons.star-filled')</a>
                    <a id="star-2" class="star text-sscr-red cursor-pointer" onclick="setRating(2)">@include('components.icons.star')</a>
                    <a id="star-3" class="star text-sscr-red cursor-pointer" onclick="setRating(3)">@include('components.icons.star')</a>
                    <a id="star-4" class="star text-sscr-red cursor-pointer" onclick="setRating(4)">@include('components.icons.star')</a>
                    <a id="star-5" class="star text-sscr-red cursor-pointer" onclick="setRating(5)">@include('components.icons.star')</a>
                </div>
                <input class="hidden" id="feedback-rating" type="number" hidden name="rating" value="1">
                <textarea name="feedback" required class="w-full p-2 border rounded-md dark:bg-gray-700 dark:text-gray-100" rows="5"
                    placeholder="Write your feedback..."></textarea>
                <input type="submit"
                    class="w-full bg-sscr-red text-white font-light py-2 px-4 rounded-md cursor-pointer" value="Submit Feedback" />
            </form>
        </div>
    </div>
@endif

<div id="notifications-modal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 z-50">
    <div class="fixed inset-0 bg-black opacity-50"></div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-96 p-4 relative">
        <h2 class="text-md font-semibold text-gray-800 dark:text-gray-100">
            Notifications
            <button type="button" onclick="document.getElementById('notifications-modal').classList.toggle('hidden'); getNotification(); readNotifications(); getHasMessages();" class="absolute top-4 right-4 text-sscr-red">@include('components.icons.x')</button>
        </h2>
        <div id="notifications-container" class="mt-4 space-y-2">

        </div>
        <div class="mt-4 flex justify-between">
            <button id="prev-btn" class="bg-sscr-red text-white px-3 py-1 rounded disabled:opacity-50 text-xs" disabled>Previous</button>
            <button id="next-btn" class="bg-sscr-red text-white px-3 py-1 rounded text-xs">Next</button>
        </div>
    </div>
</div>

@if (Auth::user()->role === 'alumni')
    <script>
            function setRating(rating) {
            const stars = document.querySelectorAll('#feedback-stars-container a');
            const ratingInput = document.getElementById('feedback-rating');
            ratingInput.value = `${rating}`;
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.innerHTML = `@include('components.icons.star-filled')`;
                } else {
                    star.innerHTML = `@include('components.icons.star')`;
                }
            });
        }
    </script>
@endif

<script>

    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('sticky-navbar');

        if (window.scrollY > 0) {
            navbar.classList.remove('bg-sscr-yellow', 'text-sscr-red');
            navbar.classList.add('bg-sscr-red', 'text-sscr-yellow', 'py-2');
            console.log("on");
        } else {
            navbar.classList.remove('bg-sscr-red' , 'text-sscr-yellow', 'py-2');
            navbar.classList.add('bg-sscr-yellow', 'text-sscr-red');
            console.log("off");
        }
    });

    document.getElementById('sticky-navbar-dropdown-trigger').addEventListener('click', function() {
        const menu = document.getElementById('sticky-navbar-dropdown');
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
        } else {
            menu.classList.add('hidden');
        }
    });

    window.addEventListener('click', function(event) {
        const dropdown = document.getElementById('dropdown');
        const menu = document.getElementById('sticky-navbar-dropdown');

        if (!dropdown.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });

    let notifications = [];
    let currentPage = 1;
    const pageSize = 5;

    async function getNotification() {
        const url = "{{ route('api.notification.index') }}";

        try {
            const response = await fetch(url);

            if (!response.ok) {
                throw new Error(`Response status: ${response.status}`);
            }

            const json = await response.json();
            notifications = json.notifications;
            displayNotifications();
        } catch (error) {
            console.error('Error fetching notifications:', error.message);
        }
    }

    async function readNotifications() {
        const url = "{{ route('api.markNotificationRead') }}";

        try {
            const response = await fetch(url);

            if (!response.ok) {
                throw new Error(`Response status: ${response.status}`);
            }

            const json = await response.json();
            displayNotifications();
            getNotification();
        } catch (error) {
            console.error('Error fetching notifications:', error.message);
        }
    }

    async function getHasMessages() {
        const url = "{{ route('api.getMessagesMark') }}";

        try {
            const response = await fetch(url);

            if (!response.ok) {
                throw new Error(`Response status: ${response.status}`);
            }

            const json = await response.json();
            console.log(json);
            if (json.hasMessage) {
                document.getElementById('messages-count').classList.remove('hidden');
            } else {
                document.getElementById('messages-count').classList.add('hidden');
            }
        } catch (error) {
            console.error('Error fetching notifications:', error.message);
        }
    }

    function displayNotifications() {
        const start = (currentPage - 1) * pageSize;
        const end = start + pageSize;
        const paginatedNotifications = notifications.slice(start, end);

        const length = document.getElementById('notification-count').textContent = notifications.filter(notification => !notification.is_read).length;
        if (length > 0) {
            document.getElementById('notification-count').classList.remove('hidden');
        } else {
            document.getElementById('notification-count').classList.add('hidden');
        }

        const notificationsContainer = document.getElementById('notifications-container');
        notificationsContainer.innerHTML = '';

        if (paginatedNotifications.length > 0) {
            paginatedNotifications.forEach(notification => {
                notificationsContainer.innerHTML += `
                    <a class="notification-item p-2 bg-gray-100 relative rounded block" ${notification?.url ? `href="${notification.url}"` : ''}>
                        <p class="text-sm text-gray-800">${notification.content}</p>
                        ${notification?.url ? `<p class="absolute bottom-1 font-bold text-sscr-red right-2 text-xs">--></p>` : ''}
                        <p class="text-xs text-gray-500 mt-2">${new Date(notification.created_at).toLocaleString()}</p>
                        ${notification.is_read ? `` : '<span id="messages-count" class=" absolute -top-1 -right-0 inline-flex items-center justify-center w-3 h-3 text-xs leading-none text-white bg-sscr-red rounded-full">•</span>'}
                    </a>
                `;
            });
        } else {
            notificationsContainer.innerHTML = '<p class="text-sm text-gray-500">No notifications available.</p>';
        }

        updatePaginationButtons();
    }

    function updatePaginationButtons() {
        const totalPages = Math.ceil(notifications.length / pageSize);

        document.getElementById('prev-btn').disabled = currentPage === 1;
        document.getElementById('next-btn').disabled = currentPage === totalPages;
    }

    document.getElementById('prev-btn').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            displayNotifications();
        }
    });

    document.getElementById('next-btn').addEventListener('click', () => {
        const totalPages = Math.ceil(notifications.length / pageSize);
        if (currentPage < totalPages) {
            currentPage++;
            displayNotifications();
        }
    });

    getNotification();
    getHasMessages();

</script>








