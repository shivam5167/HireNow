let navbar = document.querySelector(".header .flex .navbar");
let profile = document.querySelector(".header .flex .profile");

document.querySelector("#menu-btn").onclick = () => {
  navbar.classList.toggle("active");
  profile.classList.remove("active");
};

document.querySelector("#user-btn").onclick = () => {
  profile.classList.toggle("active");
  navbar.classList.remove("active");
};

window.onscroll = () => {
  navbar.classList.remove("active");
  profile.classList.remove("active");
};

let mainImage = document.querySelector(
  ".quick-view .box .row .image-container .main-image img"
);
let subImages = document.querySelectorAll(
  ".quick-view .box .row .image-container .sub-image img"
);

subImages.forEach((images) => {
  images.onclick = () => {
    src = images.getAttribute("src");
    mainImage.src = src;
  };
});

//custom theme
const themeButton = document.getElementById("theme-button");
const darkTheme = "dark-theme";
const iconTheme = "fa-sun";
const getCurrentTheme = () =>
  document.body.classList.contains(darkTheme) ? "dark" : "light";
const getCurrentIcon = () =>
  themeButton.classList.contains(iconTheme) ? "fa-moon" : "fa-sun";

  console.log(themeButton);

themeButton.addEventListener("click", () => {
  console.log("hello");
  document.body.classList.toggle(darkTheme)
  themeButton.classList.toggle(iconTheme)
});
