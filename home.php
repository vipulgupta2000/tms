<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Time Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

	<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
	<!--script src="js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
<link rel="stylesheet" type="text/css" href="css/templateblue.css" />
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="img/favicon.png">

	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
</head>

<body>
	<?php
		require_once("auth.php");
		?>
<div class="row" id="top">
	<div class="col-md-3 col-xs-6"><img id="img" src="images/logo.png" alt="Input Zero" />
	</div>
	<div class="col-md-7 col-xs-6">
		<h2>Welcome To Time Management<h2>
	</div>
</div>
<div class="navbar navbar-default" role="navigation">
     <div class="navbar-collapse collapse">
     <div class="col-md-10 col-xs-10"> </div>
     <ul class="nav navbar-nav">
			<li><a href="home.php?page=text.php">Home</a></li>
			<li><a href="logout.php">Logout</a></li>
			<?php //include("lib/menu.php"); ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
	<script> $('#myTab a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
jQuery(document).ready(function($) {
      $(".clickableRow").click(function() {
            window.document.location = $(this).attr("href");
      });
});
</script>
<div class="row clearfix">
		<div class="col-md-12 col-xs-12 column">

						<div class="row clearfix">
							<div class="col-md-3 col-xs-12 column well">
							<?php 	include("lib/menu.php");
                                                        //include("left.php");
		include("datefunc.php");
		//include("lib/utils.php");
		
		?>
				</div>
			<div class="col-md-8 col-xs-12 column">
						<?php

							echo "<form id=\"form1\" name=\"form1\" action=\"\" onsubmit=\"return validateForm1()\" method=\"POST\">";
							//include($_GET['page']);
include("lib/insert.php");
							echo "</form>";
					?>
				</div>

			</div>

		</div>
	</div>
			<div class="panel panel-default">

				<div class="panel-footer">
					<div class="col-md-5 col-xs-12"> </div> &copy;Input Zero Technologies Pvt. Ltd
				</div>
			</div>
<script language="javascript" type="text/javascript" src="datetimepick/datetimepicker.js"></script>
<script language="javascript" type="text/javascript" >
document.forms["frm1"].chb.onchange= function(){
var j = document.getElementById("<?php echo $tbl; ?>").rows.length-1; 
for(i=0;i<j;i++) { 
    var z=document.forms["frm1"].elements["chb"+i].checked=eval(document.forms["frm1"].chb.checked);  
   }
} 
</script>
<script>
function openPage($var,$tb)
{
var x=$var;
var t=$tb;
document.forms["frm1"].action="home.php?page="+t+"&num="+x;
document.forms["frm1"].submit();
}
    </script>
<script language="javascript" type="text/javascript" src="script/xml.js"></script>
<script language="javascript" type="text/javascript" src="script/basic.js"></script>
</body>
</html>
