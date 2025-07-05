<?php
require("../../include/config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = md5($_POST["password"]);
    $uniq_code = base64_encode($_POST["uniq_code"]);
    // echo $uniq_code;

    $sql = "SELECT * FROM files WHERE unique_code = '$uniq_code'";
    $result = $db->query($sql);

    if ($result->num_rows == 0) {
        echo "Invalid code";
        exit();
    }

    $row = $result->fetch_assoc();
    $pin = $row["pin_code"];
    if($pin == $password){
       $_SESSION['uniqe_code'] = $uniq_code;
      
    }
    // echo $pin;

    echo $pin.";".$password;


}

?>