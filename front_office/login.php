<?php
session_start();
include 'db.php';

if (isset($_POST['email']) && isset($_POST['pass'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);

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
else {
    echo "Veuillez remplir le formulaire.";
}
mysqli_close($conn);
?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    
    <!-- Add jQuery and jQuery Validate -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
</head>
<body class="container">
    <h1>Connexion</h1>
    <form id="loginForm" action="" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="pass" class="form-label">Mot de passe:</label>
            <input type="password" id="pass" name="pass" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>

    <script src="bootstrap.bundle.min.js"></script>
    <script src="bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // Validate the form
            $("#loginForm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    pass: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    email: {
                        required: "Veuillez entrer votre email",
                        email: "Veuillez entrer un email valide"
                    },
                    pass: {
                        required: "Veuillez entrer votre mot de passe",
                        minlength: "Le mot de passe doit comporter au moins 6 caractères"
                    }
                },
                submitHandler: function(form) {
                    form.submit();  // Submit the form when valid
                }
            });
        });
    </script>
</body>
</html>