<?php
//Only run if there is a value of login-submit that has been posted. basically if the submit button has been pressed
if(isset($_POST['login-submit'])){
	require 'loginSystemConn.php';
	$username=$_POST['userid'];
	$password=$_POST['pwd'];
	//Check for empty fields and redirect.
	if(empty($username)||empty($password)){
		header("Location:../login_page.php?error=emptyfields");
		exit();
	}else{
		$sql="SELECT * FROM users WHERE uid=?;";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt,$sql)){
			header("Location:../login_page.php?error=sql");
			exit();
		}else{
			mysqli_stmt_bind_param($stmt,"s", $username);
			mysqli_stmt_execute($stmt);
			$result=mysqli_stmt_get_result($stmt);
			//$row becomes results of database
			if($row=mysqli_fetch_assoc($result)){
				//Check password if user entered password is in the upwd column.
				$pwdCheck=password_verify($password, $row['upwd']);
				//Redirect if password check fails
				if ($pwdCheck==false) {
					header("Location:../login_page.php?error=userorpwd");
					exit();
				}else if($pwdCheck==true){
					//If password check goes through, start sessions with the id and username of the user.
					session_start();
					$_SESSION['userId'] = $row['id'];
					$_SESSION['userUid'] = $row['uid'];
					//$_SESSION['view'] = $row['viewpriv'];
					//$_SESSION['delete'] = $row['delprive'];
					//$_SESSION['change'] = $row['changepriv'];
					//Redirect to admin page if username is dshop.
					if($row['uid']=="dshop"){
						header("Location:../admin.php");
						exit();
					}else{
						//Redirect to the form for normal user.
						header("Location:../form.php?login=success");
						exit();
					}
				}else{
					header("Location:../login_page.php?error=4");
					exit();
				}
			}else{
				header("Location:../login_page.php?error=userorpwd");
				exit();
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}else{
	//Redirects back to the login_page if not get login-submit
	header("Location:../login_page.php");
	exit();
}

