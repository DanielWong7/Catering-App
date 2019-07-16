<?php
//Used by being required in other files. Redirects to login page if there is no user. Redirects to login page after 10 minutes.
	session_start();
	//header("refresh: 605"); 
	if(!isset($_SESSION['userId']))
	{
	    header('Location: ../login_page.php');
	    exit();
	}
    /*if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 600)) {
	    session_unset();
	    session_destroy();
	    header("Location:../login_page.php?error=sessiontimeout");
}
$_SESSION['LAST_ACTIVITY'] = time();
*/
?>