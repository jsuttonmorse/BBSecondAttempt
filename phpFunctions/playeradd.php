<?php
	$mysqli = new mysqli("localhost", "root", "root", "BloodBowl02");
	$query="
							call sp_PlayerAdd ('" . $_POST[paPlayerName] .
							"', " .
							$_POST[paBaseRosterID] .
							", " .
							$_POST[paTeamID] .
							", 'N', @response);
							";
	$result = $mysqli->query($query);
	if (!$result)
	{
		printf("Query failed: %s\n", $query);
  		exit;
	}
					
	$result1 = $mysqli->query("select @response;");
	$row = $result1->fetch_row();
	if (!$result1)
	{
		printf("1Query failed: %s\n", $mysqli->error);
  		exit;
	}
	$responseString = "Message: " . $row[0];
	
	echo $responseString;
	
?>

