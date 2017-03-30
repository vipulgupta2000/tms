<div id="middle_right_top">
		<h2>View Reports</h2>
		</div>
		<form name="form2"  action="" method="POST">
		<table width="auto" border="1" cellpadding="2" cellspacing="2">
		<tr>
		<?php
		if ($_SESSION['SESS_perm']=='admin' || $_SESSION['SESS_perm']=='manager' )
		{
		/*echo "<th align=left>Search By Employee ID:   </th>";*/
		echo "<th align=left>Search By Project Name: </th>";
		echo "<th align=left>Search By Employee Name: </th>";
		echo "<th align=left>Search By Charge Code: </th>";
		}
		?>
		<th align="left">Search By Month:</th>
		<th align="left">Search By Last Year:</th>
		<th align="left">Search By WeekEnd Date(Friday):</th>
		</tr>

		<tr>
		<?php
		if ($_SESSION['SESS_perm']=='admin' || $_SESSION['SESS_perm']=='manager' )
		{
		/*echo "<td><select name=\"empids\">";
		echo "<option value=\"\">Select EmpID</option>";
		eid();
		echo "</select></td>";*/

		echo "<td><select name=\"project\">";
        echo "<option value=\"\">Select Project</option>";
        ddl();
        echo "</select></td>";

		echo "<td><select name=\"empname\">";
		echo "<option value=\"\">Select EmpName</option>";
		ename();
		echo "</select></td>";

		echo "<td><select name=\"charge\">";
		echo "<option value=\"\">Select Charge Code</option>";
		ccode();
		echo "</select></td>";
		}
		?>
		<td><select name="smonth">
		<option value=  > Select Month </option>
		<option value= 1> January      </option>
		<option value= 2> February     </option>
		<option value= 3> March        </option>
		<option value= 4> April        </option>
		<option value= 5> May          </option>
		<option value= 6> June         </option>
		<option value= 7> July         </option>
		<option value= 8> August       </option>
		<option value= 9> September    </option>
		<option value=10> October      </option>
		<option value=11> November     </option>
		<option value=12> December     </option>
		</select></td>

		<td>
		<?php
		$lastyear  = date("Y", mktime(0, 0, 0, date("m"),   date("d"),   date("Y")-1));
		/*$currentyear  = date("Y", mktime(0, 0, 0, date("m"),   date("d"),   date("Y")));*/
		?>
		<select name="lyear">
		<option value=  > Select Year </option>
		<?php
		echo "<option value= $lastyear > $lastyear </option>";
		/*echo "<option value= $currentyear > $currentyear </option>";*/
		?>
		</select>
		</td>

		<td><input readonly="readonly" name="day" id="day" type="text" size="23" class="ro">
		<a href="javascript:NewCal('day','yyyymmdd')">
		<img src="datetimepick/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
		</td>
		</tr>
		</table>
							<!--<input type="submit" name="convert" value="convert">
							<?php
							/*if(isset($_POST['convert']))
							{
							$date_start = firstOfMonth($_POST['smonth']);
							$date_end  = lastOfMonth($_POST['smonth']);
							echo "$date_start"." "."$date_end";
							echo "first weekend is".friday($_POST['smonth'],1);
							echo "first weekend of next month".friday($_POST['smonth']+1,1);
							}

							function firstOfMonth($m)
							{
							return date("w:D:Y/n/j", mktime(0,0,0,$m,'01',date("Y")));
							}

							function lastOfMonth($m)
							{
							$m=$m+1;
							return date("w:D:Y/n/j", mktime(0,0,0,$m,0,date("Y")));
							}*/
							?>-->

		<?php
		function firstFriday($m,$d)
		{
		if ( date("l",mktime(0, 0, 0, $m, $d, date("Y")))=="Monday" ){$j=4;}
		if ( date("l",mktime(0, 0, 0, $m, $d, date("Y")))=="Tuesday" ){$j=3;}
		if ( date("l",mktime(0, 0, 0, $m, $d, date("Y")))=="Wednesday" ){$j=2;}
		if ( date("l",mktime(0, 0, 0, $m, $d, date("Y")))=="Thursday" ){$j=1;}
		if ( date("l",mktime(0, 0, 0, $m, $d, date("Y")))=="Friday" ){$j=0;}
		if ( date("l",mktime(0, 0, 0, $m, $d, date("Y")))=="Saturday" ){$j=6;}
		if ( date("l",mktime(0, 0, 0, $m, $d, date("Y")))=="Sunday" ){$j=5;}
		return date("Y-n-j", mktime(0, 0, 0, $m, $d+$j, date("Y")));
		}

		function lastyearFriday($m,$d,$y)
		{
		if ( date("l",mktime(0, 0, 0, $m, $d, $y))=="Monday" ){$j=4;}
		if ( date("l",mktime(0, 0, 0, $m, $d, $y))=="Tuesday" ){$j=3;}
		if ( date("l",mktime(0, 0, 0, $m, $d, $y))=="Wednesday" ){$j=2;}
		if ( date("l",mktime(0, 0, 0, $m, $d, $y))=="Thursday" ){$j=1;}
		if ( date("l",mktime(0, 0, 0, $m, $d, $y))=="Friday" ){$j=0;}
		if ( date("l",mktime(0, 0, 0, $m, $d, $y))=="Saturday" ){$j=6;}
		if ( date("l",mktime(0, 0, 0, $m, $d, $y))=="Sunday" ){$j=5;}
		return date("Y-n-j", mktime(0, 0, 0, $m, $d+$j, $y));
		}
		?>
		<br />
		<?php
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
		?>

		<?php
		if ($_SESSION['SESS_perm']=='admin' || $_SESSION['SESS_perm']=='manager')
		{
		echo "<input id=\"btn\" name=\"search\" type=\"submit\"  value =\"Search Timesheet\" onclick=\"return validateForm2a()\">";
		if(isset($_POST['search']) && empty($_POST['project']) && empty($_POST['empname']) && empty($_POST['charge'])
		&& empty($_POST['lyear']) && !empty($_POST['smonth']) && empty($_POST['day']))
		{
		$da1 = firstFriday($_POST['smonth'],1);
		$ts1 = new DateTime($da1);
		$stime=$ts1->format('U');
		$da2 = firstFriday($_POST['smonth']+1,1);
		$ts2 = new DateTime($da2);
		$etime=$ts2->format('U');
		$result = mysql_query("SELECT * FROM timetable WHERE (date between $stime and $etime) order by date");
		include("monthfunc.php");
		}

		if(isset($_POST['search']) && empty($_POST['project']) && !empty($_POST['empname']) && empty($_POST['charge'])
		&& !empty($_POST['smonth']) && empty($_POST['lyear']) && empty($_POST['day']))
		{
		$da1 = firstFriday($_POST['smonth'],1);
		$ts1 = new DateTime($da1);
		$stime=$ts1->format('U');
		$da2 = firstFriday($_POST['smonth']+1,1);
		$ts2 = new DateTime($da2);
		$etime=$ts2->format('U');
		$result = mysql_query("SELECT * FROM timetable WHERE (date between $stime and $etime) and empname='$_POST[empname]'
		order by date");
		include("monthfunc.php");
        }

	    if(isset($_POST['search']) && empty($_POST['project']) && !empty($_POST['empname']) && empty($_POST['charge'])
		&& empty($_POST['smonth']) && empty($_POST['lyear']) && empty($_POST['day']))
		{
		$result = mysql_query("SELECT * FROM timetable WHERE empname ='$_POST[empname]' order by date");
		include("searchfunc.php");
		}

		if(isset($_POST['search']) && empty($_POST['project']) && empty($_POST['empname']) && empty($_POST['charge'])
		&& empty($_POST['smonth']) && empty($_POST['lyear']) && !empty($_POST['day']))
		{
		$ts = new DateTime($_POST['day']);
		$wend = $ts->format('U');
		$result = mysql_query("SELECT * FROM timetable WHERE date ='$wend' order by date");
		include("searchfunc.php");
		}

		if(isset($_POST['search']) && empty($_POST['project']) && !empty($_POST['empname']) && !empty($_POST['charge'])
		&& !empty($_POST['smonth']) && empty($_POST['lyear']) && empty($_POST['day']))
		{
		$da1 = firstFriday($_POST['smonth'],1);
		$ts1 = new DateTime($da1);
		$stime=$ts1->format('U');
		$da2 = firstFriday($_POST['smonth']+1,1);
		$ts2 = new DateTime($da2);
		$etime=$ts2->format('U');
		$result = mysql_query("SELECT * FROM timetable WHERE (date between $stime and $etime) and empname='$_POST[empname]'
		and chargecode='$_POST[charge]' order by date");
		include("monthfunc.php");
		}

		if(isset($_POST['search']) && empty($_POST['project']) && empty($_POST['empname']) && !empty($_POST['charge'])
		&& empty($_POST['smonth']) && empty($_POST['lyear']) && empty($_POST['day']))
		{
		$result = mysql_query("SELECT * FROM timetable WHERE chargecode ='$_POST[charge]' order by date");
		include("searchfunc.php");
		}

		if(isset($_POST['search']) && empty($_POST['project']) && !empty($_POST['empname']) && !empty($_POST['charge'])
		&& empty($_POST['smonth']) && empty($_POST['lyear']) && empty($_POST['day']))
		{
		$result = mysql_query("SELECT * FROM timetable WHERE chargecode ='$_POST[charge]' and empname='$_POST[empname]'
		order by date");
		include("searchfunc.php");
		}

		if(isset($_POST['search']) && empty($_POST['project']) && !empty($_POST['empname']) && empty($_POST['charge'])
		&& !empty($_POST['smonth']) && !empty($_POST['lyear']) && empty($_POST['day']))
		{
		$da1 = lastyearFriday($_POST['smonth'],1,$_POST['lyear']);
		$ts1 = new DateTime($da1);
		$stime=$ts1->format('U');
		$da2 = lastyearFriday($_POST['smonth']+1,1,$_POST['lyear']);
		$ts2 = new DateTime($da2);
		$etime=$ts2->format('U');
		$result = mysql_query("SELECT * FROM timetable WHERE (date between $stime and $etime) and empname='$_POST[empname]'
		order by date");
		include("monthfunc.php");
		}

		if(isset($_POST['search']) && empty($_POST['project']) && !empty($_POST['empname']) && empty($_POST['charge'])
		&& empty($_POST['smonth']) && empty($_POST['lyear']) && !empty($_POST['day']))
        {
		$ts = new DateTime($_POST['day']);
        $wend = $ts->format('U');
        $result = mysql_query("SELECT * FROM timetable WHERE empname='$_POST[empname]' and date='$wend' order by date");
        include("searchfunc.php");
        }

		if(isset($_POST['search']) && empty($_POST['project']) && empty($_POST['empname']) && !empty($_POST['charge'])
		&& empty($_POST['smonth']) && empty($_POST['lyear']) && !empty($_POST['day']))
        {
        $ts = new DateTime($_POST['day']);
        $wend = $ts->format('U');
        $result = mysql_query("SELECT * FROM timetable WHERE chargecode ='$_POST[charge]' and date='$wend' order by date");
        include("searchfunc.php");
        }

		if(isset($_POST['search']) && !empty($_POST['project']) && empty($_POST['empname']) && empty($_POST['charge'])
		&& empty($_POST['smonth']) && empty($_POST['lyear']) && empty($_POST['day']))
        {
        $result = mysql_query("SELECT * FROM timetable WHERE project ='$_POST[project]' order by date");
        include("searchfunc.php");
        }

        if(isset($_POST['search']) && !empty($_POST['project']) && !empty($_POST['empname']) && empty($_POST['charge'])
        && empty($_POST['smonth']) && empty($_POST['lyear']) && empty($_POST['day']))
		{
		$result = mysql_query("SELECT * FROM timetable WHERE project ='$_POST[project]' and empname='$_POST[empname]'
		order by date");
		include("searchfunc.php");
		}

        if(isset($_POST['search'])  && !empty($_POST['project']) && empty($_POST['empname']) && empty($_POST['charge'])
        && !empty($_POST['smonth']) && empty($_POST['lyear']) && empty($_POST['day']))
        {
        $da1 = firstFriday($_POST['smonth'],1);
		$ts1 = new DateTime($da1);
		$stime=$ts1->format('U');
		$da2 = firstFriday($_POST['smonth']+1,1);
		$ts2 = new DateTime($da2);
		$etime=$ts2->format('U');
        $result = mysql_query("SELECT * FROM timetable WHERE (date between $stime and $etime) and project ='$_POST[project]'
        order by date");
        include("monthfunc.php");
        }

		}


		if ($_SESSION['SESS_perm']=='user')
		{
		echo "<input id=\"btn\" name=\"search\" type=\"submit\"  value =\"Search Timesheet\" onclick=\"return validateForm2b()\">";

		if(isset($_POST['search']) && !empty($_POST['smonth']) && !empty($_POST['lyear']) && empty($_POST['day']) )
		{
		$da1 = lastyearFriday($_POST['smonth'],1,$_POST['lyear']);
		$ts1 = new DateTime($da1);
		$stime=$ts1->format('U');
		$da2 = lastyearFriday($_POST['smonth']+1,1,$_POST['lyear']);
		$ts2 = new DateTime($da2);
		$etime=$ts2->format('U');
		$result = mysql_query("SELECT * FROM timetable WHERE (date between $stime and $etime) and empid='$_SESSION[SESS_empid]'
		order by date");
		include("monthfunc.php");
		}

		if(isset($_POST['search']) && !empty($_POST['smonth']) && empty($_POST['lyear']) && empty($_POST['day']) )
		{
		$da1 = firstFriday($_POST['smonth'],1);
		$ts1 = new DateTime($da1);
		$stime=$ts1->format('U');
		$da2 = firstFriday($_POST['smonth']+1,1);
		$ts2 = new DateTime($da2);
		$etime=$ts2->format('U');
		$result = mysql_query("SELECT * FROM timetable WHERE (date between $stime and $etime) and empid='$_SESSION[SESS_empid]'
		order by date");
		include("monthfunc.php");
		}

		if(isset($_POST['search']) && empty($_POST['lyear']) &&  !empty($_POST['day']) )
		{
		$ts = new DateTime($_POST['day']);
		$wend = $ts->format('U');
		$result = mysql_query("SELECT * FROM timetable WHERE date ='$wend' and empid='$_SESSION[SESS_empid]'
		order by date");
		include("searchfunc.php");
		}

		}
		?>
		</form>
