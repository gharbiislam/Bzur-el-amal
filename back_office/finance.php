<?php

include 'db.php';

if (isset($_GET['id'])) {
    $id_finance = intval($_GET['id']);
    $delete_sql = "DELETE FROM dons_financieres WHERE id_finance = ?";

    if ($stmt = mysqli_prepare($conn, $delete_sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $id_finance);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

if (isset($_GET['approve_id'])) {
    $approve_id = intval($_GET['approve_id']); 
    $approve_sql = "UPDATE dons_financieres SET approve = 'oui' WHERE id_finance = ?";

    if ($stmt = mysqli_prepare($conn, $approve_sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $approve_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

$sql = "
    SELECT 
        dons_financieres.*, 
        users.name AS donor_name
    FROM 
        dons_financieres
    JOIN 
        donateur ON dons_financieres.id_donateur = donateur.id_donateur
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
    <title>Liste des finances</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <!-- SweetAlert2 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.3/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.3/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <div class="d-flex flex-column flex-lg-row">
        <div class="col-lg-2 d-none d-lg-block">
            <?php include('nav.php'); ?>
        </div>
        <div class="px-2 col-lg-10">
            <h2 class="my-4" id="back-title">Liste des finances</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered nowrap" style="width: 100%;" id="financesTable">
                    <thead>
                        <tr>
                            <th>Nom du Donateur</th>
                            <th>Montant</th>
                            <th>Date de Donation</th>
                            <th>Mode de Paiement</th>
                            <th>Catégorie</th>
                            <th>Approuvé</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['donor_name']); ?></td>
                                <td><?= $row['montant']; ?> TDN</td>
                                <td><?= htmlspecialchars($row['date_don']); ?></td>
                                <td><?= htmlspecialchars($row['mode_paiement']); ?></td>
                                <td><?= htmlspecialchars($row['categorie']); ?></td>
                                <td><?= htmlspecialchars($row['approve']); ?></td>
                                <td>
                                    <?php if ($row['approve'] === 'oui'): ?>
                                        <button class="btn btn-sm btn-secondary" disabled>
                                            <i class="fas fa-check"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-success" onclick="approveFinance(<?= $row['id_finance']; ?>)">
                                            <i class="fas fa-hourglass"></i>
                                        </button>
                                    <?php endif; ?>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $row['id_finance']; ?>)">
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
            $('#financesTable').DataTable({
                responsive: true,
            });

        });

        function confirmDelete(id) {
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
        }

        function approveFinance(id) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Voulez-vous approuver cette finance ?",
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
        }
    </script>
</body>
</html>
