document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.querySelector(".hamburger");
    const menu = document.getElementById("mobile-menu");

    if (hamburger && menu) {
        hamburger.addEventListener("click", function () {
            menu.classList.toggle("show");
        });
    }
});
