<?php
    require_once 'config/database.php';
    if (isset($_POST["reset_email"])){
        $errMsg = '';
        if (empty($_POST["email"]))
            $errMsg = "Enter email address";
        else{
            $email = trim($_POST["email"]);
            $sql = "SELECT * FROM users WHERE email=?";
            $check = $conn->prepare($sql);
            $check->execute(array($email));
            $pass = $check->fetch(PDO::FETCH_ASSOC);

            if (empty($pass))
                $errMsg = "email address not found";
            else{
                $token_to_shuffle = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
                $token = substr(str_shuffle($token_to_shuffle),0,10);
                $username = $pass['username'];
                $location = "http://localhost:8080/camagru/reset_confirm.php?username=$username&key=$token";
                $massage = "Please click on the link below to reset your password\n\n".$location;
                mail($email,"Reset Password",$massage);
                $sql = "UPDATE users SET token = ? WHERE email=?";
                $check = $conn->prepare($sql);
                $check->execute(array($token,$email));
                $errMsg = "go to your email for further instructions.";
            }
        }
    }
?>
<html>
<head>
    <title>camagru | reset</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="header">
    <h2>Reset password</h2>
</div>
<form action="reset_pass.php" method="post">
    <div>
    <p>
    </p>
    </div>
    <div><?php echo $errMsg?></div>
    <div class="input-group">
        <input type="text" name="email" placeholder="email"><br>
    </div>
    <div class="input-group">
        <input type="submit" name="reset_email" class="btn" value="Request Password">
    </div>
    <div><a href="index.php">welcome page</a></div>
</form>
</body>
</html>