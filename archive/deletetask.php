<div id="middle_right_top">
		<h2>Delete Task</h2>
		</div>
		<form name="form8" onsubmit="return validateForm8()" action="" method="POST">
		  <table width="auto" border="1" cellpadding="2" cellspacing="2">
		    <tr><th align="left">Delete Task</th></tr>
		    <tr>
			<?php
		    echo "<td><select name=\"dtask\">";
		    echo "<option value=\"\">Select Task</option>";
			task();
		    echo "</select></td>";
			?>
		    </tr>
		  </table>
		  <br />
		  <input id="btn" type="submit" name="delete" value="Delete">
		<?php
		if(isset($_POST['delete']))
		{
		$val=addslashes($_POST['dtask']);
		$sql = "DELETE FROM tasktable WHERE task ='$val' LIMIT 1";

		if (!mysql_query($sql,$con))
		{
		die('Error: ' . mysql_error());
		}
		if($sql)
		{
		echo "Task Deleted";
		}
		}
		?>
		</form>
