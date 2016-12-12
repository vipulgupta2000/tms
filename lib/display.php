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
	//adding new below 2 rows
	$tg_nrow="<div class=\"row clearfix\">";
	$tg_ncol="<div class=\"col-md-4 column\">";
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
	//adding for image and attachments fields
	//<div>  <img src="https://media.licdn.com/mpr/mpr/shrinknp_200_200/p/3/000/0b7/06d/0df966e.jpg" alt="Vipul Gupta" height="200" width="200"></div>
	$tg_img="<div><img src=\"";
	$tg_img_alt="\" alt=\"";
	$tg_img_ht="\" height=\"";
	$tg_img_wd="\" width=\"";
	$tg_img_cl="\"></div>"; 
        $tg_thead="<thead>";
        $tg_thead_cl="</thead>";
        
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
		if($row['type']=="idate")
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
		$a=$a.$tg_thead.$tg_ro;
		while($row = mysql_fetch_array($result1))
		{
		if((empty($arr) || in_array($row['name'],$arr)) )
		$a=$a.$tg_hdr.$row['alias'].$tg_hdr_cl;
		}
		$a=$a.$tg_ro_cl.$tg_thead_cl;


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
		if($row['type']=="idate")
		$a=$a.$tg_td.getmydate($datarow[$row['name']]).$tg_td_cl;
		//$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		elseif($row['type']=="password"){
		$a=$a.$tg_td.$tg_td_cl;
		}
                elseif($row['type']=="option")
		{$j=1;
		$a=$a.$tg_td;		
		$sql_opt="select * from field_option where tblid=".$row['tblid']." and fieldid=".$row['fieldid']." and value=".$datarow[$row['name']];
                $result_opt=mysql_query($sql_opt);
				while($row_opt = mysql_fetch_array($result_opt))
					{$alias='';
					$alias=$row_opt['alias'];
					}
                                $alias=isset($alias)?$alias:NULL;
				$a=$a.$alias.$tg_td_cl;
				$j++;
                 }elseif($row['type']=="list")
					{
                    $a=$a.$tg_td;
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
                                                    if($row_opt['value']==$datarow[$row['name']]) 
                                                            {$alias=$row_opt['alias'];}
                                                    }
                                            }
                                    //}
                                    //below handles code if no value is set and also instead of value shows alias
                                    $alias=(isset($alias)&&($alias!=null))?$alias:"";
                                    //echo "alias is".$alias;
                                    $a=$a.$alias.$tg_td_cl;
                                    $j++;
					}			
                elseif($row['dbindex']=="primary" ){
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
if($mode==2)
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
		if($row['type']=="idate")
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
	if($_GET['page'] == 'payroll'){$a=$a."<button class=\"btn btn-warning\" id=\"btn_modify\" type=\"submit\" name=\"modify\" value=\"modify\">Cancel/Close</button>";}
	elseif($_GET['page'] == 'master'){$a=$a."<button class=\"btn btn-warning\" id=\"btn_modify\" type=\"submit\" name=\"modify\" value=\"modify\">Modify</button>";}
	elseif($_GET['page'] == 'accounts'){}
	else{$a=$a."<button class=\"btn btn-warning\" id=\"btn_modify\" type=\"submit\" name=\"modify\" value=\"modify\">Modify</button>";}
	return $a;
}

