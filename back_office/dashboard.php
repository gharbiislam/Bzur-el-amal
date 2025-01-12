<?php
include 'db.php';

$sql_financial = "SELECT COUNT(*) as total_financial FROM dons_financieres";
$result_financial = $conn->query($sql_financial);
$total_financial = $result_financial->fetch_assoc()['total_financial'];

$sql_equipment = "SELECT COUNT(*) as total_equipment FROM dons_equipment";
$result_equipment = $conn->query($sql_equipment);
$total_equipment = $result_equipment->fetch_assoc()['total_equipment'];

$sql_users = "SELECT COUNT(*) as total_users FROM users";
$result_users = $conn->query($sql_users);
$total_users = $result_users->fetch_assoc()['total_users'];

$sql_donateur = "SELECT COUNT(*) as total_donateur FROM users where role='donateur'";
$result_donateur = $conn->query($sql_donateur);
$total_donateur = $result_donateur->fetch_assoc()['total_donateur'];

$sql_bene = "SELECT COUNT(*) as total_bene FROM users where role='beneficiaire'";
$result_bene = $conn->query($sql_bene);
$total_bene = $result_bene->fetch_assoc()['total_bene'];

$sql_requests = "SELECT COUNT(*) as total_requests FROM requests";
$result_requests = $conn->query($sql_requests);
$total_requests = $result_requests->fetch_assoc()['total_requests'];

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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <script src="../assets/js/bootstrap.min.js"></script>
  <style>
    .chart-container {
      width: 100%;
      max-width: 500px;
      /* Adjust the size as needed */
      margin: auto;
      /* Center the chart */
    }
  </style>

</head>

<body>
  <div class="d-flex flex-column flex-lg-row ">
    <div class="col-lg-2 d-none d-lg-block ">
      <?php
      include('nav.php'); ?>
    </div>

    <div class="col-lg-10 px-3" id="dashboard">
      <div>
      <h1 class="my-3">Dashboard</h1>
      
      <div class="card-deck ">
        <!--users card -->
        <div class="card col-lg-4 pt-3  text-white border-0  " id="card1">
          <div class="d-flex  mb-4 ">
            <div class="col-md-6">
              <span class="far fa-user fa-5x"></span>
            </div>
            <div class="col-md-6 text-right">
              <h1 class="card-title"><?php echo $total_users; ?></h1>
              <h6 class="card-subtitle font-weight-normal">Total users</h6>
            </div>
          </div>
          <div>
            <a href="" class="btn btn-outline-info bg-white btn-block mb-0 font-weight-bold">view more</a>
          </div>
        </div>
        <!--users donations-->

        <div class="card col-lg-4 pt-3  text-white  border-0 " id="card2">
          <div class="d-flex  mb-4 ">
            <div class="col-md-6">
              <span class="fas fa-donate fa-5x"></span>
            </div>
            <div class="col-md-6 text-right">
              <h1 class="card-title"><?php echo $total_financial + $total_equipment; ?></h1>
              <h6 class="card-subtitle font-weight-normal">Total donations</h6>
            </div>
          </div>
          <div>
            <a href="" class=" btn btn-outline-warning bg-white btn-block mb-0 font-weight-bold">view more</a>
          </div>
        </div>
        <!--users request -->

        <div class="card col-lg-4 pt-3  text-white  " id="card3">
          <div class="d-flex  mb-4 ">
            <div class="col-md-6">
              <span class="fas fa-donate fa-5x"></span>
            </div>
            <div class="col-md-6 text-right">
              <h1 class="card-title"><?php echo $total_requests ?></h1>
              <h6 class="card-subtitle font-weight-normal">Total request</h6>
            </div>
          </div>
          <div>
            <a href="" class="btn btn-outline-success bg-white btn-block mb-0 font-weight-bold font-weight-bold">view more</a>
          </div>
        </div>
      </div>
        
         <div>  
          <div class="d-md-flex justify-content-around ">
            <div class="col-md-7 mt-5 bg-white p-3 rounded">
              <h4>users</h4>
              <hr>
              <canvas id="donatorBeneficiaryChart" ></canvas>
            </div>

            <div class="col-md-4 mt-5 bg-white p-3 rounded">
              <h4>Donations</h4>
              <hr>
              <canvas id="donationChart" ></canvas>
            </div>
          </div>

          
          <div class="col-md-4 mt-5 bg-white p-3 rounded">
              <h4>Donations</h4>
              <hr>            <canvas id="donationsPerWeekChart"></canvas>

              <canvas id="donationChart" ></canvas>
            </div>
          
        </div></div>
    </div>
      <script>
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
              backgroundColor: ['#99CC99', '#ffcc00'],
              borderWidth: 1
            }, ]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: true,
                position: 'right', // Moves the label/legend to the right
              },
              tooltip: {
                enabled: true,
              }
            },
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });

        var ctx2 = document.getElementById('donatorBeneficiaryChart').getContext('2d');
        var donatorBeneficiaryChart = new Chart(ctx2, {
          type: 'bar',
          data: {
            labels: ['Donors', 'Beneficiaries'],
            datasets: [{
              label: ['donateur','beneficiare'],
              data: [<?php echo $total_donateur; ?>, <?php echo $total_bene; ?>],
              backgroundColor: ['#99CCFF', '#ffcc00'],
              borderWidth: 1
            }]
          },options: {
            responsive: true,
            plugins: {
              legend: {
                display: true,
                position: 'right', // Moves the label/legend to the right
              },
              tooltip: {
                enabled: true,
              }
            },
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });

        var ctx3 = document.getElementById('donationsPerWeekChart').getContext('2d');
        var donationsPerWeekChart = new Chart(ctx3, {
          type: 'line',
          data: {
            labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            datasets: [{
              label: 'Financial Donations',
              data: [10, 15, 12, 7, 18, 9, 5],
              borderColor: '#4e73df',
              fill: false
            }, {
              label: 'Equipment Donations',
              data: [5, 7, 8, 4, 6, 3, 4],
              borderColor: '#1cc88a',
              fill: false
            }]
          },options: {
            responsive: true,
            plugins: {
              legend: {
                display: true,
                position: 'right', // Moves the label/legend to the right
              },
              tooltip: {
                enabled: true,
              }
            },
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      </script>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>   </div>

</body>

</html>