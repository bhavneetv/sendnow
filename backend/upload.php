<?php
require '../include/config.php';
require_once 'clean.php';
session_start();

// $maxSize = 10 * 1024 * 1024; // 10MB
$targetDir = '../files/';
date_default_timezone_set('Asia/Kolkata');
 

// for generate unique code that is not exist in database
function generateCode($db, $length = 7) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $maxAttempts = 10; // Prevent infinite loops
    $attempt = 0;
    
    do {
        $code = substr(str_shuffle(str_repeat($chars, $length)), 0, $length);
        $code1 = base64_encode($code);
        
        // Check if code exists in database
        $stmt = $db->prepare("SELECT id FROM files WHERE unique_code = ?");
        $stmt->bind_param("s", $code1);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return $code; // Return the unique code
        }
        
        $attempt++;
    } while ($attempt < $maxAttempts);
    
    // If we couldn't find a unique code after max attempts, append timestamp
    return $code . time();
}

// for file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $originalName = $file['name'];
    $tmpName = $file['tmp_name'];
    $fileSize = $file['size'];

    $ext = base64_encode(strtolower(pathinfo($originalName, PATHINFO_EXTENSION)));
    $originalName = base64_encode($originalName);
    $code = generateCode($db);
    $code1 = base64_encode($code);
    $newName = $code1; // No extension
    $targetPath = $targetDir . $newName;

    if (!is_dir($targetDir)) mkdir($targetDir, 0775, true);

    if(move_uploaded_file($tmpName, $targetPath)){
        
        date_default_timezone_set('Asia/Kolkata');
        
        $uploadTime = date("Y-m-d H:i:s");
        $expiryTime = date("Y-m-d H:i:s", strtotime("+3 hours"));


        $stmt = $db->prepare("INSERT INTO files (unique_code, original_name, server_name, type, upload_time, expiry_time, file_size) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $code1, $originalName, $newName, $ext, $uploadTime, $expiryTime, $fileSize);
    $stmt->execute();
   
    setcookie("code", $code, time() + (600), "/");

    echo "yes";
}
} else {
    echo "error";
}
