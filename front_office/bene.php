<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'beneficiaire') {
    header("Location: login.php");
    exit;
}

$beneficiary_id = $_SESSION['id'];

$sql = "SELECT r.id_request, d.name AS equipment_name, r.date_demande, r.approved, r.documents ,r.dateReponse 
        FROM requests r
        JOIN dons_equipment d ON r.id_equipment = d.id_equipment
        WHERE r.user_id = '$beneficiary_id'";

$result = mysqli_query($conn, $sql);
if (!$result) {
    die('Error in SQL query: ' . mysqli_error($conn));
}

$sql2 = "SELECT id_request, categorie, montant, details, documents, approved, date_reponse
         FROM request_financiere WHERE user_id='$beneficiary_id'";

$result2 = mysqli_query($conn, $sql2);
if (!$result2) {
    die('Error in SQL query: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de Bénéficiaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>
    <?php include 'header.php'; ?>


    <div class="text-center pt-5 d-flex-row" id="dons" style="background-image: url('../assets/images/bg/about2.jpg');">
    <h1 >Bienvenue dans l'interface bénéficiaire</h1>
    <p>Lorem ipsum dolor sit amet consectetur. Mauris ipsum phasellus purus metus in maecenas vitae facilisi turpis. Enim rutrum pretium aliquet</p>
   <div> <a href="demandeFinanace.php" id="btn2">Demande financiere</a>
    <a href="equipment.php" id="btn2">Demande equipment</a></div>
</div>
<div class="container text-center">
    <h2 class="text-primary">Historique de Demande</h2>
    <p>Lorem ipsum dolor sit amet consectetur. Mauris ipsum phasellus purus.</p>

    <a href="#" id="showEquipment" id="btn2">Demande Equipment</a>
    <a href="#" id="showFinance" id="btn1">Demande Financière</a>

    <div id="equipmentSection" class="mt-4">
        <?php 
        if (mysqli_num_rows($result) > 0) {
            echo '<table class="table table-bordered mt-4">';
            echo '<thead>';
            echo '<tr class="table-primary">';
            echo '<th scope="col">Nom de l\'équipement</th>';
            echo '<th scope="col">Documents</th>';
            echo '<th scope="col">Date de la demande</th>';
            echo '<th scope="col">Statut</th>';
            echo '<th scope="col">Date Réponse</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr class="table-warning">';
                echo '<td>' . htmlspecialchars($row['equipment_name']) . '</td>';
                echo '<td><a href="' . htmlspecialchars($row['documents']) . '" target="_blank">Voir le document</a></td>';
                echo '<td>' . htmlspecialchars($row['date_demande']) . '</td>';
                echo '<td>' . htmlspecialchars($row['approved']) . '</td>';
                echo '<td>' . htmlspecialchars($row['dateReponse']) . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<div class="alert alert-info">Aucune demande trouvée.</div>';
        }
        ?>
    </div>

    <div id="financeSection" class="mt-4 d-none">
        <?php 
        if (mysqli_num_rows($result2) > 0) {
            echo '<table class="table table-bordered mt-4">';
            echo '<thead>';
            echo '<tr class="table-primary">';
            echo '<th scope="col">ID Demande</th>';
            echo '<th scope="col">Catégorie</th>';
            echo '<th scope="col">Montant</th>';
            echo '<th scope="col">Documents</th>';
            echo '<th scope="col">Détails</th>';
            echo '<th scope="col">Statut</th>';
            echo '<th scope="col">Date Réponse</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_assoc($result2)) {
                echo '<tr class="table-warning">';
                echo '<td>' . htmlspecialchars($row['id_request']) . '</td>';
                echo '<td>' . htmlspecialchars($row['categorie']) . '</td>';
                echo '<td>' . htmlspecialchars($row['montant']) . '</td>';
                echo '<td><a href="' . htmlspecialchars($row['documents']) . '" target="_blank">Voir le document</a></td>';
                echo '<td>' . htmlspecialchars($row['details']) . '</td>';
                echo '<td>' . htmlspecialchars($row['approved']) . '</td>';
                echo '<td>' . htmlspecialchars($row['date_reponse']) . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<div class="alert alert-info">Aucune demande trouvée.</div>';
        }
        ?>
    </div>
</div>

<script>
    document.getElementById('showEquipment').addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('equipmentSection').classList.remove('d-none');
        document.getElementById('financeSection').classList.add('d-none');
    });

    document.getElementById('showFinance').addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('equipmentSection').classList.add('d-none');
        document.getElementById('financeSection').classList.remove('d-none');
    });
</script>

</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>