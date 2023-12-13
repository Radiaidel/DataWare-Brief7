<?php
session_start();
include("../../../includes/config/connection.php");
include '../../template/header.php';
$userId = $_SESSION["id"];

$id_question = null;

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
            if (isset($_POST['input_id'])) {
                $id_question = $_POST['input_id'];

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
                        $questionowner = $row['user_id'];
                        // Fetching tags
                        $tagsSql = "SELECT t.tag_name FROM tags t JOIN question_tag qt ON qt.id_tag = t.id_tag WHERE qt.id_question = ?";
                        $tagsStmt = $conn->prepare($tagsSql);
                        $tagsStmt->bind_param("i", $id_question);
                        $tagsStmt->execute();
                        $tagsResult = $tagsStmt->get_result();

                        if (!$tagsResult) {
                            echo "Error fetching tags: " . $tagsStmt->error;
                        } else {
                            echo "<div class='mx-auto w-full  bg-white border  p-8 rounded-lg shadow-xl  mb-4'>";
                            echo "<div class='flex items-center text-gray-300 mb-4'>";
                            echo "<div class='flex-shrink-0'>";
                            echo "<img src='$imagePath' alt='User Image' class='w-10 h-10 rounded-full'>";
                            echo "</div>";
                            echo "<div class='ml-2'>";
                            echo "<p class='text-sm text-black'>$username</p>";
                            echo "<p class='text-xs text-black'>$insertionDate</p>";
                            echo "</div>";
                            echo "</div>";
                            echo "<div class='mb-6'>";
                            echo "<h1 class='text-red-500 text-2xl font-bold'>$questionTitre</h1>";
                            echo "<br>";
                            echo "<p class='text-black '>$questionText</p>";
                            echo "</div>";
                            echo "<div class='mb-4 space-x-2'>";
                            if ($tagsResult->num_rows > 0) {
                                while ($tagRow = $tagsResult->fetch_assoc()) {
                                    echo "<span class='inline-block bg-blue-200 text-blue-800 py-1 px-2 rounded'>";
                                    echo '#' . $tagRow['tag_name'];
                                    echo "</span>";
                                }
                            }
                            echo "</div>";
                            echo "<div class='flex space-x-5'>";
                            echo "<div class='flex items-center space-x-4 mb-4'>";
                            echo "<button class='flex items-center text-gray-300 hover:text-blue-500'>";
                            echo '';
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
                            echo "</button>";
                            echo "<button class='flex items-center text-gray-300 hover:text-red-500'>";


                            echo '<svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            transform="rotate(180)">';

                            echo '<g id="SVGRepo_bgCarrier" stroke-width="0" />';

                            echo '<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />';

                            echo '<g id="SVGRepo_iconCarrier">';
                            echo '<path
                                    d="M8 10H4V20H8M8 10V20M8 10L13.1956 3.9385C13.6886 3.36333 14.4642 3.11607 15.1992 3.2998L15.2467 3.31169C16.5885 3.64714 17.1929 5.2106 16.4258 6.36138L14 10H18.5604C19.8225 10 20.7691 11.1547 20.5216 12.3922L19.3216 18.3922C19.1346 19.3271 18.3138 20 17.3604 20H8"
                                    stroke="#646066" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />';
                            echo '</g>';

                            echo '</svg>';
                            echo "<span class='ml-1'>" . $row['dislikes'] . "</span>";
                            echo "</button>";
                            echo "</div>";
                            echo "</div>";
                            echo "<ul role='list' class='flex justify-center space-x-5'>";
                            if ($userId == $row['user_id']) {
                                echo "<li>";
                                echo "<a href='modifierquestion.php?modifierID=$id_question' class='text-indigo-300 hover:text-indigo-500'>";
                                echo "<svg viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>";
                                // ... (your existing code for the edit icon)
                                echo "</svg>";
                                echo "</a>";
                                echo "</li>";
                                echo "<li>";
                                echo "<a href='deletequestion.php?DeleteID=$id_question' class='text-indigo-300 hover:text-indigo-500'>";
                                echo "<svg viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>";
                                // ... (your existing code for the delete icon)
                                echo "</svg>";
                                echo "</a>";
                                echo "</li>";
                            }
                            echo "</ul>";
                            echo "</div>";
                        }
                    } else {
                        echo "Question not found.";
                    }
                }
            } else {
                echo "Question ID not specified in the URL.";
            }
            ?>

        </div>

        <div class="bg-gray-200   rounded rounded-md p-4 mb-4">
            <!-- <h2 class="text-lg font-semibold mb-2">Répondre à la question</h2> -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="space-y-4">
                <input type="hidden" name="input_id" value="<?php echo $id_question; ?>">

                <div>
                    <label for="response_text" class="block text-sm font-medium text-xl text-gray-700 mb-2 ml-2">Votre
                        réponse </label>
                    <textarea id="response_text" name="response_text" rows="4"
                        class="mt-1 p-2 w-full border rounded-md drop-shadow-lg border-slate-950"></textarea>
                </div>
                <!-- <input type="text" hidden name="id_question" value="<?php echo $id_question; ?>"> -->


                <div class="flex items-center">
                    <button type="submit" name="Envoyer_reponse"
                        class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Envoyer la
                        réponse</button>
                </div>
            </form>
        </div>

        <div>
            <!-- Displaying the responses -->
            <?php

            $sql = "SELECT answer_id, answer.user_id, created_at, answer_text, username, image_url, likes, dislikes FROM answer INNER JOIN users ON answer.user_id = id_user WHERE answer.question_id = ? and archived=0";
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
                        echo "<div class=' flex w-full drop-shadow-2xl flex-col items-center gap-8 mx-auto mt-8  p-6 rounded mt-1 p-2 border rounded-md drop-shadow-md border-slate-950'>";

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
                        echo "<div class='flex justify-between mt-4 ml-52'>";
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
                            echo "<button type='submit' class='flex items-end text-gray-600 hover:text-red-500'>";

                            // ... (your existing code for the delete icon)
            
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

                            echo "<form method='POST' action=''>";
                            echo " <input type='text' hidden name='input_id' value='$id_question'>";

                            echo "<input type='hidden' name='answer_id' value='" . $row['answer_id'] . "'>";
                            echo "<button type='submit' class='flex items-center text-gray-600 hover:text-green-500'>";





                            echo '<svg fill="#646066" width="30px" height="25px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>';

                            echo '<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>';

                            echo '<g id="SVGRepo_iconCarrier"> <title>lamp4</title> <path d="M17.747 14.017c-1.25 0.562-4.022-0.815-4.022-0.815-3.248-1.947 1.22 6.073 1.22 6.073s0.093 2.503 0.655 2.815c4.687-6.563 3.397-8.636 2.147-8.073zM16.060 20.24c-0.379 0-1.972-4.779-1.784-5.779 1.251 0.125 2.409 0.597 3.097 0.222 1.937-0.878-0.876 5.557-1.313 5.557zM19.952 23.947c0.115-7.305 4.046-10.116 4.046-14.466 0-3.712-2.54-8.45-7.87-8.45-5.329 0-8.126 4.533-8.126 8.484 0 4.436 3.993 7.224 3.993 14.478h4.043c0 0 3.798-0.046 3.914-0.046zM12.809 23.020c0-6.771-3.868-9.373-3.868-13.513 0-3.688 2.51-7.556 7.173-7.556s6.948 4.060 6.948 7.524c0 4.060-3.814 6.742-3.916 13.56-0.102 0-3.111-0.016-3.111-0.016h-3.226zM19.505 25.014h-7c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h7c0.275 0 0.5-0.224 0.5-0.5s-0.225-0.5-0.5-0.5zM19.505 27.014h-7c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h7c0.275 0 0.5-0.224 0.5-0.5s-0.225-0.5-0.5-0.5zM12.997 29.043c0 0 0 0.334 0 0.9s0.444 1.025 0.992 1.025h4.031c0.549 0 0.992-0.459 0.992-1.025s-0.062-0.9-0.062-0.9h-5.953z"/> </g>';

                            echo '</svg>';
                            echo "</button>";
                            echo "</form>";
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


//marquer reponse 
// Marquer la réponse comme solution
if (isset($_POST['answer_id'])) {
    $answerId = $_POST['answer_id'];

    // Utilisez le bon nom de table (answer au lieu de answers)
    $updateSql = $conn->prepare("UPDATE answer SET is_solution = 1 WHERE answer_id = ?");
    $updateSql->bind_param("s", $answerId);
    $updateSql->execute();
}





//ajouter
if (isset($_POST['Envoyer_reponse'])) {
    $user_id = $_SESSION['id'];
    $response_text = $_POST["response_text"];
    $id_question = $_POST['input_id'];


    $stmt = $conn->prepare("INSERT INTO `answer`(`question_id`, `user_id`, `answer_text`) VALUES (?, ?, ?)");

    $stmt->bind_param("iis", $id_question, $user_id, $response_text);

    if ($stmt->execute()) {
        echo "Réponse ajoutée avec succès à la base de données.";
    } else {
        echo "Erreur lors de l'ajout de la réponse : " . $stmt->error;
    }

    $stmt->close();
    // header("Location: " . $_SERVER['PHP_SELF']); 
    // exit();
}




$conn->close();
?>