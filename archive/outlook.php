<html>
<head>
<title>Time Management System</title>
<link rel="stylesheet" type="text/css" href="css/div.css" />
<script language="javascript" type="text/javascript" src="datetimepick/datetimepicker.js"></script>
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

		</div>
	</div>

	<div id="footer">

	</div>

</div>
</center>
</body>
</html>