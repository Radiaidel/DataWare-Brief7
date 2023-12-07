<?php
include("../includes/config/connection.php");

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
                <form action="process_modification.php" method="post">
                    <label for="questionText">Question Text:</label>
                    <textarea name="questionText" id="questionText" rows="4" class="w-full mb-4"><?php echo $questionText; ?></textarea>
                    <input type="hidden" name="questionID" value="<?php echo $modifierID; ?>">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Modify Question</button>
                </form>
            </div>

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