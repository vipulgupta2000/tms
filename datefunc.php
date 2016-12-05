<?php

date_default_timezone_set('UTC');

echo "<br />";

// Prints something like: Monday

// echo "Today is ".date("l");

function friday()
{
//$j=-1;

if ( date("l")=="Monday" ){$j=4;}

if ( date("l")=="Tuesday" ){$j=3;}

if ( date("l")=="Wednesday" ){$j=2;}

if ( date("l")=="Thursday" ){$j=1;}

if ( date("l")=="Friday" ){$j=0;}

if ( date("l")=="Saturday" ){$j=6;}

if ( date("l")=="Sunday" ){$j=5;}

return date("Y-n-j", mktime(0, 0, 0, date("m"), date("d")+$j, date("Y")));

}
//echo "<br />Friday's Date is ".friday();
//echo "<br />";

function ddl()
{
 $result = mysql_query("SELECT p_name FROM projecttable ");
 while($row = mysql_fetch_row($result))
 {
 echo "<option value=\"{$row[0]}\">{$row[0]}</option>";
 }
}

function task()
{
 $result = mysql_query("SELECT task FROM tasktable ");
 while($row = mysql_fetch_row($result))
 {
 echo "<option value=\"{$row[0]}\">{$row[0]}</option>";
 }
}

function ccode()
{
 $result = mysql_query("SELECT c_code FROM chargecode ");
 while($row = mysql_fetch_row($result))
 {
 echo "<option value=\"{$row[0]}\">{$row[0]}</option>";
 }
}

function ccode2()
{
 $result=mysql_query("select DISTINCT c_code from projecttable");
 while($row=mysql_fetch_row($result))
 {
 echo "<option value=\"{$row[0]}\">{$row[0]}</option>";
 }
}

function eid()
{
 $result = mysql_query("SELECT empid FROM usertable");
 while($row = mysql_fetch_array($result))
 {
 echo "<option value=\"{$row[0]}\">{$row[0]}</option>";
 }
}

function ename()
{
 $result = mysql_query("SELECT empname FROM usertable where Status='active'");
 while($row=mysql_fetch_array($result))
 {
 echo "<option value=\"{$row[0]}\">{$row[0]}</option>";
 }
}

function ename1()
{
 $result = mysql_query("SELECT empname FROM usertable where mgrid='$_SESSION[SESS_empid]'");
 while($row=mysql_fetch_array($result))
 {
 echo "<option value=\"{$row[0]}\">{$row[0]}</option>";
 }
}
?>
