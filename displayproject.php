<div id="middle_right_top">
		<h2>Project Details</h2>
		</div>
		<form name="right" action="" method="POST">
		<?php
		$result = mysql_query("SELECT * FROM projecttable");

		echo "<table width=auto border=1 cellpadding=2 cellspacing=2>";
		echo "<tr><th>CHARGE CODE</th><th>PROJECT NAME</th><th>PROJECT CODE</th><th>PROJECT DESCRIPTION</th><th>START DATE</th><th>END DATE</th><th>STATUS</th></tr>";

class MyDateTime extends DateTime
{
    public function setTimestamp( $timestamp )
    {
        $date = getdate( ( int ) $timestamp );
        $this->setDate( $date['year'] , $date['mon'] , $date['mday'] );
        $this->setTime( $date['hours'] , $date['minutes'] , $date['seconds'] );
    }

    public function getTimestamp()
    {
        return $this->format( 'U' );
    }
}

		$sdat = new MyDateTime();
		$edat = new MyDateTime();
		while($row = mysql_fetch_array($result))
		{
		$sdat -> setTimestamp($row['s_date']);
		$da = $sdat-> format('Y-n-j');

		$edat->setTimestamp($row['e_date']);
		$da1 = $edat-> format('Y-n-j');

		echo "<tr>";
		echo "<td>" . $row['c_code'] . "</td>";
		echo "<td>" . $row['p_name'] . "</td>";
		echo "<td>" . $row['p_code'] . "</td>";
		echo "<td>" . $row['p_description'] . "</td>";
		echo "<td>" . $da            . "</td>";
		echo "<td>" . $da1           . "</td>";
		echo "<td>" . $row['status'] . "</td>";
		echo "</tr>";
		}
		echo "</table>";
		?>
		</form>
