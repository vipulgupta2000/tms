<html>
<head>
<script language="javascript" type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{
			try{
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
    }

	function getcode(chargecode) {
		var strURL="page2.php?chargecode="+chargecode;
		var req = getXMLHTTP();
		if (req) {
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {
						document.getElementById('projectdiv').innerHTML=req.responseText;
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}
			}
			req.open("GET", strURL, true);
			req.send(null);
		}
	}
	</script>
	</head>

	<body>
	<form method="post" action="" name="form1">
	<table width="60%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="150">Charge Code</td>
	    <td width="150"><select name="chargecode" onChange="getcode(this.value);">
		<option value="">Select Charge Code</option>
		<?php
		ccode();
		?>

	    </select></td>
	  </tr>
	  <tr style="">
	    <td>Project</td>
	    <td ><div id="projectdiv">
	    <select name="project" >
		<option>Select Project</option>
	    </select></div></td>
	  </tr>
	</table>
	</form>
	</body>
</html>

	<?php
		function ccode()
		{
		$con=mysql_connect("localhost","root","");
		if(!$con)
		{
		die('Could Not Connect'.mysql_error());
		}
		mysql_select_db("tms_lms",$con);
		$result=mysql_query("select DISTINCT c_code from projecttable");
		while($row=mysql_fetch_row($result))
		{
		echo "<option value=\"{$row[0]}\">{$row[0]}</option>";
		}
		}
		?>




