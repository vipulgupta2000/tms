<div id="middle_right_top">
		<h2>Update Project</h2>
		</div>
		<form name="form4" onsubmit="return validateForm4()" action="" method="POST">
		<?php
		if(isset($_POST['update']))
		{
		$j=0;
		while($j<$_POST['ival'])
		{
		$d1 = 'pname'.$j;
		$d2 = 'pcode'.$j;
		$d3 = 'pdesc'.$j;
		$d4 = 'sdate'.$j;
		$d5 = 'edate'.$j;
		$d6 = 'ustat'.$j;

		$val1 = $_POST[$d1];
		$val2 = $_POST[$d2];
		$val3 = $_POST[$d3];

		$ts1 = new DateTime($_POST[$d4]);
		$val4=$ts1->format('U');
		$ts2 = new DateTime($_POST[$d5]);
		$val5=$ts2->format('U');

		$val6 = $_POST[$d6];

		if(isset($_POST['chb'.$j]))
		{
		$sql1="UPDATE projecttable set p_name='$val1',  p_description='$val3', s_date='$val4', e_date='$val5', status='$val6' where p_code='$val2'";
		if (!mysql_query($sql1, $con))
		{
		die('Error: ' . mysql_error());
		}
		$k=1;
		}//end of if
		$j++;
		}//end of whileloop
		if(!isset($_POST['chb'.$j]) && isset($_POST['update']))
		{
		if(!isset($k)){echo('Error: Please Select a Check Box.');}
		}
		if(isset($sql1))
		{
		echo "Project updated";
		}
		}
		?>

		<?php
		$result = mysql_query("SELECT * FROM projecttable where status !=\"Finished\"");

		echo "<table width=auto border=1 cellpadding=2 cellspacing=2>
		<tr>
		<th>CHARGE CODE</th><th>PROJECT NAME</th><th>PROJECT CODE</th><th>PROJECT DESCRIPTION</th><th>START DATE</th><th>END DATE</th><th>SELECT STATUS</th>
		</tr>";
		class MyDateTime extends DateTime
		{
		    public function setTimestamp( $timestamp )
		    {
		        $date = getdate( ( int ) $timestamp );
		        $this->setDate( $date['year'] , $date['mon'] , $date['mday'] );
		        $this->setTime( $date['hours'] , $date['minutes'] , $date['seconds'] );
		    }
		    public function getTimestamp()
		    {
		        return $this->format( 'U' );
		    }
		}
		$i=0;
		$tdate = new MyDateTime();
		$fdate = new MyDateTime();
		while($row = mysql_fetch_array($result))
		{
		$tdate->setTimestamp($row['s_date']);
		$valA = $tdate->format('Y-n-j');

		$fdate->setTimestamp($row['e_date']);
		$valB = $fdate->format('Y-n-j');

		echo "<tr>";
		echo "<td><input type=text name=ccode$i value=\"{$row['c_code']}\" readonly=readonly class=ro size=\"11\" ></td>"  ;
		echo "<td><input type=text name=pname$i value=\"{$row['p_name']}\"				   size=\"11\" ></td>"  ;
		echo "<td><input type=text name=pcode$i value=\"{$row['p_code']}\" readonly=readonly class=ro size=\"11\" ></td>"  ;
		echo "<td><input type=text name=pdesc$i value=\"{$row['p_description']}\"			   size=\"20\" ></td>"  ;

		echo "<td><input type=text name=sdate$i id=sdate$i value=\"$valA\" readonly=readonly class=ro size=\"7\">";
		echo "<a href=\"javascript:NewCal('sdate$i','yyyymmdd')\">";
		echo "<img src=datetimepick/cal.gif width=16 height=16 border=0 alt=Pick a date></a></td>";

		echo "<td><input type=text name=edate$i id=edate$i value=\"$valB\" readonly=readonly class=ro size=\"7\">";
		echo "<a href=\"javascript:NewCal('edate$i','yyyymmdd')\">";
		echo "<img src=datetimepick/cal.gif width=16 height=16 border=0 alt=Pick a date></a></td>";

		echo "<td><input type=checkbox name=chb$i><select name=\"ustat$i\"> <option value=\"\">$row[status]</option> <option value=\"On Going\">On Going</option> <option value=\"Finished\">Finished</option> </select></td>";
		echo "</tr>";
		$i++;
		}
		echo "</table>";
		echo "<input type=hidden name=\"ival\" value=$i>";
		?>
		<br />
		<input id="btn" type="submit" name="update" onclick="return chk()" value="UPDATE">
		</form>
