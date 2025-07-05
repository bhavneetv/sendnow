<?php
require '../include/config.php';

$targetDir = '../files/';

date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');

$query = "SELECT id, server_name, expiry_time FROM files WHERE status = 'active'";
$result = $db->query($query);

if ($result && $result->num_rows > 0) {
   
    while ($row = $result->fetch_assoc()) {
        if ($row['expiry_time'] <= $currentTime) {
            $filePath = $targetDir . $row['server_name'];

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $stmt = $db->prepare("UPDATE files SET status = 'expired' WHERE id = ?");
            $stmt->bind_param("i", $row['id']);
            $stmt->execute();
          
        }
    }
   

    
} else {
    
}
