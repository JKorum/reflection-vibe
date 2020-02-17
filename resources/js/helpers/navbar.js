const navbar = document.getElementById("navbar");
const name = document.getElementById("project-name");

if (navbar && name) {
  document.addEventListener("scroll", () => {
    if (window.pageYOffset > navbar.clientHeight) {
      if (!name.classList.contains("fadeOut")) {
        name.classList.add("fadeOut");
      }
      if (name.classList.contains("fadeIn")) {
        name.classList.remove("fadeIn");
      }
      navbar.style.padding = "0 1rem";
    }

    if (window.pageYOffset < navbar.clientHeight) {
      if (name.classList.contains("fadeOut")) {
        name.classList.remove("fadeOut");
        name.classList.add("fadeIn");
      }
      navbar.style.padding = "0.5rem 1rem";
    }
  });
}
