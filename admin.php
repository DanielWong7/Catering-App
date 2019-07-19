<?php
	require "reqAdmin.php";
?>
<!DOCTYPE html>
<html>
	<link rel="stylesheet" type="text/css" href="admin.css">
<body>
	<!--3 Buttons that redirect-->
<form action="../signup_page.php" method="post"> 
	<button type="submit" >Sign Up</button>
</form>
<!--<form action="../privileges.php" method="post"> 
	<button type="submit" >Edit Privileges</button>
</form>-->
<form action="../delete_user.php" method="post">
	<button type="submit"name="delete-user">Delete Users</button> 
</form>
<form action="../form.php" method="post">
	<button  type="submit"name="form-submit">Form</button> 
</form>
<form action="../logout.php" method="post">
	<button  type="submit"name="logout-submit">Logout</button> 
</form>

</body>
</html>