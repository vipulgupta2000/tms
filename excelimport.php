<div id="middle_right_top">
<h2>Import Excel</h2>
</div>

<?php
$filename=isset($_FILES['userfile']['name'])?$_FILES['userfile']['name']:'';
//echo "<form enctype=\"multipart/form-data\" action=\"\" method=\"POST\">";
// <!-- MAX_FILE_SIZE must precede the file input field -->
  echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"70000\" />";
    //<!-- Name of input element determines name in $_FILES array -->
    echo "Send this file: <input name=\"userfile\" type=\"file\" />";
echo " <input name=\"load\" type=\"submit\" value=\"Show File\" />";
$tbl=isset($_POST['table'])?$_POST['table']:'';

 echo "TableName: <input id=\"tbl\" name=\"table\" type=\"text\" value=\"$tbl\" />";
//echo "</form>";
require_once '../phpoffice/excel/Classes/PHPExcel.php';
//echo "issettable".isset($_POST['table']);
//echo "issetkomaal".isset($_POST['komaal']);

if(isset($_POST['komaal']))
{
load_data($_POST['table']);
echo "Your file ".$filename." has been uploaded to table ".$tbl;
}
elseif($_FILES)
{  
echo $_FILES['userfile']['name'];
$uploaddir = '/Library/Webserver/Documents/uploads/';
$inputFileName = $uploaddir.$_FILES['userfile']['name'];
$inputTable=$_POST['table'];
//$uploadfile = $uploaddir .$_SESSION['SESS_empid'].time().basename($_FILES['userfile']['name']);
echo time();
echo '<pre>';
/*if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Possible file upload attack!\n";
}*/
 include('../phpoffice/readexcel.php');

}
/*else
{echo "No condition Match";
if(isset($_POST['table']))
{
echo "count:".$_POST['icnt']."field_edit:".$_POST['field_edit'];
insert_data($_POST['table']);
}
}
*/

echo  "<input name=\"komaal\" type=\"submit\" value=\"import\" />";
?>
<script>
$(document).ready(function(){
	$("input[name='komaal']").hide();
	if($("input[name='table']").val()!="")
	$("input[name='komaal']").show();
	if($("input[name='userfile']").val()!="")
	$("input[name='load']").hide();
//$(".submit").toggle();
});
$("#frm1").submit(function(){
if($("input[name='table']").val() =="")
{
alert("table name cannot be null");
return false;
}
});


</script>