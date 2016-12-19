<?php

function input($tbl,$qual,$arr,$arr_show,$mode=1)
{
	$sql1=dbsql($tbl);
	$tg_top="<div class=\"table-responsive\"><table class=\"table table-striped\" id=\"".$tbl."\" width=auto border=1 cellpadding=2 cellspacing=2>";
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
	$tg_dat_cl="','ddmmyyyy')\"><img src=datetimepick/cal.gif width=16 height=16 border=0 alt=Pick a date></a>";
	$tg_sel="<select id=\"";
	$tg_cl="\" >";
	$tg_sel_cl="</select>";
	$tg_opt="<option value=\"";
	$tg_opt_cl="</option>";
	$tg_hidden="hidden";
	$tg_readonly="\" readonly ";
	$tg_text="<textarea rows=\"4\" cols=\"15\" ";
	$tg_text_cl="</textarea>";

	$result1=mysql_query($sql1);
	$data_sql="select * from ".$tbl;
	if(isset($qual))
		{
		$qual=" where ".$qual;
		$data_sql=$data_sql.$qual;
	}
	//echo $data_sql;
	$data_sql=getPagesql($data_sql,7);
	//echo $data_sql;
//mode 0 is columnar and mode 1 for row-wise printing
	$a="";
	$opt=array(1 => "k");
	//$mode=1;
	$j=0;

	if($mode==0)
	{
	//Open Table
	echo $tg_top;
	//Print Header column
		while($row = mysql_fetch_array($result1))
		{

		echo $tg_ro;

		echo $tg_hdr.$row['alias'].$tg_hdr_cl;

	//Print data columns
		$result_data=mysql_query($data_sql);
		while($datarow=mysql_fetch_array($result_data))
		{
		if($row['dbindex']=='primary')
		{
		echo $tg_td.$datarow[$row['name']].$tg_td_cl;
		}else
		{
		echo $tg_td.$tg_ip.$tg_ip_type.$row['type'].$tg_ip_name.$row['name'].$tg_ip_size.$row['size'].$tg_ip_value;
						echo $datarow[$row['name']];
				echo $tg_ip_cl.$tg_td_cl;
		}
		}

		echo $tg_ro_cl;
		}
	//Close Table
		echo $tg_top_cl;
	}
	if($mode==1)
	{
//Open Table
		echo $tg_top;

//Print Header row
		$a= $tg_ro;
		// adding for display only temporary fields
		$tmp='';
		//blank cell for checkbox
		$a=$a.$tg_hdr.$tg_chk.$tg_chk_val.$tg_ip_cl.$tg_hdr_cl;
		while($row = mysql_fetch_array($result1))
		{
		$tmp=$tmp.$row['name'].',';
		if(empty($arr_show) || in_array($row['name'],$arr_show))
		$a=$a.$tg_hdr.$row['alias'].$tg_hdr_cl;
		// adding for display only temporary fields
		}
		for($i=0;$i<sizeof($arr_show);$i++)
		{
		$k=is_array($arr_show[$i])?$arr_show[$i][0]:$arr_show[$i];
		$j=explode(',',$tmp);
		if(!in_array($k,explode(',',$tmp)))
		$a=$a.$tg_hdr.$k.$tg_hdr_cl;
		}
		$a=$a.$tg_ro_cl;

//Print Data rows
		$result_data=mysql_query($data_sql);
		$cnt=0;
		while($datarow=mysql_fetch_array($result_data))
		{
		$j=1;

		$a=$a.$tg_ro;

		//Input for checkbox
		//echo $datarow['status'];
		// Start Added by Anshul for no Check box in paystate
		if($tbl == 'paystate'){
			if($datarow['status'] == 'Open'){
				$a=$a.$tg_td.$tg_chk.$cnt.$tg_chk_val;
				$a=$a.$tg_ip_cl.$tg_td_cl;
				}
			else{$a=$a.$tg_td;
				$a=$a;}
		}
		// End Added by Anshul for no Check box in paystate
		
		// Start Added by Anshul for no Check box in Bank
		elseif($tbl == 'bank'){
			if($datarow['status'] == 'Loaded'){
				$a=$a.$tg_td.$tg_chk.$cnt.$tg_chk_val;
				$a=$a.$tg_ip_cl.$tg_td_cl;
				}
			else{$a=$a.$tg_td;
				$a=$a;}
		}
		
		// End Added by Anshul for no Check box in Bank
		
		// Start Added by Anshul for no Check box in Payroll
		elseif($tbl == 'payroll'){
			if($datarow['status'] == 'Open'){
				$a=$a.$tg_td.$tg_chk.$cnt.$tg_chk_val;
				$a=$a.$tg_ip_cl.$tg_td_cl;
				}
			else{$a=$a.$tg_td;
				$a=$a;}
		}
		// End Added by Anshul for no Check box in Paroll
		
		else{
		$a=$a.$tg_td.$tg_chk.$cnt.$tg_chk_val;
		$a=$a.$tg_ip_cl.$tg_td_cl;}
		

		$result1=mysql_query($sql1);
		while($row = mysql_fetch_array($result1))
		{
			if(empty($arr_show) || in_array($row['name'],$arr_show))
				{
					if($row['dbindex']=="primary" || !in_array($row['name'], $arr))
					//if($row['dbindex']=="primary")
					{
						//$a=$a.$tg_td.$tg_ip.$tg_ip_type.$row['type'].$tg_ip_name.$row['name'].$cnt.$tg_readonly.$tg_ip_size.$row['size'].$tg_ip_value;
						$a=$a.$tg_td.$tg_ip.$tg_ip_type.$tg_hidden.$tg_ip_name.$row['name'].$cnt.$tg_ip_size.$row['size'].$tg_ip_value;
						//$a=$a.$datarow[$row['name']].$tg_ip_cl.$tg_td_cl;

						if($row['type']=="idate")
						{
						$a=$a.getmydate($datarow[$row['name']]).$tg_ip_cl;
						$a=$a.getmydate($datarow[$row['name']]).$tg_td_cl;
						}else
						{
						$a=$a.$datarow[$row['name']].$tg_ip_cl;
						$a=$a.$datarow[$row['name']].$tg_td_cl;
						}
					}elseif($row['type']=="textarea")
					{
						$a=$a.$tg_td.$tg_text.$tg_ip_name.$row['name'].$cnt.$tg_ip_cl;
						$a=$a.$datarow[$row['name']].$tg_text_cl.$tg_td_cl;
					}
					elseif($row['type']=="option")
					{					$a=$a.$tg_td.$tg_sel.$row['name'].$cnt.$tg_ip_name.$row['name'].$cnt.$tg_cl;
										//$a=$a.$tg_opt.$datarow[$row['name']].$tg_cl.$datarow[$row['name']].$tg_opt_cl;
										//if($cnt==0)
										//{
											$sql_opt="select * from field_option where tblid=".$row['tblid']." and fieldid=".$row['fieldid'];
											$result_opt=mysql_query($sql_opt);
											$opt[$j]="";
											while($row_opt = mysql_fetch_array($result_opt))
												{
												$opt[$j]=$opt[$j].$tg_opt.$row_opt['value'].$tg_cl.$row_opt['alias'].$tg_opt_cl;
												if($row_opt['value']==$datarow[$row['name']]) 
													{$alias='';$alias=$row_opt['alias'];}
												}
										//}
										//below handles code if no value is set and also instead of value shows alias
										$alias=isset($alias)?$alias:NULL;
										$a=$a.$tg_opt.$datarow[$row['name']].$tg_cl.$alias.$tg_opt_cl;
										//introducing for clear value option
										
										$a=$a.$tg_opt.$datarow[$row['name']].$tg_cl.$tg_opt_cl;
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
												if($row_opt['value']==$datarow[$row['name']]) 
													{$alias=$row_opt['alias'];}
												}
											}
										//}
										//below handles code if no value is set and also instead of value shows alias
										$alias=(isset($alias)&&($alias!=null))?$alias:"--clear--";
										echo "alias is".$alias;
										$a=$a.$tg_opt.$datarow[$row['name']].$tg_cl.$alias.$tg_opt_cl;
										//introducing for clear value option
										$a=$a.$tg_opt."".$tg_cl."--clear--".$tg_opt_cl;
										$a=$a.$opt[$j].$tg_sel_cl.$tg_td_cl;
					$j++;
					}
					else
					{
						$a=$a.$tg_td.$tg_ip.$tg_ip_type.$row['type'].$tg_ip_name.$row['name'].$cnt.$tg_ip_size.$row['size'].$tg_ip_value;
							if($row['type']=="idate")
							{
							$a=$a.getmydate($datarow[$row['name']]);
							$a=$a.$tg_ip_id.$row['name'].$cnt.$tg_class;
							$a=$a.$tg_ip_cl.$tg_dat.$row['name'].$cnt.$tg_dat_cl.$tg_td_cl;
							}
							else
							{$a=$a.$datarow[$row['name']].$tg_ip_cl.$tg_td_cl;}
					}
//close if condition
				}	
//close inner while
		}
			for($i=0;$i<sizeof($arr_show);$i++)
				{
				$k=is_array($arr_show[$i])?$arr_show[$i][0]:$arr_show[$i];
				$val=is_array($arr_show[$i])?$arr_show[$i][1]:NULL;
				$j=explode(',',$tmp);
				if(!in_array($k,explode(',',$tmp)))
				$a=$a.$tg_td.$tg_ip.$tg_ip_type.'text'.$tg_ip_name.$k.$cnt.$tg_ip_size.'10'.$tg_ip_value.$val.$tg_ip_cl.$tg_td_cl;
				}
		$cnt++;
		$a=$a.$tg_ro_cl."\n";
		}
