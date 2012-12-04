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
	var team1score=0;
	var team2score=0;
	
	function playgame()
	{
		/*This is just going to advance the turns 1-8 and halves 1-8*/
		var half;
		var turn;
		var activeteam;
		var justscored="TRUE";
		
		for (half=1; half<=2; half++)
		{
			for (turn=1; turn<=8; turn++)
			{
				for (activeteam=1; activeteam<=2; activeteam++)
				{
					/*Do team 1 stuff*/
					alert("Half " + half + " and turn " + turn + " for team " + activeteam);
					
					/*Do team 2 stuff*/
					alert("Half " + half + "and turn" + turn + " for team " + activeteam);
				}/*Active team loop between 1 & 2*/
			}/*Turns 1-8*/
		}/*Halfs 1 and 2*/
	}/*End function playgame*/
	
	function setup(receivingteam)
	{
		/*Set up the receiving team*/
		alert("set up the receiving team: " + receivingteam);
		
		/*set up the kicking team*/
		alert("set up the kicking team: ");
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