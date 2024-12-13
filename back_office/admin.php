<!--login-->
<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    $query = "SELECT * FROM admins WHERE email = '$email' AND mdp = '$mdp'";
    $result = mysqli_query($conn, $query);


    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }

    if ($result->num_rows > 0) {
        $admin = mysqli_fetch_assoc($result);
        $_SESSION['admins_name'] = $admin['name'];
        header("Location:dashboard.php");
        exit();
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Connexion Administrateur</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            $("form").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    mdp: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    email: {
                        required: "Veuillez entrer votre adresse e-mail.",
                        email: "Veuillez entrer une adresse e-mail valide."
                    },
                    mdp: {
                        required: "Veuillez entrer un mot de passe.",
                        minlength: "Le mot de passe doit comporter au moins 6 caractères."
                    }
                }
            });
        });
    </script>
</head>
<body>
    <h2>Connexion</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <label for="mdp">Mot de passe:</label>
        <input type="password" name="mdp" required>
        <br>
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>
