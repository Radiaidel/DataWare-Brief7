<?php
include("../../../includes/config/connection.php");
include '../../template/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../../Javascript/script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Community Page</title>
</head>

<body class="bg-gray-200 p-4">

    <div class="flex flex-col lg:flex-row">
        <div class="w-full lg:w-2/4 pr-4 mb-4 lg:mb-0  ">
            <div class="flex items-center space-x-3 mb-4 my-5">
                <!-- ******************************************raaaaaaaaaaaaaaaaaaaadiiiiaaaaaa partie filter *********************************************************** -->
                <div class="max-w-md mx-auto">
                    <div class="relative inline-block text-left">
                        <div>
                            <button type="button" id="filterBotton"
                                class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
                                Filter
                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <div id="MenuFilter"
                            class="hidden  origin-top-right absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                <a href="#"
                                    class="filter-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                    data-filter-type="new">Date (New)</a>
                                <a href="#"
                                    class="filter-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                    data-filter-type="old">Date (Old)</a>
                                <a href="#"
                                    class="filter-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                    data-filter-type="all">All Questions</a>
                                <a href="#"
                                    class="filter-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                    data-filter-type="my">My Questions</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ******************************************************************************************************************* -->


                <!-- Search Bar -->
                <div class="flex-1">
                    <form action="">
                        <input type="text" placeholder="Search questions..."
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                    </form>
                </div>
            </div>
<!-- raaaaaaaaaaaaaaaaaaaadiiiiaaaaaa afficher les questions -->
            <div id="questionsContainer">

            </div>
<!-- ****************************************************** -->
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

    <script>

        
document.getElementById('filterBotton').addEventListener("click", function () {
    document.getElementById("MenuFilter").classList.toggle("hidden");
});

document.addEventListener('DOMContentLoaded', function () {
    // Add event listeners to filter options
    var filterOptions = document.getElementsByClassName('filter-option');
    for (var i = 0; i < filterOptions.length; i++) {
        filterOptions[i].addEventListener('click', function (event) {
            var filterType = event.target.getAttribute('data-filter-type');
            loadQuestions(filterType);
        });
    }

    function loadQuestions(filterType) {
        // Perform AJAX request and update the question container
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('questionsContainer').innerHTML = xhr.responseText;
            }
        };
        xhr.open('GET', 'load_questions.php?filter=' + filterType, true);
        xhr.send();
    }
    loadQuestions('all');

});
    </script>
</body>

</html>

<?php
$conn->close();
?>