<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Header</title>
    <script src="../Javascript/script.js" defer>

    </script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>

    <header class=" sticky top-0 w-full bg-blue-800 p-4 flex justify-between items-center">

        <div class="flex items-center">
            <img src="../Images/" alt="Logo" class=" mr-2">
            <span class="text-white text-lg font-semibold">Mon Logo</span>
        </div>

        <div class="flex  justify-between items-center">

            <button id="burgerBtn" class="text-white focus:outline-none sm:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>
            <nav class="hidden md:flex items-center space-x-4">
            <a href="../index.php" class="text-white">Dashboard</a>
            <a href="../action/community.php" class="text-white">Community</a>
            <a href="../action/project.php" class="text-white">Project</a>
            <a href="../action/team.php" class="text-white">Team</a>
            <a href="../../../logout.php" class="text-white px-7 py-2 rounded-full border border-white">Log out</a>


            </nav>
        </div>
    </header>
    <div id="burgerOverlay"
        class="fixed py-5 top-18 right-0 w-1/2 h-screen bg-blue-800 bg-opacity-50 z-50 hidden items-center justify-center sm:hidden">
        <nav class="flex flex-col items-center space-y-5">
            <a href="../index.php" class="text-white">Dashboard</a>
            <a href="../src/action/Community.php" class="text-white">Community</a>
            <a href="../src/action/project.php" class="text-white">Project</a>
            <a href="../src/action/team.php" class="text-white">Team</a>
            <a href="../../logout.php" class="text-white">Log out</a>
        </nav>
    </div>

    <script>

    </script>
</body>

</html>