<?php
include 'db.php';

$id = $_GET['id'];

$deleteDonateur = "DELETE FROM donateur WHERE user_id=$id";
$deleteUser = "DELETE FROM users WHERE id=$id";

if (mysqli_query($conn, $deleteDonateur) && mysqli_query($conn, $deleteUser)) {
    header("Location: users.php"); 
} else {
    echo "Error deleting record: " .  mysqli_error($conn);
}

mysqli_close($conn);
?>
