 <?php
function mymail($event='approval',$empid,$val4)
		{
		$temp = mysql_query("select email_id,empname,mgrid from usertable where empid='$empid'");
		$row = mysql_fetch_array($temp);

		$to = $row['email_id'];
		/*$to = "nadeem.ansari@inputzero.com";*/
		$subj = "$_SESSION[SESS_ename] has ".$event." the timesheet";
		$headers = 'From: noreply@inputzero.com';
		$txt = "Hi $row[empname],"."\n"."\n".

		"Your time sheet for the weekend $val4 has been ".strtoupper($event)."\n".
		"This is a system generated mail. Please do not respond.\n\nThanks,\nnoreply@inputzero.com";

		// Use wordwrap() if lines are longer than 70 characters
		$txt = wordwrap($txt,100);

		// Send email
		$true = mail($to, $subj, $txt, $headers);

		if($true==1)
		{
		return "Notification Mail Sent".$txt.$to.$subj;
		}
		else {return "Unable to Send Notification Mail".$txt.$to.$subj;}
		}
		
function datasearch($search=NULL,$qual)
{
$sql_filter="";
$sql="";
//if(isset($_POST['string']))
//{
//$search=$_POST['string'];
//$search=cleanup($search);
//}
$sql_filter="";
if(isset($search))
{
$search=strtolower($search);
$sql_filter=" and page_filter like '%$search%'";
$search=cleanup($search);
}
$sql="select id,catid,page_filter,page,title,status from pages where ";
$sql_mid=" status='published'";
$sql_limit=" limit 10";

if(isset($qual))
{$sql=$sql.$qual;
echo " ";}

$sql=$sql.$sql_mid.$sql_filter.$sql_limit;

//echo $sql;
if(!$result=mysql_query($sql))
{
echo "Result not returned properly ".mysql_error();
echo $search." not found in any post";
}else
{
	$cat=category();
	echo "<ul>";
	while($row=mysql_fetch_array($result))
	{

	echo "<li><a href=\"home.php?page=update&id=".$row['id']."\"><b>".$cat[$row['catid']]."</b></a></li>";
	echo "<b>".strtoupper($row['title'])."</b>";
	$j=stripos($row['page_filter'],$search);
	if( false !== $j )
	{
	$k=strlen($search);

	$i=$j;$cnt=0;
	$str=substr($row['page_filter'],0,$i);
	while($i>0 && $cnt<15)
	{
	$i--;$cnt++;
	$str=substr($str,0,$i);
	$i=strrpos($str," ");
	//echo " ".$i." cnt=".$cnt;
	//echo substr($row['page_filter'],0,$j+$k);
	//echo "<br />";
	}
	echo "<p>".substr($row['page_filter'],$i,$j-$i);
	echo "<b>".substr($row['page_filter'],$j,$k)."</b>";

	echo substr($row['page_filter'],$j+$k,$j+$k-$i+200)."....</p>";
	}else {echo "<p>".substr($row['page_filter'],0,200)."....</p>";}
//echo "<br />".$row['pge']."</a>";
	}
	echo "</ul>";
}
//else echo "nothing to search";
}

function createpage()
{
//Set Category
$category=isset($_GET['catname'])?$_GET['catname']:1;
echo "<input type=\"hidden\" name=\"catid\" value=\"".$category."\" />";

//call category function to retrieve cat names based on catid
$cat=category();
echo "<h2>".strtoupper($cat[$category])."</h2>";

//Set Title
echo "<h3>Title:</h3>".'<input type="text" name="title" id="title" size="95" value="" required/>';
echo "<br /><br />";
echo "<textarea id=\"message\" name=\"message\" rows=\"15\" cols=\"80\">enter</textarea>";

if (get_magic_quotes_gpc()) $_POST = array_map('stripslashes', $_POST);

$catid = isset($_POST['catid']) ? $_POST['catid'] : 1;
$message = isset($_POST['message']) ? addslashes($_POST['message']) : 'Message';
$title=isset($_POST['title']) ? addslashes($_POST['title']) : 'Title';
$title=cleanup($title);
$message_filter=cleanup($message);
$message_filter=strtolower($cat[$category])." ".$title.$message_filter;

if(isset($_POST['submit']))
{

$tbl="pages";
$time=time();

$sql="insert into $tbl (catid,page,page_filter,status,author,time,link,title,modified_by) values($catid,'$message','$message_filter','draft','$_SESSION[SESS_uname]',$time,0,'$title','$_SESSION[SESS_uname]')";
//extractimage($message);
if(!$result=mysql_query($sql))
{ die(mysql_error());
}

}
echo "<input class=\"btn btn-primary\" name=\"submit\" type=\"submit\" value=\"Submit\" />";
}

