<?php include("init/connect.php");?> <!--Connects to database-->
<?php include("init/userSetup.php");?> <!--Sets User ID-->
<?php include("init/matchSetup.php");?> <!--Creates row for game-->

<!DOCTYPE html>
<html>
  <head>
  <meta name="viewport" content="width=device-width" />
  <link rel="stylesheet" type="text/css" href="style.css" />
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" />
  <script src="Javascript/jquery.js"></script>
  </head>
  <body>
    <div class="container">
      <?php
          echo "<div class=\"row row-centered\"><div class=\"col-12 col-centered\">";
          /*Run board() for first time*/
          echo "<script>$( document ).ready(function() {
                    board($gameID,$me);
                    });</script>";  
          /*Title, Description, Board div, Button for new game*/
          echo "
              <p class=\"title redP\">TIC </p><p class=\"title greyP\">TAC </p><p class=\"title blueP\">TOE </p>
              <div id=\"StatusDescription\"></div>
              <div id=\"board\"></div>
              <br><button id=\"newGame\" class=\"btn btn-default\" onClick=\"window.location.reload()\">New Game</button>";
          /*Closes the two first divs opened*/
          echo "</div></div>" 
      ?>
    </div>
  </body>

  <script>
      
      /*Run code that marks space for player, changes whos turn it is*/
      function makeSpace(s,p,g,t){
        $.post("update.php", {num: s, player: p, gameID: g, turn: t});
      }

      /*Run board.php every .5 seconds*/
      function board(gameID,me) {
          if (gameID == "") {
          } else { 
              xmlhttp = new XMLHttpRequest();
              xmlhttp.onreadystatechange = function() {
                  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                      var r= xmlhttp.responseText.split("|");
                      document.getElementById("StatusDescription").innerHTML = r[0];
                      document.getElementById("board").innerHTML =  r[1];
                 }
            }
              xmlhttp.open("GET","board.php?gameID="+gameID+"&player="+me,true);
              xmlhttp.send();
          }
          setTimeout(board, 500, gameID, me); /*Rerun this code ever .5 seconds*/
      }


  </script>

</html>