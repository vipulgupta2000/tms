<div id="middle_right_top">
		<h2>Retrospective Time Sheet</h2>
		</div>
		<form name="form1" action="" onsubmit="return validateForm1()" method="POST">

		<input id="btn" type="submit" name="addrow" value="Add Row">
		<input type="hidden" name="row1" size="2" value="1">

		<table border="1" width="750">

		<!--<th>EMPID</th><th>EMPNAME</th>--><th>CHARGECODE</th><th>PROJECT</th><th>TASK</th><th>DATE</th><th>SAT</th><th>SUN</th>
		<th>MON</th><th>TUE</th><th>WED</th><th>THU</th><th>FRI</th><th>TOTAL</th>
		<tr>
		<?php
		if(isset($_POST['addrow']))
		{
		$amount = $_POST['row1'];
		$i=0;
		while($i<$amount)
		{
		echo "<tr>";
		/*echo "<td><select name=\"empid$i\">";
		echo "<option value=\"\">Select Code</option>";
		eid();
		echo "</select></td>";

		echo "<td><select name=\"empname$i\">";
		echo "<option value=\"\">Select Code</option>";
		ename();
		echo "</select></td>";*/

		echo "<td><select name=\"cha$i\" onChange=\"getcode(this.value);\">";
		echo "<option value=\"\">Select Code</option>";
		ccode2();
		echo "</select></td>";

		echo "<td><div id=\"projectdiv\"><select name=\"pro$i\">";
		echo "<option value=\"\">Select Project</option>";
		/*ddl();*/
		echo "</select></div></td>";

		echo "<td> <input type=\"text\" name=\"tas$i\" value=\"\" size=\"10\" > </td>" ;

		echo "<td><input type=text name=dat$i id=dat$i value=\"\" readonly=readonly class=ro size=\"6\">";
		echo "<a href=\"javascript:NewCal('dat$i','yyyymmdd')\">
		<img src=datetimepick/cal.gif width=15 height=15 border=0 alt=Pick a date></a></td>";

		echo "<td> <input type=\"text\" name=\"sat$i\" value=\"\" size=\"2\" >  </td>" ;
		echo "<td> <input type=\"text\" name=\"sun$i\" value=\"\" size=\"2\" >  </td>" ;
		echo "<td> <input type=\"text\" name=\"mon$i\" value=\"\" size=\"2\" >  </td>" ;
		echo "<td> <input type=\"text\" name=\"tue$i\" value=\"\" size=\"2\" >  </td>" ;
		echo "<td> <input type=\"text\" name=\"wed$i\" value=\"\" size=\"2\" >  </td>" ;
		echo "<td> <input type=\"text\" name=\"thr$i\" value=\"\" size=\"2\" >  </td>" ;
		echo "<td> <input type=\"text\" name=\"fri$i\" value=\"\" size=\"2\" >  </td>" ;
		echo "<td class=\"tot\"> </td></tr>";
		$i++;
		}
		echo "<input type=hidden name=\"ival\" value=$i>";
		}
		?><!--End of add row button-->
		</tr>

		<?php
		if(1<=isset($_POST['ival']) && isset($_POST['submit']))
		{
		$j=0;
		while($j<$_POST['ival'])
		{
		/*$d1  = 'empid'.$j;
		$d2  = 'empname'.$j;*/
		$d3  = 'cha'.$j;
		$d4  = 'pro'.$j;
		$d5  = 'tas'.$j;
		$d6  = 'dat'.$j;
		$d7  = 'sat'.$j;
		$d8  = 'sun'.$j;
		$d9  = 'mon'.$j;
		$d10 = 'tue'.$j;
		$d11 = 'wed'.$j;
		$d12 = 'thr'.$j;
		$d13 = 'fri'.$j;

		/*$val1 = $_POST[$d1];
		$val2 = $_POST[$d2];*/
		$val1 = $_SESSION['SESS_empid'];
		$val2 = $_SESSION['SESS_ename'];
		$val3 = $_POST[$d3];
		$val4 = $_POST[$d4];
		$val5 = $_POST[$d5];
		$val6 = $_POST[$d6];
		$val7 = $_POST[$d7];
		$val8 = $_POST[$d8];
		$val9 = $_POST[$d9];
		$val10 = $_POST[$d10];
		$val11 = $_POST[$d11];
		$val12 = $_POST[$d12];
		$val13 = $_POST[$d13];

		if((is_numeric($val7)||empty($val7)) && (is_numeric($val8)||empty($val8)) && (is_numeric($val9)||empty($val9)) && (is_numeric($val10)||empty($val10)) && (is_numeric($val11)||empty($val11)) && (is_numeric($val12)||empty($val12)) && (is_numeric($val13)||empty($val13)))
		{
		$ts = new DateTime($val6);
		$dint = $ts->format('U');

		$sql = "INSERT INTO timetable (empid,empname,chargecode,project,task,date,datevar,saturday,sunday,monday,tuesday,wednesday,
		thursday,friday,tmp) VALUES ('$val1','$val2','$val3', '$val4','$val5','$dint','$val6',
		'$val7','$val8','$val9','$val10','$val11','$val12','$val13','1')";

		if (!mysql_query($sql,$con))
		{
		die('Error: ' . mysql_error());
		}

		}
		else{echo "ERROR: Enter only Digits!";}
		$j=$j+1;
		}/*End of while*/

