<html>
<head>
<title>Time Management System</title>
<link rel="stylesheet" type="text/css" href="css/templateblue.css" />
<script language="javascript" type="text/javascript" src="datetimepick/datetimepicker.js"></script>
<script language="javascript" type="text/javascript" src="script/validate.js"></script>
<script language="javascript" type="text/javascript" src="script/xml.js"></script>
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
		<td><a href="home.php?page=text.php"><font size="2">Home</font></a></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><a href="logout.php"><font size="2">Logout</font></a></td>
		</tr>
		</table>
		</div>
	</div>

	<div id="middle">
		<div id="mid_ltop">
		<div id="middle_left">
		<?php
		include("left.php");
		include("datefunc.php");
		?>
		</div><div id="mid_lbot"></div>
		</div>
		<div id="middle_right" align="left">

		<?php
		include($_GET['page']);
		?>
		</div>
	</div>

	<div id="footer">
	&copy Input Zero Technologies Pvt. Ltd.
	</div>

</div>
</center>
</body>
</html>