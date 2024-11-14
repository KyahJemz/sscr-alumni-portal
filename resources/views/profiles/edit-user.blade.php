@extends('master')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col">
            <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
                Edit User Information Section
            </h2>
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>
            <form method="post" action="{{ route('user.update', ['user' => $user->id]) }}" class="space-y-6"
                enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div>
                    <label for="image" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">Profile
                        Image</label>
                    <img id="image-preview"
                        src="{{ $user->image ? asset('storage/profile/images/' . $user->image) : asset('storage/profile/images/default.jpg') }}"
                        onerror="this.onerror=null;this.src='{{ asset('storage/profile/images/default.jpg') }}';"
                        alt="Profile Image" class="rounded-full w-32 h-32 border-gray-300 dark:border-gray-700 mb-4">
                    <input id="image" class="mt-1 block w-full cursor-pointer" type="file" name="image"
                        accept="image/png, image/jpeg" />
                </div>

                <div>
                    <label for="id-image" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">Profile
                        Id Image</label>
                    <img id="id-image-preview"
                        src="{{ $user->id_image ? asset('storage/profile/images/' . $user->id_image) : asset('storage/profile/images/default.jpg') }}"
                        onerror="this.onerror=null;this.src='{{ asset('storage/profile/images/default.jpg') }}';"
                        alt="Profile Id Image" class="rounded-full w-32 h-32 border-gray-300 dark:border-gray-700 mb-4">
                    <input id="id_image" class="mt-1 block w-full cursor-pointer" type="file" name="id_image"
                        accept="image/png, image/jpeg" />
                </div>

                <div>
                    <label for="username"
                        class="block font-medium text-sm text-gray-700 dark:text-gray-300">Username</label>
                    <input id="username"
                        class="bg-gray-200 mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-200 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        type="text" value="{{ $user->username }}" disabled />
                </div>

                <div>
                    <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Email</label>
                    <input id="email" name="email"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-200 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        type="email" value="{{ $user->email }}" autocomplete="email" required />
                    @if ($errors->has('email'))
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->first('email') }}</p>
                    @endif

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                Your email address is unverified.
                                <button form="send-verification"
                                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                    Click here to re-send the verification email.
                                </button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                    A new verification link has been sent to your email address.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit"
                        class="bg-gray-600 py-2 px-4 rounded-md shadow-sm hover:bg-gray-600 text-white border border-gray-600">Update</button>
                    @if (session('status'))
                        <p class="text-sm text-gray-600 dark:text-gray-600">{{session('status')}}</p>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col">
            <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
                @include('components.icons.danger')&nbsp;Edit User Password Section
            </h2>
            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                @method('put')

                <div>
                    <label for="update_password_current_password"
                        class="block font-medium text-sm text-gray-700 dark:text-gray-300">Current Password</label>
                    <input id="update_password_current_password" name="current_password" type="password"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-200 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        autocomplete="current-password" />
                    @if ($errors->updatePassword->has('current_password'))
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                            {{ $errors->updatePassword->first('current_password') }}</p>
                    @endif
                </div>

                <div>
                    <label for="update_password_password"
                        class="block font-medium text-sm text-gray-700 dark:text-gray-300">New Password</label>
                    <input id="update_password_password" name="password" type="password"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-200 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        autocomplete="new-password" />
                    @if ($errors->updatePassword->has('password'))
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                            {{ $errors->updatePassword->first('password') }}</p>
                    @endif
                </div>

                <div>
                    <label for="update_password_password_confirmation"
                        class="block font-medium text-sm text-gray-700 dark:text-gray-300">Confirm Password</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-200 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        autocomplete="new-password" />
                    @if ($errors->updatePassword->has('password_confirmation'))
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                            {{ $errors->updatePassword->first('password_confirmation') }}</p>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit"
                        class="bg-gray-600 py-2 px-4 rounded-md shadow-sm hover:bg-gray-600 text-white border border-gray-600">Update</button>
                    @if (session('status') === 'password-updated')
                        <p class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col">
            <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
                @include('components.icons.danger')&nbsp;Delete User Section
            </h2>
            <form method="post" action="{{ route('user.destroy', ['user' => $user->id]) }}" class="space-y-6">
                @csrf
                @method('delete')

                <div>
                    <label for="password"
                        class="block font-medium text-sm text-gray-700 dark:text-gray-300">Password</label>
                    <input id="password" name="password" type="password"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-200 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        autocomplete="current-password" />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit"
                        class="bg-gray-600 py-2 px-4 rounded-md shadow-sm hover:bg-gray-600 text-white border border-gray-600">Delete
                        Account</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('image-preview').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
