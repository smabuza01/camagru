<?php
	require_once 'config/database.php';
	if(empty($_SESSION['username']))
		header('Location: login.php');
?>

<html>
<head><title>camagru | home</title></head>
	<style>
	html, body {
		margin: 1px;
		border: 0;
	}
	</style>
<body>
	<div align="center">
		<div style=" border: solid 1px #006D9C; " align="left">
			<?php
				if(isset($errMsg)){
					echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
				}
			?>
			<div style="background-color:#006D9C; color:#FFFFFF; padding:10px;"><b><?php echo $_SESSION['name']; ?></b></div>
			<div style="margin: 15px">
				Welcome <?php echo $_SESSION['username']; ?> <br>

				<a href="logout.php">Logout</a><br>
				<a href="settings.php">Preference</a><br>
				<a href="camera.php">gallery</a>				
			</div>
		</div>
	</div>
</body>
</html>