<script src="Javascript/jquery.js"></script>
<script type="text/javascript"></script>

<?php include("init/connect.php");?>

<?php 

if(isset($_GET['gameID'])  && isset($_GET['player']) ){

  /*Load Data into local variables*/
  $gameID = $_GET['gameID'];
  $me = $_GET['player'];
  $sql="SELECT * FROM MasterTable WHERE gameID=$gameID";
  $result = mysqli_query($conn,$sql);
  $result = mysqli_fetch_assoc($result);
  mysqli_query($conn,$sql);
  $gameStatus = $result['gameStatus'];
  $gameCreated = $result['gameCreated'];
  $creator = $result['creator'];
  $challenger = $result['challenger'];
  $challengerMovesNum = $result['challengerMovesNum'];
  $creatorCheckIn = $result['creatorCheckIn'];
  $challengerCheckIn = $result['challengerCheckIn'];
  $winner = $result['winner'];

  for ($i = 1; $i < 10; $i++){
    $spaces[$i] = $result['space'.$i];
    if ($spaces[$i] !== NULL){
      $moveMade = 1;
    }
  }

  $turn = $result['turn'];
  $time = time();
  /*Set up checkIn times for dissconnection checks*/
  if ($creator == $me){
    $opp = $challenger;
    $oppCheckIn = $challengerCheckIn;
    $timeSince = $time - $oppCheckIn;
    $sql="UPDATE MasterTable SET creatorCheckIn=$time WHERE gameID=$gameID";
    $result = mysqli_query($conn,$sql);
  } else if($challenger == $me) {
    $opp = $creator;
    $oppCheckIn = $result['creatorCheckIn'];
    $timeSince = $time - $oppCheckIn;
    $sql="UPDATE MasterTable SET challengerCheckIn=$time WHERE gameID=$gameID";
    $result = mysqli_query($conn,$sql);
    if ($gameStatus == 0){
      $sql="UPDATE MasterTable SET gameStatus=1 WHERE gameID=$gameID";
    	$result = mysqli_query($conn,$sql);
    }
  } else {
   echo "<br>A strange error happened somehow! Who ARE you?<br>";
  }

  $oppDisconnect = 0;
  
  echo "<div class=\"description\">";

  if ($winner == NULL){
    /*Disconnection Check*/
    if($gameStatus == 1 && $oppCheckIn !== NULL && $time - $oppCheckIn > 5){
      echo "Opponent disconnected!";
      $oppDisconnect = 1;
    } else if ($oppCheckIn == '' && $gameStatus == 0 && $time - $gameCreated < 5){
       echo "Waiting for match<br>";
    } else if ($oppCheckIn == '' && $gameStatus == 0 && $time - $gameCreated < 10){
       echo "Still waiting...<br>";
    } else if ($oppCheckIn == '' && $gameStatus == 0 && $time - $gameCreated <= 15){
       echo "STILL waiting...<br>";
    } else if ($oppCheckIn == '' && $gameStatus == 0 && $time - $gameCreated > 15){
       echo "Times up! Try again later.<br>";
       $sql="UPDATE MasterTable SET winner=0 WHERE gameID=$gameID";
       $result = mysqli_query($conn,$sql);
       $sql="UPDATE MasterTable SET gameStatus=1 WHERE gameID=$gameID";
       $result = mysqli_query($conn,$sql);
    } else if ($gameStatus == 1 && $moveMade == 0 && $turn !== $me && $challengerCheckIn !== NULL){
       echo "Matched! Waiting for other player...<br>";
    } else if ($gameStatus == 1 && $moveMade == 0 && $turn !== $me && $challengerCheckIn == NULL){
       echo "Opponent disconnected!<br>";
    }
    /*No dissconnetion? Whose turn is it?*/
      else if ($turn == $me) {
      echo "Its your turn!<br>";
    } else if ($turn == $opp) {
      echo "Its your opponent's turn!<br>";
    } 

    echo "</div>";

    echo "|";
        $i=1;
        for ($j=1; $j<4; $j++){
          echo "<div class=\"threeWrapper\">";
          for ($k=1; $k<4; $k++){
            /* If its your turn */
            if ($turn==$me && $oppDisconnect == 0){
                if ($spaces[$i]==NULL){
                  echo "<a href=\"#\" onClick=\"makeSpace($i,$me, $gameID, $opp)\" class=\"grey shadow\"><p id=\"space1\" class=\"spaces unpressed grey\"></p></a>";
                } 
                if ($spaces[$i]!==NULL) {
                    if ($spaces[$i]==$me){
                      echo "<a class=\"blue\"><p id=\"space1\" class=\"spaces unpressed blue\"></p></a>";
                    } else {
                      echo "<a class=\"red\"><p id=\"space1\" class=\"spaces unpressed red\"></p></a>";
                    }
                }
              } 
              /* If its not your turn */
              else if ($turn==$opp || $turn==NULL || $oppDisconnect = 1){
                  if ($spaces[$i]==NULL){
                    echo "<p id=\"space$i\" class=\"spaces unpressed grey wait\"></p>";
                  } 

                  if ($spaces[$i]!==NULL) {
                    if ($spaces[$i]==$me){
                      echo "<a class=\"blue\"><p id=\"space1\" class=\"spaces unpressed blue\"></p></a>";
                    } else {
                      echo "<a class=\"red\"><p id=\"space1\" class=\"spaces unpressed red\"></p></a>";
                    }
                  }
              }
            $i++;
          }
          echo "</div>";
        }

          echo "|";

  } 
    /*If $winner isn't null (includes dissconnection and cat game)*/
    else {
      if ($winner == $me) {
        echo "<b>YOU WON!</b>";
      } else if ($winner == $opp){
        echo "<b>YOU LOST!</b>";
      } else if ($winner == 0){
        echo "Times up! Try again later.<br>";
      } else if ($winner == 999){
        echo "Cat game!<br>";
      }
      echo "</div> |";
      $i=1;
      for ($j=1; $j<4; $j++){
        echo "<div class=\"threeWrapper\">";
        for ($k=1; $k<4; $k++){
                if ($spaces[$i]==NULL){
                  echo "<p id=\"space$i\" class=\"spaces unpressed grey wait\"></p>";
                } 
                if ($spaces[$i]!==NULL) {
                  if ($spaces[$i]==$me){
                    echo "<a class=\"blue\"><p id=\"space1\" class=\"spaces unpressed blue\"></p></a>";
                  } else {
                    echo "<a class=\"red\"><p id=\"space1\" class=\"spaces unpressed red\"></p></a>";
                  }
                }
          
          $i++;
        }
        echo "</div>";
      }
    echo "|";
  }
} 
?>