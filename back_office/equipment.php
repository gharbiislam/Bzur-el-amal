<?php
session_start();

include 'db.php';


if (isset($_GET['id'])) {
    $id_equipment = intval($_GET['id']);
    $delete_sql = "DELETE FROM dons_equipment WHERE id_equipment = ?";
    
    if ($stmt = mysqli_prepare($conn, $delete_sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $id_equipment);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

if (isset($_GET['toggle_id'])) {
    $toggle_id = intval($_GET['toggle_id']); 
    $availability_sql = "UPDATE dons_equipment SET disponabilite = CASE 
                            WHEN disponabilite = 'disponible' THEN 'indisponible' 
                            ELSE 'disponible' 
                        END 
                        WHERE id_equipment = ?";
    
    if ($stmt = mysqli_prepare($conn, $availability_sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $toggle_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

if (isset($_GET['approve_id'])) {
    $approve_id = intval($_GET['approve_id']); 
    $approve_sql = "UPDATE dons_equipment SET approve = 'oui' WHERE id_equipment = ?";
    
    if ($stmt = mysqli_prepare($conn, $approve_sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $approve_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

$sql = "
    SELECT 
        dons_equipment.*, 
        users.name AS donor_name 
    FROM 
        dons_equipment 
    JOIN 
        donateur ON dons_equipment.id_donateur = donateur.id_donateur 
    JOIN 
        users ON donateur.user_id = users.id
";
$result = mysqli_query($conn, $sql);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des équipements donnés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha384-3g2g4n9eQq8D5Q6gL9qZg6hJb9w3kQ5kz3H5dR9m+0Cj+0R5F5F5b5G5c5F5g5F" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#equipmentTable').DataTable();
        });

        function confirmDelete(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cet équipement ?")) {
                window.location.href = '?id=' + id; 
            }
        }

        function toggleAvailability(id) {
            if (confirm("Êtes-vous sûr de vouloir changer la disponibilité de cet équipement ?")) {
                window.location.href = '?toggle_id=' + id; 
            }
        }

        function approveEquipment(id) {
            if (confirm("Êtes-vous sûr de vouloir approuver cet équipement ?")) {
               window.location.href = '?approve_id=' + id; 
            }
        }
    </script>
</head>
<body class="container">
    <h1 class="my-4">Liste des équipements donnés</h1>
    <table id="equipmentTable" class="display table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nom du Donateur</th>
                <th>Nom de l'Équipement</th>
                <th>Type d'équipement</th>
                <th>Quantité</th>
                <th>État</th>
                <th>Description</th>
                <th>Image</th>
                <th>Date de donation</th>
                <th>Disponibilité</th>
                <th>Approuvé</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['donor_name']); ?></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['type_equipment']); ?></td>
                    <td><?= $row['quantite']; ?></td>
                    <td><?= htmlspecialchars($row['etat']); ?></td>
                    <td><?= htmlspecialchars($row['description']); ?></td>
                    <td>
                        <?php if (!empty($row['image_path'])): ?>
                            <img src="<?= $row['image_path']; ?>" alt="Image" width="100">
                        <?php else: ?>
                            Pas d'image
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['date_don']); ?></td>
                    <td><?= htmlspecialchars($row['disponabilite']); ?></td>
                    <td><?= htmlspecialchars($row['approve']); ?></td>
                    <td>
                        <?php if ($row['approve'] === 'oui'): ?>
                            <button class="btn btn-secondary" disabled>
                                Approuvé
                            </button>
                        <?php else: ?>
                            <button class="btn btn-success" onclick="approveEquipment(<?= $row['id_equipment']; ?>)">
                                Approuver
                            </button>
                        <?php endif; ?>
                        <button class="btn btn-warning" onclick="toggleAvailability(<?= $row['id_equipment']; ?>)">
                         Disponibilité
                        </button>
                        <button class="btn btn-info" onclick="confirmDelete(<?= $row['id_equipment']; ?>)">
                            Supprimer
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>