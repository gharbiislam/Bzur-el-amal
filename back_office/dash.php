<?php
// Database connection
$servername = "localhost";
$username = "root";  // Your database username
$password = "";      // Your database password
$dbname = "account";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the total number of users
$sql_users = "SELECT COUNT(*) AS total_users FROM users";
$result_users = $conn->query($sql_users);
$row_users = $result_users->fetch_assoc();

// Get the total number of requests
$sql_requests = "SELECT COUNT(*) AS total_requests FROM requests";
$result_requests = $conn->query($sql_requests);
$row_requests = $result_requests->fetch_assoc();

// Get the total number of equipment donations
$sql_donations_equipment = "SELECT COUNT(*) AS total_donations_equipment FROM dons_equipment";
$result_donations_equipment = $conn->query($sql_donations_equipment);
$row_donations_equipment = $result_donations_equipment->fetch_assoc();

// Get the total number of financial donations
$sql_donations_financial = "SELECT COUNT(*) AS total_donations_financial FROM dons_financieres";
$result_donations_financial = $conn->query($sql_donations_financial);
$row_donations_financial = $result_donations_financial->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .card {
            margin: 10px;
        }
        .card-body {
            padding: 20px;
        }
        .card-title {
            font-size: 24px;
            font-weight: bold;
        }
        .card-text {
            font-size: 16px;
        }
        .icon {
            font-size: 30px;
        }
        .card-body.d-flex {
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        
        <div class="row">
            <!-- All Users Card -->
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body d-flex">
                        <div>
                            <h5 class="card-title">$<?php echo $row_users['total_users']; ?></h5>
                            <p class="card-text">All Users</p>
                        </div>
                        <i class="fa fa-users icon"></i>
                    </div>
                </div>
            </div>

            <!-- Requests Card -->
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body d-flex">
                        <div>
                            <h5 class="card-title"><?php echo $row_requests['total_requests']; ?>+</h5>
                            <p class="card-text">Requests</p>
                        </div>
                        <i class="fa fa-file-text icon"></i>
                    </div>
                </div>
            </div>

            <!-- Equipment Donations Card -->
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body d-flex">
                        <div>
                            <h5 class="card-title"><?php echo $row_donations_equipment['total_donations_equipment']; ?></h5>
                            <p class="card-text">Equipment Donations</p>
                        </div>
                        <i class="fa fa-cogs icon"></i>
                    </div>
                </div>
            </div>

            <!-- Financial Donations Card -->
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body d-flex">
                        <div>
                            <h5 class="card-title"><?php echo $row_donations_financial['total_donations_financial']; ?></h5>
                            <p class="card-text">Financial Donations</p>
                        </div>
                        <i class="fa fa-dollar icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close(); // Close the connection
?>