function display_link($tbl,$qual,$md,$arr,$link='')
{

	$sql1=dbsql($tbl);
	$tg_top="<div class=\"table-responsive\"><table class=\"table table-hover\" id=\"".$tbl."\" width=auto >";
		$tg_hdr="<th>";
		$tg_hdr_cl="</th>";
		//$tg_ro="<tr class=\"clickableRow\" href=\"".$link."constant\">";
		$tg_ro="<tr class=\"clickableRow\" href=\"#\" onclick=\"openUser(constant);\">";
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
	if($_GET['page']==$tbl)
	$data_sql=getPagesql($data_sql,5);
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
		if($row['type']=="idate")
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
		if($row['type']=="idate")
		$a=$a.$tg_td.getmydate($datarow[$row['name']]).$tg_td_cl;
		//$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		elseif($row['type']=="password"){
		$a=$a.$tg_td.$tg_td_cl;
		}
                                elseif($row['type']=="option")
		{$j=1;
		$a=$a.$tg_td;		
		$sql_opt="select * from field_option where tblid=".$row['tblid']." and fieldid=".$row['fieldid']." and value=".$datarow[$row['name']];
                $result_opt=mysql_query($sql_opt);
				while($row_opt = mysql_fetch_array($result_opt))
					{$alias='';
					$alias=$row_opt['alias'];
					}
                                $alias=isset($alias)?$alias:NULL;
				$a=$a.$alias.$tg_td_cl;
				$j++;
                 }elseif($row['type']=="list")
					{
                    $a=$a.$tg_td;
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
                                            $sql_opt="select ".$vvalue." 'value',".$valias." 'alias' from ".$vsource.$vfilter." and ".$vvalue."=".$datarow[$row['name']];
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
                                                    if($row_opt['value']==$datarow[$row['name']]) 
                                                            {$alias=$row_opt['alias'];}
                                                    }
                                            }
                                    //}
                                    //below handles code if no value is set and also instead of value shows alias
                                    $alias=(isset($alias)&&($alias!=null))?$alias:"";
                                    //echo "alias is".$alias;
                                    $a=$a.$alias.$tg_td_cl;
                                    $j++;
					}
                elseif($row['dbindex']=="primary" ){
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
	if($mode==2)
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
		if($row['type']=="idate")
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
		if($row['type']=="idate")
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
		
		$hdr=array();
		while($row = mysql_fetch_array($result1))
		{
		if((empty($arr) || in_array($row['name'],$arr)) )
		$a=$a.$tg_hdr.$row['alias'].$tg_hdr_cl;
		$hdr[$row['name']]=$row['alias'];
		}
		$a=$a.$tg_ro_cl;
//var_dump($hdr);
//echo $hdr['id'];
$record=array();$rec=array();
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
		if($row['type']=="idate")
		{$a=$a.$tg_td.getmydate($datarow[$row['name']]).$tg_td_cl;$rec[$row['name']]=getmydate($datarow[$row['name']]);/*$record[$datarow[$row['name']]]=array($row['name']=>getmydate($datarow[$row['name']]))*/;}	
		//$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		elseif($row['type']=="password"){
		$a=$a.$tg_td.$tg_td_cl;
		}elseif($row['dbindex']=="primary" ){
		$rec[$row['name']]=$datarow[$row['name']];
                //$record[$datarow[$row['name']]]=array($row['name']=>$datarow[$row['name']]);
		$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		$a=$a.$tg_ip.$tg_ip_type.$tg_hidden.$tg_ip_name.$row['name'].$tg_ip_size.$row['size'].$tg_ip_value;
		$a=$a.$datarow[$row['name']].$tg_ip_cl;
		}else
		$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;$rec[$row['name']]=$datarow[$row['name']];/*$record[$datarow[$row['name']]]=array($row['name']=>$datarow[$row['name']])*/;
		}elseif($row['dbindex']=="primary" && !in_array($row['name'],$arr))
		{
		$a=$a.$tg_ip.$tg_ip_type.$tg_hidden.$tg_ip_name.$row['name'].$tg_ip_size.$row['size'].$tg_ip_value;
		$a=$a.$datarow[$row['name']].$tg_ip_cl;
		//$rec=$rec.$row['name'].'=>'.$datarow[$row['name']];
                //$record[$datarow[$row['name']]]=array($row['name']=>$datarow[$row['name']]);
		}
		//echo $a;
		//close while loop
                
		}
                //chop($rec,",");
                $record[]=$rec;
                unset($rec);
		$a=$a.$tg_ro_cl;

		}
//Close Table
		$a=$a.$tg_top_cl;
	}
//var_dump($record);
	//$a=$a."<input class=\"btn btn-warning\" id=\"btn\" type=\"submit\" name=\"modify\" value=\"modify\">";
	//return $a;
        return $record;
}

function display_data($tbl,$qual,$md,$arr)
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
	//if($_GET['page']==$tbl)
	//$data_sql=getPagesql($data_sql,7);
	$result1=mysql_query($sql1);
