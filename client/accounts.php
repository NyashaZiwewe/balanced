<?php include"header.php"; error_reporting(0); ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>


 <?php if(isset($_POST['upload'])){

      $conn = dbconnect();

      $client_id=$_SESSION['client_id'];

      //assign the uploaded file a random name
      $file = rand(1000,100000)."-".$_FILES['file']['name'];
      $file_loc = $_FILES['file']['tmp_name'];
      $folder = "../users/";

      if(move_uploaded_file($file_loc,$folder.$file)){

          //calling PHPExcel to read uploaded excel file
          include ("../lib/Classes/PHPExcel/IOFactory.php");
          
          //loading file in PHPExcel
          $objPHPExcel = PHPExcel_IOFactory::load('../users/'.$file);
          $objPHPExcel->setActiveSheetIndex(0);
          $worksheet = $objPHPExcel->getActiveSheet();
          $highestRow = $worksheet->getHighestRow();
       
          //get data from excel sheet and add it into the database
          for($row = 2; $row <= $highestRow; $row++){

            //get parameters from the columns and add them to the names 
            $employee_number = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
            $first_name = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
            $middle_name = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
            $last_name = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
            $email = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
            $supervisor_email = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(5, $row)->getValue());
            $department = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
            $position = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
            $account_type = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(8, $row)->getValue());
            $business_unit = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(9, $row)->getValue());
                    
            $stmt = $conn->prepare("SELECT id FROM bsc_departments WHERE department = ? LIMIT 1");
            $stmt->bind_param('s', $department);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($department_id);
            $stmt->fetch();
            $stmt->close();
            
             $stmt = $conn->prepare("SELECT COUNT(*) FROM bsc_business_units WHERE name = ? AND client_id=? LIMIT 1");
            $stmt->bind_param('si', $business_unit, $_SESSION['client_id']);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            
            if($count>0){
            
            $stmt = $conn->prepare("SELECT id FROM bsc_business_units WHERE name = ? AND client_id=? LIMIT 1");
            $stmt->bind_param('si', $business_unit, $_SESSION['client_id']);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($business_unit_id);
            $stmt->fetch();
            $stmt->close();
                
            }else{
            $stmt = $conn->prepare("INSERT INTO bsc_business_units (client_id, name) VALUES (?,?)");
            $stmt->bind_param('is', $_SESSION['client_id'], $business_unit);
            $stmt->execute();
            $stmt->close();
            $business_unit_id = $conn->insert_id;
            }
            
            if(substr($account_type, 0, 1)=='O'){
                $account_type=4;
            }
              elseif(substr($account_type, 0, 1)=='D'){
                $account_type=3;
            }
              elseif(substr($account_type, 0, 1)=='B'){
                $account_type=2;
            }
              else{
                $account_type=1;
            }
         
      $stmt = $conn->prepare("INSERT INTO bsc_accounts (employee_number, first_name, middle_name, last_name, position, supervisoremail, client, business_unit, department, account_type, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
      $stmt->bind_param('ssssssssssss', $employee_number, $first_name, $middle_name, $last_name, $position, $supervisor_email, $client_id, $business_unit_id, $department_id, $account_type, $email, $password);
      $random = rand(0,100000);
      $fullname = test_input($first_name).' IPC '.test_input($last_name);
      $password = 'IPC'.substr((md5($fullname)),0,5).$random;
      $stmt->execute();
      $stmt->close();
      $last_id = $conn->insert_id;
      $level_id=$account_type;
    if($account_type==4 OR $account_type==3){
    addEmployeeScorecard($last_id, $client_id, $business_unit_id, $department_id,$level_id);
        }
        
        	$subject = "RE: New Job Ipeform Account Creation";

		$message = "<html>
						<body style='color:#1575a7;'>
							<p>Good day <b>".$first_name." ".$last_name."</b>,</p>
							<p>Your account has been created successfully on iPerform.</p><p>Please find below the login credentials and the link to sign in:</p>
							<p><b>Email:</b> ".$email."</p>
							<p><b>Password:</b> ".$password."</p>
							<p><b>Link to sign in:</b> <a href='http://129.232.213.100/~masaisai/iperform/signin.php'>http://129.232.213.100/~masaisai/iperform/signin.php</a></p>
							<p>Regards,</p>
							<p>Industrial Psychology Consultants (Pvt) Ltd</p>
					</html>";
		$message1 = "<html>
						<body style='color:#1575a7;'>
							<p>Good day team,</p>
							<p><b>".$first_name." ".$last_name."</b> of <b>".getClientName($client_id)."</b> has registered on Iperform system. Sign in to view more details.</p>
							<p>Link to sign in: <a href='http://129.232.213.100/~masaisai/iperform/signin.php'>http://129.232.213.100/~masaisai/iperform/signin.php</a></p>
							<p>Regards,</p>
							<p>Administrator</p>
					</html>";
					
			$headers = "From:  Industrial Psychology Consultants" . strip_tags('admin@masaisai.ac.zw') . "\r\n";
			$headers .= "Reply-To: ". strip_tags('nyasha@ipcconsultants.com') . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			
			$admin='ziwewend@mail.com';

		 mail($email, $subject, $message, $headers);
		 mail($admin, $subject, $message1, $headers);

      //close conn
      $conn->close();

           
        }
 
 echo "<script language=javascript> alert('Employee Records successfully added' ); window.location='employees?success=true'; </script>"; 
      $conn->close();
}
}   

 ?>


