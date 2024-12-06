<?php
session_start();
if (!isset($_SESSION['admins_name'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost"; // Your server name
$username = 'root'; // Your database username
$password = ""; // Your database password
$dbname = "account"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch counts of donations
$sql_financial = "SELECT COUNT(*) as total_financial FROM dons_financieres";
$result_financial = $conn->query($sql_financial);
$total_financial = $result_financial->fetch_assoc()['total_financial'];

$sql_equipment = "SELECT COUNT(*) as total_equipment FROM dons_equipment";
$result_equipment = $conn->query($sql_equipment);
$total_equipment = $result_equipment->fetch_assoc()['total_equipment'];

// Fetch counts of users and requests
$sql_users = "SELECT COUNT(*) as total_users FROM users";
$result_users = $conn->query($sql_users);
$total_users = $result_users->fetch_assoc()['total_users'];

$sql_donateur = "SELECT COUNT(*) as total_donateur FROM users where role='donateur'";
$result_donateur = $conn->query($sql_donateur);
$total_donateur= $result_donateur->fetch_assoc()['total_donateur'];

$sql_bene = "SELECT COUNT(*) as total_bene FROM users where role='beneficiaire'";
$result_bene = $conn->query($sql_bene);
$total_bene= $result_bene->fetch_assoc()['total_bene'];

$sql_requests = "SELECT COUNT(*) as total_requests FROM requests";
$result_requests = $conn->query($sql_requests);
$total_requests = $result_requests->fetch_assoc()['total_requests'];

// Fetch donation data for charts
$sql_donations = "SELECT type_equipment, COUNT(*) as count FROM dons_equipment GROUP BY type_equipment ";
$result_donations = $conn->query($sql_donations);
$donation_data = [];
while ($row = $result_donations->fetch_assoc()) {
    $donation_data[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .sidebar {
      height: 100vh;
      background-color: #343a40;
      color: #fff;
    }
    .sidebar a {
      color: #adb5bd;
      padding: 0.75rem 1.5rem;
      display: flex;
      align-items: center;
      text-decoration: none;
    }
    .sidebar a:hover {
      color: #ffffff;
      background-color: #495057;
    }
    .sidebar .bi {
      margin-right: 8px;
    }
    .dropdown-menu-dark {
      background-color: #343a40;
    }
    /* Chart Container */
    .chart-container {
      position: relative;
      width: 50%; /* Adjust width as needed */
      margin: auto; /* Center the chart */
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse position-fixed">
        <div class="position-sticky">
          <a href="http://localhost/dashboard/pfa/front_office/index.php">
            <img src="http://localhost/dashboard/pfa/assets/images/logo/logo.png" alt="logo" width="100px">
          </a>
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">
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
              <a class="nav-link" href="users.php">
                <i class="bi bi-people"></i> Users
              </a>
            </li>
          </ul>
          
          <!-- Profile Dropdown -->
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

      <!-- Main content -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Dashboard</h1>
          <button class="btn btn-outline-secondary d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar">
            Toggle Sidebar
          </button>
        </div>

        <!-- Info Boxes -->
        <div class="row">
          <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
              <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <p class="card-text"><?php echo $total_users; ?></p>
                <i class="bi bi-person"></i>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
              <div class="card-body">
                <h5 class="card-title">Total Donations</h5>
                <p class="card-text"><?php echo $total_financial + $total_equipment; ?></p>
                <i class="bi bi-cash"></i>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
              <div class="card-body">
                <h5 class="card-title">Total Requests</h5>
                <p class="card-text"><?php echo $total_requests; ?></p>
                <i class="bi bi-file-earmark-text"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Charts -->
        <!-- Doughnut Chart for Donations -->
        <div class="chart-container">
          <canvas id="donationChart"></canvas>
        </div>

        <!-- Bar Chart for Donators and Beneficiaries -->
        <div class="chart-container">
          <canvas id="donatorBeneficiaryChart"></canvas>
        </div>

        <!-- Line Chart for Donations per Week -->
        <div class="chart-container">
          <canvas id="donationsPerWeekChart"></canvas>
        </div>

      </main>
    </div>
  </div>

  <script>
    // Doughnut Chart for Donations Types (Financial vs Equipment)
    var ctx = document.getElementById('donationChart').getContext('2d');
    var donationChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Financial Donations', 'Equipment Donations'],
        datasets: [{
          label: 'Donation Types',
          data: [
            <?php echo $total_financial; ?>, 
            <?php echo $total_equipment; ?>
          ],
          backgroundColor: ['#4e73df', '#1cc88a'],
          borderWidth: 1
        }]
      }
    });

    // Bar Chart for Donators vs Beneficiaries
    var ctx2 = document.getElementById('donatorBeneficiaryChart').getContext('2d');
    var donatorBeneficiaryChart = new Chart(ctx2, {
      type: 'bar',
      data: {
        labels: ['Donors', 'Beneficiaries'],
        datasets: [{
          label: 'User Breakdown',
          data: [<?php echo $total_donateur; ?>, <?php echo $total_bene; ?>],  // Adjust as needed
          backgroundColor: ['#36b9cc', '#f6c23e'],
          borderWidth: 1
        }]
      }
    });

    // Line Chart for Donations per Week
    var ctx3 = document.getElementById('donationsPerWeekChart').getContext('2d');
    var donationsPerWeekChart = new Chart(ctx3, {
      type: 'line',
      data: {
        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
        datasets: [{
          label: 'Financial Donations',
          data: [10, 15, 12, 7, 18, 9, 5],  // Replace with dynamic data from DB
          borderColor: '#4e73df',
          fill: false
        }, {
          label: 'Equipment Donations',
          data: [5, 7, 8, 4, 6, 3, 4],  // Replace with dynamic data from DB
          borderColor: '#1cc88a',
          fill: false
        }]
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
