<?php
function dbsql($tbl)
{
$sql="select tblid from config where name='$tbl'";
$result=mysql_query($sql);
$myvar=mysql_result($result,0);
$sql1="select * from field where tblid=$myvar";
//$result1=mysql_query($sql1);
return $sql1;
}

function display($tbl,$qual,$md,$arr)
{

	$sql1=dbsql($tbl);
	$tg_top="<div class=\"table-responsive\"><table class=\"table table-hover table-striped\" id=\"".$tbl."\" width=auto border=1 cellpadding=2 cellspacing=2>";
	$tg_hdr="<th>";
	$tg_hdr_cl="</th>";
	$tg_ro="<tr>";
	$tg_ro_cl="</tr>";
	$tg_td="<td>";
	$tg_td_cl="</td>";
	$tg_top_cl="</table></div>";
	$tg_ip="<input";
	$tg_ip_type=" type=\"";
	$tg_ip_name="\" name=\"";
	$tg_ip_value="\" value=\"";
	$tg_ip_size="\" size=\"";
	$tg_ip_id="\" id=\"";
	$tg_class="\" class=\"ro";
	$tg_ip_cl="\" />";
	$tg_chk="<input type=\"checkbox\" name=\"chb";
	$tg_chk_val="";
	$tg_dat="<a href=\"javascript:NewCal('";
	$tg_dat_cl="','yyyymmdd')\"><img src=datetimepick/cal.gif width=16 height=16 border=0 alt=Pick a date></a>";
	$tg_sel="<select name=\"";
	$tg_cl="\" >";
	$tg_sel_cl="</select>";
	$tg_opt="<option value=\"";
	$tg_opt_cl="</option>";
	$tg_hidden="hidden";
	$tg_readonly="\" readonly ";
	$tg_text="<textarea rows=\"4\" cols=\"15\" ";
	$tg_text_cl="</textarea>";

	$data_sql="select * from ".$tbl;

	if(isset($qual))
	{
	$qual=" where ".$qual;
	$data_sql=$data_sql.$qual;
	}
	//only get pages if this is main table
	if($_GET['page']==$tbl)
	$data_sql=getPagesql($data_sql,7);
	$result1=mysql_query($sql1);
//mode 0 is columnar and mode 1 for row-wise printing
	$a="";
	$opt=array(1 => "k");
	$mode=1;
	$j=0;

	$mode=$md;

	if($mode==0)
	{
	//Open Table
	$a=$tg_top;
	//Print Header column

		while($row = mysql_fetch_array($result1))
		{
		$a=$a.$tg_ro;
		$a=$a.$tg_hdr.$row['alias'].$tg_hdr_cl;

	//Print data columns

		$result_data=mysql_query($data_sql);
		while($datarow=mysql_fetch_array($result_data))
		{
		if($row['type']=="date")
		{
		$a=$a.$tg_td.getmydate($datarow[$row['name']]).$tg_td_cl;
		}elseif($row['type']=="password"){
		$a=$a.$tg_td.$tg_td_cl;
		}
		else
		{
		$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		}
		}

		$a=$a.$tg_ro_cl;
		}
	//Close Table
		$a=$a.$tg_top_cl;
	}
	if($mode==1)
	{
//Open Table

		$a= $tg_top;

//Print Header row
		$a=$a.$tg_ro;
		while($row = mysql_fetch_array($result1))
		{
		if((empty($arr) || in_array($row['name'],$arr)) )
		$a=$a.$tg_hdr.$row['alias'].$tg_hdr_cl;
		}

		$a=$a.$tg_ro_cl;

		//Print Data rows
		$result_data=mysql_query($data_sql);
		while($datarow=mysql_fetch_array($result_data))
		{
		$a=$a.$tg_ro;
		$result1=mysql_query($sql1);
		
		while($row = mysql_fetch_array($result1))
		{
		if(empty($arr) || in_array($row['name'],$arr))
			{
		if($row['type']=="date")
		$a=$a.$tg_td.getmydate($datarow[$row['name']]).$tg_td_cl;
		//$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		elseif($row['type']=="password"){
		$a=$a.$tg_td.$tg_td_cl;
		}elseif($row['dbindex']=="primary" ){
		$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		$a=$a.$tg_ip.$tg_ip_type.$tg_hidden.$tg_ip_name.$row['name'].$tg_ip_size.$row['size'].$tg_ip_value;
		$a=$a.$datarow[$row['name']].$tg_ip_cl;
		}else
		$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;	
		}elseif($row['dbindex']=="primary" && !in_array($row['name'],$arr))
		{
		$a=$a.$tg_ip.$tg_ip_type.$tg_hidden.$tg_ip_name.$row['name'].$tg_ip_size.$row['size'].$tg_ip_value;
		$a=$a.$datarow[$row['name']].$tg_ip_cl;
		}
		//echo $a;
		//close while loop
		}
		
		$a=$a.$tg_ro_cl;

		}
//Close Table
		
		$a=$a.$tg_top_cl;
	}

	$a=$a."<input class=\"btn btn-warning\" id=\"btn\" type=\"submit\" name=\"modify\" value=\"modify\">";
	return $a;
}

