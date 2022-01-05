<?php

$userid = $_POST['key'];
$comment = "";
?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Remarks</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <form action="code.php" method="POST">
            <div class="modal-body">
                <input type="text" name="key" value="<?php echo $userid; ?>" hidden>
                <div class="input-group mb-3">
                    <select class="custom-select" name="rej_reason">
                        <option disabled selected>Reason</option>
                        <option value="Out of Service Area">Out of Service Area</option>
                        <option value="Missing or Complicated Info">Missing or Complicated Info</option>
                        <option value="Not Paying on Time">Payment was not made in time </option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div>
                    <label for="exampleFormControlTextarea1">Others</label>
                    <textarea class="form-control" name="comment" rows="3"><?php echo htmlspecialchars($comment); ?></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="reject_btn" value="submit" class=" btn btn-danger">REJECT</button>
            </div>
        </form>
    </div>
</div>
</div>