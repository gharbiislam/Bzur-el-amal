<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-3 fixed-top text-white"> 
    <div class="container">
<a class="navbar-brand" href="index.php">
            <img src="http://localhost/dashboard/pfa/assets/images/logo/logo.png" alt="logo" width="100px">
        </a>
        <ul class="navbar-nav">
            <li class="nav-item"> 
                <a class="nav-link" href="#">Nos principes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">A propos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="equipment.php">Equipment</a>
            </li>
        </ul>
        
        <?php if (isset($_SESSION['id'])): ?>
            <div class="dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Bienvenue, <?php echo htmlspecialchars($_SESSION['name']); ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <?php if ($_SESSION['role'] === 'donateur'): ?>
                        <li><a class="dropdown-item" href="donateur.php">Espace Donateur</a></li>
                    <?php elseif ($_SESSION['role'] === 'beneficiaire'): ?>
                        <li><a class="dropdown-item" href="bene.php">Espace Bénéficiaire</a></li>
                    <?php endif; ?>
                    <li><a class="dropdown-item" href="edit.php">Edit Profile</a></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="connexion.php" class="nav-link">Connexion</a>
        <?php endif; ?>
    </div>
</nav>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Ensure dropdown works correctly after page load
    document.addEventListener("DOMContentLoaded", function() {
        var dropdowns = document.querySelectorAll('.dropdown-toggle');
        dropdowns.forEach(function (dropdown) {
            new bootstrap.Dropdown(dropdown);
        });
    });
</script>
</body>
</html>
