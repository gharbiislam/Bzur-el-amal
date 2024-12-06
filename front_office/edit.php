<!--edit-->

<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit;
}

$userId = $_SESSION['id'];
$sql = "SELECT * FROM users WHERE id = '$userId'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
    $adress = mysqli_real_escape_string($conn, $_POST['adress']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $updateSql = "UPDATE users SET name = '$name', email = '$email', pass = '$pass', adress = '$adress', phone_number = '$phone' WHERE id = '$userId'";

    if (mysqli_query($conn, $updateSql)) {
        // Update session variables with the new data
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
    
        // Redirect to avoid form resubmission
        header("Location: donateur.php");
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
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1>Edit Profile</h1>
    <form action="edit.php" method="post" class="was-validated" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" id="name" name="name"   value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email"   value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="pass" class="form-label">Password:</label>
            <input type="password" id="pass" name="pass"   value="<?php echo htmlspecialchars($user['pass']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address:</label>
            <input type="text" id="address" name="address"   value="<?php echo htmlspecialchars($user['adress']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number:</label>
            <input type="tel" id="phone" name="phone"   value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 