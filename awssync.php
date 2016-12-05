<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Password Sync</title>
  <link rel="stylesheet" type="text/css" href="css/templateblue.css" />
  </head>

<body>
<div class="row" id="top">
	<div class="col-md-4 col-xs-3"><img id="img" src="images/logo.png" alt="Input Zero" />
	</div>
	<div class="col-md-7 col-xs-3">
		<h2>Welcome To PasswordSync<h2>
	</div>
</div>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$host="localhost";
$username="lms";
$password="tootifrooti";
$db_name="lms";


$empid=isset($_POST['user'])?$_POST['user']:NULL;
$pass=isset($_POST['pass'])?sha1($_POST['pass']):NULL;

@mysql_connect("$host", "$username", "$password") or die("cannot connect");
@mysql_select_db ("$db_name") or die ("cannot select DB");
if(is_null($empid))
{echo "EMPID did not come so passwords not synced";}else
{
$sql_lms="update lms.usertable u set u.password='$pass' where u.empid='$empid' ";
if($result=mysql_query($sql_lms))
echo "LMS Password done<br />";
else
   echo mysql_error();
}

$username="lmsuser";
$password="v89bXBBYNQCfDDw5";
$db_name="tms_lms";
$tbl_name="usertable";
@mysql_connect("$host", "$username", "$password") or die("cannot connect");
@mysql_select_db ("$db_name") or die ("cannot select DB");

if(is_null($empid))
{echo "EMPID did not come so passwords not synced";}else
{
$sql_tms="update tms_lms.usertable u set u.password='$pass' where u.empid='$empid' ";
if($result=mysql_query($sql_tms))
echo "TMS Password done";
else
   echo mysql_error();
echo "<br/> <br/><a href='https://tms.inputzero.com'>Goto TMS</a>";
}

?>
</body>
