
<?php

// Start the session
session_start();

// Set session variables
if(isset($_POST['signin'])){
	$_SESSION["username"] = $_POST['username'];
	$_SESSION["password"] = $_POST['password'];
}

$username = $_SESSION["username"];
$password = $_SESSION["password"];

$conn=oci_connect('pagade','agadeoracle','oracle.cise.ufl.edu:1521/orcl');
if($conn){

}
	
else
{
    $err = oci_error();
	trigger_error(htmlentities($err['message'], ENT_QUOTES), E_USER_ERROR);
}
 	$query = "SELECT name, admin, premium, team, prevvisit FROM USERS WHERE username = '$username' AND password = '$password'";
	$stid = oci_parse($conn, $query);
	oci_execute($stid);

	$row = oci_fetch_array($stid, OCI_BOTH);
	
	if($row !== false){
		$authorized = 1;
		$_SESSION["authorized"]=1;
		$name = $row[0];
		$myTeam = $row[3];
		$prevVisit = $row[4];
		$admin = $row[1];
		$premium = $row[2];

        $datetime = explode(" ",$prevVisit);
        $date = $datetime[0];
        $time = $datetime[1];
        $time = date("h:i A",strtotime($time));

		//Update PrevVisit Entry
		$query_prevvisit = "update USERS set PREVVISIT = (SELECT CURRENT_TIMESTAMP  FROM DUAL) where username='$username'";
        $stid_prevvisit = oci_parse($conn, $query_prevvisit);
        oci_execute($stid_prevvisit);
	}
	else{
		$authorized = 0;
		$name="Unauthorized User.";
		$_SESSION["authorized"]=0;
		header("Location: 403.html");
        session_destroy();
	}
?>

<?php
if($admin == 1){
	$chars="stackoverflowrules";
?>
<html>
<form name='redirect' action='admin_area.php' method='POST'>
<input type='hidden' name='chars' value='<?php echo $chars; ?>'>
<input type='submit' value='Please wait' class="hidden">
</form>
<script type='text/javascript'>
document.redirect.submit();
</script>
</html>

<?php
     }
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Soccer Statistics System</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/ma_right_content_style.css">
<link rel="stylesheet" type="text/css" href="css/loader.css">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.js" type="text/javascript"></script>

</head>
<body>
<div id="background-image" class="background-image"></div>

<!-- Member Area Container -->

<div id="member_area_container" class="member_area_container hidden">
<!--<h1 id="ma_app_title">Soccer Statistics System</h1>-->
<div id="form">
    <section>
    
    <!-- *************************************** Left Menu Area ************************************* -->
	<div id="left_menu">
	    <a href="member_area.php">
    	<img src="img/logo_small.png" width="82%">
    	</a>
    	<br><hr><br>
    	<font size="+2">Menu</font><br><br>
        <button class="button_menu" id="open_menu_home">Home</button>
		<br><br>
        <button class="button_menu" id="open_menu_leagues">Leagues</button>
		<br><br>
        <button class="button_menu" id="open_menu_teams">Teams</button>
		<br><br>
        <button class="button_menu" id="open_menu_mvps">MVPs</button>
		<br><br>
        <button class="button_menu" id="open_menu_search">Search</button>
		<br><br>
        <hr><br>


        <font size="+2">User Info</font><br>
		<span class="short">
		<font size="2px">Logged in as: </font><br><span class="black"><font size="4px"><?php echo $name ?></font></span>.

        <br>
        <font size="2px">Fav team: </font><br><span class="black"><font size="4px"><span id="span_fav_team"><?php echo $myTeam ?></span></font></span>.

        <br>
        <?php
        if($date != '01-JAN-99'){
            echo '<font size="2px">Last activity: </font><br><span class="black"><font size="4px"> '.$date.' at '.$time.'.</font></span>';
        }
        ?>

        <br>
        </span>
        <br><br>
        <button class="button_menu_alt" id="ma_logout">Logout</button>
		<br>
        <hr><br>
    </div>
    
    
    <!-- ****************************** Right Area Content ***************************************** -->
    <div id="right_menu">
    
    <!-- *************************************** Home Page ************************************** -->
    <div id="ma_right_default">
    <font size="+2">Welcome, <span class="accent"><?php echo $name ?></span></font>
    
    <br><hr><br>
        <span class"paragraph_1">
        Soccer Statistics System is an interactive application that offers user intriguing facts about soccer.<br><br>Know the chances of your favourite team winning against another based on previous performances, or most valuable players in two teams and their comparisions, or search for a player or a team, etc.
        </span><hr class="hr_alt"/><br>
        <br>
        
