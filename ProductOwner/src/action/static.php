<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <title>dataware | DashBoard</title>
    <style>
        .bg-ce0033 {
            background-color: #CE0033;
        }

        .chart-card {
            background-color: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            height: 100%;
            
        }

        /* Add a maximum height for the chart containers */
        canvas {
            max-height: 300px; /* You can adjust this value as needed */
        }
    </style>
</head>

<body class="bg-gray-200">
    <header class="bg-ce0033 sticky top-0 w-full p-4 flex justify-between items-center">
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
                <a href="../../index.php"
                    class="text-white hover:text-gray-300 transition duration-300">Dashboard</a>
                <a href="./community.php"
                    class="text-white hover:text-gray-300 transition duration-300">Community</a>
                <a href="./src/action/static.php"
                    class="text-white hover:text-gray-300 transition duration-300">Statics</a>
                <button id="logoutBtn" class="text-white px-7 py-2 rounded-full border border-white">
                    <a href="../../../logout.php" class="text-white">Log Out</a>
                </button>
            </nav>
        </div>
    </header>

    <!-- Navbar Responsive -->
    <div id="burgerOverlay"
        class="fixed py-5 top-18 right-0 w-1/2 h-screen bg-gray-800 bg-opacity-50 z-50 hidden items-center justify-center sm:hidden">
        <nav class="flex flex-col items-center space-y-5">
            <a href="" class="text-white hover:text-gray-300 transition duration-300">Dashboard</a>
            <a href="./src/action/community.php"
                class="text-white hover:text-gray-300 transition duration-300">Community</a>
            <a href="./src/action/static.php"
                class="text-white hover:text-gray-300 transition duration-300">Statics</a>
            <a href="../logout.php" class="text-white hover:text-gray-300 transition duration-300">Log out</a>
        </nav>
    </div>
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-semibold mb-4">DataWare Statics : </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mt-6">
            <!-- Chart Card 1 -->
            <div class="chart-card p-4">
                <h3 class="text-lg font-semibold mb-2">Number of Questions per Project</h3>
                <canvas id="chart1"></canvas>
            </div>

            <!-- Chart Card 2 -->
            <div class="chart-card p-4">
                <h3 class="text-lg font-semibold mb-2">Projects with the Most Questions</h3>
                <canvas id="chart2"></canvas>
            </div>

            <!-- Chart Card 3 -->
            <div class="chart-card p-4">
                <h3 class="text-lg font-semibold mb-2">Project with the Fewest Answers</h3> 
                <canvas id="chart3"></canvas>
            </div>

            <!-- Chart Card 4 -->
            <div class="chart-card p-4">
                <h3 class="text-lg font-semibold mb-2">User with the Most Answers</h3>
                <canvas id="chart4"></canvas>
            </div>
        </div>

        <script>
            document.getElementById('burgerBtn').addEventListener('click', function () {
                document.getElementById('burgerOverlay').classList.toggle('hidden');
            });

            // Initial update
            updateCharts();

            function updateCharts() {
                updateChart('chart1', 'questionsPerProject', 'doughnut');
                updateChart('chart2', 'projectsMostQuestions', 'bar');
                updateChart('chart3', 'projectLeastAnswers', 'pie'); // Use 'pie' for this chart
                updateChart('chart4', 'userMostAnswers', 'doughnut');
            }

            function updateChart(chartId, chartType, chartStyle) {
                fetch(`./getData.php?chartType=${chartType}`)
                    .then(response => response.json())
                    .then(data => {
                        updateSingleChart(chartId, data, chartStyle);
                    })
                    .catch(error => {
                        console.error(`Error fetching data for ${chartId}:`, error);
                    });
            }

            function updateSingleChart(chartId, data, chartStyle) {
                var ctx = document.getElementById(chartId).getContext('2d');

                // Check if the chart exists before attempting to destroy it
                if (window[chartId] && typeof window[chartId].destroy === 'function') {
                    window[chartId].destroy();
                }

                // Check for 'doughnut', 'bar', or 'pie' chart style
                if (chartStyle === 'doughnut') {
                    window[chartId] = new Chart(ctx, {
                        type: 'doughnut',
                        data: data,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                } else if (chartStyle === 'bar') {
                    window[chartId] = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                } else if (chartStyle === 'pie') {
                    window[chartId] = new Chart(ctx, {
                        type: 'pie',
                        data: data,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                }
            }
        </script>
    </div>
</body>

</html>
