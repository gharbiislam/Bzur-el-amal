<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}if (!isset($_SESSION['admins_name'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
$adminName = $_SESSION['admins_name'];
$query = "SELECT * FROM admins WHERE name = '$adminName'";
$res = mysqli_query($conn,$query);
if ($res && mysqli_num_rows($res) > 0) {
    $admin = mysqli_fetch_assoc($res);
} else {
    echo "Admin not found!";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];

    $updateAdmin = "UPDATE admins SET name = '$newName', email = '$newEmail', mdp = '$newPassword' WHERE name = '$adminName'";
    if (mysqli_query($conn, $updateAdmin)) {
        $_SESSION['admins_name'] = $newName; 
        echo "Profile updated successfully!";
        header("Location: dashboard.php"); 
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}

mysqli_close(mysql: $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <div class="d-flex flex-column flex-lg-row ">
        <div class="col-lg-2 d-none d-lg-block ">
            <?php
            include('nav.php');

            ?>
        </div>
        <div class="container d-flex justify-content-center align-items-center vh-100" id="edit">
  <di class=" col-lg-6" .>
    <h1 class=" mb-5" >Edit Profile</h1>
    <form method="post" >
      <div class="mb-4 form-group">
        <label for="name" class="form-label fw-bold">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($admin['name']); ?>" required>
      </div>
      <div class="mb-4 form-group">
        <label for="email" class="form-label fw-bold">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
      </div>
      <div class="mb-4 form-group">
        <label for="password" class="form-label fw-bold">Password</label>
        <input type="password" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($admin['mdp']); ?>" required>
      </div>
        <button type="reset" class=" btn mr-5" id="navBtn2">Annuler</button>
        <button type="submit" class="btn " id="navBtn">Enregistrer</button>
    </form>
  </div>
</div>



    </div>
  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
