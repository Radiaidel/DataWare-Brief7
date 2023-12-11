<?php
include("../../../includes/config/connection.php");

if (isset($_GET['modifierID'])) {
    $modifierID = $_GET['modifierID'];

    // Retrieve the question details based on the provided ID
    $sql = "SELECT * FROM question WHERE question_id = $modifierID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $questionText = $row['question_text'];
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
                <!-- <form action="process_modification.php" method="post">
                    <label for="questionText">Question Text:</label>
                    <textarea name="questionText" id="questionText" rows="4" class="w-full mb-4"><?php echo $questionText; ?></textarea>
                    <input type="hidden" name="questionID" value="<?php echo $modifierID; ?>">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Modify Question</button>
                </form> -->


                <form action="process_modification.php" method="POST">
                    <input type="text" hidden name="questionID" value=" <?php echo $modifierID; ?>">
                    <div class="mb-4">

                        <input type="text" name="question_title" id="question_title" placeholder="Titre de la Question" class="mt-1 p-2 w-full border rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <textarea name="question_content" id="question_content" rows="2" placeholder="Contenu de la Question" class="mt-1 p-2 w-full border rounded-md" required></textarea>
                    </div>

                    <div class="mb-4">
                        <input type="text" id="tags" name="tags" placeholder="#Tag" class="mt-1 p-2 w-full border rounded-md" list="tagSuggestionsList" />
                        <div id="tagSuggestions">
                            <datalist id="tagSuggestionsList" class="hidden">
                            </datalist>
                        </div>
                        <input type="hidden" id="selectedTagId" name="selectedTagId" value="">
                    </div>

                    <button name="askQuestion" type="submit" class="bg-blue-500 text-white p-2 rounded-md ">Poser la
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

$conn->close();
?>