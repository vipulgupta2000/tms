
<?php
$a='';

echo "<li class=\"dropdown\">";
if($_SESSION['SESS_perm']=='admin')
echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Administration<b class=\"caret\"></b></a>";
echo "<ul class=\"dropdown-menu\">";

$sql="select tblid,name,alias from config";
if(!$result=mysql_query($sql))
{die(mysql_error());
}else
{
while($row = mysql_fetch_array($result))
{
if(($row['tblid']<15) && $_SESSION['SESS_perm']=='admin')
{
echo "<li><a class=\"menu_left\" href=\"home.php?page=".$row['name']."\">".$row['alias']."</a></li>";
}elseif($_SESSION['SESS_perm']=='admin')
$a = $a."<li><a class=\"menu_left\" href=\"home.php?page=".$row['name']."\">".$row['alias']."</a></li>";
}
}
$sql1="select tblid,name,alias,groupname from config c,access a where c.name=a.page_name";
if(!$result1=mysql_query($sql1))
{die(mysql_error());
}else
{
while($row1 = mysql_fetch_array($result1))
{
if(($row1['groupname']==$_SESSION['SESS_perm']))
$a = $a."<li><a class=\"menu_left\" href=\"home.php?page=".$row1['name']."\">".$row1['alias']."</a></li>";
}
}

echo "</ul></li>";

echo "<li class=\"dropdown\">";
echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Wiki<b class=\"caret\"></b></a>";
echo "<ul class=\"dropdown-menu\">";
echo "<ul class=\"nav nav-tabs nav-stacked\">";
echo $a;
echo "</ul>";
echo "</ul>";
echo "</li>";
?>

