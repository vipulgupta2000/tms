<?php
#v0.1 Updated create() function . Added strtolower and str_replace function to ensure tables created have special chars removed from fields.

require_once("auth.php");

function addrow($tbl)
{
	$tg_top="<table width=auto border=1 cellpadding=2 cellspacing=2>";
	$tg_hdr="<th>";
	$tg_hdr_cl="</th>";
	$tg_ro="<tr>";
	$tg_ro_cl="</tr>";
	$tg_td="<td>";
	$tg_td_cl="</td>";
	$tg_top_cl="</table>";
	$tg_ip="<input";
	$tg_ip_type=" type=\"";
	$tg_ip_name="\" name=\"";
	$tg_ip_value="\" value=\"";
	$tg_ip_size="\" size=\"";
	$tg_ip_id="\" id=\"";
	$tg_class="\" class=\"ro";
	$tg_ip_cl="\" >";
	$tg_chk="<input type=\"checkbox\" name=\"chb";
	$tg_chk_val="";
	$tg_dat="<a href=\"javascript:NewCal('";
	$tg_dat_cl="','ddmmyyyy')\"><img src=datetimepick/cal.gif width=16 height=16 border=0 alt=Pick a date></a>";
	$tg_sel="<select id=\"";
	$tg_cl="\" >";
	$tg_sel_cl="</select>";
	$tg_opt="<option value=\"";
	$tg_opt_cl="</option>";

	//DB SQLs
	$sql="select tblid from config where name='$tbl'";
	$result=mysql_query($sql);
	$myvar=mysql_result($result,0);
	$sql1="select * from field where tblid=$myvar";
	$result1=mysql_query($sql1);
$fname="";
$fval="";
	$a="";
	$opt=array(1 => "k");
	$mode=1;
	$j=0;

	/*if(isset($_POST['sqli']))
	{
	echo $_POST['sqli'];
	if (!mysql_query($_POST['sqli']))
			{
			die('Error: ' . mysql_error());
			}
	}
	*/
	if(isset($_POST['fname']))
	{
	echo $fname;
	$array=array($_POST['fname']);
	print_r($array);
	}
//Open Table
		echo $tg_top;

//Print Header row
		$a= $tg_ro;
		//blank cell for checkbox
		//$a=$a.$tg_hdr.$tg_hdr_cl;
		while($row = mysql_fetch_array($result1))
		{
		if(!$row['dbindex']=='primary')
		$a=$a.$tg_hdr.$row['alias'].$tg_hdr_cl;
		}
		$a=$a.$tg_ro_cl;

//Print Data rows
		$cnt=0;
		{
		$j=1;

		$a=$a.$tg_ro;

		//Input for checkbox
		//$a=$a.$tg_td.$tg_chk.$cnt.$tg_chk_val;
		//$a=$a.$tg_ip_cl.$tg_td_cl;

		$result1=mysql_query($sql1);
		while($row = mysql_fetch_array($result1))
		{
		if($row['type']=="option")
				{
				$a=$a.$tg_td.$tg_sel.$row['name'].$cnt.$tg_ip_name.$row['name'].$cnt.$tg_cl;
				if($cnt==0)
				{
				$sql_opt="select * from field_option where tblid=".$row['tblid']." and fieldid=".$row['fieldid'];
                                $result_opt=mysql_query($sql_opt);
				$opt[$j]="";
				while($row_opt = mysql_fetch_array($result_opt))
					{
					$opt[$j]=$opt[$j].$tg_opt.$row_opt['value'].$tg_cl.$row_opt['alias'].$tg_opt_cl;
					}

				}

				$a=$a.$opt[$j].$tg_sel_cl.$tg_td_cl;
				$j++;
				}
				elseif($row['type']=="list")
					{
								$a=$a.$tg_td.$tg_sel.$row['name'].$cnt.$tg_ip_name.$row['name'].$cnt.$tg_cl;
											//adding new on13/12/2014.can be deleted
											$sql_filter="select source,filter,id,value,alias from valuelist where id in (select optid from field_option where tblid=".$row['tblid']." and fieldid=".$row['fieldid'].")";
											//echo $sql_filter;
											$result_filter=mysql_query($sql_filter);
											$vsource=mysql_result($result_filter,0,0);
											$vfilter=mysql_result($result_filter,0,1);
											$vid=mysql_result($result_filter,0,2);
											$vvalue=mysql_result($result_filter,0,3);
											$valias=mysql_result($result_filter,0,4);
											$vfilter=$vfilter==null?"":" where ".$vfilter;
											$sql_opt="select ".$vvalue." 'value',".$valias." 'alias' from ".$vsource.$vfilter;
											//echo $sql_opt;	
											//Completion of change
											$result_opt=mysql_query($sql_opt);
											$opt[$j]="";
											$alias='';
											if($result_opt)
											{
											while($row_opt = mysql_fetch_array($result_opt))
												{
												$opt[$j]=$opt[$j].$tg_opt.$row_opt['value'].$tg_cl.$row_opt['alias'].$tg_opt_cl;
												}
											}
										//}
										//below handles code if no value is set and also instead of value shows alias
									
										//introducing for clear value option
										$a=$a.$tg_opt."".$tg_cl."--clear--".$tg_opt_cl;
										$a=$a.$opt[$j].$tg_sel_cl.$tg_td_cl;
					$j++;
					}
				elseif(!$row['dbindex']=='primary')
				{
				$a=$a.$tg_td.$tg_ip.$tg_ip_type.$row['type'].$tg_ip_name.$row['name'].$cnt.$tg_ip_size.$row['size'].$tg_ip_value;
					if($row['type']=="idate")
					{
					$a=$a.$tg_ip_id.$row['name'].$cnt.$tg_class;
					$a=$a.$tg_ip_cl.$tg_dat.$row['name'].$cnt.$tg_dat_cl.$tg_td_cl;
					}
					else {
					$a=$a.$tg_ip_cl.$tg_td_cl;
					}
				}
		}
				//Store variables for insert query
				if(!$row['dbindex']=='primary')
							{$fname=$fname.$row['name'].",";
							if($row['type']=='idate')
							$fval=$fval."'\"".setmydate($_POST[$row['name']])."\"',";
							else
							$fval=$fval."'\".$"."_"."POST['".$row['name']."'].\"',";
					}
		$cnt++;
		$a=$a.$tg_ro_cl."\n";
		}
//Close Table
		echo $a.$tg_top_cl;

$fname=chop($fname,",");
$fval=chop($fval,",");
$sqli = "INSERT INTO ".$tbl." ( ".$fname." ) VALUES (".$fval.")";
//echo $sqli;
//$sqla= "Alter table 
echo "<input class=\"btn btn-primary\" id=\"btn\" type=\"submit\" name=\"addrow\" value=\"Add Row\">";
//echo "<input class=\"btn btn-warning\" id=\"btn\" type=\"submit\" name=\"modify\" value=\"modify\">";
return $sqli;
}

