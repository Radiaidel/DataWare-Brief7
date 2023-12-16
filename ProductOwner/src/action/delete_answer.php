<?php
include("../../../includes/config/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $answerId = $_POST["answer_id"];
    $id_question = $_POST["question_id"];

    if (isset($_POST['confirm_delete'])) {
        // User confirmed the deletion
        $deleteQuery = "DELETE FROM answer WHERE answer_id = ? ";


        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $answerId);
        $stmt->execute();

        if ($stmt) {
            header("Location: response.php?question_id=" . $id_question);
            exit;
        } else {
            echo "Error deleting answer: " . $conn->error;
        }
    }
    elseif(isset($_POST['cancel_delete'])){
        header("Location: response.php?question_id=" . $id_question);

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete answer</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex-col flex items-center justify-center">

    <div class="max-w-xl bg-white p-8 rounded-md shadow-lg">
        <p class="mb-4">Are you sure you want to delete the answer?</p>

        <form method="post" action="">
            <input type="hidden" name="answer_id" value="<?php echo $answerId; ?>">
            <input type="hidden" name="question_id" value="<?php echo $id_question; ?>">
            <div class="flex space-x-4 justify-between  ">
                <button type="submit" name="confirm_delete"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Yes, Delete Answer</button>
                <button type="submit" name="cancel_delete"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Cancel</button>
            </div>

        </form>
    </div>

</body>

</html>

<?php
// Close the database connection
$conn->close();
?>