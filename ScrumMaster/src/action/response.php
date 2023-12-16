<?php
session_start();
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

                                            <li>
                                                <a href="archive.php?id=<?php echo $row['question_id'] ?>"
                                                    class="text-indigo-300 hover:text-indigo-500">

                                                    <?php

                                                    if (0 == $row['archived']) {
                                                        ?>

                                                        <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M3.61399 4.21063C3.17804 3.87156 2.54976 3.9501 2.21069 4.38604C1.87162 4.82199 1.95016 5.45027 2.38611 5.78934L4.66386 7.56093C3.78436 8.54531 3.03065 9.68043 2.41854 10.896L2.39686 10.9389C2.30554 11.1189 2.18764 11.3514 2.1349 11.6381C2.09295 11.8661 2.09295 12.1339 2.1349 12.3618C2.18764 12.6485 2.30554 12.881 2.39686 13.0611L2.41854 13.104C4.35823 16.956 7.71985 20 12.0001 20C14.2313 20 16.2129 19.1728 17.8736 17.8352L20.3861 19.7893C20.8221 20.1284 21.4503 20.0499 21.7894 19.6139C22.1285 19.178 22.0499 18.5497 21.614 18.2106L3.61399 4.21063ZM16.2411 16.5654L14.4434 15.1672C13.7676 15.6894 12.9201 16 12.0001 16C9.79092 16 8.00006 14.2091 8.00006 12C8.00006 11.4353 8.11706 10.898 8.32814 10.4109L6.24467 8.79044C5.46659 9.63971 4.77931 10.6547 4.20485 11.7955C4.17614 11.8525 4.15487 11.8948 4.13694 11.9316C4.12114 11.964 4.11132 11.9853 4.10491 12C4.11132 12.0147 4.12114 12.036 4.13694 12.0684C4.15487 12.1052 4.17614 12.1474 4.20485 12.2045C5.9597 15.6894 8.76726 18 12.0001 18C13.5314 18 14.9673 17.4815 16.2411 16.5654ZM10.0187 11.7258C10.0064 11.8154 10.0001 11.907 10.0001 12C10.0001 13.1046 10.8955 14 12.0001 14C12.2667 14 12.5212 13.9478 12.7538 13.8531L10.0187 11.7258Z"
                                                                fill="#0F1729" />
                                                            <path
                                                                d="M10.9506 8.13908L15.9995 12.0661C15.9999 12.0441 16.0001 12.022 16.0001 12C16.0001 9.79085 14.2092 7.99999 12.0001 7.99999C11.6369 7.99999 11.285 8.04838 10.9506 8.13908Z"
                                                                fill="#0F1729" />
                                                            <path
                                                                d="M19.7953 12.2045C19.4494 12.8913 19.0626 13.5326 18.6397 14.1195L20.2175 15.3467C20.7288 14.6456 21.1849 13.8917 21.5816 13.104L21.6033 13.0611C21.6946 12.881 21.8125 12.6485 21.8652 12.3618C21.9072 12.1339 21.9072 11.8661 21.8652 11.6381C21.8125 11.3514 21.6946 11.1189 21.6033 10.9389L21.5816 10.896C19.6419 7.04402 16.2803 3.99998 12.0001 3.99998C10.2848 3.99998 8.71714 4.48881 7.32934 5.32257L9.05854 6.66751C9.98229 6.23476 10.9696 5.99998 12.0001 5.99998C15.2329 5.99998 18.0404 8.31058 19.7953 11.7955C19.824 11.8525 19.8453 11.8948 19.8632 11.9316C19.879 11.964 19.8888 11.9853 19.8952 12C19.8888 12.0147 19.879 12.036 19.8632 12.0684C19.8453 12.1052 19.824 12.1474 19.7953 12.2045Z"
                                                                fill="#0F1729" />
                                                        </svg>

                                                        <?php
                                                    } else { ?>

                                                        <!-- show -->
                                                        <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M12 6C8.76722 6 5.95965 8.31059 4.2048 11.7955C4.17609 11.8526 4.15483 11.8948 4.1369 11.9316C4.12109 11.964 4.11128 11.9853 4.10486 12C4.11128 12.0147 4.12109 12.036 4.1369 12.0684C4.15483 12.1052 4.17609 12.1474 4.2048 12.2045C5.95965 15.6894 8.76722 18 12 18C15.2328 18 18.0404 15.6894 19.7952 12.2045C19.8239 12.1474 19.8452 12.1052 19.8631 12.0684C19.8789 12.036 19.8888 12.0147 19.8952 12C19.8888 11.9853 19.8789 11.964 19.8631 11.9316C19.8452 11.8948 19.8239 11.8526 19.7952 11.7955C18.0404 8.31059 15.2328 6 12 6ZM2.41849 10.896C4.35818 7.04403 7.7198 4 12 4C16.2802 4 19.6419 7.04403 21.5815 10.896C21.5886 10.91 21.5958 10.9242 21.6032 10.9389C21.6945 11.119 21.8124 11.3515 21.8652 11.6381C21.9071 11.8661 21.9071 12.1339 21.8652 12.3619C21.8124 12.6485 21.6945 12.8811 21.6032 13.0611C21.5958 13.0758 21.5886 13.09 21.5815 13.104C19.6419 16.956 16.2802 20 12 20C7.7198 20 4.35818 16.956 2.41849 13.104C2.41148 13.09 2.40424 13.0758 2.39682 13.0611C2.3055 12.881 2.18759 12.6485 2.13485 12.3619C2.09291 12.1339 2.09291 11.8661 2.13485 11.6381C2.18759 11.3515 2.3055 11.119 2.39682 10.9389C2.40424 10.9242 2.41148 10.91 2.41849 10.896ZM12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10ZM8.00002 12C8.00002 9.79086 9.79088 8 12 8C14.2092 8 16 9.79086 16 12C16 14.2091 14.2092 16 12 16C9.79088 16 8.00002 14.2091 8.00002 12Z"
                                                                fill="#0F1729" />
                                                        </svg>
                                                        <?php
                                                    }
                                                    ?>
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
            <form method="POST" class="flex justify-end p-10">
                <input type='hidden' name='input_id' value="<?php echo $id_question; ?>">
                <button type="submit" name="showArchivedBtn" id="showArchivedBtn"
                    class="inline-flex justify-center  rounded-md border border-gray-400 shadow-sm px-4 py-2  bg-white z-40 text-sm font-medium text-gray-500 hover:bg-red-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
                    Archived Answers</button>
                <button type="submit" name="showAllBtn" id="showAllBtn"
                    class="inline-flex justify-center  rounded-md border border-gray-400 shadow-sm px-4 py-2  bg-white z-40 text-sm font-medium text-gray-500 hover:bg-red-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">All
                    Answers</button>
        </div>
        <?php
        if (isset($_POST["showAllBtn"])) {
            $sql = "SELECT answer_id, answer.user_id, created_at, answer_text, username, image_url, likes, dislikes,is_solution,archived FROM answer INNER JOIN users ON answer.user_id = id_user WHERE answer.question_id = ?  ORDER BY is_solution DESC, created_at DESC ";
        } elseif (isset($_POST["showArchivedBtn"])) {
            $sql = "SELECT answer_id, answer.user_id, created_at, answer_text, username, image_url, likes, dislikes,is_solution,archived FROM answer INNER JOIN users ON answer.user_id = id_user WHERE answer.question_id = ? and archived=1 ORDER BY is_solution DESC, created_at DESC ";

        } else {

            $sql = "SELECT answer_id, answer.user_id, created_at, answer_text, username, image_url, likes, dislikes,is_solution,archived FROM answer INNER JOIN users ON answer.user_id = id_user WHERE answer.question_id = ? and archived=0 ORDER BY is_solution DESC, created_at DESC ";
        }

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
                    echo "<div class=' flex w-full drop-shadow-2xl flex-col items-center gap-3 mx-auto  px-3 rounded border rounded-md drop-shadow-md border-slate-950'>";

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
                    }

                    ?>
                    
                        <a href="archive.php?answerid=<?php echo $row['answer_id'] ?>"
                            class="text-indigo-300 hover:text-indigo-500">

                            <?php

                            if (0 == $row['archived']) {
                                ?>

                                <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3.61399 4.21063C3.17804 3.87156 2.54976 3.9501 2.21069 4.38604C1.87162 4.82199 1.95016 5.45027 2.38611 5.78934L4.66386 7.56093C3.78436 8.54531 3.03065 9.68043 2.41854 10.896L2.39686 10.9389C2.30554 11.1189 2.18764 11.3514 2.1349 11.6381C2.09295 11.8661 2.09295 12.1339 2.1349 12.3618C2.18764 12.6485 2.30554 12.881 2.39686 13.0611L2.41854 13.104C4.35823 16.956 7.71985 20 12.0001 20C14.2313 20 16.2129 19.1728 17.8736 17.8352L20.3861 19.7893C20.8221 20.1284 21.4503 20.0499 21.7894 19.6139C22.1285 19.178 22.0499 18.5497 21.614 18.2106L3.61399 4.21063ZM16.2411 16.5654L14.4434 15.1672C13.7676 15.6894 12.9201 16 12.0001 16C9.79092 16 8.00006 14.2091 8.00006 12C8.00006 11.4353 8.11706 10.898 8.32814 10.4109L6.24467 8.79044C5.46659 9.63971 4.77931 10.6547 4.20485 11.7955C4.17614 11.8525 4.15487 11.8948 4.13694 11.9316C4.12114 11.964 4.11132 11.9853 4.10491 12C4.11132 12.0147 4.12114 12.036 4.13694 12.0684C4.15487 12.1052 4.17614 12.1474 4.20485 12.2045C5.9597 15.6894 8.76726 18 12.0001 18C13.5314 18 14.9673 17.4815 16.2411 16.5654ZM10.0187 11.7258C10.0064 11.8154 10.0001 11.907 10.0001 12C10.0001 13.1046 10.8955 14 12.0001 14C12.2667 14 12.5212 13.9478 12.7538 13.8531L10.0187 11.7258Z"
                                        fill="#0F1729" />
                                    <path
                                        d="M10.9506 8.13908L15.9995 12.0661C15.9999 12.0441 16.0001 12.022 16.0001 12C16.0001 9.79085 14.2092 7.99999 12.0001 7.99999C11.6369 7.99999 11.285 8.04838 10.9506 8.13908Z"
                                        fill="#0F1729" />
                                    <path
                                        d="M19.7953 12.2045C19.4494 12.8913 19.0626 13.5326 18.6397 14.1195L20.2175 15.3467C20.7288 14.6456 21.1849 13.8917 21.5816 13.104L21.6033 13.0611C21.6946 12.881 21.8125 12.6485 21.8652 12.3618C21.9072 12.1339 21.9072 11.8661 21.8652 11.6381C21.8125 11.3514 21.6946 11.1189 21.6033 10.9389L21.5816 10.896C19.6419 7.04402 16.2803 3.99998 12.0001 3.99998C10.2848 3.99998 8.71714 4.48881 7.32934 5.32257L9.05854 6.66751C9.98229 6.23476 10.9696 5.99998 12.0001 5.99998C15.2329 5.99998 18.0404 8.31058 19.7953 11.7955C19.824 11.8525 19.8453 11.8948 19.8632 11.9316C19.879 11.964 19.8888 11.9853 19.8952 12C19.8888 12.0147 19.879 12.036 19.8632 12.0684C19.8453 12.1052 19.824 12.1474 19.7953 12.2045Z"
                                        fill="#0F1729" />
                                </svg>

                                <?php
                            } else { ?>

                                <!-- show -->
                                <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12 6C8.76722 6 5.95965 8.31059 4.2048 11.7955C4.17609 11.8526 4.15483 11.8948 4.1369 11.9316C4.12109 11.964 4.11128 11.9853 4.10486 12C4.11128 12.0147 4.12109 12.036 4.1369 12.0684C4.15483 12.1052 4.17609 12.1474 4.2048 12.2045C5.95965 15.6894 8.76722 18 12 18C15.2328 18 18.0404 15.6894 19.7952 12.2045C19.8239 12.1474 19.8452 12.1052 19.8631 12.0684C19.8789 12.036 19.8888 12.0147 19.8952 12C19.8888 11.9853 19.8789 11.964 19.8631 11.9316C19.8452 11.8948 19.8239 11.8526 19.7952 11.7955C18.0404 8.31059 15.2328 6 12 6ZM2.41849 10.896C4.35818 7.04403 7.7198 4 12 4C16.2802 4 19.6419 7.04403 21.5815 10.896C21.5886 10.91 21.5958 10.9242 21.6032 10.9389C21.6945 11.119 21.8124 11.3515 21.8652 11.6381C21.9071 11.8661 21.9071 12.1339 21.8652 12.3619C21.8124 12.6485 21.6945 12.8811 21.6032 13.0611C21.5958 13.0758 21.5886 13.09 21.5815 13.104C19.6419 16.956 16.2802 20 12 20C7.7198 20 4.35818 16.956 2.41849 13.104C2.41148 13.09 2.40424 13.0758 2.39682 13.0611C2.3055 12.881 2.18759 12.6485 2.13485 12.3619C2.09291 12.1339 2.09291 11.8661 2.13485 11.6381C2.18759 11.3515 2.3055 11.119 2.39682 10.9389C2.40424 10.9242 2.41148 10.91 2.41849 10.896ZM12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10ZM8.00002 12C8.00002 9.79086 9.79088 8 12 8C14.2092 8 16 9.79086 16 12C16 14.2091 14.2092 16 12 16C9.79088 16 8.00002 14.2091 8.00002 12Z"
                                        fill="#0F1729" />
                                </svg>
                                <?php
                            }
                            ?>
                        </a>

                    
                    <?php


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




$conn->close();
?>