<?php
	//Most number of goals
	$query_most_goals = "select * from (select player.name,player.club,sum(playerdata.GS) from player,playerdata where player.id = playerdata.id group by player.name,player.club order by sum(playerdata.GS) desc) where rownum=1";
	$stid_most_goals = oci_parse($conn, $query_most_goals);
	oci_execute($stid_most_goals);
	
	//Most number of Assists
	$query_most_assists = "select * from (select player.name,player.club,sum(playerdata.A) from player,playerdata where player.id = playerdata.id group by player.name,player.club order by sum(playerdata.A) desc) where rownum=1";
	$stid_most_assists = oci_parse($conn, $query_most_assists);
	oci_execute($stid_most_assists);
	
	//Most number of saves by a Goalkeeper
	$query_most_saves = "select * from (select player.name,player.club,sum(playerdata.s) from player,playerdata where player.id = playerdata.id and player.POSITION = 'g' group by player.name,player.club order by sum(playerdata.S) desc) where rownum=1";
	$stid_most_saves = oci_parse($conn, $query_most_saves);
	oci_execute($stid_most_saves);
	
	//Most number of Red Cards
	$query_most_red_cards = "select * from (select player.name,player.club,sum(playerdata.RC) from player,playerdata where player.id = playerdata.id group by player.name,player.club order by sum(playerdata.RC) desc) where rownum=1";
	$stid_most_red_cards = oci_parse($conn, $query_most_red_cards);
	oci_execute($stid_most_red_cards);
	
	//Most number of Yellow Cards
	$query_most_yellow_cards = "select * from (select player.name,player.club,sum(playerdata.YC) from player,playerdata where player.id = playerdata.id group by player.name,player.club order by sum(playerdata.YC) desc) where rownum=1";
	$stid_most_yellow_cards = oci_parse($conn, $query_most_yellow_cards);
	oci_execute($stid_most_yellow_cards);
	
	//Most valuable player of the season
	$query_most_valuable_player = "select * from (select player.name,player.club,player.position,sum(playerdata.p) from player,playerdata where player.id = playerdata.id
group by player.name,player.club,player.position order by sum(playerdata.p) desc) where rownum=1";
	$stid_most_valuable_player = oci_parse($conn, $query_most_valuable_player);
	oci_execute($stid_most_valuable_player);
	
	
	
	$row_most_valuable_player = oci_fetch_array($stid_most_valuable_player, OCI_BOTH);
	$row_most_goals = oci_fetch_array($stid_most_goals, OCI_BOTH);
	$row_most_assists = oci_fetch_array($stid_most_assists, OCI_BOTH);
	$row_most_saves = oci_fetch_array($stid_most_saves, OCI_BOTH);
	$row_most_red_cards = oci_fetch_array($stid_most_red_cards, OCI_BOTH);
	$row_most_yellow_cards = oci_fetch_array($stid_most_yellow_cards, OCI_BOTH);
	
?>

