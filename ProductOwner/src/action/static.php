<?php 
session_start();
if (!isset($_SESSION['id'])) {
    header("Location:../../../logout.php ");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charts with PHP and Tailwind CSS</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .bg-ce0033 {
            background-color: #CE0033;
        }
    </style>
</head>
<body class="bg-gray-100">
    <?php include '../../template/header.php'; ?>
    <div class="container mx-auto bg-white p-8 rounded-md shadow-md max-w-screen-md">
        <h2 class="text-lg font-semibold mb-4">Choose Chart:</h2>
        <form id="chartForm">
            <label for="chartType" class="mr-2">Select Chart Type:</label>
            <select id="chartType" name="chartType" class="p-2 border rounded">
                <option value="questionsPerProject">Number of Questions per Project</option>
                <option value="projectsMostQuestions">Projects with the Most Questions</option>
                <option value="projectLeastAnswers">Project with the Fewest Answers</option>
                <option value="userMostAnswers">User with the Most Answers</option>
            </select>
            <button type="button" onclick="updateChart()" class="bg-blue-500 text-white px-4 py-2 rounded ml-2">Show Chart</button>
        </form>
        <!-- Chart Container -->
        <div id="chartContainer" class="mt-6">
        <canvas id="dynamicChart" style="width: 300px; height: 300px;"></canvas>
        </div>
        <script>
            function updateChart() {
                var selectedChart = document.getElementById('chartType').value;
                fetch('./getData.php?chartType=' + selectedChart)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (window.myChart) {
                            window.myChart.destroy();
                        }
                        if (data) {
                            var ctx = document.getElementById('dynamicChart').getContext('2d');
                            window.myChart = new Chart(ctx, {
                                type: 'doughnut',
                                data: data,
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
            }
        </script>
    </div>
</body>
</html>
