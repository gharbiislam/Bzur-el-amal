<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include 'header.php';
$user_id = $_SESSION['id'];

include('db.php');
$query = "SELECT name, phone_number, adress FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);

$query_don = "SELECT id_donateur FROM donateur WHERE user_id = $user_id";
$result_don = mysqli_query($conn, $query_don);
$don_data = mysqli_fetch_assoc($result_don);
$donateur_id = $don_data['id_donateur'];

$user_data = $result ? mysqli_fetch_assoc($result) : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $categorie = $_POST['categorie'];
    $adress = $_POST['adress'];
    $phone = $_POST['phone'];

    $query_insert = "INSERT INTO dons_financieres (id_donateur, montant, mode_paiement, categorie) 
                     VALUES ($donateur_id, $amount, '$payment_method', '$categorie')";
    $result_insert = mysqli_query($conn, $query_insert);
    $updateUser = "UPDATE users SET adress='$adress', phone_number='$phone' WHERE id=$user_id";
    if ($result_insert) {
        $message = "Don effectué avec succès!";
        

    } else {
        $message = "Erreur lors de l'enregistrement du don: " . mysqli_error($conn);
    }

    $updateUser = "UPDATE users SET adress='$adress', phone_number='$phone' WHERE id=$user_id";
    if (mysqli_query($conn, $updateUser)) {
        $message_update = "Mise à jour réussie!";
    } else {
        $message_update = "Erreur lors de la mise à jour: " . mysqli_error($conn);
    }
}

$categorie_selected = isset($_GET['categorie']) ? $_GET['categorie'] : '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faire un Don</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/jQueryvalidate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
</head>
<body>
    <div class=" mt-2">
        <h2>Faire un Don</h2> <?php if (isset($message)): ?>
            <div class="alert alert-success text-center">
                <i class="bi bi-check-circle px-2"></i> <?= $message; ?>
            </div>
        <?php endif; ?>

       
        
        <form id="donationForm" method="POST">
            <div class="mb-3 px-2 px-2">
                <label for="name" class="form-label text-left">Nom</label>
                <input type="text" class="form-control " id="name" name="name" value="<?php echo $user_data['name']; ?>" readonly>
            </div>
            <div class="mb-3 px-2">
                <label for="adress" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="adress" name="adress" value="<?php echo $user_data['adress']; ?>">
            </div>
            <div class="mb-3 px-2">
                <label for="phone" class="form-label">Numéro de téléphone</label>
                <input type="text" class="form-control " id="phone" name="phone" value="<?php echo $user_data['phone_number']; ?>">
            </div>
            <div class="mb-3 px-2">
                <label for="amount" class="form-label">Montant du Don</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="mb-3 px-2">
                <label for="categorie" class="form-label">Catégorie</label>
                <select class="form-select" id="categorie" name="categorie" required <?php echo $categorie_selected ? 'disabled' : ''; ?>>
                    <option value="">Sélectionner le catégorie</option>
                    <option value="equipments" <?php echo $categorie_selected == 'equipments' ? 'selected' : ''; ?>>Equipments</option>
                    <option value="operations" <?php echo $categorie_selected == 'operations' ? 'selected' : ''; ?>>Operations</option>
                    <option value="soinsmedicaux" <?php echo $categorie_selected == 'soinsmedicaux' ? 'selected' : ''; ?>>Soins Medicaux</option>
                </select>
                <?php if ($categorie_selected): ?>
                    <input type="hidden" name="categorie" value="<?php echo $categorie_selected; ?>">
            </div>
         
            
            
       
    <?php endif; ?>

  
    <div class="mb-3 px-2">
                <label for="payment_method" class="form-label">Mode de Paiement</label>
                <select class="form-select" id="payment_method" name="payment_method" required>
                    <option value="">Sélectionner le Mode de Paiement</option>
                    <option value="credit_card">Carte de Crédit</option>
                    <option value="bank_transfer">Virement Bancaire</option>
                </select>
            </div>
            <div class="mb-3 px-2 d-none" id="otherAmountDiv">
                <label for="otherAmount" class="form-label">Montant personnalisé:</label>
                <input type="number" id="otherAmount" name="otherAmount" class="form-control" min="1">
            </div>
            

            <div id="credit_card_details" class="d-none">
                <div class="mb-3 px-2">
                    <label for="card_number" class="form-label">Numéro de Carte</label>
                    <input type="text" class="form-control" id="card_number" name="card_number" maxlength="15">
                </div>
                <div class="mb-3 px-2">
                    <label for="expiry_date" class="form-label">Date d'Expiration (MM/AAAA)</label>
                    <div class="input-group">
                    <input type="month" class="form-control" id="date" name="expiry_date">
                    <span class="input-group-text bg-warning">
                            <i class="bi bi-date text-white text-center"></i>
                        </span></div>
                </div>
                <div class="mb-3 px-2">
                    <label for="security_code" class="form-label">Code de Sécurité (CVV)</label>
                    <input type="text" class="form-control" id="security_code" name="security_code" maxlength="3">
                </div>
            </div>

            <!-- Section Détails du Virement Bancaire -->
            <div id="bank_transfer_details" class="d-none">
                <div class="mb-3 px-2">
                    <label for="bank_name" class="form-label">Nom de la Banque</label>
                    <select class="form-select" id="bank_name" name="bank_name" required>
                        <option value="">Sélectionner la Banque</option>
                        <option value="Banque de Tunisie">Banque de Tunisie</option>
                        <option value="banque Zitouna">Banque de Zitouna</option>
                        <option value="Banque BH">Banque BH</option>
                        <option value="Banque Attijari">Banque Attijari</option>
                        <option value="Other">Autre</option>
                    </select>
                </div>
                <div id="custom_bank_name" class="mb-3 px-2 d-none">
                    <label for="other_bank" class="form-label">Nom de la Banque (Autre)</label>
                    <input type="text" class="form-control" id="other_bank" name="other_bank">
                </div>
                <div class="mb-3 px-2">
                    <label for="bank_account" class="form-label">Numéro de Compte Bancaire (Commence par TN)</label>
                    <input type="text" class="form-control" id="bank_account" name="bank_account" pattern="^TN\d{12}$" title="Le numéro de compte doit commencer par 'TN' et avoir 12 chiffres" maxlength="14" required>
                </div>
            </div><div class="text-center">
<button type="reset" class="btn " id="btn1">Soumettre le Don</button> 
            <button type="submit" class="btn " id="btn2">Soumettre le Don</button></div>  
             
    </div>  </form></div>

    <script>
        $(document).ready(function () {
            $('#payment_method').change(function () {
                if ($(this).val() == 'credit_card') {
                    $('#credit_card_details').removeClass('d-none');
                    $('#bank_transfer_details').addClass('d-none');
                } else if ($(this).val() == 'bank_transfer') {
                    $('#bank_transfer_details').removeClass('d-none');
                    $('#credit_card_details').addClass('d-none');
                } else {
                    $('#credit_card_details').addClass('d-none');
                    $('#bank_transfer_details').addClass('d-none');
                }
            });

            $('#bank_name').change(function () {
                if ($(this).val() == 'Other') {
                    $('#custom_bank_name').removeClass('d-none');
                } else {
                    $('#custom_bank_name').addClass('d-none');
                }
            });

        });
    </script>
</body>
</html>
