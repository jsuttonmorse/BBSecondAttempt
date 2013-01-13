<?php
	//populate the roster IDs based on a team ID
	//open Database Connection
	$mysqli = new mysqli("localhost", "root", "root", "BloodBowl02");
	//get the team information
	$query = "
				select br.BaseRosterID
				, br.Title, br.MA, br.ST, br.AG, br.AV, br.Cost, br.RosterLimit
				from baseRoster br
				left join team t on t.fkRaceID = br.fkRaceID
				where t.TeamID = " . $_POST[TeamID];
	$result = $mysqli->query($query);
			if (!$result)
			{
				printf("Query failed: %s\n", $mysqli->error);
  				exit;
			}
	$returnArray=array();
	while (
							list($brID, $brTitle, $brMA, $brST, $brAG, $brAV, $brCost, $brRosterLimit)
							= $result->fetch_row())
	{
		$tempArray=array($brID, $brTitle, $brMA, $brST, $brAG, $brAV, $brCost, $brRosterLimit);
		array_push($returnArray, $tempArray);
//		$string= $string . ", " . $brID;	
	}
	echo JSON_encode($returnArray);	
?>