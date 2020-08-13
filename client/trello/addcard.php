<?php include"functions.php";
if(!empty($_POST["status_id"])) {
	  $title = $_POST['title'];
	  $status_id = $_POST['status_id'];
	 addcard($title,$status_id);
	 
	 exit;
	}
	?>