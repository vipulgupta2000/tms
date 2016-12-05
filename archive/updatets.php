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
		<div id="middle_right_top">
		<h2>Update Time Sheet</h2>
		</div>
		<form name="right" action="" method="POST">

		<?php
		if(isset($_POST['update']))
		{
		$j=0;
		while($j<$_POST['ival'])
		{
		$d  = 'ta_tb'.$j;
		$d1 = 'ch_tb'.$j;
		$d2 = 'de_tb'.$j;
		$d3 = 'mo_tb'.$j;
		$d4 = 'tu_tb'.$j;
		$d5 = 'we_tb'.$j;
		$d6 = 'th_tb'.$j;
		$d7 = 'fr_tb'.$j;
		$d8 = 'sa_tb'.$j;
		$d9 = 'su_tb'.$j;

		$val  = $_POST[$d];
		$val1 = $_POST[$d1];
		$val2 = $_POST[$d2];
		$val3 = $_POST[$d3];
		$val4 = $_POST[$d4];
		$val5 = $_POST[$d5];
		$val6 = $_POST[$d6];
		$val7 = $_POST[$d7];
		$val8 = $_POST[$d8];
		$val9 = $_POST[$d9];

		if((is_numeric($val3)||empty($val3)) && (is_numeric($val4)||empty($val4)) && (is_numeric($val5)||empty($val5)) && (is_numeric($val6)||empty($val6)) && (is_numeric($val7)||empty($val7)) && (is_numeric($val8)||empty($val8)) && (is_numeric($val9)||empty($val9)))
		{
		$sql1="UPDATE timetable set chargecode='$val1', description='$val2', monday='$val3', tuesday='$val4', wednesday='$val5', thursday='$val6', friday='$val7', saturday='$val8', sunday='$val9' where taskid='$val'";
		if (!mysql_query($sql1, $con))
		{
		die('Error: ' . mysql_error());
		}
		}
		else{echo "ERROR: Enter only Digits!";}
		$j++;
		}
		if(isset($sql1))
		{
		echo "Time Sheet Updated";
		}
		}
		?>

		<?php
		$date=friday();

		$result = mysql_query("SELECT * FROM timetable where empid='$_SESSION[SESS_empid]' and date='$date'");

		echo "<table width=100% border=1 cellpadding=2 cellspacing=2>
		<tr>
		<th>TASK ID</th><th>CHARGECODE</th><th>TASK</th><th>DESCRIPTION</th><th>DATE</th><th>SAT</th><th>SUN</th><th>MON</th><th>TUE</th><th>WED</th> <th>THR</th> <th>FRI</th><th>TOTAL</th>
		</tr>";
		$i=0;
		$tot=0;

		$tsaturday =0;
		$tsunday   =0;
		$tmonday   =0;
		$ttuesday  =0;
		$twednesday=0;
		$tthursday =0;
		$tfriday   =0;

		while($row = mysql_fetch_array($result))
		{
		// To Calculate the Total of Row.

		$sumrow=$row['saturday']+$row['sunday']+$row['monday']+$row['tuesday']+$row['wednesday']+$row['thursday']+$row['friday'];
		$tot=$tot+$sumrow;

		// To Calculate the Total of Column.

		$tsaturday  = $tsaturday  +$row['saturday'];
		$tsunday    = $tsunday    +$row['sunday'];
		$tmonday    = $tmonday    +$row['monday'];
		$ttuesday   = $ttuesday   +$row['tuesday'];
		$twednesday = $twednesday +$row['wednesday'];
		$tthursday  = $tthursday  +$row['thursday'];
		$tfriday    = $tfriday    +$row['friday'];
		echo "<tr>";
		echo "<td><input type=text name=ta_tb$i size=\"5\"  value=\"{$row['taskid']}\"  readonly=readonly class=ro></td>"  ;
		echo "<td><input type=text name=ch_tb$i size=\"12\" value=\"{$row['chargecode']}\"	 ></td>"  ;
		echo "<td><input type=text name=tastb$i size=\"11\" value=\"{$row['task']}\"	     ></td>"  ;
		echo "<td><input type=text name=de_tb$i size=\"12\" value=\"{$row['description']}\"  ></td>"  ;
		echo "<td><input type=text name=da_tb$i size=\"7\"  value=\"{$row['date']}\"  readonly=readonly class=ro></td>"  ;
		echo "<td><input type=text name=sa_tb$i size=\"2\" value=\"{$row['saturday']}\"	     ></td>"  ;
		echo "<td><input type=text name=su_tb$i size=\"2\" value=\"{$row['sunday']}\"	 	 ></td>"  ;
		echo "<td><input type=text name=mo_tb$i size=\"2\" value=\"{$row['monday']}\"	 	 ></td>"  ;
		echo "<td><input type=text name=tu_tb$i size=\"2\" value=\"{$row['tuesday']}\"	     ></td>"  ;
		echo "<td><input type=text name=we_tb$i size=\"2\" value=\"{$row['wednesday']}\"	 ></td>"  ;
		echo "<td><input type=text name=th_tb$i size=\"2\" value=\"{$row['thursday']}\"	     ></td>"  ;
		echo "<td><input type=text name=fr_tb$i size=\"2\" value=\"{$row['friday']}\"	 	 ></td>"  ;
		echo "<td class=\"tot\">$sumrow</td>";
		$i=$i+1;
		echo "</tr>";
		}
		/*if(24<$tsaturday){echo"Your total for saturday is greater then 24 hours.Please Correct!"."</br>";}
		if(24<$tsunday){echo"Your total for sunday is greater then 24 hours.Please Correct!"."</br>";}
		if(24<$tmonday){echo"Your total for monday is greater then 24 hours.Please Correct!"."</br>";}
		if(24<$ttuesday){echo"Your total for tuesday is greater then 24 hours.Please Correct!"."</br>";}
		if(24<$twednesday){echo"Your total for wednesday is greater then 24 hours.Please Correct!"."</br>";}
		if(24<$tthursday){echo"Your total for thursday is greater then 24 hours.Please Correct!"."</br>";}
		if(24<$tfriday){echo"Your total for friday is greater then 24 hours.Please Correct!"."</br>";}
		elseif(84<$tot){echo"Your total for week is greater then 84 hours.Please Correct!";}*/

		echo "<tr> <td colspan=\"5\" class=\"tot\">Total</td> <td class=\"tot\">$tsaturday</td> <td class=\"tot\">$tsunday</td> <td class=\"tot\">$tmonday </td> <td class=\"tot\">$ttuesday</td> <td class=\"tot\">$twednesday</td> <td class=\"tot\">$tthursday</td> <td class=\"tot\">$tfriday </td> <td class=\"tot\"> $tot</td> </tr>";
		echo "</table>";
		echo "<input type=hidden name=\"ival\" value=$i>";
		?>
		<br />
		<input id="btn" type="submit" name="update" value="Update Time Sheet">
		</br>
		</br>
		</form>

		</div>
	</div>

	<div id="footer">

	</div>

</div>
</center>
</body>
</html>