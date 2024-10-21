$(function(){
    $("#logoutBtn").click(function () {
        $.ajax({
          url: "./handlers/logoutHandlerAdmin.php",
          type: "POST",
          success: function (res) {
            document.location.replace("index.php");
          },
          error: function (err) {
            alert("Something Went Wrong");
          },
        });
      });
})