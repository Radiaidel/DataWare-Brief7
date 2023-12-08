<?php 
include("../../../includes/config/connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Page</title>
    <script src="../Javascript/script.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--icon-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha384-GLhlTQ8iN17SJLlFfZVfP5z01K4JPTNqDQ5a6jgl5Up3H+9TP5IotK2+Obr4u" crossorigin="anonymous" />
</head>

<body class="bg-gray-200 ">
    <!--header-->
<?php
include '../../template/header.php';
?>
    <div class="flex flex-col lg:flex-row">
        <!-- Left Side - List of Questions -->
        <div class="w-full lg:w-2/4 pr-4 mb-4 lg:mb-0">
            <div class="flex items-center space-x-3 mb-4 my-5">
                <!-- Filter Buttons -->
                <div>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-full" onclick="loadQuestions(1)">All questions</button>
                </div>
                <div>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-full">My questions</button>
                </div>

                <!-- Search Bar -->
                <div class="flex-1">
                    <form action="">
                        <input type="text" placeholder="Search questions..."
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                    </form>
                </div>
            </div>
            
            <?php
            // Execute your SQL query
            $sql = "SELECT * FROM question";
            $result = $conn->query($sql);

            // Check if the query was successful
            if ($result === false) {
                // Handle the error, you might want to log or display an error message
                echo "Error executing the query: " . $conn->error;
                exit;
            }

            // Assuming $result is a valid result set
            $totalQuestions = $result->num_rows;
            $questionsPerPage = 10; // You can adjust this value based on your preference

            $totalPages = ceil($totalQuestions / $questionsPerPage);
            ?>

            <!-- Container for paginated content -->
            <div id="pagination-container">
                <!-- Questions will be dynamically loaded here -->
            </div>

            <!-- Pagination Navigation -->
            <div class="flex items-center justify-center mt-4">
                <?php
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo '<button class="bg-blue-500 text-white px-4 py-2 rounded-full mr-2" onclick="loadQuestions(' . $i . ')">' . $i . '</button>';
                }
                ?>
            </div>

        </div>

        <!-- Right Side - Display Question and Answers -->
        <div class="w-full lg:w-3/4">
            <!-- Content for the right side (question and answers) goes here -->
        </div>
    </div>


    <!-- Place jQuery script before your custom script -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../../../Javascript/pagination.js" defer></script>
</body>

</html>

<?php
$conn->close();
?>
