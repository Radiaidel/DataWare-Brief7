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
            </div>

    <?php
        }
    } else {
        echo "Aucune question trouvée.";
    }

    // Fermer la connexion à la base de données
    $conn->close();
    ?>

</body>

</html>