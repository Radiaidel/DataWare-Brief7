<?php
include("../includes/config/connection.php");

// Start the session
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}

// Get the logged-in user ID from the session
$loggedInUserId = $_SESSION['id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Card</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex-col items-center justify-center">

    <?php
    $sql = "SELECT q.*, u.image_url, u.username FROM question q 
            INNER JOIN users u ON q.user_id = u.id_user";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $imagePath = htmlspecialchars("/DataWare-Brief7/" . $row['image_url']);
            $insertionDate = $row['created_at'];
            $username = $row['username'];
            $questionTitre = $row['title_question'];
            $questionText = $row['question_text'];
            $id_question = $row['question_id'];
            $likes = $row['likes'];
            $dislikes = $row['dislikes'];

            $tagsSql = "SELECT t.tag_name FROM tags t JOIN question_tag qt ON qt.id_tag = t.id_tag WHERE qt.id_question = " . $id_question;
            $tagsResult = $conn->query($tagsSql);

    ?>

            <div class="max-w-xl bg-white gap-8 p-8 rounded-md shadow-lg">

                <div class="flex items-center text-gray-600 mb-4">
                    <div class="flex-shrink-0">
                        <img src="<?php echo $imagePath; ?>" alt="User Image" class="w-10 h-10 rounded-full">
                    </div>
                    <div class="ml-2">
                        <p class="text-sm"> <?php echo $username; ?></p>
                        <p class="text-xs"> <?php echo $insertionDate; ?></p>
                    </div>
                </div>

                <div class="mb-6">
                    <h1 class="text-black text-xl"><?php echo $questionTitre; ?></h1>
                    <br>
                    <p class="text-gray-700"><?php echo $questionText; ?></p>
                </div>

                <div class="mb-4">
                    <?php
                    // Your existing code for displaying tags
                    if ($tagsResult->num_rows > 0) {
                        while ($tagRow = $tagsResult->fetch_assoc()) {
                    ?>
                            <span class="inline-block bg-blue-200 text-blue-800 py-1 px-2 rounded mr-2">#<?php echo $tagRow['tag_name']; ?></span>
                    <?php
                        }
                    } else {
                        echo "No tags found for this question.";
                    }
                    ?>
                </div>

                <div class="flex items-center space-x-4">
                    <button class="flex items-center text-gray-600 hover:text-blue-500">
                        <!-- Your existing code for like button -->
                    </button>

                    <button class="flex items-center text-gray-600 hover:text-red-500">
                        <!-- Your existing code for dislike button -->
                    </button>
                </div>

                <ul role="list" class="flex justify-center space-x-5">
                    <?php
                    // Check if the logged-in user is the creator of the question
                    if ($loggedInUserId == $row['user_id']) {
                    ?>
                        <li>
                            <a href="modifierquestion.php?modifierID=<?php echo $id_question; ?>" class="text-indigo-700 hover:text-indigo-700">
                                <span>Edit Question</span>
                                <svg class="w-8 mt-2 h-6" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512">
                                    <style>
                                        svg {
                                            fill: #84cc16;
                                        }
                                    </style>
                                    <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H322.8c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7l40.3-40.3c-32.1-31-75.7-50.1-123.9-50.1H178.3zm435.5-68.3c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM375.9 417c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L576.1 358.7l-71-71L375.9 417z" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="deletequestion.php?DeleteID=<?php echo $id_question; ?>" class="text-indigo-700 hover:text-indigo-700">
                                <span>Delete Question</span>
                                <svg class="w-6 h-6 mt-3" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                    <style>
                                        svg {
                                            fill: #84cc16;
                                        }
                                    </style>
                                    <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                </svg>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
                <div class="flex gap-20">
                    <button class="flex items-center text-gray-600 hover:text-blue-500 like-button" data-question-id="<?php echo $id_question; ?>" data-likes-count="<?php echo $likes; ?>">

                        <svg fill="#0473c8" width="20px" height="20px" viewBox="0 0 24 24" id="a11298b2-e15e-46f5-bfd2-69e168954b14" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" stroke="#0473c8">

                            <g id="SVGRepo_bgCarrier" stroke-width="0" />

                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                            <g id="SVGRepo_iconCarrier">



                                <path d="M8,11.47A18.74,18.74,0,0,0,10.69,8.9a18.74,18.74,0,0,0,1.76-2.42A6.42,6.42,0,0,0,13,5.41l1.74-4.57a4.45,4.45,0,0,1,2.83,2A4,4,0,0,1,18,4.77a2.67,2.67,0,0,1-.09.55L16.72,9.05h5.22a2,2,0,0,1,2,1.85,19.32,19.32,0,0,1-.32,5.44,33.83,33.83,0,0,1-1.23,4.34,3.78,3.78,0,0,1-3.58,2.49,25.54,25.54,0,0,1-6.28-.66A45.85,45.85,0,0,1,8,21.26V11.47Z" />

                                <path d="M5,9H1a1,1,0,0,0-1,1V22a1,1,0,0,0,1,1H5a1,1,0,0,0,1-1V10A1,1,0,0,0,5,9ZM3,21a1,1,0,1,1,1-1A1,1,0,0,1,3,21Z" />

                            </g>

                        </svg>

                        <span class="ml-1 like-count"><?php echo $likes; ?></span>
                    </button>

                    <button class="flex items-center text-gray-600 hover:text-red-500 dislike-button" data-question-id="<?php echo $id_question; ?>" data-dislikes-count="<?php echo $dislikes; ?>">
                        <svg fill="#0473c8" height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" stroke="#0473c8">

                            <g id="SVGRepo_bgCarrier" stroke-width="0" />

                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <g>
                                        <g>
                                            <path d="M117.333,10.667h-64C23.936,10.667,0,34.603,0,64v170.667C0,264.064,23.936,288,53.333,288H160 c5.888,0,10.667-4.779,10.667-10.667V64C170.667,34.603,146.731,10.667,117.333,10.667z" />
                                            <path d="M512,208c0-18.496-10.603-34.731-26.347-42.667c3.285-6.549,5.013-13.781,5.013-21.333 c0-18.496-10.603-34.752-26.368-42.688c4.864-9.728,6.293-20.928,3.84-32.043C463.36,47.68,443.051,32,419.819,32H224 c-7.232,0-16.405,1.173-25.771,3.285c-5.739,1.301-9.344,6.976-8.064,12.693C191.403,53.632,192,58.859,192,64v213.333 c0,5.739-1.6,11.264-4.736,16.448c-1.835,3.029-2.048,6.763-0.555,9.984l47.957,103.893v72.32c0,3.243,1.472,6.293,3.989,8.341 c0.683,0.555,16.512,13.013,38.677,13.013c24.683,0,64-39.061,64-85.333c0-29.184-10.453-65.515-16.96-85.333h131.755 c28.715,0,53.141-21.248,55.637-48.341c1.387-15.189-3.669-29.824-13.632-40.725C506.901,232.768,512,220.821,512,208z" />
                                        </g>
                                    </g>
                                </g>
                            </g>

                        </svg>
                        <span class="ml-1 dislike-count"><?php echo $dislikes; ?></span>
                    </button>
                </div>
            </div>

    <?php
        }
    } else {
        echo "Aucune question trouvée.";
    }

    // Fermer la connexion à la base de données
    $conn->close();
    ?>



















    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Map to store the current state of each question (liked, disliked, or neither)
            var questionStates = {};

            // Attach click event listeners to like and dislike buttons
            document.querySelectorAll('.like-button, .dislike-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    handleButtonClick(button);
                });
            });

            // Function to handle like and dislike button click
            function handleButtonClick(button) {
                var questionId = button.getAttribute('data-question-id');
                var likesCountElement = button.querySelector('.like-count');
                var dislikesCountElement = button.querySelector('.dislike-count');

                // Determine whether it's a like or dislike button
                var isLikeButton = button.classList.contains('like-button');

                // Get the current state of the question
                var currentState = questionStates[questionId] || 'neither';

                // Send an AJAX request to update the like or dislike count based on the current state
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'update_likes_dislikes.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Update the like or dislike count on the page
                        var response = xhr.responseText;

                        if (isLikeButton && likesCountElement) {
                            likesCountElement.innerText = response;
                        } else if (!isLikeButton && dislikesCountElement) {
                            dislikesCountElement.innerText = response;
                        }

                        // Toggle the state for the question
                        if (currentState === 'neither') {
                            questionStates[questionId] = isLikeButton ? 'liked' : 'disliked';
                        } else if (currentState === 'liked' && isLikeButton) {
                            // If previously liked, remove like
                            questionStates[questionId] = 'neither';
                        } else if (currentState === 'disliked' && !isLikeButton) {
                            // If previously disliked, remove dislike
                            questionStates[questionId] = 'neither';
                        } else {
                            // Update the state based on the current action
                            questionStates[questionId] = isLikeButton ? 'liked' : 'disliked';
                        }
                    }
                };

                // Send the appropriate action based on the current state
                if (currentState === 'neither' || (currentState === 'disliked' && isLikeButton)) {
                    xhr.send('action=like&question_id=' + questionId);
                } else {
                    xhr.send('action=dislike&question_id=' + questionId);
                }
            }
        });
    </script>

</body>

</html>


</body>

</html>