//mode 0 is columnar and mode 1 for row-wise printing
	$a="";
	$opt=array(1 => "k");
	$mode=1;
	$j=0;

	$mode=$md;

		if($mode==1)
	{
//Open Table

		$a= $tg_top;

//Print Header row
		$a=$a.$tg_ro;
		
		/*$hdr=array();
		while($row = mysql_fetch_array($result1))
		{
		if((empty($arr) || in_array($row['name'],$arr)) )
		$a=$a.$tg_hdr.$row['alias'].$tg_hdr_cl;
		$hdr[$row['name']]=$row['alias'];
		}
		$a=$a.$tg_ro_cl;
		*/
//var_dump($hdr);
//echo $hdr['id'];
$record=array();
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
		if($row['type']=="idate")
		{$a=$a.$tg_td.getmydate($datarow[$row['name']]).$tg_td_cl;$record[$datarow[$row['name']]]=array($row['name']=>getmydate($datarow[$row['name']]));}	
		//$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		elseif($row['type']=="password"){
		$a=$a.$tg_td.$tg_td_cl;
		}elseif($row['dbindex']=="primary" ){
		$record[$datarow[$row['name']]]=array($row['name']=>$datarow[$row['name']]);
		$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		$a=$a.$tg_ip.$tg_ip_type.$tg_hidden.$tg_ip_name.$row['name'].$tg_ip_size.$row['size'].$tg_ip_value;
		$a=$a.$datarow[$row['name']].$tg_ip_cl;
		}else
		$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;$record[$datarow[$row['name']]]=array($row['name']=>$datarow[$row['name']]);
		}elseif($row['dbindex']=="primary" && !in_array($row['name'],$arr))
		{
		$a=$a.$tg_ip.$tg_ip_type.$tg_hidden.$tg_ip_name.$row['name'].$tg_ip_size.$row['size'].$tg_ip_value;
		$a=$a.$datarow[$row['name']].$tg_ip_cl;
		$record[$datarow[$row['name']]]=array($row['name']=>$datarow[$row['name']]);
		}
		//echo $a;
		//close while loop
		}

		$a=$a.$tg_ro_cl;

		}
//Close Table
		$a=$a.$tg_top_cl;
	}
//var_dump($record);
//$a=json_encode($record);
	//$a=$a."<input class=\"btn btn-warning\" id=\"btn\" type=\"submit\" name=\"modify\" value=\"modify\">";
	return $a;
}

function display_data_text($tbl,$qual,$md,$arr)
{

	$sql1=dbsql($tbl);
	$tg_top="";
	$tg_hdr="";
	$tg_hdr_cl="";
	$tg_ro="";
	$tg_ro_cl="";
	$tg_td="";
	$tg_td_cl="";
	$tg_top_cl="";
	$tg_ip="";
	$tg_ip_type="";
	$tg_ip_name="";
	$tg_ip_value="";
	$tg_ip_size="";
	$tg_ip_id="";
	$tg_class="";
	$tg_ip_cl="";
	$tg_chk="<input type=\"checkbox\" name=\"chb";
	$tg_chk_val="";
	$tg_dat="<a href=\"javascript:NewCal('";
	$tg_dat_cl="','yyyymmdd')\"><img src=datetimepick/cal.gif width=16 height=16 border=0 alt=Pick a date></a>";
	$tg_sel="<select name=\"";
	$tg_cl="\" >";
	$tg_sel_cl="</select>";
	$tg_opt="<option value=\"";
	$tg_opt_cl="</option>";
	$tg_hidden="";
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
	//$data_sql=getPagesql($data_sql,7);
	$result1=mysql_query($sql1);
//mode 0 is columnar and mode 1 for row-wise printing
	$a="";
	$opt=array(1 => "k");
	$mode=1;
	$j=0;

	$mode=$md;

		if($mode==1)
	{
//Open Table

		$a= $tg_top;

//Print Header row
		$a=$a.$tg_ro;
		
		/*$hdr=array();
		while($row = mysql_fetch_array($result1))
		{
		if((empty($arr) || in_array($row['name'],$arr)) )
		$a=$a.$tg_hdr.$row['alias'].$tg_hdr_cl;
		$hdr[$row['name']]=$row['alias'];
		}
		$a=$a.$tg_ro_cl;
		*/
//var_dump($hdr);
//echo $hdr['id'];
$record=array();
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
		if($row['type']=="idate")
		{$a=$a.$tg_td.getmydate($datarow[$row['name']]).$tg_td_cl;$record[$datarow[$row['name']]]=array($row['name']=>getmydate($datarow[$row['name']]));}	
		//$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		elseif($row['type']=="password"){
		$a=$a.$tg_td.$tg_td_cl;
		}elseif($row['dbindex']=="primary" ){
		$record[$datarow[$row['name']]]=array($row['name']=>$datarow[$row['name']]);
		//$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
		//$a=$a.$tg_ip.$tg_ip_type.$tg_hidden.$tg_ip_name.$row['name'].$tg_ip_size.$row['size'].$tg_ip_value;
		//$a=$a.$datarow[$row['name']].$tg_ip_cl;
		}else
		$a=$a.$tg_td.$datarow[$row['name']].$tg_td_cl;
                $record[$datarow[$row['name']]]=array($row['name']=>$datarow[$row['name']]);
		}elseif($row['dbindex']=="primary" && !in_array($row['name'],$arr))
		{
		//$a=$a.$tg_ip.$tg_ip_type.$tg_hidden.$tg_ip_name.$row['name'].$tg_ip_size.$row['size'].$tg_ip_value;
		//$a=$a.$datarow[$row['name']].$tg_ip_cl;
		$record[$datarow[$row['name']]]=array($row['name']=>$datarow[$row['name']]);
		}
		//echo $a;
		//close while loop
		}

		$a=$a.$tg_ro_cl;

		}
