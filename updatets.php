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
		$d1  = 'cha'.$j;
		$d2  = 'pro'.$j;
		$d3  = 'tas'.$j;
		$d4  = 'dat'.$j;
		$d5  = 'sat'.$j;
		$d6  = 'sun'.$j;
		$d7  = 'mon'.$j;
		$d8  = 'tue'.$j;
		$d9  = 'wed'.$j;
		$d10 = 'thr'.$j;
		$d11 = 'fri'.$j;
		$d12 = 'task'.$j;

		$val1  = $_POST[$d1];
		$val2  = $_POST[$d2];
		$val3  = $_POST[$d3];
		$val4  = $_POST[$d4];
		$val5  = $_POST[$d5];
		$val6  = $_POST[$d6];
		$val7  = $_POST[$d7];
		$val8  = $_POST[$d8];
		$val9  = $_POST[$d9];
		$val10 = $_POST[$d10];
		$val11 = $_POST[$d11];
		$val12 = $_POST[$d12];

		if((is_numeric($val5)||empty($val5)) && (is_numeric($val6)||empty($val6)) && (is_numeric($val7)||empty($val7)) &&
		(is_numeric($val8)||empty($val8)) && (is_numeric($val9)||empty($val9)) && (is_numeric($val10)||empty($val10)) &&
		(is_numeric($val11)||empty($val11)))
		{
		$sql1="UPDATE timetable set chargecode='$val1', project='$val2', task='$val3', saturday='$val5', sunday='$val6', monday='$val7',
		tuesday='$val8', wednesday='$val9', thursday='$val10', friday='$val11', tmp='1' where taskid='$val12'";
		if (!mysql_query($sql1, $con))
		{
		die('Error: ' . mysql_error());
		}
		}
		else{echo "ERROR: Enter only Digits!";}
		$j++;
		}/*end of while*/

		}/*end of if*/
		?>

		<?php
		$result = mysql_query("SELECT * FROM timetable where empid='$_SESSION[SESS_empid]' and status=\"Rejected\"");

		echo "<table border=1>
		<tr>
		<th>CHARGECODE</th><th>PROJECT</th><th>TASK</th><th>DATE</th><th>SAT</th><th>SUN</th><th>MON</th><th>TUE</th><th>WED</th> <th>THR</th> <th>FRI</th><th>TOTAL</th>
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
		echo "<td><input type=text name=cha$i size=\"12\" value=\"{$row['chargecode']}\"	 ></td>"  ;
		echo "<td><input type=text name=pro$i size=\"20\" value=\"{$row['project']}\"  		 ></td>"  ;
		echo "<td><input type=text name=tas$i size=\"20\" value=\"{$row['task']}\"	    	 ></td>"  ;
		echo "<td><input type=text name=dat$i size=\"7\"  value=\"{$row['datevar']}\"  readonly=readonly class=ro></td>"  ;
		echo "<td><input type=text name=sat$i size=\"2\"  value=\"{$row['saturday']}\"	     ></td>"  ;
		echo "<td><input type=text name=sun$i size=\"2\"  value=\"{$row['sunday']}\"	 	 ></td>"  ;
		echo "<td><input type=text name=mon$i size=\"2\"  value=\"{$row['monday']}\"	 	 ></td>"  ;
		echo "<td><input type=text name=tue$i size=\"2\"  value=\"{$row['tuesday']}\"	     ></td>"  ;
		echo "<td><input type=text name=wed$i size=\"2\"  value=\"{$row['wednesday']}\"		 ></td>"  ;
		echo "<td><input type=text name=thr$i size=\"2\"  value=\"{$row['thursday']}\"	     ></td>"  ;
		echo "<td><input type=text name=fri$i size=\"2\"  value=\"{$row['friday']}\"	 	 ></td>"  ;
		echo "<td class=\"tot\">$sumrow</td>";
		echo "<td><input type=hidden name=task$i          value=\"{$row['taskid']}\"  	 	 ></td>"  ;
		echo "</tr>";
		$i=$i+1;
		}

		echo "<tr> <td colspan=\"4\" class=\"tot\">Total</td> <td class=\"tot\">$tsaturday</td> <td class=\"tot\">$tsunday</td> <td class=\"tot\">$tmonday </td> <td class=\"tot\">$ttuesday</td> <td class=\"tot\">$twednesday</td> <td class=\"tot\">$tthursday</td> <td class=\"tot\">$tfriday </td> <td class=\"tot\"> $tot</td> </tr>";
		echo "</table>";
		echo "<input type=hidden name=\"ival\" value=$i>";
		?>
		<br />
		<input id="btn" type="submit" name="update" value="Update Time Sheet">
		</br>

		<?php
		if(isset($sql1))
		{
		echo "Time Sheet Updated";
		echo "<br />";
		}

		/*Mail Part*/
		if(isset($sql1) && isset($_POST['update']))
		{
		$temp = mysql_query("select email_id,empname from usertable where empid='$_SESSION[SESS_mgrid]'");
		$row = mysql_fetch_array($temp);

		$to = $row['email_id'];
		/*$to = "nadeem.ansari@inputzero.com";*/
		$subj = "$_SESSION[SESS_ename] has updated the timesheet";
		$headers = 'From: noreply@inputzero.com';
		$txt = "Hi $row[empname],"."\n"."\n".

		"User $_SESSION[SESS_ename] has updated timesheet for the weekend ".$val4."."."\n".
		"This is a system generated mail. Please do not respond.\n\nThanks,\nnoreply@inputzero.com";

		// Use wordwrap() if lines are longer than 70 characters
		$txt = wordwrap($txt,100);

		// Send email
		$true = mail($to, $subj, $txt, $headers);

		if($true==1)
		{
		echo "Notification Mail Sent";
		}
		else {echo "Unable to Send Notification Mail";}

		}/*End of Mail Part*/
		?>
		</form>