<table border="0px" style="background: rgba(255, 255, 255, 0.01);" cellpadding="10px" cellspacing="4px">
    <tr>
      <td>
        <table border="0px" style="background: rgba(255, 255, 255, 0.14);" cellpadding="10px" cellspacing="10px">
    	<tr>
        	<td>
            	 <font size="4px">EPL statistics</font><br>
                 <font size="2px" class="black minute_line_height">2015-16</font>
            </td>
        </tr>
        </table>
        
        
        <?php if($row_most_valuable_player[2] === 'm'){ $mvp_pos = 'Mid-fielder';}
		else if($row_most_valuable_player[2] === 'a'){ $mvp_pos = 'Striker';}
		else if($row_most_valuable_player[2] === 'd'){ $mvp_pos = 'Defender';}
		else if($row_most_valuable_player[2] === 'g'){ $mvp_pos = 'Goalkeeper';} ?>
        <table border="0px" style="background: rgba(255, 255, 255, 0.24);" cellpadding="10px" cellspacing="10px">
    	<tr>
        	<td>
                <font size="3px">Most valuable person</font><br>
       			<font size="6px" class="accent_dark short_line_height"><?php echo $row_most_valuable_player[0]; ?></font><br>
                <font size="2px" class="black minute_line_height"><?php echo $mvp_pos.", "; ?></font><font size="2px" class="black minute_line_height"><?php echo $row_most_valuable_player[1]; ?></font>
            </td>
        </tr>
        </table>
        
        <table border="0px" style="background: rgba(255, 255, 255, 0.24);" cellpadding="10px" cellspacing="10px">
    	<tr>
        	<td>
                <font size="3px">Top scorer</font><br>
       			<font size="6px" class="accent_dark short_line_height"><?php echo $row_most_goals[0]; ?></font><br>
                <font size="2px" class="black minute_line_height"><?php echo $row_most_goals[1].", Goals: "; ?></font><font size="2px" class="black minute_line_height"><?php echo $row_most_goals[2]; ?></font>
            </td>
        	<td>
                <font size="3px">Most Assists</font><br>
       			<font size="6px" class="accent_dark short_line_height"><?php echo $row_most_assists[0]; ?></font><br>
                <font size="2px" class="black minute_line_height"><?php echo $row_most_assists[1].", Assits: "; ?></font><font size="2px" class="black minute_line_height"><?php echo $row_most_assists[2]; ?></font>
            </td>
        </tr>
        </table>
        
        <table border="0px" style="background: rgba(255, 255, 255, 0.24);" cellpadding="10px" cellspacing="10px">
    	<tr>
        	<td>
                <font size="3px">Best goalkeeper</font><br>
       			<font size="6px" class="accent_dark short_line_height"><?php echo $row_most_saves[0]; ?></font><br>
                <font size="2px" class="black minute_line_height"><?php echo $row_most_saves[1].", Saves: "; ?></font><font size="2px" class="black minute_line_height"><?php echo $row_most_saves[2]; ?></font>
            </td>
        </tr>
        </table>
        
        <table border="0px" style="background: rgba(255, 255, 255, 0.24);" cellpadding="10px" cellspacing="10px">
    	<tr>
        	<td>
                <font size="3px">Most red cards</font><br>
       			<font size="6px" class="accent_dark short_line_height"><?php echo $row_most_red_cards[0]; ?></font><br>
                <font size="2px" class="black minute_line_height"><?php echo $row_most_red_cards[1].", Red cards: "; ?></font><font size="2px" class="black minute_line_height"><?php echo $row_most_red_cards[2]; ?></font>
            </td>
            <td>
                <font size="3px">Most yellow cards</font><br>
       			<font size="6px" class="accent_dark short_line_height"><?php echo $row_most_yellow_cards[0]; ?></font><br>
                <font size="2px" class="black minute_line_height"><?php echo $row_most_yellow_cards[1].", Yellow cards: "; ?></font><font size="2px" class="black minute_line_height"><?php echo $row_most_yellow_cards[2]; ?></font>
            </td>
        </tr>
        </table>
        
      </td>
      
      <td>
      </td>
      <td>
      </td>
      
      <td valign="top">
        
    <?php
	//Most dominant league in terms of goals
	$query_dom_league = "select * from (select l1.TITLE, sum(s1.FTAG + s1.FTHG) from scores s1,league l1 where l1.ID = s1.div group by l1.TITLE order by  sum(s1.FTAG + s1.FTHG) desc) where rownum<=10";
	$stid_dom_league = oci_parse($conn, $query_dom_league);
	oci_execute($stid_dom_league);
