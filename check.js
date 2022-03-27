/**
 *
 * チェックボックスをチェックをしたら予定に横線を入れる
 */
let checkedBoxes = document.querySelectorAll("input[type='checkbox']");

checkedBoxes.forEach((checkedBox) => {
  checkedBox.addEventListener(
    "click",
    () => {
      checkedBox.parentNode.classList.toggle("shcedule-end");
    },
    false
  );
});

// ヘッダーのプルダウン
let loginId = document.getElementById("login");

loginId.addEventListener(
  "mouseover",
  () => {
    loginId.querySelector(".list").classList.add("active");
  },
  false
);
loginId.addEventListener(
  "mouseout",
  () => {
    loginId.querySelector(".list").classList.remove("active");
  },
  false
);
