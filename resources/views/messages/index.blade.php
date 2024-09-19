@extends('master')

@section('content')
    <div class="bg-white dark:bg-gray-800 container mx-auto p-1 max-w-7xl sm:px-1 lg:px-1 h-max" >

        <div class="flex flex-row md:flex-row gap-1 h-96 w-full">

            <div class="md:w-1/3 bg-gray-100 dark:bg-gray-900 rounded-lg overflow-y-auto h-full relative">
                <div class="p-4 sticky top-0 bg-gray-100 rounded-lg space-y-4">
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
                    <div
                        class="w-full bg-white dark:bg-gray-700 p-2 rounded-lg flex items-center gap-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600">
                        <img class="w-10 h-10 rounded-full object-cover" src="https://via.placeholder.com/150" alt="Person 1">
                        <div class="flex flex-col w-full">
                            <p class="text-md font-semibold text-gray-700 dark:text-gray-200">Person 1</p>
                            <div class="text-xs text-gray-500 dark:text-gray-400 flex justify-between w-full">
                                <p class="truncate"></p>
                                <p class="w-max whitespace-nowrap font-light italic">asdadafsasa sd a</p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>


            <div class="md:w-2/3 bg-white dark:bg-gray-800 p-4 rounded-lg flex flex-col flex-1">
                <div class="flex justify-between items-center border-b pb-3 mb-4 dark:border-gray-700">
                    <div class="text-lg font-semibold text-gray-700 dark:text-gray-200">Message Header</div>
                    <div class="flex space-x-4">
                        <button class="text-gray-600 dark:text-gray-300 hover:text-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24"
                                stroke="currentColor" fill="none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v12m6-6H6" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex-grow space-y-4 overflow-y-auto">
                    <div class="flex items-start">
                        <img class="w-10 h-10 rounded-full" src="https://via.placeholder.com/150" alt="Person 1">
                        <div class="ml-4 bg-gray-200 dark:bg-gray-700 p-3 rounded-lg max-w-md">
                            <p class="text-sm text-gray-700 dark:text-gray-300">Test</p>
                        </div>
                    </div>

                    <div class="flex items-start justify-end">
                        <div class="ml-4 bg-sscr-red text-white p-3 rounded-lg max-w-md">
                            <p class="text-sm">Test</p>
                        </div>
                    </div>

                </div>

                <form class="mt-4 flex items-center space-x-3">
                    <input type="text" placeholder="Type your message..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Send
                    </button>
                </form>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script></script>
@endsection