?>
        
        <table border="0px" style="background: rgba(255, 255, 255, 0.24);" cellpadding="10px" cellspacing="10px">
        <tr >
        	<td valign="top" >
       			<font size="6px">League</font><br>
                <font size="2px" class="black minute_line_height">*since 1997</font>
            </td>
            <td></td>
            <td valign="top">
       			<font size="6px">Goals</font>
            </td>
        </tr>
        <?php 
			while(($row_dom_league = oci_fetch_array($stid_dom_league, OCI_BOTH)) != false){
		$num_rows_dom_league = oci_num_rows($stid_dom_league);
		if($row_dom_league[0] !=''){
			
		?>
        
    	<tr>
        	<td>
       			<font><?php echo $row_dom_league[0];  ?></font>
            </td>
            <td></td>
            <td align="center">
       			<font><?php echo $row_dom_league[1];  ?></font>
            </td>
        </tr>
        <?php 
			}
		}
		?>
        </table>
        
        </td>
        
        <td>
        </td>
             
        
        
        </tr>
        </table>
        
        
        
        <!-- bottom padding -->
    
        <br><br><br><br><br>
    </div>
        
     
    <!-- *************************************** Leagues ******************************************* -->
    
    <!-- Page 1 -->
    <div id="ma_right_leagues_1" class="hidden" style="padding-top: 0px;">
        <font size="+2">Leagues</font><hr><br>
        To begin, select a league from the drop-down menu. Select the query you want to perform.
        <br><br>
         <?php
     	    $query_leagues = "SELECT ID, TITLE FROM LEAGUE";
		    $leagues = oci_parse($conn, $query_leagues);
		    oci_execute($leagues);
	     ?>

    Select a league:
    <Select class="input_alt" id="selected_league" name="selected_league">

    <!-- Dropdown Menu -->
    <?php
	$selected_league = '';
	while(($row_leagues = oci_fetch_array($leagues, OCI_BOTH)) != false){
		$num_rows_leagues = oci_num_rows($leagues);
		if($row_leagues[1] !=''){
			echo '<option value="'.$row_leagues[1].'">'.$row_leagues[1].'</option>';
		}
	}
	?>
    
 	</Select><br>
    
    <button class="button_content_alt button-block" id="pr_leagues_1">Proceed</button>
    </div>
    
    
    <!-- Page 2 -->
    <div id="ma_right_leagues_2" class="hidden" style="padding-top: 0px;">
    <font size="+2">Leagues - <span id="league_title_1"></span></font><hr><br>
    
    
    To see interesting facts about <span id="league_title_2">.</span>, either use the dropdown options and click on the arrow to execute or use pre-compiled queries by clicking on 'execute'.
    <br><hr><br>
    
    <table border="0px" cellpadding="20px" cellspacing="20px">
    <tr><td style="background: rgba(255,255,255,0.1);"><font size="2px">Results to display: </font><input placeholder="10" type="number" id="rank" class="input_rank"/></td>
    <td style="background: rgba(255,255,255,0.1);"><font size="2px">Select # of seasons: </font><input placeholder="15" type="number" id="num_seasons" class="input_rank"/></td>
    <td style="background: rgba(255,255,255,0.1);" id="td_leagues_outcome"><font size="2px">Select outcome: </font><Select placeholder="5" type="number" id="leagues_outcome"><option value="default">-</option><option value="win">Win</option><option value="lose">Lose</option></Select></td>
    <td style="background: rgba(255,255,255,0.1);"><font size="2px">As: </font><Select placeholder="5" type="number" id="leagues_away_home"><option value="default">-</option><option value="home">Home team</option><option value="away">Away team</option></Select></td>
    <td style="background: rgba(255,255,255,0.1);" id="td_leagues_half"><font size="2px">Scored only in: </font><Select placeholder="5" type="number" id="leagues_half"><option value="default">-</option><option value="first_half">1st half</option><option value="second_half">2nd half</option></Select></td>
    <td  width="20px" style="background: rgba(255,193,7,0.0);" id="td_leagues_execute" valign="middle"><button style="background: rgba(255,193,7,0.0); border: 0px;"  id="custom_execute"><img src="img/arrow.png" width="34px" height="60px"></button></td>
    
    </tr>
    </table>
    <br><br><br>
    
    <span class="accent">Or</span> Select one of the following options.
    <br><hr><br>
    
    <!-- Leagues Query 1 -->
