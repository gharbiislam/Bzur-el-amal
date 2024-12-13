<?php
include('db.php');

include('header.php');
$user_id = $_SESSION['id'];

$query = "SELECT name, adress, phone_number from users
          WHERE id = '$user_id'";

$result = mysqli_query($conn, $query);

if ($result) {
    $user_data = mysqli_fetch_assoc($result);
} else {
    echo "Error retrieving user data: " . mysqli_error($conn);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $adress = $_POST['adress'];
    $phone = $_POST['phone'];
    $categorie = $_POST['categorie'];
    $amount = $_POST['amount'];
    $detail = $_POST['detail'];
    $document = $_FILES['document']['name'];

    // Upload document (assuming you want to store it)
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($document);
    move_uploaded_file($_FILES['document']['tmp_name'], $target_file);

    // Insert the new request into the database
    $insert_query = "INSERT INTO request_financiere 
                     (user_id, categorie, montant, details, documents, date_request) 
                     VALUES ('$user_id',  '$categorie', '$amount', '$detail', '$target_file', NOW())";

    if (mysqli_query($conn, $insert_query)) {
        echo "Donation request submitted successfully!";
    } else {
        echo "Error submitting request: " . mysqli_error($conn);
    }
    $updateUser = "UPDATE users SET  adress='$adress', phone_number='$phone_number' WHERE id=$id";

    if (mysqli_query($conn , $updateUser) ){
        echo "update done!";

    } else {
        echo "Error submitting update: " . mysqli_error($conn);    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de donation financière</title>
</head>
<body class="container">
    <h1>Demande de donation financière</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $user_data['name']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="adress" class="form-label">Adresse</label>
            <input type="text" class="form-control" id="adress" name="adress" value="<?php echo $user_data['adress']; ?>">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Numéro de téléphone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user_data['phone_number']; ?>">
        </div>
        <div class="mb-3">
            <label for="categorie" class="form-label">Catégorie</label>
            <select class="form-select" id="categorie" name="categorie" required>
                <option value="">Sélectionner la catégorie</option>
                <option value="equipments">Équipements</option>
                <option value="operations">Opérations</option>
                <option value="soinsmedicaux">Soins Médicaux</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Montant demandé (en TD)</label>
            <input type="number" class="form-control" id="amount" name="amount" required>
        </div>
        <div class="mb-3">
            <label for="detail" class="form-label">Détails</label>
            <input type="text" class="form-control" id="detail" name="detail">
        </div>
        <div class="mb-3">
            <label for="document" class="form-label">Télécharger un document</label>
            <input type="file" class="form-control" name="document" id="document" required>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer demande</button>
    </form>
</body>
</html>
