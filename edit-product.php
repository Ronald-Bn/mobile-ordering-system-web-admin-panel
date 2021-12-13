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

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2>
                        Edit product
                        <a href="products.php" class="btn btn-danger float-right"> BACK </a>
                    </h2>
                </div>
                <div class="card-body">

                    <?php
                    include('dbcon.php');


                    if (isset($_GET['id'])) {

                        $key_child = $_GET['id'];
                        $ref_table = '/Products/' . $key_child;
                        $getdata = $database->getReference($ref_table)->getValue();

                        if ($getdata > 0) {
                    ?>
                            <form action="code.php" method="POST">

                                <input type="hidden" name="key" value="<?= $key_child; ?>">
                                <div class="form-group mb-3">
                                    <label for="">Name</label>
                                    <input type="text" name="name" value="<?= $getdata['name']; ?>" class=form-control>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Description</label>
                                    <input type="text" name="description" value="<?= $getdata['description']; ?>" class=form-control>
                                </div>
                                <div class=" form-group mb-3">
                                    <label for="">Price</label>
                                    <input type="number" name="price" value="<?= $getdata['price']; ?>" class=form-control>
                                </div>
                                <div class=" form-group mb-3">
                                    <label for="">Category</label>
                                    <input type="text" name="category" value="<?= $getdata['category']; ?>" class=form-control>
                                </div>
                                <div class=" form-group mb-3">
                                    <label for="">Status</label>
                                    <input type="text" name="status" value="<?= $getdata['status']; ?>" class=form-control>
                                </div>
                                <div class=" form-group mb-3">
                                    <label for="">Image</label>
                                    <input type="text" name="image" value="<?= $getdata['image']; ?>" class=form-control>
                                </div>
                                <div class=" form-group mb-3">
                                    <button type="submit" name="update_product" class="btn btn-primary">Edit Product</button>
                                </div>

                            </form>

                    <?php

                        } else {
                            $_SESSION['status'] = 'Invalid Id';
                            header('Location: index.php');
                            exit();
                        }
                    } else {
                        $_SESSION['status'] = "No found";
                        header('Location: index.php');
                        exit();
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>