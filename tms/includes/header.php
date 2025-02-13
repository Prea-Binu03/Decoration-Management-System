<?php
// Start the session only if it's not already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="header">
    <?php if(isset($_SESSION['login'])) { ?>
        <div class="top-header">
            <div class="container">
                <ul class="tp-hd-lft wow fadeInLeft animated" data-wow-delay=".5s">
                    <li class="hm"><a href="index.php"><i class="fa fa-home"></i></a></li>
                    <li class="prnt"><a href="profile.php">My Profile</a></li>
                    <li class="prnt"><a href="change_password.php">Change Password</a></li>
                    <li class="prnt"><a href="tour_history.php">History</a></li>
                </ul>
                <ul class="tp-hd-rgt wow fadeInRight animated" data-wow-delay=".5s"> 
                    <li class="tol">Welcome :</li>        
                    <li class="sig"><?php echo htmlentities($_SESSION['login']); ?></li> 
                    <li class="sigi"><a href="logout.php">/ Logout</a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
    <?php 
    } else { ?>
        <div class="top-header">
            <div class="container">
                <ul class="tp-hd-lft wow fadeInLeft animated" data-wow-delay=".5s">
                    <li class="hm"><a href="admin/index.php">Admin Login</a></li>
                </ul>
                <ul class="tp-hd-rgt wow fadeInRight animated" data-wow-delay=".5s"> 
                    <li class="tol">Toll Number : 123-4568790</li>        
                    <li class="sig"><a href="#" data-toggle="modal" data-target="#myModal">Sign Up</a></li> 
                    <li class="sigi"><a href="#" data-toggle="modal" data-target="#myModal4">&nbsp; Sign In</a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
    <?php } ?>
    <div class="container">
        <nav class="navbar navbar-inverse" role="navigation">
            <div class="navbar-header adeInDown animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">
                <a href="index.php" class="navbar-brand scroll-top logo" style="margin-top: -5px;">
                    <img src="images/logo.png" alt="Decoration Management System Logo" style="height: 50px; margin-top: -10px;">
                    <span>Decoration Management System</span>
                </a>
                <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="main-nav" class="collapse navbar-collapse adeInDown animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">
                <ul class="nav navbar-nav" id="mainNav">
                    <li><a href="index.php" class="scroll-link">Home</a></li>
                    <li><a href="index.php#aboutUs" class="scroll-link">About Us</a></li>
                    <li><a href="index.php#packages" class="scroll-link">Packages</a></li>
                    <li><a href="index.php#portfolio" class="scroll-link">Gallery</a></li>
                    <li><a href="index.php#services" class="scroll-link">Services</a></li>
                    <li><a href="index.php#contactUs" class="scroll-link">Contact Us</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>