/*Mail Part*/

		$temp = mysql_query("select email_id,empname from usertable where empid='$_SESSION[SESS_mgrid]'");
		$row = mysql_fetch_array($temp);

		$to = $row['email_id'];
		/*$to = "nadeem.ansari@inputzero.com";*/
		$subj = "Retrospective timesheet for weekend $val6 has been submitted";
		$headers = 'From: noreply@inputzero.com';
		$txt = "Hi $row[empname],"."\n"."\n".

		"User $_SESSION[SESS_ename] has submitted retrospective timesheet for the weekend $val6."."\n".
		/*"Please fill your timesheet every weekend."."\n".*/
		"This is a system generated mail. Please do not respond.\n\nThanks,\nnoreply@inputzero.com";

		// Use wordwrap() if lines are longer than 70 characters
		$txt = wordwrap($txt,100);

		// Send email
		$true = mail($to, $subj, $txt, $headers);

		}/*End of if loop*/
		?><!--End of insert query-->

		<?php
		$tot=0;
		$tsaturday =0;
		$tsunday   =0;
		$tmonday   =0;
		$ttuesday  =0;
		$twednesday=0;
		$tthursday =0;
		$tfriday   =0;
		if(isset($_POST['submit']))
		{
		$sdat = new DateTime($val6);
		$da=$sdat->format('U');

		$result = mysql_query("SELECT * FROM timetable where empid='$_SESSION[SESS_empid]' and date='$da'");
		$j=0;

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

		echo "<input type=hidden name=ta_tb$j size=\"5\"  value=\"{$row['taskid']}\">";
		echo "<tr>";
		echo "<td> $row[chargecode] </td>";
		echo "<td> $row[project]    </td>";
		echo "<td> $row[task]       </td>";
		echo "<td> $row[datevar]    </td>";
		echo "<td> $row[saturday]   </td>";
		echo "<td> $row[sunday]     </td>";
		echo "<td> $row[monday]     </td>";
		echo "<td> $row[tuesday]    </td>";
		echo "<td> $row[wednesday]  </td>";
		echo "<td> $row[thursday]   </td>";
		echo "<td> $row[friday]     </td>";
		echo "<td class=\"tot\">$sumrow</td>";
		echo "</tr>";
		$j++;
		}
		echo "<input type=hidden name=\"jval\" value=$j>";
		}
		echo "<tr> <td colspan=\"4\" class=\"tot\">Total</td> <td class=\"tot\">$tsaturday</td> <td class=\"tot\">$tsunday</td> <td class=\"tot\">$tmonday </td> <td class=\"tot\">$ttuesday</td> <td class=\"tot\">$twednesday</td> <td class=\"tot\">$tthursday</td> <td class=\"tot\">$tfriday </td> <td class=\"tot\"> $tot</td> </tr>";
		?>
		<!--End of Select query-->
		</table>
		<br />
		<!--Enter Number Of Rows:-->
		<input id="btn" type="submit" name="submit" value="Submit">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<!--<input id="btn" type="submit" name="mail" value="Submit For The Week">--><br/>
		<?php
		if(isset($sql))
		{
		echo "Time Sheet Submitted";
		}

		if(isset($_POST['submit']))
		{
		if($true==1)
		{
		echo "<br/>";
		echo "Notification Mail Sent";
		}
		else {echo "Unable to Send Notification Mail";}
		}
		?>
		</form>