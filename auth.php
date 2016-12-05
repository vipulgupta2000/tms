<?php
	//Start session
	session_start();

	if(isset($_SESSION['SESS_uname']))
	{
	//echo "Welcome ". $_SESSION['SESS_uname']." ";
    //echo "Your Employee ID is=" . $_SESSION['SESS_empid'];
    $con = @mysql_connect("localhost","lmsuser","v89bXBBYNQCfDDw5");
    if(!$con)
    {
    die('Could not connect: ' . mysql_error());
    }
    mysql_select_db("tms",$con);
    }

	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['SESS_uname']) || (trim($_SESSION['SESS_uname']) == '')) {
		header("location: accessdenied.php");
		exit();
	}
?>

