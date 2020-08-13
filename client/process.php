<?php 
 session_start();
	include"functions.php";
	
	if($_POST['table']=='bsc_project_tasks'){
	    
 var_dump($_FILES);
 var_dump($_POST['file_id']);
  var_dump($_POST['table']);
 $evidence = rand(1000,100000)."-".$_FILES['evidence']['name'];
 $location = $_FILES['evidence']['tmp_name'];
 $size = $_FILES['evidence']['size'];
 $type = $_FILES['evidence']['type'];
 $folder="uploads_actionplans/";
 $link= "";
 $evidence="$link".$evidence;
 move_uploaded_file($location,$folder.$evidence);
 //uploadFile($_POST['table'],$_POST['task_id'],$evidence,$_POST['scorecard_id']);
 
    $conn=dbconnect();

    $table=$_POST['table'];
    $id=$_POST['file_id'];

   $stmt=$conn->prepare("UPDATE $table SET document=? WHERE id=?");
   $stmt->bind_param('si',$evidence,$id);
   $stmt->execute();
   $stmt->close();
   $conn->close();
	    
	}else{

 var_dump($_FILES);
 var_dump($_POST['file_id']);
  var_dump($_POST['table']);
 $evidence = rand(1000,100000)."-".$_FILES['evidence']['name'];
 $location = $_FILES['evidence']['tmp_name'];
 $size = $_FILES['evidence']['size'];
 $type = $_FILES['evidence']['type'];
 $folder="evidence/";
 $link= "";
 $evidence="$link".$evidence;
 move_uploaded_file($location,$folder.$evidence);
 //uploadFile($_POST['table'],$_POST['task_id'],$evidence,$_POST['scorecard_id']);
 
    $conn=dbconnect();

    $table=$_POST['table'];
    $id=$_POST['file_id'];

   $stmt=$conn->prepare("UPDATE $table SET evidence=? WHERE id=?");
   $stmt->bind_param('si',$evidence,$id);
   $stmt->execute();
   $stmt->close();
   $conn->close();

}

?>