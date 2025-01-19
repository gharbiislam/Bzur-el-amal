<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';
include 'header.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['id'];
    $donateur_sql = "SELECT id_donateur FROM donateur WHERE user_id = '$user_id'";
    $donateur_result = mysqli_query($conn, $donateur_sql);

    if (!$donateur_result) {
        $message = "Erreur dans la requête SQL : " . mysqli_error($conn);
    } elseif ($donateur_row = mysqli_fetch_assoc($donateur_result)) {
        $id_donateur = $donateur_row['id_donateur'];

        $name = $_POST['name'];
        $quantite = $_POST['quantite'];
        $etat = $_POST['etat'];
        $type_equipment = $_POST['type_equipment'];

        if ($type_equipment === 'autre' && !empty($_POST['autre_type'])) {
            $type_equipment = $_POST['autre_type'];
        }

        $description = $_POST['description'];
        $image_path = "";

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $upload_dir = "uploads/";

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $image_name = basename($_FILES['image']['name']);
            $image_path = $upload_dir . $image_name;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                $message = "Erreur lors de l'upload du fichier.";
                $image_path = "";
            }
        }

        
$sql = "INSERT INTO dons_equipment (id_donateur, name, quantite, etat, date_don, image_path, type_equipment, description) 
VALUES ('$id_donateur', '$name', '$quantite', '$etat', NOW(), '$image_path', '$type_equipment', '$description')";
        if (mysqli_query($conn, $sql)) {
            $message = "Équipement ajouté avec succès.";
        } else {
            $message = "Erreur lors de l'ajout de l'équipement : " . mysqli_error($conn);
        }
    } else {
        $message = "Erreur : Vous n'êtes pas enregistré comme donateur.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un équipement médical</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/index.js"></script>
</head>
<body>
    <div class="d-lg-flex mt-5">
        <div class="col-lg-7">
            <img src="../assets/images/bg/equipment.png" alt="" class="bg-image d-none d-lg-block img-fluid position-fixed col-lg-7">
            <img src="../assets/images/bg/equipment2.png" alt="" class="bg-image2 d-lg-none img-fluid w-sm-50">
        </div>
        <div class="col-lg-5 px-5 mt-2">
            <h2 class="titre2 py-3 text-center">Ajouter un équipement médical</h2>
            <?php if ($message): ?>
                <div class="alert alert-success"><i class="bi bi-check px-2"></i> <?= $message; ?></div>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="row">
                    <div class="mb-3 col-lg-6">
                        <label for="type_equipment" class="form-label">Type d'équipement:</label>
                        <select id="type_equipment" name="type_equipment" class="form-control" onchange="toggleAutreField()" required>
                            <option value="béquilles">Béquilles</option>
                            <option value="chaise roulante">Chaise roulante</option>
                            <option value="prothese jambe">Prothèse jambe</option>
                            <option value="prothese main">Prothèse main</option>
                            <option value="bandage">Bandage</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    <div class="mb-3 col-lg-6">
                        <label for="etat" class="form-label">État:</label>
                        <select id="etat" name="etat" class="form-control" required>
                            <option value="neuf">Neuf</option>
                            <option value="occasion">Occasion</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="quantite" class="form-label">Quantité:</label>
                    <input type="number" id="quantite" name="quantite" class="form-control" required>
                </div>
                <div class="mb-3" id="autre_input" style="display: none;">
                    <label for="autre_type" class="form-label">Veuillez préciser:</label>
                    <input type="text" id="autre_type" name="autre_type" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image (facultative):</label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="file-upload" aria-label="Upload" />
                        <span class="input-group-text bg-warning">
                            <i class="bi bi-upload text-white text-center"></i>
                        </span>
                    </div>
                </div>
                <div class="text-center">
                    <a href="donateur.php" class="btn" id="btn1">Annuler</a>
                    <input type="submit" value="Ajouter" class="btn" id="btn2">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
