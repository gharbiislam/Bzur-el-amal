<?php

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.3/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.3/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <div class="d-flex flex-column flex-lg-row">
        <div class="col-lg-2 d-none d-lg-block">
            <?php include('nav.php'); ?>
        </div>
        <div class="px-2 col-lg-10">
            <h2 class="my-4" id="back-title">Liste des équipements donnés</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered nowrap" style="width: 100%;" id="donateursTable">
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
                                        <button class="btn btn-sm btn-secondary" disabled>
                                            <i class="fas fa-check"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-success" onclick="approveEquipment(<?= $row['id_equipment']; ?>)">
                                            <i class="fas fa-hourglass"></i>
                                        </button>
                                    <?php endif; ?>
                                    <button class="btn btn-sm btn-warning" onclick="toggleAvailability(<?= $row['id_equipment']; ?>)">
                                        Disponibilité
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $row['id_equipment']; ?>)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#donateursTable').DataTable({
                responsive: true,
                pageLength: 4
            });
        });

        window.confirmDelete = function(id) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Vous ne pourrez pas revenir en arrière !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '?id=' + id; 
                }
            });
        };

        window.toggleAvailability = function(id) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Voulez-vous changer la disponibilité de cet équipement ?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, changer !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '?toggle_id=' + id; 
                }
            });
        };

        window.approveEquipment = function(id) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Voulez-vous approuver cet équipement ?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, approuver !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '?approve_id=' + id; 
                }
            });
        };
    </script>
</body>
</html>
