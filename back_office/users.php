<?php
include 'db.php';

$query = "SELECT users.id, users.name, users.email, users.pass, users.adress, users.created_at, users.phone_number, donateur.date_dernier_don
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
    <!-- Include the main Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body class="">

    <div class="d-flex flex-column flex-lg-row ">
        <div class="col-lg-2 d-none d-lg-block ">
            <?php
            include('nav.php');

            ?>
        </div>
        <div class=" col-lg-10 container-fluid">
        <h2 id="back-title" class="my-4">Liste des Donateurs</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered nowrap  mt-5 " style="width: 100%;" id="donateursTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Adresse</th>
                            <th>Date de Création du Compte</th>
                            <th>Téléphone</th>
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
                                    <td><?= $donateur['date_dernier_don'] ?></td>
                                    <td>
                                        <a href="edit_donateur.php?id=<?= $donateur['id'] ?>" class="btn btn-sm" id="navBtn" onclick="return confirmEdit('beneficiaire')">
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
                            <tr>
                                <td colspan="10">No Donateurs found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <h2 id="back-title" class="my-4">Liste des Bénéficiaires</h2>
            <div class="table-responsive">

                <table class="table table-striped table-bordered nowrap" style="width: 100%;" id="beneficiairesTable">
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
                                        <a href="edit_beneficiaire.php?id=<?= $beneficiaire['id'] ?>" class="btn  btn-sm" id="navBtn" onclick="return confirmEdit('beneficiaire')" >
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
                            <tr>
                                <td colspan="10">No Bénéficiaires found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#donateursTable').DataTable({
                responsive: true,
                pageLength: 5
            });
            $('#beneficiairesTable').DataTable({
                responsive: true,
                pageLength: 5
            });
        });
        function confirmEdit(type) {
        if (type === 'donateur') {
            return confirm("Are you sure you want to edit this Donateur?");
        } else if (type === 'beneficiaire') {
            return confirm("Are you sure you want to edit this Bénéficiaire?");
        }
    }
    
    </script>
   
</body>

</html>

<?php
mysqli_close($conn);

?>