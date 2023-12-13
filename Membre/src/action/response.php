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

    <div class="w-full lg:w-3/4 mx-auto">
        <div class="bg-white p-4 mb-4 my-5">

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
                        $questionowner =$row['user_id'];
                        // Fetching tags
                        $tagsSql = "SELECT t.tag_name FROM tags t JOIN question_tag qt ON qt.id_tag = t.id_tag WHERE qt.id_question = ?";
                        $tagsStmt = $conn->prepare($tagsSql);
                        $tagsStmt->bind_param("i", $id_question);
                        $tagsStmt->execute();
                        $tagsResult = $tagsStmt->get_result();

                        if (!$tagsResult) {
                            echo "Error fetching tags: " . $tagsStmt->error;
                        } else {
                            echo "<div class='mx-auto w-full  p-8 rounded-xl shadow-xl text-white mb-4'>";
                            echo "<div class='flex items-center text-gray-300 mb-4'>";
                            echo "<div class='flex-shrink-0'>";
                            echo "<img src='$imagePath' alt='User Image' class='w-10 h-10 rounded-full'>";
                            echo "</div>";
                            echo "<div class='ml-2'>";
                            echo "<p class='text-sm'>$username</p>";
                            echo "<p class='text-xs'>$insertionDate</p>";
                            echo "</div>";
                            echo "</div>";
                            echo "<div class='mb-6'>";
                            echo "<h1 class='text-white text-2xl font-bold'>$questionTitre</h1>";
                            echo "<br>";
                            echo "<p class='text-gray-300'>$questionText</p>";
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
                            echo "<span class='ml-1'>" . $row['likes'] . "</span>";
                            echo "</button>";
                            echo "<button class='flex items-center text-gray-300 hover:text-red-500'>";
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

        <div class="bg-white p-4 mb-4">
            <h2 class="text-lg font-semibold mb-2">Répondre à la question</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="space-y-4">
                <input type="hidden" name="input_id" value="<?php echo $id_question; ?>">

                <div>
                    <label for="response_text" class="block text-sm font-medium text-gray-700">Votre réponse :</label>
                    <textarea id="response_text" name="response_text" rows="4"
                        class="mt-1 p-2 w-full border rounded-md"></textarea>
                </div>
                <!-- <input type="text" hidden name="id_question" value="<?php echo $id_question; ?>"> -->


                <div class="flex items-center">
                    <button type="submit" name="Envoyer_reponse"
                        class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Envoyer la
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
                        echo "<div class='bg-green-100 flex w-full flex-col items-center gap-8 mx-auto mt-8'>";
                        echo "<div class='bg-green-100 w-full p-6 rounded'>";
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
                            echo "<form method='POST' action='delete_answer.php'>";
                            echo "<input type='hidden' name='answer_id' value='" . $row['answer_id'] . "'>";
                            echo "<button type='submit' class='flex items-end text-gray-600 hover:text-red-500'>";
                            echo "<svg width='20px' height='20px' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>";
                            // ... (your existing code for the delete icon)
                            echo "</svg>";
                            echo "</button>";
                            echo "</form>";
                            echo "<form method='POST' action='answer_update.php'>";
                            echo "<input type='hidden' name='answer_id' value='" . $row['answer_id'] . "'>";
                            echo "<input type='hidden' name='question_id' value='" . $id_question . "'>";
                            echo "<button type='submit' name='toupdate' class='flex items-end text-gray-600 hover:text-red-500'>";
                            echo "<svg width='20px' height='20px' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>";
                            // ... (your existing code for the edit icon)
                            echo "</svg>";
                            echo "</button>";
                            echo "</form>";

                        }
                        if ($userId == $questionowner) {

                            echo "<form method='POST' action=''>";
                            echo " <input type='text' hidden name='input_id' value='$id_question'>";

                            echo "<input type='hidden' name='answer_id' value='" . $row['answer_id'] . "'>";
                            echo "<button type='submit' class='flex items-center text-gray-600 hover:text-green-500'>";
                            echo "<span class='ml-1'>Mark as Solution</span>";
                            echo "</button>";
                            echo "</form>";
                        }
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "<p class='mt-2 text-gray-800'>" . $row['answer_text'] . "</p>";
                        echo "<div class='flex justify-between mt-4'>";
                        echo "<form method='POST' action='like_dislike.php'>";
                        echo "<input type='hidden' name='answer_id' value='" . $row['answer_id'] . "'>";
                        echo "<input type='hidden' name='action' value='like'>";
                        echo "<button type='submit' class='flex items-center text-gray-600 hover:text-blue-500'>";
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