function cleanup($msg)
{
$msg= strip_tags(html_entity_decode($msg));
//$msg=preg_replace('|[^a-zA-Z0-9_.,\s\t\r]|', '', $msg);
$msg=preg_replace('|[^a-zA-Z0-9_.,]([\s\t\r\n]+)|', '', $msg);
//$msg=preg_replace("|[']|", "", $msg);
$msg=strtolower ( $msg );
return $msg;
}

function extractimage($message)
{
$message=stripslashes($message);
$i=0;
while(strpos($message,'<img'))
{
$k=strpos($message,'<img');
$j= stripos($message,'/>',$k);
//echo "start of img ".$k."till position".$j."total length ".strlen($message);
//$sub1=substr($message,$k-1,$j);
$sub1=substr($message,$k,$j-$k+2);
//echo htmlentities($sub1);
echo $sub1;
$message=substr($message,$j+1,strlen($message)-$j+1);
//echo $message;
$i++;
}
//echo addslashes($sub1);
$sub2=strstr($sub1,'/>',true)."/>";
//echo $sub2;
//echo substr($sub1,1,strstr($sub1,'/>')+2);
// and now we print out all the images
//preg_match_all('/< img.+ src = [\'"](?P< src >.+)[\'"].*>/i', $message, $images);
//$path="C:/wamp/www/editor/tinymce/uploads/";
//$ext=".jpeg";
//$fname=$path.md5((mt_rand(10,10000000000000))).$ext;
//$data=$sub1;
//$data = base64_decode($data);
//$im = imagecreatefromstring($data);
//if ($im !== false) {
  //  header('Content-Type: image/jpeg');
  //imagejpeg($im,$fname);
//    imagedestroy($im);
//}
// lets see the images array
//print_r( $images['src'] );
//echo $message_filter;
//echo htmlentities($sub1);
//echo htmlentities($message);
//preg_match_all("|<img(.*)/>|", $message, $match,PREG_PATTERN_ORDER);
//print_r($match);
//foreach($match as $val)
//{$i=0;
//echo "<img ".stripslashes($val[0][$i])." />";$i++;}
//echo "<img ".stripslashes($match[0][1])." />";
//echo stripslashes($match[1][0]);

}

function category($out='catname')
{
$sql="select id,catname from category";
$result=mysql_query($sql) or die(mysql_error());
while($row_cat = mysql_fetch_array($result))
{
if($out=='catid')
$cat[$row_cat['catname']]=$row_cat['id'];
else
$cat[$row_cat['id']]=$row_cat['catname'];
}
return $cat;
}

function search()
{
echo "<input type=\"text\" name=\"qual\" value=\"\" />";
$qual=isset($_POST['qual'])? $_POST['qual']." and status='draft'":"status='draft'";
if(isset($_POST['qual']))
{
$qual=$_POST['qual'];
while(strpos($qual,'time'))
{$k=strpos($qual,'time');
$j= stripos($qual,'"',$k);
$p= stripos($qual,'"',$k+$j);
$sub=substr($qual,$j+1,$p);
echo $sub;
$qual=str_replace($sub,setmydate($sub),$qual);
echo $qual;
}
}
}
function getPagelink_1($iteration)
	{$x=1;$j=1;
        if(isset($_GET['num'])){$j=$_GET['num'];}
      
	echo "<ul class=\"pagination\"><li><a onclick=\"openPage(".$x.",'".$_GET['page']."');\" href=\"#\">&laquo;</a></li>";
	for($i=1;$i<=$iteration;$i++)
	{ 
            //  echo "j is $j";
            echo "<li><a ";
            if($i==$j) echo " class=\"active\" ";
            echo "onclick=openPage(".$i.",'".$_GET['page']."'".") href=\"#\"";
	echo ">".$i."</a></li>";
	}$x=$i-1;echo "<li><a onclick=\"openPage(".$x.",".$_GET['page'].");\" href=\"home.php?page=".$_GET['page']."&num=".$x."\">&raquo;</a></li></ul>";
	}
 
