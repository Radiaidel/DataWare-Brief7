<?php

include("../../../includes/config/connection.php");
session_start();

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 10;
$offset = max(0, ($page - 1) * $limit);  // Ensure that offset is non-negative
$sql = "";
$userId = $_SESSION['id'];


if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];

    switch ($filter) {
        case 'new':
            $sql = "SELECT q.*, u.image_url, u.username FROM question q  INNER JOIN users u ON q.user_id = u.id_user where q.archived=0 ORDER BY created_at DESC ";
            break;

        case 'old':
            $sql = "SELECT q.*, u.image_url, u.username FROM question q  INNER JOIN users u ON q.user_id = u.id_user where q.archived=0  ORDER BY created_at ASC";
            break;

        case 'all':
            $sql = "SELECT q.*, u.image_url, u.username FROM question q  INNER JOIN users u ON q.user_id = u.id_user where q.archived=0 ";
            break;

        case 'my':
            if (isset($_SESSION['id'])) {
                $userId = $_SESSION['id'];
                $sql = "SELECT q.*, u.image_url, u.username FROM question q  INNER JOIN users u ON q.user_id = u.id_user  WHERE q.user_id = $userId and  q.archived=0";
            } else {
                echo "<div class='flex items-center text-red-600 justify-center'>";
                echo "<p>User not logged in.</p>";
                echo "</div>";
                exit;
            }
            break;
        case 'search':
            $searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';

            if (!isset($_GET['search'])) {
                echo "<div class='flex items-center text-red-600 justify-center'>";
                echo "<p>Aucune question trouvée.</p>";
                echo "</div>";
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
            WHERE  q.archived=0 and $whereClause";

            break;




        default:
        echo "<div class='flex items-center text-red-600 justify-center'>";
        echo "<p>Aucune question trouvée.</p>";
        echo "</div>";
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

                <div class="flex items-center justify-between text-black mb-4">
                    <div class="flex">

                        <div class="flex-shrink-0">
                            <img src="<?php echo $imagePath; ?>" alt="User Image" class="w-10 h-10 rounded-full">
                        </div>
                        <div class="ml-2">
                            <p class="text-sm  ">
                                <?php echo $username; ?>
                            </p>
                            <p class="text-xs">
                                <?php echo $insertionDate; ?>
                            </p>
                        </div>
                    </div>

                    <div class="flex  ">
                        <ul role="list" class="flex justify-center space-x-5">
                            <?php
                            // Check if the logged-in user is the creator of the question
                            if ($userId == $row['user_id']) {
                                ?>
                                <li>
                                    <a href="modifierquestion.php?modifierID=<?php echo $id_question; ?>"
                                        class="text-indigo-300 hover:text-indigo-500 pr-3">


                                        <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
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
                                        <svg width="25px" height="25px" viewBox="0 0 1024 1024" fill="#000000" class="icon"
                                            version="1.1" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M32 241.6c-11.2 0-20-8.8-20-20s8.8-20 20-20l940 1.6c11.2 0 20 8.8 20 20s-8.8 20-20 20L32 241.6zM186.4 282.4c0-11.2 8.8-20 20-20s20 8.8 20 20v688.8l585.6-6.4V289.6c0-11.2 8.8-20 20-20s20 8.8 20 20v716.8l-666.4 7.2V282.4z"
                                                fill="" />
                                            <path
                                                d="M682.4 867.2c-11.2 0-20-8.8-20-20V372c0-11.2 8.8-20 20-20s20 8.8 20 20v475.2c0.8 11.2-8.8 20-20 20zM367.2 867.2c-11.2 0-20-8.8-20-20V372c0-11.2 8.8-20 20-20s20 8.8 20 20v475.2c0.8 11.2-8.8 20-20 20zM524.8 867.2c-11.2 0-20-8.8-20-20V372c0-11.2 8.8-20 20-20s20 8.8 20 20v475.2c0.8 11.2-8.8 20-20 20zM655.2 213.6v-48.8c0-17.6-14.4-32-32-32H418.4c-18.4 0-32 14.4-32 32.8V208h-40v-42.4c0-40 32.8-72.8 72.8-72.8H624c40 0 72.8 32.8 72.8 72.8v48.8h-41.6z"
                                                fill="" />
                                        </svg>

                                    </a>
                                </li>


                                <?php
                            }
                            ?>
                        </ul>


                    </div>



                </div>

                <div class="mb-6">
                    <h1 class="text-red-600 text-2xl font-bold">
                        <?php echo $questionTitre; ?>
                    </h1>
                    <br>
                    <p class="text-black">
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


                <div class="flex gap-10">
                    <button class="flex items-center text-gray-600 hover:text-blue-500 like-button"
                        data-question-id="<?php echo $id_question; ?>" data-likes-count="<?php echo $likes; ?>">

                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            stroke="#000000">

                            <g id="SVGRepo_bgCarrier" stroke-width="0" />

                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M8 10H4V20H8M8 10V20M8 10L13.1956 3.9385C13.6886 3.36333 14.4642 3.11607 15.1992 3.2998L15.2467 3.31169C16.5885 3.64714 17.1929 5.2106 16.4258 6.36138L14 10H18.5604C19.8225 10 20.7691 11.1547 20.5216 12.3922L19.3216 18.3922C19.1346 19.3271 18.3138 20 17.3604 20H8"
                                    stroke="#646066" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </g>

                        </svg>

                        <span class="ml-1 like-count">
                            <?php echo $likes; ?>
                        </span>
                    </button>

                    <button class="flex items-center text-gray-600 hover:text-red-500 dislike-button"
                        data-question-id="<?php echo $id_question; ?>" data-dislikes-count="<?php echo $dislikes; ?>">


                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            transform="rotate(180)">

                            <g id="SVGRepo_bgCarrier" stroke-width="0" />

                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M8 10H4V20H8M8 10V20M8 10L13.1956 3.9385C13.6886 3.36333 14.4642 3.11607 15.1992 3.2998L15.2467 3.31169C16.5885 3.64714 17.1929 5.2106 16.4258 6.36138L14 10H18.5604C19.8225 10 20.7691 11.1547 20.5216 12.3922L19.3216 18.3922C19.1346 19.3271 18.3138 20 17.3604 20H8"
                                    stroke="#646066" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </g>

                        </svg>
                        <span class="ml-1 dislike-count">
                            <?php echo $dislikes; ?>
                        </span>
                    </button>
                    <form action="response.php" method="POST">
                        <input type="text" hidden name="input_id" value=" <?php echo $id_question; ?> ">
                        <button type="submit" class="flex items-center text-gray-600 hover:text-green-500">
                            <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">

                                <title>comment-1</title>
                                <desc>Created with Sketch Beta.</desc>
                                <defs>

                                </defs>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                    <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-100.000000, -255.000000)"
                                        fill="#000000">
                                        <path
                                            d="M116,281 C114.832,281 113.704,280.864 112.62,280.633 L107.912,283.463 L107.975,278.824 C104.366,276.654 102,273.066 102,269 C102,262.373 108.268,257 116,257 C123.732,257 130,262.373 130,269 C130,275.628 123.732,281 116,281 L116,281 Z M116,255 C107.164,255 100,261.269 100,269 C100,273.419 102.345,277.354 106,279.919 L106,287 L113.009,282.747 C113.979,282.907 114.977,283 116,283 C124.836,283 132,276.732 132,269 C132,261.269 124.836,255 116,255 L116,255 Z"
                                            id="comment-1" sketch:type="MSShapeGroup">

                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <span class="ml-1">Respond</span>
                        </button>
                    </form>
                </div>



            </div>

            <?php
        }
    } else {
        echo "<div class='flex items-center text-red-600 justify-center'>";
        echo "<p>Aucune question trouvée.</p>";
        echo "</div>";
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
    <script src="../../../Javascript/pagination.js" defer></script>
    <?php
}
// Close your database connection
$conn->close();
?>