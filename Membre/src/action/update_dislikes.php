<?php
include("../../../includes/config/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $questionId = $_POST['question_id'];

    // Update the dislike count in the database (you'll need to adjust this based on your schema)
    $sql = "UPDATE question SET dislikes = dislikes + 1 WHERE question_id = $questionId";
    $conn->query($sql);

    // Fetch the updated dislike count
    $result = $conn->query("SELECT dislikes FROM question WHERE question_id = $questionId");
    $row = $result->fetch_assoc();
    echo $row['dislikes'];
}

$conn->close();
