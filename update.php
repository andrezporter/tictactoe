<?php include("init/connect.php");?>
<?php

	if(isset($_POST['num']) && isset($_POST['player']) && isset($_POST['gameID']) && isset($_POST['turn'])){
		$gameID = $_POST['gameID'];
		$sql="SELECT * FROM MasterTable WHERE gameID=$gameID";
  		$result = mysqli_query($conn,$sql);
  		$result = mysqli_fetch_assoc($result);
  		$turn = $result['turn'];
  		$player = $_POST['player'];
  		if ($turn == $player){
			
	  		$num = $_POST['num'];
			$player = $_POST['player'];
			$gameID = $_POST['gameID'];
			$opp = $_POST['turn'];
			$sql="UPDATE MasterTable SET space$num=$player, turn=$opp WHERE gameID=$gameID";
			mysqli_query($conn,$sql);
			
			$sql="SELECT * FROM MasterTable WHERE gameID=$gameID";
	  		$result = mysqli_query($conn,$sql);
	  		$result = mysqli_fetch_assoc($result);
			
		    $space1 = $result['space1'];
		   	$space2 = $result['space2'];
		   	$space3 = $result['space3'];
		   	$space4 = $result['space4'];
		   	$space5 = $result['space5'];
	    	$space6 = $result['space6'];
	    	$space7 = $result['space7'];
		   	$space8 = $result['space8'];
		   	$space9 = $result['space9'];

			/*Winner Check*/
			if ($space1 !== NULL && $space1 == $space2 && $space1 == $space3){
				$sql="UPDATE MasterTable SET winner=$space1 WHERE gameID=$gameID";
			} else if ($space4 !== NULL && $space4 == $space5 && $space4 == $space6){
				$sql="UPDATE MasterTable SET winner=$space4 WHERE gameID=$gameID";
			} else if ($space7 !== NULL && $space7 == $space8 && $space7 == $space9){
				$sql="UPDATE MasterTable SET winner=$space7 WHERE gameID=$gameID";
			} else if ($space1 !== NULL && $space1 == $space4 && $space1 == $space7){
				$sql="UPDATE MasterTable SET winner=$space1 WHERE gameID=$gameID";
			} else if ($space2 !== NULL && $space2 == $space5 && $space2 == $space8){
				$sql="UPDATE MasterTable SET winner=$space2 WHERE gameID=$gameID";
			} else if ($space3 !== NULL && $space3 == $space6 && $space3 == $space9){
				$sql="UPDATE MasterTable SET winner=$space3 WHERE gameID=$gameID";
			} else if ($space1 !== NULL && $space1 == $space5 && $space1 == $space9){
				$sql="UPDATE MasterTable SET winner=$space1 WHERE gameID=$gameID";
			} else if ($space3 !== NULL && $space3 == $space5 && $space3 == $space7){
				$sql="UPDATE MasterTable SET winner=$space3 WHERE gameID=$gameID";
			} 
			/*If all spaces are full set winner to "Cat"*/
			else if ($space1 !== NULL && $space2 !== NULL && $space3 !== NULL && $space4 !== NULL && $space5 !== NULL && $space6 !== NULL && $space7 !== NULL && $space8 !== NULL && $space9 !== NULL){
				$sql="UPDATE MasterTable SET winner=999 WHERE gameID=$gameID";
			}
			$result = mysqli_query($conn,$sql);
			mysqli_close($conn);	
  		} else {
  			mysqli_close($conn);
  		}
		
	}



?>