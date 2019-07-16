<?php
//Incomplete settings pane. Not implemented.
	require "reqUser.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styleSettings.css">
	<link rel="stylesheet" href="globalStyle.css">
</head>
<body>

<img src="dshop-logo-small.png">

<form action="/logout.php" method="post">
	<button class="button button1" name="logout-submit">Logout</button> 
</form>

<form action="../Display.php">
	<button class="button button2">Back to Display</button> 
</form>

<h2>Parallax with scroll</h2>

<div class="switches">
<label class="switch">
  <input type="checkbox">
  <span class="slider round"></span>
</label>
</div>
<h2>Hints</h2>
<label class="switch">
  <input type="checkbox">
  <span class="slider round"></span>
</label>
<div></div>

<button class="button button3" >Change Theme</button>
<h1>.....</h1>


</body>
</html>