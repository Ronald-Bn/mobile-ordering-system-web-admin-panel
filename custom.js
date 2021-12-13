$(document).ready(function () {
  $(".view").click(function () {
    var userid = $(this).data("id");
    $.ajax({
      url: "ajaxfile.php",
      type: "post",
      data: { userid: userid },
      success: function (response) {
        $("#viewModel").html(response);
        $("#empModal").modal("show");
      },
    });
  });
});
