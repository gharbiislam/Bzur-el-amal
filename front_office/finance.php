<?php
include 'db.php';
include 'header.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$categories = ['equipments', 'operations', 'soinsmedicaux'];
$data = [];

foreach ($categories as $categorie) {
    $query = "SELECT SUM(montant) AS total_donations, COUNT(DISTINCT id_donateur) AS donateur FROM dons_financieres WHERE categorie = '$categorie' AND approve='oui'";
    $result = mysqli_query($conn, $query);
    $donations = mysqli_fetch_assoc($result);
    $total_donations = $donations['total_donations'] ?? 0;

    $query2 = "SELECT SUM(montant) AS montant_demande FROM request_financiere WHERE categorie = '$categorie' AND approved='acceptée'";
    $result2 = mysqli_query($conn, $query2);
    $requested = mysqli_fetch_assoc($result2);
    $total_requested = $requested['montant_demande'] ?? 0;

    $data[$categorie] = [
        'total_donations' => $total_donations,
        'donateur' => $donationData['donateur'] ?? 0,
        'total_requested' => $total_requested,
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Dons Financiers</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container my-5">
    <h2 class="text-center text-primary">Nos Dons Financiers</h2>
    <p class="text-center text-muted">Choisissez la catégorie de votre don. Cela nous permettra de mieux orienter votre soutien là où il est le plus nécessaire. Merci pour votre solidarité.</p>

    <div class="row mt-4">
        <!-- Equipments Card -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-sm">
                <a href="details.php?categorie=equipments">
                    <img class="card-img-top" src="../assets/images/bg/equipment.png" alt="Equipments" height="300px">
                </a>
                <div class="card-body">
                    <h5 class="card-title text-center">Équipements</h5>
                    <p class="text-muted">Contribuez à fournir des équipements essentiels comme des fauteuils roulants ou</p>
                    <div class="progress mb-3">
                        <div class="progress-bar " id="card1"
                             role="progressbar" 
                             style="width: <?= ($data['equipments']['total_requested'] > 0) ? ($data['equipments']['total_donations'] / $data['equipments']['total_requested']) * 100 : 0; ?>%;" 
                             aria-valuenow="<?= $data['equipments']['total_donations']; ?>" 
                             aria-valuemin="0" 
                             aria-valuemax="<?= $data['equipments']['total_requested']; ?>">
                        </div>
                    </div>
                
                    <p class="text-center d-flex justify-content-between ">
                    <span>
                            <?= $donations['donateur']  ?> donateur(s) ont contribué
                        </span> 
                        <span>
                        <?= ($data['equipments']['total_requested'] > 0) 
                                ? round(($data['equipments']['total_donations'] / $data['equipments']['total_requested']) * 100, 2) 
                                : 0; ?>% 
                        </span>
                        
                    </p>
                </div>
            </div>
        </div>

        <!-- Operations Card -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-sm">
                <a href="details.php?categorie=operations">
                    <img class="card-img-top" src="../assets/operations.png" alt="Operations" height="300px">
                </a>
                <div class="card-body">
                    <h5 class="card-title text-center">Opérations</h5>
                    <p class="text-muted">Aidez-nous à financer des opérations médicales vitales pour les personnes dans le besoin.</p>
                    <div class="progress mb-3">
                        <div class="progress-bar "id="card1" 
                             role="progressbar" 
                             style="width: <?= ($data['operations']['total_requested'] > 0) ? ($data['operations']['total_donations'] / $data['operations']['total_requested']) * 100 : 0; ?>%;" 
                             aria-valuenow="<?= $data['operations']['total_donations']; ?>" 
                             aria-valuemin="0" 
                             aria-valuemax="<?= $data['operations']['total_requested']; ?>">
                        </div>
                    </div>
                    <p class="text-center d-flex justify-content-between ">
                    <span>
                            <?= $donations['donateur']  ?> donateur(s) ont contribué
                        </span> 
                        <span>
                            <?= ($data['operations']['total_requested'] > 0) 
                                ? round(($data['operations']['total_donations'] / $data['operations']['total_requested']) * 100, 2) 
                                : 0; ?>% 
                        </span>
                        
                    </p>
                    
                </div>
            </div>
        </div>

        <!-- Soins Médicaux Card -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-sm">
                <a href="details.php?categorie=soinsmedicaux">
                    <img class="card-img-top" src="../assets/soins.jpg" alt="Soins Médicaux" height="300px">
                </a>
                <div class="card-body">
                    <h5 class="card-title text-center">Soins Médicaux</h5>
                    <p class="text-muted">Faites un don pour soutenir les soins médicaux indispensables aux personnes vulnérables.</p>
                    <div class="progress mb-3">
                        <div class="progress-bar" id="card1" 
                             role="progressbar" 
                             style="width: <?= ($data['soinsmedicaux']['total_requested'] > 0) ? ($data['soinsmedicaux']['total_donations'] / $data['soinsmedicaux']['total_requested']) * 100 : 0; ?>%;" 
                             aria-valuenow="<?= $data['soinsmedicaux']['total_donations']; ?>" 
                             aria-valuemin="0" 
                             aria-valuemax="<?= $data['soinsmedicaux']['total_requested']; ?>">
                        </div>
                    </div>
                    
                    <p class="text-center d-flex justify-content-between ">
                    <span>
                            <?= $donations['donateur']  ?> donateur(s) ont contribué
                        </span> 
                        <span>
                        <?= ($data['soinsmedicaux']['total_requested'] > 0) 
                                ? round(($data['soinsmedicaux']['total_donations'] / $data['soinsmedicaux']['total_requested']) * 100, 2) 
                                : 0; ?>% 
                        </span>
                        
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
