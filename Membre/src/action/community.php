<?php
include("../../../includes/config/connection.php");
include '../../template/header.php';
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
                    <form id="searchForm" class="flex">
                        <input type="text" id="searchInput" placeholder="Search questions..." class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                        <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md">Search</button>
                    </form>
                </div>
            </div>

            <div id="questions-container" class="max-w-xl">
                <!-- Questions will be dynamically loaded here using AJAX -->
            </div>
        </div>

        <!-- Right Side - Display Question and Answers -->
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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to handle form submission
            $("#searchForm").submit(function(event) {
                event.preventDefault(); // Prevents the default form behavior

                // Get the search input value
                var searchQuery = $("#searchInput").val();

                // Call the function to load questions using AJAX
                loadQuestions(searchQuery);
            });

            // Function to load questions using AJAX
            function loadQuestions(searchQuery) {
                $.ajax({
                    type: "GET",
                    url: "recherche.php",
                    data: {
                        searchTerm: searchQuery
                    },
                    dataType: "json",
                    success: function(data) {
                        // Clear the previous content
                        $("#questions-container").empty();

                        // Check if there are any questions
                        if (data.length > 0) {
                            // Show the container when there are matching questions
                            $("#questions-container").show();

                            // Loop through the questions and append only the matching one
                            $.each(data, function(index, question) {
                                $("#questions-container").append(
                                    "<div class='max-w-xl bg-white p-8 rounded-md shadow-md my-5 cursor-pointer hover:shadow-xl'>" +
                                    "<div class='flex items-center text-gray-600 mb-4'>" +
                                    "<div class='flex-shrink-0'>" +
                                    "<svg width='30px' height='30px' viewBox='0 0 20 20' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' fill='#17d924' stroke='#17d924'>" +
                                    "</svg>" +
                                    "</div>" +
                                    "<div class='ml-2'>" +
                                    "<p class='text-sm'>Posted by " + question.user_id + "</p>" +
                                    "<p class='text-xs'>Posted on " + question.created_at + "</p>" +
                                    "</div>" +
                                    "</div>" +
                                    "<div class='mb-6'>" +
                                    "<p class='text-gray-700'>" + question.question_text + "</p>" +
                                    "</div>" +
                                    "<div class='mb-4'>" +
                                    "<span class='inline-block bg-blue-200 text-blue-800 py-1 px-2 rounded mr-2'>" + question.tag_names + "</span>" +
                                    "</div>" +
                                    "<div class='flex items-center space-x-4'>" +
                                    "<button class='flex items-center text-gray-600 hover:text-blue-500'>" +
                                    "<svg fill='#0473c8' width='20px' height='20px' viewBox='0 0 24 24' stroke='#0473c8'>" +
                                    "</svg>" +
                                    "<span class='ml-1'>" + question.likes + "</span>" +
                                    "</button>" +
                                    "<button class='flex items-center text-gray-600 hover:text-red-500'>" +
                                    "<svg fill='#0473c8' height='20px' width='20px' version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 512 512' xml:space='preserve' stroke='#0473c8'>" +
                                    "</svg>" +
                                    "<span class='ml-1'>" + question.dislikes + "</span>" +
                                    "</button>" +
                                    "<form action='testttt.php' method='POST'>" +
                                    "<input type='text' hidden name='input_id' value='" + question.question_id + "'>" +
                                    "<button type='submit' class='flex items-center text-gray-600 hover:text-green-500'>" +
                                    "<svg width='20px' height='20px' viewBox='0 0 32 32' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:sketch='http://www.bohemiancoding.com/sketch/ns'>" +
                                    "</svg>" +
                                    "<span class='ml-1'>Respond</span>" +
                                    "</button>" +
                                    "</form>" +
                                    "</div>" +
                                    "</div>"
                                );
                            });
                        } else {
                            // If no questions found, hide the container and display a message
                            $("#questions-container").hide();
                            $("#questions-container").append("<p>No questions found.</p>");
                        }
                    },
                    error: function(error) {
                        console.log("AJAX Error: " + JSON.stringify(error));
                    }
                });
            }
        });
    </script>

</body>

</html>

<?php
$conn->close();
?>