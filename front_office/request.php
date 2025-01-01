<?php
session_start();
include 'db.php';
include 'header.php';



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
    header("Location: equipment.php");
    exit;
}

if (isset($_POST['submit_request'])) {
    $document = $_FILES['document']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($document);
    
    if (move_uploaded_file($_FILES['document']['tmp_name'], $target_file)) {
        $date_demande = date('Y-m-d H:i:s');

        $adress = mysqli_real_escape_string($conn, $_POST['adress']);
        $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
        
        $update_user_query = "UPDATE users SET adress = '$adress', phone_number = '$phone_number' WHERE id = '$beneficiary_id'";
        
        if (mysqli_query($conn, $update_user_query)) {
            $insert_request_query = "INSERT INTO requests (user_id, id_equipment, date_demande, approved, documents) VALUES ('$beneficiary_id', '$equipment_id', '$date_demande', 'En attente', '$target_file')";
            
            if (mysqli_query($conn, $insert_request_query)) {
                $_SESSION['message'] = "Demande d'équipement envoyée avec succès.";
                header("Location: equipment.php");
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de l'envoi de la demande: " . mysqli_error($conn);
            }
        } else {
            $_SESSION['error'] = "Erreur lors de la mise à jour des informations: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error'] = "Erreur lors du téléchargement du document.";
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
</head>
<body class="container">
    <h1>Demande d'équipement</h1>

    <div class="row">
        <div class="col-md-6">
            <img class="details-image" src="<?= htmlspecialchars($equipment['image_path']); ?>" alt="Image" style="width: 100%;">
        </div>
        <div class="col-md-6">
            <h5 class="details-name"><?= htmlspecialchars($equipment['name']); ?></h5>
            <p class="details-beneficiary-name">Nom du bénéficiaire: <input type="text" value="<?= htmlspecialchars($beneficiary['name']); ?>" disabled></p>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="equipment_id" value="<?= htmlspecialchars($equipment['id_equipment']); ?>">
                <div class="mb-3">
                    <label for="adress" class="form-label">Adresse du bénéficiaire:</label>
                    <input type="text" class="form-control" name="adress" id="adress" value="<?= htmlspecialchars($beneficiary['adress']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Numéro de téléphone du bénéficiaire:</label>
                    <input type=" text" class="form-control" name="phone_number" id="phone_number" value="<?= htmlspecialchars($beneficiary['phone_number']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="document" class="form-label">Télécharger un document:</label>
                    <input type="file" class="form-control" name="document" id="document" required>
                </div>
                <button type="submit" name="submit_request" class="btn btn-success">Valider</button>
            </form>
        </div>
    </div>

    <?php
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);}
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']); 
    }

    mysqli_close($conn);
    ?>
</body>
</html>