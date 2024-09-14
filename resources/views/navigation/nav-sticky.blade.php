<div id="sticky-navbar" class="md:flex lg:flex border-t border-sscr-yellow sticky top-0 z-10 transition ease-in-out duration-500 bg-sscr-yellow">
    <div class="max-w-7xl mx-auto sm:flex md:flex lg:flex justify-between py-1 w-full">
        <div class="sm:-my-px sm:flex">
            <a href="{{route('home')}}" class='inline-flex text-gray-100 dark:text-gray-100 hover:text-gray-300/80 dark:hover:text-gray-300/80 items-center px-8 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                Home
            </a>
            <a href="{{route('groups.index')}}" class='inline-flex text-gray-100 dark:text-gray-100 hover:text-gray-300/80 dark:hover:text-gray-300/80 items-center px-8 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                My Organizations
            </a>
            <a href="{{route('home')}}" class='inline-flex text-gray-100 dark:text-gray-100 hover:text-gray-300/80 dark:hover:text-gray-300/80 items-center px-8 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                Announcements
            </a>
            <a href="{{route('home')}}" class='inline-flex text-gray-100 dark:text-gray-100 hover:text-gray-300/80 dark:hover:text-gray-300/80 items-center px-8 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                Events
            </a>
            @if (Auth::user()->role !== 'alumni')
            <a href="{{route('home')}}" class='inline-flex text-gray-100 dark:text-gray-100 hover:text-gray-300/80 dark:hover:text-gray-300/80 items-center px-8 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'>
                Accounts
            </a>
            @endif
        </div>

        <div class="sm:flex sm:items-center">
            <div id="dropdown" class="relative">
                <button id="sticky-navbar-dropdown-trigger" class="inline-flex items-center px-3 text-sm leading-4 font-medium rounded-md text-gray-100 dark:text-gray-100 cursor-pointer bg-sscr-red/0 dark:bg-sscr-red/0 hover:text-gray-200 dark:hover:text-gray-200 focus:outline-none transition ease-in-out duration-150 hover:text-gray-300/80 dark:hover:text-gray-300/80">
                    <div>{{ Auth::user()->name }}</div>
                </button>

                <div id="sticky-navbar-dropdown" class="absolute z-50 mt-2 hidden rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5">
                    <a href="{{route('user.index')}}" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
                            Log Out
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('scroll', function() {
        var navbar = document.getElementById('sticky-navbar');

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
        var menu = document.getElementById('sticky-navbar-dropdown');
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
        } else {
            menu.classList.add('hidden');
        }
    });

    window.addEventListener('click', function(event) {
        var dropdown = document.getElementById('dropdown');
        var menu = document.getElementById('dropdownMenu');
        if (!dropdown.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });

</script>
