<?php
include('includes/checklogin.php');
check_login();
$pid = intval($_GET['pid']);  // Get package id from the URL

if (isset($_POST['submit'])) {
    // Fetching the form data
    $pname = $_POST['packagename'];
    $ptype = $_POST['packagetype']; 
    $plocation = $_POST['packagelocation'];
    $pprice = $_POST['packageprice']; 
    $pfeatures = $_POST['packagefeatures'];  // Correct field name
    $pdetails = $_POST['packagedetails']; 
    $pimage = $_FILES["packageimage"]["name"];
    
    // SQL Query to update the package
    $sql = "UPDATE TblTourPackages 
            SET PackageName=:pname, PackageType=:ptype, PackageLocation=:plocation, PackagePrice=:pprice, 
            PackageFeatures=:pfeatures, PackageDetails=:pdetails 
            WHERE PackageId=:pid";
    
    $query = $dbh->prepare($sql);
    
    // Bind parameters
    $query->bindParam(':pname', $pname, PDO::PARAM_STR);
    $query->bindParam(':ptype', $ptype, PDO::PARAM_STR);
    $query->bindParam(':plocation', $plocation, PDO::PARAM_STR);
    $query->bindParam(':pprice', $pprice, PDO::PARAM_STR);
    $query->bindParam(':pfeatures', $pfeatures, PDO::PARAM_STR);
    $query->bindParam(':pdetails', $pdetails, PDO::PARAM_STR);
    $query->bindParam(':pid', $pid, PDO::PARAM_STR);
    
    // Execute the query
    $query->execute();

    // Success message
    $msg = "Package Updated Successfully";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="img/logo/logo.png" rel="icon">
  <title>Admin - Update Packages</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <style>
    .errorWrap {
      padding: 10px;
      margin: 0 0 20px 0;
      background: #fff;
      border-left: 4px solid #dd3d36;
      box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    }
    .succWrap {
      padding: 10px;
      margin: 0 0 20px 0;
      background: #fff;
      border-left: 4px solid #5cb85c;
      box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    }
  </style>
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
            <h1 class="h3 mb-0 text-gray-800">Packages</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item">Forms</li>
              <li class="breadcrumb-item active" aria-current="page">Update Package</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Update Package</h6>
                  <?php 
                  if($error) { ?>
                    <div class="errorWrap">
                      <strong>ERROR</strong>: <?php echo htmlentities($error); ?> 
                    </div>
                  <?php } 
                  if($msg) { ?>
                    <div class="succWrap">
                      <strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> 
                    </div>
                  <?php } ?>
                </div>
                <div class="card-body">

                  <?php 
                  $sql = "SELECT * FROM TblTourPackages WHERE PackageId=:pid";
                  $query = $dbh->prepare($sql);
                  $query->bindParam(':pid', $pid, PDO::PARAM_STR);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);

                  if($query->rowCount() > 0) {
                    foreach($results as $result) { 
                      ?>
                      <form class="form-horizontal" name="package" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="packagename" class="col-sm-2 control-label">Package Name</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="packagename" id="packagename" placeholder="Create Package" value="<?php echo htmlentities($result->PackageName);?>" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="packagetype" class="col-sm-2 control-label">Package Type</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="packagetype" id="packagetype" placeholder="Package Type e.g. Family Package" value="<?php echo htmlentities($result->PackageType);?>" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="packagelocation" class="col-sm-2 control-label">Package Location</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="packagelocation" id="packagelocation" placeholder="Package Location" value="<?php echo htmlentities($result->PackageLocation);?>" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="packageprice" class="col-sm-2 control-label">Package Price in Rs</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="packageprice" id="packageprice" placeholder="Package Price in Rs" value="<?php echo htmlentities($result->PackagePrice);?>" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="packagefeatures" class="col-sm-2 control-label">Package Features</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="packagefeatures" id="packagefeatures" placeholder="Package Features e.g. Free Pickup" value="<?php echo htmlentities($result->PackageFeatures);?>" required>
                          </div>
                        </div>    
                        <div class="form-group">
                          <label for="packagedetails" class="col-sm-2 control-label">Package Details</label>
                          <div class="col-sm-8">
                            <textarea class="form-control" rows="5" cols="50" name="packagedetails" id="packagedetails" placeholder="Package Details" required><?php echo htmlentities($result->PackageDetails);?></textarea> 
                          </div>
                        </div>                              
                        <div class="form-group">
                          <label for="packageimage" class="col-sm-2 control-label">Package Image</label>
                          <div class="col-sm-8">
                            <img src="packageimages/<?php echo htmlentities($result->PackageImage);?>" width="200">&nbsp;&nbsp;&nbsp;<a href="change_image.php?imgid=<?php echo htmlentities($result->PackageId);?>">Change Image</a>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="lastupdate" class="col-sm-2 control-label">Last Updation Date</label>
                          <div class="col-sm-8">
                            <?php echo htmlentities($result->UpdationDate);?>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-8 col-sm-offset-2">
                            <button type="submit" name="submit" class="btn-primary btn">Update</button>
                          </div>
                        </div>
                      </form>
                      <?php 
                    }
                  } ?>
                </div>
              </div>
            </div>
          </div>
          <!-- Row -->

          <!-- Modal Logout -->
          <?php include('includes/modal.php');?>

        </div>
        <!-- Container Fluid -->
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
</body>
</html>
