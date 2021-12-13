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
                        Add new product
                        <a href="products.php" class="btn btn-danger float-right"> BACK </a>
                    </h2>
                </div>
                <div class="card-body">

                    <form action="code.php" method="POST">

                        <div class="form-group mb-3">
                            <label for="">Name</label>
                            <input type="text" name="name" class=form-control>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Description</label>
                            <input type="text" name="description" class=form-control>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Price</label>
                            <input type="number" name="price" class=form-control>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Category</label>
                            <input type="text" name="category" class=form-control>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Status</label>
                            <input type="text" name="status" class=form-control>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Image</label>
                            <input type="text" name="image" class=form-control>
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" name="save_product" class="btn btn-primary">Save Product</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>