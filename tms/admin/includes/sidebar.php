<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Decoration Management System</title>

  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

  <!-- FontAwesome for Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

  <!-- Custom CSS for Sidebar (Optional) -->
  <style>
    .sidebar {
      min-height: 100vh;
      background-color: #f8f9fc;
    }
    .sidebar .nav-item .nav-link {
      color: #4e73df;
    }
    .sidebar .nav-item .nav-link:hover {
      background-color: #e2e6ea;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
      <div class="sidebar-brand-icon">
        <img src="img/logo/logo.png">
      </div>
      <div class="sidebar-brand-text mx-3">Decoration Management System</div>
    </a>
    <hr class="sidebar-divider my-0">
    
    <!-- Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="dashboard.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <hr class="sidebar-divider">

    <!-- Features Heading -->
    <div class="sidebar-heading">
      Features
    </div>

    <!-- Package Management -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#packageForm" aria-expanded="false" aria-controls="packageForm">
        <i class="fab fa-fw fa-wpforms"></i>
        <span>Package Management</span>
      </a>
      <div id="packageForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Packages</h6>
          <a class="collapse-item" href="create_package.php">Create Package</a>
          <a class="collapse-item" href="manage_packages.php">Manage Packages</a>
        </div>
      </div>
    </li>

    <!-- Service Management -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#serviceForm" aria-expanded="false" aria-controls="serviceForm">
        <i class="fas fa-fw fa-cogs"></i>
        <span>Service Management</span>
      </a>
      <div id="serviceForm" class="collapse" aria-labelledby="headingService" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Services</h6>
          <a class="collapse-item" href="create_service.php">Create Service</a>
          <a class="collapse-item" href="manage_service.php">Manage Services</a>
        </div>
      </div>
    </li>

    <!-- Booking Services -->
    <li class="nav-item">
      <a class="nav-link" href="manage_booking_services.php">
        <i class="fas fa-fw fa-calendar-check"></i>
        <span>Booking Services</span>
      </a>
    </li>

    <!-- Bookings -->
    <li class="nav-item">
      <a class="nav-link" href="manage_bookings.php">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Bookings</span>
      </a>
    </li>

    <!-- Users -->
    <li class="nav-item">
      <a class="nav-link" href="manage_users.php">
        <i class="fas fa-fw fa-user"></i>
        <span>Users</span>
      </a>
    </li>

    <!-- User Management -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#users" aria-expanded="false" aria-controls="users">
        <i class="fas fa-fw fa-users"></i>
        <span>User Management</span>
      </a>
      <div id="users" class="collapse" aria-labelledby="headingUsers" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Users</h6>
          <a class="collapse-item" href="user_register.php">Register User</a>
          <a class="collapse-item" href="Permissions.php">User Permissions</a>
        </div>
      </div>
    </li>

    <!-- Payment Management (Fixed Placement) -->
 
  </ul>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>

