<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';
include 'header.php';

if (!isset($_SESSION['id'])) {
    header("Location: edit.php");
    exit;
}

$userId = $_SESSION['id'];
$sql = "SELECT * FROM users WHERE id = '$userId'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email =  $_POST['email'];
    $password =  $_POST['password'];
    $adress =  $_POST['adress'];
    $phone =  $_POST['phone'];

    $updateSql = "UPDATE users SET name = '$name', email = '$email', pass = '$password', adress = '$adress', phone_number = '$phone' WHERE id = '$userId'";
    if (mysqli_query($conn, $updateSql)) {
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['update_success'] = true; 
        
        header("Location: edit.php"); 
        exit;
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <link rel="stylesheet" href="../assets/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/jQueryvalidate.js"></script>

</head>
<body class="bg-light">

<div class="d-flex align-items-center justify-content-center vh-100">
    <div class="container bg-white shadow col-lg-5 p-5 rounded">
        <h1 class="text-center mb-4 text-warning">Edit Profile</h1>
        <form id="editForm" action="edit.php" method="post" class="row justify-content-center">
            <div class="mb-3 form-group col-md-10">
                <label for="name" class="form-label ">Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="mb-3 form-group col-md-10">
                <label for="email" class="form-label ">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3 form-group col-md-10">
                <label for="password" class="form-label ">Password:</label>
                <input type="password" id="password" name="password" class="form-control" value="<?php $user['pass']; ?>" required>
            </div>
            <div class="d-md-flex col-md-10">
            <div class="mb-3 form-group col-md-6 ">
                <label for="adress" class="form-label ">Adress:</label>
                <input type="text" id="adress" name="adress" class="form-control" value="<?php $user['adress']; ?>" required>
            </div>
            <div class="mb-3 form-group col-md-6 mx-3">
                <label for="phone" class="form-label ">Phone Number:</label>
                <input type="tel" id="phone" name="phone" max="8" class="form-control" value="<?php echo $user['phone_number']; ?>" required>
            </div></div>
            <div class="text-center">
                <input type="reset" value="Annuler"  class="btn btn-outline-warning">
                <input type="submit" value="Modifier"  class="btn btn-warning">
            </div>
        </form>

        <?php
        if (isset($_SESSION['update_success']) && $_SESSION['update_success'] == true) {
            echo '<div class="alert alert-success text-center mt-3">Profil mis à jour avec succès!</div>'; 
            unset($_SESSION['update_success']);  
        }
        ?>
    </div>
</div>
</body>
</html>
