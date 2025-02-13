<?php
include('includes/checklogin.php');
check_login();

$serviceId = intval($_GET['sid']);  // Get service id from the URL

$error = $msg = ""; // Initialize error and message variables

if (isset($_POST['submit'])) {
    // Fetching the form data
    $serviceName = $_POST['servicename'];
    $serviceDescription = $_POST['servicedescription'];
    $serviceCost = $_POST['servicecost'];
    $status = $_POST['status'];
    $serviceImage = $_FILES["serviceimage"]["name"];

    // SQL Query to update the service
    $sql = "UPDATE tblservice 
            SET ServiceName = :servicename, 
                ServiceDescription = :servicedescription, 
                ServiceCost = :servicecost, 
                Status = :status 
            WHERE ServiceId = :sid";
    
    $query = $dbh->prepare($sql);
    
    // Bind parameters
    $query->bindParam(':servicename', $serviceName, PDO::PARAM_STR);
    $query->bindParam(':servicedescription', $serviceDescription, PDO::PARAM_STR);
    $query->bindParam(':servicecost', $serviceCost, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
    $query->bindParam(':sid', $serviceId, PDO::PARAM_INT);
    
    // Execute the query
    if ($query->execute()) {
        // Handle image upload if a new image is provided
        if ($serviceImage) {
            $target_dir = "serviceimages/";
            $target_file = $target_dir . basename($serviceImage);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            
            // Check if file is an image
            $check = getimagesize($_FILES["serviceimage"]["tmp_name"]);
            if ($check === false) {
                $msg = "File is not an image.";
                $uploadOk = 0;
            }
            
            // Check file size (5MB max)
            if ($_FILES["serviceimage"]["size"] > 5000000) {
                $msg = "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            
            // Allow certain file formats
            if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $msg = "Sorry, your file was not uploaded.";
            } else {
                // Try to upload file
                if (move_uploaded_file($_FILES["serviceimage"]["tmp_name"], $target_file)) {
                    // SQL query to update the service image
                    $sql = "UPDATE tblservice SET ServiceImage = :serviceimage WHERE ServiceId = :sid";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':serviceimage', $serviceImage, PDO::PARAM_STR);
                    $query->bindParam(':sid', $serviceId, PDO::PARAM_INT);
                    if ($query->execute()) {
                        $msg = "The file ". htmlspecialchars(basename($_FILES["serviceimage"]["name"])). " has been uploaded.";
                    } else {
                        $msg = "Failed to update service image.";
                    }
                } else {
                    $msg = "Sorry, there was an error uploading your file.";
                }
            }
        }

        // Success message
        if (empty($msg)) {
            $msg = "Service Updated Successfully";
        }
    } else {
        $error = "Failed to update service.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="img/logo/logo.png" rel="icon">
  <title>Admin - Update Service</title>
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
            <h1 class="h3 mb-0 text-gray-800">Services</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item">Forms</li>
              <li class="breadcrumb-item active" aria-current="page">Update Service</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Update Service</h6>
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
                  $sql = "SELECT * FROM tblservice WHERE ServiceId=:sid";
                  $query = $dbh->prepare($sql);
                  $query->bindParam(':sid', $serviceId, PDO::PARAM_INT);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);

                  if ($query->rowCount() > 0) {
                    foreach ($results as $result) { 
                      ?>
                      <form class="form-horizontal" name="service" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="servicename" class="col-sm-2 control-label">Service Name</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="servicename" id="servicename" placeholder="Service Name" value="<?php echo htmlentities($result->ServiceName); ?>" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="servicedescription" class="col-sm-2 control-label">Service Description</label>
                          <div class="col-sm-8">
                            <textarea class="form-control" rows="5" cols="50" name="servicedescription" id="servicedescription" placeholder="Service Description" required><?php echo htmlentities($result->ServiceDescription); ?></textarea> 
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="servicecost" class="col-sm-2 control-label">Service Cost</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="servicecost" id="servicecost" placeholder="Service Cost" value="<?php echo htmlentities($result->ServiceCost); ?>" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="status" class="col-sm-2 control-label">Status</label>
                          <div class="col-sm-8">
                            <select class="form-control" name="status" id="status" required>
                              <option value="1" <?php if($result->Status == 1) echo 'selected'; ?>>Active</option>
                              <option value="0" <?php if($result->Status == 0) echo 'selected'; ?>>Inactive</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="serviceimage" class="col-sm-2 control-label">Service Image</label>
                          <div class="col-sm-8">
                            <input type="file" class="form-control-file" name="serviceimage" id="serviceimage">
                            <?php if ($result->ServiceImage) { ?>
                              <img src="serviceimages/<?php echo htmlentities($result->ServiceImage); ?>" width="100" height="100" alt="Service Image">
                            <?php } ?>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-8 offset-sm-2">
                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                          </div>
                        </div>
                      </form>
                    <?php } 
                  } ?>
                </div>
              </div>
              <!-- Form Basic -->
            </div>
          </div>

        </div>
        <!-- Container Fluid-->
      </div>
      <!-- Footer -->
      <?php include('includes/footer.php');?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/ruang-admin.min.js"></script>
</body>
</html>
