<?php 
require_once 'db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $review_text = mysqli_real_escape_string($conn, $_POST['review_text']);
    $rating = (int)$_POST['rating'];

    $check_review_query = "SELECT * FROM reviews WHERE user_id = $user_id";
    $result = mysqli_query($conn, $check_review_query);

    if (mysqli_num_rows($result) > 0) {
        $review = mysqli_fetch_assoc($result);
        $review_id = $review['id'];

        $update_query = "UPDATE reviews SET review_text = '$review_text', rating = $rating WHERE id = $review_id AND user_id = $user_id";
        if (mysqli_query($conn, $update_query)) {
            header('Location: ' . $_SERVER['PHP_SELF'] . '?success=true');
            exit;
        }
    } else {
        $insert_query = "INSERT INTO reviews (user_id, review_text, rating) VALUES ($user_id, '$review_text', $rating)";
        if (mysqli_query($conn, $insert_query)) {
            header('Location: ' . $_SERVER['PHP_SELF'] . '?success=true');
            exit;
        }
    }
}

if (isset($_GET['delete'])) {
    $review_id = (int)$_GET['delete'];

    $delete_query = "DELETE FROM reviews WHERE id = $review_id AND user_id = $user_id";
    if (mysqli_query($conn, $delete_query)) {
        header('Location: ' . $_SERVER['PHP_SELF'] . '?success=true');
        exit;
    }
}

$review_query = "SELECT * FROM reviews WHERE user_id = $user_id";
$review_result = mysqli_query($conn, $review_query);
$review_data = mysqli_fetch_assoc($review_result);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avis des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">

    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .star-rating {
            display: inline-block;
            direction: rtl;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            font-size: 30px;
            color: #ccc;
            cursor: pointer;
        }
        .star-rating input:checked ~ label {
            color: gold;
        }
        .star-rating input:hover ~ label {
            color: gold;
        }
    </style>
</head>
<body class="container mt-5">

    <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
        <div class="alert alert-success">Action effectuée avec succès!</div>
    <?php endif; ?>

    <h2 class="titre2 mt-5" ><?php echo $review_data ? 'Modifier votre avis' : 'Soumettre un avis'; ?></h2>
    <form action="review.php" method="post">
        <textarea name="review_text" rows="4" cols="50" class="form-control" placeholder="Écrivez votre avis ici..." required><?php echo $review_data['review_text'] ?? ''; ?></textarea><br><br>

        <div class="star-rating">
            <input type="radio" id="star5" name="rating" value="5" <?php echo $review_data && $review_data['rating'] == 5 ? 'checked' : ''; ?> required>
            <label for="star5">&#9733;</label>
            <input type="radio" id="star4" name="rating" value="4" <?php echo $review_data && $review_data['rating'] == 4 ? 'checked' : ''; ?>>
            <label for="star4">&#9733;</label>
            <input type="radio" id="star3" name="rating" value="3" <?php echo $review_data && $review_data['rating'] == 3 ? 'checked' : ''; ?>>
            <label for="star3">&#9733;</label>
            <input type="radio" id="star2" name="rating" value="2" <?php echo $review_data && $review_data['rating'] == 2 ? 'checked' : ''; ?>>
            <label for="star2">&#9733;</label>
            <input type="radio" id="star1" name="rating" value="1" <?php echo $review_data && $review_data['rating'] == 1 ? 'checked' : ''; ?>>
            <label for="star1">&#9733;</label>
        </div><br><br>

        <button type="submit" class="btn" id="btn2"><?php echo $review_data ? '<i class="fas fa-edit"></i>' : 'Soumettre l\'avis'; ?></button>
    <?php if ($review_data): ?>
        <a href="review.php?delete=<?php echo $review_data['id']; ?>" class="btn btn-danger mt-3" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet avis ?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
        <?php endif; ?></form>
    <div class="alert alert-warning mt-3">
        <h5 class="text-warning"><i class="fas fa-triangle-exclamation"></i>attention!!</h5>
        <p > Vous ne pouvez laisser qu'un seul avis. Veuillez modifier votre avis existant si vous souhaitez apporter des changements.</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
