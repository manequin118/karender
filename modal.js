const open = document.getElementById("modalOpen");
const modal = document.getElementById("modalMain");
const close = document.getElementById("modalClose");

open.addEventListener("click", modalOpen);
close.addEventListener("click", modalClose);

function modalOpen() {
  modal.style.display = "block";
}
function modalClose() {
  modal.style.display = "none";
}
