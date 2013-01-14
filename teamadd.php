<!DOCTYPE html>

<html>

<head>
	<title>Create new team</title>
	<!--Styles-->
	<link rel="stylesheet" type="text/css" href="styles/bloodbowl.css" />
	
	<!--Javascript-->
	<script type="text/javascript">
		var rosterSlots=[];
		var rosterSkills=[];
		var teamID=0;
		var leagueID = 0;
		var raceID = 0;
//		var raceName=""

		
		function fillRoster(iRosterID, sTitle, iMA, iST, iAG, iAV, iCost, iRosterLimit)
		{
//			alert("fillRoster");
			var tempRoster=[iRosterID, sTitle, iMA, iST, iAG, iAV, iCost, iRosterLimit];
			rosterSlots.push(tempRoster);
			//testing alerts
//			alert("rosterSlots length: " + rosterSlots.length);
			//Now need to cycle through the "Skills" dropdowns and add the latest items

			var td = document.getElementsByTagName("TD");
//	alert("found tds - " + td.length);
			for (var i=0; i<td.length; i++)
			{
				if (td[i].classList.contains("position"))
				{
					//find the "select" inside
					var tdSearch = td[i].childNodes;
					if (tdSearch.length > 0)
					{
						for (var j=0; j<tdSearch.length; j++)
						{
//	alert(tdSearch[j].tagName + ", " + tdSearch[j].id);
							if (tdSearch[j].tagName=="SELECT" /*&& tdSearch[j].id=="selecttest"*/)
							{
//								alert("tdSearch[1]: " + tdSearch[1].value);
//								alert("j: " + j + ", tdSearch[j].length: " + tdSearch[j].length + ", rosterID: " + iRosterID + ", sTitle: " + sTitle);
//								tdSearch[j].options[tdSearch[j].length] = new Option(iRosterID, sTitle);
								var o = document.createElement('option');
								o.value=iRosterID;
								o.text=sTitle;
								tdSearch[j].options.add(o);
							}
							
						}
					}
				}
			}
			
			
		}
		
		function fillRosterSkills(iRosterID, iSkillID, sSkillDescription)
		{
//			alert("fillRosterSkills " + sSkillDescription + ", " + iRosterID);
			var tempSkillRoster=[];
			var skillAdded='FALSE';
			//only add this if the RosterID is in our RosterSlots
			for (var i=0; i<rosterSlots.length; i++)
			{
				if (iRosterID==rosterSlots[i][0])
				{
					tempSkillRoster=[iRosterID, iSkillID, sSkillDescription];
					rosterSkills.push(tempSkillRoster);
					skillAdded='TRUE';
				}
			}
			if (skillAdded=='FALSE')	
			{
				alert("Error: Skill not added - Roster Slot not found.");
			}
		}
		
		function updateStats(rosterSlot)
		{
//			alert("updateStats");
			//get from "RosterSlot" to the Form
			var form = rosterSlot.form;
			var iMA=1;
			var iST=1;
			var iAG=1;
			var iAV=1;
			var iCost=1;
			//get the ID of the slot
			var ID = rosterSlot.value;
			if(ID == 0)
			{
				iMA="";
				iST="";
				iAG="";
				iAV="";
				iCost="";
			}
			else
			{
			//get the values needed out of the rosterSlots array
				for (var i = 0; i<rosterSlots.length; i++)
				{
//					alert("slot: " + rosterSlots[i][0] + ", ID: " + ID);
//			/*
					if (rosterSlots[i][0]==ID)
					{
						iMA=rosterSlots[i][2];
						iST=rosterSlots[i][3];
						iAG=rosterSlots[i][4];
						iAV=rosterSlots[i][5];
						iCost=rosterSlots[i][6];
					}
				//MA
//			*/
				}
			}
//			alert("Roster Selection Changed! ID: " + ID + ", MA: "+ iMA);
	
			
			var rosterCycle=rosterSlot.parentNode.parentNode.getElementsByTagName('td');
			for (var rosterCycleCounter=0; rosterCycleCounter<rosterCycle.length; rosterCycleCounter++)
			{
				//update MA
				if (rosterCycle[rosterCycleCounter].classList.contains("MA"))
				{
					rosterCycle[rosterCycleCounter].innerHTML=iMA;
				}
				//update ST
				if (rosterCycle[rosterCycleCounter].classList.contains("ST"))
				{
					rosterCycle[rosterCycleCounter].innerHTML=iST;
				}
				//update AG
				if (rosterCycle[rosterCycleCounter].classList.contains("AG"))
				{
					rosterCycle[rosterCycleCounter].innerHTML=iAG;
				}
				//update AV
				if (rosterCycle[rosterCycleCounter].classList.contains("AV"))
				{
					rosterCycle[rosterCycleCounter].innerHTML=iAV;
				}
				//update Cost
				if (rosterCycle[rosterCycleCounter].classList.contains("Cost"))
				{
					rosterCycle[rosterCycleCounter].innerHTML=iCost;
				}
				//update skills
				if (rosterCycle[rosterCycleCounter].classList.contains("Skill"))
				{
					var concatenatedSkills ="";
					for (var tempSkillCounter=0; tempSkillCounter<rosterSkills.length; tempSkillCounter++)
					{
						if (rosterSkills[tempSkillCounter][0]==ID)
						{
							//put in ", " where relevant
							if (concatenatedSkills!="")
							{
								concatenatedSkills+=", ";
							}
							concatenatedSkills+=rosterSkills[tempSkillCounter][2];
						}
					}
					//concatenate all skills from the array
					rosterCycle[rosterCycleCounter].innerHTML=concatenatedSkills;
				}

			}
		}
		
		function savePlayer(button)
		{
//			alert("savePlayer!"/* + button.tagName*/);
			
			//for debug purposes see if I can count up to the TableRow
			var el=button;
			while (el.tagName!="TR")
			{
				el=el.parentNode;
//				el.style.backgroundColor="red";
//				alert(el.tagName);				
			}
			var cells = el.getElementsByTagName("TD");
//			alert("cells.count="+cells.length);
/*
			for (var i=0; i<cells.length; i++)
			{
//				cells[i].style.backgroundColor="blue";
			}
//*/
			//now find player name, base roster ID, and team ID
			//teamID is one of my global variables set elsewhere
			//paPlayerName + baseRosterID
			var playerName = "nameless";
			var baseRosterID  = "1";
///*
			for (var i=0; i<cells.length; i++)
			{
				if (cells[i].classList.contains("name"))
				{
///*
					//go down to the input
//					playerName = cells[i].value;
					var inputSearch=cells[i].getElementsByTagName("INPUT");
//					alert("inputSearch - " + inputSearch + ", " + inputSearch.length);
					playerName = inputSearch[0].value;
//					inputSearch[0].style.border="2px solid yellow";
//					cells[i].style.border = "2px solid red";
//					alert("player name is " + playerName);
//*/
				}
				if (cells[i].classList.contains("position"))
				{

					//go down to the select
					var selectSearch=cells[i].getElementsByTagName("SELECT")
					
						baseRosterID = selectSearch[0].value;
//						selectSearch[0].style.border="2px solid yellow";
					
//					cells[i].style.border = "2px solid red";
//*/
				}
			}
//*/
///*			
			//try figuring out the xmlhttp request
			var xmlhttp;
			xmlhttp=new XMLHttpRequest();
			xmlhttp.open("POST", "phpFunctions/playeradd.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			var postVariables="";

			postVariables+="paPlayerName="
			postVariables+=playerName;
			
			postVariables+="&paBaseRosterID="
			postVariables+=baseRosterID;

			postVariables+="&paTeamID="
			postVariables+=teamID;

//			alert(postVariables);//debug
			xmlhttp.send(postVariables);
			//end goal is to send a request to the server to add a player
			xmlhttp.onreadystatechange=function()
			{
  				if (xmlhttp.readyState==4)
   					 {
    					alert(xmlhttp.responseText);
    				}
  			}

			//Make fields for this row inactive
			freezeRow(button)
//*/			
		}
		
		function saveTeam(button)
		{
//			alert("SaveTeam!");
			//Need to collect the needed data
				//Team Name
				var teamName=document.getElementById("teamName").value;
				//TeamOwner
				var teamOwner=document.getElementById("coachName").value;
				//Race
				var teamRace=document.getElementById("teamRace").value;
//				var e = document.getElementById("teamRace");
//				raceName=e.options[e.selectedIndex].text;
//				alert("RaceName: " + raceName);
				//League
				var leagueID = document.getElementById("league").value;
//				alert("Name: " + teamName + ", Owner: " + teamOwner + ", Race: " + teamRace + ", League: " + leagueID);
			//Need to call a team add php function
			var xmlhttp;
			xmlhttp=new XMLHttpRequest();
			xmlhttp.open("POST", "phpFunctions/teamadd.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			var postVariables="";
				//team name
				postVariables+="teamName=";
				postVariables+=teamName;
				//coach name
				postVariables+="&coachName=";
				postVariables+=teamOwner;
				//team race
				postVariables+="&teamRace=";
				postVariables+=teamRace;
				//league
				postVariables+="&league=";
				postVariables+=leagueID;
//						alert(postVariables);//debug
			xmlhttp.send(postVariables);
			//end goal is to send a request to the server to add a player
			xmlhttp.onreadystatechange=function()
			  {
  				if (xmlhttp.readyState==4)
   					 {
//    					alert(xmlhttp.responseText);
    					var returnedArray=JSON.parse(xmlhttp.responseText);
//    					alert(returnedArray[0] + ", " + returnedArray[1] + ", " + returnedArray[2]);
    					//Need to make sure the Team ID, Race, League, etc are all stored somewhere to be used elsewhere
						raceID = teamRace;
						teamID = returnedArray[1];
						leagueID = leagueID;
//						alert("raceID = " + raceID + ", TeamID = " + teamID + ", League ID = " + leagueID);
						updateTeamData();
						populateRoster(teamID);
    				}
  				}
			//Need to flip the styling to "saved" mode
			//flipFormToRead(button);
			var el=button;
			while (el.tagName!="DIV")
			{
				el=el.parentNode;
//				alert(el.tagName);
			}
			flipReadOnly(el);
			
			
		}
		
		function flipReadOnly(div)
		{
			//function to take a particular div and make all the inputs/etc. read-only rather than accepting input
			//i.e. once the team has been added, display the team information without allowing edits
//			alert("flipReadOnly! " + div + ", " + div.id)
			var el = div.childNodes;
//			alert (el + ", " + el.length);
			for (var i = 0; i<el.length; i++)
			{
//				alert (el[i].tagName);
				if (el[i].tagName='DIV' && el[i].classList)
				{
//					alert(el[i].tagName + ", " + el[i].className);
					if (el[i].classList.contains('entered'))
					{
						el[i].style.display="inline"
					}
					else if (el[i].classList.contains('derived'))
					{
						el[i].style.display="inline"
					}
					else if (el[i].classList.contains('entry'))
					{
						el[i].style.display="none";
					}
				}
			}
			
		}
		
		function updateTeamData()
		{
//			alert("update Team Data!");
			var xmlhttp;
			xmlhttp=new XMLHttpRequest();
			xmlhttp.open("POST", "phpFunctions/teaminfoget.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			var postVariables="";
			postVariables+="TeamID=";
			postVariables+=teamID;
//						alert(postVariables);//debug			
			xmlhttp.send(postVariables);
			xmlhttp.onreadystatechange=function()
			  {
  				if (xmlhttp.readyState==4)
   					 {
//    					alert(xmlhttp.responseText);
    					var returnedArray=JSON.parse(xmlhttp.responseText);
//    					alert(returnedArray[0] + ", " + returnedArray[1] + ", " + returnedArray[2]);
    					var teamName=returnedArray[0];
    					var raceName=returnedArray[1];
    					var coachName=returnedArray[2];
    					var leagueName=returnedArray[3];
    					document.getElementById("teamNameEntered").innerHTML=teamName;
    					document.getElementById("raceNameEntered").innerHTML=raceName;
    					document.getElementById("coachNameEntered").innerHTML=coachName;
    					if (leagueName)
    					{
    						document.getElementById("leagueNameEntered").innerHTML=leagueName;
    					}
    				}
  				}
		}
		
		function populateRoster(teamID)
		{
//			alert("populate Roster!")
			var xmlhttp;
			var arrayCounter;
			xmlhttp=new XMLHttpRequest();
			xmlhttp.open("POST", "phpFunctions/populateroster.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			var postVariables="";
			postVariables+="TeamID="
			postVariables+=teamID;
//		alert(postVariables);
			xmlhttp.send(postVariables);
			//end goal is to send a request to the server to add a player
			xmlhttp.onreadystatechange=function()
			{
  				if (xmlhttp.readyState==4)
   					{
//    					alert(xmlhttp.responseText);
    					var returnedArray=JSON.parse(xmlhttp.responseText);
//	  					alert(returnedArray[0] + ", " + returnedArray[1] + ", " + returnedArray[2]);
						//this is the array of roster slots.  Now need to populate info with them
						for (arrayCounter=0; arrayCounter<returnedArray.length; arrayCounter++)
						{
							fillRoster(returnedArray[arrayCounter][0], //ID
										returnedArray[arrayCounter][1], //Title
										returnedArray[arrayCounter][2], //MA
										returnedArray[arrayCounter][3], //ST
										returnedArray[arrayCounter][4], //AG
										returnedArray[arrayCounter][5], //AV
										returnedArray[arrayCounter][6], //Cost
										returnedArray[arrayCounter][7] //# allowed
										);
							populateRosterSkills(returnedArray[arrayCounter][0]);
							
						}
						//putRostersInDropdowns();
    				}
  			}
		}
		
		function populateRosterSkills(rosterID)
		{
//			alert("populate skills for roster " + rosterID);
			var xmlhttp;
//			var arrayCounter;
			xmlhttp=new XMLHttpRequest();
			xmlhttp.open("POST", "phpFunctions/populaterosterskills.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			var postVariables="";
			postVariables+="RosterID="
			postVariables+=rosterID;
//		alert(postVariables);
			xmlhttp.send(postVariables);
			xmlhttp.onreadystatechange=function()
			{
  				if (xmlhttp.readyState==4)
   					 {
//  					alert(xmlhttp.responseText);
    					var returnedArray=JSON.parse(xmlhttp.responseText);
//	  					alert(returnedArray[0] + ", " + returnedArray[1] + ", " + returnedArray[2]);	
						if (returnedArray.length>0)
						{
							for (arrayCounter=0; arrayCounter<returnedArray.length; arrayCounter++)
							{
							
									fillRosterSkills(returnedArray[arrayCounter][0]
													, returnedArray[arrayCounter][1]
													, returnedArray[arrayCounter][2]
													);
							}
						}
					}
  			}
		}
		
		function freezeRow(button)
		{
//			alert("freeze row!");
			//make all fields in this row inactive & change the button label to "remove"
			
			//climb up to the row
			var el=button;
			while (el.tagName!="TR")
			{
				el=el.parentNode;
//				el.style.backgroundColor="red";
//				alert(el.tagName);				
			}
//			el.style.backgroundColor="blue";
			//make all input and select areas inactive
			var cells = el.getElementsByTagName("SELECT");
			for (var i = 0; i<cells.length; i++)
			{
				cells[i].disabled=true;
			}
			cells = el.getElementsByTagName("INPUT");
			for (i=0; i<cells.length; i++)
			{
				cells[i].disabled=true;
			}
			
			//change button text
			cells = el.getElementsByTagName("BUTTON")
			cells[0].textContent="Saved";
		}
	</script>

</head>

<body>

	Under Construction.
	<?php //check if there's any team info submitted
		$mysqli = new mysqli("localhost", "root", "root", "BloodBowl02");
	?><!--connect via myslqi-->
	
	<!--Header info-->
	<div id="teamform">
		<p>
			<div class="data label">
				Team Name: 
			</div>
			<div class="data entry">
				<input type="text" maxlength="50" name="teamName" id="teamName"/> 
			</div>
			<div class="data entered" id="teamNameEntered">
			</div>
		</p><!--Team Name-->
		<p>
			<div class="data label">
				Race: <!--Dropdown-->
			</div>
			<div class="data entry">
				<select name = "teamRace" id="teamRace" class="entry">
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
			</div>
			<div class="data entered" id="raceNameEntered">
			</div>
		</p><!--Race-->
		<p>
			<div class="data label">
				Rating: 
			</div>
			<div class="derived data">
				100 - Update Later
			</div>
		</p><!--Rating-->
		<p>
			<div class="data label">
				Treasury: 
			</div>
			<div class="derived data">
				1,000,000 - Update Later
			</div>
		</p><!--Treasury-->
		<p>
			<div class="data label">
				Coach:
			</div>
			<div class="data entry">
				 <input type="text" maxlength="50" name="coachName" id="coachName" class="entry"/>
			</div>
			<div class="data entered" id="coachNameEntered">
			</div>
		</p><!--Coach-->
		<p>
			<div class="data label">
				League (optional): 
			</div>
			<div class="data entry">
				<select name = "league" id="league" class="entry">
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
			</div>
			<div class="data entered" id="leagueEntered">
			</div>
		</p><!--League-->
		<input type = "submit" name = "teamAdd" onClick = "saveTeam(this)" class="entry"/>
	<!--Team Info Header-->
	</div><!--Ending the teamform div-->
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
		
		<!--Just testing - a single row without using the PHP loop (Roster slot 0) to test the form input stuff-->
		<tr><!--Row 0-->
				<td class="necessary number">0</td>
				<td class="necessary name"><input type="text" maxlength="50" name="playerName"/>
				</td><!--Name-->
				<td class="necessary position">
					<select name="playerPosition" onchange="updateStats(this)" >
					<!--always want one blank option-->
					<option value = "0">None</option>;
					<?php
//						echo '<script>alert("ResultRoster test");</script>';
						if ($resultRoster) //If the team has been selected then I populated a roster slot list earlier
						{
//							echo '<script>alert("'.$resultRoster->num_rows.', '.$resultRoster->field_count.'");</script>';	
							$resultRosterUse=$resultRoster;
							$resultRosterUse->data_seek(0);
							while(
									list(
											$RosterID, $title, $MA, $ST, $AG, $AV, $Cost, $RosterLimit
										)
										=$resultRosterUse -> fetch_row()
									)
							{
//								echo '<script>alert("New Option!");</script>';
								echo '<option value = "' . $RosterID . '">' . $title . '</option>';
							}//end the While cycling through roster slots	
						}
					?>
				</td><!--Position-->
				<td class="desired MA"></td><!--MA-->
				<td class="desired ST"></td><!--ST-->
				<td class="desired AG"></td><!--AG-->
				<td class="desired AV"></td><!--AV-->
				<td class="necessary skill"></td><!--Player Skills-->
				<td class="unimportant inj"></td><!--Inj-->
				<td class="unimportant comp"></td><!--Comp-->
				<td class="unimportant TD"></td><!--TD-->
				<td class="unimportant int"></td><!--Int-->
				<td class="unimportant cas"></td><!--Cas-->
				<td class="unimportant MVP"></td><!--MVP-->
				<td class="desired SPP"></td><!--SPP-->
				<td class="unimportant Cost"></td><!--Cost-->
				<td class="necessary submit">
					<button type = "button" name="Player0Add" onClick="savePlayer(this)"/>Save</button>
				</td><!--Add player button-->
		</tr><!--Player 0-->	
		<!--End testing the Row 0 in order to make form input stuff when adding the roster work-->
		<!--Loop through 16 times to set up the roster-->
		<?php //Loop to create the table
		for ($i=1; $i<=16; $i++)
		{
			?>
			<tr><!--Row <?php echo $i;?>-->
				<td class="necessary number"><?php echo $i;?></td>
				<td class="necessary name"><input type="text" maxlength="50" name="playerName"/>
				</td><!--Name-->
				<td class="necessary position">
					<select name="playerPosition" onchange="updateStats(this)" >
					<!--always want one blank option-->
					<option value = "0">None</option>;
					<?php
//						echo '<script>alert("ResultRoster test");</script>';
						if ($resultRoster) //If the team has been selected then I populated a roster slot list earlier
						{
//							echo '<script>alert("'.$resultRoster->num_rows.', '.$resultRoster->field_count.'");</script>';	
							$resultRosterUse=$resultRoster;
							$resultRosterUse->data_seek(0);
							while(
									list(
											$RosterID, $title, $MA, $ST, $AG, $AV, $Cost, $RosterLimit
										)
										=$resultRosterUse -> fetch_row()
									)
							{
//								echo '<script>alert("New Option!");</script>';
								echo '<option value = "' . $RosterID . '">' . $title . '</option>';
							}//end the While cycling through roster slots	
						}
					?>
				</td><!--Position-->
				<td class="desired MA"></td><!--MA-->
				<td class="desired ST"></td><!--ST-->
				<td class="desired AG"></td><!--AG-->
				<td class="desired AV"></td><!--AV-->
				<td class="necessary skill"></td><!--Player Skills-->
				<td class="unimportant inj"></td><!--Inj-->
				<td class="unimportant comp"></td><!--Comp-->
				<td class="unimportant TD"></td><!--TD-->
				<td class="unimportant int"></td><!--Int-->
				<td class="unimportant cas"></td><!--Cas-->
				<td class="unimportant MVP"></td><!--MVP-->
				<td class="desired SPP"></td><!--SPP-->
				<td class="unimportant Cost"></td><!--Cost-->
				<td class="necessary submit">
					<button type = "button" name="Player0Add" onClick="savePlayer(this)"/>Save</button>
				</td><!--Add player button-->
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