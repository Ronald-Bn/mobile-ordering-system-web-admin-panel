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
            <h4 class="m-0 font-weight-bold text-danger">To Receive Orders</h4>
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
                            <th> Time </th>
                            <th> Ship Time </th>
                            <th> Status </th>
                            <th> Cart </th>
                            <th colspan="2" style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('dbcon.php');

                        $ref_table = '/Orders/';

                        $fetchdata = $database->getReference($ref_table)->orderByChild('status')->equalTo("receiving")->getSnapshot()->getValue();

                        if ($fetchdata > 0) {
                            $i = 0;
                            foreach ($fetchdata as $key => $row) {
                        ?>
                                <tr>
                                    <td> <?php echo $row['cartId']; ?> </td>
                                    <td><?= $row['name']; ?></td>
                                    <td><?= $row['totalpayment']; ?></td>
                                    <td><?= $row['payment']; ?></td>
                                    <td><?= $row['address']; ?></br><?= $row['zipcode']; ?></td>
                                    <td><?= $row['date']; ?></td>
                                    <td><?= $row['shipdate']; ?></td>
                                    <td><?= $row['status']; ?></td>
                                    <td>
                                        <button data-id="<?= $row['userid']; ?>/<?= $row['cartId']; ?>" class="btn btn-info view">VIEW</button>
                                    </td>
                                    <td id="received">
                                        <form action="code.php" method="POST">
                                            <?php
                                            $submit = 'submit';
                                            $receive = 'receiving_btn';
                                            $usersId = $key . '|' . $row['userid'] . '|' . $row['cartId'];
                                            if ($row['notify'] == "0") {
                                                echo '<button type="' . $submit . '" name="' . $receive . '" value="' . $usersId . '" class="btn btn-success"> DELIVERED</button>';
                                            } else {
                                                echo 'WAITING';
                                            }
                                            ?>
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
</div>

<!-- Content Row -->
<?php
include('modal.php');
include('includes/scripts.php');
include('includes/footer.php');
?>