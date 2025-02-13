<?php
include('includes/checklogin.php');
check_login();

if (isset($_POST['submit'])) {
    // Retrieve form data
    $pname = $_POST['packagename'];
    $ptype = $_POST['packagetype'];
    $plocation = $_POST['packagelocation'];
    $pprice = $_POST['packageprice'];
    $pfeatures = $_POST['packagefeatures'];
    $pdetails = $_POST['packagedetails'];
    
    // Handle file upload
    if (isset($_FILES['packageimage']) && $_FILES['packageimage']['error'] == 0) {
        $image = $_FILES['packageimage'];
        $imageName = time() . '-' . basename($image['name']);
        $targetPath = 'packageimages/' . $imageName;

        if (move_uploaded_file($image['tmp_name'], $targetPath)) {
            $imagePath = $imageName;
        } else {
            $error = "Image upload failed.";
        }
    } else {
        $imagePath = null;
    }

    // Insert package details into the database
    $sql = "INSERT INTO tblpackage(PackageName, PackageType, PackageLocation, PackagePrice, PackageFeatures, PackageDetails, PackageImage) 
            VALUES(:pname, :ptype, :plocation, :pprice, :pfeatures, :pdetails, :image)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':pname', $pname, PDO::PARAM_STR);
    $query->bindParam(':ptype', $ptype, PDO::PARAM_STR);
    $query->bindParam(':plocation', $plocation, PDO::PARAM_STR);
    $query->bindParam(':pprice', $pprice, PDO::PARAM_STR);
    $query->bindParam(':pfeatures', $pfeatures, PDO::PARAM_STR);
    $query->bindParam(':pdetails', $pdetails, PDO::PARAM_STR);
    $query->bindParam(':image', $imagePath, PDO::PARAM_STR);
    $query->execute();

    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        $msg = "Package Created Successfully";
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
    <title>Admin - Create Package</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Create Package</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Package</li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Create Package</h6>
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
                                                <label>Package Name</label>
                                                <input type="text" class="form-control" name="packagename" placeholder="Package Name" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Package Type</label>
                                                <input type="text" class="form-control" name="packagetype" placeholder="Package Type" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Package Location</label>
                                                <input type="text" class="form-control" name="packagelocation" placeholder="Location" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Package Price</label>
                                                <input type="text" class="form-control" name="packageprice" placeholder="Price in Rs" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Package Features</label>
                                                <input type="text" class="form-control" name="packagefeatures" placeholder="Features" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Package Details</label>
                                                <textarea class="form-control" name="packagedetails" rows="3" placeholder="Details" required></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Package Image</label>
                                            <input type="file" name="packageimage" class="form-control-file" required>
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