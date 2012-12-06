<!DOCTYPE html>

<html>

<head>
	<title>Manage a League</title>
</head>

<body>
	Under Construction.
	<div id="newLeague">
		<p>Create New League</p>	
	</div><!--Create new league-->
	<?php
		$mysqli = new mysqli("localhost", "root", "root", "BloodBowl02");
		$result = $mysqli->query("
				SELECT l.LeagueName, l.leagueOwner, l.MaxTeams
				, (SELECT count(fkLeagueID) 
					FROM jtLeagueTeam WHERE 
					jtLeagueTeam.fkLeagueID = l.LeagueID) AS CurrentTeams
				FROM league l
				");
			if (!$result)
			{
				printf("Query failed: %s\n", $mysqli->error);
  				exit;
			}
			while (list($leagueName,
						$leagueOwner, 
						$maxTeams,
						$currentTeams
						)
					= $result->fetch_row())
			{
			/*So far, I've opened a while loop to show all leagues*/?>
			
	<div class="league">
		<p>League Name: <?php echo $leagueName ?></p>
		<p>League Owner: <?php echo $leagueOwner ?> </p>
		<p>Teams: <?php echo $currentTeams ?> of <?php echo $maxTeams ?></p>
	</div> <!--Individual League Info -->
	
	<?php
			} /*closing the league while loop*/
			?>
		
</body>

</html>