<?php
//Declaration Section

require_once('auth.php');
include('display.php');
include('addrow.php');
include('update.php');
include('utils.php');
include("events.php");
//include('rowaccess.php');
//include('sms_utils.php');
$tbl=$_GET['page'];
//include('testlib.php');
//DB SQLs

if(isset($_POST['delete']))
{
delete($tbl);
}
if(isset($_POST['update']) || isset($_POST['updates']))
{
update($tbl);
//update_single($tbl);
//echo "<p> Records Updated </p>";
}
if(isset($_POST['addrow']))
{
if($tbl=='field')
{
$sqli=alter();
echo $sqli;
if(!mysql_query($sqli))
	{
	die.mysql_error();
	}
}
if($tbl=='config')
{
$sqli=createtable();
echo $sqli;
if(!mysql_query($sqli))
	{
	die.mysql_error();
	}
  createid();
}
$sqli=insert($tbl);
//echo $sqli;
if(!mysql_query($sqli))
	{
	die.mysql_error();
	}
//echo "<p> records inserted </p>";
//Added newly

}
if(isset($_POST['create']))
{
$sqli=create($tbl);
echo $sqli;
if(!mysql_query($sqli))
	{
	die.mysql_error();
	}
}

if(isset($_POST['drop']))
{
$sqli="drop table $tbl";
echo $sqli;
if(!mysql_query($sqli))
	{
	die.mysql_error();
	}
}


include($_GET['page']);

//echo "<input id=\"btn\" type=\"submit\" name=\"addrow\" value=\"Add Row\">";
//echo "<input id=\"btn\" type=\"submit\" name=\"drop\" value=\"drop\">";

//if(!mysql_query("select * from ".$_GET['page']))
//{
//echo " Please click button to create table in the database";
//echo "<input id=\"btn\" type=\"submit\" name=\"create\" value=\"create\">";
//}
?>
