<?php
$code=$_GET['chargecode'];
require_once("auth.php");
$query="SELECT p_name FROM projecttable WHERE c_code='$code' and status=\"On Going\" ";
$result=mysql_query($query);
$i=0;
echo "<select name=\"pro$i\"><option>Select Project</option>";

while($row=mysql_fetch_array($result))
{
echo "<option value=\"{$row[0]}\">{$row[0]}</option>";
}
?>
</select>
