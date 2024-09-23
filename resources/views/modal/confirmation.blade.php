<div id="confirmation-modal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 z-50">
    <div class="fixed inset-0 bg-black opacity-50"></div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-96 p-4 relative">
        <form id="confirmation-form" onsubmit="return false;">
            @csrf
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                Confirmation
                <button type="button" onclick="document.getElementById('confirmation-modal').classList.toggle('hidden');" class="absolute top-4 right-4 text-sscr-red">
                    @include('components.icons.x')
                </button>
            </h2>

            <div id="confirmation-message" class="flex gap-2 justify-center my-4">

            </div>

            <div class="flex justify-end gap-4">
                <button type="button" onclick="document.getElementById('confirmation-modal').classList.toggle('hidden');" class="px-4 py-2 text-gray-600 dark:text-gray-300">
                    No
                </button>
                <button type="button" onclick="confirmationAction(), document.getElementById('confirmation-modal').classList.toggle('hidden');" class="px-4 py-2 bg-sscr-red text-white rounded-lg">
                    Yes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let confirmationAction = function() {};
    function confirmation(message, action) {
        document.getElementById('confirmation-message').innerHTML = message;
        confirmationAction = action;
        document.getElementById('confirmation-modal').classList.toggle('hidden');
    }
</script>
