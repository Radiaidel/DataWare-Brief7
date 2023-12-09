<?php
include("../../../includes/config/connection.php");
session_start();

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 3;
$offset = max(0, ($page - 1) * $limit);  // Ensure that offset is non-negative
$sql = "";



if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];

    switch ($filter) {
        case 'new':
            $sql = "SELECT * FROM question ORDER BY created_at DESC";
            break;

        case 'old':
            $sql = "SELECT * FROM question ORDER BY created_at ASC";
            break;

        case 'all':
            $sql = "SELECT * FROM question";
            break;

        case 'my':
            if (isset($_SESSION['id'])) {
                $userId = $_SESSION['id'];
                $sql = "SELECT * FROM question WHERE user_id = $userId";
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
            if (empty($searchQuery)) {
                echo "Search query is empty.";
                exit;
            }
            $sql = "SELECT * FROM question WHERE question_text LIKE '%$searchQuery%'";
            break;



        default:
            echo "Invalid filter type.";
            exit;
    }



    $sqlFilt = $sql . " LIMIT $limit OFFSET $offset";

    $result = $conn->query($sqlFilt);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="max-w-xl bg-white p-8 rounded-md shadow-md my-5 cursor-pointer hover:shadow-xl">';

            echo '<div class="flex items-center text-gray-600 mb-4">';
            echo '<div class="flex-shrink-0">';
            echo '<svg width="30px" height="30px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#17d924" stroke="#17d924">';
            // Your SVG content here
            echo '</svg>';
            echo '</div>';
            echo '<div class="ml-2">';
            echo '<p class="text-sm">Posted by ' . $row['user_id'] . '</p>';
            echo '<p class="text-xs">Posted on ' . $row['created_at'] . '</p>';
            echo '</div>';
            echo '</div>';

            echo '<div class="mb-6">';
            echo '<p class="text-gray-700">' . $row['question_text'] . '</p>';
            echo '</div>';

            echo '<div class="mb-4">';
            echo '<span class="inline-block bg-blue-200 text-blue-800 py-1 px-2 rounded mr-2">#web</span>';
            echo '<span class="inline-block bg-green-200 text-green-800 py-1 px-2 rounded mr-2">#product</span>';
            echo '<span class="inline-block bg-yellow-200 text-yellow-800 py-1 px-2 rounded mr-2">#html</span>';
            echo '<span class="inline-block bg-yellow-200 text-yellow-800 py-1 px-2 rounded mr-2">#js</span>';
            echo '</div>';

            echo '<div class="flex items-center space-x-4">';

            echo '<button class="flex items-center text-gray-600 hover:text-blue-500">';
            echo '<svg fill="#0473c8" width="20px" height="20px" viewBox="0 0 24 24" id="a11298b2-e15e-46f5-bfd2-69e168954b14" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" stroke="#0473c8">';
            // Your SVG content here
            echo '</svg>';
            echo '<span class="ml-1">' . $row['likes'] . '</span>';
            echo '</button>';

            echo '<button class="flex items-center text-gray-600 hover:text-red-500">';
            echo '<svg fill="#0473c8" height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" stroke="#0473c8">';
            // Your SVG content here
            echo '</svg>';
            echo '<span class="ml-1">' . $row['dislikes'] . '</span>';
            echo '</button>';

?>
  <form action="testttt.php" method="POST">
                                <input type="text"   hidden  name="input_id"   value=" <?php echo $row['question_id']; ?> ">
                            <button type="submit"     class="flex items-center text-gray-600 hover:text-green-500">
                                <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">

                                    <title>comment-1</title>
                                    <desc>Created with Sketch Beta.</desc>
                                    <defs>

                                    </defs>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                                        sketch:type="MSPage">
                                        <g id="Icon-Set" sketch:type="MSLayerGroup"
                                            transform="translate(-100.000000, -255.000000)" fill="#000000">
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
                            <?php



            echo '<button class="flex items-center text-gray-600 hover:text-green-500">';
            echo '<svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">';
            // Your SVG content here
            echo '</svg>';
            echo '<span class="ml-1">Respond</span>';
            echo '</button>';

            echo '</div>';

            echo '</div>';
        }
    } else {
        echo "Aucune question trouvée.";
    }

    $totalQuestionsSql = "SELECT COUNT(*) as total FROM question";

    if ($filter == 'my') {
        $totalQuestionsSql .= " WHERE user_id = $userId";
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
            echo '<button class="bg-blue-500 text-white px-4 py-2 rounded-full mr-2" onclick="DisplayQuestions(\'' . $filter . '\',' . $i . ')">' . $i . '</button>';
        }
        ?>
    </div>
    <script src="../../../Javascript/pagination.js" defer></script>
    <?php
}
// Close your database connection
$conn->close();
?>