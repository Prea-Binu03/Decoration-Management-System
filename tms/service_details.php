<?php
session_start();
include('includes/config.php');
include('includes/header.php');

// Initialize error and message variables
$error = '';
$msg = '';

// Check if 'ServiceId' is present in the URL
if (isset($_GET['ServiceId']) && !empty($_GET['ServiceId'])) {
    $serviceid = intval($_GET['ServiceId']);

    // Check if the user is logged in
    if (!isset($_SESSION['login']) || empty($_SESSION['login'])) {
        $error = "You need to log in to book a service.";
    } else {
        $userid = isset($_SESSION['UserId']) ? $_SESSION['UserId'] : null;

        // Check if form is submitted
        if (isset($_POST['submit2'])) {
            // Handle form submission
            $comment = $_POST['comment'] ?? '';
            $quantity = intval($_POST['quantity'] ?? 0);
            $paymentoption = $_POST['paymentoption'] ?? '';
            $paymentstatus = 'Pending';
            $status = 'Booked';

            // Fetch service cost and details
            $sql = "SELECT ServiceCost, ServiceName, ServiceDescription, ServiceImage FROM tblservice WHERE ServiceId=:ServiceId";
            $query = $dbh->prepare($sql);
            $query->bindParam(':ServiceId', $serviceid, PDO::PARAM_INT);
            $query->execute();
            $service = $query->fetch(PDO::FETCH_OBJ);

            if ($service) {
                $totalAmount = $service->ServiceCost * $quantity;

                // Insert booking details into the database
                $sql = "INSERT INTO tblbookingservices (ServiceId, UserId, Quantity, Status, PaymentOption, PaymentStatus, PaymentAmount, Comment) 
                        VALUES (:ServiceId, :userid, :quantity, :status, :paymentoption, :paymentstatus, :paymentamount, :comment)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':ServiceId', $serviceid, PDO::PARAM_INT);
                $query->bindParam(':userid', $userid, PDO::PARAM_INT);
                $query->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $query->bindParam(':status', $status, PDO::PARAM_STR);
                $query->bindParam(':paymentoption', $paymentoption, PDO::PARAM_STR);
                $query->bindParam(':paymentstatus', $paymentstatus, PDO::PARAM_STR);
                $query->bindParam(':paymentamount', $totalAmount, PDO::PARAM_STR);
                $query->bindParam(':comment', $comment, PDO::PARAM_STR);

                try {
                    $query->execute();
                    $lastInsertId = $dbh->lastInsertId();
                    if ($lastInsertId) {
                        $msg = "Booked Successfully. Thank you.";
                        $showPaymentButton = true; // Show payment button after booking success
                    } else {
                        $error = "Something went wrong. Please try again.";
                    }
                } catch (PDOException $e) {
                    $error = "Error: " . $e->getMessage();
                }
            } else {
                $error = "Service not found.";
            }
        }

        // Fetch service details for display
        $sql = "SELECT * FROM tblservice WHERE ServiceId=:ServiceId";
        $query = $dbh->prepare($sql);
        $query->bindParam(':ServiceId', $serviceid, PDO::PARAM_INT);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
    }
} else {
    $error = "Service ID is not set.";
}
?>

<!doctype html>
<html lang="en-gb" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Service Details</title>
    <meta name="description" content="Service Details">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/styles.css" />
    <style>
        .booking-form {
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .booking-form h3 {
            margin-bottom: 15px;
        }
        .selectroom_top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .selectroom_left, .selectroom_right {
            flex: 1;
        }
        .selectroom_right {
            margin-left: 20px;
        }
        .selectroom_left {
             flex: 1;
             display: flex; /* Use flexbox for alignment */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            }
  
        .selectroom_left img {
            max-width: 75%; //* Set max-width to reduce size */
            height: auto;     /* Maintain aspect ratio */
        }
    </style>
</head>

<body>
<section id="services" class="secPad">
    <div class="container">
        <div class="heading text-center">
            <h2>Service Details</h2>
            <p>Explore Our Most Popular Services for Stunning Decorations!</p>
        </div>
        <div class="selectroom">
            <div class="container">
                <?php if ($error) { ?>
                    <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?> </div>
                <?php } else if ($msg) { ?>
                    <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div>
                <?php } ?>

                <?php if (isset($results) && count($results) > 0) { 
                    foreach ($results as $result) { ?>
                        <div class="selectroom_top">
                            <div class="col-md-4 selectroom_left">
                                <img src="admin/ServiceImage/<?php echo htmlentities($result->ServiceImage); ?>" class="img-responsive" alt="">
                            </div>
                            <div class="col-md-8 selectroom_right">
                                <h2><?php echo htmlentities($result->ServiceName); ?></h2>
                                <p class="dow">#SRV-<?php echo htmlentities($result->ServiceId); ?></p>
                                <p><b>Description :</b> <?php echo htmlentities($result->ServiceDescription); ?></p>
                                <p><b>Cost :</b> <?php echo htmlentities($result->ServiceCost); ?></p>

                                <div class="grand">
                                    <p>Total Cost</p>
                                    <h3 id="totalCost"><?php echo htmlentities($result->ServiceCost); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="booking-form">
                            <h3>Book This Service</h3>
                            <form name="book" method="post" oninput="calculateTotal()">
                                <div class="selectroom_top">
                                    <div class="selectroom_right">
                                        <p><b>Additional Comments :</b> <textarea name="comment" rows="4" class="form-control"></textarea></p>
                                        <p><b>Quantity :</b> <input type="number" id="quantity" name="quantity" required min="1" class="form-control"></p>
                                        <p><b>Payment Option :</b> 
                                            <select name="paymentoption" required class="form-control">
                                                <option value="Credit Card">Credit Card</option>
                                                <option value="Google Pay">Google Pay</option>
                                                <option value="Paytm">Paytm</option>
                                                <option value="Bank Transfer">Bank Transfer</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Debit Card">Debit Card</option>
                                            </select>
                                        </p>
                                        <p><b>Payment Amount :</b> <input type="number" id="paymentAmount" step="0.01" name="paymentamount" required class="form-control" readonly></p>
                                        <input type="submit" name="submit2" value="Book Now" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                            <?php if (isset($showPaymentButton) && $showPaymentButton) { ?>
                                <a href="payment.php" class="btn btn-success">Make Payment</a>
                            <?php } ?>
                        </div>
                    <?php } 
                } ?>
            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>
</body>
</html>

<script>
function calculateTotal() {
    const quantity = document.getElementById('quantity').value || 0;
    const serviceCost = <?php echo isset($result) ? htmlentities($result->ServiceCost) : 0; ?>; // Get service cost from PHP
    const totalCost = serviceCost * quantity;
    document.getElementById('totalCost').innerText = totalCost.toFixed(2);
    document.getElementById('paymentAmount').value = totalCost.toFixed(2);
}
</script>
