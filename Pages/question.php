<?php
include("../includes/config/connection.php");
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
    // Your existing PHP code for database connection and fetching questions
    $sql = "SELECT q.*, u.image_url, u.username FROM question q JOIN users u ON q.user_id = u.id_user";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $imagePath = htmlspecialchars("/DataWare-Brief7/" . $row['image_url']);
            $imagePath = $row['image_url'];
            $insertionDate = $row['created_at'];
            $username = $row['username'];
            $questionText = $row['question_text'];
            $id_question = $row['question_id'];

            // Requête SQL pour récupérer les tags associés à chaque question
            $tagsSql = "SELECT t.tag_name FROM tags t JOIN question_tag qt ON qt.id_tag = t.id_tag WHERE qt.id_question = " . $id_question;
            $tagsResult = $conn->query($tagsSql);

    ?>
            <div class="max-w-xl bg-white p-8 rounded-md shadow-lg">

                <div class="flex items-center text-gray-600 mb-4">
                    <div class="flex-shrink-0">
                        <?php
                         // Debugging line to print the image path
                        var_dump($imagePath);
                        ?>
                        <img src="<?php echo $imagePath; ?>" alt="User Image" class="w-10 h-10 rounded-full">
                    </div>
                    <div class="ml-2">
                        <p class="text-sm"> <?php echo $username; ?></p>
                        <p class="text-xs"> <?php echo $insertionDate; ?></p>
                    </div>
                </div>

                <div class="mb-6">
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