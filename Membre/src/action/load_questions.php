<?php
include("../../../includes/config/connection.php");

$page = isset($_POST['page']) ? $_POST['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM question LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="max-w-xl bg-white p-8 rounded-md shadow-md my-5 cursor-pointer hover:shadow-xl">';
        
        echo '<div class="flex items-center text-gray-600 mb-4">';
        echo '<div class="flex-shrink-0">';
        echo '<svg width="30px" height="30px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#17d924" stroke="#17d924">';
        // Your SVG content here
        echo '</svg>';
        echo '</div>';
        echo '<div class="ml-2">';
        echo '<p class="text-sm">Posted by ' . $row['user_id'] . '</p>';
        echo '<p class="text-xs">Posted on ' . $row['created_at'] . '</p>';
        echo '</div>';
        echo '</div>';

        echo '<div class="mb-6">';
        echo '<p class="text-gray-700">' . $row['question_text'] . '</p>';
        echo '</div>';

        echo '<div class="mb-4">';
        echo '<span class="inline-block bg-blue-200 text-blue-800 py-1 px-2 rounded mr-2">#web</span>';
        echo '<span class="inline-block bg-green-200 text-green-800 py-1 px-2 rounded mr-2">#product</span>';
        echo '<span class="inline-block bg-yellow-200 text-yellow-800 py-1 px-2 rounded mr-2">#html</span>';
        echo '<span class="inline-block bg-yellow-200 text-yellow-800 py-1 px-2 rounded mr-2">#js</span>';
        echo '</div>';

        echo '<div class="flex items-center space-x-4">';
        
        echo '<button class="flex items-center text-gray-600 hover:text-blue-500">';
        echo '<svg fill="#0473c8" width="20px" height="20px" viewBox="0 0 24 24" id="a11298b2-e15e-46f5-bfd2-69e168954b14" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" stroke="#0473c8">';
        // Your SVG content here
        echo '</svg>';
        echo '<span class="ml-1">' . $row['likes'] . '</span>';
        echo '</button>';

        echo '<button class="flex items-center text-gray-600 hover:text-red-500">';
        echo '<svg fill="#0473c8" height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" stroke="#0473c8">';
        // Your SVG content here
        echo '</svg>';
        echo '<span class="ml-1">' . $row['dislikes'] . '</span>';
        echo '</button>';

        echo '<button class="flex items-center text-gray-600 hover:text-green-500">';
        echo '<svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">';
        // Your SVG content here
        echo '</svg>';
        echo '<span class="ml-1">Respond</span>';
        echo '</button>';
        
        echo '</div>';

        echo '</div>';
    }
} else {
    echo "Aucune question trouvée.";
}


$conn->close();
?>
