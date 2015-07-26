<script src="../Javascript/jquery.js"></script>
<?php include("connect.php");?>
<?php

  /*Finda all open games (gameStatus=0)*/
  $sql="SELECT COUNT(*) AS Total FROM MasterTable WHERE gameStatus=0";  
  $result = mysqli_query($conn,$sql);
  $result = mysqli_fetch_assoc($result);
  $time = time();
  /*If there are no open games, create one*/
  if($result['Total']==0){  
      /*Set creator of the match to $userID, set the time the match was created, set the match status to open ("0")*/
      $sql="INSERT INTO MasterTable (gameCreated, gameStatus, creator) VALUES ($time, 0, $userID)";
      mysqli_query($conn,$sql); 
      $sql="SELECT * FROM MasterTable WHERE creator=$userID";
      $result = mysqli_query($conn,$sql);
      $result = mysqli_fetch_assoc($result);
      $gameID = $result['gameID'];
      $me = $result['creator'];

      /*Store match data in local variables*/
      $sql="SELECT * FROM MasterTable WHERE gameID=$gameID";
      $result = mysqli_query($conn,$sql);
      $result = mysqli_fetch_assoc($result);
      $gameStatus = $result['gameStatus'];
      $creator = $result['creator'];
      $challenger = $result['challenger'];
      $turn = $result['turn'];
      $_SESSION['game_id'] = $gameID;
  } 
  /*If there is an open game, join it*/
  else {
      /*Find the latest open game and retrieve data */
      $sql="SELECT MAX(gameID) AS gameID FROM MasterTable WHERE gameStatus=0";
      $result = mysqli_query($conn,$sql);
      $result = mysqli_fetch_assoc($result);
      $creatorCheckIn = $result['creatorCheckIn']; 
	    $gameID = $result['gameID'];
	    $challenger = $result['challenger'];

      /*Set challenger to $userID, make it this users turn, change game status to closed (1) */
	    $sql="UPDATE MasterTable SET challenger=$userID, turn=$userID, gameStatus=1 WHERE gameID=$result[gameID]";
		  mysqli_query($conn,$sql);
		      
      /*Store match data in local variables*/
		  $sql="SELECT * FROM MasterTable WHERE gameID=$gameID";
	    $result = mysqli_query($conn,$sql);
	    $result = mysqli_fetch_assoc($result);
      $me = $result['challenger'];
      $opp = $result['creator'];
      $gameStatus = $result['gameStatus'];
		  $creator = $result['creator'];
	    $challenger = $result['challenger'];
	    $turn = $result['turn'];
	    $_SESSION['game_id'] = $gameID;
     
  }

	

?> 