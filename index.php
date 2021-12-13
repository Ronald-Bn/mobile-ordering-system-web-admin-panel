<?php
include('authentication.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  </div>

  <div class="d-sm-flex align-items-center justify-content-between mb-2 ml-2">
    <h5 class="h5 mb-0 text-gray-800">Orders</h5>
  </div>
  <!-- Content Row -->
  <div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="
                  text-xs
                  font-weight-bold
                  text-primary text-uppercase
                  mb-1
                ">
                Pending Orders
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <?php
                include('dbcon.php');
                $ref_table = '/Orders/';
                $fetchdata = $database->getReference($ref_table)->orderByChild('status')->equalTo('pending')->getSnapshot()->numChildren();
                echo $fetchdata; ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="
                  text-xs
                  font-weight-bold
                  text-success text-uppercase
                  mb-1
                ">
                To Pay Orders
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <?php
                include('dbcon.php');
                $ref_table = '/Orders/';
                $fetchdata = $database->getReference($ref_table)->orderByChild('status')->equalTo('approved')->getSnapshot()->numChildren();
                echo $fetchdata; ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                To Ship Orders
              </div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                    <?php
                    include('dbcon.php');
                    $ref_table = '/Orders/';
                    $fetchdata = $database->getReference($ref_table)->orderByChild('status')->equalTo('shipping')->getSnapshot()->numChildren();
                    echo $fetchdata; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="
                  text-xs
                  font-weight-bold
                  text-warning text-uppercase
                  mb-1
                ">
                To Receive Orders
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <?php
                include('dbcon.php');
                $ref_table = '/Orders/';
                $fetchdata = $database->getReference($ref_table)->orderByChild('status')->equalTo('receiving')->getSnapshot()->numChildren();
                echo $fetchdata; ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Second Column -->
  <div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="
                  text-xs
                  font-weight-bold
                  text-primary text-uppercase
                  mb-1
                ">
                Completed Orders
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <?php
                include('dbcon.php');
                $ref_table = '/Orders/';
                $fetchdata = $database->getReference($ref_table)->orderByChild('status')->equalTo('completed')->getSnapshot()->numChildren();
                echo $fetchdata; ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="
                  text-xs
                  font-weight-bold
                  text-success text-uppercase
                  mb-1
                ">
                Cancelled Orders
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <?php
                include('dbcon.php');
                $ref_table = '/Orders/';
                $fetchdata = $database->getReference($ref_table)->orderByChild('status')->equalTo('rejected')->getSnapshot()->numChildren();
                echo $fetchdata; ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="d-sm-flex align-items-center justify-content-between mb-2 ml-2">
    <h5 class="h5 mb-0 text-gray-800">Products</h5>
  </div>
  <!-- Third Column -->
  <div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="
                  text-xs
                  font-weight-bold
                  text-primary text-uppercase
                  mb-1
                ">
                Available Products
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <?php
                include('dbcon.php');
                $ref_table = '/Products/';
                $fetchdata = $database->getReference($ref_table)->orderByChild('status')->equalTo('Available')->getSnapshot()->numChildren();
                echo $fetchdata; ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="
                  text-xs
                  font-weight-bold
                  text-success text-uppercase
                  mb-1
                ">
                Unavailable Products
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <?php
                include('dbcon.php');
                $ref_table = '/Products/';
                $fetchdata = $database->getReference($ref_table)->orderByChild('status')->equalTo('Unavailable')->getSnapshot()->numChildren();
                echo $fetchdata; ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
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
</div>