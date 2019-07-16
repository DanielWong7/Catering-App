<?php
	require "reqAdmin.php";
?>
<main>
	<link rel="stylesheet" type="text/css" href="globalStyle.css">
	<link rel="stylesheet" type="text/css" href="loginStyle.css">

	<div class="wrapper">
	<!--For admin user to create new normal user-->
	<h1>Signup</h1>
	<form action="../signupCon.php" method="post">
		<input type="text" name="uid" placeholder="Username">
		<input type="password" name="pwd" placeholder="Password">
		<input type="password" name="pwd-repeat" placeholder="Repeat Password">
		<button type="submit" name="signup-submit">Signup</button>
	</form>
	<!--Moves admin user back to admin page-->
	<form action="../admin.php">
		<button type="submit">Back</button>
	</form>
</div>
</main>