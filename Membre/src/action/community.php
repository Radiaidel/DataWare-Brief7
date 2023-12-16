<?php
include("../../../includes/config/connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
   
    <script src="../../../Javascript/pagination.js" defer></script>
    <style>
        .bg-ce0033 {
            background-color: #CE0033;
        }
    </style>
</head>

<body class="w-full h-full  bg-gray-200 rounded-md text-white"> <!--header-->
    <?php
    include '../../template/header.php';
    ?>
    <div class="p-4">

        <div class="mx-auto w-3/5 flex items-center space-x-3 mb-4 my-5 z-10 p-4">
            <div class="relative inline-block text-left">
                <div>
                    <button type="button" id="filterBotton"
                        class="inline-flex justify-center w-full rounded-md border border-gray-400 shadow-sm px-4 py-2  bg-white z-40 text-sm font-medium text-gray-500 hover:bg-red-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
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
                    class="hidden origin-top-right absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                    <div class="py-1">
                        <a href="#"
                            class="filter-option block px-4 py-2 text-sm text-gray-600 hover:bg-red-500 hover:text-gray-100"
                            data-filter-type="new">Date (New)</a>
                        <a href="#"
                            class="filter-option block px-4 py-2 text-sm text-gray-600 hover:bg-red-500 hover:text-gray-100"
                            data-filter-type="old">Date (Old)</a>
                        <a href="#"
                            class="filter-option block px-4 py-2 text-sm text-gray-600 hover:bg-red-500 hover:text-gray-100"
                            data-filter-type="all">All Questions</a>
                        <a href="#"
                            class="filter-option block px-4 py-2 text-sm text-gray-600 hover:bg-red-500 hover:text-gray-100"
                            data-filter-type="my">My Questions</a>
                    </div>
                </div>
            </div>

            <div class="flex-1">
                <form id="searchForm" onsubmit="searchQuestions(); return false;" method="get">
                    <input type="text" id="searchInput" placeholder="Search questions..."
                        class="w-full px-4 py-2  rounded-md border border-gray-400 focus:outline-none focus:border-blue-500 bg-white text-black">
                </form>
            </div>
        </div>


        <div id="questionsContainer" class="mx-auto max-w-3/5">
            <!-- Contenu des questions -->
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>


        document.getElementById('filterBotton').addEventListener("click", function () {
            document.getElementById("MenuFilter").classList.toggle("hidden");
        });

        document.getElementById('searchForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Empêche la soumission par défaut du formulaire
            searchQuestions();
        });


        function searchQuestions() {
            var searchQuery = document.getElementById('searchInput').value;
            DisplayQuestions('search', 1, searchQuery);
        }


        document.addEventListener('DOMContentLoaded', function () {
            var searchQuery = '';
            document.getElementById('searchInput').addEventListener('input', function () {
                searchQuery = this.value;
                DisplayQuestions('search', 1, searchQuery);
            });

            var filterOptions = document.getElementsByClassName('filter-option');
            for (var i = 0; i < filterOptions.length; i++) {
                filterOptions[i].addEventListener('click', function (event) {
                    var filterType = event.target.getAttribute('data-filter-type');
                    DisplayQuestions(filterType, 1, searchQuery);
                });
            }

            function DisplayQuestions(filterType, page, searchQuery) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        document.getElementById('questionsContainer').innerHTML = xhr.responseText;
                    }
                };
                var url = 'load_questions.php?filter=' + filterType + '&page=' + page;
                if (filterType === 'search') {
                    url += '&search=' + encodeURIComponent(searchQuery);
                }

                xhr.open('GET', url, true);
                xhr.send();
            }

            DisplayQuestions('new', 1, searchQuery);
        });
        $(document).ready(function () {
        $('#filterBotton').on('click', function () {
            $('#MenuFilter').toggleClass('hidden');
        });

        $('#searchForm').on('submit', function (event) {
            event.preventDefault();
            searchQuestions();
        });

        $('.filter-option').on('click', function () {
            var filterType = $(this).data('filter-type');
            DisplayQuestions(filterType, 1, $('#searchInput').val());
        });

        $('.like-answer-button').on('click', function () {
            var answerId = $(this).data('answer-id');
            console.log('Liked answer with ID:', answerId);
            // Perform the like action (you can send this information to the server using AJAX)
            // Update the UI as needed
        });

        $('.dislike-answer-button').on('click', function () {
            var answerId = $(this).data('answer-id');
            console.log('Disliked answer with ID:', answerId);
            // Perform the dislike action (you can send this information to the server using AJAX)
            // Update the UI as needed
        });

        $('#searchInput').on('input', function () {
            var searchQuery = $(this).val();
            searchQuestions();
        });

        function searchQuestions() {
            var searchQuery = $('#searchInput').val();
            DisplayQuestions('search', 1, searchQuery);
        }

        function DisplayQuestions(filterType, page, searchQuery) {
            $.ajax({
                url: 'load_questions.php',
                type: 'GET',
                data: {
                    filter: filterType,
                    page: page,
                    search: searchQuery
                },
                success: function (response) {
                    $('#questionsContainer').html(response);
                },
                error: function (error) {
                    console.error(error);
                }
            });
        }

        DisplayQuestions('new', 1, '');
    });


    </script>




</body>

</html>

<?php
$conn->close();
?>
