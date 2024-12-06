<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "account");

if (!$conn) {
    die("Connexion échouée : " . mysqli_connect_error());
}

// Check if the user is a beneficiary
$isBeneficiary = isset($_SESSION['role']) && $_SESSION['role'] === 'beneficiaire';

$filters = [];
$query = "SELECT * FROM dons_equipment WHERE 1=1";

// Filtrage par disponibilité
if (isset($_GET['disponabilite']) && !empty($_GET['disponabilite'])) {
    $disponabilite = mysqli_real_escape_string($conn, $_GET['disponabilite']);
    $filters[] = "disponabilite = '$disponabilite'";
}

// Filtrage par type d'équipement
if (isset($_GET['type_equipment']) && !empty($_GET['type_equipment'])) {
    $type_equipment = mysqli_real_escape_string($conn, $_GET['type_equipment']);
    $filters[] = "type_equipment = '$type_equipment'";
}

// Filtrage par état
if (isset($_GET['etat']) && !empty($_GET['etat'])) {
    $etat = mysqli_real_escape_string($conn, $_GET['etat']);
    $filters[] = "etat = '$etat'";
}

// Appliquer les filtres au SQL
if (count($filters) > 0) {
    $query .= " AND " . implode(" AND ", $filters);
}

// Filter for approved equipment
$query .= " AND approve = 'oui'"; // Only select approved equipment

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Erreur dans la requête SQL : " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des équipements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #details-section {
            display: none;
            z-index: 1000;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body class="container">
<?php include 'header.php'; ?>

    <h1 class="mt-4 pt-5">Liste des équipements médicaux</h1>

    <!-- Formulaire de filtre -->
    <form method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="disponabilite" class="form-label">Disponibilité:</label>
                <select id="disponabilite" name="disponabilite" class="form-control">
                    <option value="">Tous</option>
                    <option value="disponible">Disponible</option>
                    <option value="indisponible">Indisponible</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="type_equipment" class="form-label">Type d'équipement:</label>
                <select id="type_equipment" name="type_equipment" class="form-control">
                    <option value="">Tous</option>
                    <option value="béquilles">Béquilles</option>
                    <option value="chaise roulante">Chaise roulante</option>
                    <option value="prothese jambe">Prothèse jambe</option>
                    <option value="prothese main">Prothèse main</option>
                    <option value="bandage">Bandage</option>
                    <option value="autre">Autre</option>
                </select>
            </div>
            <div class=" col-md-4">
                <label for="etat" class="form-label">État:</label>
                <select id="etat" name="etat" class="form-control">
                    <option value="">Tous</option>
                    <option value="neuf">Neuf</option>
                    <option value="occasion">Occasion</option>
                </select>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Filtrer</button>
        </div>
    </form>

    <!-- Grille des équipements -->
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100" onclick="showDetails(<?= htmlspecialchars(json_encode($row)); ?>)">
                    <?php if (!empty($row['image_path'])): ?>
                        <img src="<?= htmlspecialchars($row['image_path']); ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']); ?>">
                    <?php else: ?>
                        <img src="default.jpg" class="card-img-top" alt="Pas d'image disponible">
                    <?php endif; ?>
                    <div class="card-body">
    <h5 class="card-title"><?= htmlspecialchars($row['name']); ?></h5>
    <p class="card-text">
        <strong>Disponibilité:</strong> <?= htmlspecialchars($row['disponabilite']); ?>
    </p>
    <?php if ($isBeneficiary): ?>
        <form action="request.php" method="POST">
            <input type="hidden" name="equipment_id" value="<?= htmlspecialchars($row['id_equipment']); ?>">
            <button type="submit" class="btn btn-success" 
                <?= ($row['disponabilite'] === 'indisponible') ? 'disabled' : ''; ?>>
                Demander
            </button>
        </form>
    <?php endif; ?>
</div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Detailed Section -->
    <div id="details-section">
        <div class="row">
            <div class="col-md-6">
                <img class="details-image" src="" alt="Image" style="width: 100%;">
            </div>
            <div class="col-md-6">
                <h5 class="details-name"></h5>
                <p class="details-type"></p>
                <p class="details-state"></p>
                <p class="details-availability"></p>
                <p class="details-quantity"></p>
                <p class="details-date"></p>
                <button onclick="document.getElementById('details-section').style.display='none';" class="btn btn-secondary">Fermer</button>
            </div>
        </div>
    </div>

    <script>
    function showDetails(product) {
        const detailsSection = document.getElementById('details-section');
        detailsSection.style.display = 'block'; // Show the details section

        // Populate the details
        detailsSection.querySelector('.details-image').src = product.image_path || 'default.jpg';
        detailsSection.querySelector('.details-name').innerText = product.name;
        detailsSection.querySelector('.details-type').innerText = 'Type: ' + product.type_equipment;
        detailsSection.querySelector('.details-state').innerText = 'État: ' + product.etat;
        detailsSection.querySelector('.details-availability').innerText = 'Disponibilité: ' + product.disponabilite;
        detailsSection.querySelector('.details-quantity').innerText = 'Quantité: ' + product.quantite;
        detailsSection.querySelector('.details-date').innerText = 'Donné le: ' + product.date_don;
    }
    </script>

</body>
</html>

<?php
// Close connection
mysqli_close($conn);
?>

    
</body>
</html>