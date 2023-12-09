<?php
session_start();
include("../../../includes/config/connection.php");
include '../../template/header.php';
$userId = $_SESSION["id"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

</head>

<body class="bg-gray-200">


    <div class="w-full lg:w-3/4">
        <div class="bg-white p-4 mb-4 my-5">

            <?php
            $id_question = '';
            if (isset($_POST['input_id'])) {
                $id_question = $_POST['input_id'];

                // Utiliser question_id pour récupérer la question correspondante
                $sql = "SELECT q.*, u.image_url, u.username, u.id_user FROM question q  INNER JOIN users u ON q.user_id = u.id_user WHERE question_id = $id_question";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    $imagePath = htmlspecialchars("/DataWare-Brief7/" . $row['image_url']);
                    $insertionDate = $row['created_at'];
                    $username = $row['username'];
                    $questionTitre = $row['title_question'];
                    $questionText = $row['question_text'];
                    $id_question = $row['question_id'];

                    $tagsSql = "SELECT t.tag_name FROM tags t JOIN question_tag qt ON qt.id_tag = t.id_tag WHERE qt.id_question = " . $id_question;
                    $tagsResult = $conn->query($tagsSql);

                    ?>

                    <div class="mx-auto w-full  bg-gray-800 p-8 rounded-xl shadow-xl text-white mb-4">
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


                        <div class="flex space-x-5">

                            <div class="flex items-center space-x-4 mb-4"> <!-- Ajout de la classe mb-4 ici -->
                                <button class="flex items-center text-gray-300 hover:text-blue-500">
                                    <span class="ml-1">
                                        <?php echo $row['likes']; ?>
                                    </span>
                                </button>

                                <button class="flex items-center text-gray-300 hover:text-red-500">
                                    <span class="ml-1">
                                        <?php echo $row['dislikes']; ?>
                                    </span>
                                </button>
                            </div>
                        </div>

                        <ul role="list" class="flex justify-center space-x-5">
                            <?php
                            // Check if the logged-in user is the creator of the question
                            if ($userId == $row['user_id']) {
                                ?>
                                <li>
                                    <a href="modifierquestion.php?modifierID=<?php echo $id_question; ?>"
                                        class="text-indigo-300 hover:text-indigo-500">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z"
                                                    stroke="#e5e5e5" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13"
                                                    stroke="#e5e5e5" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </g>
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="deletequestion.php?DeleteID=<?php echo $id_question; ?>"
                                        class="text-indigo-300 hover:text-indigo-500">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path d="M10 12V17" stroke="#e3e3e3" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path d="M14 12V17" stroke="#e3e3e3" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path d="M4 7H20" stroke="#e3e3e3" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10"
                                                    stroke="#e3e3e3" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z"
                                                    stroke="#e3e3e3" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
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
                } else {
                    echo "Question non trouvée.";
                }
            } else {
                echo "Identifiant de question non spécifié dans l'URL.";
            }
            ?>


        </div>

        <div class="bg-white p-4 mb-4">
            <h2 class="text-lg font-semibold mb-2">Répondre à la question</h2>
            <form action="" method="post" class="space-y-4">


                <div>
                    <label for="response_text" class="block text-sm font-medium text-gray-700">Votre réponse :</label>
                    <textarea id="response_text" name="response_text" rows="4"
                        class="mt-1 p-2 w-full border rounded-md"></textarea>
                </div>
                <input type="text" hidden name="id_question" value="<?php echo $id_question; ?>">


                <div class="flex items-center">
                    <button type="submit" name="Envoyer_reponse"
                        class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Envoyer la
                        réponse</button>
                </div>



            </form>
        </div>





        affichaaage des reponses

        <?php
        $sql = "SELECT answer_id, answer.user_id, created_at, answer_text, username, image_url FROM answer INNER JOIN users ON answer.user_id = id_user";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $imagePath = htmlspecialchars("/DATAWARE-BRIEF7/" . $row['image_url']);
                ?>

                <div class="bg-green-100 flex  w-full flex-col items-center gap-8 mx-auto mt-8">
                    <div class=" bg-green-100 w-full p-6  rounded">
                        <div class=" flex">
                            <div class="flex-shrink-0">
                                <img src="<?php echo $imagePath; ?>" alt="User Image" class="w-10 h-10 rounded-full">
                            </div>
                            <div class="flex justify-between w-full">
                                <div class="ml-2">
                                    <p class="text-sm">Posted by
                                        <?php echo $row['username']; ?>
                                    </p>
                                    <p class="text-xs">Posted on
                                        <?php echo $row['created_at']; ?>
                                    </p>
                                </div>
                                <div class="flex justify-between mt-4 ml-52">



                                    <?php
                                    if ($userId == $row['user_id']) {
                                        ?>

                                        <form method="POST" action="delete_answer.php">
                                            <input type="hidden" name="answer_id" value="<?php echo $row['answer_id']; ?>">
                                            <button type="submit" class="flex items-end text-gray-600 hover:text-red-500">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
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
                                            </button>
                                        </form>

                                        <form method="POST" action="answer_update.php">
                                            <input type="hidden" name="answer_id" value="<?php echo $row['answer_id']; ?>">
                                            <input type="hidden" name="question_id" value="<?php echo $id_question; ?>">

                                            <button type="submit" name="toupdate" class="flex items-end text-gray-600 hover:text-red-500">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
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
                                            </button>
                                        </form>


                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <p class="mt-2 text-gray-800">
                            <?php echo $row['answer_text']; ?>
                        </p>
                        <div class="flex justify-between mt-4">
                            <button class="flex items-center text-gray-600 hover:text-blue-500">
                                <!-- Your existing upvote button content -->
                            </button>
                            <button class="flex items-center text-gray-600 hover:text-red-500">
                                <!-- Your existing downvote button content -->
                            </button>
                        </div>
                    </div>
                </div>

                <?php
            }
        } else {
            echo "Aucune question trouvée.";
        }
        ?>

    </div>


    <?php

    if (isset($_POST['Envoyer_reponse'])) {
        $user_id = $_SESSION['id'];
        $response_text = $_POST["response_text"];
        $id_question = $_POST["id_question"];



        // Préparer la requête SQL
        $stmt = $conn->prepare("INSERT INTO `answer`(`question_id`, `user_id`, `answer_text`) VALUES (?, ?, ?)");

        // Lier les paramètres
        $stmt->bind_param("iis", $id_question, $user_id, $response_text);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "Réponse ajoutée avec succès à la base de données.";
        } else {
            echo "Erreur lors de l'ajout de la réponse : " . $stmt->error;
        }

        // Fermer la déclaration
        $stmt->close();
    }
    ?>


</body>

</html>

<?php
$conn->close();
?>