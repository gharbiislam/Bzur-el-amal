<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

$isBeneficiary = isset($_SESSION['role']) && $_SESSION['role'] === 'beneficiaire';

$filters = [];
$query = "SELECT * FROM dons_equipment WHERE 1=1";

if (isset($_GET['disponabilite']) && !empty($_GET['disponabilite'])) {
    $disponabilite = mysqli_real_escape_string($conn, $_GET['disponabilite']);
    $filters[] = "disponabilite = '$disponabilite'";
}

if (isset($_GET['type_equipment']) && !empty($_GET['type_equipment'])) {
    $type_equipment = mysqli_real_escape_string($conn, $_GET['type_equipment']);
    $filters[] = "type_equipment = '$type_equipment'";
}

if (isset($_GET['etat']) && !empty($_GET['etat'])) {
    $etat = mysqli_real_escape_string($conn, $_GET['etat']);
    $filters[] = "etat = '$etat'";
}

if (count($filters) > 0) {
    $query .= " AND " . implode(" AND ", $filters);
}

$query .= " AND approve = 'oui'";

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .filter-sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #f8f9fa;
            padding: 15px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        
        

        .filter-sidebar .list-group-item {
            cursor: pointer;
            background-color: transparent;
            border: none;
            padding-left: 0;
        }

        .filter-sidebar .list-group-item:hover {
            background-color: #f1f1f1;
        }

        .content-area {
            margin-left: 270px;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .filter-sidebar {
                position: absolute;
                top: 0;
                left: -250px;
                z-index: 100;
            }

            .filter-sidebar.show {
                left: 0;
            }

            .content-area {
                margin-left: 0;
                padding: 15px;
            }

            .navbar-toggler {
                display: block;
            }

            .navbar-collapse {
                width: 100%;
            }
        }

    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="d-flex pt-5 container-fluid">
        <div class="filter-sidebar mt-5 pt-5 " id="filterSidebar">
            <h4>Filtres</h4>
            <div class="mb-3 ">
                <h5 class="d-flex justify-content-between align-items-center pb-3 border-bottom titre2" >
                    <a href="?reset_filters=true" class="nav-link">Tous</a>

                </h5></div>
            <!-- Disponibilité  -->
            <div class="mb-3 ">
                <h5 class="d-flex justify-content-between align-items-center pb-3 border-bottom titre2" >
                    Disponibilité
                    <button class="btn btn-sm btn-link" data-bs-toggle="collapse" data-bs-target="#disponabilite-list">
                        <i class="fas fa-caret-down titre2 "></i>
                    </button>
                </h5>
                <div id="disponabilite-list" class="collapse">
                    <ul class="list-group">
                        <li class="list-group-item"><a class="nav-link" href="?disponabilite=disponible">Disponible</a></li>
                        <li class="list-group-item"><a class="nav-link" href="?disponabilite=indisponible">Indisponible</a></li>
                    </ul>
                </div>
            </div>

            <!-- équipement  -->
            <div class="mb-3">
                <h5 class="d-flex justify-content-between align-items-center pb-3 border-bottom titre2">
                    Type d'équipement
                    <button class="btn btn-sm btn-link" data-bs-toggle="collapse" data-bs-target="#type-equipment-list">
                        <i class="fas fa-caret-down"></i>
                    </button>
                </h5>
                <div id="type-equipment-list" class="collapse">
                    <ul class="list-group">
                        <li class="list-group-item "><a class="nav-link" href="?type_equipment=béquilles">Béquilles</a></li>
                        <li class="list-group-item"><a class="nav-link" href="?type_equipment=chaise roulante">Chaise roulante</a></li>
                        <li class="list-group-item"><a class="nav-link" href="?type_equipment=prothese jambe">Prothèse jambe</a></li>
                        <li class="list-group-item"><a class="nav-link" href="?type_equipment=prothese main">Prothèse main</a></li>
                        <li class="list-group-item"><a class="nav-link" href="?type_equipment=bandage">Bandage</a></li>
                        <li class="list-group-item"><a class="nav-link" href="?type_equipment=autre">Autre</a></li>
                    </ul>
                </div>
            </div>

            <!-- État  -->
            <div class="mb-3  ">
                <h5 class="d-flex justify-content-between align-items-center pb-3 border-bottom titre2">
                    État
                    <button class="btn btn-sm btn-link" data-bs-toggle="collapse" data-bs-target="#etat-list">
                        <i class="fas fa-caret-down"></i>
                    </button>
                </h5>
                <div id="etat-list" class="collapse">
                    <ul class="list-group">
                        <li class="list-group-item"><a class="nav-link" href="?etat=neuf">Neuf</a></li>
                        <li class="list-group-item"><a class="nav-link" href="?etat=occasion">Occasion</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="content-area ">
            <button class="btn btn-primary d-md-none" id="toggleSidebarBtn">
                <i class="fas fa-bars"></i> Filtres
            </button>

            <h1 class="text-warning my-4">Liste des équipements médicaux</h1>
            <div class="row ">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card">
                            <?php if (!empty($row['image_path'])): ?>
                                <img src="<?= htmlspecialchars($row['image_path']); ?>" class="card-img-top " alt="<?= htmlspecialchars($row['name']); ?>" height="">
                            <?php else: ?>
                                <img src="default.jpg" class="card-img-top" alt="Pas d'image disponible">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['name']); ?></h5>
                                <p class="card-text">
                                    <strong>Disponibilité:</strong> <?= htmlspecialchars($row['disponabilite']); ?>
                                </p>
                                <a href="equipmentDetails.php?id=<?= urlencode($row['id_equipment']); ?>" class="btn detailsBtn">
                                    Voir les détails
                                </a>
                                
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
     <script src="../assets/js/index.js"></script>
    <script>
        
        document.getElementById('toggleSidebarBtn').addEventListener('click', function() {
            var sidebar = document.getElementById('filterSidebar');
            sidebar.classList.toggle('show');
        });
    </script>
</body>
</html>
