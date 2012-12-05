<!DOCTYPE html>

<html>
<head>
<!--Title-->
	<title>Game on!</title>
<!--Styles-->
	<link rel="stylesheet" type="text/css" title="main" href="styles/bloodbowl.css">
	<link rel="stylesheet" type="text/css" title="mobile" href="styles/bloodbowlmobile.css">
	<link rel="stylesheet" type="text/css" title="testing" href="styles/test.css">
	
<!--Scripts-->
	<script type="text/javascript">
	var team1 = ["Reikland Reavers", 3, 0]; /*Name, re-rolls, score*/
	var team2 = ["Athelorn Avengers", 2, 0]; /*Name, re-rolls, score*/
	var teams = [team1, team2];
	
	
	function playgame()
	{
		/*This is just going to advance the turns 1-8 and halves 1-8*/
		var half;
		var turn;
		var activeTeam;
		var justScored=1;
		
		
		for (half=1; half<=2; half++)
		{
			setup(1); 
			for (turn=1; turn<=8; turn++)
			{
				for (activeTeam=0; activeTeam<=1; activeTeam++)
				{

					justScored=prompt("Half " + half + " and turn " + turn + " for team " + teams[activeTeam][0] + ".  Did either team score?", "0 indicates team 1 scored & 1 indicates team 2 scored.");
					if (justScored==0 || justScored==1)
					{
						teams[justScored][2]++;
						alert(teams[justScored][0] + " scored on half " + half + " and turn " + turn + ". The current score is: " + teams[0][2] + " - " + teams[1][2] + ".");
						if (activeTeam!=justScored)
						{
							alert("Oddly, " + teams[justScored][0] + " scored on " + teams[activeTeam][0] + "'s turn. Advance the turn marker.");
							if (activeTeam==0)
							{
								activeTeam=1;
							}
							else
							{
								activeTeam=0;
								turn++;
							}
						}
						setup(justScored);
					}
				}/*Active team loop between 1 & 2*/
			}/*Turns 1-8*/
			teams.reverse();
		}/*Halfs 1 and 2*/
	}/*End function playgame*/
	
	function setup(kickingTeam)
	{
		var receivingTeam;
		if (kickingTeam==0)
		{
			receivingTeam=1;
		}
		else
		{
			receivingTeam=0;
		}
		
			
		/*Set up the receiving team*/
		alert("set up the receiving team: " + teams[receivingTeam][0]);
		
		/*set up the kicking team*/
		alert("set up the kicking team: " + teams[kickingTeam][0]);
	}/*End function setup*/
	</script>
	
</head>

<body>
	<button onclick="playgame()">Play!</button>
	<!--Divs for the basic sections-->
	<div class="board" id="board">
	
	Board
	</div><!--board-->
	
	
	<div class="turns team one">
	Turns team one
	</div><!--turns team one-->
	
	
	<div class="turns team two">
	Turns team two
	</div><!--turns team two-->
	
	
	<div class="reroll team one">
	Reroll team one
	</div><!--reroll team one-->
	
	
	<div class="reroll team two">
	Reroll team two
	</div><!--reroll team two-->
	
	
	<div class="score team one">
	Score team one
	</div><!--score team one-->
	
	
	<div class="score team two">
	Score team 2
	</div><!--score team two-->
	
	
	<div class="dugout team one">
	Dugout Team 1
	</div><!--dugout team one--->
	
	
	<div class="dugout team two">
	Dugout Team 2
	</div><!--dugout team two-->
	
	
	<div class="knockout team one">
	KO Team 1
	</div><!--knockout team one-->
	
	
	<div class="knockout team two">
	KO Team 2
	</div><!--knockout team two-->
	
	
	<div class="casualty team one">
	CAS Team 1
	</div><!--casualty team one-->
	
	
	<div class="casualty team two">
	CAS Team 2
	</div><!--casualty team two-->
	
	<div class="dice">
	Dice
	</div><!--dice-->

</body>

</html>