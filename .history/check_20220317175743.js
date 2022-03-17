let checkedBoxes = document.querySelectorAll("input[type='checkbox']");

for (let checkedBox of checkedBoxes) {
  checkedBox.addEventListener("change", () => {
    document.querySelectorAll("p").style.textDecorationLine = "line-through";
  });
}
