<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Equipment Donation</title>
</head>
<body>
    <h2>Add Equipment Donation</h2>
    <form action="add_donation.php" method="POST">
        <label for="id_donateur">Donor ID:</label>
        <input type="text" id="id_donateur" name="id_donateur" required><br><br>

        <label for="quantite">Quantity:</label>
        <input type="number" id="quantite" name="quantite" required><br><br>

        <label for="etat">Condition:</label>
        <input type="text" id="etat" name="etat" required><br><br>

        <label for="date_don">Donation Date:</label>
        <input type="date" id="date_don" name="date_don" required><br><br>

        <input type="submit" name="submit" value="Add Donation">
    </form>
</body>
</html>
<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id_donateur = $_POST['id_donateur'];
    $quantite = $_POST['quantite'];
    $etat = $_POST['etat'];
    $date_don = $_POST['date_don'];

    // Database connection
    $servername = "localhost";  // Update with your server details
    $username = "root";         // Update with your MySQL username
    $password = "";             // Update with your MySQL password
    $dbname = "your_database";  // Update with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into dons_equipment table
    $sql = "INSERT INTO dons_equipment (id_donateur, quantite, etat, date_don) 
            VALUES ('$id_donateur', '$quantite', '$etat', '$date_don')";

    if ($conn->query($sql) === TRUE) {
        echo "New donation added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
