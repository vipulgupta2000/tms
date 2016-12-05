<div id="middle_right_top">
		<h2>Create Task</h2>
		</div>
		<form name="form7" onsubmit="return validateForm7()" action="" method="POST">
		<table width="auto" border="1" cellpadding="2" cellspacing="2">
		  <tr><th align="left">Enter New Task</th></tr>
		  <tr><td><input name="tname" type="text" size="25" method="POST"></td></tr>
		</table>
		<br />
		<input id="btn" type="submit" name="entn" value="Submit New Task">
		<?php
		if(isset($_POST['entn']))
		{
		$result=mysql_query("SELECT task FROM tasktable WHERE task='$_POST[tname]'");

		$row=mysql_fetch_array($result);
		if($_POST['tname']==$row['task'])
		{
		die("Task Already Exist");
		}
			else
			{
			$sql1 = "INSERT INTO tasktable (task) VALUES ('$_POST[tname]')";

			if (!mysql_query($sql1,$con))
				{
				die('Error: ' . mysql_error());
				}
			if($sql1)
				{
				echo "</br>";
				echo "New Task Submited";
				}
			}
		}
		else
		?>
		</form>