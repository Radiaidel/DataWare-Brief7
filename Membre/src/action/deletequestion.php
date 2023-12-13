<?php
include("../../../includes/config/connection.php");

if (isset($_GET['DeleteID'])) {
    $deleteID = $_GET['DeleteID'];

    $sql = "SELECT * FROM question WHERE question_id = $deleteID";
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
            <title>Delete Question</title>
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        </head>

        <body class="bg-gray-100 min-h-screen flex-col flex items-center justify-center">

            <div class="max-w-xl bg-white p-8 rounded-md shadow-lg">
                <p class="mb-4">Are you sure you want to delete the following question?</p>
                <p class="mb-4">Question Text: <?php echo $questionText; ?></p>
                <!-- Add other fields as needed -->

                <form action="process_deletion.php" method="post">
                    <input type="hidden" name="questionID" value="<?php echo $deleteID; ?>">
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete Question</button>
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

// Close the database connection
$conn->close();
?>