<?php
include('includes/checklogin.php');
check_login();

if (isset($_POST['submit'])) {
    // Retrieve form data
    $sname = $_POST['servicename'];
    $sdescription = $_POST['servicedescription'];
    $scost = $_POST['servicecost'];
    $status = 1; // Assuming active status by default

    // Handle file upload
    if (isset($_FILES['serviceimage']) && $_FILES['serviceimage']['error'] == 0) {
        $image = $_FILES['serviceimage'];
        $imageName = time() . '-' . basename($image['name']);
        $targetPath = 'uploads/' . $imageName;

        if (move_uploaded_file($image['tmp_name'], $targetPath)) {
            $imagePath = $imageName;
        } else {
            $error = "Image upload failed.";
        }
    } else {
        $imagePath = null;
    }

    // Insert service details into the database
    $sql = "INSERT INTO tblservice(ServiceName, ServiceDescription, ServiceCost, Status, ServiceImage) 
            VALUES(:sname, :sdescription, :scost, :status, :image)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':sname', $sname, PDO::PARAM_STR);
    $query->bindParam(':sdescription', $sdescription, PDO::PARAM_STR);
    $query->bindParam(':scost', $scost, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
    $query->bindParam(':image', $imagePath, PDO::PARAM_STR);
    $query->execute();

    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        $msg = "Service Created Successfully";
    } else {
        $error = "Something went wrong. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin - Create Service</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include('includes/sidebar.php'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('includes/header.php'); ?>
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Create Service</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Service</li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Create Service</h6>
                                    <?php if ($error) { ?>
                                        <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
                                    <?php } else if ($msg) { ?>
                                        <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="card-body">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Service Name</label>
                                                <input type="text" class="form-control" name="servicename" placeholder="Service Name" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Service Cost</label>
                                                <input type="text" class="form-control" name="servicecost" placeholder="Cost in Rs" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label>Service Description</label>
                                                <textarea class="form-control" name="servicedescription" rows="3" placeholder="Description" required></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Service Image</label>
                                            <input type="file" name="serviceimage" class="form-control-file">
                                        </div>

                                        <button type="submit" name="submit" class="btn btn-primary">Create</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
</body>
</html>
