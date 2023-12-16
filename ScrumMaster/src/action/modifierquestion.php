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
        $questionTitle = $rowQuestion['title_question'];

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

        <body class="bg-gray-100 min-h-screen flex-col flex  items-center justify-center">

            <div class="max-w-xl bg-white p-8 rounded-md shadow-lg w-9/12 ">

                <form action="process_modification.php" method="POST">
                    <input type="text" hidden name="questionID" value=" <?php echo $modifierID; ?>">
                    <div class="mb-4">

                        <input type="text" name="question_title" id="question_title" placeholder="Titre de la Question"
                            class="mt-1 p-2 w-full border  rounded-md" value=" <?php echo $questionTitle; ?>" required>
                    </div>

                    <div class="mb-4">
                        <textarea name="question_content" id="question_content" rows="6" placeholder="Contenu de la Question"
                            class="mt-1 p-2 w-full border rounded-md"
                            required><?php echo htmlspecialchars($questionText); ?></textarea>
                    </div>

                    <div class="mb-4">
                        <!-- Add code for displaying existing tags here if needed -->
                        <input type="text" id="tags" name="tags" placeholder="#Tag" class="mt-1 p-2 w-full border rounded-md"
                            list="tagSuggestionsList" value="<?php echo '#' . implode(' #', $existingTags); ?>" />
                        <div id="tagSuggestions">
                            <datalist id="tagSuggestionsList" class="hidden">
                            </datalist>
                        </div>
                        <input type="hidden" id="selectedTagId" name="selectedTagId" value="">
                    </div>

                    <button name="updateQuestion" type="submit" class="bg-red-500 text-white p-2 rounded-md ">Mettre à jour la
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
    } 
} else {
    echo "Invalid request. Please provide a question ID.";
}







$conn->close();
?>