1. Top teams with most home wins.
<button style="float: right; margin-right:10px;" class="button_content_alt button-block" id="eq_leagues_1">Execute</button><hr class="hr_alt"><br>

    <!-- Leagues Query 2 -->
2. Top teams with most away wins.
<button style="float: right; margin-right:10px;" class="button_content_alt button-block" id="eq_leagues_2">Execute</button><hr class="hr_alt"><br>

    <!-- Leagues Query 3 -->
3. Top home teams with most games, having scored goals only in second half.
<button style="float: right; margin-right:10px;" class="button_content_alt button-block" id="eq_leagues_3">Execute</button><hr class="hr_alt"><br>

    <!-- Leagues Query 4 -->
4. Top home teams with most goals scored in second half.
<button style="float: right; margin-right:10px;" class="button_content_alt button-block" id="eq_leagues_4">Execute</button><hr class="hr_alt"><br>

    <!-- Leagues Query 5 -->
5. Top away teams with most matches, having scored in second half only.
<button style="float: right; margin-right:10px;" class="button_content_alt button-block" id="eq_leagues_5">Execute</button><hr class="hr_alt"><br>

    <!-- Leagues Query 6 -->
6. Top away teams with most goals that were scored in second half only.
<button style="float: right; margin-right:10px;" class="button_content_alt button-block" id="eq_leagues_6">Execute</button><hr class="hr_alt"><br>

    <!-- Leagues Query 7 -->
7. Top home teams with highest number of matches, having scored in first half only.
<button style="float: right; margin-right:10px;" class="button_content_alt button-block" id="eq_leagues_7">Execute</button><hr class="hr_alt"><br>

<!-- Leagues Query 5 -->
8. Top home teams with highest number of goals that were scored in first half only.
<button style="float: right; margin-right:10px;" class="button_content_alt button-block" id="eq_leagues_8">Execute</button><hr class="hr_alt"><br>

    <!-- Leagues Query 6 -->
9. Total games where teams who won away matches while losing in the first half.
<button style="float: right; margin-right:10px;" class="button_content_alt button-block" id="eq_leagues_9">Execute</button><hr class="hr_alt"><br>

    <!-- Leagues Query 7 -->
