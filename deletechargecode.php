<div id="middle_right_top">
		<h2>Delete Charge Code</h2>
		</div>
		<form name="form10" action="" onsubmit="return validateForm10()" method="POST">
		  <table width="auto" border="1" cellpadding="2" cellspacing="2">
		    <tr><th align="left">Select Charge Code</th></tr>
		    <tr>
			<?php
		    echo "<td><select name=dcode>";
		    echo "<option value=\"\">Select Code</option>";
			ccode();
		    echo "</select></td>";
			?>
		    </tr>
		  </table>
		  <br />
		  <input id="btn" type="submit" name="delete" value="Delete">
		<?php
		if(isset($_POST['delete']))
		{
		$val=addslashes($_POST['dcode']);
		$sql = "DELETE FROM chargecode WHERE c_code ='$val' LIMIT 1";
		if (!mysql_query($sql,$con))
		{
		die('Error: ' . mysql_error());
		}
		if($sql)
		{
		echo "</br>";
		echo "Charge Code Deleted";
		}
		}
		?>
		</form>