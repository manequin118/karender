/**
 *
 * チェックボックスをチェックをしたら予定に横線を入れる
 */
// let checkedBoxes = document.querySelectorAll("input[type='checkbox']");

// checkedBoxes.forEach((checkedBox) => {
//   checkedBox.addEventListener(
//     "click",
//     () => {
//       checkedBox.parentNode.classList.toggle("shcedule-end");
//     },
//     false
//   );
// });

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

//以下jQuery
$(".schedule").on("click", function () {
  //postメソッドで送るデータを定義 var data = {パラメータ名 : 値};
  //選択されたチェックボックスの値を配列に保存
  var checks = [];

  $("input[type='checkbox']:checked").each(function () {
    checks.push(this.value);
  });
  console.log(checks);

  $.ajax({
    type: "post",
    url: "ajaxCheck.php",
    data: {
      checkbox: checks,
    },
    //Ajax通信が成功した場合
    success: function (responce) {
      //PHPから返ってきたデータの表示

      // $(data).addClass("shcedule-end");

      const p = $("input[type='checkbox']:checked").parent();
      p.addClass("shcedule-end");
    },
  });
});
