<?php 
include 'db.php';
include 'header.php';

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['id']);
$userName = $isLoggedIn ? $_SESSION['name'] : '';
$userEmail = $isLoggedIn ? $_SESSION['email'] : '';
$userPhone = $isLoggedIn ? $_SESSION['phone_number'] : '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faire un Don</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body class="container mt-5 pt-5">
    <!-- Navbar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Faire un Don</h1>
        <?php if (!$isLoggedIn): ?>
            <a href="login.php" class="btn btn-link">Connectez-vous</a>
        <?php else: ?>
            <a href="logout.php" class="btn btn-link">Se déconnecter</a>
        <?php endif; ?>
    </div>

    <div class="text-center">
        <h2 class="mb-4">Aidez là où c'est le plus nécessaire</h2>
        <p class="lead">Votre don aide à soutenir les besoins urgents de notre cause.</p>
    </div>

    <?php if ($isLoggedIn): ?>
        <!-- Logged-in View -->
        <div class="border p-4 rounded bg-light mb-4">
            <h3>Bonjour, <?php echo htmlspecialchars($userName); ?></h3>
            <p>Email: <input type="text" value="<?php echo htmlspecialchars($userEmail); ?>" class="form-control" disabled></p>
            <p>Téléphone: <input type="text" value="<?php echo htmlspecialchars($userPhone); ?>" class="form-control" disabled></p>
            
        </div>
    <?php else: ?>
        <!-- Guest View -->
        <div class="border p-4 rounded bg-light mb-4">
            <h3>Connectez-vous ou remplissez vos informations personnelles</h3>
            <form method="post" action="process_signup.php">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Téléphone:</label>
                    <input type="text" id="phone" name="phone" class="form-control" required>
                </div>
            </form>
            
        </div>
    <?php endif; ?>

    <!-- Donation Form -->
    <form id="donationForm" method="post" action="process_donation.php">
        <div class="border p-4 rounded bg-light">
            <h3>Informations de Paiement</h3>
            <div class="mb-3">
                <label for="amount" class="form-label">Montant du don:</label>
                <select id="amount" name="amount" class="form-select" required>
                    <option value="" disabled selected>Choisissez un montant</option>
                    <option value="10">10 Dinar</option>
                    <option value="20">20 Dinar</option>
                    <option value="50">50 Dinar</option>
                    <option value="100">100 Dinar</option>
                    <option value="other">Autre</option>
                </select>
            </div>
            <div class="mb-3 d-none" id="otherAmountDiv">
                <label for="otherAmount" class="form-label">Montant personnalisé:</label>
                <input type="number" id="otherAmount" name="otherAmount" class="form-control" min="1">
            </div>

            <h4>Carte Bancaire</h4>
            <div class="mb-3">
                <label for="cardNumber" class="form-label">Numéro de carte:</label>
                <input type="text" id="cardNumber" name="cardNumber" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="expiryMonth" class="form-label">Mois:</label>
                    <input type="text" id="expiryMonth" name="expiryMonth" class="form-control" placeholder="MM" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="expiryYear" class="form-label">Année:</label>
                    <input type="text" id="expiryYear" name="expiryYear" class="form-control" placeholder="AA" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="cvv" class="form-label">CVV:</label>
                <input type="text" id="cvv" name="cvv" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Faire un Don</button>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Show/hide the custom amount input
            $('#amount').change(function() {
                if ($(this).val() === 'other') {
                    $('#otherAmountDiv').removeClass('d-none');
                } else {
                    $('#otherAmountDiv').addClass('d-none');
                }
            });
        });
    </script>
</body>
</html>
