<?php
session_start();
if (!isset($_SESSION['verified_user_id'])) {
    $_SESSION['status'] = "You are not logged in";
    header('Location:login.php');
    exit();
}
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-danger"> Products
                        <a class=" float-right btn btn-primary" href="add-product.php">ADD NEW PRODUCT</a>
                    </h4>
                </div>
                <div class="table-responsive">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('dbcon.php');

                            $ref_table = '/Products/';
                            $fetchdata = $database->getReference($ref_table)->getValue();

                            if ($fetchdata > 0) {
                                $i = 0;
                                foreach ($fetchdata as $key => $row) {
                            ?>
                                    <tr>
                                        <td><?= $row['name']; ?></td>
                                        <td><?= $row['price']; ?></td>
                                        <td><?= $row['category']; ?></td>
                                        <td><?= $row['description']; ?></td>
                                        <td><?= $row['status']; ?></td>
                                        <td><img src="<?= $row['image']; ?>" style="width: 150px;" /></td>
                                        <td>
                                            <a href="edit-product.php?id=<?= $key; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        </td>
                                        <td>
                                            <form action="code.php" method="POST">
                                                <button type="submit" name="delete_btn" value="<?= $key; ?>" class="btn btn-danger btn-sm">Delete</button>
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
include('includes/scripts.php');
include('includes/footer.php');
?>