<?php 

session_start();
include 'db.php';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">

    <title>Bootstrap Example</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="p-3 m-0 border-0 bd-example m-0 border-0 ">



    <nav class="navbar  navbar-expand-md  fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
            <img src="../assets/images/logo/logo1.png" alt="Logo"width="200" />

            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end " tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <a class="navbar-brand" href="index.php">
                        <img src="../assets/images/logo/logomobile2.png" alt="logo" width="50px">
                    </a> <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div>
                        <ul class="navbar-nav justify-content-end align-items-center  flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active " aria-current="page"id="nav-link" href="index.php">Acceuille</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="nav-link" href="about.php">A propos</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" id="nav-link" href="#">Nos actions </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" id="nav-link" href="equipment.php">Equipment</a>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>
<!--user-->
            <div>
                 <?php if (isset($_SESSION['id'])): ?>
                    <div class="dropdown ">
                        <a class="nav-link dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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

                <?php else: ?><div class="d-flex">
                    <a href="login.php" class="p-2 mx-2 nav-link" id="btn1">Connecter</a>
                    <a href="signout.php" class="p-2 nav-link" id="btn2">Créer un compte</a></div>
                <?php endif; ?>
            </div>

        </div>
    </nav>


    <!-- End Example Code -->
</body>

</html>