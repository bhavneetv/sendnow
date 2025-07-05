<?php


require '../include/config.php';
session_start();

if(isset($_POST['password']) && isset($_COOKIE['code'])){
    $password = md5($_POST['password']);
    $code = base64_encode($_COOKIE['code']);
    $query = "UPDATE files SET pin_code = '$password' WHERE unique_code = '$code'";
    $result = mysqli_query($db, $query);
    if($result){
        echo "yes";
    }else{
        echo "no";
    }
}
?>