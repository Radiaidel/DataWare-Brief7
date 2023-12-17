// like_dislike.js

document.addEventListener('DOMContentLoaded', function () {
    // Assuming you have buttons with class 'like-btn' and 'dislike-btn'
    document.querySelectorAll('.like-btn, .dislike-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var isLikeButton = this.classList.contains('like-btn');
            var questionId = this.dataset.questionId;

            // Perform AJAX request
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Update UI or handle response if needed
                    console.log(xhr.responseText);
                }
            };

            xhr.open('POST', 'update_likes_dislikes.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('action=' + (isLikeButton ? 'like' : 'dislike') + '&question_id=' + questionId);
        });
    });
});
