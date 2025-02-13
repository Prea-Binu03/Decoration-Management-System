<?php
session_start();
include('includes/config.php');
include('includes/header.php');

// Initialize variables
$error = '';
$msg = '';

// Handle cancellation request
if (isset($_GET['bkid'])) {
    $bookingId = intval($_GET['bkid']);

    // Check if the booking exists
    $sql = "SELECT Status FROM tblbooking WHERE BookingId = :bookingId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $status = $result['Status'];

        // If not already cancelled, proceed to cancel
        if ($status != 2) {
            $sql = "UPDATE tblbooking SET Status = 2 WHERE BookingId = :bookingId";
            $query = $dbh->prepare($sql);
            $query->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
            $query->execute();

            $msg = 'Booking cancelled successfully';
        } else {
            $error = 'Booking is already cancelled';
        }
    } else {
        $error = 'Invalid booking ID';
    }
}

// Display error or success message if available
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour History</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .card-header h6 {
            font-size: 1.5rem;
        }
        .table-bordered {
            border: 1px solid #dee2e6;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6;
        }
        .table th, .table td {
            padding: 1rem;
        }
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tour History</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tour History</li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="card">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Package Booking History</h6>
                                    <?php if ($error) { ?>
                                        <div class="alert alert-danger">
                                            <strong>ERROR</strong>: <?php echo htmlentities($error); ?>
                                        </div>
                                    <?php } else if ($msg) { ?>
                                        <div class="alert alert-success">
                                            <strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="table-responsive p-3">
                                    <table class="table table-bordered table-hover" id="dataTableHover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Booking Id</th>
                                                <th>User Id</th> <!-- Added UserId column -->
                                                <th>Package Name</th>
                                                <th>Booking Date</th>
                                                <th>From Date</th>
                                                <th>To Date</th>
                                                <th>Status</th>
                                                <th>Cancel</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT tblbooking.BookingId as bookid, tblbooking.id as userid, tbltourpackages.PackageName as pckname,
                                                        tblbooking.RegDate as bdate, tblbooking.FromDate as fdate,
                                                        tblbooking.ToDate as tdate, tblbooking.status as status
                                                    FROM tblbooking
                                                    JOIN tbltourpackages ON tblbooking.PackageId = tbltourpackages.PackageId";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {
                                            ?>
                                                    <tr>
                                                        <td>#BK-<?php echo htmlentities($result->bookid); ?></td>
                                                        <td><?php echo htmlentities($result->userid); ?></td> <!-- Display UserId -->
                                                        <td><?php echo htmlentities($result->pckname ?? 'No Package'); ?></td>
                                                        <td><?php echo htmlentities($result->bdate ?? 'No Date'); ?></td>
                                                        <td><?php echo htmlentities($result->fdate ?? 'No Date'); ?></td>
                                                        <td><?php echo htmlentities($result->tdate ?? 'No Date'); ?></td>
                                                        <td>
                                                            <?php
                                                            switch ($result->status) {
                                                                case 0:
                                                                    echo 'Not Confirmed';
                                                                    break;
                                                                case 1:
                                                                    echo 'Confirmed';
                                                                    break;
                                                                case 2:
                                                                    echo 'Cancelled';
                                                                    break;
                                                                default:
                                                                    echo 'Unknown Status';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($result->status == 2) { ?>
                                                                Cancelled
                                                            <?php } else { ?>
                                                                <a href="tour_history.php?bkid=<?php echo htmlentities($result->bookid); ?>" onclick="return confirm('Do you really want to cancel booking?')">Cancel</a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo '<tr><td colspan="8">No Records Found</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- DataTables for Service Bookings -->
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Service Booking History</h6>
                                </div>
                                <div class="table-responsive p-3">
                                    <table class="table table-bordered table-hover" id="dataTableHoverServices">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Booking Service Id</th>
                                                <th>User Id</th> <!-- Added UserId column -->
                                                <th>Service Name</th>
                                                <th>Booking Id</th>
                                                <th>Quantity</th>
                                                <th>Status</th>
                                                <th>Payment Option</th>
                                                <th>Payment Status</th>
                                                <th>Payment Amount</th>
                                                <th>Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT bs.BookingServiceId as bookserviceid, bs.UserId as userid, s.ServiceName as servicename, 
                                                        bs.BookingId as bookid, bs.Quantity as quantity, 
                                                        bs.Status as status, bs.PaymentOption as paymentoption,
                                                        bs.PaymentStatus as paymentstatus, bs.PaymentAmount as paymentamount, 
                                                        bs.Comment as comment
                                                    FROM tblbookingservices bs
                                                    JOIN tblservice s ON bs.ServiceId = s.ServiceId";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {
                                            ?>
                                                    <tr>
                                                        <td>#BS-<?php echo htmlentities($result->bookserviceid); ?></td>
                                                        <td><?php echo htmlentities($result->userid); ?></td> <!-- Display UserId -->
                                                        <td><?php echo htmlentities($result->servicename ?? 'No Service'); ?></td>
                                                        <td>#BK-<?php echo htmlentities($result->bookid); ?></td>
                                                        <td><?php echo htmlentities($result->quantity ?? 'No Quantity'); ?></td>
                                                        <td>
                                                            <?php
                                                            switch ($result->status) {
                                                                case 0:
                                                                    echo 'Not Confirmed';
                                                                    break;
                                                                case 1:
                                                                    echo 'Confirmed';
                                                                    break;
                                                                case 2:
                                                                    echo 'Cancelled';
                                                                    break;
                                                                default:
                                                                    echo 'Unknown Status';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo htmlentities($result->paymentoption ?? 'Not Specified'); ?></td>
                                                        <td>
                                                            <?php
                                                            echo $result->paymentstatus == 1 ? 'Paid' : 'Pending';
                                                            ?>
                                                        </td>
                                                        <td><?php echo htmlentities($result->paymentamount ?? 'No Amount'); ?></td>
                                                        <td><?php echo htmlentities($result->comment ?? 'No Comment'); ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo '<tr><td colspan="10">No Records Found</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTableHover').DataTable();
            $('#dataTableHoverServices').DataTable();
        });
    </script>
</body>
</html>
