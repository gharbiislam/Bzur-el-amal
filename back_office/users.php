<?php
include 'db.php';

$query = "SELECT users.id, users.name, users.email, users.pass, users.adress, users.created_at, users.phone_number, donateur.type_don, donateur.date_dernier_don
          FROM users 
          JOIN donateur ON users.id = donateur.user_id
          WHERE users.role = 'donateur'";
$donateurs = mysqli_query($conn, $query);

$query2 = "SELECT users.id, users.name, users.email, users.pass, users.adress, users.created_at, users.phone_number, bénéficiaire.handicap_type, bénéficiaire.needs
          FROM users 
          JOIN bénéficiaire ON users.id = bénéficiaire.user_id
          WHERE users.role = 'beneficiaire'";
$beneficiaires = mysqli_query($conn, $query2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donateurs et Bénéficiaires</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Liste des Donateurs</h2>
        <table class="table table-bordered" id="donateursTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Adresse</th>
                    <th>Date de Création du Compte</th>
                    <th>Téléphone</th>
                    <th>Type de Don</th>
                    <th>Date de Dernière Donation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (mysqli_num_rows($donateurs) > 0): ?>
                <?php while ($donateur = mysqli_fetch_assoc($donateurs)): ?>
                        <tr>
                            <td><?= $donateur['id'] ?></td>
                            <td><?= $donateur['name'] ?></td>
                            <td><?= $donateur['email'] ?></td>
                            <td><?= $donateur['pass'] ?></td>
                            <td><?= $donateur['adress'] ?></td>
                            <td><?= $donateur['created_at'] ?></td>
                            <td><?= $donateur['phone_number'] ?></td>
                            <td><?= $donateur['type_don'] ?></td>
                            <td><?= $donateur['date_dernier_don'] ?></td>
                            <td>
                                <a href="edit_donateur.php?id=<?= $donateur['id'] ?>" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="delete_donateur.php?id=<?= $donateur['id'] ?>"
                                class="btn btn-danger btn-sm" 
                                 onclick="return confirm('Are you sure you want to delete this donateur?');">
                                
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="10">No Donateurs found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h2>Liste des Bénéficiaires</h2>
        <table class="table table-bordered" id="beneficiairesTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Adresse</th>
                    <th>Date de Création du Compte</th>
                    <th>Téléphone</th>
                    <th>Type de Handicap</th>
                    <th>Soutien Nécessaire</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            ody>
                <?php if (mysqli_num_rows($beneficiaires) > 0): ?>
                    <?php while ($beneficiaire = mysqli_fetch_assoc($beneficiaires)): ?>
                    
                        <tr>
                            <td><?= $beneficiaire['id'] ?></td>
                            <td><?= $beneficiaire['name'] ?></td>
                            <td><?= $beneficiaire['email'] ?></td>
                            <td><?= $beneficiaire['pass'] ?></td>
                            <td><?= $beneficiaire['adress'] ?></td>
                            <td><?= $beneficiaire['created_at'] ?></td>
                            <td><?= $beneficiaire['phone_number'] ?></td>
                            <td><?= $beneficiaire['handicap_type'] ?></td>
                            <td><?= $beneficiaire['needs'] ?></td>
                            <td>
                                <a href="edit_beneficiaire.php?id=<?= $beneficiaire['id'] ?>" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="delete_beneficiaire.php?id=<?= $beneficiaire['id'] ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Are you sure you want to delete this bénéficiaire?');">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="10">No Bénéficiaires found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#donateursTable').DataTable();
            $('#beneficiairesTable').DataTable();
        });
    </script>
</body>
</html>

<?php
mysqli_close($conn);

?>