function insert($tbl)
{
$sql1=dbsql($tbl);
$result1=mysql_query($sql1);
$fname="";	$fval="";	$i=0;
	while($row = mysql_fetch_array($result1))
	{
		if(!$row['dbindex']=='primary')
		{
		$fname=$fname.$row['name'].",";
		if($row['type']=='idate')
		$fval=$fval."".setmydate($_POST[$row['name'].$i]).",";
		elseif($row['type']=='password')
		$fval=$fval."'".sha1($_POST[$row['name'].$i])."',";
		else
		{$fval=$fval."'".$_POST[$row['name'].$i]."',";
		//echo "fval is".$row['name'];
		}
		}
	}
$fname=chop($fname,",");
$fval=chop($fval,",");
$sqli="INSERT INTO ".$tbl." ( ".$fname." ) VALUES (".$fval.")";
//echo $sqli;
return $sqli;
}

function alter($i=0,$action='ADD')
{
//$tbl=$_POST['tblid0'];
$sql1="select name from config where tblid=".$_POST['tblid'.$i];
$result=mysql_query($sql1);
$tbl=mysql_result($result,0);
$sqli="ALTER TABLE ".$tbl." ".$action." ".$_POST['name'.$i];
if($action=='ADD' || $action=='MODIFY')
{
    $sqli=$sqli." ".$_POST['dbtype'.$i]."(".$_POST['size'.$i].")";
    if($_POST['dbindex'.$i]=='primary' && $action=='ADD')
    $sqli=$sqli." NOT NULL AUTO_INCREMENT FIRST,ADD PRIMARY KEY "."(".$_POST['name'.$i].")";
}
//echo $sqli;
return $sqli;
}

