<div id="middle_right_top">
		<h2>Create Project</h2>
		</div>
		<form name="form3" onsubmit="return validateForm3()" action="" method="POST">
		<table width="auto" border="1" cellpadding="2" cellspacing="2">
		<th>CHARGECODE</th><th>PROJECT NAME</th><th>PROJECT CODE</th><th>PROJECT DESCRIPTION</th><th>START DATE</th><th>END DATE</th><th>STATUS</th>
		<tr><?php
		echo "<td><select name=\"cha\">";
		echo "<option value=\"\">Select Code</option>";
		ccode();
		echo "</select></td>";?>
		<td> <input type="text" name="pname" size="13" onBlur="validateOB(this)"></td>
		<td> <input type="text" name="pcode" size="12" onBlur="validate1(this)"></td>
		<td> <input type="text" name="pdesc" size="22"></td>
		<td> <input type="text" name="sdate" id="sdate" size="7" readonly="readonly" class="ro">
		<a href="javascript:NewCal('sdate','yyyymmdd')">
		<img src="datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
		</td>
		<td> <input type="text" name="edate" id="edate" size="7" readonly="readonly" class="ro">
		<a href="javascript:NewCal('edate','yyyymmdd')">
		<img src="datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
		</td>
		<td> <select name="stat"> <option value="">Select Status</option> <option value="On Going">On Going</option> <option value="Finished">Finished</option> </select></td>
		</tr>
		</table>
		<br />
		<input id="btn" type="submit" name="cpro" value="CREATE PROJECT">

		<?php
		if(isset($_POST['cpro']))
		{
		$ts1 = new DateTime($_POST['sdate']);
		$sdate=$ts1->format('U');

		$ts2 = new DateTime($_POST['edate']);
		$edate=$ts2->format('U');

		$sql = "INSERT INTO projecttable (c_code, p_name, p_code, p_description , s_date, e_date, status) VALUES ('$_POST[cha]','$_POST[pname]', '$_POST[pcode]', '$_POST[pdesc]', '$sdate', '$edate', '$_POST[stat]')";

		if (!mysql_query($sql,$con))
		{
		die('Error: ' . mysql_error());
		}
		if($sql){echo "Operation Successful";}
		}
		?>
		</form>