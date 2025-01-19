
<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include 'db.php';
if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['role'], $_POST['phone'], $_POST['adress'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $phone = $_POST['phone'];
    $adress = $_POST['adress'];

    $req = "INSERT INTO users (name, email, pass, role, phone_number, adress) VALUES ('$name','$email','$password','$role','$phone','$adress')";
    $res = mysqli_query($conn, $req);

    if ($res) {
        $userId = mysqli_insert_id($conn);

        $_SESSION['id'] = $userId;
        $_SESSION['role'] = $role;
        $_SESSION['name'] = $name;

        if ($role == 'donateur') {
            $req_donateur = "INSERT INTO donateur(user_id) VALUES ('$userId')";
            $res_donateur = mysqli_query($conn, $req_donateur);

            if ($res_donateur) {
                header("Location: donateur.php");
            } else {
                echo "Erreur lors de l'insertion du donateur: " . mysqli_error($conn);
            }
        } else {
            $handicap = $_POST['handicap'];
            $doc = $_POST['doc'];
            $besoin = $_POST['besoin'];

            $req_beneficaire = "INSERT INTO bénéficiaire (user_id, handicap_type, documents, needs) VALUES ('$userId', '$handicap', '$doc', '$besoin')";
            $res_beneficaire = mysqli_query($conn, $req_beneficaire);

            if ($res_beneficaire) {
                header("Location: bene.php");
            } else {
                echo "Erreur lors de l'insertion du bénéficiaire: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Erreur lors de l'insertion de l'utilisateur: " . mysqli_error($conn);
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="../assets/css/style.css">
           
    <script src="../assets/js/jQueryvalidate.js"></script>
    <script src="../assets/js/index.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
</head>

<body class="d-md-flex">
    <style>#connexion {
    position: fixed;
    top: 0;
    right: 0;
    width: 50%; 
    height: 100%;
    background-image: url('../assets/images/bg/about3.jpg');
    background-size: cover;
    background-position: center;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}

body {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

.col-md-6 {
    width: 50%;
}
</style>
    <div class="col-md-6 p-5">
    <h1>Inscription</h1>
    <form id="signupForm" method="post" class="">
        <div class=" mb-3">
            <label for="name" class="form-label">Votre Nom Complet</label>
            <input type="text" id="name" name="name" class="form-control"  required>
        </div>
        <div class=" mb-3">
            <label for="email" class="form-label">email:</label>
            <input type="email" id="email" name="email"  class="form-control" required>
        </div>
        <div class=" mb-3">
            <label for="password" class="form-label">Mot de passe:</label>
            <input type="password"   id="password" name="password"class="form-control" required>
        </div>
        <div class=" mb-3">
            <label for="phone" class="form-label">Téléphone:</label>
            <input type="number" id="phone" name="phone" class="form-control"  required>
        </div>
        <div class=" mb-3">
            <label for="adress" class="form-label">Adresse:</label>
            <input type="text" id="adress" name="adress" class="form-control"  required>
        </div>
        <div class=" mb-3">
            <label for="role" class="form-label">Votre Rôle:</label>
            <select id="role" name="role"  class="form-control" required onchange="toggleBeneficiaireSection()">
                <option value="" disabled selected>choix votre role</option>
                <option value="donateur">Donateur</option>
                <option value="beneficiaire">Bénéficiaire</option>
            </select>
        </div>
        
        <!-- Section for Beneficiaire -->
        <div class="d-none" id="beneficaireSection">
            <div class="mb-3">
            <label for="handicap" class="form-label">Type de handicap:</label>
            <select name="handicap" id="handicap" class="form-control" >
                <option value="" disabled selected>choix type d'handicap</option>
                <option value="handicap moteur">Handicap Moteur</option>
                <option value="handicap multiple">Handicap Multiple</option>
                <option value="autre">Autre</option>
            </select></div>
            <div class="mb-3">
            <label for="besoin" class="form-label">Besoins:</label>
            <input type="text" id="besoin" name="besoin"  class="form-control"></div>
            <div class="mb-3">
            <label for="doc" class="form-label">Document:</label>
            <input type="file" id="doc" name="doc"  class="form-control"></div>
            
        </div>
        <div class="my-4 d-flex align-items-start">
    <input type="checkbox" id="agree" name="agree" value="1" class=" m-2">
    <label for="agree">En créant un compte, vous acceptez les <b>Conditions Générales</b> et notre <b>Politique de Confidentialité</b>.</label>
</div>

        <input type="submit" value="S'inscrire" class="btn btn-primary">
    </form>
    <p class="text-center text-muted my-3 d-flex justify-content-center">
    Vous Avez Deja un Compte?  <a href="login.php" class="nav-link text-warning fw-bold">  Connecter</a></p>
    </div>
<!---->
    <div class="p-5 col-md-6 text-center row justify-content-center align-items-center text-white " id="connexion" style="background-image: url('../assets/images/bg/about3.jpg');" >
      <div><h1>Bienvenu au Bzure El Amal</h1>
        <p>
        Lorem ipsum dolor sit amet,a? Aliquid maiores modi culpa deserunt fugiat assumenda neque temporibus atque nisi soluta?
</p></div>
    </div>
 
</body>

</html>