function insert_data($tbl)
{
$sql=dbsql($tbl);

$fname="";	$fval="";	$i=0;
$cnt=$_POST['icnt'];
$field_list=explode(",",$_POST['field_edit']);
while($i<$cnt)
{
	
	$result1=mysql_query($sql);
	while($row = mysql_fetch_array($result1))
	{
		if(!$row['dbindex']=='primary' && in_array($row['name'], $field_list))
		{
		$fname=$fname.$row['name'].",";
		if($row['type']=='idate')
		$fval=$fval."".setmydate($_POST[$row['name'].$i]).",";
		elseif($row['type']=='password')
		$fval=$fval."'".sha1($_POST[$row['name'].$i])."',";
		else
		{$fval=$fval."'".$_POST[$row['name'].$i]."',";
		//echo "fval is".$row['name'];
		}
		}
	}
$fname=chop($fname,",");
$fval=chop($fval,",");
$sqli="INSERT INTO ".$tbl." ( ".$fname." ) VALUES (".$fval.")";
echo $sqli;
$fname="";	$fval="";
if(!mysql_query($sqli))
	{
		die.mysql_error();
	}
$i++;
}
}

//function created to load data form excel import. It will modify date etc.
function load_data($tbl)
{
$sql=dbsql($tbl);
if (get_magic_quotes_gpc()) $_POST = array_map('stripslashes', $_POST);
$fname="";	$fval="";	$i=0;
$cnt=$_POST['icnt'];
$field_list=explode(",",$_POST['field_edit']);
while($i<$cnt)
{
	
	$result1=mysql_query($sql);
	while($row = mysql_fetch_array($result1))
	{
		if(!$row['dbindex']=='primary' && in_array($row['name'], $field_list))
		{
		$fname=$fname.$row['name'].",";
		if($row['type']=='idate')
		$fval=$fval."".setmydate($_POST[$row['name'].$i]).",";
		elseif($row['type']=='password')
		$fval=$fval."'".sha1($_POST[$row['name'].$i])."',";
		else
		{$fval=$fval."'".$_POST[$row['name'].$i]."',";
		//echo "fval is".$row['name'];
		}
		}
	}
$fname=chop($fname,",");
$fval=chop($fval,",");
$sqli="INSERT INTO ".$tbl." ( ".$fname." ) VALUES (".$fval.")";
echo $sqli;
$fname="";	$fval="";
if(!mysql_query($sqli))
	{
		die.mysql_error();
	}
$i++;
}
}

function create($tbl)
{
$sql1=dbsql($tbl);
$result1=mysql_query($sql1);
$fname="";	$fval="";	$i=0;
$special=array(".",",",")","("," ","  ","   ","/");
	while($row = mysql_fetch_array($result1))
	{
		if('primary' == $row['dbindex'])
		{
		$fname=$fname.strtolower(str_replace($special,"",$row['name']))." ".$row['dbtype']."(".$row['size'].") NOT NULL AUTO_INCREMENT PRIMARY KEY,";
		}else
		{$fname=$fname.strtolower(str_replace($special,"",$row['name']))." ".$row['dbtype']."(".$row['size']."),";}
	}
$fname=chop($fname,",");
$fval=chop($fval,",");
if(!mysql_query("select 1 from $tbl"))
$sqli="CREATE Table ".$tbl." ( ".$fname." ) ";
//else
//$sqli="ALTER table ".$tbl." add ( ".$fname." ) ";
return $sqli;
}

