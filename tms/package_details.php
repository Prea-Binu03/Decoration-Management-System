<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include('includes/config.php');

if (isset($_POST['submit2'])) {
    // Sanitize input
    $pid = intval($_GET['pkgid']);
    $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null; // Get User ID from session
    $fromdate = htmlspecialchars($_POST['fromdate']);
    $todate = htmlspecialchars($_POST['todate']);
    $paymentoption = htmlspecialchars($_POST['paymentoption']);
    $paymentamount = htmlspecialchars($_POST['paymentamount']);
    $comment = htmlspecialchars($_POST['comment']);
    $status = 'Pending'; // Set status to Pending
    $regdate = date('Y-m-d H:i:s');
    $paymentstatus = 'Pending';

    try {
        // Prepare SQL statement
        $sql = "INSERT INTO tblbooking (id, PackageId, FromDate, ToDate, Comment, RegDate, Status, PackagePaymentMode, PaymentStatus, PaymentAmount) 
                VALUES (:userid, :pid, :fromdate, :todate, :comment, :regdate, :status, :paymentoption, :paymentstatus, :paymentamount)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':userid', $userId, PDO::PARAM_INT); // Bind User ID
        $query->bindParam(':pid', $pid, PDO::PARAM_INT);
        $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
        $query->bindParam(':todate', $todate, PDO::PARAM_STR);
        $query->bindParam(':paymentoption', $paymentoption, PDO::PARAM_STR);
        $query->bindParam(':paymentamount', $paymentamount, PDO::PARAM_STR);
        $query->bindParam(':comment', $comment, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':regdate', $regdate, PDO::PARAM_STR);
        $query->bindParam(':paymentstatus', $paymentstatus, PDO::PARAM_STR);
        $query->execute();

        // Check if insert was successful
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            echo '<script>alert("Booked Successfully. Thank you")</script>';
        } else {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
    } catch (PDOException $e) {
        echo '<script>alert("Database error: ' . $e->getMessage() . '")</script>';
    }
}
?>

<!doctype html>
<html lang="en-gb" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Package Details</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
</head>
<body>
    <header class="header">
        <?php include('includes/header.php'); ?>
    </header>

    <section id="packages" class="secPad">
        <div class="container">
            <div class="heading text-center">
                <h2>Package Details</h2>
            </div>
            <div class="selectroom">
                <div class="container">
                    <?php
                    $pid = intval($_GET['pkgid']);
                    $sql = "SELECT * FROM tbltourpackages WHERE PackageId=:pid";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':pid', $pid, PDO::PARAM_INT);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) { ?>
                            <div class="selectroom_top">
                                <div class="col-md-4 selectroom_left">
                                    <img src="admin/packgeimages/Packages/packages/<?php echo htmlentities($result->PackageImage); ?>" class="img-responsive" alt="">
                                </div>
                                <div class="col-md-8 selectroom_right">
                                    <h2><?php echo htmlentities($result->PackageName); ?></h2>
                                    <p><b>Package Type :</b> <?php echo htmlentities($result->PackageType); ?></p>
                                    <p><b>Package Location :</b> <?php echo htmlentities($result->PackageLocation); ?></p>
                                    <p><b>Features :</b> <?php echo htmlentities($result->PackageFeatures); ?></p>
                                    <p><b>Package Price :</b> <?php echo htmlentities($result->PackagePrice); ?></p>
                                    <div class="grand">
                                        <p>Grand Total</p>
                                        <h3><?php echo htmlentities($result->PackagePrice); ?></h3>
                                    </div>
                                </div>
                                <h3>Package Details</h3>
                                <p><?php echo htmlentities($result->PackageDetails); ?></p>
                                <div class="clearfix"></div>
                            </div>

                            <!-- Booking Form -->
                            <form name="book" method="post">
                                <div class="selectroom_top">
                                    <div class="selectroom-info">
                                        <div class="ban-bottom">
                                            <div class="col-md-6">
                                                <label class="inputLabel">From Date</label>
                                                <input class="form-control" type="date" name="fromdate" required="">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="inputLabel">To Date</label>
                                                <input class="form-control" type="date" name="todate" required="">
                                            </div>
                                        </div>
                                        <div class="ban-bottom">
                                            <div class="col-md-6">
                                                <label class="inputLabel">Payment Option</label>
                                                <select class="form-control" name="paymentoption" required="">
                                                    <option value="Credit Card">Credit Card</option>
                                                    <option value="Google Pay">Google Pay</option>
                                                    <option value="Paytm">Paytm</option>
                                                    <option value="Bank Transfer">Bank Transfer</option>
                                                    <option value="Cash">Cash</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="inputLabel">Payment Amount</label>
                                                <input class="form-control" type="text" name="paymentamount" value="<?php echo htmlentities($result->PackagePrice); ?>" readonly="">
                                            </div>
                                        </div>
                                        <ul>
                                            <li class="spe">
                                                <label class="inputLabel">Comment</label>
                                                <textarea class="form-control" rows="4" name="comment" required=""></textarea>
                                            </li>
                                            <?php if (isset($_SESSION['login']) && $_SESSION['login']) { ?>
                                                <li class="spe" align="center">
                                                    <button type="submit" name="submit2" class="btn-primary btn">Book</button>
                                                </li>
                                            <?php } else { ?>
                                                <li class="sigi" align="center">
                                                    <a href="#" data-toggle="modal" data-target="#myModal4" class="btn-primary btn">Book</a>
                                                </li>
                                            <?php } ?>
                                            <div class="clearfix"></div>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </section>

    <a href="#top" class="topHome"><i class="fa fa-chevron-up fa-2x"></i></a>

    <?php include('includes/footer.php'); ?>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>
