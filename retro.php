<div id="middle_right_top">
		<h2>Enter Time Sheet</h2>
		</div>
<script>
function openUser()
{
//var x=$var;
//document.forms["form1"].elements['tmp1'].value=x;
//document.forms["form1"].action="home.php?page=user_appraisal";
document.forms["form1"].submit();
}
function checkme()
{
alert("You cant do this");
}

</script>
<script type="text/javascript">
// adding table rows

    $(document).ready(function(){
        $("#name").val(1);
        $(".add-row").click(function(){
              var i=$("#name").val();
            i++;
        $("#name").val(i);
            var name = "<input type='text' name='name'>";
            var email = "<input type='text' name='email'>";
            var markup = "<tr><td><input type='checkbox' name='record'></td><td>" + name + "</td><td>" + email + "</td></tr>";
            $("table tbody").append(markup);
        });
        
        // Find and remove selected table rows
        $(".delete-row").click(function(){
            $("table tbody").find('input[name="record"]').each(function(){
            	if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                    var i=$("#name").val();            
                    i--;
        $("#name").val(i);
                }
            });
        });
    });                                  		
</script>

		<?php
               
                $jy=isset($_POST['dat'])?$_POST['dat']:"";
                $dy=anyfriday($jy);
                 echo "<td><input type=text name=dat id=dat value=\"".$dy."\" readonly=readonly class=ro size=\"10\">";
		echo "<a href=\"javascript:NewCal('dat','yyyymmdd')\">
		<img src=datetimepick/cal.gif width=15 height=15 border=0 alt=Pick a date></a></td>";
               
                echo '<input id="btn" type="submit" name="opensheet" value="opensheet">';
		
                if(isset($_POST['dat']))
                {
                //$dy=new DateTime(friday());
                
                $dy=new DateTime(anyfriday($_POST['dat']));
                    ?>
<input id="btn" type="submit"  name="addrow1" value="Add Row">
		<input type="hidden" name="row1" size="2" value="1">

		<table border="1" width="750">
		<th>CHARGECODE</th><th>PROJECT</th><th>TASK</th>
		<th>SAT<br/><?php $j=$dy->modify("-6 days");echo $j->format('d-M');?></th>
		<th>SUN<br/><?php $j=$dy->modify("+1 days");echo $j->format('d-M');?></th>
		<th>MON<br/><?php $j=$dy->modify("+1 days");echo $j->format('d-M');?></th>
		<th>TUE<br/><?php $j=$dy->modify("+1 days");echo $j->format('d-M');?></th>
		<th>WED<br/><?php $j=$dy->modify("+1 days");echo $j->format('d-M');?></th>
		<th>THU<br/><?php $j=$dy->modify("+1 days");echo $j->format('d-M');?></th>
		<th>FRI<br/><?php $j=$dy->modify("+1 days");echo $j->format('d-M');?></th><th>TOTAL</th>
		<tr>
		<?php
               }
               
                
		if(isset($_POST['addrow1']))
		{
		$amount = $_POST['row1'];
		$i=0;
		while($i<$amount)
		{
		echo "<tr>";
		echo "<td><select name=\"cha$i\" onChange=\"getcode(this.value);\">";
		echo "<option value=\"\">Select Code</option>";
		ccode2();
		echo "</select></td>";

		echo "<td><div id=\"projectdiv\"><select name=\"pro$i\">";
		echo "<option value=\"\">Select Project</option>";
		/*ddl();*/
		echo "</select></div></td>";

		/*echo "<td><select name=\"tas$i\">";
		echo "<option value=\"\">Select Task</option>";
		task();
		echo "</select></td>";*/

		echo "<td> <input type=\"text\" name=\"tas$i\" value=\"\" size=\"20\" >  </td>" ;
		echo "<td> <input type=\"text\" name=\"sat$i\" value=\"\" size=\"3\" >  </td>" ;
		echo "<td> <input type=\"text\" name=\"sun$i\" value=\"\" size=\"3\" >  </td>" ;
		echo "<td> <input type=\"text\" name=\"mon$i\" value=\"\" size=\"3\" >  </td>" ;
		echo "<td> <input type=\"text\" name=\"tue$i\" value=\"\" size=\"3\" >  </td>" ;
		echo "<td> <input type=\"text\" name=\"wed$i\" value=\"\" size=\"3\" >  </td>" ;
		echo "<td> <input type=\"text\" name=\"thr$i\" value=\"\" size=\"3\" >  </td>" ;
		echo "<td> <input type=\"text\" name=\"fri$i\" value=\"\" size=\"3\" >  </td>" ;
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
		$empval=$_SESSION['SESS_empid'];
		while($j<$_POST['ival'])
		{
		$d1 = 'cha'.$j;
		//$d2 = 'des'.$j;
		$d3 = 'mon'.$j;
		$d4 = 'tue'.$j;
		$d5 = 'wed'.$j;
		$d6 = 'thr'.$j;
		$d7 = 'fri'.$j;
		$d8 = 'sat'.$j;
		$d9 = 'sun'.$j;
		$d10 = 'pro'.$j;
		$d11 = 'tas'.$j;

		$val1 = $_POST[$d1];
		//$val2 = $_POST[$d2];
		$val3 = $_POST[$d3];
		$val4 = $_POST[$d4];
		$val5 = $_POST[$d5];
		$val6 = $_POST[$d6];
		$val7 = $_POST[$d7];
		$val8 = $_POST[$d8];
		$val9 = $_POST[$d9];
		$val10 = $_POST[$d10];
		$val11 = $_POST[$d11];

		if((is_numeric($val3)||empty($val3)) && (is_numeric($val4)||empty($val4)) && (is_numeric($val5)||empty($val5)) && (is_numeric($val6)||empty($val6)) && (is_numeric($val7)||empty($val7)) && (is_numeric($val8)||empty($val8)) && (is_numeric($val9)||empty($val9)))
		{
		$date=anyfriday($jy);
		$ts = new DateTime(anyfriday($jy));
		$dint = $ts->format('U');

		$sql = "INSERT INTO timetable (empid,empname,chargecode,monday,tuesday,wednesday,thursday,friday,saturday,sunday,date,project,task,datevar,mgrid) VALUES ('$empval','$_SESSION[SESS_ename]','$val1', '$val3', '$val4', '$val5', '$val6', '$val7', '$val8', '$val9','$dint','$val10','$val11','$date','$_SESSION[SESS_mgrid]')";
echo $sql;
		if (!mysql_query($sql,$con))
		{
		die('Error: ' . mysql_error());
		}

		}
		else{echo "ERROR: Enter only Digits!";}
		$j=$j+1;
		}
		}
		?><!--End of insert query-->

		<?php
		if(isset($_POST['submit']) && !isset($_POST['ival']))
		{
                
		$j=0;
		while($j<$_POST['jval'])
		{
		$d  = 'ta_tb'.$j;
		$d1 = 'ch_tb'.$j;
		//$d2 = 'de_tb'.$j;
		$d3 = 'mo_tb'.$j;
		$d4 = 'tu_tb'.$j;
		$d5 = 'we_tb'.$j;
		$d6 = 'th_tb'.$j;
		$d7 = 'fr_tb'.$j;
		$d8 = 'sa_tb'.$j;
		$d9 = 'su_tb'.$j;
		$d10 = 'ddl'.$j;
		$d11 = 'task'.$j;

		$val  = $_POST[$d];
		$val1 = $_POST[$d1];
		//$val2 = $_POST[$d2];
		$val3 = $_POST[$d3];
		$val4 = $_POST[$d4];
		$val5 = $_POST[$d5];
		$val6 = $_POST[$d6];
		$val7 = $_POST[$d7];
		$val8 = $_POST[$d8];
		$val9 = $_POST[$d9];
		$val10 = $_POST[$d10];
		$val11 = $_POST[$d11];

		if((is_numeric($val3)||empty($val3)) && (is_numeric($val4)||empty($val4)) && (is_numeric($val5)||empty($val5)) && (is_numeric($val6)||empty($val6)) && (is_numeric($val7)||empty($val7)) && (is_numeric($val8)||empty($val8)) && (is_numeric($val9)||empty($val9)))
		{
		$sql1="UPDATE timetable set chargecode='$val1', monday='$val3', tuesday='$val4', wednesday='$val5', thursday='$val6', friday='$val7', saturday='$val8', sunday='$val9', project='$val10', task='$val11' where taskid='$val'";
		if (!mysql_query($sql1, $con))
		{
		die('Error: ' . mysql_error());
		}
		}
		else{echo "ERROR: Enter only Digits!";}
		$j++;
		}
		}
		?><!--End of update query-->

		<?php
/*Mail Part*/
		if(isset($_POST['mail']))
		{
		$sdat = new DateTime(friday());
		$da=$sdat->format('U');
		$sql2 = mysql_query("UPDATE timetable set tmp='1' where empid='$_SESSION[SESS_empid]' and date='$da'");

		$temp = mysql_query("select email_id,empname from usertable where empid='$_SESSION[SESS_mgrid]'");
		$row = mysql_fetch_array($temp);

		$to = $row['email_id'];
		/*$to = "nadeem.ansari@inputzero.com";*/
		$subj = "$_SESSION[SESS_ename] has submitted timesheet for current weekend";
		$headers = 'From: noreply@inputzero.com';
		$txt = "Hi $row[empname],"."\n"."\n".

		"User $_SESSION[SESS_ename] has submitted time sheet for the weekend ".friday()."."."\n".
		"This is a system generated mail. Please do not respond.\n\nThanks,\nnoreply@inputzero.com";

		// Use wordwrap() if lines are longer than 70 characters
		$txt = wordwrap($txt,100);

		// Send email
		$true = mail($to, $subj, $txt, $headers);

		}
/*End of Mail Part*/

		//$date=friday();
                //echo $dy;
		//$sdat = new DateTime($jy);
                if(isset($_POST['dat'])){
		$sdat=new DAteTime(anyfriday($_POST['dat']));
                $da=$sdat->format('U');
$origsql="SELECT * FROM timetable where empid='$_SESSION[SESS_empid]' and date='$da'";		
$result = mysql_query($origsql);
		
                $j=0;
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

		echo "<input type=hidden name=ta_tb$j size=\"5\"  value=\"{$row['taskid']}\">";
		echo "<tr>";
		echo "<td><select name=\"ch_tb$j\" onChange=\"getcode(this.value);\">";
		echo "<option value=\"$row[chargecode]\">$row[chargecode]</option>";
		ccode2();
		echo "</select></td>";

		echo "<td><select name=\"ddl$j\">";
		echo "<option value=\"$row[project]\">$row[project]</option>";
		ddl();
		echo "</select></td>";

		/*echo "<td><select name=\"task$j\">";
		echo "<option value=\"$row[task]\">$row[task]</option>";
		task();
		echo "</select></td>";*/

		if($row['tmp'] == 1)
		{
		/*echo "check 1";*/
		$read = "readonly=\"readonly\" class=\"ro\"";
		}

		else if($row['tmp'] == 0 || $row['tmp'] == "")
		{
		/*echo "check 2";*/
		$read = "";
		}

		echo "<td> <input type=text $read name=task$j  value=\"$row[task]\"      size=\"20\" >  </td>";
		echo "<td> <input type=text $read name=sa_tb$j value=\"$row[saturday]\"  size=\"3\" >  </td>";
		echo "<td> <input type=text $read name=su_tb$j value=\"$row[sunday]\"    size=\"3\" >  </td>";
		echo "<td> <input type=text $read name=mo_tb$j value=\"$row[monday]\"    size=\"3\" >  </td>";
		echo "<td> <input type=text $read name=tu_tb$j value=\"$row[tuesday]\"   size=\"3\" >  </td>";
		echo "<td> <input type=text $read name=we_tb$j value=\"$row[wednesday]\" size=\"3\" >  </td>";
		echo "<td> <input type=text $read name=th_tb$j value=\"$row[thursday]\"  size=\"3\" >  </td>";
		echo "<td> <input type=text $read name=fr_tb$j value=\"$row[friday]\"    size=\"3\" >  </td>";
		echo "<td class=\"tot\">$sumrow</td>";
		echo "</tr>";
		$j++;
		}
		echo "<input type=hidden name=\"jval\" value=$j>";
		echo "<tr> <td colspan=\"3\" class=\"tot\">Total</td> <td class=\"tot\">$tsaturday</td> <td class=\"tot\">$tsunday</td> <td class=\"tot\">$tmonday </td> <td class=\"tot\">$ttuesday</td> <td class=\"tot\">$twednesday</td> <td class=\"tot\">$tthursday</td> <td class=\"tot\">$tfriday </td> <td class=\"tot\"> $tot</td> </tr>";
               
                ?>
		<!--End of Select query-->
		</table>
		<br />
		<!--Enter Number Of Rows:-->
		<input id="btn" type="submit" name="submit" value="Save">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input id="btn" type="submit" name="mail" value="Submit For The Week"><br/>

		<?php
                 }
		if(isset($sql))
		{
		echo "Time Sheet Saved";
		}

		if(isset($sql1))
		{
		echo "Time Sheet Updated";
		}

		if(isset($_POST['mail']))
		{
		if($true==1)
		{
		echo "Notification Mail Sent";
		}
		else {echo "Unable to Send Notification Mail";}
		}
		?>
		
