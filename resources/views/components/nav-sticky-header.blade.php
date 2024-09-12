<div x-data="{ open: false, isSticky: false }" @scroll.window="isSticky = window.scrollY > 0" class="hidden sm:flex md:flex lg:flex border-t border-sscr-yellow sticky top-0 z-10 transition ease-in-out duration-500" :class="{ 'bg-sscr-red py-2': isSticky, 'bg-sscr-yellow': !isSticky }">
    <div class="max-w-7xl mx-auto sm:flex md:flex lg:flex justify-between py-1 w-full">
        <div class="hidden sm:-my-px sm:flex">
            <x-nav-link :href="route('dashboard')">
                {{ __('Home') }}
            </x-nav-link>
            <x-nav-link :href="route('dashboard')">
                {{ __('My Organizations') }}
            </x-nav-link>
            <x-nav-link :href="route('dashboard')">
                {{ __('Announcements') }}
            </x-nav-link>
            <x-nav-link :href="route('dashboard')">
                {{ __('Events') }}
            </x-nav-link>
            @if (Auth::user()->role !== 'alumni')
                <x-nav-link :href="route('dashboard')">
                    {{ __('Accounts') }}
                </x-nav-link>
            @endif
        </div>

        <div class="hidden sm:flex sm:items-center ">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 text-sm leading-4 font-medium rounded-md text-gray-100 dark:text-gray-100 cursor-pointer bg-sscr-red/0 dark:bg-sscr-red/0 hover:text-gray-200 dark:hover:text-gray-200 focus:outline-none transition ease-in-out duration-150 hover:text-gray-300/80 dark:hover:text-gray-300/80">
                        <div>{{ Auth::user()->name }}</div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.details')">
                        {{ __('Profile') }}
                    </x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</div>
