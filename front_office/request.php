<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';
include 'header.php';
$message="";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipment_id = mysqli_real_escape_string($conn, $_POST['equipment_id']);
    $beneficiary_id = $_SESSION['id']; 

    $equipment_query = "SELECT * FROM dons_equipment WHERE id_equipment = '$equipment_id'";
    $equipment_result = mysqli_query($conn, $equipment_query);
    $equipment = mysqli_fetch_assoc($equipment_result);

    $beneficiary_query = "SELECT * FROM users WHERE id = '$beneficiary_id'";
    $beneficiary_result = mysqli_query($conn, $beneficiary_query);
    $beneficiary = mysqli_fetch_assoc($beneficiary_result);
} else {
    header("Location: request.php");
    exit;
}

if (isset($_POST['submit_request'])) {
    $document = null;
    $target_file = null;

    if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
        $document = $_FILES['document']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($document);
        
        $allowed_types = ['application/pdf']; 
        if (in_array($_FILES['document']['type'], $allowed_types)) {
            if (!move_uploaded_file($_FILES['document']['tmp_name'], $target_file)) {
                $_SESSION['error'] = "Erreur lors du téléchargement du document.";
                header("Location: request.php");
                exit;
            }
        } else {
            $_SESSION['error'] = "Le fichier téléchargé n'est pas un document valide.";
            header("Location: request.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Aucun document téléchargé.";
        header("Location: request.php");
        exit;
    }

    $date_demande = date('Y-m-d H:i:s');
    $adress = mysqli_real_escape_string($conn, $_POST['adress']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);

    $update_user_query = "UPDATE users SET adress = '$adress', phone_number = '$phone_number' WHERE id = '$beneficiary_id'";

    if (mysqli_query($conn, $update_user_query)) {
        $insert_request_query = "INSERT INTO requests (user_id, id_equipment, date_demande, approved, documents) 
                                  VALUES ('$beneficiary_id', '$equipment_id', '$date_demande', 'En attente', '$target_file')";

        if (mysqli_query($conn, $insert_request_query)) {
            $message = "Demande d'équipement envoyée avec succès.";
            header("Location: equipment.php");
            exit;
        } else {
            $_SESSION['error'] = "Erreur lors de l'envoi de la demande: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error'] = "Erreur lors de la mise à jour des informations: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande d'équipement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'header.php'; ?>

    <div class="container mt-5 pt-4">
        <div class="row">
            <div class="col-md-6 row align-items-center text-center mb-4 container">
                <img src="<?= isset($equipment['image_path']) ? htmlspecialchars($equipment['image_path']) : 'default-image.jpg'; ?>" alt="Image de l'équipement" class="img-fluid rounded-1 shadow-sm p-5">
            </div>

            <div class="col-md-6">
                <h1 class="fw-bold">Demande d'équipement</h1>
                <h2 class="text-warning"><?= htmlspecialchars($equipment['name']); ?></h2>

                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="equipment_id" value="<?= htmlspecialchars($equipment['id_equipment']); ?>">

                    <div class="mb-3">
                        <label for="adress" class="form-label fw-bold">Adresse du bénéficiaire:</label>
                        <input type="text" class="form-control" name="adress" id="adress" value="<?= htmlspecialchars($beneficiary['adress']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label fw-bold">Numéro de téléphone du bénéficiaire:</label>
                        <input type="text" class="form-control" name="phone_number" id="phone_number" value="<?= htmlspecialchars($beneficiary['phone_number']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="document" class="form-label fw-bold">Télécharger un document:</label>
                        <div class="input-group">
                            <input type="file" class="form-control" name="document" id="file-upload" aria-label="Upload" />
                            <span class="input-group-text bg-warning">
                                <i class="bi bi-upload text-white text-center"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" name="submit_request" class="btn btn-warning w-100">Valider</button>
                </form>
            </div>
        </div>

       <?php if (isset($message)): ?>
            <div class="alert alert-success text-center">
                <i class="bi bi-check-circle px-2"></i> <?= $message; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
mysqli_close($conn);
?>
