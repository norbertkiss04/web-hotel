function showHamburgerMenu() {
    console.log("show")
    var x = document.getElementById("hamburger-menu");
    x.style.display = "block";
}

function hideHamburgerMenu() {
    var x = document.getElementById("hamburger-menu");
    x.style.display = "none";
}
function changeImg(src) {
    var img = document.getElementById("main-img");
    img.src = src;
}
function formatPrice(price) {
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}