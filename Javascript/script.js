document.getElementById('burgerBtn').addEventListener('click', function () {
    document.getElementById('burgerOverlay').classList.toggle('hidden');
});

function toggleDropdown(index) {
    var dropdown = document.getElementById('dropdown-' + index);
    dropdown.classList.toggle('hidden');
}
function validateForm() {
    var email = document.forms["signInForm"]["email"].value;
    var password = document.forms["signInForm"]["password"].value;

    // Simple email validation
    var emailRegex = /^[^\s@]+@[^\s@]+.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    // Password should not be empty
    if (password === "") {
        alert("Please enter your password.");
        return false;
    }

    return true;
}