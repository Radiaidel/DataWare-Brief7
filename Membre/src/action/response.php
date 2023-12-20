<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location:../../../logout.php ");
}
include("../../../includes/config/connection.php");
include '../../template/header.php';
$userId = $_SESSION["id"];

$id_question = isset($_GET['question_id']) ? $_GET['question_id'] : (isset($_POST['input_id']) ? $_POST['input_id'] : null);
//ajouter une reponse

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        .bg-ce0033 {
            background-color: #CE0033;
        }
    </style>
</head>

<body class="bg-gray-200">

    <div class="w-full lg:w-3/4 m-auto">
        <div class=" bg-gray-200 p-4 mb-4 my-5">

            <?php

            if (isset($id_question)) {
                // $id_question = $_POST['input_id'];
            
                // Fetching the question
                $sql = "SELECT q.*, u.image_url, u.username, u.id_user FROM question q INNER JOIN users u ON q.user_id = u.id_user WHERE question_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id_question);
                $stmt->execute();
                $result = $stmt->get_result();

                if (!$result) {
                    echo "Error fetching question: " . $stmt->error;
                } else {
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();

                        $imagePath = htmlspecialchars("/DataWare-Brief7/" . $row['image_url']);
                        $insertionDate = $row['created_at'];
                        $username = $row['username'];
                        $questionTitre = $row['title_question'];
                        $questionText = $row['question_text'];
                        $id_question = $row['question_id'];
                        $likes = $row['likes'];
                        $dislikes = $row['dislikes'];

                        $questionowner = $row['user_id'];
                        // Fetching tags
                        $tagsSql = "SELECT t.tag_name FROM tags t JOIN question_tag qt ON qt.id_tag = t.id_tag WHERE qt.id_question = ?";
                        $tagsStmt = $conn->prepare($tagsSql);
                        $tagsStmt->bind_param("i", $id_question);
                        $tagsStmt->execute();
                        $tagsResult =
                            $tagsStmt->get_result();



                        $responseCountSql = "SELECT COUNT(*) AS response_count FROM answer WHERE question_id =$id_question";
                        $responseCountResult = $conn->query($responseCountSql);
                        $responseCountRow = $responseCountResult->fetch_assoc();
                        $responseCount = $responseCountRow['response_count'];

                        ?>



                        <div class="mx-auto w-full  bg-gray-100 p-8 rounded-xl shadow-xl text-white ">

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
                                                            stroke="#000000" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path
                                                            d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13"
                                                            stroke="#000000" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
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

                                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" stroke="#000000">

                                        <g id="SVGRepo_bgCarrier" stroke-width="0" />

                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M8 10H4V20H8M8 10V20M8 10L13.1956 3.9385C13.6886 3.36333 14.4642 3.11607 15.1992 3.2998L15.2467 3.31169C16.5885 3.64714 17.1929 5.2106 16.4258 6.36138L14 10H18.5604C19.8225 10 20.7691 11.1547 20.5216 12.3922L19.3216 18.3922C19.1346 19.3271 18.3138 20 17.3604 20H8"
                                                stroke="#646066" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </g>

                                    </svg>

                                    <span class="ml-1 like-count">
                                        <?php echo $likes; ?>
                                    </span>
                                </button>

                                <button class="flex items-center text-gray-600 hover:text-red-500 dislike-button"
                                    data-question-id="<?php echo $id_question; ?>" data-dislikes-count="<?php echo $dislikes; ?>">


                                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" transform="rotate(180)">

                                        <g id="SVGRepo_bgCarrier" stroke-width="0" />

                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M8 10H4V20H8M8 10V20M8 10L13.1956 3.9385C13.6886 3.36333 14.4642 3.11607 15.1992 3.2998L15.2467 3.31169C16.5885 3.64714 17.1929 5.2106 16.4258 6.36138L14 10H18.5604C19.8225 10 20.7691 11.1547 20.5216 12.3922L19.3216 18.3922C19.1346 19.3271 18.3138 20 17.3604 20H8"
                                                stroke="#646066" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </g>

                                    </svg>
                                    <span class="ml-1 dislike-count">
                                        <?php echo $dislikes; ?>
                                    </span>
                                </button>
                                <form action="response.php" method="POST" class="m-0">
                                    <input type="text" hidden name="input_id" value=" <?php echo $id_question; ?> ">
                                    <button type="submit" class="flex items-center text-gray-600 hover:text-green-500">
                                        <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
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
                                        <span class="text-black">
                                            <?php echo $responseCount; ?>
                                        </span>
                                    </button>
                                </form>
                            </div>


                        </div>

                        <?php
                    } else {
                        echo "Question not found.";
                    }
                }
            } else {
                echo "Question ID not specified in the URL.";
            }
            ?>

        </div>

        <div class="rounded rounded-md p-4 mb-2">
            <!-- <h2 class="text-lg font-semibold mb-2">Répondre à la question</h2> -->
            <form method="POST" class="space-y-4">

                <div>
                    <label for="response_text" class="block text-sm font-medium text-xl text-gray-700 mb-2 ml-2">Votre
                        réponse </label>

                    <textarea id="response_text" name="response_text" rows="4"
                        class="mt-1 p-2 w-full border rounded-md drop-shadow-lg border-slate-950"></textarea>
                </div>
                <input type='hidden' name='input_id' value="<?php echo $id_question; ?>">

                <div class="flex items-center">
                    <button type="submit" name="Envoyer_reponse"
                        class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">Envoyer la
                        réponse</button>
                </div>
            </form>
        </div>

        <div>

            <?php

            $sql = "SELECT answer_id, answer.user_id, created_at, answer_text, username, image_url, likes, dislikes,is_solution FROM answer INNER JOIN users ON answer.user_id = id_user WHERE answer.question_id = ? and archived=0 ORDER BY is_solution DESC, created_at DESC ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_question);
            $stmt->execute();
            $result = $stmt->get_result();

            if (!$result) {
                echo "Error fetching responses: " . $stmt->error;
            } else {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imagePath = htmlspecialchars("/DATAWARE-BRIEF7/" . $row['image_url']);
                        echo "<div class=' flex w-full drop-shadow-2xl flex-col items-center gap-3 mx-auto  px-6 rounded border rounded-md drop-shadow-md border-slate-950'>";

                        echo "<div class='bg-white w-full p-6 rounded mt-1 p-2 border-2 rounded-md drop-shadow-2xl border-red-300'>";
                        echo "<div class='flex'>";
                        echo "<div class='flex-shrink-0'>";
                        echo "<img src='$imagePath' alt='User Image' class='w-10 h-10 rounded-full'>";
                        echo "</div>";
                        echo "<div class='flex justify-between w-full'>";
                        echo "<div class='ml-2'>";
                        echo "<p class='text-sm'>Posted by " . $row['username'] . "</p>";
                        echo "<p class='text-xs'>Posted on " . $row['created_at'] . "</p>";
                        echo "</div>";
                        echo "<div class='flex justify-between align-top mt-4 ml-52'>";
                        if ($userId == $row['user_id']) {

                            echo "<form method='POST' action='answer_update.php'>";
                            echo "<input type='hidden' name='answer_id' value='" . $row['answer_id'] . "'>";
                            echo "<input type='hidden' name='question_id' value='" . $id_question . "'>";
                            echo "<button type='submit' name='toupdate' class='flex items-end text-gray-600 hover:text-red-500'>";

                            // ... (your existing code for the edit icon)
            


                            echo '<svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">';
                            echo '<path
                                d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z"
                                stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />';
                            echo '<path
                                d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13"
                                stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />';
                            echo ' </svg>';
                            echo "</svg>";
                            echo "</button>";
                            echo "</form>";



                            echo "<form method='POST' action='delete_answer.php'>";
                            echo "<input type='hidden' name='answer_id' value='" . $row['answer_id'] . "'>";
                            echo "<input type='hidden' name='question_id' value='" . $id_question . "'>";
                            echo "<button type='submit' class='flex items-end text-gray-600 hover:text-red-500'>";
                            echo '<svg width="25px" height="25px" viewBox="0 0 1024 1024" fill="#000000" class="icon" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">';
                            echo '<path
                                d="M32 241.6c-11.2 0-20-8.8-20-20s8.8-20 20-20l940 1.6c11.2 0 20 8.8 20 20s-8.8 20-20 20L32 241.6zM186.4 282.4c0-11.2 8.8-20 20-20s20 8.8 20 20v688.8l585.6-6.4V289.6c0-11.2 8.8-20 20-20s20 8.8 20 20v716.8l-666.4 7.2V282.4z"
                                fill="" />';
                            echo '<path
                                d="M682.4 867.2c-11.2 0-20-8.8-20-20V372c0-11.2 8.8-20 20-20s20 8.8 20 20v475.2c0.8 11.2-8.8 20-20 20zM367.2 867.2c-11.2 0-20-8.8-20-20V372c0-11.2 8.8-20 20-20s20 8.8 20 20v475.2c0.8 11.2-8.8 20-20 20zM524.8 867.2c-11.2 0-20-8.8-20-20V372c0-11.2 8.8-20 20-20s20 8.8 20 20v475.2c0.8 11.2-8.8 20-20 20zM655.2 213.6v-48.8c0-17.6-14.4-32-32-32H418.4c-18.4 0-32 14.4-32 32.8V208h-40v-42.4c0-40 32.8-72.8 72.8-72.8H624c40 0 72.8 32.8 72.8 72.8v48.8h-41.6z"
                                fill="" />';
                            echo ' </svg>';

                            echo "</button>";
                            echo "</form>";
                        }



                        if ($userId == $questionowner) {
                            $isSolution = $row['is_solution'];

                            echo "<form method='POST' action=''>";
                            echo "<input type='hidden' name='question_id' value='" . $id_question . "'>";

                            echo "<input type='hidden' name='answer_id' value='" . $row['answer_id'] . "'>";
                            echo "<button type='submit' name='mark_as_solution' class='flex items-center text-gray-600 hover:text-green-500'>";

                            if ($isSolution == 1) {
                                // Display SVG for is_solution = 1
                                echo '<svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">

                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                                    <g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M21 11.0975V16.0909C21 19.1875 21 20.7358 20.2659 21.4123C19.9158 21.735 19.4739 21.9377 19.0031 21.9915C18.016 22.1045 16.8633 21.0849 14.5578 19.0458C13.5388 18.1445 13.0292 17.6938 12.4397 17.5751C12.1494 17.5166 11.8506 17.5166 11.5603 17.5751C10.9708 17.6938 10.4612 18.1445 9.44216 19.0458C7.13673 21.0849 5.98402 22.1045 4.99692 21.9915C4.52615 21.9377 4.08421 21.735 3.73411 21.4123C3 20.7358 3 19.1875 3 16.0909V11.0975C3 6.80891 3 4.6646 4.31802 3.3323C5.63604 2 7.75736 2 12 2C16.2426 2 18.364 2 19.682 3.3323C21 4.6646 21 6.80891 21 11.0975ZM8.25 6C8.25 5.58579 8.58579 5.25 9 5.25H15C15.4142 5.25 15.75 5.58579 15.75 6C15.75 6.41421 15.4142 6.75 15 6.75H9C8.58579 6.75 8.25 6.41421 8.25 6Z" fill="#ff0000"/> </g>

                                    </svg>';
                            } else {
                                // Display SVG for is_solution = 0
                                echo '<svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">

                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                
                                <g id="SVGRepo_iconCarrier"> <path d="M3 11.0975V16.0909C3 19.1875 3 20.7358 3.73411 21.4123C4.08422 21.735 4.52615 21.9377 4.99692 21.9915C5.98402 22.1045 7.13675 21.0849 9.44216 19.0458C10.4612 18.1445 10.9708 17.6938 11.5603 17.5751C11.8506 17.5166 12.1494 17.5166 12.4397 17.5751C13.0292 17.6938 13.5388 18.1445 14.5578 19.0458C16.8633 21.0849 18.016 22.1045 19.0031 21.9915C19.4739 21.9377 19.9158 21.735 20.2659 21.4123C21 20.7358 21 19.1875 21 16.0909V11.0975C21 6.80891 21 4.6646 19.682 3.3323C18.364 2 16.2426 2 12 2C7.75736 2 5.63604 2 4.31802 3.3323C3.5108 4.14827 3.19796 5.26881 3.07672 7" stroke="#ff0000" stroke-width="1.5" stroke-linecap="round"/> <path d="M15 6H9" stroke="#ff0000" stroke-width="1.5" stroke-linecap="round"/> </g>
                                
                                </svg>';
                            }




                            echo "</button>";
                            echo "</form>";
                        }else{
                            $isSolution = $row['is_solution'];
                            if ($isSolution == 1) {
                                // Display SVG for is_solution = 1
                                echo '<svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
    
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
    
                                    <g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M21 11.0975V16.0909C21 19.1875 21 20.7358 20.2659 21.4123C19.9158 21.735 19.4739 21.9377 19.0031 21.9915C18.016 22.1045 16.8633 21.0849 14.5578 19.0458C13.5388 18.1445 13.0292 17.6938 12.4397 17.5751C12.1494 17.5166 11.8506 17.5166 11.5603 17.5751C10.9708 17.6938 10.4612 18.1445 9.44216 19.0458C7.13673 21.0849 5.98402 22.1045 4.99692 21.9915C4.52615 21.9377 4.08421 21.735 3.73411 21.4123C3 20.7358 3 19.1875 3 16.0909V11.0975C3 6.80891 3 4.6646 4.31802 3.3323C5.63604 2 7.75736 2 12 2C16.2426 2 18.364 2 19.682 3.3323C21 4.6646 21 6.80891 21 11.0975ZM8.25 6C8.25 5.58579 8.58579 5.25 9 5.25H15C15.4142 5.25 15.75 5.58579 15.75 6C15.75 6.41421 15.4142 6.75 15 6.75H9C8.58579 6.75 8.25 6.41421 8.25 6Z" fill="#ff0000"/> </g>
    
                                    </svg>';
                            }
                        }
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "<p class='mt-2 text-gray-800'>" . $row['answer_text'] . "</p>";
                        echo "<div class='flex  mt-4'>";
                        echo "<form method='POST' action='like_dislike.php'>";
                        echo "<input type='hidden' name='answer_id' value='" . $row['answer_id'] . "'>";
                        echo "<input type='hidden' name='action' value='like'>";
                        echo "<button type='submit' class='flex items-center text-gray-600 hover:text-blue-500'>";
                        echo '<svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            stroke="#000000">';

                        echo '<g id="SVGRepo_bgCarrier" stroke-width="0" />';

                        echo '<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />';

                        echo '<g id="SVGRepo_iconCarrier">';
                        echo ' <path
                                    d="M8 10H4V20H8M8 10V20M8 10L13.1956 3.9385C13.6886 3.36333 14.4642 3.11607 15.1992 3.2998L15.2467 3.31169C16.5885 3.64714 17.1929 5.2106 16.4258 6.36138L14 10H18.5604C19.8225 10 20.7691 11.1547 20.5216 12.3922L19.3216 18.3922C19.1346 19.3271 18.3138 20 17.3604 20H8"
                                    stroke="#646066" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />';
                        echo ' </g>';

                        echo '</svg>';
                        echo "<span class='ml-1'>" . $row['likes'] . "</span>";
                        echo "<svg width='20px' height='20px' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>";
                        // ... (your upvote icon here)
                        echo "</svg>";
                        echo "</button>";
                        echo "</form>";
                        echo "<form method='POST' action='like_dislike.php'>";
                        echo "<input type='hidden' name='answer_id' value='" . $row['answer_id'] . "'>";
                        echo "<input type='hidden' name='action' value='dislike'>";
                        echo "<button type='submit' class='flex items-center text-gray-600 hover:text-red-500'>";
                        echo '<svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            transform="rotate(180)">';

                        echo '<g id="SVGRepo_bgCarrier" stroke-width="0" />';

                        echo '<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />';

                        echo '<g id="SVGRepo_iconCarrier">';
                        echo '<path
                                    d="M8 10H4V20H8M8 10V20M8 10L13.1956 3.9385C13.6886 3.36333 14.4642 3.11607 15.1992 3.2998L15.2467 3.31169C16.5885 3.64714 17.1929 5.2106 16.4258 6.36138L14 10H18.5604C19.8225 10 20.7691 11.1547 20.5216 12.3922L19.3216 18.3922C19.1346 19.3271 18.3138 20 17.3604 20H8"
                                    stroke="#646066" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />';
                        echo '</g>';
                        echo "<span class='ml-1'>" . $row['dislikes'] . "</span>";
                        echo "<svg width='20px' height='20px' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>";
                        // ... (your downvote icon here)
                        echo "</svg>";
                        echo "</button>";
                        echo "</form>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "No responses found.";
                }
            }
            ?>
        </div>
    </div>



