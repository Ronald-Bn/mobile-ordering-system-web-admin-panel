<?php
session_start();
if (!isset($_SESSION['verified_user_id'])) {
    header('Location:login.php');
    exit();
}
include('includes/header.php');
include('includes/navbar.php');
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-danger">Request Return & Refund Orders</h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th> Order ID </th>
                            <th> Name </th>
                            <th> Reason </th>
                            <th> Comments </th>
                            <th> Status </th>
                            <th> All Info. </th>
                            <th colspan="2" style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('dbcon.php');

                        $ref_table = '/Orders/';

                        $fetchdata = $database->getReference($ref_table)->orderByChild('status')->equalTo("return")->getSnapshot()->getValue();

                        if ($fetchdata > 0) {
                            $i = 0;
                            $status = " ";
                            foreach ($fetchdata as $key => $row) {
                                if ($row['status'] == "return") {
                                    $status = "Request";
                                }

                        ?>
                                <tr>
                                    <td style="display:none;"><?= $row['key']; ?></td>
                                    <td><?= $row['cartId']; ?></td>
                                    <td><?= $row['name']; ?></td>
                                    <td><?= $row['reason']; ?></td>
                                    <td><?= $row['comment']; ?></td>
                                    <td><?= $status ?></td>
                                    <td>
                                        <form autocomplete="off" action="info-report.php" method="POST" target="_blank">
                                            <input style="display:none;" type="text" name="cartId" value="<?= $row['userid']; ?>/<?= $row['cartId']; ?>" />
                                            <input style="display:none;" type="text" name="ordersId" value="<?= $row['key']; ?>">
                                            <input type="submit" class="btn btn-info" name="Generate Report" value="VIEW" />
                                        </form>
                                    </td>
                                    <td>
                                        <form action="code.php" method="POST">
                                            <button type="submit" name="approve_btn" value="<?= $key; ?>|<?= $row['userid']; ?>|<?= $row['cartId']; ?>" class="btn btn-success"> APPROVE</button>
                                        </form>
                                    </td>
                                    <td>
                                        <button data-id="<?= $key ?>" class="btn btn-danger remarks">REJECT</button>
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