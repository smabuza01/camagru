<html>
<head><title>Forgot Password</title></head>
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
			<div style="background-color:#006D9C; color:#FFFFFF; padding:10px;"><b>Forgot Password</b></div>
			<?php
				if(isset($viewpass)){
					echo '<div style="color:#198E35;text-align:center;font-size:17px;margin-top:5px">'.$viewpass.'</div>';
				}
			?>
			<div style="margin: 15px">
				<form action="" method="post">
					<input type="text" name="email" placeholder="email" autocomplete="off" class="box"/><br /><br />
					<input type="submit" name='forgotpass' value="reset" class='submit'/><br />
				</form>
			</div>
		</div>
	</div>
</body>
</html>