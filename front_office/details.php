<?php
// details.php
include 'db.php';
include 'header.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['categorie'])) {
    $categorie = $_GET['categorie'];

    if ($categorie == 'equipments') {
        $title = "Equipments";
        $image = "../assets/images/bg/equipment2.png";
        $details = "Nous lançons un appel à votre générosité pour fournir des équipements essentiels aux personnes en situation de handicap. Qu'il s'agisse de fauteuils roulants, de prothèses ou d'appareils auditifs, ces outils changent des vies en offrant autonomie et dignité. Avec votre soutien, nous pourrons répondre aux besoins urgents de nombreux bénéficiaires.
       <br> <br>C'est parce que je compte sur votre générosité je me permets de vous solliciter. Quelque soit le montant de votre Don, votre geste fera la différence et sera apprécié";
    } elseif ($categorie == 'operations') {
        $title = "Operations";
        $image = "http://localhost/dashboard/pfa/assets/operations.png";
        $details = "De nombreuses personnes en situation de handicap nécessitent des interventions chirurgicales vitales pour améliorer leur qualité de vie. Malheureusement, ces opérations restent hors de portée pour beaucoup en raison des coûts élevés. Votre contribution peut offrir à ces individus une chance de vivre sans douleur et de retrouver espoir.
        <br> <br>C'est parce que je compte sur votre générosité je me permets de vous solliciter. Quelque soit le montant de votre Don, votre geste fera la différence et sera apprécié";
    } elseif ($categorie == 'soinsmedicaux') {
        $title = "Soins Medicaux";
        $image = "http://localhost/dashboard/pfa/assets/soins.jpg";
        $details = "Les soins médicaux réguliers sont essentiels pour maintenir et améliorer la santé des personnes en situation de handicap. Qu'il s'agisse de consultations spécialisées, de rééducation ou de médicaments, votre aide permet d'assurer un suivi médical indispensable. Ensemble, nous pouvons garantir à ces personnes un meilleur avenir.
        <br> <br>C'est parce que je compte sur votre générosité je me permets de vous solliciter. Quelque soit le montant de votre Don, votre geste fera la différence et sera apprécié";
    } else {
        $title = "Categorie Not Found";
        $image = "#";
    }

    $query = "SELECT SUM(montant) AS total_donations, COUNT(DISTINCT id_donateur) AS donateur FROM dons_financieres WHERE categorie = '$categorie'";
    $result = mysqli_query($conn, $query);
    $donations = mysqli_fetch_assoc($result);

    $total_donations = isset($donations['total_donations']) && is_numeric($donations['total_donations']) ? $donations['total_donations'] : 0;
    $donateur = isset($donations['donateur']) && is_numeric($donations['donateur']) ? $donations['donateur'] : 0;

    $query2 = "SELECT SUM(montant) AS montant_demande FROM request_financiere WHERE categorie = '$categorie'";
    $result2 = mysqli_query($conn, $query2);
    $requested = mysqli_fetch_assoc($result2);
    
    $total_requested = isset($requested['montant_demande']) && is_numeric($requested['montant_demande']) ? $requested['montant_demande'] : 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="container mt-5 pt-3">
        <h1 class="my-4 text-center"><?php echo $title; ?></h1>
        <div class="row justify-content-around container mt-5">
            <div class="col-md-7 col-12 shadow-lg border-5 p-3 border-top rounded border-primary row justify-content-center align-items-center h-100">
                <div><img src="<?php echo $image; ?>" alt="" class="w-100"></div>
                <div class="pt-3">
                    <p class="tex-info"><?php echo $details; ?></p>
                </div>
            </div>
            <div class="col-md-4 col-12 shadow-lg border-5 border-top border-primary rounded p-3 h-50">
                <div id="faireUndon" class="text-center">
                    <div class="row justify-content-center">
                        <canvas id="donutChart" width="150" h-auto></canvas>

                        <h2 id="titre"><?php echo number_format($total_donations, 2); ?> DT</h2>
                        <h5 class="fw-bold">collectés sur: <span class="fw-bolder"><?php echo number_format($total_requested, 2); ?> DT</span></h5>
                        <h4><span id="titre"><i class="fas fa-user-friends"></i> <?php echo number_format($donateur); ?></span> <span>Participant(s)</span></h4>
                    </div>
                    <div class="border-top border-bottom my-3 bg-light p-4">
                        <?php if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'donateur'): ?>
                            <button class="btn btn-lg" id="btn2" disabled>Faire un don</button>
                        <?php else: ?>
                            <button class="btn btn-lg" id="btn2" onclick="showFormDon()">Faire un don</button>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p> Reste à collecter : <span class="fw-bolder"> <?php echo number_format($total_requested - $total_donations, 2); ?> DT</span></p>
                    </div>
                </div>
                <div id="formDon" class="container d-none">
                    <i class="fa fa-arrow-left fa-3 ml-5" aria-hidden="true" onclick="showFaireUndon()"></i>
                    <?php include 'ajouterFinanace.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showFormDon() {
            document.getElementById('faireUndon').classList.add('d-none');
            document.getElementById('formDon').classList.remove('d-none');
        }

        function showFaireUndon() {
            document.getElementById('formDon').classList.add('d-none');
            document.getElementById('faireUndon').classList.remove('d-none');
        }

        var ctx = document.getElementById('donutChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    label: 'Donations vs Requested',
                    data: [<?php echo $total_donations; ?>, <?php echo $total_requested; ?>],
                    backgroundColor: ['#5DAAFD', '#ebedf0'],
                    borderColor: ['#FFFFFF', '#FFFFFF'],
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: false,
                cutout: '80%',
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw.toLocaleString('en-US', {
                                    style: 'currency',
                                    currency: 'TND'
                                });
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
