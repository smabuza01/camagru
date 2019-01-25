<?php
    require_once 'config/database.php';

    if (empty($_GET["username"]) || empty($_GET["key"]) || empty($_GET["time"])){
        echo "technical error please register again";
    }
    else{
        $time = time();
        $sql = "SELECT * FROM users WHERE username=?";
        $check = $conn->prepare($sql);
        $check->execute(array($_GET["username"]));
        $data = $check->fetch(PDO::FETCH_ASSOC);
        if ((md5($data["email"]) == $_GET["key"]) && ($time - $_GET["time"]) <= (60*1)){
            $sql = "UPDATE users SET confirm_email = '1' WHERE username=?";
            $check= $conn->prepare($sql);
            $check->execute(array($_GET["username"]));
            header('location: login.php');
        }
    }
    
?>
<!DOCTYPE html>
<html>
<head>
    <title>camagru | confirm</title>
</head>
<body>
     <a href="index.php">welcome page</a>
</body>
</html>