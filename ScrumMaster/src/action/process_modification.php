<?php
include("../../../includes/config/connection.php");

if (isset($_POST['updateQuestion'])) {
    $questionID = $_POST['questionID'];
    $questionTitle = $_POST['question_title'];
    $questionContent = $_POST['question_content'];
    $tags = $_POST['selectedTagId'];

    $questionID = filter_var($questionID, FILTER_VALIDATE_INT);
    $questionTitle = filter_var($questionTitle, FILTER_SANITIZE_STRING);
    $questionContent = filter_var($questionContent, FILTER_SANITIZE_STRING);

    $sqlUpdateQuestion = "UPDATE question SET question_text = ?, title_question = ? WHERE question_id = ?";
    $stmtUpdateQuestion = $conn->prepare($sqlUpdateQuestion);

    if ($stmtUpdateQuestion === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmtUpdateQuestion->bind_param("ssi", $questionContent, $questionTitle, $questionID);
    $stmtUpdateQuestion->execute();

    $stmtUpdateQuestion->close();

    $tagIDs = explode(" ", $tags);

    $sqlDeleteTags = "DELETE FROM question_tag WHERE id_question = ?";
    $stmtDeleteTags = $conn->prepare($sqlDeleteTags);

    if ($stmtDeleteTags === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmtDeleteTags->bind_param("i", $questionID);
    $stmtDeleteTags->execute();

    $stmtDeleteTags->close();

    $sqlInsertQuestionTag = "INSERT INTO question_tag (id_question, id_tag) VALUES (?, ?)";
    $stmtInsertQuestionTag = $conn->prepare($sqlInsertQuestionTag);

    if ($stmtInsertQuestionTag === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }
    $stmtInsertQuestionTag->bind_param("ii", $questionID, $tagID);

    foreach ($tagIDs as $tagID) {
        $tagID = intval($tagID);
        $stmtInsertQuestionTag->execute();
    }

    $stmtInsertQuestionTag->close();

    header("Location: community.php");
    exit(); 
}

$conn->close();
?>
