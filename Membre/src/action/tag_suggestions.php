<?php
include("../../../includes/config/connection.php");


$prefix = $_POST['prefix'];
$prefixModified ="%" . $prefix . "%";

$sql = "SELECT id_tag,tag_name FROM tags WHERE tag_name LIKE ? LIMIT 5";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Erreur de préparation de la requête : " . $conn->error);
}

$stmt->bind_param("s", $prefixModified);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo  "<option value=\"{$row['id_tag']} \">{$row['tag_name']}</option>";
}

$stmt->close();
$conn->close();
?>
