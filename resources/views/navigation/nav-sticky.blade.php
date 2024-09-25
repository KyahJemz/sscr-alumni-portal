<div id="sticky-navbar"
    class="md:flex lg:flex border-t border-sscr-yellow sticky top-0 z-10 transition ease-in-out duration-500 bg-sscr-yellow">
    <div class="max-w-7xl mx-auto sm:flex md:flex lg:flex justify-between py-1 w-full">
        <div class="sm:-my-px sm:flex">
            <a href="{{ route('home') }}"
                class='inline-flex text-gray-100 dark:text-gray-100 hover:text-gray-300/80 dark:hover:text-gray-300/80 items-center px-8 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                Home
            </a>
            <a href="{{ route('groups.index') }}"
                class='inline-flex text-gray-100 dark:text-gray-100 hover:text-gray-300/80 dark:hover:text-gray-300/80 items-center px-8 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                {{ (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator') ? 'Organizations' : 'My Organizations' }}
            </a>
            <a href="{{ route('home') }}"
                class='inline-flex text-gray-100 dark:text-gray-100 hover:text-gray-300/80 dark:hover:text-gray-300/80 items-center px-8 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                Announcements
            </a>
            <a href="{{ route('home') }}"
                class='inline-flex text-gray-100 dark:text-gray-100 hover:text-gray-300/80 dark:hover:text-gray-300/80 items-center px-8 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                Events
            </a>
            @if (Auth::user()->role !== 'alumni')
                <a href="{{ route('account.index') }}"
                    class='inline-flex text-gray-100 dark:text-gray-100 hover:text-gray-300/80 dark:hover:text-gray-300/80 items-center px-8 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                    Accounts
                </a>
            @endif
        </div>

        <div class="sm:flex sm:items-center gap-2">
            <a href="{{ route('messages.index') }}" title="Messages"
                class='inline-flex text-gray-100 dark:text-gray-100 hover:text-gray-300/80 dark:hover:text-gray-300/80 items-center border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                @include('components.icons.chat')
            </a>
            <a href="{{ route('home') }}" title="Notifications"
                class='inline-flex text-gray-100 dark:text-gray-100 hover:text-gray-300/80 dark:hover:text-gray-300/80 items-center border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                @include('components.icons.bell')
            </a>
            <div id="dropdown" class="relative" title="Profile">
                <button id="sticky-navbar-dropdown-trigger"
                    class="flex gap-2 items-center px-3 text-sm font-medium rounded-md text-gray-100 dark:text-gray-100 cursor-pointer bg-sscr-red/0 dark:bg-sscr-red/0 hover:text-gray-200 dark:hover:text-gray-200 focus:outline-none transition ease-in-out duration-150 hover:text-gray-300/80 dark:hover:text-gray-300/80">
                    <img class="w-6 h-6 rounded-full m-0 p-0"
                        src="{{ Auth::user()->image ? asset('storage/profile/images/' . Auth::user()->image) : asset('storage/profile/images/default.jpg') }}"
                        onerror="this.onerror=null;this.src='{{ asset('storage/profile/images/default.jpg') }}';"
                        alt="Profile">
                        {{ optional(Auth::user()->alumniInformation)->getName() ?? optional(Auth::user()->adminInformation)->getName() ?? Auth::user()->username }}

                </button>

                <div id="sticky-navbar-dropdown"
                    class="absolute z-50 mt-2 hidden rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5">
                    <a href="{{ route('user.index') }}"
                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
                        Profile
                    </a>
                    @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator' || Auth::user()->role === 'program_chair')
                        <a href="{{ route('feedback.index') }}"
                            class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
                            Feedback
                        </a>
                    @else
                        <button id="send-feedback-trigger"
                            type="button"
                            onclick="document.getElementById('send-feedback-modal').classList.toggle('hidden');"
                            class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
                            Send Feedback
                        </button>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
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
            navbar.classList.remove('bg-sscr-yellow');
            navbar.classList.add('bg-sscr-red', 'py-2');
            console.log("on");
        } else {
            navbar.classList.remove('bg-sscr-red', 'py-2');
            navbar.classList.add('bg-sscr-yellow');
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
</script>








