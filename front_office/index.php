<?php
include 'db.php';
include 'header.php';

if (isset($_SESSION['role']) && $_SESSION['role'] == 'donateur') {
    $showDonateButton = true;
} else {
    $showDonateButton = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="bootstrap.min.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body class="p-0 m-0">
<div class="bg-image text-white row justify-content-end" id="section1" style="background-image: url('../assets/images/bg/bg.png');">
    <div class="col-6 text-right mt-5">
        <span class="h1 display-4 my-5 py-5">Ensemble, rendons le monde accessible à <span class="text-warning">Tous</span></span><br>
        <span class="font-weight-light h5">Rejoignez Bzure el Amal et :</span>
        <ul class="font-weight-bolder h4" style="font-size: 1.5rem;">
            <li>offrez un sourire à ceux qui en ont besoin</li>
            <li>Bénéficier de nos services</li>
        </ul>
        <a href="" class="btn btn-warning text-white btn-lg mx-3">Espace Donnateur</a>
        <a href="" class="btn btn-warning text-white btn-lg">Espace Bénéficiaire</a>
    </div>
</div>



    <div class="mt-5 container">

        <div class="d-lg-flex">

            <!-- Equipments -->
            <div class="col-lg-4" id="equipments">
                <a href="details.php?categorie=equipments">
                    <div>
                        <img src="http://localhost/dashboard/pfa/assets/equipmen.jpeg" alt="" width="350px" height="300px">
                    </div>
                </a>
                <div class="p-3">
                    <h5>Equipments</h5>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, omnis ea! Aliquid dolore consectetur voluptatem itaque commodi, molestiae veniam quis. Ducimus molestiae vero magni eos eligendi facere fugit eum similique!</p>
                </div>
            </div>

            <!-- Operations -->
            <div class="col-lg-4" id="operations">
                <a href="details.php?categorie=operations">
                    <div>
                        <img src="http://localhost/dashboard/pfa/assets/operations.png" alt="" width="350px" height="300px">
                    </div>
                </a>
                <div class="p-3">
                    <h5>Operations</h5>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, omnis ea! Aliquid dolore consectetur voluptatem itaque commodi, molestiae veniam quis. Ducimus molestiae vero magni eos eligendi facere fugit eum similique!</p>
                </div>
            </div>

            <!-- Soins Medicaux -->
            <div class="col-lg-4" id="soinsmedicaux">
                <a href="details.php?categorie=soinsmedicaux">
                    <div>
                        <img src="http://localhost/dashboard/pfa/assets/soins.jpg" alt="" width="350px" height="300px">
                    </div>
                </a>
                <div class="pt-3">
                    <h5>Soins Medicaux</h5>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, omnis ea! Aliquid dolore consectetur voluptatem itaque commodi, molestiae veniam quis. Ducimus molestiae vero magni eos eligendi facere fugit eum similique!</p>
                </div>
            </div>


        </div>

    </div>
<?php include("footer.php")?>
</body>

</html>
