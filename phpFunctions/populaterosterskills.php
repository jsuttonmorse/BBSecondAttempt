<?php
	//populate the skills based on a roster ID
	//open Database Connection
	$mysqli = new mysqli("localhost", "root", "root", "BloodBowl02");
	//get the team information
	$query = "
				select 
				fkBaseRosterID, e.EnhancementID, e.EnhancementTitle
				from jtPlayerEnhancement jt
				left join enhancement e on jt.fkEnhancementID = e.EnhancementID
				where jt.fkBaseRosterID=" . $_POST[RosterID];
	$result = $mysqli->query($query);
			if (!$result)
			{
				printf("Query failed: %s\n", $mysqli->error);
  				exit;
			}
	$returnArray=array();
	while (
							list($brID, $eID, $eTitle)
							= $result->fetch_row())
	{
		$tempArray=array($brID, $eID, $eTitle);
		array_push($returnArray, $tempArray);
//		$string= $string . ", " . $brID;	
	}
	echo JSON_encode($returnArray);	
?>