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
    <?php
    if (isset($_SESSION['orders'])) {
        function_alert($_SESSION['orders']);
        unset($_SESSION['orders']);
    }
    ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-danger">To Pay Orders</h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th> Order ID </th>
                            <th> Name </th>
                            <th> Price </th>
                            <th> Phone no. </th>
                            <th> Address </th>
                            <th> Time </th>
                            <th> Approve Time </th>
                            <th> Status </th>
                            <th> Cart </th>
                            <th colspan="2" style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('dbcon.php');


                        $ref_table = '/Orders/';

                        $fetchdata = $database->getReference($ref_table)->orderByChild('status')->equalTo('approved')->getSnapshot()->getValue();

                        if ($fetchdata > 0) {
                            $i = 0;
                            foreach ($fetchdata as $key => $row) {


                        ?>
                                <tr>
                                    <td><?= $row['cartId'] ?></td>
                                    <td><?= $row['name']; ?></td>
                                    <td><?= $row['totalpayment']; ?></td>
                                    <td><?= $row['phone']; ?></td>
                                    <td><?= $row['address']; ?></br><?= $row['zipcode']; ?></td>
                                    <td><?= $row['date']; ?></td>
                                    <td><?= $row['confirmdate']; ?></td>
                                    <td><?= $row['status']; ?></td>
                                    <td>
                                        <button data-id="<?= $row['userid']; ?>/<?= $row['cartId']; ?>" class="btn btn-info view">VIEW</button>
                                    </td>
                                    <td>
                                        <button data-id="<?= $key; ?>|<?= $row['userid']; ?>|<?= $row['cartId']; ?>" class="btn btn-danger remarks">CANCEL</button>
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
include('includes/footer.php');
?>