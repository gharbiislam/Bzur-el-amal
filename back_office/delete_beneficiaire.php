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

$deleteBeneficiaire = "DELETE FROM bénéficiaire WHERE user_id=$id";
$deleteUser = "DELETE FROM users WHERE id=$id";

if ($conn->query($deleteBeneficiaire) === TRUE && $conn->query($deleteUser) === TRUE) {
    header("Location: users.php");
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
