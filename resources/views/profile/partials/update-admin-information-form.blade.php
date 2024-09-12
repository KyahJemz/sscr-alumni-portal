<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/4 px-3">
                <label for="last_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Last Name</label>
                <input id="last_name" name="last_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="text" required />
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="first_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">First Name</label>
                <input id="first_name" name="first_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="text" required />
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="middle_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Middle Name</label>
                <input id="middle_name" name="middle_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="text" />
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="sufix" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Suffix</label>
                <input id="sufix" name="sufix" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="text" />
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="department" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Department</label>
                <input id="department" name="department" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="text" />
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="role" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Role</label>
                <input id="role" name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="text" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
