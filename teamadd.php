<!DOCTYPE html>

<html>

<head>
	<title>Create new team</title>
	<!--Styles-->
	<link rel="stylesheet" type="text/css" href="styles/bloodbowl.css" />
	
	<!--Javascript-->

</head>

<body>

	Under Construction.
	<?php //check if there's any team info submitted
		$mysqli = new mysqli("localhost", "root", "root", "BloodBowl02");
		//*
		IF(ISSET($_POST[teamName]))
		{
			$query = "call sp_teamAdd('" .
								$_POST[teamName] .
								"', '" .
								$_POST[coachName] .
								"', '" .
								$_POST[teamRace] .
								"', '', ''" . //logo file paths
								", @response, @teamID);";
//			printf($query); //debugging
			$result = $mysqli->query($query);
			if (!$result)
			{
				printf("Query failed: %s\n", $mysqli->error);
  				exit;
			}
			$result1 = $mysqli->query("select @message, @teamID;");
			$row = $result1->fetch_row();
			if (!$result1)
			{
					printf("1Query failed: %s\n", $mysqli->error);
  					exit;
			}
//			echo("Message: " . $row[0] . " ID: " . $row[1]); //debugging only
		//*
//			echo("Post: " . $_POST[league]);
			IF($_POST[league]!="X")//League was set so add the team to the league
			{
				$resultLeague = $mysqli->query("call sp_LeagueTeamLink(" .
										$_POST[league] .
										", " .
										$row[1] .
										", @response);"
										);
				if (!$resultLeague)
				{
					printf("2Query failed: %s\n", $mysqli->error);
  					exit;
				}
				$result1 = $mysqli->query("select @response;");
				$row = $result1->fetch_row();
				if (!$result1)
				{
						printf("3Query failed: %s\n", $mysqli->error);
  						exit;
				}
//				echo("Message: " . $row[0]);//debugging only
				
			}//League and team also joined
		//*/
		
		}//Team name was submitted, so need to add the team
		//*/
	
	?><!--Checking if team info was submitted & updating if so-->
	<!--Header info-->
	
	<form
			method = "post" 
			action = "<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"	
			name = "TeamAddForm">
		<p>Team Name: <input type="text" maxlength="50" name="teamName"/></p>
		<p>Race: <!--Dropdown-->
			<select name = "teamRace">
			<?php
				//populating the race ID fields from table race

				$result = $mysqli->query("
				SELECT RaceID, RaceName 
				FROM race
				");
				if (!$result)
					{
						printf("Query failed: %s\n", $mysqli->error);
  						exit;
					}
				while (
						list($RaceID, $RaceName) 
						= $result->fetch_row())
				{
					echo '<option value = "' . $RaceID . '">' . $RaceName . '</option>';
				}
			?>
			</select>
		</p>
		<p>Rating: </p> 
		<p>Treasury: </p>
		<p>Coach: <input type="text" maxlength="50" name="coachName"/></p>
		<p>League (optional): 
			<select name = "league">
				<option value="X">Unaffiliated</option>
			<?php
				//populating the league fields from all leagues with space still available
				$result=$mysqli->query("
									SELECT l.LeagueID, l.LeagueName, l.leagueOwner, l.MaxTeams
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
					while(list($leagueID
								, $leagueName
								, $leagueOwner
								, $maxTeams
								, $currentTeams
								)
							= $result -> fetch_row()
							)
							{
								if ($maxTeams > $currentTeams)
								{
									echo '<option value = "' . $leagueID . '">' . $leagueName . '</option>'; 
								}
							}
			?>
			</select>
		</p><!--League-->
		<input type = "submit" name = "teamAdd"/>
	</form><!--Team Info Header-->
	<!--Roster-->
	<div class="roster">
	<table>
		<tr><!--Header Row -->
				<th class="necessary">#</th>
				<th class="necessary">Player Name</th>
				<th class="necessary">Position</th>
				<th class="desired">MA</th>
				<th class="desired">ST</th>
				<th class="desired">AG</th>
				<th class="desired">AV</th>
				<th class="necessary">Player Skills</th>
				<th class="unimportant">Inj</th>
				<th class="unimportant">Comp</th>
				<th class="unimportant">TD</th>
				<th class="unimportant">Int</th>
				<th class="unimportant">Cas</th>
				<th class="unimportant">MVP</th>
				<th class="desired">SPP</th>
				<th class="unimportant">Cost</th>
				<th class="necessary">Add</th>
			</tr><!--Header row-->
		<!--Loop through 16 times to set up the roster-->
		<?php //Loop to create the table
		for ($i=1; $i<=16; $i++)
		{
			?>
			<tr><!--Row <?php echo $i;?>-->
				<td class="necessary"><?php echo $i;?></td>
				<td class="necessary"></td><!--Name-->
				<td class="necessary"></td><!--Position-->
				<td class="desired"></td><!--MA-->
				<td class="desired"></td><!--ST-->
				<td class="desired"></td><!--AG-->
				<td class="desired"></td><!--AV-->
				<td class="necessary"></td><!--Player Skills-->
				<td class="unimportant"></td><!--Inj-->
				<td class="unimportant"></td><!--Comp-->
				<td class="unimportant"></td><!--TD-->
				<td class="unimportant"></td><!--Int-->
				<td class="unimportant"></td><!--Cas-->
				<td class="unimportant"></td><!--MVP-->
				<td class="desired"></td><!--SPP-->
				<td class="unimportant"></td><!--Cost-->
				<td class="necessary"></td><!--Add player button-->
			</tr><!--Player <?php echo $i; ?>-->	
		<?php 	
		}
		?>
	</table>
	</div><!--Roster-->
	
	
	
	<!--Footer stuff-->
	Re-Rolls:
	Fan Factor:
	Assistant Coaches:
	Cheerleaders:
	Apothecary:
	Wizard:
	Total Cost of Team:

</body>

</html>