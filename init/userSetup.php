<?php
	/*Gets Highest ID number from user table and adds 1 to create new user ID*/
	$sql="SELECT MAX(userID) AS userID FROM Registry";
	$result = mysqli_query($conn,$sql);
	$result = mysqli_fetch_assoc($result);
	$userID = $result["userID"];
	$userID = $userID + 1;
	$_SESSION['user_id'] = $userID;
	$sql="INSERT INTO Registry (userID) VALUES ($userID)";
	mysqli_query($conn,$sql);

?>