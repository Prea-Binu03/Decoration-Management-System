<?php
include('includes/checklogin.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

check_login();

// Initialize error and message variables
$error = '';
$msg = '';

// Handle booking cancellation
if (isset($_GET['bkid'])) {
    $bid = intval($_GET['bkid']);
    $status = 2; // 2 for Cancelled
    $cancelby = 'a'; // 'a' for admin
    $sql = "UPDATE tblbooking SET Status=:status, CancelledBy=:cancelby WHERE BookingId=:bid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
    $query->bindParam(':cancelby', $cancelby, PDO::PARAM_STR);
    $query->bindParam(':bid', $bid, PDO::PARAM_INT);
    if ($query->execute()) {
        $msg = 'Booking Cancelled successfully';
    } else {
        $error = 'Something Went Wrong. Please try again';
    }
}

// Handle booking confirmation
if (isset($_GET['bckid'])) {
    $bcid = intval($_GET['bckid']);
    $status = 1; // 1 for Confirmed
    $sql = "UPDATE tblbooking SET Status=:status WHERE BookingId=:bcid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
    $query->bindParam(':bcid', $bcid, PDO::PARAM_INT);
    if ($query->execute()) {
        $msg = 'Booking Confirmed successfully';
    } else {
        $error = 'Something Went Wrong. Please try again';
    }
}

// Handle payment updates
if (isset($_POST['update_payment'])) {
    $bookingId = intval($_POST['booking_id']);
    $paymentMode = $_POST['payment_mode'] ?? '';
    $paymentStatus = $_POST['payment_status'] ?? '';
    $paymentAmount = floatval($_POST['payment_amount']);

    $sql = "UPDATE tblbooking SET PackagePaymentMode=:paymentMode, PaymentStatus=:paymentStatus, PaymentAmount=:paymentAmount WHERE BookingId=:bookingId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':paymentMode', $paymentMode, PDO::PARAM_STR);
    $query->bindParam(':paymentStatus', $paymentStatus, PDO::PARAM_STR);
    $query->bindParam(':paymentAmount', $paymentAmount, PDO::PARAM_STR);
    $query->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
    if ($query->execute()) {
        $msg = 'Payment details updated successfully';
    } else {
        $error = 'Something Went Wrong. Please try again';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="css/ruang-admin.min.css">
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include('includes/sidebar.php'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('includes/header.php'); ?>
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Manage Bookings</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Bookings</li>
                        </ol>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Manage Bookings</h6>
                                    <?php if ($error): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <strong>ERROR</strong>: <?php echo htmlentities($error); ?>
                                        </div>
                                    <?php elseif ($msg): ?>
                                        <div class="alert alert-success" role="alert">
                                            <strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="table-responsive p-3">
                                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Booking ID</th>
                                                <th>User ID</th>
                                                <th>Package ID</th>
                                                <th>From Date</th>
                                                <th>To Date</th>
                                                <th>Comment</th>
                                                <th>Registration Date</th>
                                                <th>Status</th>
                                                <th>Cancelled By</th>
                                                <th>Updation Date</th>
                                                <th>Payment Mode</th>
                                                <th>Payment Status</th>
                                                <th>Payment Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT BookingId, id AS UserId, PackageId, FromDate, ToDate, Comment, RegDate, Status, CancelledBy, UpdationDate, PackagePaymentMode, PaymentStatus, PaymentAmount FROM tblbooking";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);

                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result):
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($result->BookingId ?? 'N/A'); ?></td>
                                                        <td><?php echo htmlentities($result->UserId ?? 'N/A'); ?></td>
                                                        <td><?php echo htmlentities($result->PackageId ?? 'N/A'); ?></td>
                                                        <td><?php echo htmlentities($result->FromDate ?? 'N/A'); ?></td>
                                                        <td><?php echo htmlentities($result->ToDate ?? 'N/A'); ?></td>
                                                        <td><?php echo htmlentities($result->Comment ?? 'N/A'); ?></td>
                                                        <td><?php echo htmlentities($result->RegDate ?? 'N/A'); ?></td>
                                                        <td>
                                                            <?php
                                                            switch ($result->Status) {
                                                                case 1:
                                                                    echo 'Confirmed';
                                                                    break;
                                                                case 2:
                                                                    echo 'Cancelled';
                                                                    break;
                                                                case 3:
                                                                    echo 'Failed';
                                                                    break;
                                                                default:
                                                                    echo 'Pending';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo htmlentities($result->CancelledBy ?? 'N/A'); ?></td>
                                                        <td><?php echo htmlentities($result->UpdationDate ?? 'N/A'); ?></td>
                                                        <td><?php echo htmlentities($result->PackagePaymentMode ?? 'N/A'); ?></td>
                                                        <td><?php echo htmlentities($result->PaymentStatus ?? 'N/A'); ?></td>
                                                        <td><?php echo htmlentities($result->PaymentAmount ?? 'N/A'); ?></td>
                                                        <td>
                                                            <?php if ($result->Status == 2): ?>
                                                                Cancelled
                                                            <?php elseif ($result->Status == 1): ?>
                                                                Confirmed
                                                            <?php else: ?>
                                                                <a href="manage_bookings.php?bkid=<?php echo htmlentities($result->BookingId); ?>" onclick="return confirm('Do you really want to cancel booking?')">Cancel</a>
                                                                <a href="manage_bookings.php?bckid=<?php echo htmlentities($result->BookingId); ?>" onclick="return confirm('Do you really want to confirm booking?')">Confirm</a>
                                                                <form method="POST" action="manage_bookings.php" style="display:inline;">
                                                                    <input type="hidden" name="booking_id" value="<?php echo htmlentities($result->BookingId); ?>">
                                                                    <select name="payment_mode" class="form-control">
                                                                        <option value="Credit Card" <?php if ($result->PackagePaymentMode == 'Credit Card') echo 'selected'; ?>>Credit Card</option>
                                                                        <option value="Google Pay" <?php if ($result->PackagePaymentMode == 'Google Pay') echo 'selected'; ?>>Google Pay</option>
                                                                        <option value="Paytm" <?php if ($result->PackagePaymentMode == 'Paytm') echo 'selected'; ?>>Paytm</option>
                                                                        <option value="Bank Transfer" <?php if ($result->PackagePaymentMode == 'Bank Transfer') echo 'selected'; ?>>Bank Transfer</option>
                                                                        <option value="Cash" <?php if ($result->PackagePaymentMode == 'Cash') echo 'selected'; ?>>Cash</option>
                                                                        <option value="Debit Card" <?php if ($result->PackagePaymentMode == 'Debit Card') echo 'selected'; ?>>Debit Card</option>
                                                                    </select>
                                                                    <input type="text" name="payment_amount" placeholder="Amount" class="form-control" value="<?php echo htmlentities($result->PaymentAmount); ?>" required>
                                                                    <select name="payment_status" class="form-control">
                                                                        <option value="Pending" <?php if ($result->PaymentStatus == 'Pending') echo 'selected'; ?>>Pending</option>
                                                                        <option value="Paid" <?php if ($result->PaymentStatus == 'Paid') echo 'selected'; ?>>Paid</option>
                                                                        <option value="Failed" <?php if ($result->PaymentStatus == 'Failed') echo 'selected'; ?>>Failed</option>
                                                                    </select>
                                                                    <button type="submit" name="update_payment" class="btn btn-primary">Update Payment</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="14">No bookings found</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTableHover').DataTable();
        });
    </script>
</body>
</html>
