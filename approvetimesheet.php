<div id="middle_right_top">
		<h2>Approve Time Sheet</h2>
		</div>
		<form name="right" action="" method="POST">

		<table width="auto" border="1" cellpadding="2" cellspacing="2">
		<tr>
		<th align="left">Employee Name: </th>
		<th align="left">WeekEnd Date(Friday):</th>
		</tr>
		<tr>
		<?php
		echo "<td><select name=\"empname\">";
		echo "<option value=\"\">Select EmpName</option>";
		ename1();
		echo "</select></td>";
		?>
		<td><input readonly="readonly" name="day" id="day" type="text" size="23" class="ro">
		<a href="javascript:NewCal('day','yyyymmdd')">
		<img src="datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
		</td>
		</tr>
		</table>
		<br/>
		<input id="btn" type="submit" name="sts" value="Show Time Sheet">
		<br/><br/><br/>

		<?php
		if(isset($_POST['sts']))
		{
		$ts = new DateTime($_POST['day']);
		$wend = $ts->format('U');
		$result = mysql_query("SELECT * FROM timetable WHERE empname ='$_POST[empname]' and date='$wend' ");

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
/*$temp = $row['taskid'];*/

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
echo "<td>" .$row['status']	     . "</td>"  ;
echo "<td>" .$row['saturday']    . "</td>"  ;
echo "<td>" .$row['sunday']      . "</td>"  ;
echo "<td>" .$row['monday']      . "</td>"  ;
echo "<td>" .$row['tuesday']     . "</td>"  ;
echo "<td>" .$row['wednesday']   . "</td>"  ;
echo "<td>" .$row['thursday']    . "</td>"  ;
echo "<td>" .$row['friday']	     . "</td>"  ;
echo "<td class=\"tot\">$sumrow</td>";
$i=$i+1;
echo "</tr>";
}
echo "<tr> <td colspan=\"7\" class=\"tot\">Total</td> <td class=\"tot\">$tsaturday</td> <td class=\"tot\">$tsunday</td> <td class=\"tot\">$tmonday </td> <td class=\"tot\">$ttuesday</td> <td class=\"tot\">$twednesday</td> <td class=\"tot\">$tthursday</td> <td class=\"tot\">$tfriday </td> <td class=\"tot\"> $tot</td> </tr>";
echo "</table>";

		echo "<br/>";
		echo "<input id=\"btn\" type=\"submit\" name=\"ats\" value=\"Approve Time Sheet\">";
		echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
		echo "<input id=\"btn\" type=\"submit\" name=\"rts\" value=\"Reject Time Sheet\">";
		echo "<input type=hidden name=temp1 value=\"$_POST[empname]\">";
		echo "<input type=hidden name=temp2 value=$da>";
		/*echo "<input type=hidden name=temp3 value=$temp>";*/
		}/*End of if sts*/

		/*$temp1 = $_POST['empname'];
		$temp2 = $_POST['day'];*/

		if(isset($_POST['ats']))
		{
		$sql = "UPDATE timetable SET status='Approved',tmp=1 where empname='$_POST[temp1]' and datevar='$_POST[temp2]'";
		/*taskid='$_POST[temp3]'*/
		if(!mysql_query($sql,$con))
		{
		die('Could not update the status:' . mysql_error());
		}

		$temp = mysql_query("select email_id,empname from usertable where empname='$_POST[temp1]'");
		$row = mysql_fetch_array($temp);

		$to = $row['email_id'];
		/*$to = "nadeem.ansari@inputzero.com";*/
		$subj = "Your timesheet has been Approved";
		$headers = 'From: noreply@inputzero.com';
		$txt = "Hi $row[empname],"."\n"."\n".

		"$_SESSION[SESS_ename] has Approved your time sheet for the weekend $_POST[temp2]."."\n".
		"This is a system generated mail. Please do not respond.\n\nThanks,\nnoreply@inputzero.com";

		// Use wordwrap() if lines are longer than 70 characters
		$txt = wordwrap($txt,100);

		// Send email
		$true = mail($to, $subj, $txt, $headers);

		if($true==1)
		{
		echo "Approval Mail Sent";
		}
		else {echo "Unable to send notification mail";}
		}

		if(isset($_POST['rts']))
		{
		$sql = "UPDATE timetable SET status='Rejected',tmp=0 where empname='$_POST[temp1]' and datevar='$_POST[temp2]'";
		/*taskid='$_POST[temp3]'*/
		if(!mysql_query($sql,$con))
		{
		die('Could not update the status:' . mysql_error());
		}

		$temp = mysql_query("select email_id,empname from usertable where empname='$_POST[temp1]'");
		$row = mysql_fetch_array($temp);

		$to = $row['email_id'];
		/*$to = "nadeem.ansari@inputzero.com";*/
		$subj = "Your timesheet has been rejected";
		$headers = 'From: noreply@inputzero.com';
		$txt = "Hi $row[empname],"."\n"."\n".

		"$_SESSION[SESS_ename] has rejected your time sheet for the weekend $_POST[temp2]."."\n".
		"Please correct your timesheet for the weekend $_POST[temp2]."."\n".
		"This is a system generated mail. Please do not respond.\n\nThanks,\nnoreply@inputzero.com";

		// Use wordwrap() if lines are longer than 70 characters
		$txt = wordwrap($txt,100);

		// Send email
		$true = mail($to, $subj, $txt, $headers);

		if($true==1)
		{
		echo "Rejection Mail Sent";
		}
		else {echo "Unable to send notification mail";}
		}

		?>
		</form>
