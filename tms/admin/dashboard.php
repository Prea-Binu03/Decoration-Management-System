<?php
include('includes/checklogin.php');
check_login();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/logo.png" rel="icon">
  <title> Decoration Management System</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <link href="css/bootstrap.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include('includes/sidebar.php');?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php include('includes/header.php');?>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <div class="row mb-3">
            <!-- Total Booking Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Booking </div>
                      <?php
                      $sql1 = "SELECT BookingId FROM tblbooking";
                      $query1 = $dbh->prepare($sql1);
                      $query1->execute();
                      $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                      $cnt1 = $query1->rowCount();
                      ?>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlentities($cnt1);?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Packages Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Packages</div>
                      <?php
                      $sql3 = "SELECT PackageId FROM tbltourpackages";
                      $query3 = $dbh->prepare($sql3);
                      $query3->execute();
                      $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                      $cnt3 = $query3->rowCount();
                      ?>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlentities($cnt3);?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-shopping-cart fa-2x text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total User Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total User</div>
                      <?php
                      $sql = "SELECT id FROM tblusers";
                      $query = $dbh->prepare($sql);
                      $query->execute();
                      $results = $query->fetchAll(PDO::FETCH_OBJ);
                      $cnt = $query->rowCount();
                      ?>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo htmlentities($cnt);?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Admin's Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Admin's</div>
                      <?php
                      $sql = "SELECT id FROM tbladmin";
                      $query = $dbh->prepare($sql);
                      $query->execute();
                      $results = $query->fetchAll(PDO::FETCH_OBJ);
                      $cnt2 = $query->rowCount();
                      ?>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlentities($cnt2);?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-warning"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Services Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Services</div>
                      <?php
                      $sql4 = "SELECT ServiceId FROM tblservice";
                      $query4 = $dbh->prepare($sql4);
                      $query4->execute();
                      $results4 = $query4->fetchAll(PDO::FETCH_OBJ);
                      $cnt4 = $query4->rowCount();
                      ?>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlentities($cnt4);?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-concierge-bell fa-2x text-danger"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Booking Service Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Booking Services</div>
                      <?php
                      $sql5 = "SELECT BookingServiceId FROM tblbookingservices";
                      $query5 = $dbh->prepare($sql5);
                      $query5->execute();
                      $results5 = $query5->fetchAll(PDO::FETCH_OBJ);
                      $cnt5 = $query5->rowCount();
                      ?>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlentities($cnt5);?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-boxes fa-2x text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- Invoice Example -->
        <?php include('includes/modal.php');?>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
      <?php include('includes/footer.php');?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  
</body>

</html>
