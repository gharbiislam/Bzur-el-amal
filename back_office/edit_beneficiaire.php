<?php
include 'db.php';


$id = $_GET['id'];
$query = "SELECT users.id, users.name, users.email, users.adress, users.phone_number, bénéficiaire.handicap_type, bénéficiaire.needs 
          FROM users 
          JOIN bénéficiaire ON users.id = bénéficiaire.user_id 
          WHERE users.id = $id";
$res = mysqli_query($conn,$query);

if($res && mysqli_num_rows($res) > 0) {
        $beneficiaire  = mysqli_fetch_assoc($res);
} else {
    echo "No Beneficiary found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $adress = $_POST['adress'];
    $phone = $_POST['phone'];
    $handicap_type = $_POST['handicap_type'];
    $needs = $_POST['needs'];

    $updateUser = "UPDATE users SET name='$name', email='$email', adress='$adress', phone_number='$phone' WHERE id=$id";
    $updateBeneficiaire = "UPDATE bénéficiaire SET handicap_type='$handicap_type', needs='$needs' WHERE user_id=$id";
    if (mysqli_query($conn, $updateUser) && mysqli_query($conn, $updateBeneficiaire)) {
        header("Location: users.php");
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

}
mysqli_close(mysql: $conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <link rel="stylesheet" href="../assets/css/style.css">
  <script src="../assets/js/jQueryvalidate.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

</head>
<body><style>
    .error {
    color: red;
    font-size: 0.875em;
    margin-top: 5px;}
  </style>
<div class="d-flex flex-column flex-lg-row">
    <div class="col-lg-2 d-none d-lg-block">
      <?php include('nav.php'); ?>
    </div>
    <div class="container d-flex justify-content-center align-items-center vh-100" id="edit">
      <div class="col-lg-6">

        <h1 class="mb-5">Edit Profile</h1>

        <form method="post">
    <div class="form-group  mb-3">
        <label class="fw-bold"  for="name">Name:</label>  
        <input type="text" class="form-control" id="name" name="name" value="<?= $beneficiaire['name'] ?>"required>
    </div>
    <div class="form-group mb-3">
        <label class="fw-bold"  for="email">Email:</label>  
        <input type="text" class="form-control" id="email" name="email" value="<?= $beneficiaire['email'] ?>"required>
    </div>
    <div class="form-group mb-3">
        <label class="fw-bold"  for="adress">Address:</label>  
        <input type="text" class="form-control" id="adress" name="adress" value="<?= $beneficiaire['adress'] ?>" required>
    </div>
    <div class="form-group mb-3">
        <label class="fw-bold"  for="phone">Phone Number:</label>  
        <input type="text" class="form-control" id="phone" name="phone" value="<?= $beneficiaire['phone_number'] ?>" required>
    </div>
    <div class="form-group mb-3">
        <label class="fw-bold"  for="handicap_type">Type of Handicap:</label>  
        <input type="text" class="form-control" id="handicap_type" name="handicap_type" value="<?= $beneficiaire['handicap_type'] ?>" required>
    </div>
    <div class="form-group mb-3">
        <label class="fw-bold"  for="needs">Needs:</label>  
        <input type="text" class="form-control" id="needs" name="needs" value="<?= $beneficiaire['needs'] ?>" required>
    </div>
    <button type="reset" class="btn btn-secondary mr-5" id="navBtn2">Cancel</button>
    <button type="submit" class="btn btn-primary" id="navBtn">Save</button>
</form>


</body>
</html>

