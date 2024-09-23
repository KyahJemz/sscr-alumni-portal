<script>
    function alertModal(message, seconds = 3) {
        const container = document.getElementById('alert-container');

        const alertDiv = document.createElement('div');
        alertDiv.classList.add('bg-sscr-red', 'text-white', 'px-4', 'py-3', 'rounded-lg', 'shadow-lg', 'transform', 'transition', 'translate-x-full', 'opacity-0');

        alertDiv.innerHTML = `
            <div class="flex justify-between items-center">
                <span>${message}</span>
                <button onclick="removeAlert(this)" class="ml-4 text-white font-bold">x</button>
            </div>
        `;

        container.appendChild(alertDiv);

        setTimeout(() => {
            alertDiv.classList.remove('translate-x-full', 'opacity-0');
            alertDiv.classList.add('translate-x-0', 'opacity-100');
        }, 100);

        setTimeout(() => {
            removeAlert(alertDiv);
        }, seconds * 1000);
    }

    function removeAlert(element) {
        if (!element) return;

        element.classList.remove('translate-x-0', 'opacity-100');
        element.classList.add('translate-x-full', 'opacity-0');

        setTimeout(() => {
            element.remove();
        }, 500);
    }
</script>
