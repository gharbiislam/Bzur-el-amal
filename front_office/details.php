<?php 
include 'db.php';
include 'header.php';

// Check if categorie is passed via the query string
if (isset($_GET['categorie'])) {
    $categorie = $_GET['categorie'];

    // Retrieve data based on the categorie
    if ($categorie == 'equipments') {
        $title = "Equipments";
        $image = "http://localhost/dashboard/pfa/assets/equipmen.jpeg";
    } elseif ($categorie == 'operations') {
        $title = "Operations";
        $image = "http://localhost/dashboard/pfa/assets/operations.png";
    } elseif ($categorie == 'soinsmedicaux') {
        $title = "Soins Medicaux";
        $image = "http://localhost/dashboard/pfa/assets/soins.jpg";
    } else {
        // Default fallback
        $title = "categorie Not Found";
        $image = "#";
    }

    $query = "SELECT SUM(montant) AS total_donations, COUNT(DISTINCT id_donateur) AS donateur FROM dons_financieres WHERE categorie = '$categorie'";
    $result = mysqli_query($conn, $query);
    $donations = mysqli_fetch_assoc($result);
    $total_donations = $donations['total_donations'] ?? 0;
    $donateur = $donations['donateur'] ?? 0;
    

    $query2 = "SELECT SUM(montant) AS montant_demande FROM request_financiere WHERE categorie = '$categorie'";
    $result2 = mysqli_query($conn, $query2);
    $requested = mysqli_fetch_assoc($result2);
    $total_requested = $requested['montant_demande'] ?? 0;
    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="container mt-5 pt-5">
    <div class="row">
        <div class="col-8">
            <h1><?php echo $title; ?></h1>
            <img src="<?php echo $image; ?>" alt="" width="350px" height="300px">
            <div class="pt-3">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, omnis ea! Aliquid dolore consectetur voluptatem itaque commodi, molestiae veniam quis. Ducimus molestiae vero magni eos eligendi facere fugit eum similique!</p>
            </div>
            
</div>
            <!-- Add Canvas for Doughnut Chart -->
            <div class="col-4 pt-5">
                <canvas id="donutChart" width="400" height="400"></canvas>
                <h5>Amount Collected: <?php echo number_format($total_donations, 2); ?> </h5>
                <h4>Amount Requested: <?php echo number_format($total_requested, 2); ?></h4>
                <h4>Participant(s): <?php echo number_format($donateur); ?></h4>
            
            </div>
</div>
            <!-- Chart.js Script -->
            <script>
                var ctx = document.getElementById('donutChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Amount Collected', 'Amount Requested'],
                        datasets: [{
                            label: 'Donations vs Requested',
                            data: [<?php echo $total_donations; ?>, <?php echo $total_requested; ?>],
                            backgroundColor: [ '#0000FF','#808080',],
                            borderColor: ['#FFFFFF', '#FFFFFF'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
                                    }
                                }
                            }
                        }
                    }
                });
            </script>
      
    
</body>

</html>
