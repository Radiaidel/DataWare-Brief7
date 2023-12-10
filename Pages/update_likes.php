<?php
include("../includes/config/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $questionId = $_POST['question_id'];

    $sql = "UPDATE question SET likes = likes + 1 WHERE question_id = $questionId";
    $conn->query($sql);

    $result = $conn->query("SELECT likes FROM question WHERE question_id = $questionId");
    $row = $result->fetch_assoc();
    echo $row['likes'];
}

$conn->close();
