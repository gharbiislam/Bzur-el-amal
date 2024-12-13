<?php
session_start();
if (!isset($_SESSION['admins_name'])) {
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

// Update profile if form is submitted
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
  <title>Edit Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2>Edit Profile</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($admin['name']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($admin['mdp']); ?>" required>
      </div>
      <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
