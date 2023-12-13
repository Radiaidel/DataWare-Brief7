<?php
// like_dislike_handler.php

// Assuming you have a database connection
include("../../../includes/config/connection.php");
session_start();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the action and question ID from the POST data
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $questionId = isset($_POST['questionId']) ? (int)$_POST['questionId'] : 0;

    // Check if the user is logged in
    if (!isset($_SESSION['id'])) {
        echo json_encode(['error' => 'User not logged in.']);
        exit;
    }

    // Get the user ID from the session
    $userId = $_SESSION['id'];

    // Handle different actions
    switch ($action) {
        case 'like_question':
            // Update the likes column in the question table
            $conn->query("UPDATE question SET likes = likes + 1 WHERE question_id = $questionId");
            break;

        case 'dislike_question':
            // Update the dislikes column in the question table
            $conn->query("UPDATE question SET dislikes = dislikes + 1 WHERE question_id = $questionId");
            break;

        // Add more cases for other actions if needed

        default:
            echo json_encode(['error' => 'Invalid action.']);
            exit;
    }

    // Get updated counts
    $likesCount = getLikesCount($questionId);
    $dislikesCount = getDislikesCount($questionId);

    // Return the updated counts
    echo json_encode(['likes' => $likesCount, 'dislikes' => $dislikesCount, 'state' => $action]);
    exit;
}

// Function to get the count of likes for a question
function getLikesCount($questionId) {
    global $conn;
    $result = $conn->query("SELECT likes FROM question WHERE question_id = $questionId");
    $row = $result->fetch_assoc();
    return $row['likes'];
}

// Function to get the count of dislikes for a question
function getDislikesCount($questionId) {
    global $conn;
    $result = $conn->query("SELECT dislikes FROM question WHERE question_id = $questionId");
    $row = $result->fetch_assoc();
    return $row['dislikes'];
}

// Close the database connection
$conn->close();
?>