function update($tbl)
{
$sqlu=dbsql($tbl);
$fname="";	$fval="";	$i=0;
//$data_sql="select * from ".$tbl;
//$result_data=mysql_query($data_sql);
$cnt=$_POST['icnt'];
$field_list=explode(",",$_POST['field_edit']);

while($i<$cnt)
{

if(isset($_POST['chb'.$i]))
{
if($tbl=='load_master'){
	$sdat=$_POST['sdate'.$i];

$edat=$_POST['edate'.$i];
$first_date=date("01-m-Y", strtotime($sdat)); // hard-coded '01' for first day
$last_date=date("d-m-Y", strtotime($edat));
if($sdat!=$first_date){
echo "<script>alert('Please make sure the Start date should be starting of the month ')</script>";
}
elseif($edat!=$last_date){
echo "<script>alert('Please make sure the End date should be End of the month ');</script>";
}
elseif($sdat==$edat){
echo "<script>alert('Please make sure that start and End date are not same')</script>";
}
else{
$val=$_POST['id'.$i];
$updateStatus =mysql_query("update load_master  set status='Validated' where id='$val'");

}}
	$result1=mysql_query($sqlu);
	while($row = mysql_fetch_array($result1))
	{
		if($row['dbindex']=="primary" ||in_array($row['name'], $field_list))
		{if($row['dbindex']=='primary')
		{
		$fval=$fval.$row['name']."=";
			if($row['dbtype']=='int')
			{
			$fval=$fval.$_POST[$row['name'].$i].",";
			}else
			{
			$fval=$fval."'".$_POST[$row['name'].$i]."',";
			}
		}
		else{
		$fname=$fname.$row['name']."=";
		if($row['type']=="idate")
		{
		$fname=$fname."'".setmydate($_POST[$row['name'].$i])."',";
		}elseif($row['type']=='password')
		{$fname=$fname."'".sha1($_POST[$row['name'].$i])."',";}
		else{
		$fname=$fname."'".mysql_real_escape_string(($_POST[$row['name'].$i]))."',";
		}

		}
		}
	}
//adding new below row for admin operations
/*if($tbl=='field')
{
$sqli=alter($i,'DROP');
echo $sqli;
if(!mysql_query($sqli))
	{
	die.mysql_error();
	}
$sqli=alter($i,'ADD');
echo $sqli;
if(!mysql_query($sqli))
	{
	die.mysql_error();
	}	
}
*/
$fname=chop($fname,",");
$fval=chop($fval,",");
$sqli="UPDATE ".$tbl." set ".$fname." Where ".$fval;
//echo $sqli."<br/>";

// This code will only run when the page name is Bank otherwise not
if($_GET['page'] == 'bank'){
if($fname == "status='Loaded'"){}
elseif($fname == "status='Reconcile'"){	
	$sql_get = mysql_query("select * from bank where ".$fval);
	while($row = mysql_fetch_array($sql_get))
	{
		$bdate = $row['date'];
		$bdesc = $row['description'];		
		$bamt = $row['amt'];
	}	
	$date = date_create();
		//echo date_format($date, 'U = Y-m-d H:i:s')."<br>";
		
		date_timestamp_set($date, $bdate);
		$month =  date_format($date, 'n');
		$year =  date_format($date, 'Y');
	$sql_acc_insert = mysql_query("insert into accounts (date,entry_from,name,dr,cr,month,year) values ('$bdate','Bank','$bdesc',0,'$bamt','$month',$year)");	
}
}

// This code will only run when the Validated Button is clicked otherwise not
if(isset($_POST['validate']))
{$my_table =$_GET['page'];
if($my_table == "loaded_payroll"){$sqli="UPDATE ".$tbl." set status = 'Validated' Where ".$fval;}}

$fname="";	$fval="";
if(isset($sqli) && !mysql_query($sqli))
	{
	die.mysql_error();
	}
}
$i++;
}

}

