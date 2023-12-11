<?php
include("../../../includes/config/connection.php");

if (isset($_GET['modifierID'])) {
    $modifierID = $_GET['modifierID'];

    // Retrieve the question details based on the provided ID
    $sqlQuestion = "SELECT * FROM question WHERE question_id = ?";
    $stmtQuestion = $conn->prepare($sqlQuestion);
    $stmtQuestion->bind_param("i", $modifierID);
    $stmtQuestion->execute();
    $resultQuestion = $stmtQuestion->get_result();

    if ($resultQuestion->num_rows > 0) {
        $rowQuestion = $resultQuestion->fetch_assoc();
        $questionText = $rowQuestion['question_text'];

        // Retrieve the associated tags for the question using prepared statement
        $sqlTags = "SELECT tags.tag_name FROM tags 
                    INNER JOIN question_tag ON tags.id_tag = question_tag.id_tag
                    WHERE question_tag.id_question = ?";
        $stmtTags = $conn->prepare($sqlTags);
        $stmtTags->bind_param("i", $modifierID);
        $stmtTags->execute();
        $resultTags = $stmtTags->get_result();

        $existingTags = [];
        while ($rowTag = $resultTags->fetch_assoc()) {
            $existingTags[] = $rowTag['tag_name'];
        }
        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Modify Question</title>
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        </head>

        <body class="bg-gray-100 min-h-screen flex-col items-center justify-center">

            <div class="max-w-xl bg-white p-8 rounded-md shadow-lg">
                <form action="" method="POST">
                    <input type="text" hidden name="questionID" value="<?php echo $modifierID; ?>">
                    <div class="mb-4">
                        <input type="text" name="question_title" id="question_title" placeholder="Titre de la Question"
                            class="mt-1 p-2 w-full border rounded-md" required value="<?php echo htmlspecialchars($rowQuestion['title_question']); ?>">
                    </div>

                    <div class="mb-4">
                        <textarea name="question_content" id="question_content" rows="2" placeholder="Contenu de la Question"
                            class="mt-1 p-2 w-full border rounded-md" required><?php echo htmlspecialchars($questionText); ?></textarea>
                    </div>

                    <div class="mb-4">
                        <!-- Add code for displaying existing tags here if needed -->
                        <input type="text" id="tags" name="tags" placeholder="#Tag" class="mt-1 p-2 w-full border rounded-md" list="tagSuggestionsList"
        value="<?php echo '#' . implode(' #', $existingTags); ?>" />
                        <div id="tagSuggestions">
                            <datalist id="tagSuggestionsList" class="hidden">
                            </datalist>
                        </div>
                        <input type="hidden" id="selectedTagId" name="selectedTagId" value="">
                    </div>

                    <button name="updateQuestion" type="submit" class="bg-blue-500 text-white p-2 rounded-md">Mettre à jour la
                        Question</button>
                </form>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var tagsInput = document.getElementById("tags");
                    var tagSuggestions = document.getElementById("tagSuggestions");
                    var selectedTagIdInput = document.getElementById("selectedTagId");

                    var selectedTagIds = [];

                    tagsInput.addEventListener("input", function () {
                        var input = tagsInput.value;

                        if (input.includes("#")) {
                            var prefix = input.split("#").pop();
                            getTagSuggestions(prefix);
                        } else {
                            tagSuggestions.innerHTML = "";
                        }
                    });

                    tagSuggestions.addEventListener("click", function (event) {
                        if (event.target.tagName === "OPTION") {
                            var selectedTagId = event.target.getAttribute("data-tag-id");
                            var currentTags = tagsInput.value;

                            selectedTagIds.push(selectedTagId);

                            var updatedTags = currentTags + "" + event.target.value;

                            tagsInput.value = updatedTags.trim();

                            selectedTagIdInput.value = selectedTagIds.join(" ");

                            tagSuggestions.innerHTML = "";
                        }
                    });
                });


                function getTagSuggestions(prefix) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "tag_suggestions.php", true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            document.getElementById("tagSuggestions").innerHTML = xhr.responseText;
                        }
                    };
                    xhr.send("prefix=" + encodeURIComponent(prefix));
                }
            </script>

        </body>

        </html>

        <?php
    } else {
        echo "Question not found.";
    }
} else {
    echo "Invalid request. Please provide a question ID.";
}









if (isset($_POST['updateQuestion'])) {
    $questionID = $_POST['questionID'];
    $questionTitle = $_POST['question_title'];
    $questionContent = $_POST['question_content'];
    $tags = $_POST['selectedTagId'];

    // Perform the update for the question
    $sqlUpdateQuestion = "UPDATE question SET question_text = ?, title_question = ? WHERE question_id = ?";
    $stmtUpdateQuestion = $conn->prepare($sqlUpdateQuestion);

    if ($stmtUpdateQuestion === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmtUpdateQuestion->bind_param("ssi", $questionContent, $questionTitle, $questionID);
    $stmtUpdateQuestion->execute();

    $stmtUpdateQuestion->close();

    // Update tags for the question
    $tagIDs = explode(" ", $tags);

    // Delete existing tags for the question
    $sqlDeleteTags = "DELETE FROM question_tag WHERE id_question = ?";
    $stmtDeleteTags = $conn->prepare($sqlDeleteTags);

    if ($stmtDeleteTags === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmtDeleteTags->bind_param("i", $questionID);
    $stmtDeleteTags->execute();

    $stmtDeleteTags->close();

   // Insert new tags for the question
   $sqlInsertQuestionTag = "INSERT INTO question_tag (id_question, id_tag) VALUES (?, ?)";
   $stmtInsertQuestionTag = $conn->prepare($sqlInsertQuestionTag);

   if ($stmtInsertQuestionTag === false) {
       die("Erreur de préparation de la requête : " . $conn->error);
   }

   foreach ($tagIDs as $tagID) {
       $tagID = intval($tagID);

       $stmtInsertQuestionTag->bind_param("ii", $questionID, $tagID);
       $stmtInsertQuestionTag->execute();
   }

   $stmtInsertQuestionTag->close();

   // Redirect to the question page or wherever needed
   header("Location: question_project.php");
   exit(); // Ensure that no code is executed after the header function
}

$conn->close();
?>