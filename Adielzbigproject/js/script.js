const navbarNav = document.querySelector(".navbar-nav");

document.querySelector("#motor-menu").onclick = () => {
  navbarNav.classList.toggle("active");
};

//toggle search
const searchForm = document.querySelector(".search-form");
const searchBox = document.querySelector("#search-box");

document.querySelector("#search-button").onclick = (e) => {
  searchForm.classList.toggle("active");
  searchBox.focus();
  e.preventDefault();
};
//toggle shopping
const shoppingCart = document.querySelector(".shopping-cart");
document.querySelector("#shopping-cart-button").onclick = (e) => {
  shoppingCart.classList.toggle("active");
};

//click out sidebar
const motor = document.querySelector("#motor-menu");

document.addEventListener("click", function (e) {
  if (!motor.contains(e.target) && !navbarNav.contains(e.target)) {
    navbarNav.classList.remove("active");
  }
});
