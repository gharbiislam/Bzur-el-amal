<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Footer Example</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/jQueryvalidate.js"></script>
</head>

<body>
    <footer class="text-white py-5 " id="footer">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-3 mb-3 mb-md-0 text-center text-md-start">
                    <img src="../assets/images/logo/logowhite.png" alt="logo" class="w-50">
                </div>

                <div class="col-12 col-md-3 mb-3 mb-md-0">
                    <h5 class="text-center text-md-start">Guide du Site</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="nav-link text-white">Accueil</a></li>
                        <li><a href="about.php" class="nav-link text-white">À propos</a></li>
                        <li><a href="actions.php" class="nav-link text-white">Nos Actions</a></li>
                        <li><a href="equipment.php" class="nav-link text-white">Équipements</a></li>
                    </ul>
                </div>

                <div class="col-12 col-md-3 mb-3 mb-md-0">
                    <h5 class="text-center text-md-start">Contact</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-envelope px-2"></i> bzureelamal@gmail.com</li>
                        <li><i class="bi bi-geo-alt px-2"></i> Rue Alpha 3, Bâtiment Foulan, Foulani 3030</li>
                        <li><i class="bi bi-telephone px-2"></i>+216 11 222 333, +216 77 222 333</li>
                    </ul>
                </div>

                <div class="col-12 col-md-3 text-center text-md-start">
                    <h5>Suivez-nous</h5>
                    <div class="mb-4">
                        <a href="#" class="text-white p-2"><i class="bi bi-facebook bg-warning p-2 rounded-circle"></i></a>
                        <a href="#" class="text-white p-2"><i class="bi bi-instagram bg-warning p-2 rounded-circle"></i></a>
                        <a href="#" class="text-white p-2"><i class="bi bi-tiktok bg-warning p-2 rounded-circle"></i></a>
                    </div>

                    <h5>Abonnez-vous à notre newsletter</h5>
                    <form action="contact.php" method="POST" class="d-flex justify-content-center">
                        <input type="email" class="form-control w-75 w-md-50" placeholder="Votre email" name="email" required>
                        <button type="submit" class="btn btn-warning ms-2">S'abonner</button>
                    </form>
                </div>
            </div>
        
            <div class="row mt-5 justify-content-center">
                <div class="col-12 text-center">
                    <hr class="text-white">
                    <p class="mb-0">Tous les droits sont réservés &copy; 2024</p>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
