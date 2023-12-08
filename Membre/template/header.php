<!-- In your header.php or any appropriate template file -->
<header class="bg-gray-800 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo or Branding -->
        <div class="text-xl font-bold w-32 mt-1">
            <img src="../../../logo.png" class="w-full h-auto" alt="Logo">
        </div>
        <!-- Toggle Button for Responsive Navbar -->
        <button id="burgerBtn" class="sm:hidden focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
        <!-- Navigation Links -->
        <nav class="space-x-4 hidden sm:flex">
            <a href="#" class="hover:text-gray-300">Dashboard</a>
            <a href="#" class="hover:text-gray-300">Community</a>
            <a href="#" class="hover:text-gray-300">Team</a>
            <!-- Add more links as needed -->
        </nav>
       <!-- User Information with Image -->
    <div id="membreInfo" class="flex items-center hidden sm:flex">
        <!-- Assuming you have a user object with an 'image' property -->
        <img src="../../../upload/bob.jpg" alt="User Image" class="w-8 h-8 rounded-full mr-2">
        <button id="logoutBtn" class="text-white px-7 py-2 rounded-full border border-white">           
            Log Out
        </button>
    </div>
</header>

<!-- Navbar Responsive -->
<div id="burgerOverlay"
    class="fixed py-5 top-18 right-0 w-1/2 h-screen bg-blue-800 bg-opacity-50 z-50 hidden items-center justify-center sm:hidden">
    <nav class="flex flex-col items-center space-y-5">
        <a href="#" class="text-white">Dashboard</a>
        <a href="#" class="text-white">Community</a>
        <a href="#" class="text-white">Team</a>
        <a href="#" class="text-white">Log out</a>
    </nav>
</div>

<script>
document.getElementById('burgerBtn').addEventListener('click', function () {
    document.getElementById('burgerOverlay').classList.toggle('hidden');
});

// Function to show/hide user image based on screen size
function updateUserImageVisibility() {
    var membreInfo = document.getElementById('membreInfo');
    membreInfo.classList.toggle('hidden', window.innerWidth < 640); // Adjust the threshold as needed
}

// Initial call to set initial visibility
updateUserImageVisibility();

// Listen for window resize to update visibility
window.addEventListener('resize', updateUserImageVisibility);
</script>
