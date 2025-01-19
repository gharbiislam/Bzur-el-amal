<?php
include 'db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$isBeneficiary = isset($_SESSION['role']) && $_SESSION['role'] === 'beneficiaire';

if (isset($_GET['id'])) {
    $equipment_id = mysqli_real_escape_string($conn, $_GET['id']);
    
    $query = "SELECT * FROM dons_equipment WHERE id_equipment = '$equipment_id' AND approve = 'oui'";
    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) === 0) {
        die("Équipement non trouvé.");
    }

    $row = mysqli_fetch_assoc($result);
} else {
    die("Aucun identifiant d'équipement spécifié.");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'équipement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="bg-light">
<?php include 'header.php'; ?>

<div class="container mt-5 pt-4">
    <div class="row">
        <div class="col-md-6 row align-items-center text-center  p-5">
            <?php if (!empty($row['image_path'])): ?>
                <img src="<?= htmlspecialchars($row['image_path']); ?>" class="img-fluid rounded-1 shadow-sm p-5 " alt="<?= htmlspecialchars($row['name']); ?>">
            <?php else: ?>
                <img src="default.jpg" class="img-fluid rounded-3 shadow-sm" alt="Pas d'image disponible">
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <h1 class="fw-bold">Détails de l'équipement</h1>
            <h3 class="text-warning"><?= htmlspecialchars($row['name']); ?></h3>
            <p><strong>État:</strong> <?= htmlspecialchars($row['etat']); ?></p>
            <p><strong>Type d'équipement:</strong> <?= htmlspecialchars($row['type_equipment']); ?></p>
            <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($row['description'])); ?></p>
            <p><strong>Quantité disponible:</strong> <?= htmlspecialchars($row['quantite']); ?></p>
            <p><strong>Disponibilité:</strong> <?= htmlspecialchars($row['disponabilite']); ?></p>

            <?php if ($isBeneficiary): ?>
                <form action="request.php" method="POST">
                    <input type="hidden" name="equipment_id" value="<?= htmlspecialchars($row['id_equipment']); ?>">
                    <button type="submit" class="btn btn-warning w-100 mt-3" <?= ($row['disponabilite'] === 'indisponible') ? 'disabled' : ''; ?>>
                        Demander
                    </button>
                </form>

                <div class="alert alert-warning mt-3">
                    <h5 class="text-warning"><i class="fas fa-triangle-exclamation"></i> Attention</h5>
                    <p>Veuillez noter que l'envoi de votre demande ne garantit pas son acceptation. Chaque demande sera examinée et évaluée selon les critères en vigueur, après un tri minutieux des cas.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
mysqli_close($conn);
?>
