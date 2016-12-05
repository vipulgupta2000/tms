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

$sdat = new MyDateTime();
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
echo "<td>" .$row['status']	     . "</td>"  ;
echo "<td>" .$da             	 . "</td>"  ;
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
?>
