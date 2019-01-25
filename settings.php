<?php
	require_once 'config/database.php';
    if(empty($_SESSION['username']))
    header('Location: login.php');
    else{
        if (!empty($_POST)){
            $errMsg = '';
            if ($_POST['change_username']){
                if (empty($_POST["username"]))
                    $errMsg = "enter new username if you wish to change your username";
                else if (isset($_POST["username"]))
                {
                    $check = $conn->prepare("SELECT * FROM users WHERE username = :name");
                    $check->bindParam(':name', $_POST["username"]);
                    $check->execute();

                    if ($check->rowCount() > 0){
                        $errMsg = "username taken";
                    }
                    else if(strlen($_POST["username"]) <= 6 || strlen($_POST["username"]) >= 50 || ctype_lower($_POST["username"])){
                        $errMsg = "new username must atleast be 6 chars long with capital letters";
                    }
                    else {
                        $sql = $conn->prepare("UPDATE users SET username=? WHERE username=?");
                        $sql->execute(array($_POST["username"], $_SESSION["username"]));
                        $_SESSION["username"] = $_POST["username"];
                    }
                }
            }
            if ($_POST['change_email']){
                if (empty($_POST["email"]))
                    $errMsg = "enter new email if you wish to change your email address";
                else if (isset($_POST["email"]))
                {
                    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                        $errMsg = "invalid email address";
                    }
                    else{
                        $check = $conn->prepare("SELECT * FROM users WHERE email = :mail");
                        $check->bindParam(':mail', $_POST["email"]);
                        $check->execute();

                        if ($check->rowCount() > 0){
                            $errMsg = "email address taken";
                        }
                        else{
                            $sql = $conn->prepare("UPDATE users SET email=? WHERE email=?");
                            $sql->execute(array($_POST["email"], $_SESSION["email"]));
                            $_SESSION["email"] = $_POST["email"];
                        }
                    }
                }
            
            }
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
                        $sql->execute(array($password, $_SESSION["username"]));
                        $_SESSION["password"] = $_POST["password"];
                    }
                }
            }
            if ($_POST["change_notifications"]){
                if (empty($_POST["notifications"]))
                    $errMsg = "enter yes or no small caps to change notifications";
                else if (isset($_POST["notifications"]))
                {
                    if (ctype_lower($_POST['notifications'])){
                        if ((!strcmp($_POST['notifications'], "yes")) || (!strcmp($_POST['notifications'], "no"))){
                            $sql = $conn->prepare("UPDATE users SET notifications=? WHERE username=?");
                            $sql->execute(array($_POST['notifications'], $_SESSION["username"])); 
                        }
                        else {
                            $errMsg = "enter only yes or no";
                        }

                    }
                    else{
                        $errMsg = "enter only small letters";
                    }
                }
            
            }
        }
    }
?>


<html>
<head>
    <meta charset="utf-8" />
    <title>camagru | Preference</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
    <div class="header">
        <h2>change settings</h2>
    </div>
    <form method="POST" action="">
        <div>
        <?php
            echo $errMsg;
        ?>
        </div>
        <div class="input-group">
           <label>new username</label>
            <input type="text" name="username">
        </div>
        <div class="input-group">
            <input type="submit" name="change_username" value="change" class="newc">
        </div>
        <div class="input-group">
           <label>new email</label>
            <input type="text" name="email">
        </div>
        <div class="input-group">
            <input type="submit" name="change_email"  value="change" class="newc">
        </div>
        <div class="input-group">
            <label>new Password</label>
            <input type="password" name="password">
        </div>
        <div class="input-group">
            <input type="submit" name="change_password"  value="change" class="newc">
        </div>
        <div class="input-group">
            <label>Notifications</label>
            <input type="text" name="notifications">
        </div>
        <div class="input-group">
            <input type="submit" name="change_notifications" value="change" class="newc">
        </div>
        <span>
            <a href="home.php">Home page</a>
        </span>
        <span>  
            <a href="logout.php"> logout</a>
        </span>
    </form>
</body>
</html>