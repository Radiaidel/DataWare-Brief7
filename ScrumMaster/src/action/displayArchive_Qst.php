<?php
include("../../../includes/config/connection.php");
include("../../action/displayArchive_Qst.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Community Page</title>
</head>

<body class="bg-gray-200 p-4">

    <div class="flex flex-col lg:flex-row">
        <!-- Left Side - List of Questions -->
        <div class="w-full lg:w-2/4 pr-4 mb-4 lg:mb-0">
            <div class="flex items-center space-x-3 mb-4 my-5">
                <!-- Filter Buttons -->
                <div>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-full">All questions</button>
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
            $sql = "SELECT * FROM questions WHERE archived = 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="max-w-xl bg-white p-8 rounded-md shadow-md my-5 cursor-pointer hover:shadow-xl">

                        <div class="flex items-center text-gray-600 mb-4">
                            <div class="flex-shrink-0">
                                <svg width="30px" height="30px" viewBox="0 0 20 20" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    fill="#17d924" stroke="#17d924">
                                    <!-- Your SVG content here -->
                                </svg>
                            </div>
                            <div class="ml-2">
                                <p class="text-sm">Posted by
                                    <?php echo $row['user_id']; ?>
                                </p>
                                <p class="text-xs">Posted on
                                    <?php echo $row['created_at']; ?>
                                </p>
                            </div>
                            <a href="archive.php?id=<?php echo $row['question_id'] ?>"
                                class="text-white bg-blue-700 ml-24 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Archive</a>
                        </div>

                        <div class="mb-6">
                            <!-- <h2 class="text-xl font-semibold mb-2"><?php echo $row['titre_question']; ?></h2> -->
                            <p class="text-gray-700">
                                <?php echo $row['question_text']; ?>
                            </p>
                        </div>

                        <div class="mb-4">
                            <span class="inline-block bg-blue-200 text-blue-800 py-1 px-2 rounded mr-2">#web</span>
                            <span class="inline-block bg-green-200 text-green-800 py-1 px-2 rounded mr-2">#product</span>
                            <span class="inline-block bg-yellow-200 text-yellow-800 py-1 px-2 rounded mr-2">#html</span>
                            <span class="inline-block bg-yellow-200 text-yellow-800 py-1 px-2 rounded mr-2">#js</span>
                        </div>

                        <div class="flex items-center space-x-4">

                            <button class="flex items-center text-gray-600 hover:text-blue-500">
                                <svg fill="#0473c8" width="20px" height="20px" viewBox="0 0 24 24"
                                    id="a11298b2-e15e-46f5-bfd2-69e168954b14" data-name="Livello 1"
                                    xmlns="http://www.w3.org/2000/svg" stroke="#0473c8">
                                    <!-- Your SVG content here -->
                                </svg>
                                <span class="ml-1">
                                    <?php echo $row['likes']; ?>
                                </span>
                            </button>


                            <button class="flex items-center text-gray-600 hover:text-red-500">
                                <svg fill="#0473c8" height="20px" width="20px" version="1.1" id="Layer_1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 512 512" xml:space="preserve" stroke="#0473c8">
                                    <!-- Your SVG content here -->
                                </svg>
                                <span class="ml-1">
                                    <?php echo $row['dislikes']; ?>
                                </span>
                            </button>

                            <button class="flex items-center text-gray-600 hover:text-green-500">
                                <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                    <!-- Your SVG content here -->
                                </svg>
                                <span class="ml-1">Respond</span>
                            </button>
                        </div>

                    </div>
                    <?php
                }
            } else {
                echo "Aucune question trouvée.";
            }
            ?>

        </div>

        <div class="w-full lg:w-3/4">
            <div class="bg-white p-4 mb-4 my-5">
                <h2 class="text-xl font-bold mb-2">Question 1</h2>
                <p>Content of Question 1...</p>

                <h3 class="text-lg font-bold mt-4 mb-2">Answers</h3>
                <ul>
                    <li>Answer 1</li>
                    <li>Answer 2</li>
                </ul>
            </div>
        </div>
    </div>

</body>

</html>
