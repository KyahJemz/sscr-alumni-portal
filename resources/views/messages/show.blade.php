@extends('master')

@section('css')
@endsection

@section('content')
    <div class="bg-white rounded-lg container mx-auto p-1 max-w-7xl sm:px-1 lg:px-1 h-full">
        <div class="flex flex-row md:flex-row gap-1 h-[calc(100vh-130px)]">

            <div class="md:w-1/3 bg-white rounded-lg overflow-y-auto h-full relative scrollbar-hide border border-gray-300">
                <div class="p-4 sticky top-0 bg-white rounded-lg space-y-4 relative">
                    <div class="text-lg font-semibold text-gray-700 dark:text-gray-200 flex justify-between">
                        <span class="chat-full">Messages</span>
                        <button id="toggle-chat-list" class=" sm:flex md:hidden p-1 text-gray-700 dark:text-gray-200 focus:outline-none items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 4.5v15m6-15v15m-10.875 0h15.75c.621 0 1.125-.504 1.125-1.125V5.625c0-.621-.504-1.125-1.125-1.125H4.125C3.504 4.5 3 5.004 3 5.625v12.75c0 .621.504 1.125 1.125 1.125Z" />
                              </svg>
                        </button>
                    </div>
                    <input type="text" placeholder="Search people..." oninput="searchPeople(event)"
                        class="chat-full w-full text-sm px-4 py-2 border border-gray-300 rounded-lg text-gray-700 dark:text-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="chat-full absolute top-12 right-5 flex items-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </span>
                </div>

                <div id="chat-list" class="space-y-2 px-4 w-full chat-full">
                    @livewire('chats')
                </div>
                <div id="chat-list-heads" class="space-y-2 px-2 w-full hidden chat-full">
                    @livewire('chats-hide')
                </div>
                <div id="people-list" class="hidden space-y-2 px-4 w-full">

                </div>
            </div>

            <div class="md:w-2/3 bg-white p-4 rounded-lg flex flex-col flex-1 rounded-lg border border-gray-300">
                <div class="flex justify-between items-center border-b pb-3 mb-4 dark:border-gray-700">
                    <a
                        class="text-lg font-semibold text-gray-700 hover:text-gray-500 hover:font-light cursor-pointer"
                        href="{{ $group->name ? route('groups.show', ['group' => $group->id]) : route('user.index', ['id' => $receiver->id]) }}"
                    >
                        {{ $group->name ??
                            (optional($receiver->alumniInformation)->first_name . ' ' . optional($receiver->alumniInformation)->last_name) ??
                            (optional($receiver->adminInformation)->first_name . ' ' . optional($receiver->adminInformation)->last_name) ??
                            'Unknown' }}
                    </a>
                    <div class="flex space-x-4">
                        {{-- <button class="text-gray-600 dark:text-gray-300 hover:text-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
                            </svg>
                        </button> --}}
                    </div>
                </div>

                @livewire('messages', ['receiverId' => $chatId, 'isGroup' => $isGroup])

                <form class="mt-4 flex items-center space-x-3" id="send-message-form" onsubmit="sendMessage(event)">
                    <input type="text" placeholder="Type your message..." name="message"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="px-4 py-2 bg-sscr-red text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Send
                    </button>
                </form>
            </div>

        </div>
    </div>
@endsection

@section('scripts')

<script>
    let chatListWindow = true;
    document.getElementById('toggle-chat-list').addEventListener('click', function () {
        document.querySelectorAll('.chat-full').forEach(e => e.classList.toggle('hidden'));
        chatListWindow = !chatListWindow;
    });
</script>

    <script>
        const people = @json($users);

        function searchPeople(event) {
            let searchValue = event.target.value.toLowerCase();
            const chatList = document.getElementById('chat-list');
            const peopleList = document.getElementById('people-list');

            if (searchValue !== '') {
                chatList.classList.add('hidden');
                peopleList.classList.remove('hidden');
            } else {
                chatList.classList.remove('hidden');
                peopleList.classList.add('hidden');
            }

            peopleList.innerHTML = '';

            people.forEach(user => {
                const fullName = `${user.alumni_information?.first_name ?? user.admin_information?.first_name ?? ''} ${user.alumni_information?.last_name ?? user.admin_information?.last_name ?? ''}`.toLowerCase();

                if (fullName.includes(searchValue)) {
                    peopleList.innerHTML += `
                        <a href="/messages/${user.id}" class="w-full bg-white dark:bg-gray-700 p-2 rounded-lg flex items-center gap-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600">
                            <img class="w-10 h-10 rounded-full object-cover bg-gray-300" src="{{ asset('storage/profile/images')}}/${user?.image ?? 'default.jpg'}" alt="Person">
                            <div class="flex flex-col w-full">
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">${fullName}</p>
                            </div>
                        </a>
                    `;
                }
            });

            if (peopleList.innerHTML === '') {
                peopleList.innerHTML = '<p>No users found.</p>';
            }
        }
    </script>

    <script>
        async function sendMessage(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            formData.append('receiver_id', {{ $chatId }});
            formData.append('is_group', {{ $isGroup ? 'true' : 'false'  }});
            const url = "{{ route('messages.store') }}";
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
                scrollToBottom();
                e.target.reset();
            } catch (error) {
                console.error(error.message);
            }
        }

        const chatContainer = document.getElementById('messages-container');

        function isAtBottom() {
            return chatContainer.scrollTop + chatContainer.clientHeight >= chatContainer.scrollHeight - 10;
        }

        function scrollToBottom() {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        scrollToBottom();

        let autoScroll = true;

        chatContainer.addEventListener('scroll', () => {
            autoScroll = isAtBottom();
        });
    </script>
@endsection
