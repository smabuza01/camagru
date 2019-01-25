

<?php
	require_once 'config/database.php';

	if(isset($_POST['signin'])) {
		$errMsg = '';

		// Get data from FORM
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);

		if(empty($username))
			$errMsg = 'Enter username';
		else if(empty($password))
			$errMsg = 'Enter password';

		if(empty($errMsg)) {
			try {
				$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
				$stmt->execute(array($username));
				$data = $stmt->fetch(PDO::FETCH_ASSOC);

				if(empty($data)){
					$errMsg = "User $username not found.";
				}
				else {
					if ($data["confirm_email"] > 0)
					{
						if(password_verify($password,$data['password'])) {
							echo "$password\n\n".$data["password"];
							$_SESSION['username'] = $data['username'];
							$_SESSION['email'] = $data['email'];
							$_SESSION['password'] = $data['password'];
							
							header('Location: home.php');
							exit;
						}
						else
						{
							$errMsg = 'Password not match.';
						}
					}
					else {
						$errMsg = "Please confirm your email address";
					}
				}
			}
			catch(PDOException $e) {
				$errMsg = $e->getMessage();
			}
		}
	}
?>

<html>
<head>
    <meta charset="utf-8" />
    <title>camagru | login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
	<?php
		if(isset($errMsg)){
			echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
		}
	?>
    <div class="header">
        <h2>sign in</h2>
    </div>
    <form method="POST" action="">
        <div class="input-group">
           <label>Username</label>
            <input type="text" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>">
        </div>
        </div>
        <div class="input-group">
            <button type="submit" name="signin" class="btn">Sign in</button>
        </div>
        <p>
            want join us ? <a href="register.php"> Sign up</a>
        </p>
		<p>
			<br><a href="index.php">welcome page</a>
		</p>
    </form>
</body>
</html>