<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donateur Interface</title>
    meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de Bénéficiaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">

</head>

<div>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include 'header.php';
    include 'db.php';

    if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'donateur') {
        header("Location: login.php");
        exit;
    }

    $user_id = $_SESSION['id'];

    $sql_donateur = "SELECT id_donateur FROM donateur WHERE user_id = '$user_id'";
    $result_donateur = mysqli_query($conn, $sql_donateur);

    if ($result_donateur && mysqli_num_rows($result_donateur) > 0) {
        $donateur = mysqli_fetch_assoc($result_donateur);
        $donateur_id = $donateur['id_donateur'];

        $sql_financial = "SELECT * FROM dons_financieres WHERE id_donateur = '$donateur_id'";
        $result_financial = mysqli_query($conn, $sql_financial);

        $sql_equipment = "SELECT * FROM dons_equipment WHERE id_donateur = '$donateur_id'";
        $result_equipment = mysqli_query($conn, $sql_equipment);
    } else {
        echo "Aucun donateur trouvé pour cet utilisateur.";
        exit;
    }
    ?>

    <div id="dons" class="text-center pt-5 d-flex-row" id="bene" style="background-image: url('../assets/images/bg/about2.jpg');">
        <h1>Welcome to Donateur Interface</h1>
        <div >
            <a href="ajouterEquip.php" class="btn" id="btn2">Ajouter equipment</a>
            <a href="finance.php" class="btn" id="btn2">Ajouter financiere</a>
        </div>
    </div>
    <div class="container text-center mt-5">
        <h2 class="titre2">Historique de dons </h2>
        <p>Lorem ipsum dolor sit amet consectetur. Mauris ipsum phasellus purus.</p>
<div class="d-flex justify-content-start" >
        <a href="#" id="showEquipment" class="nav-link history active">Donations Financière</a>
        <a href="#" id="showFinance" class="mx-2 nav-link history">Donations Equipment</a></div>
        <div id="equipmentSection" class="mt-4">
            <table class="table">
                <thead>
                    <tr class="table-primary">
                        <th>Montant</th>
                        <th>Date de Don</th>
                        <th>Mode de Paiement</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_financial)): ?>
                        <tr class="table-warning">
                            <td><?= htmlspecialchars($row['montant']); ?></td>
                            <td><?= htmlspecialchars($row['date_don']); ?></td>
                            <td><?= htmlspecialchars($row['mode_paiement']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <div id="financeSection" class="mt-4 d-none">
            <table class="table">
                <thead>
                    <tr class="table-primary">
                        <th>Nom de l'Équipement</th>
                        <th>Quantité</th>
                        <th>Type d'Équipement</th>
                        <th>État</th>
                        <th>Disponibilité</th>
                        <th>Date de Don</th>
                        <th>Approuvé</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_equipment)): ?>
                        <tr class="table-warning">
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['quantite']); ?></td>
                            <td><?= htmlspecialchars($row['type_equipment']); ?></td>
                            <td><?= htmlspecialchars($row['etat']); ?></td>
                            <td><?= htmlspecialchars($row['disponabilite']); ?></td>
                            <td><?= htmlspecialchars($row['date_don']); ?></td>
                            <td><?= htmlspecialchars($row['approve']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div><?php include 'review.php' ?>
    </div>
</div>




</div>
<script src="../assets/js/index.js"></script>
<script>
    $(document).ready(function() {
    $(".history").on("click", function() {
        $(".history").removeClass("active");
        
        $(this).addClass("active");
    });
});
</script>
</body>

</html>

<?php
mysqli_close($conn);
?>