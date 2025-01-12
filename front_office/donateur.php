<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donateur Interface</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<div>
    <?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }    include 'header.php';
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
        <div>
            <a href="ajouterEquip.php">Ajouter equipment</a>
            <a href="ajouterFinanace.php">Ajouter financiere</a>
        </div>
    </div>
    <div class="container mt-5 pt-5">
        <h2 class="text-primary">Historique de dons </h2>
        <p>Lorem ipsum dolor sit amet consectetur. Mauris ipsum phasellus purus.</p>

        <a href="#" id="showEquipment" id="btn2">Demande Equipment</a>
        <a href="#" id="showFinance" id="btn1">Demande Financière</a>
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
    </div></div>
    </div>
    <script>
        document.getElementById('showEquipment').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('equipmentSection').classList.remove('d-none');
            document.getElementById('financeSection').classList.add('d-none');
        });

        document.getElementById('showFinance').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('equipmentSection').classList.add('d-none');
            document.getElementById('financeSection').classList.remove('d-none');
        });
    </script>

    </div>
    <script src="bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
mysqli_close($conn);
?>