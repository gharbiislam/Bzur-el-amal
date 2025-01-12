<!--login-->
<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $errors = "";
    

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
        $errors = "Nom d'utilisateur ou mot de passe incorrect.";

    }
}

mysqli_close($conn);
?>



<!DOCTYPE html>
<html>
<head>
    <title>Connexion Administrateur</title> 
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
                        email: "Veuillez entrer une adresse e-mail valide.",

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
<body class="bg-warning row  justify-content-center align-items-center container-fluid vh-100 ">
    <div class="bg-white col-md-4 col-10 p-5  rounded-4  ">
    <img src="../assets/images/logo/logo1.png" alt="" class="w-100">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="">
        <div class="form-group my-3 ">
        <label for="email" class="form-label  font-weight-bolder ">Email:</label>
        <input type="email" name="email" class="form-control" required>
    </div>
        <div class="form-group my-3   ">
        <label for="mdp" class="form-label font-weight-bolder  ">Mot de passe:</label>
        <input type="password" name="mdp" class="form-control" required></div>
        <div class="text-center">
        <input type="submit" value="Se connecter" id="btn2" class="border-0  ">
</div>
  </form>
  <?php if (!empty($errors)): ?>
            <div class="mt-3 py-3 text-center text-danger font-weight-bolder ">
                <?php echo $errors; ?>
            </div>
        <?php endif; ?>
</div>  
</div>
</body>
</html>
