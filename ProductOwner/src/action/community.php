<?php
include("../../../includes/config/connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>dataware | DashBoard</title>
    <style>
        .bg-ce0033 {
            background-color: #CE0033;
        }
    </style>
</head>

<body class="bg-gray-200">
    <header class="bg-ce0033 sticky top-0 w-full  p-4 flex justify-between items-center ">
        <div class="text-xl font-bold w-32 mt-1">
            <img src="http://localhost/DataWare-Brief7/Membre/image/logov.PNG" class="w-full h-auto" alt="Logo">
        </div>

        <div class="flex items-center">
            <button id="burgerBtn" class="sm:hidden focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-6 h-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>

            <nav class="space-x-4 hidden sm:flex items-center">
                <a href="../../index.php" class="text-white hover:text-gray-300 transition duration-300">Dashboard</a>
                <a href="./community.php"
                    class="text-white hover:text-gray-300 transition duration-300">Community</a>
                <a href="./static.php"
                    class="text-white hover:text-gray-300 transition duration-300">Statics</a>
                <button id="logoutBtn" class="text-white px-7 py-2 rounded-full border border-white">
                    <a href="../logout.php" class="text-white">Log Out</a>
                </button>
            </nav>
        </div>
    </header>

    <!-- Navbar Responsive -->
    <div id="burgerOverlay"
        class="fixed py-5 top-18 right-0 w-1/2 h-screen bg-gray-800 bg-opacity-50 z-50 hidden items-center justify-center sm:hidden">
        <nav class="flex flex-col items-center space-y-5">
            <a href="../../index.php" class="text-white hover:text-gray-300 transition duration-300">Dashboard</a>
            <a href="./community.php"
                class="text-white hover:text-gray-300 transition duration-300">Community</a>
            <a href="./static.php"
                class="text-white hover:text-gray-300 transition duration-300">Statics</a>
            <a href="../logout.php" class="text-white hover:text-gray-300 transition duration-300">Log out</a>
        </nav>
    </div>

  
    <div class="w-full p-4 mb-4 lg:mb-0 bg-gray-200 rounded-md shadow-lg text-white">

    <div class="mx-auto w-3/5 flex items-center space-x-3 mb-4 my-5 z-10   p-4">
                    <div class="relative inline-block text-left">
                <div>
                    <button type="button" id="filterBotton"
                        class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-gray-600 text-sm font-medium text-gray-300 hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
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
                    class="hidden origin-top-right absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-gray-600 ring-1 ring-black ring-opacity-5">
                    <div class="py-1">
                        <a href="#"
                            class="filter-option block px-4 py-2 text-sm text-gray-300 hover:bg-gray-500 hover:text-gray-100"
                            data-filter-type="new">Date (New)</a>
                        <a href="#"
                            class="filter-option block px-4 py-2 text-sm text-gray-300 hover:bg-gray-500 hover:text-gray-100"
                            data-filter-type="old">Date (Old)</a>
                        <a href="#"
                            class="filter-option block px-4 py-2 text-sm text-gray-300 hover:bg-gray-500 hover:text-gray-100"
                            data-filter-type="all">All Questions</a>
                        <a href="#"
                            class="filter-option block px-4 py-2 text-sm text-gray-300 hover:bg-gray-500 hover:text-gray-100"
                            data-filter-type="my">My Questions</a>
                    </div>
                </div>
            </div>

            <div class="flex-1">
                <form id="searchForm" onsubmit="searchQuestions(); return false;" method="get">
                    <input type="text" id="searchInput" placeholder="Search questions..."
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500 bg-gray-600 text-white">
                </form>
            </div>
        </div>

        <div id="questionsContainer" class="mx-auto max-w-3/5">
            <!-- Contenu des questions -->
        </div>

    </div>


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

            // Add event listeners to filter options
            var filterOptions = document.getElementsByClassName('filter-option');
            for (var i = 0; i < filterOptions.length; i++) {
                filterOptions[i].addEventListener('click', function (event) {
                    var filterType = event.target.getAttribute('data-filter-type');
                    DisplayQuestions(filterType, 1, searchQuery);
                });
            }

            function DisplayQuestions(filterType, page, searchQuery) {

                console.log('Filter Type:', filterType);
                console.log('Page:', page);
                console.log('Search Query:', searchQuery);


                // Perform AJAX request and update the question container
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

                console.log('AJAX URL:', url);
                xhr.open('GET', url, true);
                xhr.send();
            }

            DisplayQuestions('new', 1, searchQuery);
        });

    </script>

    <!-- Place jQuery script before your custom script -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../../../Javascript/pagination.js" defer></script>
</body>

</html>

<?php
$conn->close();
?>