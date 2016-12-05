<?php
	//Start session
	//session_start();
	require_once('auth.php');
	//Unset the variables stored in session
	unset($_SESSION['SESS_uname']);
    unset($_SESSION['SESS_pwd']);
    session_destroy();
mysql_close($con);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Time Management System</title>
</head>
<body>
<p align="center">&nbsp;</p>
<h4 align="center" class="err">You have been successfully logged out.</h4>
<p align="center">Click here to <a href="index.php">Login</a></p>
</body>
</html>