//Close Table
		$a=$a.$tg_top_cl;
		$a=$a."<input type=\"number\" name=\"icnt\" value=$cnt style=\"display:none\">";
		$a=$a."<input type=\"hidden\" name=\"field_edit\" value=\"".implode(",",$arr)."\" >";
//Close Mode
	}

	//only get pages if this is main table
if($_GET['page'] == 'bank'){}
elseif($_GET['page'] == 'load_master'){}
elseif($_GET['page'] == 'payroll'){
$a=$a."&nbsp<input class=\"btn btn-danger\" id=\"btn\" type=\"submit\" name=\"cancel_payroll\" value=\"Cancel Payroll\">&nbsp;&nbsp;&nbsp;"; 
$a=$a."<input class=\"btn btn-primary\" id=\"btn\" type=\"submit\" name=\"close_payroll\" value=\"Close Payroll\">";}
elseif($_GET['page'] == 'paystate'){$a=$a."&nbsp<input class=\"btn btn-danger\" id=\"btn\" type=\"submit\" name=\"update\" value=\"Close Paystate\">";}
else{	
if($_GET['page']==$tbl){
$a=$a."&nbsp<input class=\"btn btn-danger\" id=\"btn\" type=\"submit\" name=\"update\" value=\"Update\">";}
if($_SESSION['SESS_perm']=='sys_admin'){
$a=$a."&nbsp<input class=\"btn btn-danger\" id=\"btn_del\" type=\"submit\" name=\"delete\" value=\"Delete\">";}}
return $a;
}



