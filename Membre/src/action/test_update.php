<?php
include("../../../includes/config/connection.php");
include '../../template/header.php';

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["answer_id"])) {
    $answerId = $_GET["answer_id"];
    $sql = "SELECT user_id, answer_text FROM answer WHERE user_id = $answerId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $answerText = $row['answer_text'];
?>
        <!-- Edit answer form -->
       

            <form method="post" action="update2.php" class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md mt-10">
                <input type="hidden" name="answer_id" value="<?php echo $row['user_id']; ?>">

                <textarea name="answer_text" rows="4" cols="50" class="w-full px-4 py-2 border rounded-md mb-4"><?php echo $answerText; ?></textarea>

                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:shadow-outline-green active:bg-green-800">
                    Save Changes
                </button>
            </form>

<?php
    } else {
        echo "Answer not found.";
    }
} else {
    echo "Invalid request.";
}


?>
