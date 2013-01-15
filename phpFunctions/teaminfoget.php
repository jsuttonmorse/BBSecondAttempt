<?php
	//open Database Connection
	$mysqli = new mysqli("localhost", "root", "root", "BloodBowl02");
	//get the team information
	$query = "call sp_TeamInfoGet(".$_POST[TeamID].")";
	$result = $mysqli->query($query);
			if (!$result)
			{
				printf("Query failed: %s\n", $mysqli->error);
  				exit;
			}
	$row=$result->fetch_row();
	$returnArray=array($row[0], $row[1], $row[2], $row[3], $row[4]);
	echo JSON_encode($returnArray);
	
?>