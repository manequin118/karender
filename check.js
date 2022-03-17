let checkedBoxes = document.querySelectorAll("input[type='checkbox']");

for (let checkedBox of checkedBoxes) {
  checkedBox.addEventListener("change", () => {
    const p = document.querySelectorAll("p");
    console.log(p);
  });
}
