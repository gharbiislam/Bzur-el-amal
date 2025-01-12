<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include 'db.php';


if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'beneficiaire') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_equipment = mysqli_real_escape_string($conn, $_POST['id_equipment']);
    $id_beneficiaire = $_SESSION['id']; 

    if (isset($_FILES['documents']) && $_FILES['documents']['error'] == 0) {
        $file_tmp = $_FILES['documents']['tmp_name'];
        $file_name = $_FILES['documents']['name'];
        $file_path = 'uploads/' . basename($file_name);

        if (move_uploaded_file($file_tmp, $file_path)) {
            $sql_request = "INSERT INTO requests (id_beneficaire, id_equipment, date_demande, approved, documents) VALUES ('$id_beneficiaire', '$id_equipment', NOW(), 'En attente', '$file_path')";
            if (mysqli_query($conn, $sql_request)) {
                echo "Demande soumise avec succès.";
            } else {
                echo "Erreur lors de la soumission de la demande: " . mysqli_error($conn);
            }
        } else {
            echo "Erreur lors du téléchargement du fichier.";
        }
    } else {
        echo "Aucun fichier téléchargé ou erreur de téléchargement.";
    }
} else {
    echo "Méthode de requête non valide.";
}

mysqli_close($conn);
?>