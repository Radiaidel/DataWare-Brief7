
    // Define an object to store the current state of questions (liked, disliked, or neither)
    var questionStates = {};

    // Function to create and configure the XMLHttpRequest object
    function createXHR() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Update the like or dislike count on the page
                var response = JSON.parse(xhr.responseText);

                // Get the question ID, current state, and elements within the xhr.onreadystatechange function
                var questionId = xhr._questionId;
                var currentState = questionStates[questionId] || 'neither';
                var likesCountElement = xhr._likesCountElement;
                var dislikesCountElement = xhr._dislikesCountElement;

                if (xhr._isLikeButton && likesCountElement) {
                    likesCountElement.innerText = response.likes !== undefined ? response.likes : '';
                } else if (!xhr._isLikeButton && dislikesCountElement) {
                    dislikesCountElement.innerText = response.dislikes !== undefined ? response.dislikes : '';
                }

                // Toggle the state for the question
                if (currentState === 'neither') {
                    questionStates[questionId] = xhr._isLikeButton ? 'liked' : 'disliked';
                } else if (currentState === 'liked' && xhr._isLikeButton) {
                    // If previously liked, remove like
                    questionStates[questionId] = 'neither';
                } else if (currentState === 'disliked' && !xhr._isLikeButton) {
                    // If previously disliked, remove dislike
                    questionStates[questionId] = 'neither';
                } else {
                    // Update the state based on the current action
                    questionStates[questionId] = xhr._isLikeButton ? 'liked' : 'disliked';
                }
            }
        };
        return xhr;
    }

    // Add event listeners to all like and dislike buttons
    var likeButtons = document.querySelectorAll('.like-button');
    likeButtons.forEach(function (likeButton) {
        likeButton.addEventListener('click', function () {
            handleLikeDislikeClick(likeButton, true);
        });
    });

    var dislikeButtons = document.querySelectorAll('.dislike-button');
    dislikeButtons.forEach(function (dislikeButton) {
        dislikeButton.addEventListener('click', function () {
            handleLikeDislikeClick(dislikeButton, false);
        });
    });

    // Function to handle like or dislike button click
    function handleLikeDislikeClick(button, isLikeButton) {
        // Check if the button has already been clicked
        if (button.classList.contains('disabled')) {
            return; // Ignore the click if the button is disabled
        }

        // Get the question ID and current like/dislike count from the button's data attributes
        var questionId = button.getAttribute('data-question-id');
        var currentState = questionStates[questionId] || 'neither';
        var likesCountElement = button.querySelector('.like-count');
        var dislikesCountElement = button.querySelector('.dislike-count');

        // If the button is a like button and the question is already disliked, remove the dislike
        if (isLikeButton && currentState === 'disliked') {
            removeDislike(questionId, dislikesCountElement);
        }

        // If the button is a dislike button and the question is already liked, remove the like
        else if (!isLikeButton && currentState === 'liked') {
            removeLike(questionId, likesCountElement);
        }

        // Create and configure the XMLHttpRequest object
        var xhr = createXHR();

        // Open a POST request to the server endpoint
        xhr.open('POST', 'update_likes_dislikes.php', true);
        // Set the Content-Type header for POST requests
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Set additional properties to be used in the xhr.onreadystatechange function
        xhr._isLikeButton = isLikeButton;
        xhr._questionId = questionId;
        xhr._likesCountElement = likesCountElement;
        xhr._dislikesCountElement = dislikesCountElement;

        // Send the request with the action and question ID
        xhr.send('action=' + (isLikeButton ? 'like' : 'dislike') + '&question_id=' + questionId);

        // Disable the button to prevent further clicks
        button.classList.add('disabled');
    }



































    // function removeDislike(questionId, dislikesCountElement) {
    //     // Create and configure the XMLHttpRequest object
    //     var xhr = createXHR();

    //     // Open a POST request to the server endpoint
    //     xhr.open('POST', 'update_likes_dislikes.php', true);
    //     // Set the Content-Type header for POST requests
    //     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    //     // Set additional properties to be used in the xhr.onreadystatechange function
    //     xhr._isLikeButton = false;
    //     xhr._questionId = questionId;
    //     xhr._likesCountElement = null; // No need to update like count

    //     // Send the request with the action to remove dislike
    //     xhr.send('action=remove_dislike&question_id=' + questionId);

    //     // Update the local state immediately
    //     questionStates[questionId] = 'neither';
    //     if (dislikesCountElement) {
    //         dislikesCountElement.innerText = parseInt(dislikesCountElement.innerText) - 1;
    //     }
    // }

    // Function to remove the like
    // function removeLike(questionId, likesCountElement) {
    //     // Create and configure the XMLHttpRequest object
    //     var xhr = createXHR();

    //     // Open a POST request to the server endpoint
    //     xhr.open('POST', 'update_likes_dislikes.php', true);
    //     // Set the Content-Type header for POST requests
    //     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    //     // Set additional properties to be used in the xhr.onreadystatechange function
    //     xhr._isLikeButton = true;
    //     xhr._questionId = questionId;
    //     xhr._dislikesCountElement = null; // No need to update dislike count

    //     // Send the request with the action to remove like
    //     xhr.send('action=remove_like&question_id=' + questionId);

    //     // Update the local state immediately
    //     questionStates[questionId] = 'neither';
    //     if (likesCountElement) {
    //         likesCountElement.innerText = parseInt(likesCountElement.innerText) - 1;
    //     }
    // }







