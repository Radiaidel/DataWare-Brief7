document.getElementById('burgerBtn').addEventListener('click', function () {
    document.getElementById('burgerOverlay').classList.toggle('hidden');
});

function toggleDropdown(index) {
    var dropdown = document.getElementById('dropdown-' + index);
    dropdown.classList.toggle('hidden');
}