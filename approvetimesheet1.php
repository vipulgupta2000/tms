<div id="middle_right_top">
<h2>Approve Time Sheet</h2>
</div>
<form name="form4" action="" method="POST">

<?php
if(isset($_POST['update']))
{
$j=0;
	while($j<$_POST['ival'])
	{
	$d1 = 'ustat'.$j;
	$d2 = 'taskid'.$j;
	$d3 = 'empid'.$j;
	$d4 = 'wdate'.$j;

	$val1 = $_POST[$d1];
	$val2 = $_POST[$d2];
	$val3 = $_POST[$d3];
	$val4 = $_POST[$d4];

		if(isset($_POST['chb'.$j]) && $_POST['ustat'.$j] == 'Approved')
		{
			$sql = "UPDATE timetable SET status='Approved',tmp=1 where taskid='$val2'";
			if(!mysql_query($sql,$con))
			{
			die('Could not update the status:' . mysql_error());
			}

			$temp = mysql_query("select email_id,empname from usertable where empid='$val3'");
			$row = mysql_fetch_array($temp);

			/*$to = $row['email_id'];*/
			$to = "nadeem.ansari@inputzero.com";
			$subj = "Your timesheet has been Approved";
			$headers = 'From: noreply@inputzero.com';
			$txt = "Hi $row[empname],"."\n"."\n".

			"$_SESSION[SESS_ename] has Approved your time sheet for the weekend $val4."."\n".
			"This is a system generated mail. Please do not respond.\n\nThanks,\nnoreply@inputzero.com";

			// Use wordwrap() if lines are longer than 70 characters
			$txt = wordwrap($txt,100);

			// Send email
			$true1 = mail($to, $subj, $txt, $headers);

		}//end of if

		if(isset($_POST['chb'.$j]) && $_POST['ustat'.$j] == 'Rejected')
		{
			$sql = "UPDATE timetable SET status='Rejected',tmp=0 where taskid='$val2'";
			if(!mysql_query($sql,$con))
			{
			die('Could not update the status:' . mysql_error());
			}

			$temp = mysql_query("select email_id,empname from usertable where empid='$val3'");
			$row = mysql_fetch_array($temp);

			/*$to = $row['email_id'];*/
			$to = "nadeem.ansari@inputzero.com";
			$subj = "Your timesheet has been rejected";
			$headers = 'From: noreply@inputzero.com';
			$txt = "Hi $row[empname],"."\n"."\n".

			"$_SESSION[SESS_ename] has rejected your time sheet for the weekend $val4."."\n".
			"Please correct your timesheet for the weekend $val4."."\n".
			"This is a system generated mail. Please do not respond.\n\nThanks,\nnoreply@inputzero.com";

			// Use wordwrap() if lines are longer than 70 characters
			$txt = wordwrap($txt,100);

			// Send email
			$true2 = mail($to, $subj, $txt, $headers);

		}//end of if

	$j++;
	}//end of whileloop

}
?>

<?php
$result = mysql_query("SELECT * FROM timetable WHERE status !='Approved' and mgrid = '$_SESSION[SESS_empid]' order by date");

echo "<table border='1'>
<tr>
<th>EMPID</th><th>EMPNAME</th><th>CHARGECODE</th><th>PROJECT</th><th>TASK</th><th>DATE</th><th>STATUS</th><th>SAT</th><th>SUN</th><th>MON</th> <th>TUE</th><th>WED</th> <th>THU</th><th>FRI</th><th>TOTAL</th>
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

$sdat = new DateTime();
while($row = mysql_fetch_array($result))
{
$sdat->setTimestamp($row['date']);
$da = $sdat->format('Y-n-j');

echo "<tr>";
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

echo "<td>" .$row['empid']	     . "</td>"  ;
echo "<td>" .$row['empname']	 . "</td>"  ;
echo "<td>" .$row['chargecode']	 . "</td>"  ;
echo "<td>" .$row['project'] 	 . "</td>"  ;
echo "<td>" .$row['task']	     . "</td>"  ;
echo "<td>" .$da             	 . "</td>"  ;
echo "<td><input type=checkbox name=chb$i><select name=\"ustat$i\">
<option value=\"\">$row[status]</option>
<option value=\"Approved\">Approve</option>
<option value=\"Rejected\">Reject</option> </select></td>";
echo "<td>" .$row['saturday']    . "</td>"  ;
echo "<td>" .$row['sunday']      . "</td>"  ;
echo "<td>" .$row['monday']      . "</td>"  ;
echo "<td>" .$row['tuesday']     . "</td>"  ;
echo "<td>" .$row['wednesday']   . "</td>"  ;
echo "<td>" .$row['thursday']    . "</td>"  ;
echo "<td>" .$row['friday']	     . "</td>"  ;
echo "<td class=\"tot\">$sumrow</td>";
echo "<td><input type=\"hidden\" name=\"taskid$i\" value=$row[taskid]>
<input type=\"hidden\" name=\"empid$i\" value=$row[empid]>
<input type=\"hidden\" name=\"wdate$i\" value=$da></td>";
$i=$i+1;
echo "</tr>";
}
echo "<tr> <td colspan=\"7\" class=\"tot\">Total</td> <td class=\"tot\">$tsaturday</td> <td class=\"tot\">$tsunday</td> <td class=\"tot\">$tmonday </td> <td class=\"tot\">$ttuesday</td> <td class=\"tot\">$twednesday</td> <td class=\"tot\">$tthursday</td> <td class=\"tot\">$tfriday </td> <td class=\"tot\"> $tot</td> </tr>";
echo "</table>";
echo "<input type=\"hidden\" name=\"ival\" value=$i>";
echo "<br/>";

?>

<input id="btn" type="submit" name="update" onclick="return chk()" value="UPDATE STATUS">


<?php
	if(isset($_POST['update']))
	{
		if($true1 == 1 or $true2 == 1)
		{
		echo "Notification Mail Sent";
		}
		else {echo "Unable to Send Notification Mail";}

	}//End of if
?>

</form>