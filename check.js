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
//カレンダーのチェックボックスでajaxでPOSTデータを送る
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

      const p = $("input[type='checkbox']:checked").parent();
      p.addClass("shcedule-end");
    },
  });
});

$("#comment_button").on("click", () => {
  const body = $("#comment_body").val();
  const id = $("#shcedule_id").val();
  console.log(body);
  console.log(id);

  $.ajax({
    type: "post",
    url: "showAjax.php",
    data: {
      comment_body: body,
      id: id,
    },
    datatype: "json",
    success: function (responce) {
      console.log(responce.comment);

      $("#result ul").append("<li>" + responce.comment + "</li>" + "</br>");
      // $("#result ul li").append(
      //   '  <input type="submit" value="✖️" id="comment_delete"></input>'
      // );
      console.log("通信成功");
    },
    error: function (responce) {
      console.log("通信失敗");
      const id = JSON.stringify(responce);
      console.log(id);
    },
  });
});

//コメント削除ボタン
$("#comment_delete").on("click", () => {
  const comment_id = $(this).data("comment_id");
  console.log(comment_id);
  $.ajax({
    type: "post",
    url: "deleteAjax.php",
    data: {
      id: comment_id,
      _method: "DELETE",
    },
    success: function (responce) {
      $("#comment li").remove();
    },
  });
});
