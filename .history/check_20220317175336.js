let checkedBoxes = document.querySelectorAll("input[type='checkbox']");

for (let checkedBox of checkedBoxes) {
  checkedBox.addEventListener("change", () => {
    document.querySelector("p").style.textDecorationLine = "line-thr";
  });
}
