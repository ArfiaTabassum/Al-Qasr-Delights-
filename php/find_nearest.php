<?php
include '../php/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_lat = $_POST['lat'];
    $user_lng = $_POST['lng'];
    
    $branches = $conn->query("
        SELECT *, 
        ( 6371 * acos( 
            cos( radians($user_lat) ) 
            * cos( radians( lat ) ) 
            * cos( radians( lng ) - radians($user_lng) ) 
            + sin( radians($user_lat) ) 
            * sin( radians( lat ) ) 
        ) ) AS distance 
        FROM branches 
        ORDER BY distance ASC 
        LIMIT 3
    ");
    
    if ($branches->num_rows > 0) {
        while($branch = $branches->fetch_assoc()) {
            echo '
            <div class="branch-card">
                <span class="distance-badge">'.round($branch['distance'], 1).' km away</span>
                <h3>'.$branch['name'].'</h3>
                <p><i class="fas fa-map-marker-alt"></i> '.$branch['address'].'</p>
                <p><i class="fas fa-phone"></i> '.$branch['phone'].'</p>
                <a href="'.$branch['map_link'].'" target="_blank" class="text-gold">View on Map</a>
            </div>';
        }
    } else {
        echo '<div class="branch-card"><p>No branches found near your location</p></div>';
    }
}
?>
