<?php
//nav
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['admins_name'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
  <style>
   
 
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse position-fixed">
        <div class="position-sticky">
            <img src="../assets/images/logo/logowhite2-02.png" alt="logo" class="w-75">
          <ul class="nav flex-column mt-4">
            <li class="nav-item">
              <a class="nav-link active" href="dashboard.php">
                <i class="bi bi-speedometer2"></i> Dashboard
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="request.php">
                <i class="bi bi-file-earmark-text"></i> Request
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="equipment.php">
                <i class="bi bi-heart-pulse"></i> Équipement médical
              </a>
            </li> 
            <li class="nav-item">
              <a class="nav-link" href="finance.php">
              <i class="fas fa-donate"></i>  Finance
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="users.php">
                <i class="bi bi-people"></i> Users
              </a>
            </li>
           
          </ul>
          
          <div class="dropdown mt-4 ms-3">
            <a href="#" class="d-flex text-decoration-none dropdown-toggle" id="dropdownUser " data-bs-toggle="dropdown" aria-expanded="false">
              <span><?php echo htmlspecialchars($_SESSION['admins_name']); ?></span> 
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser ">
              <li><a class="dropdown-item" href="edit.php"><i class="bi bi-person"></i> Profile</a></li>
              <li><a class="dropdown-item" href="http://localhost/dashboard/pfa/front_office/index.php"><i class="bi bi-box-arrow-right"></i> Sign out</a></li>
            </ul>
          </div>
        </div>
      </nav>

      
    </div>
  </div>

  <script>
    

  

    
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
