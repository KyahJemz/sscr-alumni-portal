<nav class="bg-sscr-red dark:bg-sscr-red border-b border-gray-200 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative">
        <div class="flex w-full justify-between h-max py-4 sm:py-2 px-2">
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}">
                    <x-application-logo />
                </a>
            </div>
            <div class="flex sm:flex shrink-0 flex-1 items-center text-center flex-col">
                <p class="sm:text-3xl text-md text-sscr-yellow dark:text-sscr-yellow">San Sebastian College - Recoletos
                    de Cavite</p>
                <p class="sm:text-lg text-xs text-sscr-yellow dark:text-sscr-yellow">Alumni Portal</p>
            </div>
            <div class="hidden -me-2 flex items-center sm:hidden">
                <button id="menuToggle"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path id="menuIconOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path id="menuIconClose" class="hidden" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div id="responsiveMenu" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'text-gray-900' : 'text-gray-500' }} hover:text-gray-900 dark:hover:text-gray-400 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Home
                </a>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}"
                        class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium hover:text-gray-900 dark:hover:text-gray-400">
                        Profile
                    </a>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                            class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium hover:text-gray-900 dark:hover:text-gray-400"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Log Out
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    document.getElementById('menuToggle').addEventListener('click', function() {
            var menu = document.getElementById('responsiveMenu');
            var openIcon = document.getElementById('menuIconOpen');
            var closeIcon = document.getElementById('menuIconClose');

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                openIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
                openIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        });
</script>
