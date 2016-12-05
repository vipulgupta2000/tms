<html>
<head>
<title>Time Management System</title>
</head>
<body>
<form action="" method="POST">
<?php

$host="localhost";
$username="lmsuser";
$password="v89bXBBYNQCfDDw5";
$db_name="tms";
$tbl_name="usertable";

// Connect to server and select database.
mysql_connect("$host", "$username", "$password") or die("cannot connect");

mysql_select_db ("$db_name") or die ("cannot select DB");

session_start();

// username and password sent from form
if(isset($_POST['myusername']))
{$pass=$_POST['mypassword'];
$myusername=$_POST['myusername'];
$mypassword=sha1($_POST['mypassword']);
//echo "i am in if";
}elseif(isset($_REQUEST["user"]))
{
$myusername=$_REQUEST["user"];
$mypassword=sha1($_REQUEST["pass"]);
//echo " i m in elsif".$myusername;
//echo " i m in elsif".$mypassword;

}else
{
echo "Wrong Username or Password";
header("location:index.php");
}
echo $myusername.$mypassword;
// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);

$sql="SELECT * FROM $tbl_name WHERE empid='$myusername' and password='$mypassword'";

$result=mysql_query($sql);

if($result)
{
if(mysql_num_rows($result)==1)
{
session_regenerate_id();
$member = mysql_fetch_assoc($result);
$_SESSION['SESS_ename'] = $member['empname'];
$_SESSION['SESS_uname'] = $member['username'];
$_SESSION['SESS_pwd'] = $member['password'];
$_SESSION['SESS_empid'] = $member['empid'];
$_SESSION['SESS_perm'] = $member['permission'];
$_SESSION['SESS_access'] = $member['permission'];
$_SESSION['SESS_mgrid'] = $member['mgrid'];
$_SESSION['pass'] = $pass;
$_SESSION['SESS_tmp']=NULL;
session_write_close();
header("location:home.php?page=text.php");
exit();
}
else
{
echo "Wrong Username or Password";
header("location:index.php");
}
}
?>
</form>
</body>
</html>
