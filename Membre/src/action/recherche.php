<?php
include("../../../includes/config/connection.php");

$searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';

// Split the search term into an array of keywords
$keywords = explode(" ", $searchTerm);

// Build the WHERE clause for both question text and tags
$whereClause = "";
foreach ($keywords as $keyword) {
    $whereClause .= "(question_text LIKE '%$keyword%' OR tags.tag_name LIKE '%$keyword%') AND ";
}

// Remove the trailing " AND " from the WHERE clause
$whereClause = rtrim($whereClause, " AND ");

$sql = "SELECT question.*, GROUP_CONCAT(tags.tag_name) AS tag_names
        FROM question
        LEFT JOIN question_tag ON question.question_id = question_tag.id_question
        LEFT JOIN tags ON question_tag.id_tag = tags.id_tag
        WHERE $whereClause
        GROUP BY question.question_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $questions = array();

    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }

    echo json_encode($questions);
} else {
    echo json_encode(array('message' => 'No results found.'));
}

$conn->close();
