<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - Qasr-Delights</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/review.css">
</head>

<body>
    <!-- Dropdown Menu Button -->
<button class="menu-button" onclick="toggleMenu()" aria-label="Toggle menu">☰</button>

<!-- Dropdown Menu -->
<ul id="menu" class="dropdown-menu">
  <li><a href="index.html"><i class="fas fa-home"></i> Home</a></li>
  <li><a href="menu.php"><i class="fas fa-utensils"></i> Menu</a></li>
  <li><a href="about.html"><i class="fas fa-info-circle"></i> About Us</a></li>
  <li><a href="contact.html"><i class="fas fa-envelope"></i> Contact Us</a></li>
  <li><a href="gallery.html"><i class="fas fa-camera"></i> Gallery</a></li>
  <li><a href="branches.html"><i class="fas fa-map-marker-alt"></i> Branches</a></li>
  <li><a href="reservation.php"><i class="fas fa-calendar-check"></i> Reservation</a></li>
  <li><a href="review.php"><i class="fas fa-star"></i> Review</a></li>
</ul>

    <h1 class="page-title">REVIEWS</h1>

    <div class="main-container">
        <!-- Left side: Reviews display (60%) -->
        <div class="reviews-section">
            <?php
            include '../php/db.php';

            $query = "SELECT name, rating, comment FROM reviews ORDER BY created_at DESC LIMIT 3";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $stars = str_repeat("★", $row['rating']) . str_repeat("☆", 5 - $row['rating']);
                    echo '<div class="review-item">';
                    echo '<div class="review-name">' . htmlspecialchars($row['name']) . '</div>';
                    echo '<div class="review-stars">' . $stars . '</div>';
                    echo '<div class="review-comment">' . htmlspecialchars($row['comment']) . '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="review-item"><div class="review-comment">No reviews yet. Be the first to review!</div></div>';
            }

            $conn->close();
            ?>
        </div>

        <!-- Right side: Review form (40%) -->
        <div class="form-section">
            <div class="review-form">
                <h3 class="text-center mb-4" style="color: var(--gold);">Share Your Experience</h3>
                <form id="reviewForm" action="../php/submit_review.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Your Rating</label>
                        <div class="star-rating">
                            <i class="fas fa-star" data-rating="1"></i>
                            <i class="fas fa-star" data-rating="2"></i>
                            <i class="fas fa-star" data-rating="3"></i>
                            <i class="fas fa-star" data-rating="4"></i>
                            <i class="fas fa-star" data-rating="5"></i>
                        </div>
                        <input type="hidden" name="rating" id="selectedRating" required>
                    </div>

                    <div class="mb-3">
                        <label for="comment" class="form-label">Your Review</label>
                        <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>
            </div>
        </div>
    </div>
        <!-- Footer -->
<footer class="arabian-footer">
  <div class="footer-content">
    <div class="footer-links">
      <a href="index.html">Home</a>
      <a href="menu.php">Menu</a>
      <a href="about.html">About Us</a>
      <a href="contact.html">Contact</a>
      <a href="gallery.html">Gallery</a>
      <a href="branches.html">Branches</a>
      <a href="reservation.php">Reservation</a>
      <a href="review.php">Reviews</a>
    </div>
    <div class="copyright">
    © 2025 Qasr Delights | Arabian Fine Dining. All rights reserved.
    </div>
  </div>
</footer>
   

    <script>
        // Rating selection with stars
        const stars = document.querySelectorAll('.star-rating i');
        const ratingInput = document.getElementById('selectedRating');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const rating = star.getAttribute('data-rating');
                ratingInput.value = rating;
                
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });
        });

        // Toggle menu function
        function toggleMenu() {
            const menu = document.getElementById("menu");
            menu.classList.toggle("show");
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const menuButton = document.querySelector('.menu-button');
            const dropdownMenu = document.getElementById('menu');
            
            if (!menuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove('show');
            }
        });

        // Form submission feedback
        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            alert('Thank you for your review!');
        });
    </script>
</body>

</html>