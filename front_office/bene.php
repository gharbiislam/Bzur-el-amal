<?php
session_start();
include 'db.php';

// Check if the user is logged in as a beneficiary
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'beneficiaire') {
    header("Location: login.php");
    exit;
}

$beneficiary_id = $_SESSION['id'];

// Fetch the requests made by the current beneficiary
$sql = "SELECT r.id_request, d.name AS equipment_name, r.date_demande, r.approved, r.documents ,r.dateReponse 
        FROM requests r
        JOIN dons_equipment d ON r.id_equipment = d.id_equipment
        WHERE r.user_id = '$beneficiary_id'";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de Bénéficiaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
    <h1>Bienvenue dans l'interface bénéficiaire</h1>

<h3>Mes demandes d'équipement</h3>

        <?php
        if (mysqli_num_rows($result) > 0) {
            // Display the requests in a table
            echo '<table class="table table-bordered mt-4">';
            echo '<thead>';
            echo '<tr>';
            echo '<th scope="col">ID Demande</th>';
            echo '<th scope="col">Nom de l\'équipement</th>';
            echo '<th scope="col">Date de la demande</th>';
            echo '<th scope="col">Statut</th>';
            echo '<th scope="col">Date Reponse</th>';
            echo '<th scope="col">Documents</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['id_request']) . '</td>';
                echo '<td>' . htmlspecialchars($row['equipment_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['date_demande']) . '</td>';
                echo '<td>' . htmlspecialchars($row['approved']) . '</td>';
                echo '<td>' . htmlspecialchars($row['dateReponse']) . '</td>';
                echo '<td><a href="' . htmlspecialchars($row['documents']) . '" target="_blank">Voir le document</a></td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<div class="alert alert-info">Aucune demande trouvée.</div>';
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>