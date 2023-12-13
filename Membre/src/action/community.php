<?php
include("../../../includes/config/connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Page</title>
    <script src="../Javascript/script.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha384-GLhlTQ8iN17SJLlFfZVfP5z01K4JPTNqDQ5a6jgl5Up3H+9TP5IotK2+Obr4u" crossorigin="anonymous" />
        <script src="../../../Javascript/pagination.js" defer></script>
    <script src="../../../Javascript/like_dislike.js" defer></script>
    <style>
        .bg-ce0033 {
            background-color: #CE0033;
        }
    </style>
</head>

<body> <!--header-->
    <?php
    include '../../template/header.php';
    ?>
    <div class="w-full p-4 mb-4 lg:mb-0 bg-gray-200 rounded-md shadow-lg text-white">

    <div class="mx-auto w-3/5 flex items-center space-x-3 mb-4 my-5 z-10 p-4">
    <div class="relative inline-block text-left">
        <div>
            <button type="button" id="filterBotton"
                class="inline-flex justify-center w-full rounded-md border border-gray-400 shadow-sm px-4 py-2  bg-white z-40 text-sm font-medium text-gray-500 hover:bg-red-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
                Filter
                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div id="MenuFilter"
            class="hidden origin-top-right absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
            <div class="py-1">
                <a href="#"
                    class="filter-option block px-4 py-2 text-sm text-gray-600 hover:bg-red-500 hover:text-gray-100"
                    data-filter-type="new">Date (New)</a>
                <a href="#"
                    class="filter-option block px-4 py-2 text-sm text-gray-600 hover:bg-red-500 hover:text-gray-100"
                    data-filter-type="old">Date (Old)</a>
                <a href="#"
                    class="filter-option block px-4 py-2 text-sm text-gray-600 hover:bg-red-500 hover:text-gray-100"
                    data-filter-type="all">All Questions</a>
                <a href="#"
                    class="filter-option block px-4 py-2 text-sm text-gray-600 hover:bg-red-500 hover:text-gray-100"
                    data-filter-type="my">My Questions</a>
            </div>
        </div>
    </div>

    <div class="flex-1">
        <form id="searchForm" onsubmit="searchQuestions(); return false;" method="get">
            <input type="text" id="searchInput" placeholder="Search questions..."
                class="w-full px-4 py-2  rounded-md border border-gray-400 focus:outline-none focus:border-blue-500 bg-white text-white">
        </form>
    </div>
</div>


        <div id="questionsContainer" class="mx-auto max-w-3/5">
            <!-- Contenu des questions -->
        </div>

    </div>


    <script>


        document.getElementById('filterBotton').addEventListener("click", function () {
            document.getElementById("MenuFilter").classList.toggle("hidden");
        });

        document.getElementById('searchForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Empêche la soumission par défaut du formulaire
            searchQuestions();
        });


        function searchQuestions() {
            var searchQuery = document.getElementById('searchInput').value;
            DisplayQuestions('search', 1, searchQuery);
        }


        document.addEventListener('DOMContentLoaded', function () {
            var searchQuery = '';
            document.getElementById('searchInput').addEventListener('input', function () {
                searchQuery = this.value;
                DisplayQuestions('search', 1, searchQuery);
            });

            var filterOptions = document.getElementsByClassName('filter-option');
            for (var i = 0; i < filterOptions.length; i++) {
                filterOptions[i].addEventListener('click', function (event) {
                    var filterType = event.target.getAttribute('data-filter-type');
                    DisplayQuestions(filterType, 1, searchQuery);
                });
            }

            function DisplayQuestions(filterType, page, searchQuery) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        document.getElementById('questionsContainer').innerHTML = xhr.responseText;
                    }
                };
                var url = 'load_questions.php?filter=' + filterType + '&page=' + page;
                if (filterType === 'search') {
                    url += '&search=' + encodeURIComponent(searchQuery);
                }

                xhr.open('GET', url, true);
                xhr.send();
            }

            DisplayQuestions('new', 1, searchQuery);
        });

        
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



    </script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


</body>

</html>

<?php
$conn->close();
?>