<!-- In your header.php or any appropriate template file -->
<header class="sticky top-0 w-full bg-gray-800 p-4 flex justify-between items-center">
    <div class="text-xl font-bold w-32 mt-1">
        <img src="../../../logo.png" class="w-full h-auto" alt="Logo">
    </div>

    <div class="flex items-center">

        <button id="burgerBtn" class="sm:hidden focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>

        <nav class="space-x-4 hidden sm:flex items-center">
            <a href="./project.php" class="text-white hover:text-gray-300 transition duration-300">Dashboard</a>
            <a href="./community.php"  class="text-white hover:text-gray-300 transition duration-300">Community</a>
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
        <a href="./project.php" class="text-white hover:text-gray-300 transition duration-300">Dashboard</a>
        <a href="./community.php" class="text-white hover:text-gray-300 transition duration-300">Community</a>
        <a href="../../../logout.php"  class="text-white hover:text-gray-300 transition duration-300">Log out</a>
    </nav>
</div>

<script>
    document.getElementById('burgerBtn').addEventListener('click', function () {
        document.getElementById('burgerOverlay').classList.toggle('hidden');
    });

 
</script>