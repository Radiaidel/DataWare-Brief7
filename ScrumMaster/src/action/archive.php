<?php

include("../../../includes/config/connection.php");

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];


        $checkStmt = $conn->prepare('SELECT archived FROM question WHERE question_id = ?');
        $checkStmt->bind_param("i", $id);
        $checkStmt->execute();
        $checkStmt->bind_result($checkResult);
        $checkStmt->fetch();
        $checkStmt->close();

        $newArchivedStatus = ($checkResult == 1) ? 0 : 1;

        $updateStmt = $conn->prepare('UPDATE question SET archived=? WHERE question_id = ?');
        $updateStmt->bind_param("ii", $newArchivedStatus, $id);
        $updateStmt->execute();
        $updateStmt->close();

        $conn->close();

        header('location: community.php');
        exit();
    }
    if (isset($_GET['answerid'])) {
        $id = $_GET['answerid'];


        $checkStmt = $conn->prepare('SELECT archived FROM answer WHERE answer_id = ?');
        $checkStmt->bind_param("i", $id);
        $checkStmt->execute();
        $checkStmt->bind_result($checkResult);
        $checkStmt->fetch();
        $checkStmt->close();

        $newArchivedStatus = ($checkResult == 1) ? 0 : 1;

        $updateStmt = $conn->prepare('UPDATE answer SET archived=? WHERE answer_id = ?');
        $updateStmt->bind_param("ii", $newArchivedStatus, $id);
        $updateStmt->execute();
        $updateStmt->close();

        $conn->close();

        header('location: community.php');
        exit();
    }
}

?>
