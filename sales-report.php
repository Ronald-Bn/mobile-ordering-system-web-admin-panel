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
                    <option value="approved">To Pay Orders</option>
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

<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-danger"></h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th> Order ID </th>
                            <th> Name </th>
                            <th> Price </th>
                            <th> Payment </th>
                            <th> Address </th>
                            <th> Status </th>
                            <th> All Info. </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('dbcon.php');

                        $ref_table = '/Orders/';

                        $fetchdata = $database->getReference($ref_table)->orderByChild('status')->equalTo("completed")->getSnapshot()->getValue();

                        if ($fetchdata > 0) {
                            $i = 0;
                            foreach ($fetchdata as $key => $row) {
                        ?>
                                <tr>
                                    <td style="display:none;"><?= $row['key']; ?></td>
                                    <td><?= $row['cartId']; ?></td>
                                    <td><?= $row['name']; ?></td>
                                    <td><?= $row['totalpayment']; ?></td>
                                    <td><?= $row['payment']; ?></td>
                                    <td><?= $row['address']; ?></br><?= $row['zipcode']; ?></td>
                                    <td><?= $row['status']; ?></td>
                                    <td>
                                        <form autocomplete="off" action="info-report.php" method="POST" target="_blank">
                                            <input style="display:none;" type="text" name="cartId" value="<?= $row['userid']; ?>/<?= $row['cartId']; ?>" />
                                            <input style="display:none;" type="text" name="ordersId" value="<?= $row['key']; ?>">
                                            <input type="submit" class="btn btn-info" name="Generate Report" value="VIEW" />
                                        </form>
                                    </td>
                                </tr>

                            <?php
                            }
                        } else {
                            ?>

                            <tr>
                                <td colspan="7">No Record Found</td>
                            </tr>

                        <?php
                        }
                        ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>



<!-- Content Row -->
<?php
include('modal.php');
include('includes/scripts.php');
include('includes/added_scripts.php');
include('includes/footer.php');
?>