?>
<?php
// written to show fields in arranged format in input mode
function input_new($tbl,$qual,$arr,$arr_show,$mode)
{
	
	$sql1=dbsql($tbl);
	
	$col_wid=0;$col_space=0;
	if($mode==2)
	{$col_wid=4;$col_space=2;}
	if($mode==3)
	{$col_wid=3;$col_space=1;}
	$span=($col_wid*$mode)+(($mode-1)*$col_space);
	$tg_row="<div class=\"row\">";
	$tg_col1="<div class=\"col-md-1\">";
	$tg_span="<div class=\"col-md-$span\">";
	$tg_colspace="<div class=\"col-md-$col_space\"></div>";
	$tg_col="<div class=\"col-md-$col_wid\">";
	$tg_ip_gp="<div class=\"form-group\"><label for=\"";
	$tg_ip_gp_cl="</label>";
	$tg_static="<div class=\"col-sm-10\"><p class=\"form-control-static\">";
	$tg_static_cl="</p>";
	$tg_div_cl="</div>";
	$tg_ip_class="\" class=\"form-control";
	
	$tg_top="<div class=\"table-responsive\"><table class=\"table table-striped\" id=\"".$tbl."\" width=auto border=1 cellpadding=2 cellspacing=2>";
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
	$tg_dat_cl="','ddmmyyyy')\"><img src=datetimepick/cal.gif width=16 height=16 border=0 alt=Pick a date></a>";
	$tg_sel="<select class=\"form-control\" id=\"";
	$tg_cl="\" >";
	$tg_sel_cl="</select>";
	$tg_opt="<option value=\"";
	$tg_opt_cl="</option>";
	$tg_hidden="hidden";
	$tg_readonly="\" readonly ";
	$tg_text="<textarea rows=\"4\" cols=\"15\" ";
	$tg_text_cl="</textarea>";

	$result1=mysql_query($sql1);
	$data_sql="select * from ".$tbl;
	if(isset($qual))
		{
		$qual=" where ".$qual;
		$data_sql=$data_sql.$qual;
	}
	//$data_sql=getPagesql($data_sql,7);
	//echo $data_sql;
//mode 0 is columnar and mode 1 for row-wise printing
	$a="";
	$opt=array(1 => "k");
	//$mode=1;
	$j=0;

	if($mode==0)
	{
	//Open Table
	echo $tg_top;
	//Print Header column
		while($row = mysql_fetch_array($result1))
		{

		echo $tg_ro;

		echo $tg_hdr.$row['alias'].$tg_hdr_cl;

	//Print data columns
		$result_data=mysql_query($data_sql);
		while($datarow=mysql_fetch_array($result_data))
		{
		if($row['dbindex']=='primary')
		{
		echo $tg_td.$datarow[$row['name']].$tg_td_cl;
		}else
		{
		echo $tg_td.$tg_ip.$tg_ip_type.$row['type'].$tg_ip_name.$row['name'].$tg_ip_size.$row['size'].$tg_ip_value;
						echo $datarow[$row['name']];
				echo $tg_ip_cl.$tg_td_cl;
		}
		}

		echo $tg_ro_cl;
		}
	//Close Table
		echo $tg_top_cl;
	}
	if($mode==1)
	{
//Open Table
		echo $tg_top;

//Print Header row
		$a= $tg_ro;
		// adding for display only temporary fields
		$tmp='';
		//blank cell for checkbox
		$a=$a.$tg_hdr.$tg_chk.$tg_chk_val.$tg_ip_cl.$tg_hdr_cl;
		while($row = mysql_fetch_array($result1))
		{
		$tmp=$tmp.$row['name'].',';
		if(empty($arr_show) || in_array($row['name'],$arr_show))
		$a=$a.$tg_hdr.$row['alias'].$tg_hdr_cl;
		// adding for display only temporary fields
		}
		for($i=0;$i<sizeof($arr_show);$i++)
		{
		$k=is_array($arr_show[$i])?$arr_show[$i][0]:$arr_show[$i];
		$j=explode(',',$tmp);
		if(!in_array($k,explode(',',$tmp)))
		$a=$a.$tg_hdr.$k.$tg_hdr_cl;
		}
		$a=$a.$tg_ro_cl;

//Print Data rows
		$result_data=mysql_query($data_sql);
		$cnt=0;
		while($datarow=mysql_fetch_array($result_data))
		{
		$j=1;

		$a=$a.$tg_ro;

		//Input for checkbox
		$a=$a.$tg_td.$tg_chk.$cnt.$tg_chk_val;
		$a=$a.$tg_ip_cl.$tg_td_cl;

		$result1=mysql_query($sql1);
		while($row = mysql_fetch_array($result1))
		{
			if(empty($arr_show) || in_array($row['name'],$arr_show))
				{
					if($row['dbindex']=="primary" || !in_array($row['name'], $arr))
					//if($row['dbindex']=="primary")
					{
						//$a=$a.$tg_td.$tg_ip.$tg_ip_type.$row['type'].$tg_ip_name.$row['name'].$cnt.$tg_readonly.$tg_ip_size.$row['size'].$tg_ip_value;
						$a=$a.$tg_td.$tg_ip.$tg_ip_type.$tg_hidden.$tg_ip_name.$row['name'].$cnt.$tg_ip_size.$row['size'].$tg_ip_value;
						//$a=$a.$datarow[$row['name']].$tg_ip_cl.$tg_td_cl;

						if($row['type']=="idate")
						{
						$a=$a.getmydate($datarow[$row['name']]).$tg_ip_cl;
						$a=$a.getmydate($datarow[$row['name']]).$tg_td_cl;
						}else
						{
						$a=$a.$datarow[$row['name']].$tg_ip_cl;
						$a=$a.$datarow[$row['name']].$tg_td_cl;
						}
					}elseif($row['type']=="textarea")
					{
						$a=$a.$tg_td.$tg_text.$tg_ip_name.$row['name'].$cnt.$tg_ip_cl;
						$a=$a.$datarow[$row['name']].$tg_text_cl.$tg_td_cl;
					}
					elseif($row['type']=="option")
					{					$a=$a.$tg_td.$tg_sel.$row['name'].$cnt.$tg_ip_name.$row['name'].$cnt.$tg_cl;
										//$a=$a.$tg_opt.$datarow[$row['name']].$tg_cl.$datarow[$row['name']].$tg_opt_cl;
										//if($cnt==0)
										//{
											$sql_opt="select * from field_option where tblid=".$row['tblid']." and fieldid=".$row['fieldid'];
											
											$result_opt=mysql_query($sql_opt);
											$opt[$j]="";
											while($row_opt = mysql_fetch_array($result_opt))
												{
												$opt[$j]=$opt[$j].$tg_opt.$row_opt['value'].$tg_cl.$row_opt['alias'].$tg_opt_cl;
												if($row_opt['value']==$datarow[$row['name']]) 
													{$alias='';$alias=$row_opt['alias'];}
												}
										//}
										//below handles code if no value is set and also instead of value shows alias
										$alias=isset($alias)?$alias:NULL;
										$a=$a.$tg_opt.$datarow[$row['name']].$tg_cl.$alias.$tg_opt_cl;
										//introducing for clear value option
										$a=$a.$tg_opt.$datarow[$row['name']].$tg_cl.$tg_opt_cl;
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
												if($row_opt['value']==$datarow[$row['name']]) 
													{$alias=$row_opt['alias'];}
												}
											}
										//}
										//below handles code if no value is set and also instead of value shows alias
										$alias=(isset($alias)&&($alias!=null))?$alias:"--clear--";
										echo "alias is".$alias;
										$a=$a.$tg_opt.$datarow[$row['name']].$tg_cl.$alias.$tg_opt_cl;
										//introducing for clear value option
										$a=$a.$tg_opt."".$tg_cl."--clear--".$tg_opt_cl;
										$a=$a.$opt[$j].$tg_sel_cl.$tg_td_cl;
					$j++;
					}
					else
					{
						$a=$a.$tg_td.$tg_ip.$tg_ip_type.$row['type'].$tg_ip_name.$row['name'].$cnt.$tg_ip_size.$row['size'].$tg_ip_value;
							if($row['type']=="idate")
							{
							$a=$a.getmydate($datarow[$row['name']]);
							$a=$a.$tg_ip_id.$row['name'].$cnt.$tg_class;
							$a=$a.$tg_ip_cl.$tg_dat.$row['name'].$cnt.$tg_dat_cl.$tg_td_cl;
							}
							else
							{$a=$a.$datarow[$row['name']].$tg_ip_cl.$tg_td_cl;}
					}
//close if condition
				}	
//close inner while
		}
			for($i=0;$i<sizeof($arr_show);$i++)
				{
				$k=is_array($arr_show[$i])?$arr_show[$i][0]:$arr_show[$i];
				$val=is_array($arr_show[$i])?$arr_show[$i][1]:NULL;
				$j=explode(',',$tmp);
				if(!in_array($k,explode(',',$tmp)))
				$a=$a.$tg_td.$tg_ip.$tg_ip_type.'text'.$tg_ip_name.$k.$cnt.$tg_ip_size.'10'.$tg_ip_value.$val.$tg_ip_cl.$tg_td_cl;
				}
		$cnt++;
		$a=$a.$tg_ro_cl."\n";
		}
