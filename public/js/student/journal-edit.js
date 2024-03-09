document.addEventListener("DOMContentLoaded", function () {
    var formElements = document.querySelectorAll("form input, form textarea");
    formElements.forEach(function (element) {
        element.setAttribute("readonly", true);
    });
});

// JavaScript to handle the click event
document.addEventListener("DOMContentLoaded", function () {
    var clickableImages = document.querySelectorAll(".clickable-image");

    clickableImages.forEach(function (image) {
        image.addEventListener("click", function () {
            var imageUrl = this.getAttribute("src");
            document.getElementById("modalImage").setAttribute("src", imageUrl);
            document.querySelector(".modal").classList.remove("hidden");
        });
    });

    document
        .querySelector(".modal-close")
        .addEventListener("click", function () {
            document.querySelector(".modal").classList.add("hidden");
        });

    document
        .querySelector(".modal-overlay")
        .addEventListener("click", function () {
            document.querySelector(".modal").classList.add("hidden");
        });
});
