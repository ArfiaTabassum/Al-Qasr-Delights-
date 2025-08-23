<?php
session_start();
include '../php/db.php';
require '../php/PHPMailer/PHPMailer.php';
require '../php/PHPMailer/SMTP.php';
require '../php/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize variables
$found = false;
$deleted = false;
$reservation = [];

// Handle find reservation logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['find'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // Get only the most recent PENDING reservation
    $stmt = $conn->prepare("SELECT * FROM reservations 
                          WHERE full_name=? AND email=? AND phone=? AND status='pending'
                          ORDER BY created_at DESC LIMIT 1");
    $stmt->bind_param("sss", $name, $email, $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $reservation = $result->fetch_assoc();
        $found = true;
        $_SESSION['on_cancel_form'] = true; // Keep on cancel form
    } else {
        echo "<script>alert('No pending reservation found with these details.');</script>";
    }
    
    // Repopulate form values
    $_POST['name'] = $name;
    $_POST['email'] = $email;
    $_POST['phone'] = $phone;
}
// Handle delete action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
  $id = $_POST['id'];
  $email = $_POST['email'];
  $name = $_POST['name'];
  $branch = $_POST['branch'];
  $dates = $_POST['dates'];
  $time = $_POST['time_slot'];
  $edays = $_POST['edays'];
  $guests = $_POST['guests'];

  // Start transaction
  $conn->begin_transaction();
  
  try {
      // 1. Archive reservation
      $archiveSql = "INSERT INTO deleted_reservations 
                    SELECT * FROM reservations WHERE id=?";
      $stmt = $conn->prepare($archiveSql);
      $stmt->bind_param("i", $id);
      $stmt->execute();

      // 3. Delete reservation
      $deleteSql = "DELETE FROM reservations WHERE id=?";
      $stmt = $conn->prepare($deleteSql);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      
      // 4. Send confirmation email - ADDED HERE
      $mail = new PHPMailer(true);
      try {
          $mail->isSMTP();
          $mail->Host = "smtp.gmail.com";
          $mail->SMTPAuth = true;
          $mail->Username = "ummehani99800@gmail.com";
          $mail->Password = "xwgn ecba yfqt qbpl";
          $mail->SMTPSecure = "tls";
          $mail->Port = 587;

          $mail->setFrom("ummehani99800@gmail.com", "Qasr-Delights");
          $mail->addAddress($email);
          $mail->isHTML(true);
          $mail->Subject = "Reservation Deleted - QASR_DELIGHTS";
          $mail->Body = "Dear $name,<br><br>Your reservation at <strong>$branch</strong> on <strong>$dates</strong> at <strong>$time</strong> has been successfully deleted.<br><br>Thank you for letting us know.<br><br>Regards,<br>Arabian Fine Dining";
          $mail->send();
      } catch (Exception $e) {
          error_log("Email error: " . $e->getMessage());
      }

      // Commit transaction
      $conn->commit();
      
      // Success handling
      unset($_SESSION['on_cancel_form']);
      echo "<script>
          alert('Reservation and all order items deleted successfully. Confirmation email sent.');
          window.location.href = 'reservation.php';
      </script>";
      exit();
      
  } catch (Exception $e) {
      $conn->rollback();
      echo "<script>alert('Deletion failed: " . addslashes($e->getMessage()) . "');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservation - Arabian Fine Dining</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../css/reservation.css">

 </head>
<body>
  <!-- Fullscreen Background with Overlay -->
  <div class="fullscreen-bg"></div>
  <div class="fullscreen-overlay"></div>
  
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
  
  <!-- Main Content -->
  <div class="reservation-container">
    <div class="content-wrapper">
      <!-- Heading -->
      <h1 class="gold-heading">Reservation</h1>
      
      <!--toggele -->
      <div class="toggle-buttons">
        <button id="make-btn" class="toggle-btn active">Make Reservation</button>
        <button id="cancel-btn" class="toggle-btn">Cancel Reservation</button>
      </div>
      
      <!-- Make Reservation Form -->
      <div id="make-form" class="form-container <?= !isset($_SESSION['on_cancel_form']) ? 'active' : '' ?>">
        <?php if (!isset($_SESSION["otp_sent"])): ?>
        <form action="../php/send_otp.php" method="POST">
          <div class="form-group">
            <label for="name">Full Name:</label>
            <input type="text" class="form-control" name="full_name" required>
          </div>
          <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="text" class="form-control" name="phone" required>
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" required>
          </div>
          <button type="submit" class="btn-gold">Generate OTP</button>
        </form>

        <?php elseif ($_SESSION["otp_sent"] === true && $_SESSION["otp_verified"] !== true): ?>
          <div style="text-align: center;">
            <div class="form-group">
              <label style="font-size: 1.2rem; color: var(--gold);">Verify OTP:</label>
              <?php if (isset($_SESSION['otp_error'])): ?>
                <p style="color: #ff6b6b; margin-top: 10px;"><?php echo $_SESSION['otp_error']; unset($_SESSION['otp_error']); ?></p>
              <?php else: ?>
                <script>alert("OTP is sent to your mail. Check your spam folder and verify the OTP.");</script>
              <?php endif; ?>
            </div>
            
            <form action="../php/verify_otp.php" method="POST">
              <div class="form-group">
                <input type="text" name="otp" placeholder="Enter OTP" required class="form-control text-center" style="font-size: 18px;">
              </div>
              <button type="submit" class="btn-gold">Verify OTP</button>
            </form>
          </div>

        <?php elseif ($_SESSION["otp_verified"] === true): ?>
          <form action="../php/save_reservation.php" method="POST">
            <div class="form-group">
              <label for="branch">Select Branch:</label>
              <select class="form-select" name="branch" required>
                <option value="" disabled selected>Select Branch</option>
                <?php
                $branches = $conn->query("SELECT name FROM branches");
                while ($row = $branches->fetch_assoc()) {
                  echo '<option value="' . htmlspecialchars($row['name']) . '">' . htmlspecialchars($row['name']) . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="guests">Number of Guests:</label>
              <input type="number" class="form-control" name="guests" min="1" max="20" required>
            </div>
            <div class="form-group">
              <label for="time">Select Time Slot:</label>
              <select class="form-select" name="time_slot" required>
                <option value="11:00 AM">11:00 AM</option>
                <option value="12:00 PM">12:00 PM</option>
                <option value="1:00 PM">1:00 PM</option>
                <option value="2:00 PM">2:00 PM</option>
                <option value="3:00 PM">3:00 PM</option>
                <option value="5:00 PM">5:00 PM</option>
                <option value="6:00 PM">6:00 PM</option>
                <option value="7:00 PM">7:00 PM</option>
                <option value="8:00 PM">8:00 PM</option>
                <option value="9:00 PM">9:00 PM</option>
              </select>
            </div>
            <div class="form-group">
              <label for="dates">Date:</label>
              <select name="dates" id="dates" class="form-select" required>
                <?php
                for ($i = 0; $i <= 5; $i++) {
                  $date = date('Y-m-d', strtotime("+$i days"));
                  echo "<option value=\"$date\">$date</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="edays">Day:</label>
              <input type="text" name="edays" id="edays" class="form-control" readonly>
            </div>
            <?php if (isset($_SESSION['order_number'])): ?>  
    <div class="form-group">  
        <h5>Your Order</h5>  
        <table class="elegant-gold-table">  
            <thead>  
                <tr><th>Item</th><th>Price</th><th>Qty</th><th>Total</th></tr>  
            </thead>  
            <tbody>  
                <?php  
                $order_query = $conn->prepare("SELECT * FROM orders WHERE order_number = ?");  
                $order_query->bind_param("s", $_SESSION['order_number']);  
                $order_query->execute();  
                $order_items = $order_query->get_result();  

                while ($item = $order_items->fetch_assoc()):  
                ?>  
                    <tr>  
                        <td><?= htmlspecialchars($item['item_name']) ?></td>  
                        <td>₹<?= $item['price'] ?></td>  
                        <td><?= $item['quantity'] ?></td>  
                        <td>₹<?= $item['price'] * $item['quantity'] ?></td>  
                    </tr>  
                <?php endwhile; ?>  
            </tbody>  
        </table>  
    </div>  
    <?php if (isset($_SESSION['order_number'])): ?>
    <input type="hidden" name="order_number" value="<?= htmlspecialchars($_SESSION['order_number']) ?>">
<?php endif; ?>
<?php endif; ?>
            <button type="submit" class="btn-gold">Submit Reservation</button>
          </form>
        <?php endif; ?>
      </div>

      <div id="cancel-form" class="form-container <?= isset($_SESSION['on_cancel_form']) ? 'active' : '' ?>">
    <?php if (!isset($found) || !$found): ?>
    <form method="POST">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" required 
                   value="<?= $_POST['name'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required
                   value="<?= $_POST['email'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" required
                   value="<?= $_POST['phone'] ?? '' ?>">
        </div>
        <button type="submit" name="find" class="btn-gold">Find My Reservation</button>
    </form>
    <?php elseif ($found): ?>
      <form method="POST">
        <input type="hidden" name="id" value="<?= $reservation['id'] ?>">
        <input type="hidden" name="email" value="<?= $reservation['email'] ?>">
        <input type="hidden" name="name" value="<?= $reservation['full_name'] ?>">
        <input type="hidden" name="branch" value="<?= $reservation['branch'] ?>">
        <input type="hidden" name="dates" value="<?= $reservation['dates'] ?>">
        <input type="hidden" name="time_slot" value="<?= $reservation['time_slot'] ?>">
        
        <div class="reservation-details">
          <h4>Your Reservation Details</h4>
          <table class="reservation-table">
            <tr><th>Branch</th><td><?= $reservation['branch'] ?></td></tr>
            <tr><th>Date</th><td><?= $reservation['dates'] ?></td></tr>
            <tr><th>Time Slot</th><td><?= $reservation['time_slot'] ?></td></tr>
            <tr><th>Guests</th><td><?= $reservation['guests'] ?></td></tr>
          </table>
        </div>
    
        <div class="action-buttons mt-4">
          <button type="submit" name="delete" class="btn-gold">Confirm Deletion</button>
          <button type="button" onclick="location.href='reservation.php'" class="btn btn-secondary">Cancel</button>
        </div>
      </form>
    <?php endif; ?>
  </div>

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
    // Toggle between forms
    document.getElementById("make-btn").addEventListener("click", function() {
      this.classList.add("active");
      document.getElementById("cancel-btn").classList.remove("active");
      document.getElementById("make-form").classList.add("active");
      document.getElementById("cancel-form").classList.remove("active");
    });
    
    document.getElementById("cancel-btn").addEventListener("click", function() {
      this.classList.add("active");
      document.getElementById("make-btn").classList.remove("active");
      document.getElementById("cancel-form").classList.add("active");
      document.getElementById("make-form").classList.remove("active");
    });
    
    // Menu toggle
    function toggleMenu() {
      var menu = document.getElementById("menu");
      menu.classList.toggle("show");
    }
    
    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
      const menuButton = document.querySelector('.menu-button');
      const dropdownMenu = document.getElementById('menu');
      if (event.target !== menuButton && !menuButton.contains(event.target)) {
        dropdownMenu.classList.remove("show");
      }
    });
    
    // Date to day conversion
    document.getElementById("dates").addEventListener("change", function() {
      const dateValue = this.value;
      const dayBox = document.getElementById("edays");
      
      if (dateValue) {
        const selectedDate = new Date(dateValue);
        const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        const dayName = days[selectedDate.getDay()];
        dayBox.value = dayName;
      } else {
        dayBox.value = "";
      }
    });
    // Modified toggle function to prevent switching during cancel process
    document.getElementById("make-btn").addEventListener("click", function() {
        <?php if (!isset($_SESSION['on_cancel_form'])): ?>
            this.classList.add("active");
            document.getElementById("cancel-btn").classList.remove("active");
            document.getElementById("make-form").classList.add("active");
            document.getElementById("cancel-form").classList.remove("active");
        <?php endif; ?>
    });
    
    document.getElementById("cancel-btn").addEventListener("click", function() {
        this.classList.add("active");
        document.getElementById("make-btn").classList.remove("active");
        document.getElementById("make-form").classList.remove("active");
        document.getElementById("cancel-form").classList.add("active");
    });
   
  </script>
</body>
</html>