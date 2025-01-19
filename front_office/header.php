<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Site Header</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="mb-5">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="../assets/images/logo/logo1.png" alt="Logo" width="150">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <a class="navbar-brand" href="index.php">
                        <img src="../assets/images/logo/logomobile2.png" alt="Mobile Logo" width="50">
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <li class="nav-item">
        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" id="nav-link" href="index.php">Accueil</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : '' ?>" id="nav-link" href="about.php">À propos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'actions.php' ? 'active' : '' ?>" id="nav-link" href="actions.php">Nos actions</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'equipment.php' ? 'active' : '' ?>" id="nav-link" href="equipment.php">Équipement</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'contactt.php' ? 'active' : '' ?>" id="nav-link" href="contact.php">contact</a>
    </li>
</ul>


                    <div>
                        <?php if (isset($_SESSION['id'])): ?>
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Bienvenue, <?= htmlspecialchars($_SESSION['name']); ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <?php if ($_SESSION['role'] === 'donateur'): ?>
                                        <li><a class="dropdown-item" href="donateur.php">Espace Donateur</a></li>
                                    <?php elseif ($_SESSION['role'] === 'beneficiaire'): ?>
                                        <li><a class="dropdown-item" href="bene.php">Espace Bénéficiaire</a></li>
                                    <?php endif; ?>
                                    <li><a class="dropdown-item" href="edit.php">Modifier Profil</a></li>
                                    <li><a class="dropdown-item" href="logout.php">Déconnexion</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <div class="d-flex">
                                <a href="login.php" class="btn  me-2" id="btn1">Se connecter</a>
                                <a href="signUp.php" class="btn " id="btn2">Créer un compte</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</body>
</html>