function getPagelink($iteration)
	{
	echo "<ul class=\"pagination\"><li><a href=\"#\">&laquo;</a></li>";
	for($i=1;$i<=$iteration;$i++)
	{ echo "<li><a href=home.php?page=".$_GET['page']."&num=".$i;
	echo ">".$i."</a></li>";
	}$x=$i-1;echo "<li><a href=\"home.php?page=".$_GET['page']."&num=".$x."\">&raquo;</a></li></ul>";
	}

function getPagesql($sql,$rec_limit)
	{

		$start=0;

		$result_page=mysql_query($sql);
		$total=mysql_num_rows($result_page);

		if(isset($_GET['num']))
		{$start=(($_GET['num'])-1)*$rec_limit;

		}
		if(ceil($total/$rec_limit)>1)
		getPagelink_1(ceil($total/$rec_limit));
		$sql=$sql." limit ".$start.", ".$rec_limit;
		return $sql;
	}

function getmydate($time)
{
$tdate = date_create();
date_timestamp_set($tdate,$time);
return date_format($tdate, 'd-m-Y');
}
function getmytime($time)
{
$tdate = date_create();
$time=$time+19800;
date_timestamp_set($tdate,$time);
return date_format($tdate, 'd-m-Y H:i:s');
}
function setmydate($time)
{
$ts1 = date_create($time);
return date_format($ts1,'U');
}


function comments($pageid)
{
$db_name="editor";
$tbl1="comments";
if(isset($_POST['comment']) && isset($_POST['com']))
 {
  insert_data('comments');


//echo "<meta http-equiv=\"refresh\" content=\".1\">";

 // header("location: home.php?page=update&id=$pageid");
//echo "<meta http-equiv='refresh' content='0;url=home.php?update&id=$pageid'>";
//exit();
}
$sql="select id,comment,author,time from $tbl1 where pageid=$pageid";
$time=time();
$i=1;
if($result=mysql_query($sql))
{
while($row=mysql_fetch_array($result))
{

echo "<p>";
echo "<b>".'Comment'.$i."."."</b>";
echo "<br />commneted by :".$row['author'];
echo "<br />at :".getmytime($row['time']);
echo "<br />".$row['comment'];
echo"</p>";
echo "<hr/>";
$i++;
}
}else{
 die(mysql_error());
}
//if($status!='draft')
{
echo "<form role=\"form\" name=\"form1\" id=\"frm1\" action=\"home.php?page=update&id=$pageid\" method=\"POST\">";
echo "<p><h3>Leave a comment</h3><br />";
echo  "<b>Message:</b>&nbsp;<textarea name=\"comment\" rows=\"4\" cols=\"40\" required></textarea>";
echo  "<br /><input type=\"hidden\" name=\"author\" value=\"".$_SESSION['SESS_uname']."\">";
echo  "<br /><input type=\"hidden\" name=\"time\" value=\"".time()."\">";
echo  "<br /><input type=\"hidden\" name=\"pageid\" value=\"".$pageid."\">";
echo "<input class=\"btn btn-primary\" name=\"com\" type=\"submit\" value=\"comment\" /></p>";
echo "</form>";
}
}

