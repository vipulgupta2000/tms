<?php
echo "<table border='1'>
<tr>
<th>EMPID</th><th>EMPNAME</th><th>CHARGECODE</th><th>PROJECT</th><th>TASK</th><th>STATUS</th><th>DATE</th><th>SAT</th><th>SUN</th><th>MON</th> <th>TUE</th><th>WED</th> <th>THU</th><th>FRI</th><th>TOTAL</th>
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

$wendFirst=firstFriday($_POST['smonth'],1);
$offset=date("w", mktime(0,0,0,$_POST['smonth'],'1',date("Y")));

$wendLast=firstFriday($_POST['smonth']+1,1);
$oddset=date("w", mktime(0,0,0,$_POST['smonth']+1,'1',date("Y")));

/*$ts1 = new DateTime($wendFirst);
$stime=$ts1->format('U');//$stime contains integer value of date .....

$ts2 = new DateTime($wendLast);
$etime=$ts2->format('U');//$etime contains integer value of date .....*/

$sdat = new MyDateTime();

while($row = mysql_fetch_array($result))
{
$sdat->setTimestamp($row['date']);
$da = $sdat->format('Y-n-j');

echo "<tr>";
$sa = $row['saturday'] ;
$su = $row['sunday']   ;
$mo = $row['monday']   ;
$tu = $row['tuesday']  ;
$we = $row['wednesday'];
$th = $row['thursday'] ;
$fr = $row['friday']   ;

if($da==$wendFirst)
{
if($offset==0)                       //sun
{$sa=0;}

if($offset==1)                       //mon
{$sa=0;$su=0;}

if($offset==2)                       //tue
{$sa=0;$su=0;$mo=0;}

if($offset==3)                       //wed
{$sa=0;$su=0;$mo=0;$tu=0;}

if($offset==4)                       //thr
{$sa=0;$su=0;$mo=0;$tu=0;$we=0;}

if($offset==5)                       //fri
{$sa=0;$su=0;$mo=0;$tu=0;$we=0;$th=0;}
}

if($da==$wendLast)
{
if($oddset==0)
{$su=0;$mo=0;$tu=0;$we=0;$th=0;$fr=0;}

if($oddset==1)
{$mo=0;$tu=0;$we=0;$th=0;$fr=0;}

if($oddset==2)
{$tu=0;$we=0;$th=0;$fr=0;}

if($oddset==3)
{$we=0;$th=0;$fr=0;}

if($oddset==4)
{$th=0;$fr=0;}

if($oddset==5)
{$fr=0;}
}

// To Calculate the Total of Row.
$sumrow=$sa+$su+$mo+$tu+$we+$th+$fr;
$tot=$tot+$sumrow;

// To Calculate the Total of Column.
$tsaturday  = $tsaturday  +$sa;
$tsunday    = $tsunday    +$su;
$tmonday    = $tmonday    +$mo;
$ttuesday   = $ttuesday   +$tu;
$twednesday = $twednesday +$we;
$tthursday  = $tthursday  +$th;
$tfriday    = $tfriday    +$fr;

echo "<td>" .$row['empid']	 	. "</td>"  ;
echo "<td>" .$row['empname']	. "</td>"  ;
echo "<td>" .$row['chargecode'] . "</td>"  ;
echo "<td>" .$row['project']    . "</td>"  ;
echo "<td>" .$row['task']	    . "</td>"  ;
echo "<td>" .$row['status']	    . "</td>"  ;
echo "<td>" .$da  . "</td>"  ;
echo "<td>" .$sa  . "</td>"  ;
echo "<td>" .$su  . "</td>"  ;
echo "<td>" .$mo  . "</td>"  ;
echo "<td>" .$tu  . "</td>"  ;
echo "<td>" .$we  . "</td>"  ;
echo "<td>" .$th  . "</td>"  ;
echo "<td>" .$fr  . "</td>"  ;
echo "<td class=\"tot\">$sumrow</td>";
$i=$i+1;
echo "</tr>";
}
echo "<tr> <td colspan=\"7\" class=\"tot\">Total</td> <td class=\"tot\">$tsaturday</td> <td class=\"tot\">$tsunday</td> <td class=\"tot\">$tmonday </td> <td class=\"tot\">$ttuesday</td> <td class=\"tot\">$twednesday</td> <td class=\"tot\">$tthursday</td> <td class=\"tot\">$tfriday </td> <td class=\"tot\"> $tot</td> </tr>";
echo "</table>";
?>
