<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>

<body>
    <?php

    include("../../../includes/config/connection.php");
    session_start();

    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $limit = 3;
    $offset = max(0, ($page - 1) * $limit);  // Ensure that offset is non-negative
    $sql = "";
    $userId = $_SESSION['id'];


    if (isset($_GET['filter'])) {
        $filter = $_GET['filter'];

        switch ($filter) {
            case 'new':
                $sql = "SELECT q.*, u.image_url, u.username FROM question q  INNER JOIN users u ON q.user_id = u.id_user ORDER BY created_at DESC ";
                break;

            case 'old':
                $sql = "SELECT q.*, u.image_url, u.username FROM question q  INNER JOIN users u ON q.user_id = u.id_user  ORDER BY created_at ASC";
                break;

            case 'all':
                $sql = "SELECT q.*, u.image_url, u.username FROM question q  INNER JOIN users u ON q.user_id = u.id_user ";
                break;

            case 'my':
                if (isset($_SESSION['id'])) {
                    $userId = $_SESSION['id'];
                    $sql = "SELECT q.*, u.image_url, u.username FROM question q  INNER JOIN users u ON q.user_id = u.id_user  WHERE q.user_id = $userId";
                } else {
                    echo "User not logged in.";
                    exit;
                }
                break;
            case 'search':
                $searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';

                if (!isset($_GET['search'])) {
                    echo "Search query is missing.";
                    exit;
                }

                $searchQuery = $_GET['search'];

                $keywords = explode(" ", $searchQuery);
                $whereClause = "";

                foreach ($keywords as $keyword) {
                    $whereClause .= "(question_text LIKE '%$keyword%' OR tags.tag_name LIKE '%$keyword%') AND ";
                }

                $whereClause = rtrim($whereClause, " AND ");

                $sql = "SELECT q.*, u.image_url, u.username FROM question q INNER JOIN users u ON q.user_id = u.id_user 
            LEFT JOIN question_tag ON q.question_id = question_tag.id_question
            LEFT JOIN tags ON question_tag.id_tag = tags.id_tag
            WHERE $whereClause";

                break;




            default:
                echo "Invalid filter type.";
                exit;
        }



        $sqlFilt = $sql . " LIMIT $limit OFFSET $offset";

        $result = $conn->query($sqlFilt);

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
                <div class="mx-auto w-3/5  bg-gray-100 p-8 rounded-xl shadow-xl text-white mb-4">
                    <div class="flex items-center text-gray-300 mb-4">
                        <div class="flex-shrink-0">
                            <img src="<?php echo $imagePath; ?>" alt="User Image" class="w-10 h-10 rounded-full">
                        </div>
                        <div class="ml-2">
                            <p class="text-sm">
                                <?php echo $username; ?>
                            </p>
                            <p class="text-xs">
                                <?php echo $insertionDate; ?>
                            </p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h1 class="text-white text-2xl font-bold">
                            <?php echo $questionTitre; ?>
                        </h1>
                        <br>
                        <p class="text-gray-300">
                            <?php echo $questionText; ?>
                        </p>
                    </div>

                    <div class="mb-4 space-x-2">
                        <?php
                        // Your existing code for displaying tags
                        if ($tagsResult->num_rows > 0) {
                            while ($tagRow = $tagsResult->fetch_assoc()) {
                                ?>
                                <span class="inline-block bg-blue-200 text-blue-800 py-1 px-2 rounded">
                                    <?php echo '#' . $tagRow['tag_name']; ?>
                                </span>
                                <?php
                            }
                        }
                        ?>
                    </div>




                    <div class="flex gap-20">
                        <button class="flex items-center text-gray-600 hover:text-blue-500 like-button"
                            data-question-id="<?php echo $id_question; ?>" data-likes-count="<?php echo $likes; ?>">

                            <svg fill="#0473c8" width="20px" height="20px" viewBox="0 0 24 24"
                                id="a11298b2-e15e-46f5-bfd2-69e168954b14" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg"
                                stroke="#0473c8">

                                <g id="SVGRepo_bgCarrier" stroke-width="0" />

                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                                <g id="SVGRepo_iconCarrier">



                                    <path
                                        d="M8,11.47A18.74,18.74,0,0,0,10.69,8.9a18.74,18.74,0,0,0,1.76-2.42A6.42,6.42,0,0,0,13,5.41l1.74-4.57a4.45,4.45,0,0,1,2.83,2A4,4,0,0,1,18,4.77a2.67,2.67,0,0,1-.09.55L16.72,9.05h5.22a2,2,0,0,1,2,1.85,19.32,19.32,0,0,1-.32,5.44,33.83,33.83,0,0,1-1.23,4.34,3.78,3.78,0,0,1-3.58,2.49,25.54,25.54,0,0,1-6.28-.66A45.85,45.85,0,0,1,8,21.26V11.47Z" />

                                    <path
                                        d="M5,9H1a1,1,0,0,0-1,1V22a1,1,0,0,0,1,1H5a1,1,0,0,0,1-1V10A1,1,0,0,0,5,9ZM3,21a1,1,0,1,1,1-1A1,1,0,0,1,3,21Z" />

                                </g>

                            </svg>

                            <span class="ml-1 like-count">
                                <?php echo $likes; ?>
                            </span>
                        </button>

                        <button class="flex items-center text-gray-600 hover:text-red-500 dislike-button"
                            data-question-id="<?php echo $id_question; ?>" data-dislikes-count="<?php echo $dislikes; ?>">
                            <svg fill="#0473c8" height="20px" width="20px" version="1.1" id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"
                                xml:space="preserve" stroke="#0473c8">

                                <g id="SVGRepo_bgCarrier" stroke-width="0" />

                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <g>
                                            <g>
                                                <path
                                                    d="M117.333,10.667h-64C23.936,10.667,0,34.603,0,64v170.667C0,264.064,23.936,288,53.333,288H160 c5.888,0,10.667-4.779,10.667-10.667V64C170.667,34.603,146.731,10.667,117.333,10.667z" />
                                                <path
                                                    d="M512,208c0-18.496-10.603-34.731-26.347-42.667c3.285-6.549,5.013-13.781,5.013-21.333 c0-18.496-10.603-34.752-26.368-42.688c4.864-9.728,6.293-20.928,3.84-32.043C463.36,47.68,443.051,32,419.819,32H224 c-7.232,0-16.405,1.173-25.771,3.285c-5.739,1.301-9.344,6.976-8.064,12.693C191.403,53.632,192,58.859,192,64v213.333 c0,5.739-1.6,11.264-4.736,16.448c-1.835,3.029-2.048,6.763-0.555,9.984l47.957,103.893v72.32c0,3.243,1.472,6.293,3.989,8.341 c0.683,0.555,16.512,13.013,38.677,13.013c24.683,0,64-39.061,64-85.333c0-29.184-10.453-65.515-16.96-85.333h131.755 c28.715,0,53.141-21.248,55.637-48.341c1.387-15.189-3.669-29.824-13.632-40.725C506.901,232.768,512,220.821,512,208z" />
                                            </g>
                                        </g>
                                    </g>
                                </g>

                            </svg>
                            <span class="ml-1 dislike-count">
                                <?php echo $dislikes; ?>
                            </span>
                        </button>
                    </div>
                    <ul role="list" class="flex justify-center space-x-5">
                        <?php
                        // Check if the logged-in user is the creator of the question
                        if ($userId == $row['user_id']) {
                            ?>
                            <li>
                                <a href="modifierquestion.php?modifierID=<?php echo $id_question; ?>"
                                    class="text-indigo-300 hover:text-indigo-500">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z"
                                            stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13"
                                            stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="deletequestion.php?DeleteID=<?php echo $id_question; ?>"
                                    class="text-indigo-300 hover:text-indigo-500">
                                    <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">

                                        <title>comment-1</title>
                                        <desc>Created with Sketch Beta.</desc>
                                        <defs>

                                        </defs>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                                            sketch:type="MSPage">
                                            <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-100.000000, -255.000000)"
                                                fill="#000000">
                                                <path
                                                    d="M116,281 C114.832,281 113.704,280.864 112.62,280.633 L107.912,283.463 L107.975,278.824 C104.366,276.654 102,273.066 102,269 C102,262.373 108.268,257 116,257 C123.732,257 130,262.373 130,269 C130,275.628 123.732,281 116,281 L116,281 Z M116,255 C107.164,255 100,261.269 100,269 C100,273.419 102.345,277.354 106,279.919 L106,287 L113.009,282.747 C113.979,282.907 114.977,283 116,283 C124.836,283 132,276.732 132,269 C132,261.269 124.836,255 116,255 L116,255 Z"
                                                    id="comment-1" sketch:type="MSShapeGroup">

                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>

                <?php
            }
        } else {
            echo "Aucune question trouvée.";
        }

        $totalQuestionsSql = "SELECT COUNT(*) as total FROM question";

        if ($filter == 'my') {
            $totalQuestionsSql .= " WHERE user_id = $userId";
        }
        if ($filter == 'search') {
            $totalQuestionsSql = "SELECT COUNT(*) as total FROM question LEFT JOIN question_tag ON question.question_id = question_tag.id_question
        LEFT JOIN tags ON question_tag.id_tag = tags.id_tag
        WHERE $whereClause";
        }


        $totalQuestionsResult = $conn->query($totalQuestionsSql);
        $totalQuestionsRow = $totalQuestionsResult->fetch_assoc();
        $totalQuestions = $totalQuestionsRow['total'];

        $totalPages = ceil($totalQuestions / $limit);

        // Affichage des boutons de pagination
        ?>
        <!-- Pagination Navigation -->
        <div class="flex items-center justify-center mt-4">
            <?php
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<button class="flex-shrink-0 w-10 h-10 bg-gray-800 border border-white rounded-full mr-2 focus:outline-none hover:bg-gray-900" onclick="DisplayQuestions(\'' . $filter . '\',' . $i . ')">' . $i . '</button>';
            } ?>
        </div>

        <?php
    }







    // Close your database connection
    $conn->close();
    ?>



<script>
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















</script>









    <script src="../../../Javascript/like_dislike.js" defer></script>

</body>

</html>