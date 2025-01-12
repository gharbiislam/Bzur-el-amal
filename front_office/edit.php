<!--edit-->

<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include 'db.php';
include 'header.php';

if (!isset($_SESSION['id'])) {
    header("Location: edit.php");
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
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
    
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
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- jQuery and jQuery Validation Plugin -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>
    <style>
        .is-invalid {
            border: 2px solid red !important;
            box-shadow: none;
        }
    </style>
</head>
<body class="bg-light">
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="container bg-white shadow col-lg-5 p-5 rounded">
            <h1 class="text-center mb-4">Edit Profile</h1>
            <form id="editForm" action="edit.php" method="post" class="row justify-content-center">
                <div class="mb-3 form-group col-md-10">
                    <label for="name" class="form-label fw-bold">Name:</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>
                <div class="mb-3 form-group col-md-10">
                    <label for="email" class="form-label fw-bold">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="mb-3 form-group col-md-10">
                    <label for="pass" class="form-label fw-bold">Password:</label>
                    <input type="password" id="pass" name="pass" class="form-control" value="<?php echo htmlspecialchars($user['pass']); ?>" required>
                </div>
                <div class="mb-3 form-group col-md-10">
                    <label for="address" class="form-label fw-bold">Address:</label>
                    <input type="text" id="address" name="address" class="form-control" value="<?php echo htmlspecialchars($user['adress']); ?>" required>
                </div>
                <div class="mb-3 form-group col-md-10">
                    <label for="phone" class="form-label fw-bold">Phone Number:</label>
                    <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
                </div>
                <div class="text-center">
                    <input type="reset" value="Annuler" class="btn btn-secondary">
                    <input type="submit" value="Modifier" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#editForm").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    pass: {
                        required: true,
                        minlength: 6
                    },
                    address: {
                        required: true,
                        minlength: 5
                    },
                    phone: {
                        required: true,
                        digits: true,
                        minlength: 8,
                        maxlength: 8
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name.",
                        minlength: "Your name must be at least 2 characters long."
                    },
                    email: {
                        required: "Please enter your email.",
                        email: "Please enter a valid email address."
                    },
                    pass: {
                        required: "Please provide a password.",
                        minlength: "Your password must be at least 6 characters long."
                    },
                    address: {
                        required: "Please enter your address.",
                        minlength: "Your address must be at least 5 characters long."
                    },
                    phone: {
                        required: "Please enter your phone number.",
                        digits: "Please enter only digits.",
                        minlength: "Your phone number must be at least 10 digits long.",
                        maxlength: "Your phone number must not exceed 15 digits."
                    }
                },
                errorClass: "text-danger",
                errorPlacement: function (error, element) {
                    error.insertAfter(element); // Place error message after the input field
                },
                highlight: function (element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function (element) {
                    $(element).removeClass("is-invalid");
                }
            });
        });
    </script>
</body>
</html>

