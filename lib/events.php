<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$tbl=$_GET['page'];
$field_show=array();
//$COD="<script>$(document).ready(function(){";
$COD="\$rec=display_array('events','1=1',1,\$field_show);";
//$rec=display_array('events','1=1',1,$field_show);
//var_dump($rec);
//display_array('events','1=1',1,$field_show)
$COD=$COD."\$cd='';\$hd='';\$tl='';\$cnt=0;";
$COD=$COD."foreach(\$rec as \$k)
{\$j=0;\$l=0;\$tl='';\$on=0;
    if(\$k['enable']==1)
    {
    foreach(\$k as \$key=>\$val)
    {
        if(\$key=='name' && \$k[\$key]==\$tbl)
        {\$j++;//echo \$j;
        }
        if(\$key=='name' && \$k[\$key]=='global')
        {
        \$l=1;
        }
        //if event is a global and type is head
        if(\$l==1 && \$key=='type' && \$k[\$key]=='head')
        \$l=2;
        //if event is a global and type is tail
        if(\$l==1 && \$key=='type' && \$k[\$key]=='tail')
        \$l=3;
        //if event is a global and type is others script tag will be separate
        if((\$l==1 || \$j>0) && \$key=='type' && \$k[\$key]=='others')
        \$l=4;
        if(\$key=='code' && \$j>0 && (\$l==0 || \$l==1))
        {    \$cd=\$cd.\$k[\$key];
          // \$strrep=substr(\$k[\$key],strpos(\$k[\$key],'##',0)+2,strpos(\$k[\$key],'##',1)-strpos(\$k[\$key],'##',0)+3);         
          //  \$cd=str_replace('##'.\$strrep.'##',\$\$strrep,\$k[\$key]);
            \$cnt++;
        }   
        if(\$key=='code' &&  \$l==4)
           {
          //\$strrep=substr(\$k[\$key],strpos(\$k[\$key],'##',0)+2,(strpos(\$k[\$key],'##',1)-strpos(\$k[\$key],'##',0)+3));         
//echo str_replace('##'.\$strrep.'##',\$\$strrep,\$k[\$key]);
echo \$k[\$key];
           }
        if(\$key=='code' && \$l==2)   
        \$hd=\$k[\$key];
        if(\$key=='code' && \$l==3)   
        \$tl=\$k[\$key];
        
    }
    }
}
if(\$cnt>0){
echo \$hd;
echo \$cd;
echo \$tl;
}";

//eval("\$fld_show=array('code');echo display_data_text('events','id=2',1,\$fld_show);");
//$COD=$COD."});</script>";
//echo $COD;
eval($COD);

?>
