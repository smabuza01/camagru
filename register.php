<?php
	require_once 'config/database.php';

	if(isset($_POST["register"])) {
		$errMsg = '';

		
		$username = trim($_POST['username']);
		$email = trim($_POST['email']);
        $password = trim($_POST['password_1']);
        $password_2 = trim($_POST['password_2']);
        $notifications = "yes";

		if(strlen($username) <= 6 || strlen($username) >= 50 || ctype_lower($username))
			$errMsg = "username must atleast be 6 chars with capital letters";
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			$errMsg = "invalid email address";
		else if(strlen($password) <= 6 || strlen($password) >= 50 || ctype_lower($password))
			$errMsg = "password must atleast be 6 characters with capital letter";
        else if ($password != $password_2)
            $errMsg = "The two passwords do not match";
        else if ($conn->query("SELECT username FROM users WHERE username=\"".$username."\";")->fetch())
            $errMsg = "Username already taken.";
        else if ($conn->query("SELECT email FROM users WHERE email=\"".$email."\";")->fetch())
            $errMsg = "Email already taken.";

		if(empty($errMsg)){
			try {
                $token = "none";
                $time = time();
                $password = password_hash($password, PASSWORD_DEFAULT);
				$stmt = $conn->prepare('INSERT INTO users (username, email, password, notifications, token) VALUES (:username, :email, :password, :noti, :toke)');
				$stmt->execute(array(
					':username' => $username,
					':email' => $email,
                    ':password' => $password,
                    ':noti' => $notifications,
                    ':toke' => $token,
                ));
                $rand = md5($email);
                $location = "http://localhost:8080/camagru/confirm.php?time=$time&username=$username&key=$rand";
                $massage = "Please confirm your email address by clicking the link below\n\n".$location;
                mail($email, "Camagru Confirmation mail" ,$massage);
                echo "Registration successfull. Please confirm email address within 1 minute to login";
                header("Refresh: 2; url=index.php");
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
	}
?>

<html>
<head>
    <meta charset="utf-8" />
    <title>camagru | register</title>
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
           <label>Username</label>
            <input type="text" name="username" required>
        </div>
        <div class="input-group">
           <label>Email</label>
            <input type="text" name="email" required>
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password_1" required>
        </div>
        <div class="input-group">
            <label>Confirm Password</label>
            <input type="password" name="password_2" required>
        </div>
        <div class="input-group">
            <button type="submit" name="register" class="btn">Sign up</button>
        </div>
        <p>
            click signup then <a href="login.php"> Sign in</a>
        </p>
		<p>
			<br><a href="index.php">welcome page</a>
		</p>
    </form>
</body>
</html>