function display_total($tbl,$qual,$md,$arr)
{

	$sql1=dbsql($tbl);
	$tg_top="<div class=\"table-responsive\"><table class=\"table table-hover table-striped\" id=\"".$tbl."\" width=auto border=1 cellpadding=2 cellspacing=2>";
	$tg_hdr="<th>";
	$tg_hdr_cl="</th>";
	$tg_ro="<tr>";
	$tg_ro_cl="</tr>";
	$tg_td="<td>";
	$tg_td_cl="</td>";
	$tg_top_cl="</table></div>";
	$tg_ip="<input";
	$tg_ip_type=" type=\"";
	$tg_ip_name="\" name=\"";
	$tg_ip_value="\" value=\"";
	$tg_ip_size="\" size=\"";
	$tg_ip_id="\" id=\"";
	$tg_class="\" class=\"ro";
	$tg_ip_cl="\" />";
	$tg_chk="<input type=\"checkbox\" name=\"chb";
	$tg_chk_val="";
	$tg_dat="<a href=\"javascript:NewCal('";
	$tg_dat_cl="','yyyymmdd')\"><img src=datetimepick/cal.gif width=16 height=16 border=0 alt=Pick a date></a>";
	$tg_sel="<select name=\"";
	$tg_cl="\" >";
	$tg_sel_cl="</select>";
	$tg_opt="<option value=\"";
	$tg_opt_cl="</option>";
	$tg_hidden="hidden";
	$tg_readonly="\" readonly ";
	$tg_text="<textarea rows=\"4\" cols=\"15\" ";
	$tg_text_cl="</textarea>";

	$data_sql="select * from ".$tbl;

	if(isset($qual))
	{
	$qual=" where ".$qual;
	$data_sql=$data_sql.$qual;
	}
	//only get pages if this is main table
	if($_GET['page']==$tbl)
	$data_sql=getPagesql($data_sql,7);
	$result1=mysql_query($sql1);
//mode 0 is columnar and mode 1 for row-wise printing
	$a="";
	$opt=array(1 => "k");
	$mode=1;
	$j=0;

	$mode=$md;

	if($mode==0)
	{
	//Open Table
	$a=$tg_top;
	//Print Header column

		while($row = mysql_fetch_array($result1))
		{
		$a=$a.$tg_ro;
		$a=$a.$tg_hdr.$row['alias'].$tg_hdr_cl;

	//Print data columns

		$result_data=mysql_query($data_sql);
		while($datarow=mysql_fetch_array($result_data))
		{
		if($row['type']=="date")
		{
		$a=$a.$tg_td.getmydate($datarow[$row['name']]).$tg_td_cl;
		}elseif($row['type']=="password"){
		$a=$a.$tg_td.$tg_td_cl;
		}
		else
		{
		$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		}
		}

		$a=$a.$tg_ro_cl;
		}
	//Close Table
		$a=$a.$tg_top_cl;
	}
	if($mode==1)
	{
//Open Table

		$a= $tg_top;

//Print Header row
		$a=$a.$tg_ro;
		while($row = mysql_fetch_array($result1))
		{
		if((empty($arr) || in_array($row['name'],$arr)) )
		$a=$a.$tg_hdr.$row['alias'].$tg_hdr_cl;
		}
		//add timetable total column
		$a=$a.$tg_hdr."Total".$tg_hdr_cl;
		$a=$a.$tg_ro_cl;

		//define timetable specific variables to store values
		$tot=0;	$tsaturday =0;$tsunday   =0;$tmonday   =0;	$ttuesday  =0;		$twednesday=0;		$tthursday =0;		$tfriday   =0;
		
		//Print Data rows
		$result_data=mysql_query($data_sql);
		while($datarow=mysql_fetch_array($result_data))
		{
		$a=$a.$tg_ro;
		$result1=mysql_query($sql1);
		
		// To Calculate the Total of a row in a timetable.
		//$sumrow=$datarow['saturday']+$datarow['sunday']+$datarow['monday']+$datarow['tuesday']+$datarow['wednesday']+$datarow['thursday']+$datarow['friday'];
		//$tot=$tot+$sumrow;

		// To Calculate the Total of Column in a timetable.
		$tsaturday  = $tsaturday  +$datarow['saturday'];
		$tsunday    = $tsunday    +$datarow['sunday'];
		$tmonday    = $tmonday    +$datarow['monday'];
		$ttuesday   = $ttuesday   +$datarow['tuesday'];
		$twednesday = $twednesday +$datarow['wednesday'];
		$tthursday  = $tthursday  +$datarow['thursday'];
		$tfriday    = $tfriday    +$datarow['friday'];
		// Get Column Names from field table for each data row
		while($row = mysql_fetch_array($result1))
		{
		if(empty($arr) || in_array($row['name'],$arr))
			{
		if($row['type']=="date")
		$a=$a.$tg_td.getmydate($datarow[$row['name']]).$tg_td_cl;
		//$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		elseif($row['type']=="password"){
		$a=$a.$tg_td.$tg_td_cl;
		}elseif($row['dbindex']=="primary" ){
		$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		$a=$a.$tg_ip.$tg_ip_type.$tg_hidden.$tg_ip_name.$row['name'].$tg_ip_size.$row['size'].$tg_ip_value;
		$a=$a.$datarow[$row['name']].$tg_ip_cl;
		}elseif($row['type']=="int")
                {
                  $a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl; 
                  $sumrow=$sumrow+$datarow[$row['name']];
                }
                else
		$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;	
		}elseif($row['dbindex']=="primary" && !in_array($row['name'],$arr))
		{
		$a=$a.$tg_ip.$tg_ip_type.$tg_hidden.$tg_ip_name.$row['name'].$tg_ip_size.$row['size'].$tg_ip_value;
		$a=$a.$datarow[$row['name']].$tg_ip_cl;
		}
		//echo $a;
		//close while loop
		}
		//adding below row for total column in timetable
                if($tot==1)
		$a=$a.$tg_td.$sumrow.$tg_td_cl;
		
		$a=$a.$tg_ro_cl;

		}
//Close Table
		//total row in the last;
		$z="<tr class=\"success\"> <td colspan=\"3\" class=\"tot\">Total</td> <td class=\"tot\">$tsaturday</td> <td class=\"tot\">$tsunday</td> <td class=\"tot\">$tmonday </td> <td class=\"tot\">$ttuesday</td> <td class=\"tot\">$twednesday</td> <td class=\"tot\">$tthursday</td> <td class=\"tot\">$tfriday </td> <td class=\"warning\"> $tot</td> </tr>";$tot=$tot+$sumrow;
		$a=$a.$z;
		$a=$a.$tg_top_cl;
	}

	$a=$a."<input class=\"btn btn-warning\" id=\"btn\" type=\"submit\" name=\"modify\" value=\"modify\">";
	return $a;
}

