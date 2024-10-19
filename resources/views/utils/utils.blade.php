<script>
    function getTimeAgo(date) {
        const now = new Date();
        let dateObj = new Date(date);

        const timezoneOffsetInMinutes = dateObj.getTimezoneOffset();

        const correctTimezoneOffsetInMinutes = -480;

        if (timezoneOffsetInMinutes !== correctTimezoneOffsetInMinutes) {
            const offsetDifference = (correctTimezoneOffsetInMinutes - timezoneOffsetInMinutes) * 60 * 1000;
            dateObj = new Date(dateObj.getTime() + offsetDifference);
        }

        const diffInSeconds = Math.floor((now - dateObj) / 1000);

        if (diffInSeconds < 60) {
            return `${diffInSeconds} seconds ago`;
        } else if (diffInSeconds < 3600) {
            const minutes = Math.floor(diffInSeconds / 60);
            return `${minutes} minutes ago`;
        } else if (diffInSeconds < 86400) {
            const hours = Math.floor(diffInSeconds / 3600);
            return `${hours} hours ago`;
        } else {
            const days = Math.floor(diffInSeconds / 86400);
            return `${days} days ago`;
        }
    }

    function getHumanReadableDate(date) {
        const options = {
            weekday: 'short',
            month: 'short',
            day: 'numeric',
            year: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            hour12: true };
        return new Date(date).toLocaleDateString('en-US', options);
    }
</script>
