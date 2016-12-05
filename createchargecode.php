<div id="middle_right_top">
		<h2>Create Charge Code</h2>
		</div>
		<form name="form9" onsubmit="return validateForm9()" action="" method="POST">
		<table width="auto" border="1" cellpadding="2" cellspacing="2">
		  <tr><th align="left">Enter New Charge Code</th></tr>
		  <tr><td><input name="ccname" type="text" size="25" method="POST"></td></tr>
		</table>
		<br />
		<input id="btn" type="submit" name="encc" value="Submit New Charge Code">
		<?php
		if(isset($_POST['encc']))
		{
		$result = mysql_query("SELECT c_code FROM chargecode WHERE c_code = '$_POST[ccname]'");
		$row = mysql_fetch_array($result);

		if($_POST['ccname'] == $row['c_code'])
		{
		die("Charge Code Already Exist");
		}
			else
			{
			$sql = "INSERT INTO chargecode (c_code) VALUES ('$_POST[ccname]')";

			if (!mysql_query($sql,$con))
				{
				die('Error: ' . mysql_error());
				}
			if($sql)
				{
			    echo "</br>";
				echo "New Charge Code Submitted";
				}
			}
		}
		?>
		</form>