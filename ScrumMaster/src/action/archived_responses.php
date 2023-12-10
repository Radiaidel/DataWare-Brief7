<?php
include("../../../includes/config/connection.php");
include '../../template/header.php';

// Retrieve archived responses with a join on the users table
$sql = "SELECT answer.*, users.username 
        FROM answer 
        INNER JOIN users ON answer.user_id = users.id_user 
        WHERE answer.archived = 1";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>

        <div class="bg-green-100 flex w-full flex-col items-center gap-8 mx-auto mt-8">
            <div class="bg-green-100 w-full p-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <!-- Add content here if needed -->
                    </div>
                    <div class="flex justify-between w-full">
                        <div class="ml-2">
                            <p class="text-sm">Posted by
                                <?php echo $row['username']; ?>
                            </p>
                            <p class="text-xs">Posted on
                                <?php echo $row['created_at']; ?>
                            </p>
                        </div>
                        <div class="flex justify-between mt-4 ml-52">
                        </div>
                    </div>
                </div>
                <p class="mt-2 text-gray-800">
                    <?php echo $row['answer_text']; ?>
                </p>
            </div>
        </div>

<?php
    }
} else {
    echo "No archived responses found.";
}
?>