function display_link($tbl,$qual,$md,$arr,$link)
{

	$sql1=dbsql($tbl);
	$tg_top="<div class=\"table-responsive\"><table class=\"table table-hover\" id=\"".$tbl."\" width=auto >";
		$tg_hdr="<th>";
		$tg_hdr_cl="</th>";
		$tg_ro="<tr class=\"clickableRow\" href=\"".$link."constant\">";
		$tg_ro_cl="</tr>";
		$tg_td="<td>";
		$tg_td_cl="</td>";
	$tg_top_cl="</table></div>";

	//$tg_top="<div><ul class=\"nav nav-tabs nav-stacked\" id=\"".$tbl."\" >";
	$tg_hdr="<th>";
	$tg_hdr_cl="</th>";
	$tg_al="<a href=\"#\" onclick=\"openUser(";
	$tg_alo=");\" >";
	$tg_alc="</a>";
	//echo "<a href=\"#\" onclick=\"openUser(".$_SESSION['SESS_empid'].");\" >;
	//$tg_ro="<tr href=\"#\" onclick=\"openUser(".$_SESSION['SESS_empid'].");\">";
	//$tg_ro_cl="</tr>";
	//$tg_td="<li><a href=\"".$link."constant\">";
	//$tg_td_cl="</a></li>";
	//$tg_top_cl="</ul></div>";
	$tg_ip="<input";
	$tg_ip_type=" type=\"";
	$tg_ip_name="\" name=\"";
	$tg_ip_value="\" value=\"";
	$tg_ip_size="\" size=\"";
	$tg_ip_id="\" id=\"";
	$tg_class="\" class=\"ro";
	$tg_ip_cl="\" />";
	$tg_chk="<input type=\"checkbox\" name=\"chb";
	$tg_chk_val="";
	$tg_dat="<a href=\"javascript:NewCal('";
	$tg_dat_cl="','yyyymmdd')\"><img src=datetimepick/cal.gif width=16 height=16 border=0 alt=Pick a date></a>";
	$tg_sel="<select name=\"";
	$tg_cl="\" >";
	$tg_sel_cl="</select>";
	$tg_opt="<option value=\"";
	$tg_opt_cl="</option>";
	$tg_hidden="hidden";
	$tg_readonly="\" readonly ";
	$tg_text="<textarea rows=\"4\" cols=\"15\" ";
	$tg_text_cl="</textarea>";

	$data_sql="select * from ".$tbl;

	if(isset($qual))
	{
	$qual=" where ".$qual;
	$data_sql=$data_sql.$qual;
	}
	//only get pages if this is main table
	//if($_GET['page']==$tbl)
	$data_sql=getPagesql($data_sql,7);
	//echo $data_sql;
$result1=mysql_query($sql1);
//mode 0 is columnar and mode 1 for row-wise printing
	$a="";
	$opt=array(1 => "k");
	$mode=1;
	$j=0;

	$mode=$md;

	if($mode==0)
	{
	//Open Table
	$a=$tg_top;
	//Print Header column

		while($row = mysql_fetch_array($result1))
		{
		$a=$a.$tg_ro;
		$a=$a.$tg_hdr.$row['alias'].$tg_hdr_cl;

	//Print data columns

		$result_data=mysql_query($data_sql);
		while($datarow=mysql_fetch_array($result_data))
		{
		if($row['type']=="date")
		{
		$a=$a.$tg_td.getmydate($datarow[$row['name']]).$tg_td_cl;
		}elseif($row['type']=="password"){
		$a=$a.$tg_td.$tg_td_cl;
		}
		else
		{
		$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		}
		}

		$a=$a.$tg_ro_cl;
		}
	//Close Table
		$a=$a.$tg_top_cl;
	}
	if($mode==1)
	{
//Open Table
		$a= $tg_top;

//Print Header row
		$a=$a."<tr>";
		while($row = mysql_fetch_array($result1))
		{
		if((empty($arr) || in_array($row['name'],$arr)) )
		$a=$a.$tg_hdr.$row['alias'].$tg_hdr_cl;
		}
		$a=$a."</tr>";

//Print Data rows
		$result_data=mysql_query($data_sql);
		while($datarow=mysql_fetch_array($result_data))
		{
		$a=$a.$tg_ro;
		$result1=mysql_query($sql1);
		while($row = mysql_fetch_array($result1))
		{
		if(empty($arr) || in_array($row['name'],$arr))
		{
		if($row['type']=="date")
		$a=$a.$tg_td.getmydate($datarow[$row['name']]).$tg_td_cl;
		//$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		elseif($row['type']=="password"){
		$a=$a.$tg_td.$tg_td_cl;
		}elseif($row['dbindex']=="primary" ){
		$a=str_replace('constant',$datarow[$row['name']],$a);
		$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		$a=$a.$tg_ip.$tg_ip_type.$tg_hidden.$tg_ip_name.$row['name'].$tg_ip_size.$row['size'].$tg_ip_value;
		$a=$a.$datarow[$row['name']].$tg_ip_cl;
		}else
		$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		}elseif($row['dbindex']=="primary" && !in_array($row['name'],$arr))
		{
		$a=str_replace('constant',$datarow[$row['name']],$a);
		$a=$a.$tg_ip.$tg_ip_type.$tg_hidden.$tg_ip_name.$row['name'].$tg_ip_size.$row['size'].$tg_ip_value;
		$a=$a.$datarow[$row['name']].$tg_ip_cl;
		}
		//echo $a;
		//close while loop
		}

		$a=$a.$tg_ro_cl;
		}
//Close Table
		$a=$a.$tg_top_cl;
	}
	return $a;
}

