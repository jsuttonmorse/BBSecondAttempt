<?php
//Add a team based on variables based via post from the TeamAdd.php 
//This is just a stub php function, and a "dumb pipe"

//open Database Connection
	$mysqli = new mysqli("localhost", "root", "root", "BloodBowl02");
//Call TeamAdd sp
	$query="
							call sp_TeamAdd ('" . $_POST[teamName] .
							"', '" .
							$_POST[coachName] .
							"', " .
							$_POST[teamRace] .
							", '', ''" . //logofilepath & logoconcludefilepath
							", @response, @teamID);
							";
//	echo ("alert('" . $query . "')");
	$result = $mysqli->query($query);
			if (!$result)
			{
				printf("Query failed: %s\n", $mysqli->error);
  				exit;
			}
	$response = $mysqli->query("select @response, @teamID;");
			if (!$response)
			{
				printf("Query failed: %s\n", $mysqli->error);
  				exit;
			}
	$row=$response->fetch_row();
	$teamMessage=$row[0];
	$teamID = $row[1];
//	echo "alert('Message: " . $row[0] . ", ID: " . $row[1] . "')"); //debugging only

//League link(?)
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
//				echo("alert('Message: " . $row[0] . "')");//debugging only
				$leagueMessage=$row[0];
			}//League and team also joined



//return message from the server
//	echo $teamMessage . "||" . $teamID . "||" . $leagueMessage;
	$returnArray = array($teamMessage, $teamID, $leagueMessage);
	echo JSON_encode($returnArray);

?>