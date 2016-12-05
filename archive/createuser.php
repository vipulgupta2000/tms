<html>
<head>
<title>Time Management System</title>
<link rel="stylesheet" type="text/css" href="css/div.css" />
<script language="javascript" type="text/javascript" src="datetimepick/datetimepicker.js"></script>
<script language="javascript" type="text/javascript" src="script/validate.js"></script>
<script language="javascript">
function validate(field) {
var valid = "abcdefghijklmnopqrstuvwxyz";
var ok = "yes";
var temp;
for (var i=0; i<field.value.length; i++) {
temp = "" + field.value.substring(i, i+1);
if (valid.indexOf(temp) == "-1") ok = "no";
}
if (ok == "no") {
alert("Invalid entry!  Only characters are accepted!");
field.focus();
field.select();
   }
}
function validate1(field) {
var valid = "0123456789";
var ok = "yes";
var temp;
for (var i=0; i<field.value.length; i++) {
temp = "" + field.value.substring(i, i+1);
if (valid.indexOf(temp) == "-1") ok = "no";
}
if (ok == "no") {
alert("Invalid entry!  Only numbers are accepted!");
field.focus();
field.select();
   }
}
</script>
</head>

<body>
<center>
<div id="box">

	<div id="top">
		<?php
		require_once("auth.php");
		?>
		<div id="top_left">
		<img id="img" src="images/logo.png" alt="Input Zero" />
		</div>
		<div id="top_middle">
		<font face="times new roman">Welcome To Time Management</font>
		</div>
		<div id="top_right">
		<table align="right">
		<tr>
		<td><a href="home.php"><font size="2">HOME</font></a></td>
		<td><a href="logout.php"><font size="2">LOGOUT</font></a></td>
		</tr>
		</table>
		</div>
	</div>

	<div id="middle">
		<div id="middle_left">
		<?php
		include("left.php");
		include("datefunc.php");
		?>
		</div>

		<div id="middle_right" align="left">
		<div id="middle_right_top">
		<h2>Create User</h2>
		</div>
		<form name="form5" onsubmit="return validateForm5()" action="" method="POST">
		  <table width="auto" border="1" cellpadding="2" cellspacing="2">
		    <tr>
		      <th align="left">Employee ID</th>
		      <th align="left">User Name</th>
		      <th align="left">Password</th>
		      <th align="left">Date Of Joining</th>
		    </tr>
		    <tr>
		      <td><input name="eid" type="text" size="20" method="POST" onBlur="validate1(this)"></td>
		      <td><input name="uname" type="text" size="20" method="POST" onBlur="validate(this)"></td>
		      <td><input name="upassword" type="password" size="20" method="POST"></td>
		      <td><input readonly="readonly" name="dojoin" id="dojoin" type="text" size="20" method="POST" class="ro">
		      <a href="javascript:NewCal('dojoin','yyyymmdd')">
			  <img src="datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date"></td>
		    </tr>
		  </table>
		  <br />
		  <input id="btn" type="submit" name="reg" value="Register User" />

		<?php
		if(isset($_POST['reg']))
		{
		$ts1 = new DateTime($_POST['dojoin']);
		$date=$ts1->format('U');

		$sql = "INSERT INTO user (eid, doj, username, password) VALUES ('$_POST[eid]','$date','$_POST[uname]','$_POST[upassword]')";
		if (!mysql_query($sql,$con))
		{
		die('Error: ' . mysql_error());
		}
		else
		echo "User Added";
		}
		?>
		</form>

		</div>
	</div>

	<div id="footer">

	</div>

</div>
</center>
</body>
</html>