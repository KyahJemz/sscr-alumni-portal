@extends('master')

@section('css')
@endsection

@section('content')
    <div class="bg-white rounded-lg container mx-auto p-1 max-w-7xl sm:px-1 lg:px-1 h-full">
        <div class="flex flex-row md:flex-row gap-1 h-[calc(100vh-130px)]">

            <div class="md:w-1/3 bg-white rounded-lg overflow-y-auto h-full relative scrollbar-hide border border-gray-300">
                <div class="p-4 sticky top-0 bg-white rounded-lg space-y-4">
                    <div class="text-lg font-semibold text-gray-700 dark:text-gray-200">Messages</div>
                    <input type="text" placeholder="Search people..."
                        class="w-full text-sm px-4 py-2 border border-gray-300 rounded-lg text-gray-700 dark:text-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="absolute inset-y-0 right-4 flex items-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.9 14.32a8.02 8.02 0 10-1.41 1.41l4.18 4.17a1 1 0 001.41-1.41l-4.18-4.17zM7.5 12a4.5 4.5 0 110-9 4.5 4.5 0 010 9z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </div>

                <div class="space-y-2 px-4 w-full">
                    @for ($i = 0; $i < 50; $i++)
                        <div
                            class="w-full bg-white dark:bg-gray-700 p-2 rounded-lg flex items-center gap-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600">
                            <img class="w-10 h-10 rounded-full object-cover bg-gray-300"
                                src="https://via.placeholder.com/150" alt="Person 1">
                            <div class="flex flex-col w-full">
                                <p class="text-md font-semibold text-gray-700 dark:text-gray-200">Person 1</p>
                                <div class="text-xs text-gray-500 dark:text-gray-400 flex justify-between w-full">
                                    <p class="truncate"></p>
                                    <p class="w-max whitespace-nowrap font-light italic">asdadafsasa sd a</p>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="md:w-2/3 bg-white p-4 rounded-lg flex flex-col flex-1 rounded-lg border border-gray-300">
                <div class="flex justify-between items-center border-b pb-3 mb-4 dark:border-gray-700">
                    <div class="text-lg font-semibold text-gray-700">Kupal Kaba Boss</div>
                    <div class="flex space-x-4">
                        <button class="text-gray-600 dark:text-gray-300 hover:text-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24"
                                stroke="currentColor" fill="none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div id="messages-container"
                    class="flex-grow space-y-2 overflow-y-auto scrollbar-hide bg-white flex-col-reverse justify-end">
                    {{-- @for ($i = 0; $i < 50; $i++)
                        <div class="flex items-start">
                            <img class="w-10 h-10 rounded-full" src="https://via.placeholder.com/150" alt="Person 1">
                            <div class="ml-4 bg-gray-200 dark:bg-gray-700 px-3 py-2 rounded-lg max-w-md">
                                <p class="text-sm text-gray-700 dark:text-gray-300">Test</p>
                            </div>
                        </div>

                        <div class="flex items-start justify-end">
                            <div class="ml-4 bg-sscr-red text-white px-3 py-2 rounded-lg max-w-md">
                                <p class="text-sm">Test</p>
                            </div>
                        </div>
                    @endfor --}}

                </div>

                <form class="mt-4 flex items-center space-x-3">
                    <input type="text" placeholder="Type your message..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                        class="px-4 py-2 bg-sscr-red text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Send
                    </button>
                </form>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        async function getData() {
            const url = "{{ route('chats.show', ['id' => 4]) }}";
            try {
                const response = await fetch(url);
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }
                const json = await response.json();
                console.log(json);
                addMessages(json);
                // setInterval(() => {
                //     addMessages(json);
                // }, 1000);
            } catch (error) {
                console.error(error.message);
            }
        }

        const received = (name, message, time) => `
            <div class="flex items-start">
                <img class="w-10 h-10 rounded-full" src="https://via.placeholder.com/150" alt="Person 1">
                <div class="ml-4 bg-gray-200 dark:bg-gray-700 px-3 py-2 rounded-lg max-w-md">
                    <p class="text-sm text-gray-700 dark:text-gray-300">${message}</p>
                </div>
            </div>
        `;

        const sent = (name, message, time) => `
            <div class="flex items-start justify-end">
                <div class="ml-4 bg-sscr-red text-white px-3 py-2 rounded-lg max-w-md">
                    <p class="text-sm">${message}</p>
                </div>
            </div>
        `;

        const addMessages = (messages) => {
            if (messages) {
                messages?.forEach(message => {
                    if (message.sent_by === {{ Auth::user()->id }}) {
                        document.querySelector('#messages-container').innerHTML += sent(message.sent_by, message
                            .message, message.created_at);
                    } else {
                        document.querySelector('#messages-container').innerHTML += received(message.received_by,
                            message.message, message.created_at);
                    }
                });
            }
        }

        getData();


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
