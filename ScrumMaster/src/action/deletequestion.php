<?php
include("../../../includes/config/connection.php");

if (isset($_GET['DeleteID'])) {
    $deleteID = $_GET['DeleteID'];

    $sql = "SELECT * FROM question WHERE question_id = $deleteID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
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

                <form action="process_deletion.php" method="post">
                    <input type="hidden" name="questionID" value="<?php echo $deleteID; ?>">
                    <div class="flex space-x-4 justify-between  ">
                        <button type="submit" name="confirm_delete"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Delete Question</button>
                        <button type="submit" name="cancel_delete"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Cancel</button>
                    </div>
                </form>
            </div>

        </body>

        </html>

        <?php
    } else {
        echo "Question not found.";
    }
}

// Close the database connection
$conn->close();
?>