$(document).ready(function () {
  $(".remarks").click(function () {
    var key = $(this).data("id");
    $.ajax({
      url: "remarksfile.php",
      type: "post",
      data: { key: key },
      success: function (response) {
        $("#remarks").html(response);
        $("#remarksModal").modal("show");
      },
    });
  });
});
