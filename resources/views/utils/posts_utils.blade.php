<script>
    function addEvents() {
        document.querySelectorAll('[data-carousel="slide"]').forEach(slider => {
            const prevButton = slider.querySelector('[data-carousel-prev]');
            const nextButton = slider.querySelector('[data-carousel-next]');
            const items = slider.querySelectorAll('[data-carousel-item]');
            let currentIndex = 0;

            const showItem = (index) => {
                items.forEach((item, i) => {
                    item.classList.toggle('hidden', i !== index);
                });
            };

            prevButton.addEventListener('click', () => {
                currentIndex = (currentIndex > 0) ? currentIndex - 1 : items.length - 1;
                showItem(currentIndex);
            });

            nextButton.addEventListener('click', () => {
                currentIndex = (currentIndex < items.length - 1) ? currentIndex + 1 : 0;
                showItem(currentIndex);
            });

            showItem(currentIndex);
        });
    }

    async function sendComment(e) {
        e.preventDefault();
        const commentBox = e.target.querySelector('textarea');
        const formData = new FormData(e.target);
        const url = "{{ route('api.comment.store') }}";
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
            const json = await response.json();
            commentBox.value = '';
            alertModal(json.message);
            getPosts();
        } catch (error) {
            alertModal(error.message);
            console.error(error.message);
        }
    }

    function deleteCommentConfirmation(commentId) {
        confirmation('Are you sure you want to delete this comment?', () => deleteComment(commentId));
    }

    async function deleteComment(commentId) {
        const formData = new FormData();
        formData.append("_method", "DELETE");
        formData.append("comment_id", commentId);
        const url = "/api/comment/";
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
            const json = await response.json();
            alertModal(json.message);
            getPosts();
        } catch (error) {
            alertModal(error.message);
            console.error(error.message);
        }
    }

    async function sendLike(e) {
        e.preventDefault();
        const likeBox = e.target.querySelector('.like');
        const formData = new FormData(e.target);
        const url = "{{ route('api.like.store') }}";
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
            const json = await response.json();
            likeBox.innerHTML = `@include('components.icons.heart-filled')`;
            getPosts();
        } catch (error) {
            console.error(error.message);
        }
    }

    async function deleteLike(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            formData.append("_method", "DELETE");
            const url = "{{ route('api.like.destroy') }}";
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
                const json = await response.json();
                getPosts();
            } catch (error) {
                console.error(error.message);
            }
        }
<script >
