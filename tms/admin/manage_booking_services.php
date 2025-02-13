<?php
include('includes/checklogin.php');
check_login();

// Handle booking cancellation
if (isset($_REQUEST['bkid'])) {
    $bid = intval($_GET['bkid']);
    $status = 2; // 2 for Cancelled
    $cancelby = 'a'; // 'a' for admin
    $sql = "UPDATE tblbookingservices SET status=:status, CancelledBy=:cancelby WHERE BookingId=:bid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
    $query->bindParam(':cancelby', $cancelby, PDO::PARAM_STR);
    $query->bindParam(':bid', $bid, PDO::PARAM_INT);
    if ($query->execute()) {
        echo '<script>alert("Booking Cancelled successfully")</script>';
    } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}

// Handle booking confirmation
if (isset($_REQUEST['bckid'])) {
    $bcid = intval($_GET['bckid']);
    $status = 1; // 1 for Confirmed
    $sql = "UPDATE tblbookingservices SET status=:status WHERE BookingId=:bcid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
    $query->bindParam(':bcid', $bcid, PDO::PARAM_INT);
    if ($query->execute()) {
        echo '<script>alert("Booking Confirmed successfully")</script>';
    } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}

// Handle payment updates
if (isset($_POST['update_payment'])) {
    $bookingServiceId = intval($_POST['booking_service_id']);
    $paymentOption = $_POST['payment_option'];
    $paymentStatus = $_POST['payment_status'];
    $paymentAmount = floatval($_POST['payment_amount']);

    $sql = "UPDATE tblbookingservices SET PaymentOption=:paymentOption, PaymentStatus=:paymentStatus, PaymentAmount=:paymentAmount WHERE BookingServiceId=:bookingServiceId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':paymentOption', $paymentOption, PDO::PARAM_STR);
    $query->bindParam(':paymentStatus', $paymentStatus, PDO::PARAM_STR);
    $query->bindParam(':paymentAmount', $paymentAmount, PDO::PARAM_STR);
    $query->bindParam(':bookingServiceId', $bookingServiceId, PDO::PARAM_INT);
    if ($query->execute()) {
        echo '<script>alert("Payment details updated successfully")</script>';
    } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags and CSS links -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Booking Services</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="css/ruang-admin.min.css">
</head>
<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include('includes/sidebar.php'); ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include('includes/header.php'); ?>
                <!-- Topbar -->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Manage Booking Services</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Booking Services</li>
                        </ol>
                    </div>

                    <!-- Row -->
                    <div class="row">
                        <!-- DataTable with Hover -->
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Manage Booking Services</h6>
                                    <?php if ($error) { ?>
                                        <div class="alert alert-danger" role="alert">
                                            <strong>ERROR</strong>: <?php echo htmlentities($error); ?>
                                        </div>
                                    <?php } elseif ($msg) { ?>
                                        <div class="alert alert-success" role="alert">
                                            <strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="table-responsive p-3">
                                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Booking Service Id</th>
                                                <th>Booking Id</th>
                                                <th>Service Id</th>
                                                <th>User Id</th> <!-- New User Id Column -->
                                                <th>Quantity</th>
                                                <th>Status</th>
                                                <th>Payment Option</th>
                                                <th>Payment Status</th>
                                                <th>Payment Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT BookingServiceId, BookingId, ServiceId,UserId, Quantity, Status, PaymentOption, PaymentStatus, PaymentAmount FROM tblbookingservices"; // Changed UserId to id
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) { ?>
                                                    <tr>
                                                        <td>#BS-<?php echo htmlentities($result->BookingServiceId); ?></td>
                                                        <td><?php echo htmlentities($result->BookingId); ?></td>
                                                        <td><?php echo htmlentities($result->ServiceId); ?></td>
                                                        <td><?php echo htmlentities($result->UserId); ?></td> <!-- Display User Id -->
                                                        <td><?php echo htmlentities($result->Quantity); ?></td>
                                                        <td>
                                                            <?php
                                                            switch ($result->Status) {
                                                                case 0: echo "Pending"; break;
                                                                case 1: echo "Confirmed"; break;
                                                                case 2: echo "Cancelled"; break;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo htmlentities($result->PaymentOption); ?></td>
                                                        <td><?php echo htmlentities($result->PaymentStatus); ?></td>
                                                        <td><?php echo htmlentities($result->PaymentAmount); ?></td>
                                                        <td>
                                                            <?php if ($result->Status == 2) { ?>
                                                                Cancelled
                                                            <?php } elseif ($result->Status == 1) { ?>
                                                                Confirmed
                                                            <?php } else { ?>
                                                                <a href="manage_booking_services.php?bkid=<?php echo htmlentities($result->BookingId); ?>" onclick="return confirm('Do you really want to cancel booking?')">Cancel</a>&nbsp;
                                                                <a href="manage_booking_services.php?bckid=<?php echo htmlentities($result->BookingId); ?>" onclick="return confirm('Do you really want to confirm booking?')">Confirm</a>
                                                                <form method="POST" action="manage_booking_services.php" style="display:inline;">
                                                                    <input type="hidden" name="booking_service_id" value="<?php echo htmlentities($result->BookingServiceId); ?>">
                                                                    <select name="payment_option" class="form-control">
                                                                        <option value="Credit Card" <?php if ($result->PaymentOption == 'Credit Card') echo 'selected'; ?>>Credit Card</option>
                                                                        <option value="Google Pay" <?php if ($result->PaymentOption == 'Google Pay') echo 'selected'; ?>>Google Pay</option>
                                                                        <option value="Paytm" <?php if ($result->PaymentOption == 'Paytm') echo 'selected'; ?>>Paytm</option>
                                                                        <option value="Bank Transfer" <?php if ($result->PaymentOption == 'Bank Transfer') echo 'selected'; ?>>Bank Transfer</option>
                                                                        <option value="Cash" <?php if ($result->PaymentOption == 'Cash') echo 'selected'; ?>>Cash</option>
                                                                    </select>
                                                                    <select name="payment_status" class="form-control">
                                                                        <option value="Pending" <?php if ($result->PaymentStatus == 'Pending') echo 'selected'; ?>>Pending</option>
                                                                        <option value="Completed" <?php if ($result->PaymentStatus == 'Completed') echo 'selected'; ?>>Completed</option>
                                                                        <option value="Failed" <?php if ($result->PaymentStatus == 'Failed') echo 'selected'; ?>>Failed</option>
                                                                    </select>
                                                                    <input type="number" name="payment_amount" value="<?php echo htmlentities($result->PaymentAmount); ?>" required>
                                                                    <button type="submit" name="update_payment" class="btn btn-primary">Update Payment</button>
                                                                </form>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } else { ?>
                                                <tr>
                                                    <td colspan="10">No Booking Services Found</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- DataTable with Hover -->
                    </div>
                    <!-- Row -->
                </div>
            </div>
            <!-- Footer -->
            <?php include('includes/footer.php'); ?>
            <!-- Footer -->
        </div>
    </div>
    <!-- Scroll to Top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- JavaScript files -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTableHover').DataTable({
                "order": [],
                "pageLength": 10
            });
        });
    </script>
</body>
</html>