<script type="text/javascript">
  function saveAccount(val) {
        // alert(val);
        var employee_number = document.getElementById("employee_number"+val).value;
       
        var first_name = document.getElementById("first_name"+val).value;
        var last_name = document.getElementById("last_name"+val).value;
        var middle_name = document.getElementById("middle_name"+val).value;
        var email = document.getElementById("email"+val).value;
        var supervisor_email = document.getElementById("supervisor_email"+val).value;
        var account_type = document.getElementById("account_type"+val).value;
        var position = document.getElementById("position"+val).value;
        var department = document.getElementById("department"+val).value;
        var business_unit = document.getElementById("business_unit"+val).value;
        var client_id = <?php echo $_SESSION['client_id']; ?>
    
     
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    saveAccount: "nyasha",
    id: val,
    employee_number,
    client_id,
    first_name,
    middle_name,
    last_name,
    email,
    supervisor_email,
    account_type,
    position,
    business_unit,
    department
  },
  success: function(data){
    // alert(data);
    document.getElementById("accounts").innerHTML = data;
  }
  });
  }
</script>
<script type="text/javascript">
  function addAccount() {
        var client_id = document.getElementById("client_id").value;
        var employee_number = document.getElementById("employee_number").value;
        var first_name = document.getElementById("first_name").value;
        var last_name = document.getElementById("last_name").value;
        var middle_name = document.getElementById("middle_name").value;
        var email = document.getElementById("email").value;
        var supervisor_email = document.getElementById("supervisor_email").value;
        var account_type = document.getElementById("account_type").value;
        var position = document.getElementById("position").value;
        var department = document.getElementById("department").value;
        var business_unit = document.getElementById("business_unit").value;
        
        if(first_name=='' || last_name=='' || email=='' || supervisor_email=='' || account_type=='' || position=='' || department==''){
            document.getElementById("error").innerHTML="All fields marked with * are required";
            return false;
        }
        
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    addAccount: "Ziwewe",
    client_id,
    employee_number,
    first_name,
    middle_name,
    last_name,
    email,
    supervisor_email,
    account_type,
    position,
    business_unit,
    department

  },
  success: function(data){
   // alert(data);
      $("#addModal").modal('hide');
    document.getElementById("accounts").innerHTML = data;
  }
  });
  }
</script>
<script type="text/javascript">
  function deleteAccount(val) {
   // alert(val);
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    deleteAccount: "Nyengerai",
    account: val

  },
  success: function(data){
   // alert(data);
    document.getElementById("accounts").innerHTML = data;
  }
  });
  }
</script>

