let lastScroll = 0;
const header = document.getElementById("header");

window.addEventListener("scroll", () => {
  const currentScroll = window.pageYOffset;
  
  if (currentScroll > lastScroll) {
    // Scroll down
    header.style.transform = "translateY(-100%)";
  } else {
    // Scroll up
    header.style.transform = "translateY(0)";
  }
  lastScroll = currentScroll;
});
