$(document).ready(function () {
  $(".receipt").click(function () {
    var receipt = $(this).data("id");
    $.ajax({
      url: "ajaxreceipt.php",
      type: "post",
      data: { receipt: receipt },
      success: function (response) {
        $("#receiptModel").html(response);
        $("#receiptModal").modal("show");
      },
    });
  });
});
