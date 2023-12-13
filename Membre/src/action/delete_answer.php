<?php
include("../../../includes/config/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $answerId = $_POST["answer_id"];

    
    $deleteQuery = "DELETE FROM answer WHERE answer_id = $answerId ";
    $result = $conn->query($deleteQuery);

    if ($result) {
        echo "Answer deleted successfully";
    } else {
        echo "Error deleting answer: " . $conn->error;
    }
    header("Location:community.php"); 
}
?>
