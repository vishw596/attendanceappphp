$(function () {
  $("#login").submit(function () {
    event.preventDefault();
    $("#lockscreen").addClass("applylockscreen");
    let username = $("#username").val();
    let password = $("#pass").val();
    if (username.length > 20) {
      alert("Username must be less than 20 characters");
    } else if (password.length > 20) {
      alert("Password must be less than 20 characters");
      $("#password").val("");
    } else {
      let formData = $(this).serialize();
      $.ajax({
        url: "./handlers/loginHandler.php",
        type: "POST",
        data: formData,
        beforeSend: function () {
          $("#diverror").removeClass("applyerrordiv");
        },
        success: function (res) {
          let parsedRes = JSON.parse(res);
          if (parsedRes["status"] == "ALL OK") {
            document.location.replace("attendance.php");
          } else {
            // alert(parsedRes["status"]);
            $("#diverror").addClass("applyerrordiv");
            $("#errormessage").text(parsedRes["status"]);
          }
        },
        error: function (err) {
          alert("something went wrong");
        },
      });
    }
  });
});
