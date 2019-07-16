<!--Vulnerable to SQL injection attacks (The login system isn't).-->
<?php
	require "reqAdmin.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="globalStyle.css">
	<link rel="stylesheet" type="text/css" href="loginStyle.css">
</head>
<body>
	<h4>1 is Yes, 0 is No</h4>
<?php
//creates a table from the loginsystem database and displays
	require 'loginSystemConn.php';
    $sql = "SELECT * FROM users;";
    $result = mysqli_query( $conn, $sql );
	echo "<table id='datatable'>";
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck>0){
	    echo "  <tr><th>ID</th><th>UID</th><th>View Tables</th><th>Delete Records</th><th>Edit Records</th></tr>";
	    while($all =mysqli_fetch_assoc($result) ){
	        echo "<tr><td>" .$all['id'] . "</td><td>" .  $all['uid'] ."</td><td>" .  $all['viewpriv'] ."</td><td>" .  $all['delpriv'] ."</td><td>" .  $all['changepriv'] . "</td></tr>"; 
}
echo "</table>"; 
	}
	?>
	<!-- Sends a id value to delete, then run deletion code after-->
	<form action="" method="post">
		<input type="number" name="id" placeholder="ID">
		<select name="viewpriv">
			<option value="" disabled selected>View Privileges</option>
			<option value="1">Yes</option>
			<option value="0">No</option>
		</select>
		<select name="delpriv">
			<option value="" disabled selected>Delete Privileges</option>
			<option value="1">Yes</option>
			<option value="0">No</option>
		</select>
		<select name="changepriv">
			<option value="" disabled selected>Change Privileges</option>
			<option value="1">Yes</option>
			<option value="0">No</option>
		</select>
		<button type="submit">Update</button>
	</form>

<?php
	$updateID=$_POST['id']??'';
	$viewpriv=$_POST['viewpriv']??'';
	$delpriv=$_POST['delpriv']??'';
	$changepriv=$_POST['changepriv']??'';
	$dbUpdate = "UPDATE `users` SET `viewpriv` = '$viewpriv', `delpriv` = '$delpriv', `changepriv` = '$changepriv' WHERE `users`.`id` = $updateID;";//DO NOT CHANGE QUOTATION MARKS. 
	mysqli_query( $conn, $dbUpdate); 
?>
	<form action="admin.php" method="post">
		<button type="submit">Back</button>
	</form>
</body>
</html>