</body>

</html>

<?php


// Marquer la reponse comme solution
if (isset($_POST['answer_id']) && isset($_POST['mark_as_solution'])) {
    $answerId = $_POST['answer_id'];
    $id_question = $_POST['question_id'];

    $checkStmt = $conn->prepare("SELECT is_solution FROM answer WHERE answer_id = ?");
    $checkStmt->bind_param("i", $answerId);
    $checkStmt->execute();
    $checkStmt->bind_result($isSolution);
    $checkStmt->fetch();
    $checkStmt->close();

    // Toggle is_solution value
    $newIsSolution = ($isSolution == 1) ? 0 : 1;

    // Update the database with the new is_solution status
    $updateStmt = $conn->prepare("UPDATE answer SET is_solution = ? WHERE answer_id = ?");
    $updateStmt->bind_param("ii", $newIsSolution, $answerId);
    $updateStmt->execute();
    $updateStmt->close();
    if ($updateStmt) {
        echo '<form id="refreshForm" action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
        echo '<input type="hidden" name="input_id" value="' . $id_question . '">';
        echo '</form>';
        echo '<script>document.getElementById("refreshForm").submit();</script>';
        exit;
    }
}





//ajouter
if (isset($_POST['Envoyer_reponse'])) {
    $user_id = $_SESSION['id'];
    $response_text = $_POST["response_text"];
    $id_question = $_POST['input_id'];


    $stmt = $conn->prepare("INSERT INTO `answer`(`question_id`, `user_id`, `answer_text`,is_solution) VALUES (?, ?, ?,0)");

    $stmt->bind_param("iis", $id_question, $user_id, $response_text);

    if ($stmt->execute()) {
        echo '<form id="refreshForm" action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
        echo '<input type="hidden" name="input_id" value="' . $id_question . '">';
        echo '</form>';
        echo '<script>document.getElementById("refreshForm").submit();</script>';
        exit;
    } else {
        echo "Erreur lors de l'ajout de la réponse : " . $stmt->error;
    }

    $stmt->close();

}



if (isset($_POST['confirm_delete'])) {
    $answerId = $_POST["answer_id"];
    $id_question = $_POST["question_id"];
    // User confirmed the deletion
    $deleteQuery = "DELETE FROM answer WHERE answer_id = ? ";


    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $answerId);
    $stmt->execute();

    if ($stmt) {
        exit;
    } else {
        echo "Error deleting answer: " . $conn->error;
    }
} elseif (isset($_POST['cancel_delete'])) {
    exit;
}



if (isset($_POST["update_response"])) {
    $answerId = $_POST["answer_id"];
    $newAnswerText = $_POST["response_text"];
    $id_question = $_POST["question_id"];

    $updateQuery = "UPDATE answer SET answer_text = ? WHERE answer_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $newAnswerText, $answerId);
    $stmt->execute();
    if ($stmt) {
        exit;
    } else {
        echo "Error updating answer: " . $conn->error;
    }
}


$conn->close();
?>