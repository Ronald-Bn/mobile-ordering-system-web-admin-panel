<?php
session_start();
include('includes/header.php');
if (isset($_SESSION['verified_user_id'])) {
    $_SESSION['status'] = "You are already logged in";
    header('Location:index.php');
    exit();
}
?>

<div class="container">
    <div class="center-div col-md-4">
        <?php
        if (isset($_SESSION['status'])) {
            function_alert($_SESSION['status']);
        }
        ?>

        <div class="card">
            <div class="card-header">
                <h2 style="text-align: center;">
                    Login
                </h2>
            </div>
            <div class="card-body">

                <form action="logincode.php" method="POST">

                    <div class="form-group mb-3">
                        <label for="">Email</label>
                        <input type="text" name="email" class=form-control>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Password</label>
                        <input type="password" name="password" class=form-control>
                    </div>

                    <div class="form-group mb-3">
                        <button type="submit" name="login_btn" class="btn btn-primary">Login</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
</div>

<?php
include('includes/scripts.php');
?>