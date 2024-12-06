<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donateur Interface</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
<?php 
session_start();
include 'header.php'; 
include 'db.php'; // Ensure you include your database connection

// Check if the user is logged in and is a donor
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'donateur') {
    header("Location: login.php");
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION['id'];

// Fetch the donor ID from the donateur table
$sql_donateur = "SELECT id_donateur FROM donateur WHERE user_id = '$user_id'";
$result_donateur = mysqli_query($conn, $sql_donateur);

if ($result_donateur && mysqli_num_rows($result_donateur) > 0) {
    $donateur = mysqli_fetch_assoc($result_donateur);
    $donateur_id = $donateur['id_donateur'];

    // Fetch financial donations
    $sql_financial = "SELECT * FROM dons_financieres WHERE id_donateur = '$donateur_id'";
    $result_financial = mysqli_query($conn, $sql_financial);

    // Fetch equipment donations
    $sql_equipment = "SELECT * FROM dons_equipment WHERE id_donateur = '$donateur_id'";
    $result_equipment = mysqli_query($conn, $sql_equipment);
} else {
    echo "Aucun donateur trouvé pour cet utilisateur.";
    exit;
}
?>

<div class="container mt-5 pt-5">
    <h1>Welcome to Donateur Interface</h1>
    <button><a href="ajouterEquip.php">Ajouter equipment</a></button>
    <button><a href="ajouterFinanace.php">Ajouter financiere</a></button>

    <h2 class="mt-5">Mes Dons Financiers</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Montant</th>
                <th>Date de Don</th>
                <th>Mode de Paiement</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result_financial)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['montant']); ?></td>
                    <td><?= htmlspecialchars($row['date_don']); ?></td>
                    <td><?= htmlspecialchars($row['mode_paiement']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h2 class="mt-5">Mes Dons d'Équipements</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nom de l'Équipement</th>
                <th>Quantité</th>
                <th>Type d'Équipement</th>
                <th>État</th>
                <th>Disponibilité</th>
                <th>Date de Don</th>
                <th>Approuvé</th> <!-- New column for approval status -->
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result_equipment)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['quantite']); ?></td>
                    <td><?= htmlspecialchars($row['type_equipment']); ?></td>
                    <td><?= htmlspecialchars($row['etat']); ?></td>
                    <td><?= htmlspecialchars($row['disponabilite']); ?></td>
                    <td><?= htmlspecialchars($row['date_don']); ?></td>
                    <td><?= htmlspecialchars($row['approve']); ?></td> <!-- Display approval status -->
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>