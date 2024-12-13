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
</head>

<body class="container mt-5 pt-5">
    <di class="mt-5 container">
            <div class="row">

                   <!-- Equipments -->
<div class="col-4" id="equipments">
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
<div class="col-4" id="operations">
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
<div class="col-4" id="soinsmedicaux">
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
        </form>
    </div>
    <script src="bootstrap.min.js"></script>
</body>

</html>
