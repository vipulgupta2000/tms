<html>
<head>
<title>Time Management System</title>
<link rel="stylesheet" type="text/css" href="css/div.css" />
<script language="javascript" type="text/javascript" src="datetimepick/datetimepicker.js"></script>
<script language="javascript" type="text/javascript" src="script/validate.js"></script>
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
		<h2>Update User</h2>
		</div>
		<form name="form6" action="" onsubmit="return validateForm6()" method="POST">
		<?php
		if(isset($_POST['update']))
		{
		$j=0;
		while($j<$_POST['ival'])
		{
		$d1 = 'uid'.$j;
		$d2 = 'ueid'.$j;
		$d3 = 'uname'.$j;
		$d4 = 'upass'.$j;

		$val1 = $_POST[$d1];
		$val2 = $_POST[$d2];
		$val3 = $_POST[$d3];
		$val4 = $_POST[$d4];

		$sql1="UPDATE user set username='$val3',  password='$val4' where id='$val1' and eid='$val2'";

		if (!mysql_query($sql1, $con))
		{
		die('Error: ' . mysql_error());
		}
		$j++;
		}
		if($sql1)
		{
		echo "Record updated";
		}
		}
		?>

		<?php
		$result = mysql_query("SELECT * FROM user");

		echo "<table width=auto border=1 cellpadding=2 cellspacing=2>
		<tr>
		<th>ID</th><th>EID</th><th>USERNAME</th><th>PASSWORD</th>
		</tr>";
		$i=0;
		while($row = mysql_fetch_array($result))
		{
		echo "<tr>";
		echo "<td><input type=text name=uid$i size=\"15\" value={$row['id']} readonly=readonly  class=ro></td>"  ;
		echo "<td><input type=text name=ueid$i size=\"15\" value={$row['eid']} readonly=readonly  class=ro></td>"  ;
		echo "<td><input type=text name=uname$i size=\"15\" value={$row['username']} ></td>"  ;
		echo "<td><input type=text name=upass$i size=\"15\" value={$row['password']} ></td>"  ;
		echo "</tr>";
		$i++;
		}
		echo "</table>";
		echo "<input type=hidden name=\"ival\" value=$i>";
		?>
		<br />
		<input id="btn" type="submit" name="update" value="UPDATE" >
		</form>
		</div>
	</div>

	<div id="footer">

	</div>

</div>
</center>
</body>
</html>