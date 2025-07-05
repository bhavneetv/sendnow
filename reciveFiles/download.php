<?php
require '../include/config.php';

$code = $_GET['code'];
$code1 = base64_encode($code);
$result = $db->query("SELECT * FROM files WHERE unique_code='$code1'");
if ($result->num_rows == 0) die("Invalid file.");

$row = $result->fetch_assoc();
$filename = base64_decode($row['original_name']);
$filePath = "../files/" . $code1;

if (!file_exists($filePath)){
    echo "<script>alert('File not found or expired');window.location.href = '../index.php';</script>";
    exit();
} 

header("Content-Description: File Transfer");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
header("Expires: 0");
header("Cache-Control: must-revalidate");
header("Pragma: public");
header("Content-Length: " . filesize($filePath));

flush();
readfile($filePath);
exit;
?>
