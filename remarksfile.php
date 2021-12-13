<?php
include('dbcon.php');
$comment = "";
if (isset($_POST['userid'])) {
    $key = $_POST['userid'];
}
?>

<div class="modal fade" id="remarksModal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Remarks</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body" id="remarksBody">
                <div class="input-group mb-3">

                    <select class="custom-select" id="inputGroupSelect01">
                        <option selected>Reason</option>
                        <option value="Out of Service Area">Out of Service Area</option>
                        <option value="Missing or Complicated Info">Missing or Complicated Info</option>
                        <option value="Not Paying on Time">Payment was not made in time </option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div>
                    <form action="code.php" method="POST">
                        <label for="exampleFormControlTextarea1">Others</label>
                        <textarea class="form-control" name="comment" rows="3"><?php echo htmlspecialchars($comment); ?></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="reject_btn" value="<?= $key; ?>" class=" btn btn-danger">REJECT</button>
                </form>
            </div>
        </div>
    </div>
</div>