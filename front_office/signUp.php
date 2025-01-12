
<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include 'db.php';
if (isset($_POST['name'], $_POST['email'], $_POST['pass'], $_POST['role'], $_POST['phone'], $_POST['adress'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $role = $_POST['role'];
    $phone = $_POST['phone'];
    $adress = $_POST['adress'];

    $req = "INSERT INTO users (name, email, pass, role, phone_number, adress) VALUES ('$name','$email','$pass','$role','$phone','$adress')";
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

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
</head>

<body class="d-md-flex">
    <div class="col-md-6 p-5">
    <h1>Inscription</h1>
    <form id="signupForm" method="post" class="">
        <div class=" mb-3">
            <label for="name" class="form-label">Nom:</label>
            <input type="text" id="name" name="name" class="form-control"  required>
        </div>
        <div class=" mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email"  class="form-control" required>
        </div>
        <div class=" mb-3">
            <label for="pass" class="form-label">Mot de passe:</label>
            <input type="password"   id="pass" name="pass"class="form-control" required>
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
            <label for="role" class="form-label">Rôle:</label>
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
                <option value="h_moteur">Handicap Moteur</option>
                <option value="h_audictive">Handicap Auditif</option>
                <option value="h_multiple">Handicap Multiple</option>
                <option value="autre">Autre</option>
            </select></div>
            <div class="mb-3">
            <label for="besoin" class="form-label">Besoins:</label>
            <input type="text" id="besoin" name="besoin"  class="form-control"></div>
            <div class="mb-3">
            <label for="doc" class="form-label">Document:</label>
            <input type="file" id="doc" name="doc"  class="form-control"></div>
        </div>

        <input type="submit" value="S'inscrire" class="btn btn-primary">
    </form>
    </div>
    <div class="p-5 col-md-6 text-center  " id="connexion" style="background-image: url('../assets/images/bg/img2.jpeg');" >
      <h1>Bienvenu au Bzure El Amal</h1>
        <p>
        Lorem ipsum dolor sit amet,a? Aliquid maiores modi culpa deserunt fugiat assumenda neque temporibus atque nisi soluta?
</p>
<a href="login.php" class="nav-link" id="btn2"> login</a>
    </div>
    <script>
        function toggleBeneficiaireSection() {
            var role = document.getElementById('role').value;
            var beneficaireSection = document.getElementById('beneficaireSection');

            if (role === "beneficiaire") {
                beneficaireSection.classList.remove('d-none');
            } else {
                beneficaireSection.classList.add('d-none');
            }
        }

        $(document).ready(function () {
            $("#signupForm").validate({
                rules: {
                    name: "required",
                    email: {
                        required: true,
                        email: true
                    },
                    pass: {
                        required: true,
                        minlength: 6
                    },
                    phone: {
                        required: true,
                        digits: true,
                        minlength: 8
                    },
                    adress: "required",
                    role: "required",
                    handicap: {
                        required: function () {
                            return $("#role").val() === "beneficiaire";
                        }
                    }
                },
                messages: {
                    name: "Veuillez fournir un nom valide.",
                    email: {
                        required: "Veuillez fournir un email.",
                        email: "Veuillez fournir un email valide."
                    },
                    pass: {
                        required: "Veuillez fournir un mot de passe.",
                        minlength: "Le mot de passe doit comporter au moins 6 caractères."
                    },
                    phone: {
                        required: "Veuillez fournir un numéro de téléphone.",
                        digits: "Veuillez entrer uniquement des chiffres.",
                        minlength: "Le numéro de téléphone doit comporter au moins 8 chiffres."
                    },
                    adress: "Veuillez fournir une adresse.",
                    role: "Veuillez sélectionner un rôle.",
                    handicap: "Veuillez fournir un type de handicap."
                }
            });
        });
    </script>
</body>

</html>
