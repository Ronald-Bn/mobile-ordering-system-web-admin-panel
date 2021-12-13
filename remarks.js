$(document).ready(function () {
  $(".remarks").click(function () {
    var userid = $(this).data("id");
    $.ajax({
      url: "remarksfile.php",
      type: "post",
      data: { userid: userid },
      success: function (response) {
        $("#remarksModal").modal("show");
      },
    });
  });
});
