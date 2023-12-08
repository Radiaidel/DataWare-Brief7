function DisplayQuestions(filterType, page) {
    // Perform AJAX request and update the question container
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('questionsContainer').innerHTML = xhr.responseText;
        }
    };
    xhr.open('GET', 'load_questions.php?filter=' + filterType + '&page=' + page, true);
    xhr.send();
}