<?php

include("../../../includes/config/connection.php");

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
       
        $stmt = mysqli_prepare($conn, 'UPDATE answer SET archived=1 WHERE answer_id = ?');
        if (!$stmt) {
            die("Prepare failed: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        header('location: response.php');
        exit();
    }
}

?>