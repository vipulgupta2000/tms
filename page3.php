<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$code=$_GET['QUAL'];
//echo $_GET['page'];

require_once("auth.php");
$usr=$_SESSION['SESS_ename'];
$qual=" task  like \"%".$code."%\" and user='$usr'";
$query="SELECT task FROM projecttask WHERE $qual and 1=1 ";
//$query="SELECT p_name FROM projecttable ";
//echo $query;
$result=mysql_query($query);
$i=0;
//echo "<select name=\"pro$i\"><option>Select Project</option>";
$a="<ul class=\"vakhri\" >";
while($row=mysql_fetch_array($result))
{
$b[]=$row['task'];
//echo "<option value=\"{$row[0]}\">{$row[0]}</option>";
$a=$a."<li onclick=\"setresult('$row[task]')\">";
$a=$a.$row['task'];
$a=$a."</li>"; 
}
//echo json_encode($b);
//echo $b;
echo $a;
echo "</ul>";
//return $a;
?>

