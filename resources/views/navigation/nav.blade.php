<nav class="bg-sscr-red border-b border-gray-200 sm:sticky top-0 md:relative z-10">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 relative">
        <div class="flex w-full justify-between h-max py-4 sm:py-2 items-center relative">
            <div class="sm:hidden md:flex absolute items-center">
                <a href="{{ route('posts.index') }}">
                    <img class="h-16 w-auto" src="{{ asset('storage/stags.png') }}" alt="San Sebastian College - Recoletos de Cavite">
                </a>
            </div>
            <div class="sm:hidden md:flex shrink-0 flex-1 items-center text-center flex-col">
                <p class="text-3xl text-sscr-yellow">San Sebastian College - Recoletos de Cavite</p>
                <p class="text-lg text-sscr-yellow">Alumni Portal</p>
            </div>
            <div class="sm:flex md:hidden shrink-0 flex-1 items-center text-center flex-col">
                <p class="text-2xl text-sscr-yellow">SSC-RdC Alumni Portal</p>
            </div>

            <div class="sm:flex md:hidden items-center">
                <button id="menuToggle" class="inline-flex items-center justify-center p-2 rounded-md text-gray-200 hover:text-gray-200 focus:outline-none transition duration-150 ease-in-out">
                    <svg id="menuIconOpen" class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="menuIconClose" class="hidden h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <div id="responsiveMenu" class="hidden sm:flex sm:flex-col md:hidden rounded-b-xl absolute bg-sscr-red w-full z-10 -mx-6 p-6">
            <a href="{{ route('posts.index') }}" class="{{ request()->routeIs('posts.index') ? 'text-gray-300' : 'text-gray-300' }} block pl-3 pr-4 py-2 text-base font-medium border-t-2 border-gray-300">
                Home
            </a>
            <a href="{{ route('groups.index') }}" class="{{ request()->routeIs('groups.index') ? 'text-gray-300' : 'text-gray-300' }} block pl-3 pr-4 py-2 text-base font-medium">
                {{ (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator') ? 'Organizations' : 'My Organizations' }}
            </a>
            <a href="{{ route('news.index') }}" class="{{ request()->routeIs('news.index') ? 'text-gray-300' : 'text-gray-300' }} block pl-3 pr-4 py-2 text-base font-medium">
                News
            </a>
            <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.index') ? 'text-gray-300' : 'text-gray-300' }} block pl-3 pr-4 py-2 text-base font-medium">
                Events
            </a>
            <a href="{{ route('announcements.index') }}" class="{{ request()->routeIs('announcements.index') ? 'text-gray-300' : 'text-gray-300' }} block pl-3 pr-4 py-2 text-base font-medium">
                Announcements
            </a>
            <a href="{{ route('messages.index') }}" title="Messages" class="{{ request()->routeIs('messages.index') ? 'text-gray-300' : 'text-gray-300' }} block pl-3 pr-4 py-2 text-base font-medium">
                Chats
            </a>
            <a onclick="document.getElementById('notifications-modal').classList.toggle('hidden');" title="Notifications" class="{{ request()->routeIs('notifications.index') ? 'text-gray-300' : 'text-gray-300' }} block pl-3 pr-4 py-2 text-base font-medium">
                Notifications
            </a>
            @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator' || Auth::user()->role === 'program_chair')
                <a href="{{ route('feedback.index') }}"
                    class="block pl-3 pr-4 py-2 text-base font-medium text-gray-300">
                    Feedback
                </a>
            @else
                <a id="send-feedback-trigger"
                    type="button"
                    onclick="document.getElementById('send-feedback-modal').classList.toggle('hidden');"
                    class="block pl-3 pr-4 py-2 text-base font-medium text-gray-300">
                    Send Feedback
                </a>
            @endif
            @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
                <a href="{{ route('hobbies.index') }}"
                    class="block pl-3 pr-4 py-2 text-base font-medium text-gray-300">
                    Hobbies Management
                </a>
            @endif
            @if (Auth::user()->role !== 'alumni')
                <a href="{{ route('account.index', ['type'=>'alumni']) }}" class='text-gray-300 block pl-3 pr-4 py-2 text-base font-medium'>
                    Alumni Accounts
                </a>
                <a href="{{ route('account.index', ['type'=>'graduates']) }}" class='text-gray-300 block pl-3 pr-4 py-2 text-base font-medium'>
                    Graduation List
                </a>
                @if(Auth::user()->role === 'cict_admin')
                    <a href="{{ route('account.index', ['type'=>'admins']) }}" class='text-gray-300 block pl-3 pr-4 py-2 text-base font-medium'>
                        Management Accounts
                    </a>
                @endif
            @endif

            <div class="pt-4 pb-1 border-t-2 border-gray-300">
                <div class="px-3">
                    <div class="font-medium text-base text-gray-300">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-300">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('user.index') }}" class="text-gray-300 block pl-3 pr-4 py-2 text-base font-medium">
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="text-gray-300 block pl-3 pr-4 py-2 text-base font-medium" onclick="event.preventDefault(); this.closest('form').submit();">
                            Log Out
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    const menuToggle = document.getElementById('menuToggle');
    const menu = document.getElementById('responsiveMenu');
    const openIcon = document.getElementById('menuIconOpen');
    const closeIcon = document.getElementById('menuIconClose');

    menuToggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        openIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    });
</script>