<script type="text/javascript">
  function addInputFields() {
      //alert(2);
 
document.getElementById("upload_area").innerHTML ='<label>Attach Completed Template File</label><hr><input type="file" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">';
document.getElementById("upload_footer").innerHTML ='<button type="submit" name="upload">Upload Records</button>';
}
</script>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Employee Records</h5>

                        <div class="ibox-tools">
                          <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i>Add New</a>
                           <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#upload"><i class="fa fa-plus"></i>Upload Employee Details</a>
                           <!--<a class="btn btn-primary btn-sm" href="add_multiple.php"><i class="fa fa-plus"></i>Add Multiple Accounts</a>-->
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#" class="dropdown-item">Config option 1</a>
                                </li>
                                <li><a href="#" class="dropdown-item">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                    <tr>
                          <th>Full Name</th>
                          <th>Email</th>
                          <th>Job Title</th>
                          <th>Department</th>
                          <th>Supervisor</th>
                          <th>Account Type</th>
                          <th>Action</th>
                        </tr>
                    </tr>
                    </thead>
                    <tbody id="accounts">
                    <?php    getAccounts(); ?>
                    </tbody>
                    <tfoot>
                    <tr>
                          <th>Full Name</th>
                          <th>Email</th>
                          <th>Job Title</th>
                          <th>Department</th>
                          <th>Supervisor</th>
                          <th>Account Type</th>
                          <th>Action</th>
                    </tr>
                    </tfoot>
                    </table>
                        </div>

                    </div>
                </div>
            </div>
            </div>
        </div>

                 <div class="modal inmodal fade" id="addModal" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Add new Employee</h4>
                                        </div>
                                        <form>
                                        <div class="modal-body">
                                      

           

                  <div class="row about-extra">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                    <div class="form-group form-float">
                          <div class="form-line">
                               <label>Employee Number (optional)</label>
                            <input type="hidden" id="client_id" value="<?php echo $_SESSION['client_id']; ?>">
                              <input type="text" id="employee_number" class="form-control" placeholder="Employee Number" >
                          </div>
                      </div>                  
                     </div>

                  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                               <label>First Name *</label>
                              <input type="text" id="first_name" name="first_name" minlength="3" class="form-control" placeholder="First Name" required>
                          </div>
                      </div>
                    </div>
                        </div>

                  <div class="row about-extra">
               
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                               <label>Middle Name (optional)</label>
                              <input type="text" id="middle_name" name="middle_name" class="form-control" placeholder="Midle Name">
                          </div>
                      </div>
                    </div>

                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                               <label>Last Name *</label>
                              <input type="text" id="last_name" name="last_name" minlength="3" pattern="[A-Za-z]*" class="form-control" placeholder="Last Name" required>
                          </div>
                      </div>
                      </div>
                       </div>
                       
                    <div class="row about-extra">
                 
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                       <div class="form-group form-float">
                          <div class="form-line">     
                           <label>Email Address *</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email Address" required>
                         </div>
                       </div>
                       </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                               <label>Email of Immediate Supervisor *</label>
                              <select id="supervisor_email" class="form-control" required>
                                <option value="bod">BOD</option>
                                 <?php   getSupervisors(); ?>
                              </select>
                          </div>
                      </div>
                    </div>
                       </div>
                    <div class="row about-extra">
                    
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                               <label>Access Level *</label>
                             <select class="form-control show-tick" id="account_type" required>
                          <option value="" selected disabled>Account Type</option>
                             <?php    listAccountTypes(); ?>
                          </select>
                          </div>
                      </div>
                      </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                               <label>Job Title *</label>
                           <input type="text" id="position" name="position" minlength="3" class="form-control" placeholder="Job Title" required>
                          </div>
                      </div>
                    </div>
                      </div>
                  <div class="row about-extra">
  
                  
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                       <div class="form-group form-float">
                          <div class="form-line">
                               <label>Business Unit</label>
                              <select id="business_unit" name="business_unit" class="form-control">
                                <option selected disabled value="">Select Business Unit</option>
                                <option value="no">No Business Unit</option>
                                <?php listBusinessUnits($_SESSION['client_id']);  ?>
                              </select>
                          </div>
                      </div>
                    </div>


                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                       <div class="form-group form-float">
                          <div class="form-line">
                              <label>Department *</label>
                            <select id="department" name="department" class="form-control" required>
                            <option selected disabled value="">Select Department</option>
                                <?php getDepartments();  ?>
                              </select>
                          </div>
                      </div>
                    </div>
            
                    </div>
                    <p align="center" style="color:red;"></p>
                  </div>
                                         <div class="modal-footer">
                                            <button type="button" onClick="addAccount();" class="btn btn-outline-primary">Done</button>
                                        </div>
                                      </form>
                                    </div>
                                </div>
                            </div>

                            
                                <div class="modal inmodal fade" id="upload" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Upload Employee Records</h4>
                                        </div>
                                        <form  method="post" action="" enctype="multipart/form-data">
                                        <div class="modal-body">
                                        <div class="row about-extra" >
                                        <!--<h4>Step 1. Download Template </h4>-->
                                        <a href="template.xlsx" download onClick="addInputFields()"><h4>Step 1. Download Template </h4></a> 
                                       <hr>

                                   <div class="form-group" id="upload_area">
                                    
                                   </div>

                                        
                                          </div>
                                          </div>

                                     
                                         <div class="modal-footer" id="upload_footer">
                                           
                                        </div>
                                      </form>
                                    </div>
                                </div>
                            </div>
   


<?php include"footer.php"; ?>




