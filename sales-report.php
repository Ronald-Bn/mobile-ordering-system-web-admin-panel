<?php
session_start();
if (!isset($_SESSION['verified_user_id'])) {
    header('Location:login.php');
    exit();
}
include('includes/header.php');
include('includes/navbar.php');
?>


<div class="d-flex justify-content-center">


    <form autocomplete="off" action="generate-report.php" method="POST" target="_blank">
        <div class="d-flex justify-content-center flex-column ">
            <div class="d-flex justify-content-center flex-column mb-2">
                <select name="orders" id="orders">
                    <option value="pending">Pending Orders</option>
                    <option value="paying">To Pay Orders</option>
                    <option value="shipping">To Ship Orders</option>
                    <option value="receiving">To Receive Orders</option>
                    <option value="completed">Completed Orders</option>
                    <option value="rejected">Cancelled Orders</option>
                </select>
            </div>
            <div class="d-flex align-items-start justify-content-center ">

                <p class="mr-4">From: <input type="text" name="datepicker_one" id="datepicker" placeholder="MM/DD/YYYY" autocomplete="off"></p>
                <p class="mr-4">To: <input type="text" name="datepicker_two" id="datepicker_two" placeholder="MM/DD/YYYY" autocomplete="off"></p>
                <input type="submit" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" name="Generate Report" value="Generate Report" />
            </div>
        </div>
    </form>
</div>




<!-- Content Row -->
<?php
include('modal.php');
include('includes/scripts.php');
include('includes/added_scripts.php');
include('includes/footer.php');
?>