//Close Table
		$a=$a.$tg_top_cl;
		$a=$a."<input type=\"number\" name=\"icnt\" value=$cnt style=\"display:none\">";
		$a=$a."<input type=\"hidden\" name=\"field_edit\" value=\"".implode(",",$arr)."\" >";
//Close Mode
	}
if($mode>=2)
	{
	//Open Table
	//echo $tg_top;
	//Print Header column
	$nfield=0;
	$split=0;
	$a=$tg_row.$tg_col1.$tg_div_cl;
	//echo $tg_col;
	$a=$a.$tg_col;$b=$tg_col;
	if($mode==3)
	$c=$tg_col;
	$d=$tg_div_cl.$tg_row.$tg_col1.$tg_div_cl.$tg_span;	
	$cnt=0;
		while($row = mysql_fetch_array($result1))
		{
		if($row['span']==2)
		{$d=$d.$tg_ip_gp.$row['name'].$tg_cl.$row['alias'].$tg_ip_gp_cl;$split=1;}
		else{
		if($row['col']==2)
		$b=$b.$tg_ip_gp.$row['name'].$tg_cl.$row['alias'].$tg_ip_gp_cl;
		elseif($row['col']==3)
		$c=$c.$tg_ip_gp.$row['name'].$tg_cl.$row['alias'].$tg_ip_gp_cl;
		else
		$a=$a.$tg_ip_gp.$row['name'].$tg_cl.$row['alias'].$tg_ip_gp_cl;
		}

	//Print data columns
		$result_data=mysql_query($data_sql);
		$j=1;
		while($datarow=mysql_fetch_array($result_data))
		{
		if(empty($arr_show) || in_array($row['name'],$arr_show))
		{		
		if($row['dbindex']=='primary' || !in_array($row['name'], $arr))
		//if($row['dbindex']=='primary')
		{
		$x=$tg_ip.$tg_ip_type.$row['type'].$tg_ip_class.$tg_ip_name.$row['name'].$cnt.$tg_ip_size.$row['size'].$tg_ip_value;
		//if($row['type']=="idate")
			//			{
				//		$x=$x.getmydate($datarow[$row['name']]).$tg_ip_cl;
			//			$x=$x.$tg_static.getmydate($datarow[$row['name']]).$tg_static_cl.$tg_div_cl.$tg_div_cl;
				//		}else
					//	{
						$x=$x.$datarow[$row['name']]."\" readonly \"".$tg_ip_cl;
						//$x=$x.$tg_static.$datarow[$row['name']].$tg_static_cl.$tg_div_cl.$tg_div_cl;
						//}
		
		//$x=$x.$tg_static.$datarow[$row['name']].$tg_static_cl.$tg_div_cl;
                $x=$x.$tg_div_cl;
		}elseif($row['type']=="textarea")
					{
						$x=$x.$tg_text.$tg_ip_name.$row['name'].$cnt.$tg_ip_cl;
						$x=$x.$datarow[$row['name']].$tg_text_cl;
					}	
		elseif($row['type']=="option")
					{					$x=$tg_sel.$row['name'].$cnt.$tg_ip_name.$row['name'].$cnt.$tg_cl;
										//$a=$a.$tg_opt.$datarow[$row['name']].$tg_cl.$datarow[$row['name']].$tg_opt_cl;
										//if($cnt==0)
										//{
											$sql_opt="select * from field_option where tblid=".$row['tblid']." and fieldid=".$row['fieldid'];
											$result_opt=mysql_query($sql_opt);
											$opt[$j]="";
											while($row_opt = mysql_fetch_array($result_opt))
												{
												$opt[$j]=$opt[$j].$tg_opt.$row_opt['value'].$tg_cl.$row_opt['alias'].$tg_opt_cl;
												if($row_opt['value']==$datarow[$row['name']]) 
													{$alias='';$alias=$row_opt['alias'];}
												}
										//}
										//below handles code if no value is set and also instead of value shows alias
										$alias=isset($alias)?$alias:NULL;
										$x=$x.$tg_opt.$datarow[$row['name']].$tg_cl.$alias.$tg_opt_cl;
										//introducing for clear value option
										$x=$x.$tg_opt.$datarow[$row['name']].$tg_cl.$tg_opt_cl;
										$x=$x.$opt[$j].$tg_sel_cl.$tg_div_cl;
					$j++;
					}
		elseif($row['type']=="list")
					{
								$x=$tg_sel.$row['name'].$cnt.$tg_ip_name.$row['name'].$cnt.$tg_cl;
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
										$alias=(isset($alias)&&($alias!=null))?$alias:"--clear--";
										$x=$x.$tg_opt.$datarow[$row['name']].$tg_cl.$alias.$tg_opt_cl;
										//introducing for clear value option
										$x=$x.$tg_opt."".$tg_cl."--clear--".$tg_opt_cl;
										$x=$x.$opt[$j].$tg_sel_cl.$tg_div_cl;
					$j++;
					}			
		else
		{
		$x=$tg_ip.$tg_ip_type.$row['type'].$tg_ip_class.$tg_ip_name.$row['name'].$cnt.$tg_ip_size.$row['size'].$tg_ip_value;
							if($row['type']=="idate")
							{
							$x=$x.getmydate($datarow[$row['name']]);
							$x=$x.$tg_ip_id.$row['name'].$cnt.$tg_ip_class.$tg_class;
							$x=$x.$tg_ip_cl.$tg_dat.$row['name'].$cnt.$tg_dat_cl.$tg_div_cl;
							}
							else
							{$x=$x.$datarow[$row['name']].$tg_ip_cl.$tg_div_cl;}
			}
			
		if($row['span']==2)
		{$d=$d.$x;}
		else{
		if($row['col']==2)
		$b=$b.$x;
		elseif($row['col']==3)
		$c=$c.$x;
		else
		$a=$a.$x;
                
             
		}
	
		}
			 
		}
		
		}$cnt++;
                  $x=$tg_td.$tg_chk."0".$tg_chk_val."\" hidden checked=\"checked";
		$x=$x.$tg_ip_cl.$tg_td_cl;
                echo $x;
		$a=$a.$tg_div_cl.$tg_colspace.$b.$tg_div_cl;
		if($mode==3)
		$a=$a.$tg_colspace.$c.$tg_div_cl;
		if($split==1)
		$a=$a.$d.$tg_div_cl;
		$a=$a.$tg_col1.$tg_div_cl.$tg_div_cl;
	//Close Table
		//echo $tg_top_cl;
			$a=$a."<input type=\"number\" name=\"icnt\" value=$cnt style=\"display:none\">";
		$a=$a."<input type=\"hidden\" name=\"field_edit\" value=\"".implode(",",$arr)."\" >";
	
	}
	//only get pages if this is main table
	if($_GET['page']==$tbl)
        {
            $del='';$bk='';
            $nav="<div class=\"navbar navbar-default\" role=\"navigation\"><div class=\"col-md-8\">";
            $bk="<div class=\"col-md-4\"><button class=\"btn btn-default\" id=\"btn_back\" type=\"submit\" name=\"back\" value=\"back\"><span class=\"glyphicon glyphicon-chevron-left\"></span></button></div>"; 
            $upd="<div class=\"col-md-4\"><button class=\"btn btn-default\" id=\"btn_update\" type=\"submit\" name=\"updates\" value=\"update\" >Update</button></div>";
        if($_SESSION['SESS_perm']=='user')
//$del="<div class=\"col-md-4\"><button class=\"btn btn-danger\" id=\"btn_del\" type=\"submit\" value=\"delete\">Delete</button></div>";
//$a=$z."</div>".$a.$z."</div>";
        $bk='';
$nav=$nav.$bk.$upd."</div></div>";
$a=$nav.$a.$nav;
        }

//$a=$a."&nbsp<input class=\"btn btn-danger\" id=\"btn\" type=\"submit\" name=\"update\" value=\"Update\">";
return $a;
}


?>
