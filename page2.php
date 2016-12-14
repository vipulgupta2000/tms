<?php
$code=$_GET['projcode'];
require_once("auth.php");
//$query="SELECT p_name FROM projecttable WHERE c_code='$code' and status=\"On Going\" ";
$query="SELECT `task` FROM `projecttask` WHERE project='$code' and user='$_SESSION[SESS_empid]'";
//echo $query;
$result=mysql_query($query);
$i=0;
echo "<select name=\"task$i\"><option>Select Task</option>";

while($row=mysql_fetch_array($result))
{
echo "<option value=\"{$row[0]}\">{$row[0]}</option>";
}
?>
</select>
