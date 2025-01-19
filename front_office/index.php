<?php
include 'db.php';
include 'header.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body class="container-fluid mt-5 pt-5">
<div class="bg-image text-white row  vh-100 align-items-start justify-content-end img-fluid pt-5" id="section1" style="background-image: url('../assets/images/bg/bg.png');">
    <div class="col-6 text-right mt-5 pt-5">
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
<?php include ("finance.php")?>

<section class="text-center  py-5" id="dashboard">
        <div class="container">
    <h1 class="titre2">Collaboration Avec</h1>
    <p>Association Bzure El Amal Remercie leurs Collaboration Avec</p>

    <div class="row justify-content-between align-items-center ">
        <div class="col-4  col-md-2 p-2 text-center ">
            <img src="../assets/images/logo/cipph.jpeg" alt="" class="img-fluid " style="max-width: 150px; height: auto;">
        </div>
        <div class="col-4  col-md-2 p-2 text-center">
            <img src="../assets/images/logo/crLogo.png" alt="" class="img-fluid" style="max-width: 100px; height: auto;">
        </div>
        <div class="col-4  col-md-2 p-2 text-center">
            <img src="../assets/images/logo/LOGO-GEMI.png" alt="" class="img-fluid" style="max-width: 150px; height: auto;">
        </div>
        <div class="col-4  col-md-2 p-2 text-center">
            <img src="../assets/images/logo/msLogo.png" alt="" class="img-fluid" style="max-width: 100px; height: auto;">
        </div>
        <div class="col-4  col-md-2 0">
            <img src="../assets/images/logo/pharmacie.png" alt="" class="img-fluid" style="max-width: 100px; height: auto;">
        </div>
        <div class="col-4  col-md-2 p-2 text-center">
            <img src="../assets/images/logo/bt.png" alt="" class="img-fluid" style="max-width: 80px; height: auto;">
        </div>
    </div></div>
</section>




    
        <?php include("ja.php")?>

    </div>
<?php include("footer.php")?>
</body>

</html>