function delete($tbl)
{
$sqlu=dbsql($tbl);
$fname="";	$fval="";	$i=0;
//$data_sql="select * from ".$tbl;
//$result_data=mysql_query($data_sql);
$cnt=$_POST['icnt'];
$field_list=explode(",",$_POST['field_edit']);

while($i<$cnt)
{

if(isset($_POST['chb'.$i]))
{
	$result1=mysql_query($sqlu);
	while($row = mysql_fetch_array($result1))
	{
		if($row['dbindex']=="primary" ||in_array($row['name'], $field_list))
		{echo $row['name'];if($row['dbindex']=='primary')
		{
		$fval=$fval.$row['name']."=";
			if($row['dbtype']=='int')
			{
			$fval=$fval.$_POST[$row['name'].$i].",";
			}else
			{
			$fval=$fval."'".$_POST[$row['name'].$i]."',";
			}
		}
		else{
		$fname=$fname.$row['name']."=";
		if($row['type']=="idate")
		{
		$fname=$fname."'".setmydate($_POST[$row['name'].$i])."',";
		}else{
		$fname=$fname."'".$_POST[$row['name'].$i]."',";
		}

		}
		}
	}


$fname=chop($fname,",");
echo $fname;
//adding new below row for admin operations
if($tbl=='field')
{
$sqli=alter($i,'DROP');
echo $sqli;
if(!mysql_query($sqli))
	{
	die.mysql_error();
	}
}
$fval=chop($fval,",");
$sqli="DELETE from ".$tbl." Where ".$fval;
echo $sqli."<br/>";
$fname="";	$fval="";
if(isset($sqli) && !mysql_query($sqli))
	{
	die.mysql_error();
	}
}
$i++;
}
}

function update_single($tbl)
{
$sqlu=dbsql($tbl);
$fname="";	$fval="";	$i=0;
//$data_sql="select * from ".$tbl;
//$result_data=mysql_query($data_sql);
$cnt=$_POST['icnt'];
$field_list=explode(",",$_POST['field_edit']);
//echo "count is $cnt";
while($i<$cnt)
{
//echo "caught the issue";
//if(isset($_POST['chb'.$i]))
//{
	$result1=mysql_query($sqlu);
	while($row = mysql_fetch_array($result1))
	{
		if($row['dbindex']=="primary" ||in_array($row['name'], $field_list))
		{if($row['dbindex']=='primary')
		{
		$fval=$fval.$row['name']."=";
			if($row['dbtype']=='int')
			{
			$fval=$fval.$_POST[$row['name'].$i].",";
			}else
			{
			$fval=$fval."'".$_POST[$row['name'].$i]."',";
			}
		}
		else{
		$fname=$fname.$row['name']."=";
		if($row['type']=="idate")
		{
		$fname=$fname."'".setmydate($_POST[$row['name'].$i])."',";
		}elseif($row['type']=='password')
		{$fname=$fname."'".sha1($_POST[$row['name'].$i])."',";}
		else{
		$fname=$fname."'".mysql_real_escape_string(($_POST[$row['name'].$i]))."',";
		}

		}
		}
	}
//adding new below row for admin operations

if($tbl=='field')
{
/*$sqli=alter($i,'DROP');
echo $sqli;
if(!mysql_query($sqli))
	{
	die.mysql_error();
	}
*/
        $sqli=alter($i,'MODIFY');
//echo $sqli;
if(!mysql_query($sqli))
	{
	die.mysql_error();
	}	
}

$fname=chop($fname,",");
$fval=chop($fval,",");
$sqli="UPDATE ".$tbl." set ".$fname." Where ".$fval;
//echo $sqli."<br/>";
$fname="";	$fval="";
if(isset($sqli) && !mysql_query($sqli))
	{
	die.mysql_error();
	}
//}
$i++;
}

}

function createtable()
{
    $sql_create="CREATE TABLE ".$_POST['name0']."( `id` INT(9) NOT NULL AUTO_INCREMENT , PRIMARY KEY (`id`)) ENGINE = InnoDB";
   return $sql_create;
}

function createid()
{
    $sql="select max(tblid)+1 from config";
    if($resultid=mysql_query($sql))
        {$rid=mysql_result($resultid,0);}
        else{die.mysql_error();}
   $sqli="INSERT INTO `field` (`tblid`, `name`, `alias`, `type`, `dbtype`, `dbindex`, `size`, `col`, `ord`, `span`) VALUES (".$rid.", 'id', 'ID', 'text', 'int', 'primary', '9', '0', '0', '0')";     
if(!mysql_query($sqli))
	{
	die.mysql_error();
	}
}
?>