function edit($pageid,$mod){

//include('rowaccess.php');
if (get_magic_quotes_gpc()) $_POST = array_map('stripslashes', $_POST);

$subject = isset($_POST['subject']) ? $_POST['subject'] : 'Subject';
$message = isset($_POST['message']) ? addslashes($_POST['message']) : 'Message';
$title = isset($_POST['title']) ? addslashes($_POST['title']) : 'Title';

$message_filter=cleanup($message);
$message_filter=cleanup($message);
$message_filter=strtolower($cat[$category])." ".$title.$message_filter;


$db_name="editor";
$tbl="pages";



if(isset($_POST['submit']))
{
	$dd=$_POST['id'];
	$cat=category('catid');
	echo $subject;

	$d='draft';
	$time=time();
//echo "Post author is :".$_POST['author1'];
//echo "session name is :".$_SESSION['SESS_uname'];
//echo " authorinsubmit= ".$author;

	if($_POST['author1']==$_SESSION['SESS_uname'])
	{

	$date=time();
	$sql="update $tbl set page='$message',page_filter='$message_filter',time='$date',modified_by='$_SESSION[SESS_uname]'where id='$pageid'";
	//echo $sql;
		if(!$result=mysql_query($sql))
		{ die(mysql_error());
		}//end if
	}else
	{
	$sql="INSERT INTO $tbl (catid,page,page_filter,status,author,time,link,title) VALUES ('$cat[$subject]','$message','$message_filter','$d','$_SESSION[SESS_uname]','$time','$dd','$title') ";
if(!$result=mysql_query($sql))
		{ die(mysql_error());
		}//end if
}
}
	$sql="select id,title,catid,page,page_filter,status,author,time,modified_by,flag from $tbl where id=$pageid";
	$cat=category();
	if($result=mysql_query($sql))
	{
		while($row=mysql_fetch_array($result))
		{
			if(isset($_POST['edit']))
			{
			echo "author<input type=\"hidden\" name=\"author1\" value=\"".$row['author']."\" />";
			echo "<h2>".strtoupper($cat[$row['catid']])."</h2>";
			echo  '<textarea id="message" name="message" rows="15" cols="80">'.$row['page'].'</textarea>';
			echo  "<input type=\"hidden\" name=\"subject\" value=\"".$cat[$row['catid']]."\" />";
			echo "<input type=\"hidden\" name=\"id\" value=\"".$row['id']."\" />";
			echo "<input type=\"hidden\" name=\"title\" value=\"".$row['title']."\" />";

			echo "<input class=\"btn btn-primary\" name=\"submit\" type=\"submit\" value=\"Submit\" />";
			}else
			{

			echo "<input type=\"hidden\" name=\"author\" value=\"".$row['author']."\" />";
			echo "<h2>".strtoupper($cat[$row['catid']])."</h2>";
			echo "<b>Title :".$row['title']."</b>";
			echo "<br />";
			echo "<b>Author :".$row['author']."</b>";
			echo "<br /><b>Last Update time :".getmytime($row['time'])."</b>";
			echo "<br /><b>Last Update by :".$row['modified_by']."</b>";
			echo "<br />".$row['page'];
			if(	$_SESSION['SESS_uname']==$row['author'] || $mod==1 || !$row['status']=='draft' || $_SESSION['SESS_perm']=='admin')
			echo "<input class=\"btn btn-primary\" name=\"edit\" type=\"submit\" value=\"Edit\" />";
			echo "<hr/>";
			echo "<p>";
			echo "</p>";

			}
		$flag=$row['flag'];
		return $flag;
		}
	}

}

function show()
{

$db_name="editor";
$tbl="pages";

$pageid=isset($_GET['id'])?$_GET['id'] : 3;
$sql="select id,title,catid,page,page_filter,status,author,time,modified_by from $tbl where id=$pageid";
$cat=category();
if($result=mysql_query($sql))
{
while($row=mysql_fetch_array($result))
{
if(isset($_POST['edit']))
{//echo '<input type="text" name="subject" value="'.$cat[$row['catid']].'" />';
echo "<h2>".strtoupper($cat[$row['catid']])."</h2>";
echo  '<textarea id="message" name="message" rows="15" cols="80">'.$row['page'].'</textarea>';
echo  "subject<input type=\"text\" name=\"subject\" value=\"".$cat[$row['catid']]."\" />";
echo '<input type="hidden" name="id" value="'.$row['id'].'" />';
echo '<input type="text" name="title" value="'.$row['title'].'" />';

echo "<input class=\"btn btn-primary\" name=\"submit\" type=\"submit\" value=\"Submit\" />";
}elseif(!(isset($_POST['edit'])) || isset($_POST['search']))
{


echo "<h2>".strtoupper($cat[$row['catid']])."</h2>";
echo "<b>Title :".$row['title']."</b>";
echo "<br />";
echo "<b>Author :".$row['author']."</b>";
echo "<br /><b>Last Update time :".getmytime($row['time'])."</b>";
echo "<br /><b>Last Update by :".$row['modified_by']."</b>";
echo "<br />".$row['page'];

//if(isset($_SESSION['SESS_uname']=='admin'))
//{
if($row['status']!='draft' || $_SESSION['SESS_uname']=='admin' || $_SESSION['SESS_uname']==$author)
echo "<input class=\"btn btn-primary\" name=\"edit\" type=\"submit\" value=\"Edit\" />";//}
echo "<hr/>";
echo "<p>";
echo "</p>";
//return array($row['id'],$row['catid'],$cat[$row['catid']],$row['page'],$row['title'],$row['status']);
}
}}

}
function enc()
{
$key_value = "123321";
$plain_text = "YqvjywySafVDSDej";
$encrypted_text = mcrypt_ecb(MCRYPT_DES, $key_value, $plain_text, MCRYPT_ENCRYPT);


$decrypted_text = mcrypt_ecb(MCRYPT_DES, $key_value, $encrypted_text, MCRYPT_DECRYPT);
return $decrypted_text;
}

?>