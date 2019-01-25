<?php
    require_once 'config/database.php';

    if (empty($_GET["username"]) || empty($_GET["key"])){
        echo "technical error please register again";
    }
    else{
        $sql = "SELECT * FROM users WHERE username=?";
        $check = $conn->prepare($sql);
        $check->execute(array($_GET["username"]));
        $data = $check->fetch(PDO::FETCH_ASSOC);
        if ($data["token"] == $_GET["key"]){
            if ($_POST["change_password"]){
                if (empty($_POST["password"]))
                    $errMsg = "enter new password if you wish to change your password";
                else if (isset($_POST["password"]))
                {
                    $password = $_POST["password"];
                    if(strlen($password) <= 6 || strlen($password) >= 50 || ctype_lower($password)){
                        $errMsg = "password must atleast be 6 characters with capital letters";
                    }
                    else{
                        $password = password_hash($password, PASSWORD_DEFAULT);
                        $sql = $conn->prepare("UPDATE users SET password=? WHERE username=?");
                        $sql->execute(array($password, $_GET["username"]));
                        $errMsg = "change password successfull.";
                        header("Refresh: 2; url=login.php");
                    }
                }
            }
    }
}   
    
?>
<html>
<head>
    <meta charset="utf-8" />
    <title>camagru | reset_password</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
    <div class="header">
        <h2>Sign up</h2>
    </div>
    <form method="POST" action="">
        <!-- diplaying validation error -->
        <div>
        <?php
            echo $errMsg;
        ?>
        </div>
        <div class="input-group">
            <label>new Password</label>
            <input type="password" name="password">
        </div>
        <div class="input-group">
            <input type="submit" name="change_password"  value="change" class="newc">
        </div>
        <a href="index.php">Welcome page</a>
    </form>
</body>
</html>