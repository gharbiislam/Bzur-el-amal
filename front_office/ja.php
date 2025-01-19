<?php
include('db.php');

$sql = "SELECT reviews.id, users.name, reviews.review_text, reviews.rating, reviews.created_at 
        FROM reviews 
        JOIN users ON reviews.user_id = users.id"; 

$res = mysqli_query($conn, $sql);

if (!$res) {
    die("Query failed: " . mysqli_error($conn));
}

$reviews = [];
while ($row = mysqli_fetch_assoc($res)) {
    $reviews[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews Carousel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">    

    
</head>
<body>

<div class="container my-5">
    <h2 class="text-center titre2">User Reviews</h2>

    <!-- Carousel container for reviews -->
    <div id="carouselContainer" class="carousel-container">
        <div class="d-flex justify-content-center align-items-center">
            <div class="mx-5">
                <i id="prevButton" class="fas fa-chevron-left"></i>
            </div>
            <div>
                <h5 id="reviewerName"></h5>
                <p id="reviewText" class="review-text"></p>
                <p id="reviewRating" class="rating"></p>
                <!-- Added created date -->
                <p id="createdDate" class="text-muted" style="font-size: 0.8em;"></p>
            </div>  
            <div class="mx-5">
                <i id="nextButton" class="fas fa-chevron-right"></i>
            </div>
        </div>

        <div class="carousel-btns">
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let currentReviewIndex = 0;
    const reviews = <?php echo json_encode($reviews); ?>;

    // Function to display the current review
    function displayReview(index) {
        const review = reviews[index];
        const reviewerName = document.getElementById('reviewerName');
        const reviewText = document.getElementById('reviewText');
        const reviewRating = document.getElementById('reviewRating');
        const createdDate = document.getElementById('createdDate');

        reviewerName.textContent = review.name;
        reviewText.textContent = review.review_text;
        
        // Generate star rating
        let stars = '';
        for (let i = 0; i < review.rating; i++) {
            stars += '★';
        }
        for (let i = review.rating; i < 5; i++) {
            stars += '☆';
        }
        reviewRating.textContent = stars;

        // Format and display the created date
        const formattedDate = new Date(review.created_at).toLocaleDateString();
        createdDate.textContent = `Created on: ${formattedDate}`;
    }

    // Display the first review
    displayReview(currentReviewIndex);

    // Next button functionality
    document.getElementById('nextButton').addEventListener('click', function() {
        currentReviewIndex++;
        if (currentReviewIndex >= reviews.length) {
            currentReviewIndex = 0;
        }
        displayReview(currentReviewIndex);
    });

    document.getElementById('prevButton').addEventListener('click', function() {
        currentReviewIndex--;
        if (currentReviewIndex < 0) {
            currentReviewIndex = reviews.length - 1; 
        }
        displayReview(currentReviewIndex);
    });

    setInterval(function() {
        currentReviewIndex++;
        if (currentReviewIndex >= reviews.length) {
            currentReviewIndex = 0; 
        }
        displayReview(currentReviewIndex);
    }, 5000);
</script>

</body>
</html>

<?php
$conn->close();
?>