//Close Table
		$a=$a.$tg_top_cl;
	}
//var_dump($record);
//$a=json_encode($record);
	//$a=$a."<input class=\"btn btn-warning\" id=\"btn\" type=\"submit\" name=\"modify\" value=\"modify\">";
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
 $tg_thead="<thead>";
 $tg_thead_cl="</thead>";
        
 $data_sql="select * from ".$tbl;

 if(isset($qual))
 {
 $qual=" where ".$qual;
 $data_sql=$data_sql.$qual;
 }
 //only get pages if this is main table
 if($_GET['page']==$tbl)
 //$data_sql=getPagesql($data_sql,7);
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
  if($row['type']=="idate")
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
  $a=$a.$tg_thead.$tg_ro;
  while($row = mysql_fetch_array($result1))
  {
  if((empty($arr) || in_array($row['name'],$arr)) )
  $a=$a.$tg_hdr.$row['alias'].$tg_hdr_cl;
  }
  //add timetable total column
  //$a=$a.$tg_hdr."Total".$tg_hdr_cl;
  $a=$a.$tg_ro_cl.$tg_thead_cl;

  //define timetable specific variables to store values
  $tot = 0;
  $tcr = 0;
  $tdr = 0;
  
  //Print Data rows
  $result_data=mysql_query($data_sql);
  while($datarow=mysql_fetch_array($result_data))
  {
  $a=$a.$tg_ro;
  $result1=mysql_query($sql1);
  
  // To Calculate the Total of a row in a timetable.
  //$sumrow=$datarow['cr']+$datarow['dr'];
  //$tot=$tot+$sumrow;

  // To Calculate the Total of Column in a timetable.
  $tcr  = $tcr + $datarow['cr'];
  $tdr  = $tdr + $datarow['dr'];
   
  while($row = mysql_fetch_array($result1))
  {
  if(empty($arr) || in_array($row['name'],$arr))
   {
  if($row['type']=="idate")
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
  //adding below row for total column in timetable
 // $a=$a.$tg_td.$sumrow.$tg_td_cl;
  
 // $a=$a.$tg_ro_cl;

  }
//Close Table
  //total row in the last;
  $z="<tr class=\"success\"> <td colspan=\"3\" class=\"tot\">Total</td> <td class=\"tot\">$tdr</td> <td class=\"tot\">$tcr</td> </tr>";
  $bal = $tdr - $tcr;
  if($bal < 0){$bal =  abs($bal);
$b="<tr class=\"warning\"> <td colspan=\"3\" class=\"tot\">Balance</td> <td class=\"tot\">$bal</td> <td class=\"tot\">0.00</td> </tr>";
$to = $tdr+$bal;
$q="<tr class=\"success\"> <td colspan=\"3\" class=\"tot\">Balance Sheet Statement</td> <td class=\"tot\">$to</td> <td class=\"tot\">$tcr</td> </tr>";
}
	  else{		  
$b="<tr class=\"danger\"> <td colspan=\"3\" class=\"tot\">Balance</td> <td class=\"tot\">0.00</td> <td class=\"tot\">$bal</td> </tr>";
$to = $tcr+$bal;
$q="<tr class=\"success\"> <td colspan=\"3\" class=\"tot\">Balance Sheet Statement</td> <td class=\"tot\">$tdr</td> <td class=\"tot\">$to</td> </tr>";
}
   
  //$tot=$tot+$sumrow;
  $a=$a.$z;
 
  
   $a=$a.$b;
   $a=$a.$q;
  $a=$a.$tg_top_cl;
 }
if($_GET['page'] == 'accounts'){}
else{
 $a=$a."<input class=\"btn btn-warning\" id=\"btn\" type=\"submit\" name=\"modify\" value=\"modify\">";}
 return $a;
}

?>