function display_array($tbl,$qual,$md,$arr)
{

	$sql1=dbsql($tbl);
	$tg_top="<div class=\"table-responsive\"><table class=\"table hover table-striped\" id=\"".$tbl."\" width=auto border=1 cellpadding=2 cellspacing=2>";
	$tg_hdr="<th>";
	$tg_hdr_cl="</th>";
	$tg_ro="<tr>";
	$tg_ro_cl="</tr>";
	$tg_td="<td>";
	$tg_td_cl="</td>";
	$tg_top_cl="</table></div>";
	$tg_ip="<input";
	$tg_ip_type=" type=\"";
	$tg_ip_name="\" name=\"";
	$tg_ip_value="\" value=\"";
	$tg_ip_size="\" size=\"";
	$tg_ip_id="\" id=\"";
	$tg_class="\" class=\"ro";
	$tg_ip_cl="\" />";
	$tg_chk="<input type=\"checkbox\" name=\"chb";
	$tg_chk_val="";
	$tg_dat="<a href=\"javascript:NewCal('";
	$tg_dat_cl="','yyyymmdd')\"><img src=datetimepick/cal.gif width=16 height=16 border=0 alt=Pick a date></a>";
	$tg_sel="<select name=\"";
	$tg_cl="\" >";
	$tg_sel_cl="</select>";
	$tg_opt="<option value=\"";
	$tg_opt_cl="</option>";
	$tg_hidden="hidden";
	$tg_readonly="\" readonly ";
	$tg_text="<textarea rows=\"4\" cols=\"15\" ";
	$tg_text_cl="</textarea>";

	$data_sql="select * from ".$tbl;

	if(isset($qual))
	{
	$qual=" where ".$qual;
	$data_sql=$data_sql.$qual;
	}
	//only get pages if this is main table
	if($_GET['page']==$tbl)
	$data_sql=getPagesql($data_sql,7);
	$result1=mysql_query($sql1);
//mode 0 is columnar and mode 1 for row-wise printing
	$a="";
	$opt=array(1 => "k");
	$mode=1;
	$j=0;

	$mode=$md;

	if($mode==0)
	{
	//Open Table
	$a=$tg_top;
	//Print Header column

		while($row = mysql_fetch_array($result1))
		{
		$a=$a.$tg_ro;
		$a=$a.$tg_hdr.$row['alias'].$tg_hdr_cl;

	//Print data columns

		$result_data=mysql_query($data_sql);
		while($datarow=mysql_fetch_array($result_data))
		{
		if($row['type']=="date")
		{
		$a=$a.$tg_td.getmydate($datarow[$row['name']]).$tg_td_cl;
		}elseif($row['type']=="password"){
		$a=$a.$tg_td.$tg_td_cl;
		}
		else
		{
		$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		}
		}

		$a=$a.$tg_ro_cl;
		}
	//Close Table
		$a=$a.$tg_top_cl;
	}
	if($mode==1)
	{
//Open Table

		$a= $tg_top;

//Print Header row
		$a=$a.$tg_ro;
		while($row = mysql_fetch_array($result1))
		{
		if((empty($arr) || in_array($row['name'],$arr)) )
		$a=$a.$tg_hdr.$row['alias'].$tg_hdr_cl;
		}
		$a=$a.$tg_ro_cl;


//Print Data rows
		$result_data=mysql_query($data_sql);
		while($datarow=mysql_fetch_array($result_data))
		{
		$a=$a.$tg_ro;
		$result1=mysql_query($sql1);
		while($row = mysql_fetch_array($result1))
		{
		if(empty($arr) || in_array($row['name'],$arr))
		{
		if($row['type']=="date")
		$a=$a.$tg_td.getmydate($datarow[$row['name']]).$tg_td_cl;
		//$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		elseif($row['type']=="password"){
		$a=$a.$tg_td.$tg_td_cl;
		}elseif($row['dbindex']=="primary" ){
		$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		$a=$a.$tg_ip.$tg_ip_type.$tg_hidden.$tg_ip_name.$row['name'].$tg_ip_size.$row['size'].$tg_ip_value;
		$a=$a.$datarow[$row['name']].$tg_ip_cl;
		}else
		$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		}elseif($row['dbindex']=="primary" && !in_array($row['name'],$arr))
		{
		$a=$a.$tg_ip.$tg_ip_type.$tg_hidden.$tg_ip_name.$row['name'].$tg_ip_size.$row['size'].$tg_ip_value;
		$a=$a.$datarow[$row['name']].$tg_ip_cl;
		}
		//echo $a;
		//close while loop
		}

		$a=$a.$tg_ro_cl;

		}
//Close Table
		$a=$a.$tg_top_cl;
	}

	$a=$a."<input class=\"btn btn-warning\" id=\"btn\" type=\"submit\" name=\"modify\" value=\"modify\">";
	return $a;
}

?>