10. Total games where teams who lost home matches while winning in the first half.
<button style="float: right; margin-right:10px;" class="button_content_alt button-block" id="eq_leagues_10">Execute</button><hr class="hr_alt"><br>


    <!-- Bottom Padding -->
    <br><br><br>
	</div>





    <!-- *************************************** MVPs ******************************************* -->
    
    <!-- Page 1 -->
    <div id="ma_right_mvps_1" class="hidden" style="padding-top: 0px;">
        <font size="+2">Most Valuable Players</font><hr><br>
        To begin, select two teams from the drop-down menus. Then click on proceed.
        <br><br>
        <!-- Dropdown Menu -->
    <?php
     	$query_mvp_t1 = "SELECT DISTINCT CLUB FROM PLAYER";
		$mvp_t1 = oci_parse($conn, $query_mvp_t1);
		oci_execute($mvp_t1);
	?>
    Select team A:
    
    <Select class="input_alt" id="selected_mvp_1" name="selected_mvp_1">
    <?php
	$selected_league = '';
	while(($row_mvp_t1 = oci_fetch_array($mvp_t1, OCI_BOTH)) != false){
		if($row_mvp_t1[0] !=''){
			echo '<option value="'.$row_mvp_t1[0].'">'.$row_mvp_t1[0].'</option>';
		}
	}
	?>

 	</Select><br>
    
     <?php
     	$query_mvp_t2 = "SELECT DISTINCT CLUB FROM PLAYER";
		$mvp_t2 = oci_parse($conn, $query_mvp_t2);
		oci_execute($mvp_t2);
	?>
    
    Select team B:
    <Select class="input_alt" id="selected_mvp_2" name="selected_mvp_2">
    <?php
	$selected_league = '';
	while(($row_mvp_t2 = oci_fetch_array($mvp_t2, OCI_BOTH)) != false){
		if($row_mvp_t2[0] !=''){
			echo '<option value="'.$row_mvp_t2[0].'">'.$row_mvp_t2[0].'</option>';
		}
	}
	?>

 	</Select><br>
    
    <button class="button_content_alt button-block" id="pr_mvp_1">Proceed</button>
    
    <!-- Bottom Padding -->
    <br><br><br>
    
    </div>
    
    
    
    
    
    
    <!-- *************************************** Search ******************************************* -->
    
    <!-- Page 1 -->
    <div id="ma_right_search_1" class="hidden" style="padding-top: 0px;">
        <font size="+2">Search</font><hr><br>
        To begin, select any of the following options.
        
    <table border="0px" cellspacing="40px" cellpadding="50px">
    <tr>
    <td style="background: rgba(255, 255, 255, 0.1);" valign="top">
        <!-- Dropdown Menu -->
    <?php
     	$query_search_club = "SELECT DISTINCT CLUB FROM PLAYER";
		$search_club = oci_parse($conn, $query_search_club);
		oci_execute($search_club);
	?>
    <span class="accent_dark">Search Players</span><br>
    Select club:
    <Select id="selected_search_club" name="selected_search_club">
    <option value="default">-</option>
    <?php
	while(($row_search_club = oci_fetch_array($search_club, OCI_BOTH)) != false){
		if($row_search_club[0] !=''){
			echo '<option value="'.$row_search_club[0].'">'.$row_search_club[0].'</option>';
		}
	}
	?>

 	</Select><br>
    
     <?php
     	$query_search_position = "SELECT DISTINCT POSITION FROM PLAYER";
		$search_position = oci_parse($conn, $query_search_position);
		oci_execute($search_position);
	?>
    
    Select position:
    <Select id="selected_search_position" name="selected_search_position">
    <option value="default">-</option>
    <?php
	while(($row_search_position = oci_fetch_array($search_position, OCI_BOTH)) != false){
		if($row_search_position[0] !=''){
			if($row_search_position[0] == 'd'){ $pos = 'Defender'; }
			else if($row_search_position[0] == 'g'){ $pos = 'Goalkeeper'; }
			else if($row_search_position[0] == 'a'){ $pos = 'Striker'; }
			else if($row_search_position[0] == 'm'){ $pos = 'Mid-fielder'; }
			echo '<option value="'.$row_search_position[0].'">'.$pos.'</option>';
		}
	}
	?>

 	</Select><br>
    
    <!--
    Minimum Goals:
    <input placeholder="0" type="number" id="selected_search_min_goals" class="input_rank"/>
    <br>
    
    Minimum Own Goals:
    <input placeholder="0" type="number" id="selected_search_own_goals" class="input_rank"/>
    <br>
    
    -->
    <button class="button_content_alt button-block" id="search_player">Search</button>
    </td>
    
    
    
    
    <td style="background: rgba(255, 255, 255, 0.1);"  valign="top">
        <!-- Dropdown Menu -->
    <?php
     	$query_search_player = "SELECT DISTINCT NAME FROM PLAYER";
		$search_player = oci_parse($conn, $query_search_player);
		oci_execute($search_player);
	?>
    
    <span class="accent_dark">Search Teams</span><br>
    Select player:
    <Select id="selected_search_player" name="selected_search_player">
    <option value="default">-</option>
    <?php
	while(($row_search_player = oci_fetch_array($search_player, OCI_BOTH)) != false){
		if($row_search_player[0] !=''){
			echo '<option value="'.$row_search_player[0].'">'.$row_search_player[0].'</option>';
		}
	}
	?>

 	</Select><br>
    
    <!--
    Minimum winning ratio:
    <input placeholder="0" type="number" id="selected_search_min_win_ratio" class="input_rank"/>
    <br>
    
    -->
    
    <button class="button_content_alt button-block" id="search_team">Search</button>
    </td>
    
    
    </tr>
    </table>
    <!-- Bottom Padding -->
    <br><br><br>
    
    </div>
    





    
