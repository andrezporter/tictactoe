<?php 
	$conn = mysqli_connect("GitHub", "GitHub", "GitHub", "GitHub"); // host, username, pw, database
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    printf("No Success");
	    exit();
	}
?>