<?php
 include'header.php';
/* require_once("dbcontroller.php");
$db_handle = new DBController(); */
if(!empty($_POST["goal_level"])) {
	//$query ="SELECT * FROM city WHERE country_id = '" . $_POST["country_id"] . "'";
	$results = $_POST['goal_level'];

	if($results==1) {
echo'<option value="">Select from your organisation \'s Goal</option>';
getOrganisationalGoalOptions();
	}
	elseif($results==2){ 
	echo'<option value="">Select from your Department \'s Goal</option>';
	getDepartmentalGoalOptions();
	}
	else{
		echo'<option>No options</option>';
	}
}
?>