
<?php
include '../php/db.php';

$branches = $conn->query("SELECT * FROM branches ORDER BY name");

if ($branches->num_rows > 0) {
    while($branch = $branches->fetch_assoc()) {
        echo '
        <div class="branch-card">
            <h3>'.$branch['name'].'</h3>
            <p><i class="fas fa-map-marker-alt"></i> '.$branch['address'].'</p>
            <p><i class="fas fa-phone"></i> '.$branch['phone'].'</p>
            <a href="'.$branch['map_link'].'" target="_blank" class="text-gold">View on Map</a>
        </div>';
    }
} else {
    echo '<p>No branches found</p>';
}
?>