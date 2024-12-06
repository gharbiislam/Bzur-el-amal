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
$query = "SELECT users.id, users.name, users.email, users.adress, users.phone_number, donateur.type_don, donateur.date_dernier_don 
          FROM users 
          JOIN donateur ON users.id = donateur.user_id 
          WHERE users.id = $id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $donateur = $result->fetch_assoc();
} else {
    echo "No Donateur found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $adress = $_POST['adress'];
    $phone_number = $_POST['phone_number'];
    $type_don = $_POST['type_don'];
    $date_dernier_don = $_POST['date_dernier_don'];

    $updateUser = "UPDATE users SET name='$name', email='$email', adress='$adress', phone_number='$phone_number' WHERE id=$id";
    $updateDonateur = "UPDATE donateur SET type_don='$type_don', date_dernier_don='$date_dernier_don' WHERE user_id=$id";

    if ($conn->query($updateUser) === TRUE && $conn->query($updateDonateur) === TRUE) {
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
    <title>Edit Donateur</title>
</head>
<body>
    <form method="post">
        <label>Name: <input type="text" name="name" value="<?= $donateur['name'] ?>"></label><br>
        <label>Email: <input type="text" name="email" value="<?= $donateur['email'] ?>"></label><br>
        <label>Address: <input type="text" name="adress" value="<?= $donateur['adress'] ?>"></label><br>
        <label>Phone Number: <input type="text" name="phone_number" value="<?= $donateur['phone_number'] ?>"></label><br>
        <label>Type of Donation: <input type="text" name="type_don" value="<?= $donateur['type_don'] ?>"></label><br>
        <label>Date of Last Donation: <input type="date" name="date_dernier_don" value="<?= $donateur['date_dernier_don'] ?>"></label><br>
        <button type="submit">Save Changes</button>
    </form>
</body>
</html>

<?php $conn->close(); ?>
