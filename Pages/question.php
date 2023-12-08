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

<div class="mx-auto w-3/5 bg-gray-800 p-8 rounded-xl shadow-xl text-white mb-4">
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

    <div class="flex items-center space-x-4 mb-4"> <!-- Ajout de la classe mb-4 ici -->
        <button class="flex items-center text-gray-300 hover:text-blue-500">
            <svg fill="#0473c8" width="20px" height="20px" viewBox="0 0 24 24" id="a11298b2-e15e-46f5-bfd2-69e168954b14" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" stroke="#0473c8">
                <!-- Your SVG content here -->
            </svg>
            <span class="ml-1"><?php echo $row['likes']; ?></span>
        </button>

        <button class="flex items-center text-gray-300 hover:text-red-500">
            <svg fill="#0473c8" height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" stroke="#0473c8">
                <!-- Your SVG content here -->
            </svg>
            <span class="ml-1"><?php echo $row['dislikes']; ?></span>
        </button>
    </div>

    <ul role="list" class="flex justify-center space-x-5">
        <?php
        // Check if the logged-in user is the creator of the question
        if ($userId == $row['user_id']) {
            ?>
            <li>
                <a href="modifierquestion.php?modifierID=<?php echo $id_question; ?>" class="text-indigo-300 hover:text-indigo-500">
                    <svg class="w-8 h-6" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512">
                        <!-- Your SVG content here -->
                    </svg>
                </a>
            </li>
            <li>
                <a href="deletequestion.php?DeleteID=<?php echo $id_question; ?>" class="text-indigo-300 hover:text-indigo-500">
                    <svg class="w-6 h-6 mt-3" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                        <!-- Your SVG content here -->
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