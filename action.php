<?php
//Vulnerable to SQL injection attacks (The login system isn't).
//Gets the information from the form, then runs the query to insert into database.
	session_start();
	require 'connection.php';
	$date = $_POST["date"]??'';
	$start_time = $_POST["start_time"]??'';
	$end_time = $_POST["end_time"]??'';
	$meal= $_POST["meal"]??'';
	$room = $_POST["room"]??'';
	$delivery_time = $_POST["delivery_time"]??'';
	$morning_break = $_POST["morning_break"]??'';
	$afternoon_break = $_POST["afternoon_break"]??'';
	$floor = $_POST["floor"]??'';
	$attendees = $_POST["attendees"]??'';
	$purpose = $_POST["purpose"]??'';
	$restrictions = $_POST["restrictions"]??'';
	$hot_cold = $_POST["hot_cold"]??'';
	$drinks = $_POST["drinks"]??'';
	$vendor = $_POST["vendor"]??'';
	$food = $_POST["food"]??'';
	$cost_center = $_POST["cost_center"]??'';
	$organizer = $_POST["organizer"]??'';
	$user=$_SESSION['userUid'];
	$dbinsert = "INSERT INTO cateringdata (Date,StartTime,EndTime,Meal,Room,DeliveryTime,MorningBreak,AfternoonBreak,Floor,Attendees,Purpose,Restrictions,HotCold,Drinks,Vendor,Food,LoBCostCenter,Organizer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = mysqli_stmt_init($connection);
	if(!mysqli_stmt_prepare($stmt,$dbinsert)){
		echo "SQL FAILURE";
	}else{
		mysqli_stmt_bind_param($stmt, "ssssssssssssssssss",$date, $start_time, $end_time, $meal, $room, $delivery_time,$morning_break, $afternoon_break, $floor, $attendees, $purpose,$restrictions,$hot_cold,$drinks,$vendor,$food,$cost_center, $organizer);
		mysqli_stmt_execute($stmt);
	}
	$result=mysqli_query( $connection, "SELECT * FROM cateringdata ORDER BY DateCreated DESC LIMIT 0, 1");
	$all =mysqli_fetch_assoc($result);
	$string=implode("|", $all);
	$dblog = "INSERT INTO log (User,AfterChange,Type) VALUES ('$user','$string', 'Insert');";
	mysqli_query( $connection, $dblog );
	header("Location:../form.php");