<!-- *******************************************   Teams   **************************************************-->
    
    <!-- Page 1 -->
    <div id="ma_right_teams_1" class="hidden" style="padding-top: 0px;">
    <font size="+2">Teams</font><hr><br>
    To begin, select a team from the drop-down menu.
    <br><br>

    <!-- Dropdown Menu -->
    <?php
     	$query_teams = "SELECT ID, LEAGUE FROM TEAM order by id asc";
		$teams = oci_parse($conn, $query_teams);
		oci_execute($teams);
	?>
    Select a team:
    <Select class="input_alt" id="selected_team" name="selected_team">
    <?php
	$selected_league = '';
	while(($row_teams = oci_fetch_array($teams, OCI_BOTH)) != false){
		$num_rows_teams = oci_num_rows($teams);
		if($row_teams[0] !=''){
			echo '<option value="'.$row_teams[0].'">'.$row_teams[0].'</option>';
		}
	}
	?>

 	</Select><br>
    
    <button class="button_content_alt button-block" id="pr_teams_1">Proceed</button>
    </div>
    
    
    
    <!-- Page 2 -->
    <div id="ma_right_teams_2" class="hidden" style="padding-top: 0px;">
    <font size="+2">Teams - <span id="team_title_1"></span></font><hr><br>
    <br>
    
    <div id="teams_info_page"></div>
    
    
    
    <br>
<br>

<hr/>
  
    
 
 
    <!-- Bottom Padding -->
    <br><br><br><br><br><br>

    </div>
    
    
 </div>
    
 
	</section>
	</div>

	<!--DBStats-->
    	 <?php
             	$query_dbTuples = "select SUM(to_number(extractvalue(xmltype(dbms_xmlgen.getxml('select count(*) X from '||table_name))
                                                                              ,'/ROWSET/ROW/X'))) count
                                  from USER_TABLES";
        		$dbTuples = oci_parse($conn, $query_dbTuples);
        		oci_execute($dbTuples);
        	?>
            <?php
        	$row_dbTuples = oci_fetch_array($dbTuples, OCI_BOTH);
        	$num_rows_dbTuples = oci_num_rows($dbTuples);
        	$tuples = intval($row_dbTuples[0]) - 57848;
        	?>

    	 <?php
             	$query_dbTables = "select COUNT(table_name) from USER_TABLES";
        		$dbTables = oci_parse($conn, $query_dbTables);
        		oci_execute($dbTables);
        	?>
            <?php
        	$row_dbTables = oci_fetch_array($dbTables, OCI_BOTH);
        	$num_rows_dbTables = oci_num_rows($dbTables);
        	$tables = intval($row_dbTables[0]) - 1;
        	?>

	<div class="dbStats">
      <span><img src="img/stats.png"></span>
      <div class="dbStats-content">

        <p><font size="2px" class="white">Count of tuples: </font><br>
        <span class="black"><font size="6px"><?php echo $tuples; ?>.</font></span>
        <hr class="hr_alt">
        <font size="2px" class="white">Count of tables: </font><br>
                <span class="black"><font size="6px"><?php echo $tables; ?>.</font></span>
        </p>
      </div>
    </div>


</div>



<!-- Result Page/ Close Button/ Loader -->
<div class="result_frame hidden" id="result_frame"></div>
<div class="result_frame_bg hidden" id="result_frame_bg"></div>
 
<button class="button_special result_frame_close hidden" id="result_frame_close">X</button>

<div id="loading" class="loading">
<span class="cssload-loader"><span class="cssload-loader-inner"></span></span>
</div>



<div id="splash" class="splash hidden"><span class="splash_logo"><img src="img/splash.png"></span></div>

<div id="premium_box" class="premium_box"><?php echo $premium ?></div>


<!-- *************************************** Import scripts ******************************************* -->
	<script src="js/w3-include-HTML.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/scripts.js" ></script>
	<script type="text/javascript" src="js/ma_menu.js" ></script>
	<script type="text/javascript" src="js/league_queries.js" ></script>
	<script type="text/javascript" src="js/team_queries.js" ></script>
	<script type="text/javascript" src="js/mvp_queries.js" ></script>
	<script type="text/javascript" src="js/search_queries.js" ></script>
 

</body>
</html>