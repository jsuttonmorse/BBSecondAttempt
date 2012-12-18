<!DOCTYPE html>

<html>

<head>
	<title>Manage a League</title>
	
	<script type="text/javascript">
		function validateForm()
		{
			var x = document.forms["LeagueAddForm"]["leagueName"].value;
			alert(x);
		}
	</script>
</head>

<body>
	Under Construction.
	<div id="newLeague">
		<?php /*Check if data has been submitted to add a new league & add if if necessary*/
			$mysqli=new mysqli("localhost", "root", "root", "BloodBowl02");
			printf("Hello, if clause");
			if (isset ($_POST['leagueName'])) /*data submitted via form, so add the league*/
			{
				printf("Hi There!");
				$leagueName=($_POST['leagueName']);
				$leagueOwner=($_POST['leagueOwner']);
				$maxTeams=($_POST['maxTeams']);
				
				$result = $mysqli->query("
									call sp_leagueAdd('" .
									$leagueName . "'" .
									", '" . $leagueOwner . "'" .
									", '" . $maxTeams . "'" .
									", @message, @leagueID)
									");
				if (!$result)
				{
					printf("Query failed: %s\n", $mysqli->error);
					exit;
				}
				else
				{
					$result1 = $mysqli->query("select @message, @leagueID");
					if (!$result1)
					{
						printf("Query failed: %s\n", $mysqli->error);
						exit;
					}
					else
					{
						printf("Message: " . $row[0] . " ID: " . $row[1]);
					}
				}
				/*Now want to delete the $_POST values for leagueName, etc*/
				/*Note that if I refresh there's the option to resubmit*/
				/*Look into Post/Redirect/Get - http://en.wikipedia.org/wiki/Post/Redirect/Get*/
				
				
			}/*There was data submitted, so the league was added*/
			
		
		?><!--php to add a new league if there's data from the form-->
		
		<?php /*Check if there was data submitted to link a team to a league & create the link*/
			if(isset($_POST['teamToAdd'])) /*data submitted via form, so link the team and the league*/
			{
				//testing only
				//printf("linking team and league");
				$leagueID = $_POST['leagueToAddTo'];
				$teamID = $_POST['teamToAdd'];
				//printf("'nother test");
				/*printf($leagueID . ", " . $teamID . " call sp_leagueTeamLink( "
										. $leagueID .
										", "
										. $teamID .
										", @message)
										");*/
				$result3 = $mysqli->query("
										call sp_leagueTeamLink( "
										. $leagueID .
										", "
										. $teamID .
										", @message)
										");
				//printf("test 4");
				if (!$result3)
				{
					printf("Query failed: %s\n", $mysqli->error);
					exit;
				}
				else
				{
					$result4 = $mysqli->query("select @message");
					if (!$result4)
					{
						printf("Query failed: %s\n", $mysqli->error);
						exit;
					}
					else
					{
						printf("Message: " . $row[0]);
					}
				}
			
			}/*data was submitted, so the league & team were linked*/
		?><!--php to link a team to a league if there's data from the form-->
		
		<p>Create New League</p>	
		<form 
			method = "post" 
			action = "<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"	
			onsubmit="return validateForm()"
			name = "LeagueAddForm">
			<p>League Name: <input type="text" maxlength="50" name="leagueName"/></p>
			<p>League Owner: <input type="text" maxlength="50" name="leagueOwner"/></p>
			<p>Max Teams: <input type="text" maxlength="11" name="maxTeams"/></p>
			<input type="submit" name="leagueSubmit"/>
		</form>
	</div><!--Create new league-->
	<!--Load up the list of leagues-->
	<?php
		$mysqli = new mysqli("localhost", "root", "root", "BloodBowl02");
		$resultLeagues = $mysqli->query("
				SELECT l.LeagueID, l.LeagueName, l.leagueOwner, l.MaxTeams
				, (SELECT count(fkLeagueID) 
					FROM jtLeagueTeam WHERE 
					jtLeagueTeam.fkLeagueID = l.LeagueID) AS CurrentTeams
				FROM league l
				");
			if (!$resultLeagues)
			{
				printf("Query failed: %s\n", $mysqli->error);
  				exit;
			}
	?>
	<div id="addTeamToLeague">
		<p>Add team to league</p>
		<form
			method = "post"
			action = "<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
			onsubmit="return validateForm()"
			name="TeamAddToLeague">
			<p>Team: 
				<select name = "teamToAdd">
	<?php	//populate all teams not in a leage from table team
			
			$resultTeamNotInLeague = $mysqli->query("
				select TeamID, TeamName from team t
				left join jtLeagueTeam jt
				on t.TeamID = jt.fkTeamID
				where jt.fkTeamID is NULL
				");//pull all teams not in the team/league join table
			
			if (!$resultTeamNotInLeague)
				{
					printf("Query failed: %s\n", $mysqli->error);
					exit;
				}
			
			while(
					list ($TeamID, $TeamName)
					= $resultTeamNotInLeague->fetch_row()
					)
					{
						echo '<option value = "' . $TeamID . '">' . $TeamName . '</option>';
					}
					
	?><!--Populating the team names in the select dropdown box-->
				</select>
			</p>
	<!--Put in a list of the leagues that still have teams available-->
			<p>League: 
				<select name = "leagueToAddTo">
	<?php //populate the leagues based on a new query to pull leagues in
				$resultLeagues2 = $mysqli->query("
				SELECT l.LeagueID, l.LeagueName, l.leagueOwner, l.MaxTeams
				, (SELECT count(fkLeagueID) 
					FROM jtLeagueTeam WHERE 
					jtLeagueTeam.fkLeagueID = l.LeagueID) AS CurrentTeams
				FROM league l
				");
			if (!$resultLeagues2)
			{
				printf("Query failed: %s\n", $mysqli->error);
  				exit;
			} 
				while(list($leagueID
							, $leagueName
							, $leagueOwner
							, $maxTeams
							, $currentTeams
							)
						= $resultLeagues2 -> fetch_row()
						)
						{
							if ($maxTeams > $currentTeams)
							{
								echo '<option value = "' . $leagueID . '">' . $leagueName . '</option>'; 
							}
						}
	
	?><!--Populated the leagues based on a new query of leagues-->
			
			<input type="submit" name="teamAddToLeague"/>
		</form>
	</div><!--Adding a team to a league-->
	
	
	<!--Here's where I start outputting leagues-->
	<?php
			while (list($leagueID,
						$leagueName,
						$leagueOwner, 
						$maxTeams,
						$currentTeams
						)
					= $resultLeagues->fetch_row())
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