<?php

	//show all the errors
	ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

	//set the function for cleaning
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = nl2br($data);
	  return $data;
	}

	//function to connect to the database'
	function dbconnect(){

	    $sql = "localhost"; 
	    $username = "root";
	    $password = "";
	    $conn = mysqli_connect($sql, $username, $password) or 
	    die("Unable to connect to the database");
	    $databse = mysqli_select_db($conn, "trello");

	    // Return from the function 
	    return $conn; 
	}
	function getCards(){

	$conn = dbconnect();
    //read admin
     $stmt = $conn->prepare("SELECT id, status_name FROM tbl_status");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($stat_id, $status_name);
    While($stmt->fetch())
 {
                ?>
                <div class="status-card">
                    <div class="card-header">
                        <span class="card-header-text"><?php echo $status_name; ?></span>
                    </div>
                    <ul class="sortable ui-sortable"
                        id="sort<?php echo $stat_id; ?>"
                        data-status-id="<?php echo $stat_id; ?>">
                <?php
         
                $stmt1 = $conn->prepare("SELECT id, title, description, project_name, status_id, created_at FROM tbl_task WHERE status_id=?");
                $stmt1->bind_param('i',$stat_id);
			    $stmt1->execute();
			    $stmt1->store_result();
			    $stmt1->bind_result($id, $title, $description, $project_name, $status_id, $date);
                While($stmt1->fetch())   
                  {
                        ?>
                
                     <li class="text-row ui-sortable-handle"
                            data-task-id="<?php echo $id; ?>"><?php echo strtoupper($title); ?></li>
                <?php
                    }
                    $stmt1->close();
                ?>
                <div class="status-card">
                    <div class="card-header">
           
               <div id="<?php echo $stat_id; ?>" style="display:none">
				<li class="text-row ui-sortable-handle"
                     ><textarea cols="25" rows="4" name="title" onfocusout="addCard(this.value,<?php echo $stat_id; ?>)" placeholder="Enter Project Name"></textarea></li>
		           </div><hr>
		           <?php echo'<span class="card-header-text" id="hide-button'.$stat_id.'"  type="submit" onClick="showHideDiv('.$stat_id.');">New card</span>';
		            echo'<span class="card-header-text" style="display:none" id="show-button'.$stat_id.'" type="submit" onClick="showHideDiv('.$stat_id.');">Save card</span>';
		            ?>
                    </div>
                    </div> 
                  </ul>
                </div>
                <?php
            }
	}
	function addcard($title,$status_id){
		$conn=dbconnect();

		$stmt = $conn->prepare("INSERT INTO tbl_task (title, status_id) VALUES (?,?)");
		$stmt->bind_param('si', $title,$status_id);
		$stmt->execute();
		$stmt->close();

	}
?>
                
      
      