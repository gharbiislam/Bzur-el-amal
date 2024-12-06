<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "account");
if (!$conn) {
    die("Connexion échouée : " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_donateur = $_POST['id_donateur'];
    $montant = $_POST['montant'];
    $mode_paiement = $_POST['mode_paiement'];
    $date_don = date('Y-m-d');

    $sql = "INSERT INTO dons_financieres (id_donateur, montant, date_don, mode_paiement) 
            VALUES (?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'iiss', $id_donateur, $montant, $date_don, $mode_paiement);
        if (mysqli_stmt_execute($stmt)) {
            $success = "Donation added successfully.";
        } else {
            $error = "Error adding donation: " . mysqli_error($conn);
        }
    }
}

$user_id = $_SESSION['id'];
$query = "SELECT donateur.id_donateur, users.name 
          FROM donateur 
          JOIN users ON donateur.user_id = users.id 
          WHERE users.id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$donateur = mysqli_stmt_get_result($stmt)->fetch_assoc();

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Don Financier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container">
    <h1 class="my-4">Ajouter Don Financier</h1>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="donateur" class="form-label">Donateur</label>
            <input type="text" id="donateur" class="form-control" value="<?= htmlspecialchars($donateur['name']); ?>" disabled>
            <input type="hidden" name="id_donateur" value="<?= htmlspecialchars($donateur['id_donateur']); ?>">
        </div>
        <div class="mb-3">
            <label for="montant" class="form-label">Montant</label>
            <select id="montant" name="montant" class="form-control">
                <option value="50">50 DT</option>
                <option value="20">20 DT</option>
                <option value="10">10 DT</option>
                <option value="">Autre</option>
            </select>
            <input type="number" name="montant_custom" placeholder="Montant personnalisé" class="form-control mt-2">
        </div>
        <div class="mb-3">
            <label for="mode_paiement" class="form-label">Mode de Paiement</label>
            <select id="mode_paiement" name="mode_paiement" class="form-control" required>
                <option value="Carte Bancaire">Carte Bancaire</option>
                <option value="Virement">Virement</option>
                <option value="Espèces">Espèces</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</body>
</html>
