<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "account";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$query = "SELECT users.id, users.name, users.email, users.adress, users.phone_number, bénéficiaire.handicap_type, bénéficiaire.needs 
          FROM users 
          JOIN bénéficiaire ON users.id = bénéficiaire.user_id 
          WHERE users.id = $id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $beneficiaire = $result->fetch_assoc();
} else {
    echo "No Beneficiary found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $adress = $_POST['adress'];
    $phone_number = $_POST['phone_number'];
    $handicap_type = $_POST['handicap_type'];
    $needs = $_POST['needs'];

    $updateUser = "UPDATE users SET name='$name', email='$email', adress='$adress', phone_number='$phone_number' WHERE id=$id";
    $updateBeneficiaire = "UPDATE bénéficiaire SET handicap_type='$handicap_type', needs='$needs' WHERE user_id=$id";

    if ($conn->query($updateUser) === TRUE && $conn->query($updateBeneficiaire) === TRUE) {
        header("Location: users.php"); 
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Beneficiary</title>
</head>
<body>
    <form method="post">
        <label>Name: <input type="text" name="name" value="<?= $beneficiaire['name'] ?>"></label><br>
        <label>Email: <input type="text" name="email" value="<?= $beneficiaire['email'] ?>"></label><br>
        <label>Address: <input type="text" name="adress" value="<?= $beneficiaire['adress'] ?>"></label><br>
        <label>Phone Number: <input type="text" name="phone_number" value="<?= $beneficiaire['phone_number'] ?>"></label><br>
        <label>Type of Handicap: <input type="text" name="handicap_type" value="<?= $beneficiaire['handicap_type'] ?>"></label><br>
        <label>Needs: <input type="text" name="needs" value="<?= $beneficiaire['needs'] ?>"></label><br>
        <button type="submit">Save Changes</button>
    </form>
</body>
</html>

<?php $conn->close(); ?>
