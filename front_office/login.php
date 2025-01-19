<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include 'db.php';

if (isset($_POST['email']) && isset($_POST['pass'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $sql = "SELECT * FROM users WHERE email = '$email' AND pass = '$pass'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];

        if ($user['role'] == 'donateur') {
            header("Location: donateur.php");
        } elseif ($user['role'] == 'beneficiaire') {
            header("Location:bene.php");
        }
        exit;
    } else {
        echo "Email ou mot de passe incorrect.";
    }
} 

mysqli_close($conn);
?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
</head>
<body class=" d-md-flex ">
    <div class="p-5 col-md-6  text-center" id="connexion" style="background-image: url('../assets/images/bg/about3.jpg');" >
      <h1>Bienvenu au Bzure El Amal</h1>
        <p>
        Lorem ipsum dolor sit amet,a? Aliquid maiores modi culpa deserunt fugiat assumenda neque temporibus atque nisi soluta?
</p>
<a href="signUp.php" class="  nav-link" id="btn2"> Sign Up</a>
    </div>
    <div class="p-5 col-md-6">
    <h1>Connecter A votre Compte</h1>
    <form id="loginForm" action="" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Votre Adresse mail</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="pass" class="form-label">Mot de passe:</label>
            <input type="password" id="pass" name="pass" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form></div>

    <script src="bootstrap.bundle.min.js"></script>
    <script src="bootstrap.min.js"></script>

    <script src="../assets/js/jQueryvalidate.js">
</script>
</body>
</html>