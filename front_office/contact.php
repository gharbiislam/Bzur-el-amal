<?php
include 'db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nom']) && isset($_POST['msg']) && isset($_POST['email']) && isset($_POST['phone'])) {
        $name = $_POST['nom'];
        $msg = $_POST['msg'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $req = "INSERT INTO contact(nom,email,phone,msg) VALUES ('$name', '$email', '$phone', '$msg')";
        $res = mysqli_query($conn, $req);

        if ($res) {
            $success = "Your message has been sent successfully!";
        } else {
            $error = "There was an error while sending your message.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include 'header.php' ?>
    <div class="container mt-5 py-5">
    <div class="d-md-flex justify-content-between text-center">
        <div>
            <button class="btn rounded-circle mb-3 mt-3 mt-md-0" id="btn2"> <i class="bi bi-geo-alt" id="btn-2"></i></button>
            <h5>Adresse</h5>
            <p>rue alpha 3 batiment Foulan foulani 3030</p>
        </div>
        <div> 
            <button class="btn rounded-circle mb-3" id="btn2"> <i class="bi bi-telephone"></i></button>
            <h5>Tél</h5>
            <p>+216 55 222 333 <br>+216 77 222 333</p>
        </div>
        <div>
            <button class="btn rounded-circle mb-3" id="btn2"> <i class="bi bi-envelope"></i></button>
            <h5>e-mail</h5>
            <p>bzureelamal@gmail.com</p>
        </div>
    </div>
    <hr>
    <div class="d-md-flex">
        <div class="col-md-5 mb-3">
            <?php
            if ($success) {
                echo "<div class='alert alert-success'>$success</div>";
            }
            if ($error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
            ?>
            <form action="" method="post" class="row justify-content-center">
                <div class="col-md-10">
                    <input type="text" id="name" name="nom" class="form-control mb-4 col" placeholder="votre Nom et Prenom" required>
                </div>
                <div class="col-md-10">
                    <input type="email" id="email" name="email" class="form-control mb-4" placeholder="votre e-mail" required>
                </div>
                <div class="col-md-10">
                    <input type="tel" id="phone" name="phone" class="form-control mb-4" placeholder="votre telephone" required>
                </div>
                <div class="col-md-10">
                    <textarea name="msg" id="msg" placeholder="votre message" class="form-control mb-4"></textarea>
                </div>
                <div class="col-md-10">
                    <input type="submit" value="envoyer" class="btn text-center btn-block col-12" id="btn2">
                </div>
            </form>
        </div>
        <div class="col-md-7">
            <iframe     src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2689.9351064559156!2d10.1633141844186!3d36.86361057982511!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1302f3136d35cfef%3A0x1f46e25e1003ff4e!2sManar%202%2C%20Tunis!5e0!3m2!1sen!2stn!4v1673707395562!5m2!1sen!2stn" 
                width="750" height="400" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</div>

    <?php include 'footer.php'?>

</body>

</html>