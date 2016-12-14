
<center>
<?php
echo "<h2>Create User</h2>";
?>

<form action="" name="nform"  method ="POST" >


<!--- Codes for Inserting a new Record-->
<?php
date_default_timezone_set('Etc/GMT');
if(isset($_POST['ok']))
{
$n1=$_POST['nempid'];
$n2=$_POST['nempname'];
$n3=$_POST['nusername'];
$n4=$_POST['npassword'];
$t7=new DateTime("$_POST[ndoj]");
$m5=$t7->format('U');

//echo "shashank";
$m5=$_POST['ndoj'];
$n6=$_POST['access'];
$n7=$_POST['managernm'];
$n8=$_POST['nearned'];
$n9=$_POST['ncasual'];
//$m1=$_POST['nval'];
$n51=new DateTime("$_POST[nval]");
$m1=$n51->format('U');


$bal = $n8 + $n9;

$sql1 = "INSERT INTO users (empid,empname,doj,username,password,permission,mgrid) VALUES('$n1','$n2','$m5','$n3','$n4','$n6','$n7')";

$sql2 = "INSERT INTO balancetable (empid,empname,doj,access,acc_leave,c_leave,e_leave,validity,bal_leave) VALUES('$n1','$n2','$m5','$n6','$bal','$n9','$n8','$m1','$bal')";
/*
if($n6=="manager" || $n6=="admin")
{
$k=1;
$sql3 = "INSERT INTO mgrtable (mgrid,mgrname) Values ('$n1','$n2')";
}
*/
if(!mysql_query($sql1,$con))
{
die ('Error in Insert  '.mysql_error());
}
if(!mysql_query($sql2,$con))
{
die ('Bugs in Inserting '.mysql_error());
}
else
echo "<b>User Created</b>";

if(isset($k))
{

if(!mysql_query($sql3,$con))
{die ('Bugs in Inserting '.mysql_error());}}
/*
else
echo "<b>User Created</b>";
*/
}

?>

<!--- Codes for Searching on the basis of empname or empid-->
<?php
date_default_timezone_set('Etc/GMT');
if(isset($_POST['ok1']))
{
$id=$_POST['nempid'];
$name=$_POST['nempname'];
}
$res = mysql_query("select * from balancetable where empid='$id' || empname='$name'");

$res1 = mysql_query("select * from usertable where empid='$id' || empname='$name'");

$row = mysql_fetch_array($res);

$row1 = mysql_fetch_array($res1);
{

$d = new DateTime();
$d->setTimestamp($row['doj']);
$doj=$d->format('d-m-Y');

$e = new DateTime();
$e->setTimestamp($row['validity']);
$val=$e->format('d-m-Y');

echo "<table align=center border=1>";
echo "<tr><td>Empid</td>";
echo "<td><input type=text name=\"nempid\" value=\"$row[empid]\" onblur=validate2(this) id=\"nempid\"></tr>";
echo "<tr><td>EmpName</td>";
echo "<td><input type=text name=\"nempname\" value=\"$row[empname]\" onblur=validate(this) id=\"nempname\"></tr>";
echo "<tr><td>Username</td>";
echo "<td><input type=text name=\"nusername\" value=\"$row1[username]\" onblur=validate2(this) id=\"nusername\"></tr>";
echo "<tr><td>Password</td>";
echo "<td><input type=password name=\"npassword\" value=\"$row1[password]\" id=\"npassword\"></tr>";
echo "<tr><td>Date Of Joining</td>";
echo "<td><input type=text name=\"ndoj\" value=\"$doj\" id=\"ndoj\"><a href=javascript:NewCal('ndoj','ddmmyyyy')>";
echo "<img src=images/cal.gif width=16 height=16 border=0 alt=Pick a date></a></tr>";
echo "<tr><td>Type of User</td>";
echo "<td><input type=text name=\"access\" value=\"$row[access]\" id=\"access\"></tr>";
echo "<tr><td>Manager Name</td>";
echo "<td><input type=text name=\"mgrid\" value=\"$row1[mgrid]\" id=\"mgrid\"></tr></tr>";
echo "<tr><td>Earned Leave</td>";
echo "<td><input type=text name=\"nearned\" value=\"$row[e_leave]\" onblur=\"validate1(this)\" id=\"nearned\"></tr>";
echo "<tr><td>Casual Leave</td>";
echo "<td><input type=text name=\"ncasual\" value=\"$row[c_leave]\" onblur=\"validate1(this)\" id=\"ncasual\"></tr>";
echo "<tr><td>Validity</td>";
echo "<td><input type=text name=\"nval\" value=\"$val\" id=\"nval\"><a href=javascript:NewCal('nval','ddmmyyyy')>";
echo "<img src=images/cal.gif width=16 height=16 border=0 alt=Pick a date></a></td></tr>";
echo "<tr><td colspan=2 align=center cellpadding=2><input  type=submit  class=\"btn\" value=Submit  name=\"ok\">
		<input  type=submit value=Search class=\"btn\"  name=\"ok1\">
		<input  type=submit value=Update class=\"btn\" name=\"ok2\">
		</td>
</tr>";
echo "</table>";
}
?>

<!--- Codes for Updation-->
<?php
date_default_timezone_set('Etc/GMT');
if(isset($_POST['ok2']))
{
$n1=$_POST['nempid'];
$n2=$_POST['nempname'];
$n3=$_POST['nusername'];
$n4=$_POST['npassword'];

//$m55=$_POST['ndoj'];
$n5=new DateTime($_POST['ndoj']);
$m5=$n5->format('U');
//echo "ur not gr8";
$n6=$_POST['access'];
$n7=$_POST['mgrid'];
$n8=$_POST['nearned'];
$n9=$_POST['ncasual'];
//$m1=$_POST['nval'];
$t1=new DateTime($_POST['nval']);
$m1=$t1->format('U');

$bal = $n8 + $n9;
$sql3 = "update usertable set empname='$n2',doj='$m5',username='$n3',password='$n4',permission='$n6',mgrid='$n7' where empid='$n1'";

$sql4 = "update balancetable set empname='$n2', doj='$m5',dojint='$m5', access='$n6', acc_leave='$bal', c_leave='$n9', e_leave='$n8', validity='$m1', bal_leave='$bal' where empid ='$n1'";

if(!mysql_query($sql3,$con))
{
die ('Error in Insert  '.mysql_error());
}
if(!mysql_query($sql4,$con))
{
die ('Bugs in Inserting '.mysql_error());
}
else
echo "<b>User Updated</b>";
}
?>
</form>
</center>
