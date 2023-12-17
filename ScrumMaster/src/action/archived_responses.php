<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        .bg-ce0033 {
            background-color: #CE0033;
        }
    </style>
</head>
<?php
include("../../../includes/config/connection.php");
include '../../template/header.php';
session_start();
if (!isset($_SESSION['id'])) {
    header("Location:../../../logout.php ");
}
// Retrieve the question ID from the URL
$id_question = $_GET['id_question'];

$userId = $_SESSION["id"];
// Retrieve archived responses with a join on the users table
$sql = "SELECT answer_id, answer.user_id, created_at, answer_text, username, image_url 
        FROM answer 
        INNER JOIN users ON answer.user_id = id_user 
        WHERE answer.archived = 1 AND answer.question_id = ?";
$stmt = $conn->prepare($sql);

// Bind the parameter
$stmt->bind_param("i", $id_question);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Output archived responses
    while ($row = $result->fetch_assoc()) {
        $imagePath = htmlspecialchars("/DATAWARE-BRIEF7/" . $row['image_url']);
        ?>

        <div class="bg-green-100 flex  w-full flex-col items-center gap-8 mx-auto mt-8">
            <div class=" bg-green-100 w-full p-6  rounded">
                <div class=" flex">
                    <div class="flex-shrink-0">
                        <img src="<?php echo $imagePath; ?>" alt="User Image" class="w-10 h-10 rounded-full">
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
                        <a href="archiverep.php?id=<?php echo $row['answer_id'] ?>"
                            class="text-white bg-blue-700 ml-24 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Archive</a>
                        <div class="flex justify-between mt-4 ml-52">




                            <?php
                            if ($userId == $row['user_id']) {
                                ?>

                                <form method="POST" action="delete_answer.php">
                                    <input type="hidden" name="answer_id" value="<?php echo $row['answer_id']; ?>">
                                    <button type="submit" class="flex items-end text-gray-600 hover:text-red-500">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z"
                                                stroke="#000000" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13"
                                                stroke="#000000" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </form>

                                <form method="POST" action="answer_update.php">
                                    <input type="hidden" name="answer_id" value="<?php echo $row['answer_id']; ?>">
                                    <input type="hidden" name="question_id" value="<?php echo $id_question; ?>">

                                    <button type="submit" name="toupdate" class="flex items-end text-gray-600 hover:text-red-500">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z"
                                                stroke="#000000" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13"
                                                stroke="#000000" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </form>


                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <p class="mt-2 text-gray-800">
                    <?php echo $row['answer_text']; ?>
                </p>
                <div class="flex justify-between mt-4">
                    <button class="flex items-center text-gray-600 hover:text-blue-500">
                        <!-- Your existing upvote button content -->
                    </button>
                    <button class="flex items-center text-gray-600 hover:text-red-500">
                        <!-- Your existing downvote button content -->
                    </button>
                </div>
            </div>
        </div>

        <?php
    }
} else {
    echo "Aucune reponses trouvée.";
}
?>