<?php
$sId = session_id();
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
	    $databse = mysqli_select_db($conn, "bsc_demo");

	    // Return from the function 
	    return $conn; 
	}

  function deleteAccount($par){

    $conn = dbconnect();

    $stmt = $conn->prepare("DELETE FROM bsc_accounts WHERE id = ?");
    $stmt->bind_param('i', $id);
    $id = test_input($par);
    $stmt->execute();
    $stmt->close();
    $conn->close();
  }

  //function to change password
  function passwordChange($par1, $par2){

    $conn = dbconnect();
if($_SESSION['account_type']==1){
 $stmt = $conn->prepare("SELECT password FROM bsc_client_credentials WHERE client_id = ?");
    $stmt->bind_param('i', $id);
    $id = test_input($_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($password);
    $stmt->fetch();
    $stmt->close();

} else{
    $stmt = $conn->prepare("SELECT password FROM bsc_accounts WHERE id = ?");
    $stmt->bind_param('i', $id);
    $id = test_input($_SESSION['user_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($password);
    $stmt->fetch();
    $stmt->close();
}
    if($password == test_input($par1)){

     if($_SESSION['account_type']==1){
      $stmt = $conn->prepare("UPDATE bsc_client_credentials SET password = ? WHERE client_id = ?");
      $stmt->bind_param('si', $pwd, $id);
      $pwd = test_input($par2);
      $id = test_input($_SESSION['client_id']);
      $stmt->execute();
      $stmt->close();
      }

      else{
       $stmt = $conn->prepare("UPDATE bsc_accounts SET password = ? WHERE id = ?");
      $stmt->bind_param('si', $pwd, $id);
      $pwd = test_input($par2);
      $id = test_input($_SESSION['user_id']);
      $stmt->execute();
      $stmt->close(); 
      }

      echo "<script type='text/javascript'>
          window.location.href = 'changepassword?primary=true';
          </script>";

    }else{

  echo "<script language=javascript> alert('Wrong old password'); window.location='changepassword?password_error=true'; </script>"; 

    }

    $conn->close();

  }

  //function to sign in
  function signIn($par1, $par2){

    //include connection to the database
    $conn = dbconnect();

    //session start up
    session_start();

    //set loging to false
    $login = false;

    // prepare and bind
    $stmt = $conn->prepare("SELECT admin_id, first_name, last_name, email, password, account_type FROM admin  WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);

    // set parameters 
    $email = test_input(@$par1);
    $password = test_input(@$par2);

    //get the count of the email
    $sql = "SELECT COUNT(*) AS count FROM admin WHERE email = '".$email."' AND password = '".$password."'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];

    //set condition and execute depending on the condition
    if($count == 1){

      $stmt->execute();

      $stmt->store_result();
      $stmt->bind_result($admin_id, $first_name, $last_name, $email, $password, $account_type);

      while($stmt->fetch())
      {

        //get the session variables
        $_SESSION["admin_id"] = $admin_id;
        $_SESSION["first_name"] = $first_name;
        $_SESSION["last_name"] = $last_name;
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        $_SESSION["account_type"] = $account_type;
        $_SESSION["logged"] = true;
          $login = true;
          break; 

      }

    echo "<script type='text/javascript'>
        window.location.href = 'index.php';
        </script>";


    }else{

      echo "<script type='text/javascript'>
        window.location.href = 'login?failure=true';
        </script>";

    }

    $stmt->close();
    $conn->close();

  }

  //function for password reset
  function resetPassword($par1){

    //include connection to the database
    $conn = dbconnect();

    //get count of the email
    $stmt = $conn->prepare("SELECT COUNT(email) AS count FROM admin WHERE email = ?");
    $stmt->bind_param('s', $email);

    //set parameters and execute
    $email = test_input($par1);
    $stmt->execute();

    //get the result
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();
    $count;

    //set conditions for the count
    if($count == 1){
      //get the credentials and email the user
      $stmt = $conn->prepare("SELECT password FROM admin WHERE email = ?");
      $stmt->bind_param('s', $email);

      //set parameters and execute
      $email = test_input($par1);
      $stmt->execute();

      //get the result
      $stmt->store_result();
      $stmt->bind_result($password);
      $stmt->fetch();

      //send the email
      $to = $par1; 
        $from = "admin@ipcjobsportal.com"; 
        $subject = "RE: Password Recovery";
        $message = 'Good day, <br/><br/> Please find below the email and password for your account. <br/><br/> Email Address: '.$email.'<br> Password: '.$password.' <br/><br/> Follow this link to login: server2018/consultant/pages/examples/sign-in.php <br/><br/> Regards, <br/> Admin.';
        $headers = "From:" . $from;
       
        ////mail($to,$subject,$message,$headers);

        /**
           * This example shows sending a message using PHP's mail() function.
           */
          require '/lib/PHPMailer/PHPMailerAutoload.php';

          //Create a new PHPMailer instance
          $mail = new PHPMailer;

          $mail->IsSMTP();
          $mail->Host = "smtp.gmail.com";

          // optional
          // used only when SMTP requires authentication  
          $mail->SMTPAuth = true;
          $mail->Username = 'ipcconsultants1@gmail.com';
          $mail->Password = 'redweb2013';

          //Set who the message is to be sent from
          $mail->setFrom('ipcconsultants1@gmail.com', 'Talent Hunter');
          //Set an alternative reply-to address
          // $mail->addReplyTo('makazatinashe2000@gmail.com', 'First Last');
          //Set who the message is to be sent to
          $mail->addAddress($to, $subject); 
          //Set the subject line
          $mail->Subject = $subject;
          //Read an HTML message body from an external file, convert referenced images to embedded,
          //convert HTML into a basic plain-text alternative body
          // $mail->msgHTML(file_get_contents('PHPMailer/examples/contents.html'), dirname(__FILE__));
          //Replace the plain text body with one created manually
          //Fetching data from database
          //End of fetch

          $mail->IsHTML(true);
          $mail->Body  = $message;
          $mail->AltBody = $message;
          //Attach an image file
          //$mail->addAttachment('loanpdf.php?userid=7');

          //send the message, check for errors
          if (!$mail->send()) {
              echo "Mailer Error: " . $mail->ErrorInfo;
          } else {
              //redirect after sending email
              header("Location: {$_SERVER['HTTP_REFERER']}?success=true");
        exit;
          }

    }else{
      header("Location: {$_SERVER['HTTP_REFERER']}?error=true");
      exit;
    }

    $stmt->close();
    $conn->close();

  }

  //function to add consultant
  function addAdmin($par1, $par2, $par3, $par4, $par5){

    // Database connection
    $conn = dbconnect();

    //add admin
    $stmt = $conn->prepare("INSERT INTO admin (first_name, last_name, email, password, account_type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss', $first_name, $last_name, $email, $password, $account_type);
    $first_name = test_input($par1);
    $last_name = test_input($par2);
    $email = test_input($par3);
    $password = test_input($par4);
    $account_type = test_input($par5);
    $stmt->execute();
    $stmt->close();

    //close conn
    $conn->close();

    echo "<script language=javascript> alert('$first_name $last_name was successfully added as a consultant'); window.location='../../pages/tables/consultants.php'; </script>"; 

  }
    //function to add consultant
    function editAdmin($par1, $par2, $par3, $par4, $par5){

      // Database connection
      $conn = dbconnect();
  
      $admin_id=$_GET['admin_id'];
      $stmt = $conn->prepare("UPDATE admin SET first_name=?, last_name=?, email=?, password=?, account_type=? WHERE admin_id='$admin_id'");
      $stmt->bind_param('sssss', $first_name, $last_name, $email, $password, $account_type);
      $first_name = test_input($par1);
      $last_name = test_input($par2);
      $email = test_input($par3);
      $password = test_input($par4);
      $account_type = test_input($par5);
      $stmt->execute();
      $stmt->close();
  
      //close conn
      $conn->close();
  
      echo "<script language=javascript> alert('$first_name $last_name was successfully updated as a $account_type'); window.location='consultants.php'; </script>"; 
  
    }
//function to read consultnts
  function getAdmin(){

    // Database connection
    $conn = dbconnect();

    //read admin
    $stmt = $conn->prepare("SELECT admin_id, first_name, last_name, email, account_type, date_time FROM admin");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($admin_id, $first_name, $last_name, $email, $account_type, $date);
    while($stmt->fetch()){
      echo '  <tbody>
                                    <tr><td><a href="consultants.php?edit=true&admin_id='.$admin_id.'">
<i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>  <a href="delete.php?admin_id='.$admin_id.'"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
                                        <td>'.$first_name.' '.$last_name.'</td>
                                        <td>'.$email.'</td>
                                        <td>'.$account_type.'</td>
                                        <td>'.$date.'</td>
                                    </tr>
                             
                                </tbody>';
    }
    $stmt->close();

    //close conn
    $conn->close();

  }
  
  //function to get a list of the clients
  function getAdminList(){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT admin_id, first_name, last_name FROM admin ORDER BY admin_id");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($admin_id, $first_name, $last_name);
    while($stmt->fetch()){
      echo '<option value="'.$admin_id.'">'.$first_name.' '.$last_name.'</option>';
    }
    $stmt->close();

    $conn->close();

  }
  function getAdminToChange(){

    // Database connection
    $conn = dbconnect();

    $admin_id=$_GET['admin_id'];
    $stmt = $conn->prepare("SELECT admin_id, first_name, last_name, email, password, account_type, date_time FROM admin WHERE admin_id=?");
    $stmt ->bind_param('i',$admin_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($admin_id, $first_name, $last_name, $email, $password, $account_type, $date);
    while($stmt->fetch()){
      echo '  <!--==========================
    Intro Section
  ============================-->
  <section id="hero" class="clearfix">
    <div class="container">

     
        
       

<div class="getjob">

<h1>Add new Consultant</h1>

    </div>
  </section><!-- #intro -->


 




  <main id="main">

    <!--==========================
      About Us Section
    ============================-->
    <section id="joblisting">
      <div class="container">
          <div class="row about-extra">

         <div class="col-sm-10 col-centered wow fadeInUp pt-5 pt-lg-0">
          <div class="card">
            <div class="card-body">
                  <form action="" method="POST">
            
                <div class="form-group">
                <label>First name:</label>
      <div class="input-group">
        <div class="input-group-prepend bg-primary">
        <span class="input-group-text bg-transparent">
          <i class="mdi mdi-account text-white"></i>
        </span>
        </div>
       <input type="text" id="first_name"  name="first_name" value="'.$first_name.'" class="form-control" required>

      </div>
      </div>

               <div class="form-group">
                <label>Last name:</label>
      <div class="input-group">
        <div class="input-group-prepend bg-primary">
        <span class="input-group-text bg-transparent">
          <i class="mdi mdi-account text-white"></i>
        </span>
        </div>
       <input type="text" id="last_name"  name="last_name" value="'.$last_name.'" class="form-control" required>

      </div>
      </div>

         <div class="form-group">
                <label>Email:</label>
      <div class="input-group">
        <div class="input-group-prepend bg-primary">
        <span class="input-group-text bg-transparent">
          <i class="mdi mdi-account text-white"></i>
        </span>
        </div>
        <input type="email" id="email_address" name="email" value="'.$email.'" class="form-control" required>

      </div>
      </div>

         <div class="form-group">
                <label>Password:</label>
      <div class="input-group">
        <div class="input-group-prepend bg-primary">
        <span class="input-group-text bg-transparent">
          <i class="mdi mdi-account text-white"></i>
        </span>
        </div>
       <input type="password" id="password" name="password" value="'.$password.'"class="form-control" required minlength="6">

      </div>
      </div>

      <div class="form-group">
      <label>Acount Type</label>
      <div class="input-group">
        <div class="input-group-prepend bg-primary">
        <span class="input-group-text bg-transparent">
          <i class="mdi mdi-account text-white"></i>
        </span>
        </div>
        <select name="account_type" class="form-control" aria-label="account_type" aria-describedby="colored-addon1" required>
       <option value="" selected >'.getAccountTypeName($account_type).'</option>
                                        <option>Consultant</option>
                                        <option>Superuser</option>
  </select>
    
      </div>
      </div>
 
                
              <button type="submit" name="save" class="btn btn-primary m-r-20 btn-sm">Save</button> 
                <button type="reset" name="rest" class="btn btn-primary m-r-20 btn-sm">Reset</button> 
              </form>
 

            </div>
          </div>
        </div>


       


      </div>

      </div>
    </section><!-- #about -->

  </main> ';
    }
    $stmt->close();

    //close conn
    $conn->close();

  }
  function getCredits(){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT id, amount, tockens_bought, tockens_used, level, date FROM payments WHERE client_id=?");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $amount, $tockens_bought, $tockens_used, $level, $date);
        while($stmt->fetch()){
          echo '<tr><td>RTGS$ '.$amount.'</td><td>'.$tockens_bought.'</td><td>'.$tockens_used.'</td><td>'.$level.'</td><td>'.substr($date,0,11).'</td>
          <td>
        <a href="credits.php?edit=true&credit_id='.$id.'" style="color:green"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
        <a href="delete.php?credit_id='.$id.'" style="color:red"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></td></tr>';
        }
    $stmt->close();

    $conn->close();
    
  }
   function getCreditstoEdit(){
  $conn=dbconnect();
  $credit_id=$_GET['credit_id'];
  $stmt = $conn->prepare("SELECT id, client_id, tockens_bought, level, date FROM payments WHERE id=?");
      $stmt->bind_param('i',$credit_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($credit_id,$client_id, $tockens_bought, $level, $date);
        while($stmt->fetch()){ 

  echo'

                  <h4><b>These Credits can be given to paid clients or by priviledge</b></h4>
                  <hr>
                  <p><font color="red">Please note the price for executives is <b>$100</b> and the price for non-executives is <b>$50</b>.</font></p>
                  <br/>
                  <form action="credits.php" method="POST">
                    <div class="row about-extra">
                      <div class="col-sm-4 wow fadeInUp pt-5 pt-lg-0">
                        <div class="form-group">
                        <input type="hidden" name="credit_id" value="'.$credit_id.'">
                          <label for="tockens_bought">Select Client</label>
                          <select class="form-control" name="client_id" required>
                          <option selected value="'.$client_id.'">'.getClientName($client_id).'</option>
                            <option  disabled>Select Client</option>';
                             getClients(); 
             echo'             </select>
                        </div>
                      </div>
                       
                      <div class="col-sm-4 wow fadeInUp pt-5 pt-lg-0">
                        <div class="form-group">
                          <label for="tockens_bought">Number of Credits</label>
                          <input type="number" min="1" class="form-control" name="tockens_bought" value="'.$tockens_bought.'" placeholder="Enter the number of credits to be paid for" required>
                        </div>
                      </div>
                      <div class="col-sm-4wow fadeInUp pt-5 pt-lg-0">
                        <div class="form-group">
                          <label for="level">Level</label>
                          <select class="form-control" name="level" required>
                          <option selected value="'.$level.'">'.$level.'</option>
                            <option value="Executive">Executive</option>
                            <option value="Non-Executive">Non-Executive</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <br/>
                    <button type="submit" name="saveCredits" class="btn btn-primary"><i class="fa fa-save"></i> Save Details</button>
                  </form>

  '; 
}
$stmt->Close();
$conn->Close();
 }
function saveCreditChanges($id, $client_id, $tockens_bought, $level){
  $conn=dbconnect();

      //add the variables
    $tockens_bought = $_POST['tockens_bought'];
    $tockens_used = 0;
    $level = $_POST['level'];
    $client_id = $_POST['client_id'];

    //get the price
    if($_POST['level'] == 'Executive'){
      $price = 100;
    }else{
      $price = 50;
    }

    //compute the value
    $value = $_POST['tockens_bought']*$price;

    //save the infomation and get the id
    $conn = dbconnect();

    $stmt = $conn->prepare("UPDATE payments SET id=?, client_id=?, amount=?, tockens_bought=?, level=? WHERE id=?");
    $stmt->bind_param('iiiiis', $id, $client_id, $value, $tockens_bought, $level,$id);
    $stmt->execute();
    $stmt->close();

    $conn->close();
    echo "<script type='text/javascript'>
        window.location.href = 'credits.php?success=true';
        </script>"; 
        $stmt->close();
        $conn->Close();
}

    function getMyNotifications(){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT notifications_id, subject, message, status, date_time FROM  bsc_client_notifications WHERE client_id=? ORDER by date_time DESC");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $subject, $message, $status, $date);
    while($stmt->fetch()){

      echo '<tr>
        <td>'.$subject.'</td>
        <td>'.substr($message,0,115).'</td>
        <td>'.getNotificationStatusName($status).'</td>
        <td>'.substr($date,0,11).'</td>
        <td>
         <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Options</button>
        <ul class="dropdown-menu">                                       
        <li><a href="#"><button class="btn btn-outline-info" data-toggle="modal" data-target="#view'.$id.'"><font color="#175ea8"<i class="fa fa-search"></i>View Details</font></button></a></li>                
        </ul>
        </div>';

   echo'<div class="modal inmodal fade" id="view'.$id.'" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h3> <b> '.$subject.' </b></h3>
                                        </div>
                                        <div class="modal-body">
                                   <p align="center">'.$message.'</p>
                                        </div>

                                        <div class="modal-footer">
                                        <button class="btn btn-outline-info" data-dismiss="modal">Close</buuton>
                                            <button type="button" class="btn btn-outline-danger" onclick="deleteNotification('.$id.')" data-dismiss="modal"><i class="fa fa-trash"></i> Delete Notification</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';

    echo' </td></tr>';
    }
    $stmt->close();

    $conn->close();

  }
  function getNotificationsCount($status){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM  bsc_client_notifications WHERE status=?");
    $stmt->bind_param('i',$status);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();   
    $stmt->close();
    $conn->close();
return $count;

  }
  function getNewNotifications(){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT subject, message, status, date_time FROM  bsc_client_notifications WHERE status=? AND client_id=? ORDER by date_time DESC LIMIT 3");
    $stmt->bind_param('ii',$status,$_SESSION['client_id']);
    $status=0;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($subject, $message, $status, $date);
    while($stmt->fetch()){

      echo ' 
             <li>
                <a href="notifications.php" class="dropdown-item">
                    <div>
                        <i class="fa fa-envelope fa-fw"></i>'.$subject.'
                        <span class="float-right text-muted small">'.substr($date,0,11).'</span>
                    </div>
                </a>
            </li>
            <li class="dropdown-divider"></li>';
    }
    $stmt->close();

    $conn->close();

  }

    function getNewMessages(){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT id, subject, message, sender, date FROM  bsc_emails WHERE recepient=? AND status=? ORDER BY date DESC LIMIT 3");
    $stmt->bind_param('si',$_SESSION['email'],$status);
    $status=0;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $subject, $message, $sender, $date);
    while($stmt->fetch()){

      echo '
               <li onclick="redirect('.$id.')">

                <div class="dropdown-messages-box">
                    <a class="dropdown-item float-left" href="#">
                        <img alt="image" class="rounded-circle" src="img/a7.jpg">
                    </a>
                    <div>
                        <small class="float-right">'.substr($date, 0,11).'</small>
                        <strong>'.$subject.'</strong>. <br>
                        '.substr($message,0,40).'
                        <small class="text-muted">'.$sender.'</small>

                    </div>
                </div>
            </li>
            <li class="dropdown-divider"></li>';
    }
    $stmt->close();

    $conn->close();

  }

  function getNewNotifications2(){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT subject, message, status, date_time FROM  consultant_notifications ORDER by date_time DESC LIMIT 3");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($subject, $message, $status, $date);
    while($stmt->fetch()){

      echo '                
          <li>
            <a href="notifications.php">
              <div class="icon-circle bg-purple">
                <i class="material-icons">settings</i>
              </div>
              <div class="menu-info">
                <h4>'.$subject.'</h4>
                <p>
                  <i class="material-icons">access_time</i> '.$date.'
                </p>
              </div>
            </a>
          </li>';
    }
    $stmt->close();

    $conn->close();

  }
  function changeMessageStatus($old,$new){

    $conn = dbconnect();
    $stmt = $conn->prepare("UPDATE bsc_client_notifications SET status=? WHERE status= ?" );
    $stmt-> bind_param('ii', $old, $new);
    $stmt->execute();
    $stmt->close();
    $conn->close();
     }

  //function to update client status
  function updateClientStatus($par1){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT status AS stat FROM bsc_client_credentials WHERE client_id = ?");
    $stmt->bind_param('i', $id);
    $id = $par1;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($stat);
    $stmt->fetch();
    $stmt->close();

    if($stat == 0 || $stat == ""){
      $stat = 1;
    }else{
      $stat = 0;
    }

    $stmt = $conn->prepare("UPDATE bsc_client_credentials SET status = ? WHERE client_id = ?");
    $stmt->bind_param('ii', $status, $id);
    $status = $stat;
    $id = $par1;
    $stmt->execute();
    $stmt->close();

    $conn->close();

    echo "<script type='text/javascript'>
        window.location.href = 'employers.php?statuschange=true';
        </script>";

  }

  function getTotalScorecards(){

    $conn = dbconnect();
     if($_SESSION['account_type']==1){
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? ");
    $stmt->bind_param('i',$_SESSION['client_id']);
     }
     elseif($_SESSION['account_type']==2){
      $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? AND business_unit=?");
    $stmt->bind_param('ii',$_SESSION['client_id'],$_SESSION['business_unit']); 
     }
     elseif($_SESSION['account_type']==3){
      $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? AND department_id=?");
    $stmt->bind_param('ii',$_SESSION['client_id'], $_SESSION['department_id']); 
     }else{
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE owner=?");
    $stmt->bind_param('i',$_SESSION['user_id']); 
     }
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();
        
       // echo''.$count.'';

    $stmt->close();
    $conn->close();

    return $count;
    
  }

  //function to get total accounts
   function getTotalAccounts(){

     $conn = dbconnect();


     if($_SESSION['account_type']==1){
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_accounts WHERE client=? ");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $count=$count+1;
     }
     elseif($_SESSION['account_type']==2){
      $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_accounts WHERE client=? AND business_unit=?");
      $stmt->bind_param('ii',$_SESSION['client_id'],$_SESSION['business_unit']); 
     }
     elseif($_SESSION['account_type']==3){
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_accounts WHERE client=? AND department=?");
    $stmt->bind_param('ii',$_SESSION['client_id'], $_SESSION['department_id']); 
     }
     else{
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_accounts WHERE id=?");
    $stmt->bind_param('i',$_SESSION['user_id']); 
     }
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();

    $stmt->close();
    $conn->close();

    return $count;
    
  }

    


  //function to get total accounts
  function getTotalAccountsSupervisor(){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_accounts WHERE supervisoremail = ?");
    $stmt->bind_param('s', $client);
    $client = test_input($_SESSION['email']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
        $stmt->fetch();
    $stmt->close();

    $conn->close();

    return $count;
    
  }


    //function to get total clients
  function getTotalClients(){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM client");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
        $stmt->fetch();
        
        echo''.$count.'';

    $stmt->close();
    $conn->close();

    //return $count;
    
  }

    function getCountries(){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT country_id, country FROM country ORDER BY country");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($country_id, $country);
    while($stmt->fetch()){

      echo '<tr><td><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <a href="delete.php?country_id='.$country_id.'"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td><td><div id="content" contenteditable="true">'.$country.' </div><form name="form1" action="" method="post">
                 <input type="text" name="country_id" value="'.$country_id.'">
                  <textarea hidden display:none; visibility:none></textarea>
                </form></td><td><button type="submit">save</button></td></tr>';
    }
    $stmt->close();

    $conn->close();

  }

  //function to get a list of the employment type
  function getPerpectiveOptions(){

    $conn = dbconnect();
    $stmt = $conn->prepare("SELECT id FROM bsc_perspectives WHERE id NOT IN  (SELECT perspective_id FROM bsc_client_perspectives WHERE client_id=?)");
    $stmt->bind_param('i',$_SESSION['client_id']); 
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($perspective_id);
    while($stmt->fetch()){
      echo '<option value="'.$perspective_id.'">'.getPerspectiveName($perspective_id).'</option>';
    }
    $stmt->close();

    $conn->close();

  }

  //function to get a list of the employment type
  function getGoalOptions($perspective_id){

    $conn = dbconnect();
    $scorecard_id=$_GET['scorecard'];
    $stmt = $conn->prepare("SELECT id FROM bsc_goals WHERE scorecard_id=?");
    $stmt->bind_param('i',$scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($goal_id);
    while($stmt->fetch()){
      echo '<option value="'.$goal_id.'">'.getgoalName($goal_id).'</option>';
    }
    $stmt->close();

    $conn->close();

  }
    function getOrganisationalGoalOptions(){

    $conn = dbconnect();

    $stmt1 = $conn->prepare("SELECT goals.id FROM bsc_scorecards LEFT JOIN bsc_goals ON bsc_goals.scorecard_id=bsc_scorecards.id WHERE client_id=? AND level_id=? ");
    $stmt1->bind_param('ii',$client_id,$level_id);
    $client_id=test_input($_SESSION["client_id"]);
    $level_id=1;
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($goal_id);
    while($stmt1->fetch()){
      echo '<option value="'.$goal_id.'">'.getgoalName($goal_id).'</option>';
    
       }
    $stmt1->close();
    $conn->close();

  }
      function getDepartmentalGoalOptions(){

    $conn = dbconnect();

    $stmt1 = $conn->prepare("SELECT goals.id FROM bsc_scorecards LEFT JOIN goals ON bsc_goals.scorecard_id=bsc_scorecards.id WHERE client_id=? AND level_id=? ");
    $stmt1->bind_param('ii',$_SESSION['client_id'],$level_id);
    $level_id=2;
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($goal_id);
    while($stmt1->fetch()){
      echo '<option value="'.$goal_id.'">'.getgoalName($goal_id).'</option>';
    
       }
    $stmt1->close();
    $conn->close();

  }
//function to get the job categories
  function readClient(){

    $conn = dbconnect();

  $stmt1 = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE level_id=? AND client_id=?");
    $stmt1->bind_param('ii',$level_id,$_SESSION['client_id']);
    $level_id=1;
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    while($stmt1->fetch()){
}    
$stmt1->close();

      echo '<tr><td>'.getClientName($_SESSION['client_id']).'</td><td><div class="btn-group"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Update<span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
                                      <li>
                                      <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                <a href="client.php?update_address=true&client_id='.$_SESSION['client_id'].'"><button type="submit" class="btn btn-success m-r-20 btn-sm" name="address"><i class="fa fa-address-card"></i> My Address</button></a>
                <a href="client.php?update_contact_details=true&client_id='.$_SESSION['client_id'].'"><button type="submit" class="btn btn-warning m-r-20 btn-sm" name="address"><i class="fa fa-phone"></i> My Contact</button></a>
              <a href="delete.php?client_id='.$_SESSION['client_id'].'"><button type="submit" class="btn btn-danger m-r-20 btn-sm" name="address"><i class="fa fa-trash"></i> Delete My Account</button>
                    
                      </div>
                      </li>
                                      </ul></div>
           <a href="accounts.php?client_id='.$_SESSION['client_id'].'"><button type="submit" class="btn btn-primary" name="accounts"><i class="fa fa-users"></i> User Accounts</button></a>';
               if($count>0){
              echo' <a href="scorecards.php?edit=true&client_id='.$_SESSION['client_id'].'"><button type="submit" class="btn btn-warning" name="accounts"><i class="fa fa-star"></i> Ratings</button></a></td></tr>';                        
                                      }else{
            echo' <a href="scorecards.php?addnew=true&client_id='.$_SESSION['client_id'].'"><button type="submit" class="btn btn-warning" name="accounts"><i class="fa fa-star"></i> Ratings</button></a></td></tr>';                    
                                      }          

    $conn->close();

  }
  function checkUserScorecard($par1){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE owner=?");
    $stmt->bind_param('i',$user_id);
    $user_id=test_input($par1);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
  return $count;

  }

    function getUserScorecard($user_id){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE owner=?");
    $stmt->bind_param('i',$user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
  return $id;

  }
    function checkDeptScorecard($par1,$par2){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE department_id=? AND level_id=? AND client_id=?");
    $stmt->bind_param('iii',$department_id,$level_id, $client_id);
    $department_id=test_input($par1);
    $client_id=test_input($par2);
    $level_id=2;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $count;

  }
    function getAccounts(){

    // Database connection
    $conn = dbconnect();

  if(countBusinessUnits()>0){
   if($_SESSION['account_type']==1){
     $stmt = $conn->prepare("SELECT id, employee_number, first_name, middle_name, last_name, email, supervisoremail, position, business_unit, department, account_type, date FROM bsc_accounts WHERE client = ?");
    $stmt->bind_param('i',$_SESSION['client_id']);
  }  elseif($_SESSION['account_type']==2){
     $stmt = $conn->prepare("SELECT id, employee_number, first_name, middle_name, last_name, email, supervisoremail, position, business_unit, department, account_type, date FROM bsc_accounts WHERE client = ? AND business_unit=?");
    $stmt->bind_param('ii',$_SESSION['client_id'],$_SESSION['business_unit']);
  }  
  
  else{
      $stmt = $conn->prepare("SELECT id, employee_number, first_name, middle_name, last_name, email, supervisoremail, position, business_unit, department, account_type, date FROM bsc_accounts WHERE department=? AND business_unit=? AND client = ?");
    $stmt->bind_param('iii',$_SESSION['department_id'],$_SESSION['business_unit'],$_SESSION['client_id']);
  }
}
else{

  if($_SESSION['account_type']==1){
     $stmt = $conn->prepare("SELECT id, employee_number, first_name, middle_name, last_name, email, supervisoremail, position, business_unit, department, account_type, date FROM bsc_accounts WHERE client = ?");
    $stmt->bind_param('i',$_SESSION['client_id']);
  }  
  
  else{
      $stmt = $conn->prepare("SELECT id, employee_number, first_name, middle_name, last_name, email, supervisoremail, position, business_unit, department, account_type, date FROM bsc_accounts WHERE department=? AND client = ?");
    $stmt->bind_param('ii',$_SESSION['department_id'],$_SESSION['client_id']);
  } 

}
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $employee_number, $first_name, $middle_name, $last_name, $email, $supervisor_email, $position, $business_unit, $department, $account_type, $date);
    while($stmt->fetch()){
      echo '<tr>
        <td>'.$first_name.' '.$last_name.'</td>
        <td>'.$email.'</td>
        <td>'.$position.'</td>
        <td>'.getDepartmentName($department).'</td>
        <td>'.getSupervisorName($supervisor_email).'</td>
        <td>'.getAccountTypeName($account_type).'</td>
        <td> 
      
        <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Options</button>
        <ul class="dropdown-menu">';
        if(checkUserScorecard($id)==0){ 
                              
echo'  <li><a href="/demo/client/scorecards?addm3"> <button type="button" class="btn btn-outline-primary">Add Scorecard</button></a></li>';
                        }else{
echo '<li> <a href="/demo/client/scorecard/'.getUserScorecard($id).'"> <button type="button"  class="btn btn-outline-primary"><i class="fa fa-search"></i> Scorecard</button></a></li>';
                        }
echo'  <li> <a href="#"> <button type="button" data-toggle="modal" data-target="#update'.$id.'"  class="btn btn-outline-primary"><i class="fa fa-edit"></i> Edit User</button></a></li>
                     
        <li><a href="#"><button class="btn btn-outline-danger" data-toggle="modal" data-target="#delete'.$id.'"><font color="red"<i class="fa fa-trash"></i>Delete User</font></button></a></li>
                       
        </ul>
        </div>
        </td>
      </tr>';

      echo'         <div class="modal inmodal fade" id="delete'.$id.'" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h3>Deleting <b> '.getEmployeeName($id).' </b>\'s Record</h3>
                            <h5><font color="red">Deleting Employee Will delete all associated Information about the employee</font></h5>
                                        </div>
                                        <div class="modal-body">
                                   <p align="center"> <h3>Are you Sure you want to delete this employee record?</h3> </p>
                                        </div>

                                        <div class="modal-footer">
                                        <button class="btn btn-outline-info" data-dismiss="modal">No</buuton>
                                            <button type="button" class="btn btn-outline-danger" onclick="deleteAccount('.$id.')" data-dismiss="modal"><i class="fa fa-trash"></i> Yes Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';

          echo' <div class="modal inmodal fade" id="update'.$id.'" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Update Employee Record</h4>
                                        </div>
                                        <div class="modal-body">                       
                  <div class="row about-extra">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                    <div class="form-group form-float">
                          <div class="form-line">
                            <input type="hidden" id="client_id'.$id.'" value="'.$_SESSION['client_id'].'">
                              <input type="text" id="employee_number'.$id.'" class="form-control" placeholder="Employee Number" value="'.$employee_number.'" >
                          </div>
                      </div>                  
                     </div>

                  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                              <input type="text" id="first_name'.$id.'" name="first_name" class="form-control" placeholder="First Name" value="'.$first_name.'" required>
                          </div>
                      </div>
                    </div>
                        </div>

                  <div class="row about-extra">
               
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                              <input type="text" id="middle_name'.$id.'" name="middle_name" class="form-control" placeholder="Midle Name" value="'.$middle_name.'">
                          </div>
                      </div>
                    </div>

                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                              <input type="text" id="last_name'.$id.'" name="last_name" class="form-control" placeholder="Last Name" value="'.$last_name.'" required>
                          </div>
                      </div>
                      </div>
                       </div>
                       
                    <div class="row about-extra">
                 
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                       <div class="form-group form-float">
                          <div class="form-line">                                
                        <input type="email" id="email'.$id.'" name="email" class="form-control" placeholder="Email Address" value="'.$email.'" required>
                         </div>
                       </div>
                       </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                              <select id="supervisor_email'.$id.'" class="form-control" >
                              <option selected value="'.$supervisor_email.'">'.getEmailOwnerName($supervisor_email).'</option>';
                               getSupervisors();
                         echo'</select>
                          </div>
                      </div>
                    </div>
                       </div>
                    <div class="row about-extra">
                    
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                             <select class="form-control show-tick" id="account_type'.$id.'" required>
                          <option value="'.$account_type.'" selected>'.getAccountTypeName($account_type).'</option>';
                                listAccountTypes(); 
              echo'        </select>
                          </div>
                      </div>
                      </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                           <input type="text" id="position'.$id.'" name="position" class="form-control" placeholder="Job Title" required value="'.$position.'">
                          </div>
                      </div>
                    </div>
                      </div>
                  <div class="row about-extra">
  
                  
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                       <div class="form-group form-float">
                          <div class="form-line">
                              <select id="business_unit'.$id.'" name="business_unit" class="form-control">
                        <option selected value="'.$business_unit.'">'.getBusinessUnitName($business_unit).'</option>';
                                 listBusinessUnits($_SESSION['client_id']); 
                          echo'</select>
                          </div>
                      </div>
                    </div>


                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                       <div class="form-group form-float">
                          <div class="form-line">
                            <select id="department'.$id.'" name="department" class="form-control" required>
                            <option selected value="'.$department.'">'.getDepartmentName($department).'</option>';
                                 getDepartments();  
               echo'        </select>
                          </div>
                      </div>
                    </div>
            
                    </div>
                  </div>
                                         <div class="modal-footer">
                       <button type="button" class="btn btn-outline-primary" onclick="saveAccount('.$id.')" data-dismiss="modal">Done</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';
    }
    $stmt->close();

    //close conn
    $conn->close();

  }
  function countActiveScorecards($owner,$status){
    $conn=dbconnect();

    $stmt = $conn->prepare("SELECT COUNT(id) as count FROM bsc_scorecards WHERE owner=? AND status=?");
    $stmt->bind_param('ii',$owner,$status);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $count;
  }

    function getEmployeesWithoutScorecards(){

    // Database connection
    $conn = dbconnect();
if($_SESSION['account_type']==1){
   $stmt = $conn->prepare("SELECT id, employee_number, first_name, middle_name, last_name, email, supervisoremail, position, business_unit, department, account_type, date FROM bsc_accounts WHERE client = ? AND account_type > 1");
    $stmt->bind_param('i',$_SESSION['client_id']);
}
elseif($_SESSION['account_type']==2){
   $stmt = $conn->prepare("SELECT id, employee_number, first_name, middle_name, last_name, email, supervisoremail, position, business_unit, department, account_type, date FROM bsc_accounts WHERE client = ? AND business_unit=? AND account_type > 2");
    $stmt->bind_param('ii',$_SESSION['client_id'],$_SESSION['business_unit']);
}
else{
    $stmt = $conn->prepare("SELECT id, employee_number, first_name, middle_name, last_name, email, supervisoremail, position, business_unit, department, account_type, date FROM bsc_accounts WHERE client = ? AND business_unit=? AND department=? AND account_type =4");
    $stmt->bind_param('iii',$_SESSION['client_id'],$_SESSION['business_unit'],$_SESSION['department_id']); 
}
   $account_type=4;
    $account_type=3;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $employee_number, $first_name, $middle_name, $last_name, $email, $supervisor_email, $position, $department, $business_unit, $account_type, $date);
    while($stmt->fetch()){

      if(countActiveScorecards($id,1)>0){

      }else{
      echo '<tr>
        <td>'.$first_name.' '.$last_name.'</td>
        <td>'.$position.'</td>
        <td>'.getDepartmentName($department).'</td>
        <td>'.getSupervisorName($supervisor_email).'</td>
        <td> 
      
        <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Options</button>
        <ul class="dropdown-menu">

         <li><a href="#" data-toggle="modal" data-target="#addScorecard'.$id.'"> <button type="button" class="btn btn-outline-primary">Add Scorecard</button></a></li>
                       
        </ul>
        </div>
        </td>
      </tr>';

      echo'         <div class="modal inmodal fade" id="addScorecard'.$id.'" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h3>Creating a scorecard for <b> '.getEmployeeName($id).' </b>\'s Record</h3>
                                        </div>
                                        <div class="modal-body">
                                   <p align="center"> <h3>An automatic Email will be sent to '.getEmployeeName($id).' </h3> </p>
                                        <input type="hidden" id="department'.$id.'" value="'.$department.'">
                                        </div>

                                        <div class="modal-footer">
                                        <button class="btn btn-outline-info" data-dismiss="modal">No</buuton>
                                            <button type="button" class="btn btn-outline-primary" onClick="addM41('.$id.')" data-dismiss="modal"><i class="fa fa-plus-square"></i> Yes Create</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';                          
    }
  }
    $stmt->close();

    //close conn
    $conn->close();

  }
  function countEmployeesWithoutScorecards(){

    // Database connection
    $conn = dbconnect();
    $count=0;
    $stmt = $conn->prepare("SELECT id FROM bsc_accounts WHERE client = ? AND account_type=?");
    $stmt->bind_param('ii',$_SESSION['client_id'],$account_type);
    $account_type=4;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id);
    while($stmt->fetch()){
      if(countActiveScorecards($id,1)<1){
     $count++;
      }                        
    }
    $stmt->close();
    $conn->close();
    return $count;
  }

      function listEmployeesWithoutScorecards(){

    // Database connection
    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT id, first_name, last_name FROM bsc_accounts WHERE client = ? AND account_type =?");
    $stmt->bind_param('ii',$_SESSION['client_id'],$level_id);
    $level_id = 4;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $first_name,  $last_name);
    while($stmt->fetch()){

      if(countActiveScorecards($id,1)>0){

      }else{
      echo '<option value="'.$id.'">'.$first_name.' '.$last_name.'</option>';                  
    }
  }
    $stmt->close();
    //close conn
    $conn->close();
  }


          function getSupervisorName($par1){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT COUNT(*), first_name, last_name FROM bsc_accounts WHERE email = ?");
    $stmt->bind_param('s', $email);
    $email = test_input($par1);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count,$first_name, $last_name);
    While($stmt->fetch()){
      if($count>0){
        $name= $first_name.' '.$last_name;
      }
      else{
  $name="No supervisor";
      }

    }
    $stmt->close();

    $conn->close();

    return $name;

  }
            function getEmailOwnerName($email){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT COUNT(*), first_name, last_name FROM bsc_accounts WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count,$first_name, $last_name);
    $stmt->fetch();
      if($count>0){
        $name= $first_name.' '.$last_name;
      }
      else{
    $name=$email;
      }
    $stmt->close();
    $conn->close();
    return $name;
  }
                function getScoreCardLevel($scorecard_id){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT level_id FROM bsc_scorecards WHERE id = ?");
    $stmt->bind_param('i', $scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($level_id);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

    return $level_id;
  }

    function getScoreCardDepartment($scorecard_id){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT department_id FROM bsc_scorecards WHERE id = ?");
    $stmt->bind_param('i', $scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($department_id);
    While($stmt->fetch()){

    }
    $stmt->close();

    $conn->close();

    return $department_id;
  }
     function getScoreCardID(){

    $conn = dbconnect();
    if($_SESSION['account_type']==1){
    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE client_id=? AND level_id=?");
    $stmt->bind_param('ii',$_SESSION['client_id'],$level_id);
      $level_id=1;
    }
        elseif($_SESSION['account_type']==2){
    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE client_id=? AND business_unit=? AND level_id=?");
    $stmt->bind_param('iii', $_SESSION['client_id'],$_SESSION['business_unit'], $level_id);
      $level_id=2;
    }
    elseif($_SESSION['account_type']==3){
    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE client_id=? AND department_id=? AND level_id=?");
    $stmt->bind_param('iii', $_SESSION['client_id'],$_SESSION['department_id'],$level_id);
      $level_id=3;
    } else{
    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE owner=? AND level_id=?");
    $stmt->bind_param('ii', $_SESSION['user_id'],$level_id);
      $level_id=4;
    }  
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

    return $scorecard_id;
  }
   function getMyScoreCard(){

    $conn = dbconnect();
 
    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE owner=? AND level_id=?");
    $stmt->bind_param('ii', $_SESSION['user_id'],$level_id);
    $level_id=4;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

    return $scorecard_id;
  } 

     function getScorecardClientId($scorecard_id){

    $conn = dbconnect();
 
    $stmt = $conn->prepare("SELECT client_id FROM bsc_scorecards WHERE id=?");
    $stmt->bind_param('i', $scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($client_id);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

    return $client_id;
  }
   function getMyDeptScoreCard(){

    $conn = dbconnect();
 
    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE department_id=? AND level_id=? AND client_id=?");
    $stmt->bind_param('iii', $_SESSION['department_id'],$level_id,$_SESSION['client_id']);
    $level_id=3;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

    return $scorecard_id;
  } 

     function getHisDeptScoreCard($department_id,$client_id){

    $conn = dbconnect();
 
    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE department_id=? AND level_id=? AND client_id=?");
    $stmt->bind_param('iii', $department_id,$level_id,$client_id);
    $level_id=3;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

    return $scorecard_id;
  } 
              function getClientEmailName($email){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT client FROM bsc_client LEFT JOIN bsc_client_credentials AS c ON c.client_id=bsc_client.client_id WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($client);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $client;
  }
                function getClientEmail($client_id){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT email FROM bsc_client_credentials WHERE client_id = ?");
    $stmt->bind_param('i', $client_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($email);
    While($stmt->fetch()){

    }
    $stmt->close();

    $conn->close();

    return $email;
  }


	//function to add a job seeker
	function addClients($client, $profile, $first_name, $middle_name, $last_name, $gender, $mobile, $phone, $position, $level, $email, $password, $status, $stand_number, $street, $city, $vat_number, $sector, $trade_name){

		$conn = dbconnect();

		$stmt = $conn->prepare("INSERT INTO bsc_client_credentials (email, password, status) VALUES (?,?,?)");
		$stmt->bind_param('sss', $email, $password, $status);
		$stmt->execute();
		$stmt->close();
		$client_id = $conn->insert_id;

		$stmt = $conn->prepare("INSERT INTO bsc_client_contact_details (client_id, first_name, middle_name, last_name, gender, mobile, phone, position, level) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('issssssss', $client_id, $first_name, $midle_name, $last_name, $gender, $mobile, $phone, $postion, $level);
		$stmt->execute();
		$stmt->close();

		$stmt = $conn->prepare("INSERT INTO bsc_client_work_address (client_id, stand_number, street, city) VALUES (?, ?, ?, ?)");
		$stmt->bind_param('isss', $client_id, $stand_number, $street, $city);
		$stmt->execute();
		$stmt->close();

		$stmt = $conn->prepare("INSERT INTO bsc_client_work_details (client_id, company_name, vat_number, sector, tradename) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param('issss', $client_id, $company_name, $vat_number, $sector, $trade_name);
		$stmt->execute();
		$stmt->close();

		$stmt = $conn->prepare("INSERT INTO bsc_client (client_id, client, profile) VALUES (?, ?, ?)");
		$stmt->bind_param('iss', $client_id, $client, $profile);
		$stmt->execute();
		$stmt->close();

		$conn->close();
		echo "<script language=javascript> alert('$company_name was successfully added as a new client'); window.location='../../pages/tables/clients.php'; </script>"; 


	}
  //function to get a list of the clients
  function getClients(){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT client_id, client FROM bsc_client ORDER BY client");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($client_id, $client);
    while($stmt->fetch()){
      echo '<option value="'.$client_id.'">'.$client.'</option>';
    }
    $stmt->close();

    $conn->close();

  }
    function addEmployeeScorecard($last_id, $client_id,$business_unit,$department,$level_id){

    $conn = dbconnect();

    $stmt = $conn->prepare("INSERT INTO bsc_scorecards (client_id, owner, business_unit, department_id, level_id) VALUES (?,?,?,?,?)");
    $stmt->bind_param('iiiii', $client_id,$last_id,$business_unit,$department, $level_id);
    //$level_id=4;
    $stmt->execute();
    $stmt->close();

    $scorecard_id = $conn->insert_id;
    $stmt1 = $conn->prepare("INSERT INTO bsc_comments (scorecard_id, scope) VALUES (?,?)");
    $stmt1->bind_param('ii', $scorecard_id,$scope);
    $scope=2;
    $stmt1->execute();
    $stmt1->close();

    $stmt1 = $conn->prepare("INSERT INTO bsc_comments (scorecard_id, scope) VALUES (?,?)");
    $stmt1->bind_param('ii', $scorecard_id,$scope);
    $scope=1;
    $stmt1->execute();
    $stmt1->close();
    $conn->close();
  }
      function addAccount($client_id,$employee_number, $first_name, $middle_name, $last_name, $position, $supervisor_email, $business_unit, $department, $account_type,$email){

      // Database connection
      $conn = dbconnect();    

      $stmt = $conn->prepare("INSERT INTO bsc_accounts (employee_number, first_name, middle_name, last_name, position, supervisoremail, client, business_unit, department, account_type, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
      $stmt->bind_param('ssssssssssss', $employee_number, $first_name, $middle_name, $last_name, $position, $supervisor_email, $client_id, $business_unit, $department, $account_type, $email, $password);
      $random = rand(0,100000);
      $fullname = test_input($first_name).' IPC '.test_input($last_name);
      $password = 'IPC'.substr((md5($fullname)),0,5).$random;
      $stmt->execute();
      $stmt->close();
      $last_id = $conn->insert_id;
      $level_id=$account_type;
    if($account_type==4 OR $account_type==3){
    addEmployeeScorecard($last_id, $client_id, $business_unit, $department,$level_id);
     }
     
     	$subject = "RE: New Job Ipeform Account Creation";

		$message = "<html>
						<body style='color:#1575a7;'>
							<p>Good day <b>".$first_name." ".$last_name."</b>,</p>
							<p>Your account has been created successfully on iPerform.</p><p>Please find below the login credentials and the link to sign in:</p>
							<p><b>Email:</b> ".$email."</p>
							<p><b>Password:</b> ".$password."</p>
							<p><b>Link to sign in:</b> <a href='https://www.epsychos.net/demo/signin.php'>https://www.epsychos.net/demo/signin.php</a></p>
							<p>Regards,</p>
							<p>Industrial Psychology Consultants (Pvt) Ltd</p>
					</html>";
		$message1 = "<html>
						<body style='color:#1575a7;'>
							<p>Good day team,</p>
							<p><b>".$first_name." ".$last_name."</b> of <b>".getClientName($client_id)."</b> has registered on Iperform system. Sign in to view more details.</p>
							<p>Link to sign in: <a href='https://www.epsychos.net/demo/signin.php'>https://www.epsychos.net/demo/signin.php</a></p>
							<p>Regards,</p>
							<p>Administrator</p>
					</html>";
					
			$headers = "From:  Industrial Psychology Consultants" . strip_tags('admin@epsychos.net') . "\r\n";
			$headers .= "Reply-To: ". strip_tags('bis@ipcconsultants.com') . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			
			$admin='bis@ipcconsultants.com';

		 mail($email, $subject, $message, $headers);
		 mail($admin, $subject, $message1, $headers);

      //close conn
      $conn->close();

    }
          function signup($first_name, $last_name,$email,$account_type,$client_id,$department_id){

      // Database connection
      $conn = dbconnect();    

      $stmt = $conn->prepare("INSERT INTO bsc_accounts (first_name, last_name, client, email,department, account_type, password) VALUES (?, ?, ?,?, ?, ?,?)");
      $stmt->bind_param('sssssss', $first_name, $last_name, $client_id, $email,$department_id,$account_type,$password);

      $random = rand(0,100000);
      $fullname = test_input($first_name).' IPC '.test_input($last_name);
      $password = 'IPC'.substr((md5($fullname)),0,5).$random;
      $stmt->execute();
      $stmt->close();
      $last_id = $conn->insert_id;

    addEmployeeScorecard($last_id, $client,$department_id);
      //close conn
      $conn->close();

      echo "<script type='text/javascript'>
        window.location.href = 'signup?success=true';
        </script>";
    }

    function modifyscorecardDepartment($id,$department){
      $conn=dbconnect();

      $stmt=$conn->prepare("UPDATE bsc_scorecards SET department_id=?  WHERE owner=?");
      $stmt->bind_param('ii',$department,$i);
      $stmt->execute();
      $stmt->close();
      $conn->close();

    }


    function getModifyAccount($id, $client_id, $employee_number, $first_name, $middle_name, $last_name, $position, $supervisor_email,$business_unit,$department, $email, $account_type){

      // Database connection
      $conn = dbconnect();    

      $stmt = $conn->prepare("UPDATE bsc_accounts SET employee_number = ?, first_name = ?, middle_name = ?, last_name = ?, position = ?, supervisoremail = ?, client = ?, business_unit=?, department = ?, email = ?,account_type = ? WHERE id = ?");
      $stmt->bind_param('sssssssssssi', $employee_number, $first_name, $middle_name, $last_name, $position, $supervisor_email, $client_id, $business_unit, $department,$email, $account_type, $id);
      $stmt->execute();
      $stmt->close();

      modifyscorecardDepartment($id,$department);

      //close conn
      $conn->close();

    echo "<script type='text/javascript'>
        window.location.href = 'accounts.php';
        </script>";
    }
    //function to get client name
  function getClientName($par1){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT client FROM bsc_client WHERE client_id = ?");
    $stmt->bind_param('i', $id);
    $id = test_input($par1);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($client);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

    return $client;

  }

 //function to get address details to change
 function getClientAddressDetailsToChange(){

    $conn = dbconnect();
    $client_id=$_GET['client_id'];
    $stmt = $conn->prepare("SELECT stand_number, street, city FROM bsc_client_work_address WHERE client_id = ?");
    $stmt->bind_param('i', $client_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($stand_number, $street, $city);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

    echo '    
                <table class="col-sm-9">
                    <tr>
                     <td><label class="form-label">Stand No.</label></td>
                     <td><input type="text" value="'.$stand_number.'" name="stand_number" required  id="email_address" class="form-control"></td>
                    </tr>
                    <tr>
                     <td><label class="form-label"><label class="form-label">Street/Road</label></label></td>
                     <td><input type="text" value="'.$street.'" name="street" id="street" class="form-control"></td>

                    </tr>
                    <tr>
                     <td><label class="form-label">Street/Road</label></td>
                     <td><input type="text" value="'.$street.'" name="street" id="street" class="form-control"></td>

                    </tr>

                    </tr>
                    <tr>
                     <td><label class="form-label">City</label></td>
                     <td><input type="text" value="'.$city.'" name="street" id="street" class="form-control"></td>

                    </tr>

                    </tr>
                    <tr>
                     <td><label class="form-label">City</label></td>
                     <td><input type="text" value="'.$city.'" name="street" id="street" class="form-control"></td>
                    </tr>
                    </tr>
                    <tr>
                     <td><label class="form-label">Country</label></td>
                     <td><div class="form-group form-float">
                <div class="form-line">
                    <input type="text" name="country" value="Zimbabwe" class="form-control">
  
                </div>
              </div></td>
                    </tr>
                </table>        
              ';
  }
    //function to save saveadress chnages
  function saveAddressChanges($par1, $par2, $par3){

    $conn = dbconnect();
    $client_id=$_GET['client_id'];
    $stmt = $conn->prepare("UPDATE bsc_client_work_address SET stand_number = ?, street = ?, city = ? WHERE client_id = ?");
    $stmt->bind_param('sssi', $stand_number, $street, $city, $client_id);
    $stand_number = test_input($par1);
    $street = test_input($par2);
    $city = test_input($par3);
    $stmt->execute();
    $stmt->close();

    $conn->close();

    echo "<script type='text/javascript'>
        window.location.href = 'client.php';
        </script>";

  }

  	//function to send notifications to people
	function notifyClients($email){

		$conn = dbconnect();
		$stmt = $conn->prepare("SELECT email, password, client FROM bsc_client_credentials AS c INNER JOINbsc_ client ON c.client_id=bsc_client.client_id  WHERE email = ?");
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($email, $password, $client);
		while($stmt->fetch()){

			//send email
			$to = $email; 

			$headers = "From:  Industrial Psychology Consultants" . strip_tags('do_not_reply@ipcjobsportal.com') . "\r\n";
			$headers .= "Reply-To: ". strip_tags('do_not_reply@ipcjobsportal.com') . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			$subject = "RE: Company Profile Creation";

			$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Industrial psychology consultants</title>
  <style type="text/css">

  img {
    max-width: 600px;
    outline: none;
    text-decoration: none;
    -ms-interpolation-mode: bicubic;
  }

  a {
    border: 0;
    outline: none;
  }

  a img {
    border: none;
  }

  /* General styling */

  td, h1, h2, h3  {
    font-family: Helvetica, Arial, sans-serif;
    font-weight: 400;
  }

  td {
    font-size: 13px;
    line-height: 19px;
    text-align: left;
  }

  body {
    -webkit-font-smoothing:antialiased;
    -webkit-text-size-adjust:none;
    width: 100%;
    height: 100%;
    color: #37302d;
    background: #ffffff;
  }

  table {
    border-collapse: collapse !important;
  }


  h1, h2, h3, h4 {
    padding: 0;
    margin: 0;
    color: #444444;
    font-weight: 400;
    line-height: 110%;
  }

  h1 {
    font-size: 35px;
  }

  h2 {
    font-size: 30px;
  }

  h3 {
    font-size: 24px;
  }

  h4 {
    font-size: 18px;
    font-weight: normal;
  }

  .important-font {
    color: #21BEB4;
    font-weight: bold;
  }

  .hide {
    display: none !important;
  }

  .force-full-width {
    width: 100% !important;
  }

  </style>

  <style type="text/css" media="screen">
      @media screen {
        @import url(http://fonts.googleapis.com/css?family=Open+Sans:400);

        /* Thanks Outlook 2013! */
        td, h1, h2, h3 {
          font-family: "Open Sans", "Helvetica Neue", Arial, sans-serif !important;
        }
      }
  </style>

  <style type="text/css" media="only screen and (max-width: 600px)">
    /* Mobile styles */
    @media only screen and (max-width: 600px) {

      table[class="w320"] {
        width: 320px !important;
      }

      table[class="w300"] {
        width: 300px !important;
      }

      table[class="w290"] {
        width: 290px !important;
      }

      td[class="w320"] {
        width: 320px !important;
      }

      td[class~="mobile-padding"] {
        padding-left: 14px !important;
        padding-right: 14px !important;
      }

      td[class*="mobile-padding-left"] {
        padding-left: 14px !important;
      }

      td[class*="mobile-padding-right"] {
        padding-right: 14px !important;
      }

      td[class*="mobile-padding-left-only"] {
        padding-left: 14px !important;
        padding-right: 0 !important;
      }

      td[class*="mobile-padding-right-only"] {
        padding-right: 14px !important;
        padding-left: 0 !important;
      }

      td[class*="mobile-block"] {
        display: block !important;
        width: 100% !important;
        text-align: left !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        padding-bottom: 15px !important;
      }

      td[class*="mobile-no-padding-bottom"] {
        padding-bottom: 0 !important;
      }

      td[class~="mobile-center"] {
        text-align: center !important;
      }

      table[class*="mobile-center-block"] {
        float: none !important;
        margin: 0 auto !important;
      }

      *[class*="mobile-hide"] {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
        line-height: 0 !important;
        font-size: 0 !important;
      }

      td[class*="mobile-border"] {
        border: 0 !important;
      }
    }
  </style>
</head>
<body class="body" style="padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none" bgcolor="#ffffff">
<table align="center" cellpadding="0" cellspacing="0" width="100%" height="100%">
  <tr>
    <td align="center" valign="top" bgcolor="#ffffff"  width="100%">

    <table cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td style="background:#ffffff" width="100%">

            <table cellspacing="0" cellpadding="0" width="600" class="w320">
              <tr>
                <td valign="top" class="mobile-block mobile-no-padding-bottom mobile-center" width="270" style="background:#ffffff;padding:10px 10px 10px 20px;">
                  <a href="#" style="text-decoration:none;">
                    <img src="https://www.ipcjobsportal.com/images/logo.jpg" width="135" height="80" alt="Our Logo"/>
                  </a>
                </td>
                <td valign="top" class="mobile-block mobile-center" width="270" style="background:#ffffff;padding:10px 15px 10px 10px">
                  <table border="0" cellpadding="0" cellspacing="0" class="mobile-center-block" align="right">
                    <tr>
                      <td align="center">
                        <a href="https://www.facebook.com/IPCConsultants"/>
                        <img src="http://www.ipcjobsportal.com/images/social_facebook.png"  width="30" height="30" alt="social icon"/>
                        </a>
                      </td>
                      <td align="center" style="padding-left:5px">
                        <a href="https://twitter.com/ipcconsultants">
                        <img src="http://www.ipcjobsportal.com/images/social_twitter.png"  width="30" height="30" alt="social icon"/>
                        </a>
                      </td>
                      <td align="center" style="padding-left:5px">
                        <a href="https://www.linkedin.com/company/industrial-psychology-consultants-pvt-ltd/">
                        <img src="http://www.ipcjobsportal.com/images/social_linkedin.png"  width="30" height="30" alt="social icon"/>
                        </a>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>

        </td>
      </tr>
      <tr>
        <td style="border-bottom:1px solid #e7e7e7;">

        
            <table cellpadding="0" cellspacing="0" width="600" class="w320">
              <tr>
                <td align="left" class="mobile-padding" style="padding:20px 20px 0">

                  <table cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                      <td style="padding-top:8px;padding-bottom:10px">
                        <h4>Good day "'.$client.'"</h4>
                      </td>
                    </tr>
                  </table>

                  <div class="textdark">
                   <p> Please note that Your Profile has been created for the Online balanced scorecard You can follow this link to access your account and start adding scorecards. </p>
				   <p>Please find your Credentials</p>
				   <p>Email: "'.$email.'"</p>
				   <p>Password: "'.$password.'"</p>
                  </div>
                  <br>
                  <hr>
                  <div>
                  </div>
                  <br>
                  <hr>
                 <div class="row">
                  <div class="textdark">
                    Regards
                  </div>
                  <hr>
                  <h4><b>Admin</b></h4>
                  <br><br>
              </tr>
            </table>
       

        </td>
      </tr>
      <tr>
        <td style="background-color:#ffffff;">
       
            <table border="0" cellpadding="0" cellspacing="0" width="600" class="w320" style="height:100%;color:#ffffff" bgcolor="#ffffff" >
              <tr>
                <td align="right" valign="middle" class="mobile-padding" style="font-size:12px;padding:20px; background-color:#175ae8; color:#ffffff; text-align:left; ">
                  <a style="color:#ffffff;"  href="http://ipcconsultants.com/contact/">Contact Us</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                  <a style="color:#ffffff;" href="https://www.facebook.com/IPCConsultants/">Facebook</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                  <a style="color:#ffffff;" href="https://twitter.com/ipcconsultants">Twitter</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                  <a style="color:#ffffff;" href="https://www.linkedin.com/company/industrial-psychology-consultants-pvt-ltd/">LinkedIn</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                </td>
              </tr>
            </table>
      
        </td>
      </tr>
    </table>

    </td>
  </tr>
</table>
</body>
</html>';
						

			mail($to, $subject, $message, $headers);
			}
		$stmt->close();

		$conn->close();

	}
    //function to add a job seeker
  function addScorecard($client_id){

    $conn = dbconnect();

    $stmt = $conn->prepare("INSERT INTO scorecards (client_id, level_id) VALUES (?,?)");
    $stmt->bind_param('ss', $client_id,$level_id);
    $level_id=1;
    $stmt->execute();
    $stmt->close();

    $last_id = $conn->insert_id;
    $stmt1 = $conn->prepare("INSERT INTO comments (scorecard_id, scope) VALUES (?,?)");
    $stmt1->bind_param('ii', $last_id,$scope);
    $scope=2;
    $stmt1->execute();
    $stmt1->close();

    $stmt1 = $conn->prepare("INSERT INTO comments (scorecard_id, scope) VALUES (?,?)");
    $stmt1->bind_param('ii', $last_id,$scope);
    $scope=1;
    $stmt1->execute();
    $stmt1->close();
    $conn->close();
  }

  function updateSummary($platinum,$gold,$diamond,$silver,$bronze,$nickel){
     $conn=dbconnect();

  $stmt=$conn->prepare("UPDATE bsc_summary_ratings SET platinum=?, gold=?, diamond=?, silver=?, bronze=?, nickel=? WHERE client_id=?");
  $stmt->bind_param('iiiiiii',$platinum,$gold,$diamond,$silver,$bronze,$nickel,$client_id);
  $client_id=$_SESSION['client_id'];
  $stmt->execute();
  $stmt->close();
  $conn->close();  
     echo "<script type='text/javascript'>
        window.location.href = 'client.php';
        </script>";
}
  //function to add a job seeker
  
  function addClientScorecard($client_id,$leader,$reporting_period,$platinum,$gold,$diamond,$silver,$bronze,$nickel){

    $conn = dbconnect();

    $stmt = $conn->prepare("INSERT INTO bsc_scorecards (client_id, leader, reporting_period, level_id) VALUES (?,?,?,?)");
    $stmt->bind_param('ssss', $client_id,$leader,$reporting_period,$level_id);
    $level_id=1;
    $stmt->execute();
    $stmt->close();

    $last_id = $conn->insert_id;
    $stmt1 = $conn->prepare("INSERT INTO bsc_comments (scorecard_id, scope) VALUES (?,?)");
    $stmt1->bind_param('ii', $last_id,$scope);
    $scope=2;
    $stmt1->execute();
    $stmt1->close();

    $stmt1 = $conn->prepare("INSERT INTO bsc_summary_ratings (client_id, platinum,gold,diamond,silver, bronze, nickel) VALUES (?,?,?,?,?,?,?)");
    $stmt1->bind_param('iiiiiii', $client_id,$platinum,$gold,$diamond,$silver,$bronze,$nickel);
    $stmt1->execute();
    $stmt1->close();

    $stmt1 = $conn->prepare("INSERT INTO bsc_comments (scorecard_id, scope) VALUES (?,?)");
    $stmt1->bind_param('ii', $last_id,$scope);
    $scope=1;
    $stmt1->execute();
    $stmt1->close();
    $conn->close();
    echo "<script type='text/javascript'>
        window.location.href = 'scorecard/".$last_id."';
        </script>";
  }

  function addM2Scorecard($client_id, $reporting_period,$business_unit){

    $conn = dbconnect();

    $stmt = $conn->prepare("INSERT INTO bsc_scorecards (client_id, reporting_period, business_unit, level_id) VALUES (?,?,?,?)");
    $stmt->bind_param('isii', $client_id,$reporting_period, $business_unit, $level_id);
    $level_id=2;
    $stmt->execute();
    $stmt->close();

    $scorecard_id = $conn->insert_id;
    $stmt1 = $conn->prepare("INSERT INTO bsc_comments (scorecard_id, scope) VALUES (?,?)");
    $stmt1->bind_param('ii', $scorecard_id,$scope);
    $scope=2;
    $stmt1->execute();
    $stmt1->close();

    $stmt1 = $conn->prepare("INSERT INTO bsc_comments (scorecard_id, scope) VALUES (?,?)");
    $stmt1->bind_param('ii', $scorecard_id,$scope);
    $scope=1;
    $stmt1->execute();
    $stmt1->close();
    $conn->close();
   // echo "<script language=javascript> alert('scorecard was successfully added'); window.location='scorecards.php?departmental'; </script>"; 
  }
        //function to add a job seeker
  function addM3Scorecard($client_id, $reporting_period,$business_unit,$department_id,$owner){

    $conn = dbconnect();

    $stmt = $conn->prepare("INSERT INTO bsc_scorecards (client_id, reporting_period, business_unit, department_id, level_id, owner) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param('isiiii', $client_id,$reporting_period, $business_unit, $department_id, $level_id,$owner);
    $level_id=3;
    $stmt->execute();
    $stmt->close();

    $scorecard_id = $conn->insert_id;
    $stmt1 = $conn->prepare("INSERT INTO bsc_comments (scorecard_id, scope) VALUES (?,?)");
    $stmt1->bind_param('ii', $scorecard_id,$scope);
    $scope=2;
    $stmt1->execute();
    $stmt1->close();

    $stmt1 = $conn->prepare("INSERT INTO bsc_comments (scorecard_id, scope) VALUES (?,?)");
    $stmt1->bind_param('ii', $scorecard_id,$scope);
    $scope=1;
    $stmt1->execute();
    $stmt1->close();
    $conn->close();
   // echo "<script language=javascript> alert('scorecard was successfully added'); window.location='scorecards.php?departmental'; </script>"; 
  }
      //function to add a job seeker
  function addM4Scorecard($client_id, $employee){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT business_unit, department FROM bsc_accounts WHERE id=?");
    $stmt->bind_param('i', $employee);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($business_unit, $department_id);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO bsc_scorecards (client_id, owner, business_unit, department_id, level_id) VALUES (?,?,?,?,?)");
    $stmt->bind_param('iiiii', $client_id,$employee, $business_unit, $department_id, $level_id);
    $level_id=4;
    $stmt->execute();
    $stmt->close();

    $scorecard_id = $conn->insert_id;
    $stmt1 = $conn->prepare("INSERT INTO bsc_comments (scorecard_id, scope) VALUES (?,?)");
    $stmt1->bind_param('ii', $scorecard_id,$scope);
    $scope=2;
    $stmt1->execute();
    $stmt1->close();

    $stmt1 = $conn->prepare("INSERT INTO bsc_comments (scorecard_id, scope) VALUES (?,?)");
    $stmt1->bind_param('ii', $scorecard_id,$scope);
    $scope=1;
    $stmt1->execute();
    $stmt1->close();
    $conn->close();
     // echo "<script language=javascript> alert('scorecard was successfully added'); window.location='scorecards.php?addm3=true'; </script>"; 
  }
   function addMyScorecard($client_id, $reporting_period,$employee,$business_unit, $department_id){

    $conn = dbconnect();

    $stmt = $conn->prepare("INSERT INTO bsc_scorecards (client_id, owner, reporting_period, business_unit, department_id, level_id) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param('iisiii', $client_id,$employee,$reporting_period, $business_unit, $department_id, $level_id);
    $level_id=4;
    $stmt->execute();
    $stmt->close();

    $scorecard_id = $conn->insert_id;
    $stmt1 = $conn->prepare("INSERT INTO bsc_comments (scorecard_id, scope) VALUES (?,?)");
    $stmt1->bind_param('ii', $scorecard_id,$scope);
    $scope=2;
    $stmt1->execute();
    $stmt1->close();

    $stmt1 = $conn->prepare("INSERT INTO bsc_comments (scorecard_id, scope) VALUES (?,?)");
    $stmt1->bind_param('ii', $scorecard_id,$scope);
    $scope=1;
    $stmt1->execute();
    $stmt1->close();
    $conn->close();
        echo "<script type='text/javascript'>
          window.location.href = 'scorecard/".$scorecard_id."'
          </script>"; 
  }
  	//function to add a job seeker
	function addClient($client, $email, $password){

		$conn = dbconnect();

		$stmt = $conn->prepare("INSERT INTO bsc_client (client) VALUES (?)");
		$stmt->bind_param('s', $client);
		$stmt->execute();
		$stmt->close();
		$client_id = $conn->insert_id;

		$stmt = $conn->prepare("INSERT INTO bsc_client_credentials (client_id, email, password) VALUES (?,?,?)");
		$stmt->bind_param('sss', $client_id, $email, $password);
		$stmt->execute();
		$stmt->close();
    addScorecard($client_id);
		notifyClients($email);
		$conn->close();
		echo "<script language=javascript> alert('$client was successfully added as a new client'); window.location='client.php'; </script>"; 


	}
	  //function to get address details of the client
  function getClientAddress(){

    $conn = dbconnect();
    $client_id=$_GET['client_id'];
    $stmt = $conn->prepare("SELECT client_id, stand_number, street, city FROM bsc_client_work_address WHERE client_id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($client_id, $stand_number, $street, $city);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

    echo '<tr><td>Stand No.</td><td>'.$stand_number.'</td></tr><tr><td>Street/Road</td><td>'.$street.'</td></tr><tr><td>City</td><td> '.$city.'</td></tr><tr><td>Country</td><td> Zimbabwe</td></tr>';

  }
		//function to get work details for client
	function getClientWorkDetails(){

		$conn = dbconnect();
        $client_id=$_GET['client_id'];
		$stmt = $conn->prepare("SELECT client_id, company_name, vat_number, sector, tradename FROM bsc_client_work_details WHERE client_id = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($client_id, $company_name, $vat_number, $sector, $trade_name);
		$stmt->fetch();
		$stmt->close();

		$conn->close();

		echo '<tr><td>Company Name</td><td>'.$company_name.'</td></tr><tr><td>VAT Number</td><td>'.$vat_number.'</td></tr><tr><td>Sector</td><td> '.$sector;  echo '</td></tr><tr><td>Trade Name</td><td>'.$trade_name.'</td></tr>';

	}

	function getCategoryName($par1){

		$conn = dbconnect();

		$stmt = $conn->prepare("SELECT category FROM bsc_category WHERE category_id = ?");
		$stmt->bind_param('i', $id);
		$id = test_input($par1);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($category);
		$stmt->fetch();
		$stmt->close();

		$conn->close();

		return $category;

	}
    function getPerspectiveName($id){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT name FROM bsc_perspectives WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

    return $name;

  }
      function getgoalName($id){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT goal FROM bsc_goals WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

    return $name;

  }
		//function to read employers
		function getClientToEdit(){

			// Database connection
			$conn = dbconnect();
	         $client_id=$_GET['client_id'];
			//read admin
			$stmt = $conn->prepare("SELECT cwd.client_id, cwd.company_name, cwd.vat_number, cwd.sector, cwd.tradename, ccd.first_name, ccd.middle_name, ccd.last_name, ccd.gender, ccd.mobile, ccd.phone, ccd.position, ccd.level, cc.email, cc.status, cc.date_time, cwa.stand_number, cwa.street, cwa.city FROM bsc_client_work_details AS cwd INNER JOIN bsc_client_contact_details AS ccd ON cwd.client_id = ccd.client_id INNER JOIN bsc_client_credentials AS cc ON cwd.client_id = cc.client_id INNER JOIN bsc_client_work_address AS cwa ON cwd.client_id = cwa.client_id WHERE cc.client_id=?");
			$stmt ->bind_param('i', $client_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($client_id, $company_name, $vat_number, $sector, $tradename, $first_name, $middle_name, $last_name, $gender, $mobile, $phone, $position, $level, $email, $status, $date_time, $stand_number, $street, $city);
			while($stmt->fetch()){
		echo'  <form action="" method="POST">                                    
		<div class="form-group form-float">
			<div class="form-line">
				<input name="name" class="form-control" required value="'.$company_name.'">
				<label class="form-label">Company Name</label>
			</div>
		</div>
		<div class="form-group form-float">
			<div class="form-line">
				<input name="vat_number" class="form-control"  value="'.$vat_number.'">
				<label class="form-label">vat_number</label>
			</div>
		</div>
		<div class="form-group form-float">
			<div class="form-line">
				<select name="sector" class="form-control" required>
				<option>'.$sector.'</option>
				<option value="" selected disabled>SELECT BUSINESS SECTOR </option>';
				getSectors();
	  echo'   </select>
			</div>
		</div>
		<div class="form-group form-float">
			<div class="form-line">
				<input name="tradename" class="form-control" required value="'.$tradename.'">
				<label class="form-label">Trade Name</label>
			</div>
		</div>
		<div class="form-group form-float">
			<div class="form-line">
				<input name="stand_number" class="form-control" required value="'.$stand_number.'">
				<label class="form-label">Stand Number</label>
			</div>
		</div>
		<div class="form-group form-float">
			<div class="form-line">
				<input name="street" class="form-control" required value="'.$street.'">
				<label class="form-label">Street</label>
			</div>
		</div>
		<div class="form-group form-float">
			<div class="form-line">
				<select name="city" class="form-control" required>
				<option value="'.$city.'">'.$city.'</option>
				<option value="" selected disabled> SELECT CITY </option>';
			  getCity();
echo'     </select>
		   </div>
		</div>
		<div class="form-group form-float">
			<div class="form-line">
				<input name="first_name" class="form-control" required value="'.$first_name.'">
				<label class="form-label">Contact Person First Name</label>
			</div>
		</div>
		<div class="form-group form-float">
			<div class="form-line">
				<input name="middle_name" class="form-control" required value="'.$first_name.'">
				<label class="form-label">Contact Person Middle Name</label>
			</div>
		</div>
		<div class="form-group form-float">
			<div class="form-line">
				<input name="last_name" class="form-control" required value="'.$last_name.'">
				<label class="form-label">Contact Person Last Name</label>
			</div>
		</div>
		<div class="form-group form-float">
			<div class="form-line">
				<select name="gender" class="form-control" required >
				<option value="'.$gender.'" selected>'.$gender.'</option>
				<option value="" disabled>SELECT CONTACT PERSON GENDER</option>
				<option>male</option>
				<option>female</option>
			</select>
			</div>
		</div>
		<div class="form-group form-float">
			<div class="form-line">
				<input name="mobile" class="form-control" required value="'.$mobile.'">
				<label class="form-label">Mobile Number</label>
			</div>
		</div>
		<div class="form-group form-float">
			<div class="form-line">
				<input name="phone" class="form-control" required value="'.$phone.'">
				<label class="form-label">Company Telephone</label>
			</div>
		</div>
		<div class="form-group form-float">
			<div class="form-line">
				<select name="position" class="form-control" required>
				<option value="'.$job_title.'">'.$job_title.'</option>
				<option value="" selected disabled>Contact Person Position</option>';
				getJobTitle();
echo'        </select>
		</div>
		</div>
		<div class="form-group form-float">
			<div class="form-line">
				<input type="email" name="email" class="form-control" required value="'.$email.'">
				<label class="form-label">Business Email</label>
			</div>
		</div>
		<div class="form-group form-float">
			<div class="form-line">
				<input type="password" name="password" class="form-control" required minlength="8" value="'.$password.'">
				<label class="form-label">Password</label>
			</div>
		</div>
	  </div>
		</div>
		
	<button type="submit" class="btn btn-success m-t-15 waves-effect" name="save">SAVE CLIENT</button> <button type="reset" class="btn btn-danger m-t-15 waves-effect">RESET FORM</button>
</form> ';
	
			}
			$stmt->close();
	
			//close conn
			$conn->close();
	
		}

	//function to save the employer
	function saveClient($company_name, $vat_number, $sector, $tradename, $first_name, $middle_name, $last_name, $gender, $mobile, $phone, $position, $level, $email, $password, $status, $stand_number, $street, $city){

		$conn = dbconnect();

		$stmt = $conn->prepare("INSERT INTO bsc_client_credentials (email, password, status) VALUES (?, ?, ?)");
		$stmt->bind_param('ssi', $email, $password, $status);
		$stmt->execute();
		$stmt->close();
		$last_id = $conn->insert_id;

		$stmt = $conn->prepare("INSERT INTO bsc_client_contact_details (client_id, first_name, middle_name, last_name, gender, mobile, phone, position, level) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('issssssss', $last_id, $first_name, $middle_name, $last_name, $gender, $mobile, $phone, $position, $level);
		$stmt->execute();
		$stmt->close();

		$stmt = $conn->prepare("INSERT INTO bsc_client_work_address (client_id, stand_number, street, city) VALUES (?, ?, ?, ?)");
		$stmt->bind_param('isss', $last_id, $stand_number, $street, $city);
		$stmt->execute();
		$stmt->close();

		$stmt = $conn->prepare("INSERT INTO bsc_client_work_details (client_id, company_name, vat_number, sector, tradename) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param('issss', $last_id, $company_name, $vat_number, $sector, $tradename);
		$stmt->execute();
		$stmt->close();

		auditTrail(test_input($_SESSION['admin_id']), 'Create', 'Adding new client with id: '.$last_id.'. ', 'client_credentials ; client_contact_details ; client_work_address ; client_work_details', 'Consultant');

		$conn->close();

		   echo "<script type='text/javascript'>
          window.location.href = 'clients.php?success=true'
          </script>";


	}

		//function to get profile changes
	function getClientWorkDetailsToChange(){

		$conn = dbconnect();
        $client_id=$_GET['client_id'];
		$stmt = $conn->prepare("SELECT company_name, vat_number, sector, tradename FROM bsc_client_work_details WHERE client_id = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($company_name, $vat_number, $sector, $trade_name);
		$stmt->fetch();
		$stmt->close();

		$conn->close();

		echo '
      <div class="form-group profile-forms ">
      <table width:100% class=" col-sm-10">
          <tr>
            <td><label class="form-label">Company Name</label></td>
            <td><input type="text" value="'.$company_name.'" name="company_name" required  id="email_address" class="form-control"></td>
        </tr>

        <tr>
            <td><label class="form-label">VAT Number</label></td>
            <td><input type="text" value="'.$vat_number.'" name="vat_number" required id="vat_number" class="form-control"></td>
        </tr>
        <tr>
            <td><label class="form-label">Tradename</label></td>
            <td><input type="text" value="'.$trade_name.'" name="trade_name"  id="sector" class="form-control"></td>
        </tr>
        <tr>
            <td> Sector</td>
            <td>
                <select name="sector"class="form-control show-tick" data-live-search="true">
                      <option value ='.$sector.' >'.getCategoryName($sector).'</option>
                    '; echo getCategoryList(); echo '
                  </select>

            </td>
        </tr>





      </table>
                
          ';

	}
	//function to get  client contact details to change
  function getClientContactDetailsToChange(){

    $conn = dbconnect();
    $client_id=$_GET['client_id'];
    $stmt = $conn->prepare("SELECT client_id, first_name,  middle_name, last_name, gender,  mobile,  phone, position, level   FROM bsc_client_contact_details WHERE client_id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($client_id, $first_name, $middle_name, $last_name, $gender, $mobile, $phone, $position, $level);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

    echo '<div class="form-group">
     First Name
                <div class="input-group">
                  <div class="input-group-prepend">

                    <span class="input-group-text bg-transparent">
                      
                    </span>
                  </div>
                  <input type="text" class="form-control" name="first_name" placeholder="Stand No." value="'.$first_name.'" aria-label="First Name" aria-describedby="colored-addon1" required>
                </div>
              </div>
              <div class="form-group">
                  middle_name
                <div class="input-group">
                  <div class="input-group-prepend ">
                    <span class="input-group-text bg-transparent">
                  
                    </span>
                  </div>
                  <input type="text" class="form-control" name="middle_name" placeholder="middle name" value="'.$middle_name.'" aria-label="Last Name" aria-describedby="colored-addon1" required>
                </div>
              </div>
              <div class="form-group">
                   Last Name
                <div class="input-group">
                  <div class="input-group-prepend ">
                    <span class="input-group-text bg-transparent">
                 
                    </span>
                  </div>
                  
                  <input type="text" class="form-control" name="last_name" placeholder="last name" value="'.$last_name.'" aria-label="Email Address" aria-describedby="colored-addon1" required>
                </div>
              </div>
              <div class="form-group">
               Gender
                <div class="input-group">
                  <div class="input-group-prepend ">
                    <span class="input-group-text bg-transparent">
                     
                    </span>
                  </div>
                  
                  <select class="form-control" name="last_name" placeholder="gender"aria-label="Email Address" aria-describedby="colored-addon1" required>
                  <option>'.$gender.'</option>
                   <option>Female</option>
                    <option>Male</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                Mobile
                <div class="input-group">
                  <div class="input-group-prepend ">
                    <span class="input-group-text bg-transparent">
                    
                    </span>
                  </div>
                  
                  <input type="text" class="form-control" name="mobile" placeholder="mobile" value="'.$mobile.'" aria-label="Email Address" aria-describedby="colored-addon1" required>
                </div>
              </div>
              <div class="form-group">
              Phone
                <div class="input-group">
                  <div class="input-group-prepend ">
                    <span class="input-group-text bg-transparent">
                      
                    </span>
                  </div>
                  
                  <input type="text" class="form-control" name="phone" placeholder="telephone" value="'.$phone.'" aria-label="Email Address" aria-describedby="colored-addon1" required>
                </div>
              </div>
              <div class="form-group">
               Position
                <div class="input-group">
                  <div class="input-group-prepend ">
                    <span class="input-group-text bg-transparent">
                     
                    </span>
                  </div>
                  
                  <input type="text" class="form-control" name="position" placeholder="position" value="'.$position.'" aria-label="Email Address" aria-describedby="colored-addon1" required>
                </div>
              </div>
              <div class="form-group">
                 Level
                <div class="input-group">
                  <div class="input-group-prepend ">
                    <span class="input-group-text bg-transparent">
                   
                    </span>
                  </div>
                  
                  <select class="form-control" name="level" placeholder="last name" aria-label="Email Address" aria-describedby="colored-addon1" required>
                     <option>'.$level.'</option>
                     <option>Executive</option>
                     <option>Managerial</option>
                     <option>Non Managerial</option>
                  </select>
                </div>
              </div>';

  }

	//function to edit the employer details
	function editClient($company_name, $vat_number, $sector, $tradename, $first_name, $middle_name, $last_name, $gender, $mobile, $phone, $position, $level, $email, $password, $status, $stand_number, $street, $city, $client_id){

		$conn = dbconnect();
        $client_id=$_GET['client_id'];
		$stmt = $conn->prepare("UPDATE bsc_client_credentials SET email = ?, password = ?, status = ? WHERE client_id = '$client_id'");
		$stmt->bind_param('sss', $email, $password, $status);
		$stmt->execute();
		$stmt->close();

		$stmt = $conn->prepare("UPDATE bsc_client_contact_details SET first_name = ?, middle_name = ?, last_name = ?, gender = ?, mobile = ?, phone = ?, position = ?, level = ? WHERE client_id = ?");
		$stmt->bind_param('ssssssssi', $first_name, $middle_name, $last_name, $gender, $mobile, $phone, $position, $level, $client_id);
		$stmt->execute();
		$stmt->close();

		$stmt = $conn->prepare("UPDATE bsc_client_work_address SET stand_number = ?, street = ?, city = ? WHERE client_id = ?");
		$stmt->bind_param('sssi', $stand_number, $street, $city, $client_id);
		$stmt->execute();
		$stmt->close();

		$stmt = $conn->prepare("UPDATE bsc_client_work_details SET company_name = ?, vat_number = ?, sector = ?, tradename = ? WHERE client_id = ?");
		$stmt->bind_param('ssssi', $company_name, $vat_number, $sector, $tradename, $client_id);
		$stmt->execute();
		$stmt->close();

		$conn->close();

		   echo "<script type='text/javascript'>
          window.location.href = 'clients.php?success=true'
          </script>";


	}


	//function to update consultants
	function updateAdmin($par1, $par2, $par3, $par4, $par5, $par6){

		// Database connection
		$conn = dbconnect();

		//update consultant
		$stmt = $conn->prepare("UPDATE admin SET first_name = ?, last_name = ?, email = ?, account_type = ?, password = ? WHERE admin_id = ?");
		$stmt->bind_param('sssssi', $first_name, $last_name, $email, $account_type, $password, $admin_id);
		$first_name = test_input($par1);
		$last_name = test_input($par2);
		$email = test_input($par3);
		$account_type = test_input($par4); 
		$password = test_input($par5); 
		$admin_id = test_input($par6);
		$stmt->execute();
		$stmt->close();

		//close conn
		$conn->close();
		echo "<script type='text/javascript'>
				window.location.href = 'consultants.php?success=true';
				</script>";

	}

	//function to get profile changes
	function getProfileToChange(){

		$conn = dbconnect();

		$stmt = $conn->prepare("SELECT first_name, last_name, email FROM admin WHERE admin_id = ?");
		$stmt->bind_param('i', $id);
		$id = test_input($_SESSION['admin_id']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($first_name, $last_name, $email);
		$stmt->fetch();
		$stmt->close();

		$conn->close();

		echo '<div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend bg-primary">
                    <span class="input-group-text bg-transparent">
                      <i class="mdi mdi-account text-white"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control" name="first_name" placeholder="First Name" value="'.$first_name.'" aria-label="First Name" aria-describedby="colored-addon1" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend bg-primary">
                    <span class="input-group-text bg-transparent">
                      <i class="mdi mdi-account text-white"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="'.$last_name.'" aria-label="Last Name" aria-describedby="colored-addon1" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend bg-primary">
                    <span class="input-group-text bg-transparent">
                      <i class="mdi mdi-account text-white"></i>
                    </span>
                  </div>
                  <input type="email" class="form-control" name="email" placeholder="Email Address" value="'.$email.'" aria-label="Email Address" aria-describedby="colored-addon1" required>
                </div>
              </div>';

	}

	//function to save changes of the profile
	function saveProfileChanges($par1, $par2, $par3){

		$conn = dbconnect();

		$stmt = $conn->prepare("UPDATE admin SET first_name = ?, last_name = ?, email = ? WHERE admin_id = ?");
		$stmt->bind_param('sssi', $first_name, $last_name, $email, $id);
		$first_name = test_input($par1);
		$last_name = test_input($par2);
		$email = test_input($par3);
		$id = test_input($_SESSION['admin_id']);
		$stmt->execute();
		$stmt->close();

		$conn->close();

		echo "<script type='text/javascript'>
				window.location.href = 'profile.php?changes_success=true';
				</script>";

	}

    //function to get the companies
  function getcompany(){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT client_id, client FROM bsc_client ORDER BY client ASC");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $client);
    while($stmt->fetch()){
      echo '<option value="'.$id.'">'.$client.'</option>';
    }
    $stmt->close();

    $conn->close();

  }

  //function to get a list of fields
  function getDepartments(){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT id, department FROM bsc_departments ORDER BY department ASC");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($department_id, $department);
    while($stmt->fetch()){
      echo '<option value="'.$department_id.'">'.$department.'</option>';
    }
    $stmt->close();

    $conn->close();

  }

    //function to get a list of fields
  function getSupervisors(){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT email, first_name, last_name FROM bsc_accounts WHERE account_type !=?  AND client=?");
    $stmt->bind_param('ii',$account_type,$_SESSION['client_id']);
    $account_type=4;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($email, $first_name,$last_name);
    while($stmt->fetch()){
      echo '<option value="'.$email.'">'.$first_name.' '.$last_name.'</option>';
    }
    $stmt->close();

    $conn->close();

  }

      //function to get a list of fields
  function listSupervisors(){

    $conn = dbconnect();
    $select='';

    $stmt = $conn->prepare("SELECT email, first_name, last_name FROM bsc_accounts WHERE account_type=? AND client=?");
    $stmt->bind_param('si',$account_type,$client_id);
    $account_type="Supervisor";
    $client_id=$_SESSION['client_id'];
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($email, $first_name,$last_name);
    while($stmt->fetch()){
      $select.= '<option value="'.$email.'">'.$first_name.' '.$last_name.'</option>';
    }
    $stmt->close();

    $conn->close();
  return $select;
  }

    function listAccountTypes(){
       $conn = dbconnect();

    $stmt = $conn->prepare("SELECT level, name FROM bsc_account_types");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($level_id, $name);
    while($stmt->fetch()){
      echo '<option value="'.$level_id.'">'.$name.'</option>';
    }
    $stmt->close();
    $conn->close();
  }

   //function to get a list of fields
  function getProjectStatus($project_status,$project_id){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT id, status FROM bsc_project_status");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($status_id, $status);
    while($stmt->fetch()){
      if($project_status==$status_id){
      echo '<label><input type="radio"  checked="" value="'.$status_id.'" name="status"> <i></i>&nbsp;&nbsp;&nbsp;&nbsp;'.$status.'</label>&nbsp;&nbsp;&nbsp;&nbsp;';
      }else{
      echo '<label><input type="radio" value="'.$status_id.'"  onchange="updateProjectStatus('.$status_id.','.$project_id.')" id="project_status'.$project_id.'" name="status"> <i></i>&nbsp;&nbsp;&nbsp;&nbsp;'.$status.' </label>&nbsp;&nbsp;&nbsp;&nbsp;';
      }                             
     
    }
    $stmt->close();

    $conn->close();

  }
    function getEmployees(){

    $conn = dbconnect();
    if($_SESSION['account_type']==1){

    $stmt = $conn->prepare("SELECT id, last_name, first_name FROM bsc_accounts WHERE client=?");
    $stmt->bind_param('i',$client_id); 
    }elseif($_SESSION['account_type']==2){

    $stmt = $conn->prepare("SELECT id, last_name, first_name FROM bsc_accounts WHERE client=? AND business_unit=?");
    $stmt->bind_param('ii',$client_id,$_SESSION['business_unit']);
    }elseif($_SESSION['account_type']==3){

    $stmt = $conn->prepare("SELECT id, last_name, first_name FROM bsc_accounts WHERE client=? AND department=?");
    $stmt->bind_param('ii',$client_id,$_SESSION['department_id']);
    }else{

    $stmt = $conn->prepare("SELECT id, last_name, first_name FROM bsc_accounts WHERE id=?");
    $stmt->bind_param('i',$_SESSION['user_id']);
    }
    
    $client_id=test_input($_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($employee_id, $last_name,$first_name);
    while($stmt->fetch()){
      echo '<option value="'.$employee_id.'">'.$first_name.' '.$last_name.'</option>';
    }
    $stmt->close();

    $conn->close();

  }
  
  
      function getEmployeesOfCertainLevel($account_type){

    $conn = dbconnect();
    if($_SESSION['account_type']==1){

    $stmt = $conn->prepare("SELECT id, last_name, first_name FROM bsc_accounts WHERE client=? AND account_type=?");
    $stmt->bind_param('ii',$client_id,$account_type); 
    }elseif($_SESSION['account_type']==2){

    $stmt = $conn->prepare("SELECT id, last_name, first_name FROM bsc_accounts WHERE client=? AND business_unit=? AND account_type=?");
    $stmt->bind_param('iii',$client_id,$_SESSION['business_unit'],$account_type);
    }elseif($_SESSION['account_type']==3){

    $stmt = $conn->prepare("SELECT id, last_name, first_name FROM bsc_accounts WHERE client=? AND department=? AND account_type=?");
    $stmt->bind_param('iii',$client_id,$_SESSION['department_id'],$account_type);
    }else{

    $stmt = $conn->prepare("SELECT id, last_name, first_name FROM bsc_accounts WHERE id=? AND account_type=?");
    $stmt->bind_param('ii',$_SESSION['user_id'],$account_type);
    }
    
    $client_id=test_input($_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($employee_id, $last_name,$first_name);
    while($stmt->fetch()){
      echo '<option value="'.$employee_id.'">'.$first_name.' '.$last_name.'</option>';
    }
    $stmt->close();

    $conn->close();

  }

	//function to get a list of the field name
	function getDepartmentName($par1){

		$conn = dbconnect();

		$stmt = $conn->prepare("SELECT department FROM bsc_departments WHERE id = ?");
		$stmt->bind_param('i', $department_id);
		$department_id = test_input($par1);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($department);
		$stmt->fetch();
		$stmt->close();

		$conn->close();

		return $department;

  }

    function getAccountTypeName($account_type){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT name FROM bsc_account_types WHERE level = ?");
    $stmt->bind_param('i', $account_type);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $name;

  }

    function getBusinessUnitName($business_unit){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT name FROM bsc_business_units WHERE id = ?");
    $stmt->bind_param('i', $business_unit);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

    return $name;

  }
  
    function getStatusName($par1){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT status FROM bsc_project_status WHERE id = ?");
    $stmt->bind_param('i', $status_id);
    $status_id = test_input($par1);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

    return $status;

  }
      function getNotificationStatusName($status_id){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT status_name FROM bsc_notification_status WHERE status = ?");
    $stmt->bind_param('i', $status_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $status;

  }
  function getUserName($par1){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT first_name, last_name FROM bsc_accounts WHERE id = ?");
    $stmt->bind_param('i', $id);
    $id = test_input($par1);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($first_name, $last_name);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

    return $first_name.' '.$last_name;

  }
    //function to get a list of the field name
  function getEmployeeName($employee_id){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT first_name, last_name FROM bsc_accounts WHERE id = ?");
    $stmt->bind_param('i', $employee_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($last_name,$first_name);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

    return $last_name.' '.$first_name;

  }

    function getEmployeePosition($employee_id){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT position FROM bsc_accounts WHERE id = ?");
    $stmt->bind_param('i', $employee_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($position);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

    return $position;

  }

  	//function to get the companies
	function getEmpName(){

		$conn = dbconnect();

		$stmt = $conn->prepare("SELECT first_name AS name FROM bsc_accounts WHERE id = ?");
		$stmt->bind_param('i', $_SESSION['user_id']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($name);
		$stmt->fetch();
		$stmt->close();

		$conn->close();

		return $name;

	}
    function getBusinessUnitsButtons(){
    $conn=dbconnect();
    $stmt=$conn->prepare("SELECT DISTINCT business_unit FROM bsc_scorecards WHERE client_id=? AND level_id=?");
    $stmt->bind_param('is',$_SESSION['client_id'],$level);
    $level=2;   
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($business_unit);
    while($stmt->fetch()){
echo' <a href="myscorecards?business_units=true'.$client_id.'"><button class="btn btn-info btn-sm">'.getBusinessUnitName($business_unit).'</button></a>
                                        
        ';
  }
  $stmt->close();
    $conn->close();
}
	function getDepartmentButtons($business_unit){
		$conn=dbconnect();
		$stmt=$conn->prepare("SELECT DISTINCT department_id FROM bsc_scorecards WHERE client_id=? AND level_id=? AND business_unit=?");
    $stmt->bind_param('iii',$_SESSION['client_id'],$level,$business_unit);
		$level=3;		
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($department_id);
		while($stmt->fetch()){
echo' <a href="myscorecards?departmental=true&department='.$department_id.'"><button class="btn btn-info btn-sm">'.getDepartmentName($department_id).'</button></a>
	                                    	
				';
	}
	$stmt->close();
    $conn->close();
}
function getUserButtons($client_id,$department_id){
		$conn=dbconnect();
		$stmt=$conn->prepare("SELECT DISTINCT(owner), id FROM bsc_scorecards WHERE client_id=? AND level_id=? AND department_id=?");
		$stmt->bind_param('iss',$client_id,$level,$department_id);
		$level=4;
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($owner,$scorecard_id);
		while($stmt->fetch()){
echo' <a href="scorecard/'.$scorecard_id.'"><button class="btn btn-info btn-sm" name="departments">'.getUserName($owner).'</button><br></a>';
	}
	$stmt->close();
    $conn->close();
}
	//function to get a list of the field name
	function getLevelName($level_id){

		$conn = dbconnect();

		$stmt = $conn->prepare("SELECT level FROM bsc_levels WHERE id = ?");
		$stmt->bind_param('i', $level_id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($level);
		$stmt->fetch();
		$stmt->close();

		$conn->close();

		return $level;

	}
	function getOwner($scorecard_id){

		$conn = dbconnect();
       // $scorecard_id=$_GET['scorecard'];
		$stmt = $conn->prepare("SELECT owner, level_id, client_id, department_id, business_unit FROM bsc_scorecards WHERE id = ?");
		$stmt->bind_param('i', $scorecard_id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($owner,$level_id,$client_id,$department_id,$business_unit);
		$stmt->fetch();
		$stmt->close();
		$conn->close();
    if($level_id==1){
      return getClientName($client_id);
    }
    elseif($level_id==2){
      return getBusinessUnitName($business_unit);
    }
      elseif($level_id==3){
      return getDepartmentName($department_id);
    }
    else{
		return getUserName($owner);
    }
	}

    function getOwnerID($scorecard_id){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT owner, client_id, level_id FROM bsc_scorecards WHERE id = ?");
    $stmt->bind_param('i', $scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($owner,$client_id,$level_id);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    
    if($level_id==1){
        return $client_id;
    }else{
        return $owner;  
    }
    }


	function getOwnerPosition(){

		$conn = dbconnect();
        $scorecard_id=$_GET['scorecard'];
		$stmt = $conn->prepare("SELECT leader, position, level_id, client_id, department_id FROM bsc_scorecards LEFT JOIN bsc_accounts ON bsc_scorecards.owner=bsc_accounts.id WHERE bsc_scorecards.id = ?");
		$stmt->bind_param('i', $scorecard_id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($leader, $position,$level_id,$client_id,$department_id);
		$stmt->fetch();
		$stmt->close();
		$conn->close();
if($level_id==4){
  return $position;
}
else{
 return $leader; 
     }
	}
	
	
	function getOwnerPhoto($owner){

		$conn = dbconnect();
        $scorecard_id=$_GET['scorecard'];
		$stmt = $conn->prepare("SELECT profile_pic FROM bsc_accounts WHERE id = ?");
		$stmt->bind_param('i', $owner);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($photo);
		$stmt->fetch();
		$stmt->close();
		$conn->close();
    echo $photo;
	}
	
		function getPosition($scorecard_id){

		$conn = dbconnect();
    
		$stmt = $conn->prepare("SELECT leader, position, level_id, client_id, department_id FROM bsc_scorecards LEFT JOIN bsc_accounts ON bsc_scorecards.owner=bsc_accounts.id WHERE bsc_scorecards.id = ?");
		$stmt->bind_param('i', $scorecard_id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($leader, $position,$level_id,$client_id,$department_id);
		$stmt->fetch();
		$stmt->close();
		$conn->close();
if($level_id==4){
  return $position;
}
else{
 return $leader; 
     }
	}
	
		function getScorecardsByDepartments(){

			  $conn = dbconnect();
        if($_SESSION['account_type']==1){
        $stmt = $conn->prepare("SELECT DISTINCT department_id AS department FROM bsc_scorecards WHERE client_id=? AND level_id=?");
        $stmt->bind_param('ii', $_SESSION['client_id'],$level_id); 
        }
        elseif($_SESSION['account_type']==2){
         $stmt = $conn->prepare("SELECT DISTINCT department_id AS department FROM bsc_scorecards WHERE client_id=? AND level_id=? AND business_unit=?");
        $stmt->bind_param('iii', $_SESSION['client_id'],$level_id,$_SESSION['business_unit']); 
        }
        else{
        $stmt = $conn->prepare("SELECT DISTINCT department_id AS department FROM bsc_scorecards WHERE client_id=? AND level_id=? AND department_id=?");
        $stmt->bind_param('iii', $_SESSION['client_id'],$level_id,$_SESSION['department_id']);  
      }

        $level_id=4;
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($department);
				while($stmt->fetch()){
		
          echo' <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>'.getDepartmentName($department).' <font color="#175ea8"><button type="button" class="btn btn-outline-secondary m-r-sm">'; getTotalSCInClientDepartment($department); echo'</button></font></h5>
               
                    </div>
                    <div class="ibox-content">
                      <div class="btn-group">
 <a href="myscorecards?individual&department='.$department.'"> <button class="btn btn-outline-primary btn-lg" ><i class="fa fa-folder-open"></i> View</button> </a> 
                    </div>

                </div>
                </div>
            </div>';
				}
				$stmt->close();
		
				$conn->close();
				
			}
          function getScorecardsByCompany(){

        $conn = dbconnect();

        $stmt = $conn->prepare("SELECT DISTINCT client_id AS bsc_client FROM scorecards");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($client_id);
        while($stmt->fetch()){



          echo'
            <div class="col-sm-3 wow fadeInUp pt-1 pt-lg-0" id="box">
            <a href="myscorecards?bydepartment=true&client_id='.$client_id.'"> <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">'.getClientName($client_id).' <span class="badge badge-dark">'; getTotalSCInClient($client_id); echo'</span></h4> 
           
                        <hr/>
                      </div>
                    </div>
                  </div>'; 
        }
        $stmt->close();
    
        $conn->close();   
      }
				function getTotalSCInClientDepartment($par1){

	$conn = dbconnect();
		$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE department_id=? AND client_id=? AND level_id=?");
		$stmt->bind_param('iii', $department,$client_id,$level_id);
		$department=test_input($par1);
		$client_id=test_input($_SESSION['client_id']);
    $level_id=4;
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($count);
    $stmt->fetch();
		$stmt->close();

		$conn->close();

	echo $count;
		
	}
          function getTotalSCInClient($client_id){

  $conn = dbconnect();
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? AND level_id=?");
    $stmt->bind_param('ii', $client_id,$level_id);
    $level_id=3;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
        $stmt->fetch();
    $stmt->close();

    $conn->close();

  echo $count;
    
  }

   function countScorecards($level_id){

    $conn = dbconnect();

    if(countBusinessUnits()<1){
    if($_SESSION['account_type']==1){
$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? AND level_id=?");
$stmt->bind_param('ii', $_SESSION['client_id'],$level_id);
    }
    elseif($_SESSION['account_type']==2) {
$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? AND level_id=? AND business_unit=?");
    $stmt->bind_param('iii', $_SESSION['client_id'],$level_id,$_SESSION['business_unit']);
    } 
    else{
      $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? AND level_id=? AND department_id=?");
    $stmt->bind_param('iii', $_SESSION['client_id'],$level_id,$_SESSION['department_id']);  
    }
}

else{
      if($_SESSION['account_type']==1){
$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? AND level_id=?");
$stmt->bind_param('ii', $_SESSION['client_id'],$level_id);
    }
    elseif($_SESSION['account_type']==2) {
$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? AND level_id=?");
    $stmt->bind_param('ii', $_SESSION['client_id'],$level_id);
    } 
      elseif($_SESSION['account_type']==3){
      $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? AND level_id=? AND department_id=?");
    $stmt->bind_param('iii', $_SESSION['client_id'],$level_id,$_SESSION['department_id']);  
    }
    else{
      $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? AND level_id=? AND department_id=?");
    $stmt->bind_param('iii', $_SESSION['client_id'],$level_id,$_SESSION['department_id']);  
    }
}

  
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
  return $count;
    
  }

     function count360Responses(){

    $conn = dbconnect();
    $stmt = $conn->prepare("SELECT COUNT(DISTINCT(user_id)) AS count FROM 360_responses WHERE client_id=?");
    $stmt->bind_param('i', $_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
  return $count;
    
  }

	function getScorecards(){
		$conn=dbconnect();

		$stmt=$conn->prepare("SELECT id, reporting_period, level_id, last_update FROM bsc_scorecards WHERE level_id=? AND client_id=?");
    $stmt->bind_param('ii',$level_id,$client_id);
    $client_id=test_input($_SESSION['client_id']);
    $level_id=1;
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($id, $reporting_period, $level, $last_update);
		while($stmt->fetch()){
		
         echo '<tr><td>'.$reporting_period.'</td><td>'.getLevelName($level).'</td>';
         if(getTotalWR($id)>=50){
echo'    <td class="text-center"><font color="green">'.getTotalWR($id).'%</font></td>';
         }
         elseif(getTotalWR($id)==0){
  echo'    <td>Nothing to show</td>';
         } else{
  echo'    <td class="text-center"><font color="red">'.getTotalWR($id).'%</font></td>';
         }
  echo' <td>'.substr($last_update,0,11).'</td>
  <td>         <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Drill down</button>
        <ul class="dropdown-menu">
          <li>'; getBusinessUnitsButtons(); echo'</li>               
        </ul>
        </div>

      <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Options</button>
        <ul class="dropdown-menu">
          <li><a href="downloads/'.$id.'" class="btn btn-sm btn-outline-primary"><i class="fa fa-download"></i>Download Report</a></li>
           <li><a href="scorecard/'.$id.'" class="btn btn-outline-info">View <i class="fa fa-desktop"></i></a></li> 
          <li><a data-toggle="modal" data-target="#delete'.$id.'" class="btn btn-outline-danger">Delete<i class="fa fa-trash"></i></a></li> 
                      
        </ul>
        </div>';
        
               echo '<!-- Modal -->
          <div class="modal fade" id="delete'.$id.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Delete Scorecard </h4>
                </div>
                <div class="modal-body">
                <form action="scorecards.php" method="POST">
                 <input type="hidden"  name="scorecard_id" value="'.$id.'">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <p align="center">Are you sure you want to delete this Scorecard </b>?</p>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                  <br/>
                  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                  <button type="submit" class="btn btn-danger" name="delete">Delete</button></a>
           
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>

        </td>
  </tr>';
			 }  
			 $stmt->close();

		$conn->close(); 
		}

          function getBScorecards(){
    $conn=dbconnect();
    
    if($_SESSION['account_type']==1){
    $stmt=$conn->prepare("SELECT id, client_id, leader, business_unit, reporting_period, level_id, last_update FROM bsc_scorecards WHERE client_id=? AND level_id=?");
    $stmt->bind_param('ii',$_SESSION['client_id'],$level_id);
    $level_id=2;
  }
  elseif($_SESSION['account_type']==2){
    $stmt=$conn->prepare("SELECT id, client_id, leader, business_unit, reporting_period, level_id, last_update FROM bsc_scorecards WHERE client_id=? AND level_id=? AND business_unit=?");
    $stmt->bind_param('iii',$_SESSION['client_id'],$level_id,$_SESSION['business_unit']);
    $level_id=2;
  }else{

  }
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id,$client_id, $leader, $business_unit, $reporting_period, $level, $last_update);
    while($stmt->fetch()){
    
         echo '<tr><td>'.getBusinessUnitName($business_unit).'</td>
         <td><p id="custodian'.$id.'"><a onclick="changeCustodian('.$id.')">'.getEmployeeName($leader).'</a></p></td>
         <td>'.$reporting_period.'</td>
         <td>'.getLevelName($level).'</td>
         <td>'.substr($last_update,0,11).'</td>

 <td>         <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Drill down</button>
        <ul class="dropdown-menu">
          <li>';  getDepartmentButtons($business_unit); echo'</li>               
        </ul>
        </div>

      <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Options</button>
        <ul class="dropdown-menu">
          <li> <a href="downloads/'.$id.'" class="btn btn-sm btn-outline-primary"><i class="fa fa-download"></i>Download Report</a></li>
           <li><a href="scorecard/'.$id.'" class="btn btn-success">View<i class="fa fa-search"></i></a></i> 
          <li><a data-toggle="modal" data-target="#delete'.$id.'" class="btn btn-danger">Delete</a></li> 
                      
        </ul>
        </div>';
        
               echo '<!-- Modal -->
          <div class="modal fade" id="delete'.$id.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Delete Scorecard </h4>
                </div>
                <div class="modal-body">
                <form action="scorecards.php" method="POST">
                 <input type="hidden"  name="scorecard_id" value="'.$id.'">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <p align="center">Are you sure you want to delete this Scorecard </b>?</p>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                  <br/>
                  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                  <button type="submit" class="btn btn-danger" name="delete">Delete</button></a>
           
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>

        </td>
        </tr>';
       } 
       $stmt->close();

    $conn->close();  
    }
			function getDScorecards(){
		$conn=dbconnect();
		
    if($_SESSION['account_type']==1){
		$stmt=$conn->prepare("SELECT id, client_id, owner, business_unit, department_id, reporting_period, level_id, last_update FROM bsc_scorecards WHERE client_id=? AND level_id=?");
		$stmt->bind_param('ii',$_SESSION['client_id'],$level_id);
    $level_id=3;
  }
   elseif($_SESSION['account_type']==2){
    $stmt=$conn->prepare("SELECT id, client_id, owner, business_unit, department_id, reporting_period, level_id, last_update FROM bsc_scorecards WHERE client_id=? AND level_id=? AND business_unit=?");
    $stmt->bind_param('iii',$_SESSION['client_id'],$level_id,$_SESSION['business_unit']);
    $level_id=3;
  }
  elseif($_SESSION['account_type']==3){
    $stmt=$conn->prepare("SELECT id, client_id, owner, business_unit, department_id, reporting_period, level_id, last_update FROM bsc_scorecards WHERE client_id=? AND level_id=? AND department_id=?");
    $stmt->bind_param('iii',$_SESSION['client_id'],$level_id,$_SESSION['department_id']);
    $level_id=3;
  }
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($id,$client_id, $owner, $business_unit, $department_id, $reporting_period, $level, $last_update);
		while($stmt->fetch()){
		
         echo '<tr><td>'.getDepartmentName($department_id).'</td>';
         if($owner==''){
       echo'<td><p id="custodian'.$id.'"><a onclick="changeCustodian('.$id.')">Click Me to add</a></p></td>';
         }else{
          echo'<td><p id="custodian'.$id.'"><a onclick="changeCustodian('.$id.')">'.getEmployeeName($owner).'</a></p></td>';
        }
    echo'<td>'.getBusinessUnitName($business_unit).'</td>
         <td>'.$reporting_period.'</td>';
         if(getTotalWR($id)<0){
         echo'<td><font color="red">'.round(getTotalWR($id),1).'%</font></td>';
         }else{
         echo'<td><font color="green">'.round(getTotalWR($id),1).'%</font></td>';     
         }
    echo' <td>'.substr($last_update,0,11).'</td>

 <td>         <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Drill down</button>
        <ul class="dropdown-menu">
          <li>';   getUserButtons($client_id,$department_id); echo'</li>               
        </ul>
        </div>

      <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Options</button>
        <ul class="dropdown-menu">
          <li> <a href="downloads/'.$id.'" class="btn btn-sm btn-outline-primary"><i class="fa fa-download"></i>Download Report</a></li>
             <li><a href="scorecard/'.$id.'" class="btn btn-success">View<i class="fa fa-search"></i></a></li>
          <li><a data-toggle="modal" data-target="#delete'.$id.'" class="btn btn-danger">Delete</a></li> 
                     
        </ul>
        </div>

        </td>';

       echo '<!-- Modal -->
          <div class="modal fade" id="delete'.$id.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Delete Scorecard </h4>
                </div>
                <div class="modal-body">
                <form action="scorecards.php" method="POST">
                 <input type="hidden"  name="scorecard_id" value="'.$id.'">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <p align="center">Are you sure you want to delete this Scorecard </b>?</p>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                  <br/>
                  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                  <button type="submit" class="btn btn-danger" name="delete">Delete</button></a>
           
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>';
 echo'   </tr>';
			 } 
			 $stmt->close();

		$conn->close();  
		}
		function getEScorecards(){
			$conn=dbconnect();
			$level_id=4;
			$stmt=$conn->prepare("SELECT s.id, s.client_id, owner, s.department_id, position, reporting_period, level_id, last_update FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON owner=a.id WHERE s.client_id=? AND level_id=? AND s.department_id=?");
			$stmt->bind_param('iii',$client_id,$level_id,$department_id);
			$client_id=test_input($_SESSION['client_id']);
			$department_id=test_input($_GET['department']);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($id,$client_id,$owner, $department, $position, $reporting_period, $level, $last_update);
			while($stmt->fetch()){
			
			  echo '<tr><td>'.getUserName($owner).'</td><td>'.getDepartmentName($department).'</td><td>'.$position.'</td><td>'.$reporting_period.'</td><td>'.getLevelName($level).'</td>';
        if(getTotalWR($id)>=50){
echo'    <td class="text-center"><font color="green">'.getTotalWR($id).'%</font></td>';
         }
         elseif(getTotalWR($id)==0){
  echo'    <td>Nothing to show</td>';
         } else{
  echo'    <td class="text-center"><font color="red">'.getTotalWR($id).'%</font></td>';
         }

    echo'<td>'.substr($last_update,0,11).'</td>
   <td>
   <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Options</button>
        <ul class="dropdown-menu">
        <li> <a href="scorecard/'.$id.'"> <button type="button"  class="btn btn-outline-primary"><i class="fa fa-search"></i> View Scorecard</button></a></li>
        <li><a href="downloads/'.$id.'" class="btn btn-sm btn-success"><i class="fa fa-download"></i>Download Report</a></li>
                     
        <li><a href="#"><button class="btn btn-outline-danger" data-toggle="modal" data-target="#delete'.$id.'"><font color="red"<i class="fa fa-trash"></i>Delete Scorecard</font></button></a></li>                
        </ul>
        </div>';
        
               echo '<!-- Modal -->
          <div class="modal fade" id="delete'.$id.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Delete Scorecard </h4>
                </div>
                <div class="modal-body">
                <form action="scorecards.php" method="POST">
                 <input type="hidden"  name="scorecard_id" value="'.$id.'">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <p align="center">Are you sure you want to delete this Scorecard </b>?</p>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                  <br/>
                  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                  <button type="submit" class="btn btn-danger" name="delete">Delete</button></a>
           
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>
       </td></tr>';
											
										
				 }  
				 $stmt->close();

		$conn->close(); 
			}

          function getMyScorecards(){
      $conn=dbconnect();
      $level_id=4;
      $stmt=$conn->prepare("SELECT s.id, s.client_id, owner, s.department_id, position, reporting_period, level_id, last_update FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON owner=a.id WHERE owner=?");
      $stmt->bind_param('i',$_SESSION['user_id']);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($id,$client_id,$owner, $department, $position, $reporting_period, $level, $last_update);
      while($stmt->fetch()){
      
        echo '<tr>
        <td>'.getUserName($owner).'</td>
        <td>'.getDepartmentName($department).'</td>
        <td>'.$position.'</td>
        <td>'.$reporting_period.'</td>';
        if(getTotalWR($id)>=50){
echo'    <td class="text-center"><font color="green">'.getTotalWR($id).'%</font></td>';
         }
         elseif(getTotalWR($id)==0){
  echo'    <td>Nothing to show</td>';
         } else{
  echo'    <td class="text-center"><font color="red">'.getTotalWR($id).'%</font></td>';
         }

    echo'<td>'.substr($last_update,0,11).'</td>
   <td>
   <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Options</button>
        <ul class="dropdown-menu">
        <li> <a href="scorecard/'.$id.'"> <button type="button"  class="btn btn-outline-primary"><i class="fa fa-search"></i> View Scorecard</button></a></li>
        <li><a href="downloads/'.$id.'" class="btn btn-sm btn-outline-primary"><i class="fa fa-download"></i>Download Report</a></li>
                     
        <li><a href="#"><button class="btn btn-outline-danger" data-toggle="modal" data-target="#delete'.$id.'"><font color="red"<i class="fa fa-trash"></i>Delete Scorecard</font></button></a></li>                
        </ul>
        </div>';
        
               echo '<!-- Modal -->
          <div class="modal fade" id="delete'.$id.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Delete Scorecard </h4>
                </div>
                <div class="modal-body">
                <form action="scorecards.php" method="POST">
                 <input type="hidden"  name="scorecard_id" value="'.$id.'">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <p align="center">Are you sure you want to delete this Scorecard </b>?</p>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                  <br/>
                  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                  <button type="submit" class="btn btn-danger" name="delete">Delete</button></a>
           
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>
       </td></tr>';
                      
                    
         }  
         $stmt->close();

    $conn->close(); 
      }


function getGoals($par1){
       $conn=dbconnect();
        $scorecard_id=$_GET['scorecard'];
        $stmt2=$conn->prepare("SELECT id, perspective_id, goal FROM bsc_goals WHERE perspective_id=? AND scorecard_id=?");
	    $stmt2 ->bind_param('ii', $perspective_id,$scorecard_id);
	    $perspective_id=test_input($par1);
		$stmt2->execute();
		$stmt2->store_result();
		$stmt2->bind_result($goal_id, $perspective_id, $goal);
		while($stmt2->fetch()){
	     echo $goal; echo"\n";
		}
		$stmt2->close();
		$conn->close();
	}
	

	/*function getWeight($par1){
       $conn=dbconnect();
        $scorecard_id=$_GET['scorecard'];
        $stmt2=$conn->prepare("SELECT weight FROM bsc_perspectives WHERE scorecard_id=? AND id=?");
	    $stmt2 ->bind_param('ii', $scorecard_id,$id);
	    $id=test_input($par1);
		$stmt2->execute();
		$stmt2->store_result();
		$stmt2->bind_result($weight);
		while($stmt2->fetch()){
	    return $weight; 
		}
		$stmt2->close();
		$conn->close();
	}
function getTotalWeight(){
	    $conn=dbconnect();

		$scorecard_id=$_GET['scorecard'];
		$stmt=$conn->prepare("SELECT SUM(weight) AS Total FROM bsc_perspectives WHERE scorecard_id=? ");
	    $stmt ->bind_param('i', $scorecard_id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($total);
		while($stmt->fetch()){
	     
	}
	    $stmt->close();
		$conn->close();
	return $total;
} */
function getOwnerComments(){
      $conn=dbconnect();

    $scorecard_id=$_GET['scorecard'];
    $stmt=$conn->prepare("SELECT id, comment FROM bsc_comments WHERE scorecard_id=? AND scope=? ");
      $stmt ->bind_param('ii', $scorecard_id,$scope);
    $scope=1;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $comment);
    while($stmt->fetch()){
      if($_SESSION['account_type']==getScoreCardLevel($_GET['scorecard'])){
echo'<table>
<tr><td><input hidden type="text" id="id2" name="id2" value="'.$id.'"> 
<input type="text" id="scope2" name="scope2" hidden value="1">
    <textarea id="comment2" name="comment2" rows="8" cols="65" onfocusout="saveMyComments('.$id.','.$scorecard_id.','.$scope.')">'.$comment.'</textarea></td></tr></table>'; 
      }else{
    echo' 
<table>
<tr><td>
    <textarea id="comment2" name="comment2" rows="8" readonly cols="65">'.$comment.'</textarea></td></tr></table>'; 
}
}
     $stmt->close();
    $conn->close();
}
function getSupervisorComments(){
      $conn=dbconnect();

    $scorecard_id=$_GET['scorecard'];
    $stmt=$conn->prepare("SELECT id, comment FROM bsc_comments WHERE scorecard_id=? AND scope=? ");
      $stmt ->bind_param('ii', $scorecard_id,$scope);
    $scope=2;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $comment);
    while($stmt->fetch()){
      if($_SESSION['account_type']==getScoreCardLevel($_GET['scorecard'])){
 echo' <table>
<tr>
    <textarea name="comment" rows="8" cols="70" readonly>'.$comment.'</textarea></td></tr></table>'; 
      } else{
  echo' <table>
<tr><td><input hidden id="supervisor_comment_id" type="text" name="id2" value="'.$id.'"> 
<input type="text" id="scope3" name="scope3" hidden value="2">
<input type="text" id="scorecard_id3" name="scorecard_id2" hidden value="'.$scorecard_id.'">
    <textarea id="supervisor_comment" name="comment" rows="8" cols="70" onfocusout="superComments()">'.$comment.'</textarea></td></tr></table>'; 
      } 
}
     $stmt->close();
    $conn->close();
}
function getIndividualComment($measure_id){
      $conn=dbconnect();

    $stmt=$conn->prepare("SELECT id, comment, sender, date FROM bsc_comments WHERE measure_id=?");
      $stmt ->bind_param('i', $measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $comment);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
  return $comment;
}

function getIndividualComments($measure_id){
      $conn=dbconnect();

    if($_SESSION['account_type']==1){
      $user_id = 0;
    }else{
      $user_id = $_SESSION['user_id'];
    }

    $stmt=$conn->prepare("SELECT id, comment, sender, date, status FROM bsc_comments WHERE measure_id=?");
      $stmt ->bind_param('i', $measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $comment,$sender,$date,$status);
    while($stmt->fetch()){

      if($sender==0){
        $name = "Coporate account used";
        }else{
        $name = getEmployeeName($sender);
        }

          if($user_id <> $sender){
              echo'   <div class="row">
                        <div class="col-11">
                          <font color="#175ea8"><b>'.$name.'</b></font>
                          '.$comment.'
                          <br/>
                          <small class="text-muted">'.$date.'</small>
                        </div>
                        <div class="col-1"></div>
                      </div>
                      <hr>';
                    } else{
                echo' <div class="row">
                          <div class="col-1"></div>
                          <div class="media-body col-11" style="text-align: right;">
                            '.$comment.'
                            <font color="#175ea8"><b> You</b></font><br/>
                            <small class="text-muted">'.$date.'</small>

                          </div>
                      </div>
                      <hr>';
                     }

    }
    $stmt->close();
    $conn->close();  
}

function getReportingPeriod($scorecard_id){
	$conn=dbconnect();

	$stmt=$conn->prepare("SELECT id, reporting_period FROM bsc_scorecards WHERE id=? ");
	$stmt ->bind_param('i', $scorecard_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id, $reporting_period);
	$stmt->fetch();
  $stmt->close();
  $conn->close();
return $reporting_period;
}

function getStartPeriod($scorecard_id){
  $conn=dbconnect();

  $stmt=$conn->prepare("SELECT id, start FROM bsc_scorecards WHERE id=? ");
  $stmt ->bind_param('i', $scorecard_id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($id, $start);
  $stmt->fetch();
  $stmt->close();
  $conn->close();
return $start;
}

function getStartingPeriod($scorecard_id){
	$conn=dbconnect();
	$stmt=$conn->prepare("SELECT id, date FROM bsc_scorecards WHERE id=? ");
	$stmt ->bind_param('i', $scorecard_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id, $starting_period);
	$stmt->fetch();

    $d = date_parse_from_format("Y-m-d H:i:s", $starting_period);
    $month= $d["month"];
    $starting_month= date('F', mktime(0, 0, 0, $month, 10)); 
    
    $stmt->close();
    $conn->close();
return $starting_month;
}

function getReportingFrequency($measure_id){
	$conn=dbconnect();

	$stmt=$conn->prepare("SELECT reporting_frequency FROM bsc_targets WHERE id=?");
	$stmt->bind_param('i',$measure_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($reporting_frequency);
	$stmt->fetch();
	$stmt->close();
	$conn->close();
	return $reporting_frequency;
}

function getMeasures($par1){
	    $conn=dbconnect();
        $stmt3 = $conn->prepare("SELECT id, goal_id,measure, unit, reporting_frequency, base_target, stretch_target, allocated_weight FROM bsc_targets WHERE goal_id=?"); 
        $goal_id=test_input($par1);  
		$stmt3->execute();
		$stmt3->store_result();
		$stmt3->bind_result($target_id, $goal_id,$measure,$unit,$reporting_frequency, $base_target,$stretch_target,$allocated_weight);
			while($stmt3->fetch()){
				echo $measure;
}
   $stmt->close();
    $conn->close();
}

function getFirstTable(){
	$conn=dbconnect();
	$scorecard_id=$_GET['scorecard'];
	echo'<form name="period" action="../grades.php" method="post">
	<div class="row">
  <div class="col-lg-4">
    
  <table width="100%" border="0">

  <tr>
    <td><font color="#175ea8">Owner</font> </td>
    <td>
    <input type="text" name="owner" class="form-control" value="'.getOwner($scorecard_id).'" readonly/>
    </td>
  </tr>
  <tr>
    <td><font color="#175ea8">Position</font></td>
    <td>
    <input id="position'.$scorecard_id.'" onfocusout="saveFirstTable('.$scorecard_id.')" type="text" name="position" class="form-control" value="'.getOwnerPosition().'"/>
    </td>
  </tr>
  <tr>
  <td><font color="#175ea8">Reporting Period</font> </td>
    <td>
    <input type="text" name="scorecard_id" value="'.$scorecard_id.'" hidden ?>
    <input  data-toggle="modal" data-target="#reporting_period" readonly class="form-control" value="'.getReportingPeriod($scorecard_id).'"/>

    <div class="modal fade" id="reporting_period" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
 <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reporting Period</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row">
    
      <div class="col-6">Start Date
        <input id="start'.$scorecard_id.'" type="date" onfocusout="saveFirstTable('.$scorecard_id.')" class="form-control" value="'.getStartPeriod($scorecard_id).'"/>
      </div>
      <div class="col-6">End date
        <input id="r_period'.$scorecard_id.'" type="date" onfocusout="saveFirstTable('.$scorecard_id.')" class="form-control" value="'.getReportingPeriod($scorecard_id).'"/>
      </div>

        </div>
      <div class="modal-footer">
         <button type="button" onClick="document.location.reload(true)" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-spinner" aria-hidden="true"></i> Process</button>
      </div>
    </div>
  </div>
</div>

    </td>
    </tr>
  </table>
  </div>
  <div class="col-lg-4">

  <table width="100%" class=" table table-striped">
  <tr>
    <td><font color="#175ea8">Overall Score</font></td>';
     if (getTotalWR($_GET['scorecard'])<0){
echo'<td><font color="#FF0000"> '.getTotalWR($_GET['scorecard']).'%</font></td>';
   }else{
echo '<td><font color="green">'.getTotalWR($_GET['scorecard']).'%</font></td>';
   }
echo'</tr>
    <tr>
    <td> <font color="#175ea8">Total Allocated Weight</font> </td>';
    if(getOverallWeight($_GET['scorecard'])<>100){
  echo' <td><font color="red"><input type="text" size="5em" id="ov" readonly class="form-control" value="'.getOverallWeight($_GET['scorecard']).' %"></font></td>';  
    } else{
  echo' <td><font color="green"><input type="text" size="5em" id="ov1" readonly class="form-control" value="'.getOverallWeight($_GET['scorecard']).'%"></font></td>';
    }
  echo'</tr>
  <tr><td>';
  if(getScoreCardLevel($_GET['scorecard'])!=1){
   echo'<a class="btn btn-outline-success" href="../actionplans/'.$_GET['scorecard'].'">View Action Plans</a>';   
  }
 echo '</td>
  <td align="right">';   

  if(getScoreCardLevel($_GET['scorecard'])==4 && $_SESSION['account_type']!=4){
    echo '<a href="../assessments/'.$scorecard_id.'"><span class="btn btn-outline-primary">Assess Performance</span></a></td>';
  }
  echo'</td>
  </tr>
  </table>
</div>

  <div class="col-lg-4">
  <table width="100%" id="upper_weights" border="0">';
 getUpperWeights($scorecard_id);
echo'</table>
  </div>
  </div>

 </form>
  
  ';
}

function getUpperWeights($scorecard_id){
    $conn=dbconnect();
  $client_id=$_SESSION['client_id'];
  $stmt=$conn->prepare("SELECT DISTINCT(perspective_id) FROM bsc_client_perspectives WHERE client_id=?");
  $stmt->bind_param('i',$client_id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($perspective_id);
  While($stmt->fetch()){

 echo' <tr>
          <td align="right"><font color="#175ea8">'.ucwords(getPerspectiveName($perspective_id)).'</font></td> 
          <td width="5%"></td>
          <td> <font color="#175ea8"><b>'.getPerspectiveTotalWeight($perspective_id,$scorecard_id).'%</b></font></td>
      </tr>
';
  }
$stmt->close();
$conn->close();

}

function updateReportingPeriod($leader,$rperiod,$start,$scorecard_id){
   $conn=dbconnect();
 if(getScoreCardLevel($scorecard_id)==4){
   $stmt=$conn->prepare("UPDATE bsc_scorecards SET reporting_period=?, start=? WHERE id=?");
   $stmt->bind_param('ssi',$rperiod,$start,$scorecard_id);
 }else{
   $stmt=$conn->prepare("UPDATE bsc_scorecards SET leader=?, reporting_period=?, start=? WHERE id=?");
   $stmt->bind_param('sssi',$leader,$rperiod,$start,$scorecard_id);
 }
   $stmt->execute();
   $stmt->close();

}

function getScoredcard_id(){
     $conn=dbconnect();
  $scorecard_id=$_GET['scorecard'];
  $stmt=$conn->prepare("SELECT scorecard_id FROM bsc_goals WHERE scorecard_id=? LIMIT 1");
  $stmt ->bind_param('i', $scorecard_id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($sc);
$stmt->close();
$conn->close();
return $sc;
}
function updateSecondTable($goal_id,$unit,$reporting_frequency,$target_period,$base_target,$stretch_target,$actual,$allocated_weight,$trend_indicator,$measure_id,$scorecard_id){
  $conn=dbconnect();
	 $stmt2=$conn->prepare("UPDATE bsc_targets SET goal_id=?, unit=?, reporting_frequency=?, target_period=?, base_target=?, stretch_target=?, actual=?, allocated_weight=?,trend_indicator=? WHERE id=?");
	 $stmt2->bind_param('sssssssssi',$goal_id,$unit,$reporting_frequency,$target_period,$base_target,$stretch_target,$actual,$allocated_weight,$trend_indicator,$measure_id); 
	 $stmt2->execute();
	 $stmt2->close();
   $stmt2->close();

   updateLastUpdate($scorecard_id);
    
	echo "<script type='text/javascript'>
        window.location.href = 'scorecard/".$scorecard_id."';
        </script>"; 
}
function updateLastUpdate($scorecard_id){
  $conn=dbconnect();
  $today=date('Y-m-d H:i:s');
  $stmt=$conn->prepare("UPDATE bsc_scorecards SET last_update=? WHERE id=?");
  $stmt->bind_param('si',$today, $scorecard_id);
  $stmt->execute();
  $stmt->close();
  $conn->close();
  
}
function saveGoal($scorecard_id,$goal,$goal_id){
   $conn=dbconnect();
   $stmt=$conn->prepare("UPDATE bsc_goals SET goal=? WHERE id=?");
   $stmt->bind_param('si',$goal,$goal_id);
   //$company_goal=test_input($par4);
   $stmt->execute();
   $stmt->close();

   echo "<script type='text/javascript'>
   window.location.href = 'scorecard/".$scorecard_id."';
   </script>";
}

      function addGoal($scorecard_id,$perspective_id,$goal,$company_goal){

    $conn = dbconnect();    
  
    $stmt = $conn->prepare("INSERT INTO bsc_goals (scorecard_id, perspective_id, goal,company_goal) VALUES (?,?,?,?)");
    $stmt->bind_param('iiss', $scorecard_id,$perspective_id,$goal,$company_goal);
    $stmt->execute();
    $stmt->close();

    $last_id = $conn->insert_id;
    $stmt1 = $conn->prepare("INSERT INTO bsc_targets (goal_id) VALUES (?)");
    $stmt1->bind_param('i', $last_id);
    $stmt1->execute();
    $stmt1->close();
    $conn->close(); 

echo "<script type='text/javascript'>
        window.location.href = 'scorecard/".$scorecard_id."';
        </script>";
  }

     function addMeasure($goal_id,$measure,$measure_type,$scorecard_id){

    $conn = dbconnect();    
 
    $stmt1 = $conn->prepare("INSERT INTO bsc_targets (goal_id, measure, measure_type) VALUES (?,?,?)");
    $stmt1->bind_param('isi', $goal_id,$measure,$measure_type);
    $stmt1->execute();
    $stmt1->close();
    $conn->close();

echo "<script type='text/javascript'>
        window.location.href = 'scorecard/".$scorecard_id."';
        </script>";
  }
       function addComment($scorecard_id,$measure_id,$comment){

    $conn = dbconnect(); 
    $date = date('Y-m-d H:i');
    if($_SESSION['account_type']==1){
      $sender=0;
    }else{
    $sender = $_SESSION['user_id'];
    }
    $stmt1 = $conn->prepare("INSERT INTO bsc_comments (scorecard_id, measure_id, comment,sender, date) VALUES (?,?,?,?,?)");
    $stmt1->bind_param('iisis', $scorecard_id,$measure_id,$comment,$sender,$date);
    $stmt1->execute();
    $stmt1->close();
    $conn->close();
     }

      function addOveralComments($id, $scorecard_id,$scope,$comment){

    $conn = dbconnect(); 

   $stmt=$conn->prepare("UPDATE bsc_comments SET id=?, scorecard_id=?, comment=? WHERE id=?");
   $stmt->bind_param('iisi',$id, $scorecard_id, $comment,$id);
   $stmt->execute();
   $stmt->close();
   $stmt->close();
   $conn->close();

  }



function saveMeasure($measure_id,$measure,$measure_type,$scorecard_id){
   $conn=dbconnect();
   $stmt=$conn->prepare("UPDATE bsc_targets SET measure=?, measure_type=? WHERE id=?");
   $stmt->bind_param('sss',$measure,$measure_type,$measure_id);
   $stmt->execute();
   $stmt->close();
   if($stmt){
   echo "<script type='text/javascript'>
   window.location.href = 'scorecard/".$scorecard_id."';
   </script>";
}
else{
  echo "<script type='text/javascript'>
  window.location.href = 'scorecard/".$scorecard_id."';
  </script>";
}}

function getFourthTable(){
echo'<div style="display: inline-block">

'.getOwnerComments().'

</div>
<div style="display: inline-block">


'.getSupervisorComments().'



</div>';

}

function getThirdTable(){
	$conn=dbconnect();
  echo' <div class="row"><div class="col-8" align="right">
<table width="98%" class="table table-striped">
  <tr>
    <th colspan="3"><font color="#175ea8">Summary of Ratings</font></th>
    <th>';actionPlans($_GET['scorecard']); echo'</th>
    <th><a href="../downloads/'.$_GET['scorecard'].'" class="btn btn-sm btn-success" style="float:right;"><i class="fa fa-download"></i> Download Report</a></th>
  </tr>';
getSummaryTable();
echo'  <tr>
    '.getOveralSummary().'
  </tr>
</table></form></div>
<div class="col-4">

<table width="100%" class="table table-striped" align="right">
<tr><th>';

if(getScoreCardLevel($_GET['scorecard'])!=1){
echo '<a href="../pep/'.$_GET['scorecard'].'" class="btn btn-warning btn-sm">Performance Improvement Plans</a>'; }

echo'</th></tr>
  <tr>
    <td align="justify">Achievement Ratio: Extent to which the stretch target has been achieved over and above the baseline. Weighted Rating = (Actual - Base)/(Stretch - Base) The summary of  ratings assumes that each perspective carries a weight as shown on Total of the perspective</td>
  </tr>
</table>
</div></div>

';
}
function getOveralSummary(){
  $conn=dbconnect();
 $scorecard_id=$_GET['scorecard'];
   $stmt=$conn->prepare("SELECT id, client_id, platinum, gold,diamond,silver, bronze, nickel FROM bsc_summary_ratings WHERE client_id=?");
   $stmt->bind_param('i',$client_id);
   $client_id=$_SESSION['client_id'];
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result($id, $client_id, $platinum, $gold,$diamond,$silver, $bronze, $nickel);
   While($stmt->fetch()){

   }
    $mytotal=0;
    $stmt1 = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE scorecard_id=?");
    $stmt1->bind_param('i',$scorecard_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($measure_id);
    While($stmt1->fetch()){

        $mytotal+=getWeightedRating($measure_id); 
      }

   if($mytotal>=$platinum){
  $value="Platinum";
  $range=$platinum."% - 100%";
  $comment="Excellent Performance";
}
elseif($mytotal<$platinum && $mytotal>=$gold){
  $value="Gold";
  $max=$platinum-1;
  $range=$gold."%-".$max."%";
  $comment="Better Achievements";
}
elseif($mytotal<$gold && $mytotal>=$diamond){
  $value="Diamond";
  $max=$gold-1;
  $range=$diamond."% -".$max."%";
  $comment="Good results";
}
elseif($mytotal<$diamond && $mytotal>=$silver){
  $value="Silver";
  $max=$diamond-1;
  $range=$silver."%-".$max."%";
  $comment="Basic Achievement";
}
elseif($mytotal<$silver && $mytotal>=$bronze){
  $value="Bronze";
  $max=$silver-1;
  $range=$bronze."%-".$max."%";
  $comment="Poor Performance";
}
else{
  $value="Nickel";
  $range="Less than ".$bronze."%";
  $comment="Unsatisfactory results";
}
echo'<td>Overall</td>';
   if($mytotal==0){
   echo' <td>nothing to display</td>
         <td></td>
         <th></th>
         <td></td>'; 
    }
         elseif($mytotal<0 && $mytotal!=0){
   echo' <td><font color="red">'.$value.'</font></td>
         <td><font color="red">'.$comment.'</font></td>
         <th></th>
         <td><font color="red">'. $mytotal.'%</font></td>'; 
    }
 elseif($mytotal>=$platinum){
   echo' <td><font color="green">'.$value.'</font></td>
         <td><font color="green">'.$comment.'</font></td>
         <th></th>
         <td><font color="green">'. $mytotal.'%</font></td>'; 
    }
    else{
    echo'<td>'.$value.'</td>
         <td>'.$comment.'</td>
         <th></th>
         <td>'. $mytotal.'%</td>'; 
    }
    echo'</tr>'; 

$stmt->close();
$conn->close();

}

function getSummaryTable(){
  $conn=dbconnect();
   $scorecard_id=$_GET['scorecard'];
   for($perspective_id=1; $perspective_id<5; $perspective_id++){
 
   $stmt=$conn->prepare("SELECT id, client_id, platinum, gold,diamond,silver, bronze, nickel FROM bsc_summary_ratings WHERE client_id=?");
   $stmt->bind_param('i',$client_id);
   $client_id=$_SESSION['client_id'];
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result($id, $client_id, $platinum, $gold,$diamond,$silver, $bronze, $nickel);
   While($stmt->fetch()){
}
    $stmt1 = $conn->prepare("SELECT COUNT(bsc_targets.id), bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE perspective_id=? AND scorecard_id=?");
    $stmt1->bind_param('ii',$perspective_id,$scorecard_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count, $measure_id);
    While($stmt1->fetch()){
     if($count>0){
        $total=0;
        $range='';
          getWR($scorecard_id,$perspective_id);
        $total+=getWR($scorecard_id,$perspective_id); 
        $mytotal=round(($total/getPerspectiveTotalWeight($perspective_id,$scorecard_id))*100,1);
      }
     else{
      $mytotal=0;
     }
if($mytotal>=$platinum){
  $value="Platinum";
  $range=$platinum."% - 100%";
  $comment="Excellent Performance";
}
elseif($mytotal<$platinum && $mytotal>=$gold){
  $value="Gold";
  $max=$platinum-1;
  $range=$gold."%-".$max."%";
  $comment="Better Achievement";
}
elseif($mytotal<$gold && $mytotal>=$diamond){
  $value="Diamond";
  $max=$gold-1;
  $range=$diamond."% -".$max."%";
  $comment="Good results";
}
elseif($mytotal<$diamond && $mytotal>=$silver){
  $value="Silver";
   $max=$diamond-1;
  $range=$silver."%-".$max."%";
  $comment="Basic Achievement";
}
elseif($mytotal<$silver && $mytotal>=$bronze){
  $value="Bronze";
    $max=$silver-1;
  $range=$bronze."%-".$max."%";
  $comment="Poor Performance";
}
else{
  $value="Nickel";
  $range="Less than ".$bronze."%";
  $comment="Unsatisfactory results";
}

 $actual = '('.round(getWR($scorecard_id,$perspective_id),2).'/'.getPerspectiveTotalWeight($perspective_id,$scorecard_id).') * 100';
echo'
  <tr>
    <td>'.getPerspectiveName($perspective_id).'</td>';
     if($mytotal==0){
   echo' <td>nothing to display</td>
         <td></td>
         <td></td>
         <td></td>'; 
    }
    elseif($mytotal<0 && $mytotal!=0){
   echo' <td><font color="red">'.$value.'</font></td>
         <td><font color="red">'.$comment.'</font></td>
         <td>'.$actual.'</td>
         <td><font color="red">'.$mytotal.'%</font></td>'; 
    }
 elseif($mytotal>=$platinum){
   echo' <td><font color="green">'.$value.'</font></td>
         <td><font color="green">'.$comment.'</font></td>
         <td>'.$actual.'</td>
         <td><font color="green">'.$mytotal.'%</font></td>'; 
    }
    else{
    echo'<td>'.$value.'</td>
         <td>'.$comment.'</td>
         <td>'.$actual.'</td>
         <td>'.$mytotal.'%</td>'; 
    }
    echo' </tr>
';
}
}
$stmt->close();
$stmt1->close();
$conn->close();
}


function getOrganisationalGoals($par1){
  $conn=dbconnect();
  $stmt=$conn->prepare("SELECT level_id FROM bsc_scorecards WHERE id=?");
  $stmt->bind_param('i',$scorecard_id);
  $scorecard_id=test_input($par1);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($level_id);
  While($stmt->fetch()){
    if($level_id!=1){
  echo'     <div class="form-group"><label>Choose Organisational goal being supported</label>
                                  <select name="company_goal" class="form-control">
                                  <option selected disabled>Select goal</option>';
                                   getOrganisationalGoalOptions();
                         echo'         </select>
                                  
                                </div>';
  }}

  $stmt->close();
  $conn->close();
}

//trial
function getNestedTable(){

  $table = '<table class=" table table-striped" width="100%" id="myTable">
              <thead>
                <tr>
		<th style="width:6%"><font color="#175ea8"><b>Perspective</span></b></font></th>
		<th style="width:20%" data-toggle="popover" data-placement="top" data-content="What you actually Want to achieve"><font color="#175ea8"><b>Goal</b></font></th>
		<th style="width:20%" data-toggle="popover" data-placement="top" data-content="Measure of Success"><font color="#175ea8"><b>Measure</b></font></th>
		<th data-toggle="popover" data-placement="top" data-content="Unit of measurement"><font color="#175ea8"><b>Unit</b></font></th>
		<th data-toggle="popover" data-placement="top" data-content="Reporting Frequency"><font color="#175ea8"><b>RF</b></font></th>
		<th data-toggle="popover" data-placement="top" data-content="Target Period"><font color="#175ea8"><b>TP</b></font></th>
		<th data-toggle="popover" data-placement="top" data-content="Base Target (minimum expected)"><font color="#175ea8"><b>BT</b></font></th>
		<th data-toggle="popover" data-placement="top" data-content="Stretch target (maximum attainable in givern cirumstances)"><font color="#175ea8" ><b>ST</b></font></th>
		<th data-toggle="popover" data-placement="top" data-content="Actual Achievement"><font color="#175ea8"><b>Actual</b></font></th>
		<th data-toggle="popover" data-placement="top" data-content="Allocated Weight."><font color="#175ea8"><b>AW</b> </font> </th>  
		<th data-toggle="popover" data-placement="top" data-content="Weighted Rating (automatically Calculated)"><font color="#175ea8"><b>WR</b></font></th>
		<th data-toggle="popover" data-placement="top" data-content="Trend Indicator (time to time performance Indicator)"><font color="#175ea8"><b>TI</b></font></th>
        <th data-toggle="popover" data-placement="top" data-content="Specific Comment for this measure"><font color="#175ea8"><b>Comment</b></font></th>
		<th><font color="#175ea8"><b><i class="fa fa-trash-o" aria-hidden="true"></i></b></font></th>
		                  </tr>
                </thead>
                <tbody>';

   $conn = dbconnect();

    $scorecard_id = test_input($_GET['scorecard']);

    //get the perspectives
    $stmt = $conn->prepare("SELECT perspective_id FROM bsc_client_perspectives WHERE client_id=?");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($perspective_id);
    while($stmt->fetch()){
  
      //get count of measures in selected perspective
      $stmt1 = $conn->prepare("SELECT COUNT(bsc_targets.id) AS total_measures FROM bsc_targets INNER JOIN bsc_goals ON bsc_targets.goal_id = bsc_goals.id WHERE bsc_goals.scorecard_id = ? AND bsc_goals.perspective_id = ?");
      $stmt1 ->bind_param('ii', $scorecard_id, $perspective_id);
      $stmt1->execute();
      $stmt1->store_result();
      $stmt1->bind_result($total_measures);
      $stmt1->fetch();
      $stmt1->close();

      //check if there are no measures
      if($total_measures == 0){

        //get total goals in selected perspective for the goal
        $stmt2 = $conn->prepare("SELECT COUNT(*) AS total_goals FROM bsc_goals WHERE scorecard_id = ? AND perspective_id = ?");
        $stmt2 ->bind_param('ii', $scorecard_id, $perspective_id);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($total_goals);
        $stmt2->fetch();
        $stmt2->close();

        //check if goals are available
        if($total_goals == 0){

          //add the perspective in table row
          $table .= '<tr><td rowspan="2" >'.getPerspectiveName($perspective_id).'</td>
          <td> <i class="fa fa-plus-circle" aria-hidden="true" style="color:#175ae8;" data-toggle="modal" data-target="#goaladd'.$perspective_id.'">goal</i></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          </tr>';
           $table.='
             <tr>
             <td></td>
              <td colspan="6"></td>
              <td><font color="blue">Total</font></td>
              <td></td>         
              <td></td>
              <td></td>
              </tr>
            ';
                     echo '<!-- Modal -->
                    <div class="modal fade" id="goaladd'.$perspective_id.'" role="dialog">
                      <div class="modal-dialog">
                      
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Add new goal to <font color="#175ae8">'.getPerspectiveName($perspective_id).'</font> Perspective</h4>

                          </div>
                          <div class="modal-body">
                          <form action="../grades.php" method="POST">

                            <div class="row">
                              <div class="col-lg-12">
                               <div class="form-group">
                               <input type="text" hidden name="scorecard_id" value="'.$_GET['scorecard'].'">
                                <input type="text" hidden name="perspective_id" value="'.$perspective_id.'"> 
                                </div>
                                <div class="form-group">
                                <input type="text" hidden name="company_goal" value="">  
                                </div>
                                <div class="form-group">
                                  <textarea rows="4" cols="10" name="goal" placeholder="Add new goal to a selected perspective." class="form-control"></textarea>
                                  <br/><br/>
                                </div>
                              </div>
                            </div>
                            <div class="form-group" align="right">
                            <br/>
                              <button type="submit" class="btn btn-primary" name="addgoal">Add goal</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </form>
                          </div>
                        </div>
                        
                      </div>
                    </div>';

        }else{

          //add the perspective in table row
          $table .= '<tr><td rowspan="'.$total_goals.'"><span id="mySpan">'.getPerspectiveName($perspective_id).' <i class="fa fa-plus-circle" aria-hidden="true" style="color:#175ae8;" data-toggle="modal" data-target="#goaladd'.$perspective_id.'">goal</i></span></td>';

          //get the goals for selected perspective
          $stmt1 = $conn->prepare("SELECT id, scorecard_id, goal FROM bsc_goals WHERE scorecard_id = ? AND perspective_id = ?");
          $stmt1 ->bind_param('ii', $scorecard_id, $perspective_id);
          $stmt1->execute();
          $stmt1->store_result();
          $stmt1->bind_result($id, $scorecard_id, $goal);
          while($stmt1->fetch()){

            //add the goal in table row
            $table .= '<td rowspan="1"><p data-toggle="modal" data-target="#goal'.$id.'">'.$goal.'
</p></td>      
          <td><i class="fa fa-plus-circle" aria-hidden="true" style="color:#175ae8;" data-toggle="modal" data-target="#newmeasure'.$id.'">measure</i></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
            </tr>';
            $table.='
             <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
              <td ><font color="blue">Total</font></td>         
              <td ><font color="blue">empty</font></td>
              <td></td>
              <td></td>
              </tr>
            ';

              echo '<!-- Modal -->
          <div class="modal fade" id="goal'.$id.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">Update Goal </h4>
                </div>
                <div class="modal-body" >
                <form action="../grades.php" method="POST">

                  <div class="row" >
                    <div class="col-lg-12">
                      <div class="form-group">
                      <input type="text" name="scorecard_id" value="'.$_GET['scorecard'].'" hidden>
                      <input type="text" name="goal_id" value="'.$id.'" hidden>
                        <textarea rows="4" cols="5" name="goal" placeholder="modify goal" class="form-control">'.$goal.'</textarea>
                        <br/><br/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                    <button type="submit" class="btn btn-primary" name="savegoal">Save goal</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>';
            echo '<!-- Modal -->
          <div class="modal fade" id="newmeasure'.$id.'" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Add new measure to <font color="#175ae8">'.$goal.'</font></h4>
                </div>
                <div class="modal-body">
                <form action="../grades.php" method="POST">

                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                      <input type="text" hidden name="scorecard_id" value="'.$_GET['scorecard'].'">
                      <input type="text" hidden name="perspective_id" value="'.$perspective_id.'">
                      <input type="text" hidden name="goal_id" value="'.$id.'">
                 </div>
                        <textarea rows="4" cols="10" name="measure" placeholder="add new measure" class="form-control" required></textarea>
                        <br/><br/>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                  <br/>
                    <button type="submit" class="btn btn-primary" name="newmeasure">Save new measure</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>';
                  echo '<!-- Modal -->
                    <div class="modal fade" id="goaladd'.$perspective_id.'" role="dialog">
                      <div class="modal-dialog">
                      
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Add new goal to <font color="#175ae8">'.getPerspectiveName($perspective_id).'</font> Perspective</h4>

                          </div>
                          <div class="modal-body">
                          <form action="../grades.php" method="POST">

                            <div class="row">
                              <div class="col-lg-12">
                               <div class="form-group">
                               <input type="text" hidden name="scorecard_id" value="'.$_GET['scorecard'].'">
                                <input type="text" hidden name="perspective_id" value="'.$perspective_id.'"> 
                                </div>
                                <div class="form-group">
                                <input type="text" hidden name="company_goal" value="">
                                </div>
                                <div class="form-group">
                                  <textarea rows="4" cols="10" name="goal" placeholder="Add new goal to a selected perspective" class="form-control"></textarea>
                                  <br/><br/>
                                </div>
                              </div>
                            </div>
                            <div class="form-group" align="right">
                            <br/>
                              <button type="submit" class="btn btn-primary" name="addgoal">Add goal</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </form>
                          </div>
                        </div>
                        
                      </div>
                    </div>';
          }
          $stmt1->close();

        }

      }else{

        //add the perspective in table row
        $total_measures = $total_measures+1;
        $table .= '<div id="div"><tr><td rowspan="'.$total_measures.'"><span id="mySpan">'.getPerspectiveName($perspective_id).' <i class="fa fa-plus-circle" aria-hidden="true" style="color:#175ae8;" data-toggle="modal" data-target="#goaladd'.$perspective_id.'">goal</i></span></td>';

        //get the goals for selected perspective
        $stmt1 = $conn->prepare("SELECT id, goal FROM bsc_goals WHERE scorecard_id = ? AND perspective_id = ?");
        $stmt1 ->bind_param('ii', $scorecard_id, $perspective_id);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($id, $goal);
        while($stmt1->fetch()){

          //get total measures in selected perspective for the goal
          $stmt2 = $conn->prepare("SELECT COUNT(bsc_targets.id) AS total_measures FROM bsc_targets INNER JOIN bsc_goals ON bsc_targets.goal_id = bsc_goals.id WHERE bsc_goals.scorecard_id = ? AND bsc_goals.perspective_id = ? AND bsc_goals.id = ?");
          $stmt2 ->bind_param('iii', $scorecard_id, $perspective_id, $id);
          $stmt2->execute();
          $stmt2->store_result();
          $stmt2->bind_result($total_goal_measures);
          $stmt2->fetch();
          $stmt2->close();

          //add the goal in table row
          $table .= '<td rowspan="'.$total_goal_measures.'"><p data-toggle="modal" data-target="#goal'.$id.'">'.$goal.'
</p><i class="fa fa-pencil-square-o" aria-hidden="true" style="color:#175ae8;" data-toggle="modal" data-target="#newmeasure'.$id.'">measure</i></td>';

          //counter for the rowspan
          $counter_goals = 0;

          //get measures for the goal
          $stmt2 = $conn->prepare("SELECT bsc_targets.id, measure, measure_type, unit, reporting_frequency, target_period, base_target, stretch_target, actual ,allocated_weight,trend_indicator FROM bsc_targets WHERE goal_id = ?");
          $stmt2 ->bind_param('i', $id);
          $stmt2->execute();
          $stmt2->store_result();
          $stmt2->bind_result($measure_id, $measure, $measure_type, $unit, $reporting_frequency, $target_period, $base_target, $stretch_target, $actual, $allocated_weight,$trend_indicator);
          while($stmt2->fetch()){
            if($counter_goals == 0){
                $table .=  '<form action="../grades.php" method="post" name="myform"><td>';
               if(strlen($measure)>0){
             $table.='<p data-toggle="modal" data-target="#measure'.$measure_id.'">'.$measure.'</p>';
              } else{
                $table.='<i class="fa fa-pencil-square-o" aria-hidden="true" style="color:#175ae8;" data-toggle="modal" data-target="#measure'.$measure_id.'">measure</i>';
              }         
     $table.='</td>
              <td><input type="text" hidden name="scorecard_id" value="'.$_GET['scorecard'].'">
              <input type="text" hidden name="measure_id" value="'.$measure_id.'">
              <input type="text" hidden name="goal_id" value="'.$id.'">
              <select id="unit'.$measure_id.'" name="unit"  onChange="saverow('.$measure_id.'); sendScorecardID();"><option>'.$unit.'</option><option>$</option><option>#</option><option>%</option></select></td>
              <td><select id="reporting_frequency'.$measure_id.'" style="border-color: #175ae8;" name="reporting_frequency" onChange="saverow('.$measure_id.'); sendScorecardID();"><option>'.$reporting_frequency.'</option>'.getRfoptions().'</select></td>
              <td><select id="target_period'.$measure_id.'" name="target_period" onChange="saverow('.$measure_id.');sendScorecardID();"><option>'.$target_period.'</option>'.getRfoptions().'</select></td>';
              if(getMeasureType($measure_id)>0){

              $table.=' <td data-toggle="popover" data-placement="top" data-content="Driven from action plans list"><input type="number" id="base_target'.$measure_id.'" name="base_target" step="any" style="width: 5em" value="'.$base_target.'" readonly></td>
              <td><input type="number" id="stretch_target'.$measure_id.'" name="stretch_target" step="any" style="width: 5em" value="'.$stretch_target.'" readonly></td>
               
             <td data-toggle="popover" data-placement="top" data-content="Driven from action plans list" data-title="'.getActualTooltip($measure_id).'"><p data-toggle="modal" data-target="#action_plans'.$measure_id.'"> <input type="number" name="actual" style="width: 5em" step="any" value="'.$actual.'" readonly id="actual'.$measure_id.'"></p></td>';

              }else{
    $table.=' <td><input type="number" id="base_target'.$measure_id.'" name="base_target" step="any" style="width: 5em" value="'.$base_target.'" onfocusout="saverow('.$measure_id.'); sendScorecardID()"></td>
              <td><input type="number" id="stretch_target'.$measure_id.'" name="stretch_target" step="any" style="width: 5em" value="'.$stretch_target.'" onfocusout="saverow('.$measure_id.');"></td>';
              if(getReportingFrequency($measure_id)=='Y'){
              $table.='<td  data-title="'.getActualTooltip($measure_id).'"><input id="actual'.$measure_id.'" type="number" step="any" name="actual" style="width: 5em" value="'.$actual.'" onfocusout="saverow('.$measure_id.');"></td>';
              }else{
             $table.='<td data-title="'.getActualTooltip($measure_id).'"><p data-toggle="modal" data-target="#select'.$measure_id.'"> <input type="number" name="actual" style="width: 5em" step="any" value="'.$actual.'" readonly id="actual'.$measure_id.'"></p></td>';
              }
            }
          $table.='<td><input id="allocated_weight'.$measure_id.'" type="number" name="allocated_weight" style="width: 3em" max="100" min="1" value="'.$allocated_weight.'" onfocusout="saverow('.$measure_id.'); sendScorecardID(); reloadDiv();"></td>';
             if(getWeightedRating($measure_id)<0){
              $table.='<td><p data-toggle="modal" data-target="#chart'.$id.'" id="wr'.$measure_id.'"><font color="#FF0000">'.round(getWeightedRating($measure_id),2).'%</font></p></td>'; 
              }
              
              elseif(getWeightedRating($measure_id)==0 AND strlen($actual) >0 ){
              $table.='<td><p data-toggle="modal" data-target="#chart'.$id.'" id="wr'.$measure_id.'"><font color="green">'.round(getWeightedRating($measure_id),2).'%</font></p></td>';
            }
             elseif(getWeightedRating($measure_id)==''){
              $table.='<td></td>';
              }
              else{
              $table.='<td><p data-toggle="modal" data-target="#chart'.$id.'" id="wr'.$measure_id.'"><font color="green">'.round(getWeightedRating($measure_id),2).'%</font></p></td>';
            }
            
          $table.=getTrendIndicator($measure_id);
       $table.='<td><button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#comment'.$measure_id.'"><i class="fa fa-commenting-o" aria-hidden="true"></i> <font color="#175ea8"><b>'.countComments($measure_id).'</b></font>
</i></button></td>
 </form>';
       
           $table.='<td><a href="#"><i class="fa fa-trash-o" aria-hidden="true" data-toggle="modal" data-target="#delete'.$measure_id.'"></i></a></td>
              </tr>';

              $counter_goals++;
            }else{
              $table .=  '<form action="../grades.php" method="post" name="myform"><tr><td>';
                 if(strlen($measure)>0){
             $table.='<p data-toggle="modal" data-target="#measure'.$measure_id.'">'.$measure.'
            </p>';
              } else{
                $table.='<td><i class="fa fa-pencil-square-o" aria-hidden="true" style="color:#175ae8;" data-toggle="modal" data-target="#measure'.$measure_id.'">measure</i>';
              }
//straightfromscorecard
     $table.='</td>
              <td><input type="text" hidden name="scorecard_id" value="'.$_GET['scorecard'].'"><input type="text" hidden name="measure_id" value="'.$measure_id.'"><input type="text" hidden name="goal_id" value="'.$id.'">
              <select name="unit" id="unit'.$measure_id.'" onChange="saverow('.$measure_id.');"><option>'.$unit.'</option><option>$</option><option>#</option><option>%</option></select></td>
              <td><select id="reporting_frequency'.$measure_id.'" name="reporting_frequency" onChange="saverow('.$measure_id.');"><option>'.$reporting_frequency.'</option>'.getRfoptions().'</select></td>
              <td><select name="target_period" id="target_period'.$measure_id.'"  onChange="saverow('.$measure_id.');"><option>'.$target_period.'</option>'.getRfoptions().'</select></td>';

       if(getMeasureType($measure_id)>0){

              $table.=' <td data-toggle="popover" data-placement="top" data-content="Driven from action plans list"><input type="number" id="base_target'.$measure_id.'" name="base_target" step="any" style="width: 5em" value="'.$base_target.'" readonly></td>
              <td data-toggle="popover" data-placement="top" data-content="Driven from action plans list"><input type="number" id="stretch_target'.$measure_id.'" name="stretch_target" step="any" style="width: 5em" value="'.$stretch_target.'" readonly></td>
               
             <td data-title="'.getActualTooltip($measure_id).'"><p data-toggle="modal" data-target="#action_plans'.$measure_id.'"> <input type="number" name="actual" style="width: 5em" step="any" value="'.$actual.'" readonly id="actual'.$measure_id.'"></p></td>';

              }else{
    $table.=' <td><input type="number" id="base_target'.$measure_id.'" name="base_target" step="any" style="width: 5em" value="'.$base_target.'" onfocusout="saverow('.$measure_id.'); sendScorecardID()"></td>
              <td><input type="number" id="stretch_target'.$measure_id.'" name="stretch_target" step="any" style="width: 5em" value="'.$stretch_target.'" onfocusout="saverow('.$measure_id.');"></td>';
               if(getReportingFrequency($measure_id)=='Y'){
               $table.='<td  data-title="'.getActualTooltip($measure_id).'"><input id="actual'.$measure_id.'" type="number" step="any" name="actual" style="width: 5em" value="'.$actual.'" onfocusout="saverow('.$measure_id.');"></td>';
              }else{
             $table.='<td data-title="'.getActualTooltip($measure_id).'"><p data-toggle="modal" data-target="#select'.$measure_id.'"> <input type="number" name="actual" style="width: 5em" step="any" value="'.$actual.'" readonly id="actual'.$measure_id.'"></p></td>';
              }
            }
            
     $table.='<td><input id="allocated_weight'.$measure_id.'" type="number" name="allocated_weight" style="width: 3em" max="100" min="1" value="'.$allocated_weight.'"  onfocusout="saverow('.$measure_id.'); sendScorecardID(); reloadDiv();"></td>';
             if(getWeightedRating($measure_id)<0){
              $table.='<td><p data-toggle="modal" data-target="#chart'.$id.'" id="wr'.$measure_id.'"><font color="#FF0000">'.round(getWeightedRating($measure_id),2).'%</font></p></td>'; 
              }
                elseif(getWeightedRating($measure_id)==0 AND strlen($actual) >0 ){
              $table.='<td><p data-toggle="modal" data-target="#chart'.$id.'" id="wr'.$measure_id.'"><font color="green">'.round(getWeightedRating($measure_id),2).'%</font></p></td>';
            }
               elseif(getWeightedRating($measure_id)==''){
              $table.='<td></td>';
               }
              else{
               $table.='<td><p data-toggle="modal" data-target="#chart'.$id.'" id="wr'.$measure_id.'"><font color="green">'.round(getWeightedRating($measure_id),2).'%</font></p></td>';
            }
         $table.=getTrendIndicator($measure_id);
  $table.='</select></td><td><button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#comment'.$measure_id.'"><i class="fa fa-commenting-o" aria-hidden="true"></i> <font color="#175ea8"><b>'.countComments($measure_id).'</b></font>
</i></button></td>
</form>';
$table.='   <td><a href="#"><i class="fa fa-trash-o" aria-hidden="true" data-toggle="modal" data-target="#delete'.$measure_id.'"></i></a></td>
              </tr></div>
              ';
              $counter_goals++;
            }
             echo '<!-- Modal -->
          <div class="modal fade bd-example-modal-lg" tabindex="-1" id="chart'.$id.'" role="dialog">
             <div class="modal-dialog modal-lg" >
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">Goal Supporters</div>';
                 // getOrganogram($scorecard_id,$id);
             
           echo'</div>
              </div>
              </div>';

                 
      echo' <div class="modal inmodal fade" id="action_plans'.$measure_id.'" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4>Tasks Involved to achieve this.</h4>
                                    
                         <div class="modal-body">
                        <div class="row" id="add_to_me'.$measure_id.'">
                        <ul class="todo-list m-t small-list" style="text-align: left;" id="add_to'.$measure_id.'">';
                          getMeasureTasks($measure_id);
                 echo'           </ul>
                        </div><br>
                     <div class="row" id="button'.$measure_id.'">
                     <button class="btn btn-primary btn-sm" onclick="addCode('.$measure_id.')">Add Action Plan</button>
                         </div>

                   
                           <p id="warning'.$measure_id.'" style="color: red;"></p>   
                               </div>
                              
                <div class="modal-footer">                    
           
                  <button data-dismiss="modal" class="btn btn-primary">Done</button>
                                        </div>
                                       
                                    </div>
                                    </div>
                                </div>
                            </div>
';
         

                             echo '<!-- Modal -->
                    <div class="modal fade" id="goaladd'.$perspective_id.'" role="dialog">
                      <div class="modal-dialog">
                      
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Add new goal to <font color="#175ae8">'.getPerspectiveName($perspective_id).'</font> Perspective</h4>

                          </div>
                          <div class="modal-body">
                          <form action="../grades.php" method="POST">

                            <div class="row">
                              <div class="col-lg-12">
                               <div class="form-group">
                               <input type="text" hidden name="scorecard_id" value="'.$_GET['scorecard'].'">
                                <input type="text" hidden name="perspective_id" value="'.$perspective_id.'"> 
                                </div>
                                <div class="form-group">
                              <input type="text" hidden name="company_goal" value="">
                                  </div>
                                <div class="form-group">
                                  <textarea rows="4" cols="10" name="goal" placeholder="Add new goal to a selected perspective" class="form-control"></textarea>
                                  <br/><br/>
                                </div>
                              </div>
                            </div>
                            <div class="form-group" align="right">
                            <br/>
                              <button type="submit" class="btn btn-primary" name="addgoal">Add goal</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </form>
                          </div>
                        </div>
                        
                      </div>
                    </div>';
           
                echo '<!-- Modal -->
          <div class="modal fade bd-example-modal-lg" id="comment'.$measure_id.'" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Add Comments </h4>
                </div>
                <div class="modal-body">';

                     getIndividualComments($measure_id);
                        
                    echo'<div class="row">
                          <div class="col-1"></div>
                          <div class="media-body col-11" style="text-align: right;" id="newcomment'.$measure_id.'">
                            
                            </div>
                          </div>
                       <br> <textarea class="form-control" id="mycomment'.$measure_id.'" placeholder="Write comment..."></textarea><br>
                               
                                <div class="form-group" align="right">
                                    <button type="button" onclick="saveComment('.$scorecard_id.','.$measure_id.')" class="btn btn-primary"><i class="fa fa-send"></i> Send</button>
                                </div>

                    
                   
                  <div class="form-group" align="right">
                 
                    <button type="button" class="btn btn-outline-secondary" style="width: 100%" data-dismiss="modal">Close</button>
                  </div>
              
                </div>
              </div>
              
            </div>
          </div>';
     echo '<!-- Modal -->
          <div class="modal fade" id="goal'.$id.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">Update Goal </h4>
                </div>
                <div class="modal-body" >
                <form action="../grades.php" method="POST">

                  <div class="row" >
                    <div class="col-lg-12">
                      <div class="form-group">
                      <input type="text" name="scorecard_id" value="'.$_GET['scorecard'].'" hidden>
                      <input type="text" name="goal_id" value="'.$id.'" hidden>
                        <textarea rows="4" cols="5" name="goal" placeholder="modify goal" class="form-control">'.$goal.'</textarea>
                        <br/><br/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                    <button type="submit" class="btn btn-primary" name="savegoal">Save goal</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>';

                 echo '<!-- Modal -->
          <div class="modal fade" id="delete'.$measure_id.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Delete Measure </h4>
                </div>
                <div class="modal-body">
                <form action="../grades.php" method="POST">
                 <input type="hidden"  name="scorecard_id" value="'.$scorecard_id.'">
                  <input type="hidden" name="measure_id" value="'.$measure_id.'">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <p align="center">Are you sure you want to delete this measure <b>('.$measure.') </b>?</p>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                  <br/>
                  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                  <button type="submit" class="btn btn-danger" name="deletemeasure">Delete</button></a>
           
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>';
     echo '<!-- Modal -->
          <div class="modal fade bd-example-modal-lg" id="select'.$measure_id.'" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">Actual Achievements</h4>
                </div>
                <div class="modal-body" >
             
                 <div class="row" >
                    <div class="col-lg-12">
                      <div id="33'.$measure_id.'" class="form-group">';
           
             getRevenues2($measure_id);
         
            echo'    
                    </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                      <button type="button" onClick="document.location.reload(true)" class="btn btn-success" data-dismiss="modal"><i class="fa fa-spinner" aria-hidden="true"></i>Process</button>
                  </div>
                
                </div>
              </div>
              
            </div>
          </div>';
          echo '<!-- Modal -->
          <div class="modal fade" id="measure'.$measure_id.'" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Update Measure </h4>
                </div>
                <div class="modal-body">
                <form action="../grades.php" method="POST">

                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                      <input type="text" hidden name="scorecard_id" value="'.$_GET['scorecard'].'">
                      <input type="text" hidden name="measure_id" value="'.$measure_id.'">

                        <textarea rows="4" cols="10" name="measure" placeholder="modify measure" class="form-control">'.$measure.'</textarea>
                        <br/><br/>
                      </div>
                    </div>
                   
                  </div>
                  <div class="form-group" align="right">
                  <br/>
                    <button type="submit" class="btn btn-primary" name="savemeasure">Save measure</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>';
          echo '<!-- Modal -->
          <div class="modal fade" id="newmeasure'.$id.'" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Add new measure to <font color="#175ae8">'.$goal.'</font></h4>
                </div>
                <div class="modal-body">
                <form action="../grades.php" method="POST">

                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                      <input type="text" hidden name="scorecard_id" value="'.$_GET['scorecard'].'">
                      <input type="text" hidden name="perspective_id" value="'.$perspective_id.'">
                      <input type="text" hidden name="goal_id" value="'.$id.'">
                 </div>
                 
                        <textarea rows="4" cols="10" name="measure" placeholder="Type your measure here..." class="form-control" required></textarea>
                        <br/><br/>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                  <br/>
                    <button type="submit" class="btn btn-primary" name="newmeasure">Save new measure</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>';
          }
          $stmt2->close();

        }
         $table.=' 
             <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
             <td><font color="blue">Total</font></td>
             <td ><font color="blue">'.getPerspectiveTotalWeight($perspective_id,$scorecard_id).'</font></td>';
if (getWR($scorecard_id,$perspective_id)<0){
   $table.='<td bgcolor="#FF0000"><font color="#fff">'.round(getWR($scorecard_id,$perspective_id),2).'%</font></td>';
   }else{
    $table.='<td bgcolor="green"><font color="#fff">'.round(getWR($scorecard_id,$perspective_id),2).'%</font></td>';
   }
       $table.='  <td></td>
                  <td></td>
                  </tr>
            ';
        $stmt1->close();

      }

    }
    $stmt->close();
    
    $conn->close();

    //close table tag
    $table .= '<tr>
    <td colspan="8" align="right"><font color="#175ae8">Overall Achievement</font></td>';
    if (getOverallWeight($scorecard_id)!=100){
        $table.='<td colspan="2" align="right" bgcolor="#FF0000"><font color="#fff">'.getOverallWeight($scorecard_id).'%</font></td>';
        }else{
        $table.='<td colspan="2" align="right" bgcolor="green"><font color="#fff">'.getOverallWeight($scorecard_id).' %</font></td>';
        }
 if (getTotalWR($_GET['scorecard'])<0){
   $table.='<td bgcolor="#FF0000"><font color="#fff">'.getTotalWR($_GET['scorecard']).'%</font></td>';
   }else{
    $table.='<td bgcolor="green"><font color="#fff">'.getTotalWR($_GET['scorecard']).'%</font></td>';
   }

  $table.='  </td>
            <td></td>
            <td></td>
            </tr>
    </tbody></table>';

    echo $table;
    
  }

     function getPerspectiveTotalWeight($perspective_id,$scorecard_id){

     $conn = dbconnect();
    $stmt = $conn->prepare("SELECT SUM(allocated_weight) AS total FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE perspective_id=? AND scorecard_id=?");
    $stmt->bind_param('ss', $perspective_id,$scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($total);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

  return $total;
    
  }
          function getOverallWeight($scorecard_id){

    $conn = dbconnect();
    $stmt = $conn->prepare("SELECT SUM(allocated_weight) AS total FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE scorecard_id=?");
    $stmt->bind_param('s',$scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($total);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

  return $total;
    
  }
     function getWR($scorecard_id,$perspective_id){

    $conn = dbconnect();
    $total=0;
    $stmt = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE perspective_id=? AND scorecard_id=?");
    $stmt->bind_param('ii',$perspective_id,$scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($measure_id);
    While($stmt->fetch()){
        $total+=getWeightedRating($measure_id); 
      }
    return $total;
  }
  //   function getMonthlyWR($scorecard_id,$perspective_id){

  //   $conn = dbconnect();
  //   $total=0;
  //   $stmt = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE perspective_id=? AND scorecard_id=?");
  //   $stmt->bind_param('ii',$perspective_id,$scorecard_id);
  //   $stmt->execute();
  //   $stmt->store_result();
  //   $stmt->bind_result($measure_id);
  //   While($stmt->fetch()){
  //       $total+=getMonthlyWeightedRating($measure_id); 
  //     }
  //   return $total;
  // }
  //     function getHalfYearlyWR($scorecard_id,$perspective_id){

  //   $conn = dbconnect();
  //   $total=0;
  //   $stmt = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE perspective_id=? AND scorecard_id=?");
  //   $stmt->bind_param('ii',$perspective_id,$scorecard_id);
  //   $stmt->execute();
  //   $stmt->store_result();
  //   $stmt->bind_result($measure_id);
  //   While($stmt->fetch()){
  //       $total+=getHalfYearlyWeightedRating($measure_id); 
  //     }

  //   return $total;
  // }
  //       function getYearlyWR($scorecard_id,$perspective_id,$year){

  //   $conn = dbconnect();

  //   $stmt=$conn->prepare("SELECT COUNT(id) AS count FROM bsc_scorecards WHERE id=? AND SUBSTR(reporting_period,1,4)=?");
  //   $stmt->bind_param('is',$scorecard_id, $year);
  //   $stmt->execute();
  //   $stmt->store_result();
  //   $stmt->bind_result($count);
  //   $stmt->fetch();
  //   if($count==0){
  //   return 'No data';
  //   }else{
  //       $total=0;
  //   $stmt1 = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id LEFT JOIN bsc_scorecards ON bsc_scorecards.id=scorecard_id WHERE perspective_id=? AND scorecard_id=? AND SUBSTR(reporting_period,1,4)=?");
  //   $stmt1->bind_param('iis',$perspective_id,$scorecard_id,$year);
  //   $stmt1->execute();
  //   $stmt1->store_result();
  //   $stmt1->bind_result($measure_id);
  //   While($stmt1->fetch()){
  //       $total+=getWeightedRating($measure_id); 
  //     }
  //     return $total;
  //     $stmt1->close();
  // } 
  //   $stmt->close();
  //   $conn->close();
  //   }
  //  function getYearlyTotalWR($scorecard_id,$year){

  //   $conn = dbconnect();

  //   $stmt=$conn->prepare("SELECT COUNT(id) AS count FROM bsc_scorecards WHERE id=? AND SUBSTR(reporting_period,1,4)=?");
  //   $stmt->bind_param('is',$scorecard_id, $year);
  //   $stmt->execute();
  //   $stmt->store_result();
  //   $stmt->bind_result($count);
  //   $stmt->fetch();
  //   if($count==0){
  //   return 'No data';
  //   }else{
  //       $total=0;
  //   $stmt1 = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id LEFT JOIN bsc_scorecards ON bsc_scorecards.id=scorecard_id WHERE scorecard_id=? AND SUBSTR(reporting_period,1,4)=?");
  //   $stmt1->bind_param('is',$scorecard_id,$year);
  //   $stmt1->execute();
  //   $stmt1->store_result();
  //   $stmt1->bind_result($measure_id);
  //   While($stmt1->fetch()){
  //       $total+=getWeightedRating($measure_id); 
  //     }
  //     return $total;
  //     $stmt1->close();
  // } 
  //   $stmt->close();
  //   $conn->close();
  //   }
  //       function getQuarterlyWR($scorecard_id,$perspective_id){

  //   $conn = dbconnect();
  //   $total=0;
  //   $stmt = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE perspective_id=? AND scorecard_id=?");
  //   $stmt->bind_param('ii',$perspective_id,$scorecard_id);
  //   $stmt->execute();
  //   $stmt->store_result();
  //   $stmt->bind_result($measure_id);
  //   While($stmt->fetch()){
  //       $total+=getQuarterlyWeightedRating($measure_id); 
  //     }
  //   return $total;
  // }

       function getTotalWR($scorecard_id){

    $conn = dbconnect();
    $total=0;
  
    $stmt = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE scorecard_id=?");
    $stmt->bind_param('i',$scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($measure_id);
    While($stmt->fetch()){
        $total+=getWeightedRating($measure_id); 
      }
    return $total;
  }

  //  function getMonthlyTotalWR($scorecard_id){

  //   $conn = dbconnect();
  //   $total=0;
  
  //   $stmt = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE scorecard_id=?");
  //   $stmt->bind_param('i',$scorecard_id);
  //   $stmt->execute();
  //   $stmt->store_result();
  //   $stmt->bind_result($measure_id);
  //   While($stmt->fetch()){
  //       $total+=getMonthlyWeightedRating($measure_id); 
  //     }
  //   return $total;
  // }

  //    function getQuarterlyTotalWR($scorecard_id){

  //   $conn = dbconnect();
  //   $total=0;
  
  //   $stmt = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE scorecard_id=?");
  //   $stmt->bind_param('i',$scorecard_id);
  //   $stmt->execute();
  //   $stmt->store_result();
  //   $stmt->bind_result($measure_id);
  //   While($stmt->fetch()){

  //       $total+=getQuarterlyWeightedRating($measure_id); 
  //     }
  //   return $total;
  // }

  //      function getHalfYearlyTotalWR($scorecard_id){

  //   $conn = dbconnect();
  //   $total=0;
  
  //   $stmt = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE scorecard_id=?");
  //   $stmt->bind_param('i',$scorecard_id);
  //   $stmt->execute();
  //   $stmt->store_result();
  //   $stmt->bind_result($measure_id);
  //   While($stmt->fetch()){
  //       $total+=getHalfYearlyWeightedRating($measure_id); 
  //     }
  //   return $total;
  // }

 function getWeightedRating($measure_id){
    error_reporting(0);
    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT base_target, stretch_target, allocated_weight, actual FROM bsc_targets WHERE id=?");
    $stmt->bind_param('i',$measure_id);
   // $measure_id=test_input($par1);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($base_target, $stretch_target,$allocated_weight, $actual);
    $stmt->fetch();
  
     if(strlen($actual)<1){
     $weighted_rating=' ';
    }
    elseif($stretch_target==$base_target AND $stretch_target==$actual){
      $weighted_rating=$allocated_weight; 
    }
     elseif($base_target==$actual){
      $weighted_rating=0; 
    }
    else{
    $weighted_rating=(($actual-$base_target)/($stretch_target-$base_target))*$allocated_weight;
    if($weighted_rating>$allocated_weight){
      $weighted_rating=$allocated_weight;
    }
    elseif($weighted_rating<-$allocated_weight){
      $weighted_rating=-$allocated_weight;
    }
    else{
    
    }
  }
    $stmt->close();
    $conn->close();

  return round($weighted_rating,2);
    }

    function sumMonthly($measure_id){
    $conn = dbconnect();
    $month=test_input($_GET['month']);
    $stmt = $conn->prepare("SELECT AVG(amount) AS sum FROM bsc_monthly WHERE target_id=? AND month=?");
    $stmt->bind_param('is',$measure_id,$month);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($sum1);
    $stmt->fetch();
    $stmt->close();
    $monthend = $month."-28";
    $early_month = $month."-01";
   $max_week= date("W", strtotime($monthend)); echo'<br>';
   $min_week= date("W", strtotime($early_month)); 
 
    $stmt = $conn->prepare("SELECT AVG(amount) AS sum FROM bsc_weekly WHERE target_id=? AND SUBSTR(week,7,9)>=? AND SUBSTR(week,7,9)<=?");
    $stmt->bind_param('iss',$measure_id,$min_week,$max_week); 
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($sum2);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
   return $sum1+$sum2;  

   }

   function sumQuarterly($measure_id){
    $conn = dbconnect();
    $month=test_input($_GET['quarter']);

    $stmt = $conn->prepare("SELECT AVG(amount) AS sum FROM bsc_quarterly WHERE target_id=? AND quarter=?");
    $stmt->bind_param('is',$measure_id,$quarter);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($avg);
    $stmt->fetch();
    $stmt->close();
  return $avg;
    

   }

    function sumHalfYearly($measure_id){
    $conn = dbconnect();
    $month=test_input($_GET['half']);

    $stmt = $conn->prepare("SELECT AVG(amount) AS sum FROM bsc_half_yearly WHERE target_id=? AND half=?");
    $stmt->bind_param('is',$measure_id,$half);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($avg);
    $stmt->fetch();
    $stmt->close();
    $start_period=date_sub($half,date_interval_create_from_date_string("6 months"));
    $start_period= date_format($start_period,"Y-m");

    return $avg;  

   }




  function getMonthlyWeightedRating($par1){
  error_reporting(0);
  $conn=dbconnect();

    $stmt = $conn->prepare("SELECT base_target, stretch_target, allocated_weight FROM bsc_targets WHERE id=?");
    $stmt->bind_param('i',$measure_id);
    $measure_id=test_input($par1);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($base_target, $stretch_target,$allocated_weight);
   While($stmt->fetch()){
    if(sumMonthly($measure_id)=='' ){
  $weighted_rating='';
    }
    elseif($stretch_target==$base_target){
       $weighted_rating="0"; 
    }
    else{
    $weighted_rating=((sumMonthly($measure_id)-$base_target)/($stretch_target-$base_target))*$allocated_weight;
    if($weighted_rating>$allocated_weight){
      $weighted_rating=$allocated_weight;
    }
    elseif($weighted_rating<-$allocated_weight){
      $weighted_rating=-$allocated_weight;
    }
    else{

    }
  }
}
    $stmt->close();
    $conn->close();

  return $weighted_rating;
    }
     
         function getQuarterlyWeightedRating($par1){
  error_reporting(0);
  $conn=dbconnect();

    $stmt = $conn->prepare("SELECT base_target, stretch_target, allocated_weight FROM bsc_targets WHERE id=?");
    $stmt->bind_param('i',$measure_id);
    $measure_id=test_input($par1);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($base_target, $stretch_target,$allocated_weight);
   While($stmt->fetch()){
    if(sumQuarterly($measure_id)=='' ){
  $weighted_rating='';
    }
    elseif($stretch_target==$base_target){
       $weighted_rating="0"; 
    }
    else{
    $weighted_rating=((sumQuarterly($measure_id)-$base_target)/($stretch_target-$base_target))*$allocated_weight;
    if($weighted_rating>$allocated_weight){
      $weighted_rating=$allocated_weight;
    }
    elseif($weighted_rating<-$allocated_weight){
      $weighted_rating=-$allocated_weight;
    }
    else{

    }
  }
}
    $stmt->close();
    $conn->close();

  return $weighted_rating;
    }

        function getHalfYearlyWeightedRating($par1){
  error_reporting(0);
  $conn=dbconnect();

    $stmt = $conn->prepare("SELECT base_target, stretch_target, allocated_weight FROM bsc_targets WHERE id=?");
    $stmt->bind_param('i',$measure_id);
    $measure_id=test_input($par1);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($base_target, $stretch_target,$allocated_weight);
   While($stmt->fetch()){
    if(sumHalfyearly($measure_id)=='' ){
  $weighted_rating='';
    }
    elseif($stretch_target==$base_target){
       $weighted_rating="0"; 
    }
    else{
    $weighted_rating=((sumHalfYearly($measure_id)-$base_target)/($stretch_target-$base_target))*$allocated_weight;
    if($weighted_rating>$allocated_weight){
      $weighted_rating=$allocated_weight;
    }
    elseif($weighted_rating<-$allocated_weight){
      $weighted_rating=-$allocated_weight;
    }
    else{

    }
  }
}
    $stmt->close();
    $conn->close();

  return $weighted_rating;
    }

  function getTotalWR2($par1){

    $conn = dbconnect();
    $total=0;
    $stmt = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE scorecard_id=?");
    $stmt->bind_param('i',$scorecard_id);
    $scorecard_id=test_input($par1);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($measure_id);
    if ($stmt->fetch()){
   
        $total+=getWeightedRating($measure_id); 
      }
     else{
      $total=0;
     }
     $stmt->close();
     $conn->close();
    return $total;
  }

  function getActionPlans($scorecard_id){
    $conn=dbconnect();
       $stmt2 = $conn->prepare("SELECT id, scorecard_id, activity, measure, deadline, employee, status, evidence,date   FROM bsc_action_plans WHERE scorecard_id = ? ORDER BY date");
        $stmt2 ->bind_param('i', $scorecard_id);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($id, $scorecard_id,$activity,$measure, $deadline,$employee,$status,$evidence, $date);
       While($stmt2->fetch()){
             echo'
        <tr>
        <td>'.substr($activity,0,30).'</td>
        <td>'.substr($measure,0,30).'</td>
        <td>'.getEmployeeName($employee).'</td>
        <td>
     <div class="progress">  <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
  aria-valuenow="'.$status.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$status.'%">
    <font color="#ffffff">'.$status.'% complete</font>
  </div></div>
        </td>
        <td>'.$deadline.'</td>
        <td>'.substr($date,0,11).'</td>
        <td>'; if(strlen($evidence)>0){
        echo'<a href="'.$evidence.'">download</a>';
        } else{
        echo'Nothing uploaded';
        }
   echo'</td>
        <td><a href="action_plans?edit=true&id='.$id.'"><i class="fa fa-edit" style="color:green;">edit</i></a> <a href="delete.php?action_plan_id='.$id.'&scorecard_id='.$scorecard_id.'"><i class="fa fa-trash" style="color:red;">delete</i></a></td>
        </tr>';
  }
  $stmt2->close();
  $conn->close();
}
    function addActionPlans($scorecard_id, $goal_id, $activity, $measure, $deadline, $employee){

      // Database connection
      $conn = dbconnect();    

      $stmt = $conn->prepare("INSERT INTO bsc_action_plans (scorecard_id, goal_id, activity, measure, deadline, employee) VALUES (?, ?, ?, ?,?,?)");
      $stmt->bind_param('iissss', $scorecard_id, $goal_id, $activity, $measure, $deadline, $employee);
      $stmt->execute();
      $stmt->close();
      //close conn
      $conn->close();

      echo "<script type='text/javascript'>
        window.location.href = 'action_plans/".$scorecard_id."';
        </script>";
    }
        function updateActionPlans($scorecard_id,$goal_id, $activity, $measure, $deadline, $employee,$status,$evidence,$id){

      // Database connection
      $conn = dbconnect();    

      $stmt = $conn->prepare("UPDATE bsc_action_plans SET scorecard_id=?, goal_id=?, activity=?, measure=?, deadline=?, employee=?,status=?, evidence=? WHERE id=?");
      $stmt->bind_param('iissssssi', $scorecard_id,$goal_id, $activity, $measure, $deadline, $employee,$status,$evidence,$id);
      $stmt->execute();
      $stmt->close();
      //close conn
      $conn->close();

      echo "<script type='text/javascript'>
        window.location.href = 'action_plans/".$scorecard_id."';
        </script>";
    }
 function actionPlans(){
  $scorecard_id=$_GET['scorecard'];
  $conn=dbconnect();
  echo ' <a href="../actionplans" class="btn btn-success btn-sm" style="float:right;">Action Plans &nbsp;&nbsp;</a>';

    echo '<!-- Modal -->
          <div class="modal fade" id="newplan'.$scorecard_id.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Explain what you are going to do</h4>
                </div>
                <div class="modal-body">
                <form action="action_plans.php" method="POST">

                 <div class="form-group">
                <label>Select the goal being supported by this action:</label>
      <div class="input-group">
        <div class="input-group-prepend bg-primary">
        <span class="input-group-text bg-transparent">
          <i class="mdi mdi-account text-white"></i>
        </span>
        </div>
       <select name="goal_id" id="goal_id" class="form-control" required>';
   getGoalOptions($scorecard_id);
     echo'  </select>
      </div>
      </div>

                           <div class="form-group">
                <label>Activity:</label>
      <div class="input-group">
        <div class="input-group-prepend bg-primary">
        <span class="input-group-text bg-transparent">
          <i class="mdi mdi-account text-white"></i>
        </span>
        </div>
        <input name="scorecard_id" type="text" hidden value="'.$scorecard_id.'">
       <textarea id="activity"  name="activity" rows="3" class="form-control" required></textarea>

      </div>
      </div>
     
               <div class="form-group">
                <label>Expected results when completed:</label>
      <div class="input-group">
        <div class="input-group-prepend bg-primary">
        <span class="input-group-text bg-transparent">
          <i class="mdi mdi-account text-white"></i>
        </span>
        </div>
       <textarea id="measure"  name="measure" rows="3" class="form-control" required></textarea>

      </div>
      </div>

         <div class="form-group">
                <label>Deadline:</label>
      <div class="input-group">
        <div class="input-group-prepend bg-primary">
        <span class="input-group-text bg-transparent">
          <i class="mdi mdi-account text-white"></i>
        </span>
        </div>
        <input type="date" min="';  
        echo date('Y-m-d');
     echo'" id="deadline" name="deadline" class="form-control" required>

      </div>
      </div>

         <div class="form-group">
                <label>Employee:</label>
      <div class="input-group">
        <div class="input-group-prepend bg-primary">
        <span class="input-group-text bg-transparent">
          <i class="mdi mdi-account text-white"></i>
        </span>
        </div>
      <select id="employee" name="employee" class="form-control" required>';
       getEmployees();
      echo' </select>
       
      </div>
      </div> 
                  <div class="form-group" align="right">
                  <br/>
                    <button type="submit" class="btn btn-primary" name="add">Add </button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>';
 }
 function measuresDirectory(){
  $scorecard_id=$_GET['scorecard'];
  $conn=dbconnect();
  echo '<p><a href="measures_directory/'.$scorecard_id.'"><i class="fa fa-eye fa-lg" aria-hidden="true" style="color:#175ae8;">Measures Directory</i></a> | <a href="measures_directory?addnew=true&scorecard_id='.$scorecard_id.'"><i class="fa fa-plus-circle fa-lg" aria-hidden="true" style="color:#175ae8;" data-toggle="modal" data-target="#newmeasures'.$scorecard_id.'">Measures</i> </a></p>';

    echo '<!-- Modal -->
          <div class="modal fade" id="newmeasures'.$scorecard_id.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Your Organisation \'s measures directory</h4>
                </div>
                <div class="modal-body">
                <form action="measures_directory.php" method="POST">

                <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                         <select name="perspective_id" class="form-control">
      <option selected disabled>Select Perspective in Question</option>';
      getPerpectiveOptions();
    echo'  </select>
                      </div>
                    </div>
                  </div>

                    <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group"> <label>Employees can select these measures:</label>
                     <input name="scorecard_id" type="text" hidden value="'.$scorecard_id.'">
      <input name="measures" id="choices-text-unique-values" type="text" placeholder="seperate measures by clicking enter">
                      </div>
                    </div>
                  </div>      
      </div>

                  <div class="form-group" align="right">
                  <br/>
                    <button type="submit" class="btn btn-primary" name="add">Add </button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>';
 }
 function addMeasuresDirectory($scorecard_id,$perspective_id,$measures){
$conn=dbconnect();

   $stmt = $conn->prepare("SELECT COUNT(*) AS count, id FROM measures_directory WHERE perspective_id=? AND scorecard_id=?");
    $stmt->bind_param('ii',$perspective_id,$scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count,$id);
    $stmt->fetch();
     if($count>0){

$stmt1=$conn->prepare("UPDATE measures_directory SET scorecard_id=?, perspective_id=?, measures=? WHERE id=?");
$stmt1->bind_param('iisi',$scorecard_id,$perspective_id,$measures,$id);
$stmt1->execute();
$stmt1->close();
$conn->close();
echo "<script type='text/javascript'>
        window.location.href = 'scorecard/".$scorecard_id."';
        </script>";
     }else{

$stmt2=$conn->prepare("INSERT INTO measures_directory (scorecard_id, perspective_id, measures) VALUES (?,?,?)");
$stmt2->bind_param('iis',$scorecard_id,$perspective_id,$measures);
$stmt2->execute();
$stmt2->close();
      //close conn
$conn->close();
echo "<script type='text/javascript'>
        window.location.href = 'scorecard/".$scorecard_id."';
        </script>";
     }
     $stmt->close();

 }
  function updateMeasuresDirectory($scorecard_id,$perspective_id,$measures,$measure_id){
$conn=dbconnect();

$stmt1=$conn->prepare("UPDATE measures_directory SET scorecard_id=?, perspective_id=?, measures=? WHERE id=?");
$stmt1->bind_param('iisi',$scorecard_id,$perspective_id,$measures,$measure_id);
$stmt1->execute();
$stmt1->close();
$conn->close();

echo "<script type='text/javascript'>
        window.location.href = 'measures_directory/".$scorecard_id."';
        </script>";
     
     $stmt->close();

 }
  function getMeasuresDirectory($par1){
    $conn=dbconnect();
      $conn=dbconnect();
       $stmt2 = $conn->prepare("SELECT id, scorecard_id, perspective_id, measures FROM measures_directory WHERE scorecard_id = ?");
        $stmt2 ->bind_param('i', $scorecard_id);
        $scorecard_id=test_input($par1);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($id, $scorecard_id,$perspective_id,$measures);
       While($stmt2->fetch()){

   echo'
        <tr>
        <td>'.getPerspectiveName($perspective_id).'</td>
        <td>'.$measures.'</td> 
        <td><a href="measures_directory?edit=true&id='.$id.'&scorecard_id='.$scorecard_id.'"><i class="fa fa-edit" style="color:green;">edit</i></a> <a href="delete.php?measures_directory_id='.$id.'&scorecard_id='.$scorecard_id.'"><i class="fa fa-trash" style="color:red;">delete</i></a></td>
        </tr>';
  }
  $stmt2->close();
  $conn->close();
}

function getSummaryOptions(){
  echo'
  <option>Platinum</option>
  <option>Gold</option>
  <option>Diamond</option>
  <option>Silver</option>
  <option>Bronze</option>';

}
function getWatchList(){
  $conn=dbconnect();

if(countBusinessUnits()>0){
if($_SESSION['account_type']==1){
 $stmt = $conn->prepare("SELECT s.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE (level_id=? OR level_id=?) AND client_id=?");
 $stmt->bind_param('iii',$level_id,$level_id1,$_SESSION['client_id']);
} 
elseif($_SESSION['account_type']==2){
 $stmt = $conn->prepare("SELECT s.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE (level_id=? OR level_id=?) AND client_id=? AND s.business_unit=?");
 $stmt->bind_param('iiii',$level_id, $level_id1,$_SESSION['client_id'],$_SESSION['business_unit']);
} elseif($_SESSION['account_type']==3){
 $stmt = $conn->prepare("SELECT s.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE (level_id=? OR level_id=?) AND client_id=? AND department_id=?");
 $stmt->bind_param('iiii',$level_id,$level_id1,$_SESSION['client_id'],$_SESSION['department_id']);
}
else{
 $stmt = $conn->prepare("SELECT id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE owner=?");
 $stmt->bind_param('i',$_SESSION['user_id']);
}  
}


else{
if($_SESSION['account_type']==1){
 $stmt = $conn->prepare("SELECT s.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE (level_id=? OR level_id=?) AND client_id=?");
 $stmt->bind_param('iii',$level_id,$level_id1,$_SESSION['client_id']);
} elseif($_SESSION['account_type']==3){
 $stmt = $conn->prepare("SELECT s.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE (level_id=? OR level_id=?) AND client_id=? AND department_id=?");
 $stmt->bind_param('iiii',$level_id,$level_id1,$_SESSION['client_id'],$_SESSION['department_id']);
}
else{
 $stmt = $conn->prepare("SELECT scorecards.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE owner=?");
 $stmt->bind_param('i',$_SESSION['user_id']);
} 

}  
    $level_id=4;
    $level_id1=3;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id, $first_name, $last_name, $email, $supervisor_email,$postion,$department);
    while($stmt->fetch()){
      if(getTotalWR($scorecard_id)<0){  

      echo '<tr>

        <td>'.$first_name.' '.$last_name.'</td>
        <td>'.$postion.'</td>
        <td>'.getDepartmentName($department).'</td>
        <td>'.getSupervisorName($supervisor_email).'</td>
        <td align="center"><font color="red">'.round(getTotalWR($scorecard_id),1).'%</font></td>
        <td>
        <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Options</button>
        <ul class="dropdown-menu">
                              
        <li> <a href="scorecard/'.$scorecard_id.'"> <button type="button" class="btn btn-outline-primary">View Scorecard</button></a></li>
        <li> <a href="downloads/'.$scorecard_id.'" class="btn btn-sm btn-outline-primary"><i class="fa fa-download"></i>Download Report</a></li>               
        </ul>
        </div>
   </td>



      </tr>';
    }
  }
    $stmt->close();
    //close conn
    $conn->close();

  }
  
  function getWatchListByActionPlans(){
  $conn=dbconnect();

if(countBusinessUnits()>0){
if($_SESSION['account_type']==1){
 $stmt = $conn->prepare("SELECT s.id, a.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE level_id=? AND client_id=?");
 $stmt->bind_param('ii',$level_id,$_SESSION['client_id']);
} 
elseif($_SESSION['account_type']==2){
 $stmt = $conn->prepare("SELECT s.id, a.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE level_id=? AND client_id=? AND s.business_unit=?");
 $stmt->bind_param('iii',$level_id,$_SESSION['client_id'],$_SESSION['business_unit']);
} elseif($_SESSION['account_type']==3){
 $stmt = $conn->prepare("SELECT s.id, a.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE level_id=? AND client_id=? AND department_id=?");
 $stmt->bind_param('iii',$level_id,$_SESSION['client_id'],$_SESSION['department_id']);
}
else{
 $stmt = $conn->prepare("SELECT s.id, a.id first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner  WHERE owner=?");
 $stmt->bind_param('i',$_SESSION['user_id']);
}  
}


else{
if($_SESSION['account_type']==1){
 $stmt = $conn->prepare("SELECT s.id, a.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE level_id=? AND client_id=?");
 $stmt->bind_param('ii',$level_id,$_SESSION['client_id']);
} elseif($_SESSION['account_type']==3){
 $stmt = $conn->prepare("SELECT s.id, a.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE level_id=? AND client_id=? AND department_id=?");
 $stmt->bind_param('iii',$level_id,$_SESSION['client_id'],$_SESSION['department_id']);
}
else{
 $stmt = $conn->prepare("SELECT scorecards.id, a.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE owner=?");
 $stmt->bind_param('i',$_SESSION['user_id']);
} 

}  
    $level_id=4;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id, $user_id, $first_name, $last_name, $email, $supervisor_email,$postion,$department);
    while($stmt->fetch()){
      if(getIndividualCompletionProgress($user_id)<50){  

      echo '<tr>

        <td>'.$first_name.' '.$last_name.'</td>
        <td>'.$postion.'</td>
        <td>'.getDepartmentName($department).'</td>
        <td>'.getSupervisorName($supervisor_email).'</td>
        <td align="center"><font color="red">'.round(getIndividualCompletionProgress($user_id),1).'%</font></td>
        <td>
        <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Options</button>
        <ul class="dropdown-menu">
                              
        <li> <a href="scorecard/'.$scorecard_id.'"> <button type="button" class="btn btn-outline-primary">View Scorecard</button></a></li>
        <li> <a href="downloads/'.$scorecard_id.'" class="btn btn-sm btn-outline-primary"><i class="fa fa-download"></i>Download Report</a></li>               
        </ul>
        </div>
   </td>



      </tr>';
    }
  }
    $stmt->close();
    //close conn
    $conn->close();

  }
  
    function getBothWatchLists(){
  $conn=dbconnect();

if(countBusinessUnits()>0){
if($_SESSION['account_type']==1){
 $stmt = $conn->prepare("SELECT s.id, a.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE level_id=? AND client_id=?");
 $stmt->bind_param('ii',$level_id,$_SESSION['client_id']);
} 
elseif($_SESSION['account_type']==2){
 $stmt = $conn->prepare("SELECT s.id, a.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE level_id=? AND client_id=? AND s.business_unit=?");
 $stmt->bind_param('iii',$level_id,$_SESSION['client_id'],$_SESSION['business_unit']);
} elseif($_SESSION['account_type']==3){
 $stmt = $conn->prepare("SELECT s.id, a.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE level_id=? AND client_id=? AND department_id=?");
 $stmt->bind_param('iii',$level_id,$_SESSION['client_id'],$_SESSION['department_id']);
}
else{
 $stmt = $conn->prepare("SELECT s.id, a.id first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner  WHERE owner=?");
 $stmt->bind_param('i',$_SESSION['user_id']);
}  
}


else{
if($_SESSION['account_type']==1){
 $stmt = $conn->prepare("SELECT s.id, a.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE level_id=? AND client_id=?");
 $stmt->bind_param('ii',$level_id,$_SESSION['client_id']);
} elseif($_SESSION['account_type']==3){
 $stmt = $conn->prepare("SELECT s.id, a.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE level_id=? AND client_id=? AND department_id=?");
 $stmt->bind_param('iii',$level_id,$_SESSION['client_id'],$_SESSION['department_id']);
}
else{
 $stmt = $conn->prepare("SELECT scorecards.id, a.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE owner=?");
 $stmt->bind_param('i',$_SESSION['user_id']);
} 

}  
    $level_id=4;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id, $user_id, $first_name, $last_name, $email, $supervisor_email,$postion,$department);
    while($stmt->fetch()){
      if(getIndividualCompletionProgress($user_id)<50 AND getTotalWR($scorecard_id)<0){  

      echo '<tr>

        <td>'.$first_name.' '.$last_name.'</td>
        <td>'.$postion.'</td>
        <td>'.getDepartmentName($department).'</td>
        <td>'.getSupervisorName($supervisor_email).'</td>
        <td align="center"><font color="red">'.round(getIndividualCompletionProgress($user_id)+getTotalWR($scorecard_id),1).'%</font></td>
        <td>
        <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Options</button>
        <ul class="dropdown-menu">
                              
        <li> <a href="scorecard/'.$scorecard_id.'"> <button type="button" class="btn btn-outline-primary">View Scorecard</button></a></li>
        <li> <a href="downloads/'.$scorecard_id.'" class="btn btn-sm btn-outline-primary"><i class="fa fa-download"></i>Download Report</a></li>               
        </ul>
        </div>
   </td>



      </tr>';
    }
  }
    $stmt->close();
    //close conn
    $conn->close();

  }
  
  function getIndividualCompletionProgress($user_id){
      $conn=dbconnect();
      
    $stmt = $conn->prepare("SELECT AVG(completion) FROM bsc_project_tasks LEFT JOIN bsc_projects ON bsc_projects.id=project_id WHERE (manager =? OR assigned=?) AND client_id=?");
    $stmt->bind_param('iii',$user_id,$user_id,$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($average);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $average;
  }
  
  
  
  function getCountWatchList(){
  $conn=dbconnect();
  $count=0;
     if($_SESSION['account_type']==1){
      $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE level_id=? AND client_id=?");
      $stmt->bind_param('ii',$level_id,$_SESSION['client_id']);
     }
     elseif($_SESSION['account_type']==2){
      $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE level_id=? AND client_id=? AND business_unit=?");
      $stmt->bind_param('iii',$level_id,$_SESSION['client_id'],$_SESSION['business_unit']);
      }elseif($_SESSION['account_type']==3){
      $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE level_id=? AND client_id=? AND department_id=?");
      $stmt->bind_param('iii',$level_id,$_SESSION['client_id'],$_SESSION['department_id']);
     }
     else{
      $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE owner=?");
      $stmt->bind_param('i',$_SESSION['user_id']);
     }
     
    $level_id=4;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id);
    while($stmt->fetch()){
// $count=COUNT(getTotalWR($scorecard_id)<0);
if(getTotalWR($scorecard_id)<0){
  $count++;
  }
  }
    $stmt->close();
    $conn->close();
return $count;
  }
  
  
function sendLastUpdatedReminder(){
  $conn=dbconnect();
  $twoweeksago = mktime(0, 0, 0, date("m"), date("d")-14,   date("Y"));
        $stmt = $conn->prepare("SELECT id, last_updated FROM scorecards");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($scorecard_id, $last_updated);
        while($stmt->fetch()){
          if($twoweeksago>$last_updated){
            sendReminder($scorecard_id);
          }


        }
       
}

function checkFirstUpdate(){
  $conn=dbconnect();

        //$date2=date_create(date("Y-m-d"));
      
        $stmt = $conn->prepare("SELECT id, date FROM bsc_scorecards WHERE date<? ");
        $stmt->bind_param('s',$date);
        $date=date('Y-m-d', strtotime('-6 days'));
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($scorecard_id, $thedate);
        while($stmt->fetch()){

// $date1=date_create($thedate);
// $date2=date_create(date("Y-m-d"));
// $diff=date_diff($date1,$date2);

$earlier = new DateTime($thedate);
$later = new DateTime(date('Y-m-d'));

$diff = $later->diff($earlier)->format("%a");

        $stmt1 = $conn->prepare("SELECT COUNT(bsc_goals.id) AS count FROM  bsc_goals WHERE scorecard_id=?");
        $stmt1->bind_param('i',$scorecard_id);       
        //$date=date_create();
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($count);
        $stmt1->fetch();

          if($count==0){
           sendFirstReminder($scorecard_id,$diff);
             //echo $scorecard_id;   echo getOwner($scorecard_id); echo '<br>';
          }

          $stmt1->close();
        }
      $stmt->close();
      $conn->close(); 
}
function getRfoptions(){
	return ' <option value="W">W</option>
		     <option value="M">M</option>
		     <option value="Q">Q</option>
		     <option value="HY">HY</option>
		     <option value="Y">Y</option>';
}


function getRevenues($measure_id){
	$conn=dbconnect();
	$stmt=$conn->prepare("SELECT reporting_frequency FROM bsc_targets WHERE id=?");
	$stmt->bind_param('i',$measure_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($reporting_frequency);
	$stmt->fetch();
	if($reporting_frequency=='W'){
       $table='<table class="table table-bordered table-condensed dataTable js-exportable">
       <tr><th>Week</th><th>Value</th></tr>';

	    $stmt6= $conn->prepare("SELECT COUNT(*) FROM bsc_weekly WHERE target_id=?");
	    $stmt6->bind_param('i', $measure_id);
	    $stmt6->execute();
	    $stmt6->store_result();
	    $stmt6->bind_result($count);
	    $stmt6->fetch();
	    if($count<1){
          insertWeek_id($measure_id);
	    }
	     $stmt6->close();

		$stmt1=$conn->prepare("SELECT id, week, amount FROM bsc_weekly WHERE target_id=?");
		$stmt1->bind_param('i', $measure_id);
		$stmt1->execute();
		$stmt1->store_result();
		$stmt1->bind_result($week_id,$week,$amount);
		While($stmt1->fetch()){
			$table.='<tr><td><input type="week" name="week" value="'.$week.'" onfocusout="autosaveWeek(this.value,'.$measure_id.','.$week_id.')"></td><td><input type="number" step="any" name="amount" value="'.$amount.'" onfocusout="autosaveWeeklyAmount(this.value,'.$measure_id.','.$week_id.')"><i class="fa fa-trash-o" aria-hidden="true" onClick="deleteWeek('.$week_id.','.$measure_id.');"> </i></td></tr>';
		}
			$table.='</table>';
		$stmt1->close();
	}
	elseif($reporting_frequency=='M'){
		$table='<table class="table table-bordered table-condensed dataTable js-exportable">
		<tr><th>Month</th><th>Value</th></tr>';

		$stmt6= $conn->prepare("SELECT COUNT(*) FROM monthly WHERE target_id=?");
	    $stmt6->bind_param('i', $measure_id);
	    $stmt6->execute();
	    $stmt6->store_result();
	    $stmt6->bind_result($count);
	    $stmt6->fetch();
	    if($count<1){
          insertMonth_id($measure_id);
	    }
	     $stmt6->close();
		
		$stmt1=$conn->prepare("SELECT id, month, amount FROM bsc_monthly WHERE target_id=?");
		$stmt1->bind_param('i', $measure_id);
		$stmt1->execute();
		$stmt1->store_result();
		$stmt1->bind_result($month_id,$month,$amount);
		While($stmt1->fetch()){
			$table.='<tr><td><input type="month" name="month" value="'.$month.'" onfocusout="autosaveMonth(this.value,'.$measure_id.','.$month_id.')"></td><td><input type="number" step="any" name="amount" value="'.$amount.'" onfocusout="autosaveMonthlyAmount(this.value,'.$measure_id.','.$month_id.')"><i class="fa fa-trash-o" aria-hidden="true" onClick="deleteMonth('.$month_id.','.$measure_id.');"> </i></td></tr>';
		}
			$table.='</table>';
		$stmt1->close();
	}
		elseif($reporting_frequency=='Q'){
		$table='<table class="table table-bordered table-condensed dataTable js-exportable">
		<tr><th>Quarter</th><th>Value</th></tr>';
		
		$stmt6= $conn->prepare("SELECT COUNT(*) FROM bsc_quarterly WHERE target_id=?");
	    $stmt6->bind_param('i', $measure_id);
	    $stmt6->execute();
	    $stmt6->store_result();
	    $stmt6->bind_result($count);
	    $stmt6->fetch();
	    if($count<1){
          insertQuarter_id($measure_id);
	    }
	     $stmt6->close();

		$stmt1=$conn->prepare("SELECT id, quarter, amount FROM bsc_quarterly WHERE target_id=?");
		$stmt1->bind_param('i', $measure_id);
		$stmt1->execute();
		$stmt1->store_result();
		$stmt1->bind_result($quarter_id,$quarter,$amount);
		While($stmt1->fetch()){
			$table.='<tr><td><input type="month" name="quarter" value="'.$quarter.'"onfocusout="autosaveQuarter(this.value,'.$measure_id.','.$quarter_id.')"></td><td><input type="number" step="any" name="amount" value="'.$amount.'" onfocusout="autosaveQuarterlyAmount(this.value,'.$measure_id.','.$quarter_id.')"><i class="fa fa-trash-o" aria-hidden="true" onClick="deleteQuarter('.$quarter_id.','.$measure_id.');"> </i></td></tr>';
		}
			$table.='</table>';
		$stmt1->close();
	}
		elseif($reporting_frequency=='HY'){
		$table='<table class="table table-bordered table-condensed dataTable js-exportable">
		<tr><th>Half</th><th>Value</th></tr>';

		$stmt6= $conn->prepare("SELECT COUNT(*) FROM bsc_half_yearly WHERE target_id=?");
	    $stmt6->bind_param('i', $measure_id);
	    $stmt6->execute();
	    $stmt6->store_result();
	    $stmt6->bind_result($count);
	    $stmt6->fetch();
	    if($count<1){
          insertHalf_id($measure_id);
	    }
	     $stmt6->close();
		
		$stmt1=$conn->prepare("SELECT id, half, amount FROM bsc_half_yearly WHERE target_id=?");
		$stmt1->bind_param('i', $measure_id);
		$stmt1->execute();
		$stmt1->store_result();
		$stmt1->bind_result($half_id,$half,$amount);
		While($stmt1->fetch()){
			$table.='<tr><td><input type="month" name="half" value="'.$half.'" onfocusout="autosaveHalf(this.value,'.$measure_id.','.$half_id.')"></td><td><input type="number" step="any" name="amount" value="'.$amount.'" onfocusout="autosaveHalflyAmount(this.value,'.$measure_id.','.$half_id.')"><i class="fa fa-trash-o" aria-hidden="true" onClick="deleteHalf('.$half_id.','.$measure_id.');"> </i></td></tr>';
		}
			$table.='</table>';
		$stmt1->close();
	}
	else{
$table='<table><tr><td>Please add allocated weight and save first and reload so that the system decides on which interface to give you</td></tr></table>';
	}
echo $table;
}
function update_rf($reporting_frequency,$measure_id){
	$conn=dbconnect();
	$stmt=$conn->prepare("UPDATE bsc_targets SET reporting_frequency=? WHERE id=?");
	$stmt->bind_param('si',$reporting_frequency,$measure_id);
	$stmt->execute();
	$stmt->close();
	$conn->close();
}
  function insertWeeklyAmount($amount,$measure_id,$week_id){
  	$conn=dbconnect();
    
    $score = updateScore($measure_id,$amount);

    $stmt= $conn->prepare("SELECT week FROM bsc_weekly WHERE id =?");
    $stmt->bind_param('i', $week_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($week);
    $stmt->fetch();
    $stmt->close();

    $month = date('Y-m',strtotime($week));
   //$date = date('m', strtotime($week));
   //$month = $year.'-'.$date;
    //$month ='2020-01';
    //$score = 21;
    
  	$stmt1 = $conn->prepare("UPDATE bsc_weekly SET target_id=?, amount=?, month=?, score=? WHERE id=? AND target_id=?");
    $stmt1->bind_param('isssii', $measure_id,$amount,$month,$score,$week_id,$measure_id);
    $stmt1->execute();
    $stmt1->close();
    sumActual($measure_id,'W');

    $stmt= $conn->prepare("SELECT amount FROM bsc_weekly WHERE target_id=? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param('i', $measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();

    if(strlen($amount)>0){
   insertWeek_id($measure_id);
    }
    else{

    }
    $stmt->close();
    $conn->close(); 
  }
   function insertWeek($week,$measure_id,$week_id){
  	$conn=dbconnect();

  	$stmt1 = $conn->prepare("UPDATE bsc_weekly SET target_id=?, week=? WHERE id=?");
    $stmt1->bind_param('isi', $measure_id,$week,$week_id);
    $stmt1->execute();
    $stmt1->close();

    $stmt= $conn->prepare("SELECT amount FROM bsc_weekly WHERE target_id=? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param('i', $measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();

    if(strlen($amount)>0){
   insertWeek_id($measure_id);
    }
    else{

    }
    $stmt->close();
    $conn->close(); 
  }
  function insertWeek_id($measure_id){
  	$conn=dbconnect();
    $stmt1 = $conn->prepare("INSERT INTO bsc_weekly (target_id) VALUES (?)");
    $stmt1->bind_param('i', $measure_id);
    $stmt1->execute();
    $stmt1->close();

  }
   function insertMonth_id($measure_id){
  	$conn=dbconnect();
    $stmt1 = $conn->prepare("INSERT INTO bsc_monthly (target_id) VALUES (?)");
    $stmt1->bind_param('i', $measure_id);
    $stmt1->execute();
    $stmt1->close();

  }
   function insertQuarter_id($measure_id){
  	$conn=dbconnect();
    $stmt1 = $conn->prepare("INSERT INTO bsc_quarterly (target_id) VALUES (?)");
    $stmt1->bind_param('i', $measure_id);
    $stmt1->execute();
    $stmt1->close();

  }
   function insertHalf_id($measure_id){
  	$conn=dbconnect();
    $stmt1 = $conn->prepare("INSERT INTO bsc_half_yearly (target_id) VALUES (?)");
    $stmt1->bind_param('i', $measure_id);
    $stmt1->execute();
    $stmt1->close();

  }
  function insertMonthlyAmount($amount,$measure_id,$month_id){
  	$conn=dbconnect();
    // $score = 30;
    $score = updateScore($measure_id,$amount);
  	$stmt1 = $conn->prepare("UPDATE bsc_monthly SET target_id=?, amount=?, score=? WHERE id=? AND target_id =? ");
    $stmt1->bind_param('issii', $measure_id,$amount,$score,$month_id,$measure_id);
    $stmt1->execute();
    $stmt1->close();
    sumActual($measure_id,'M');

    $stmt= $conn->prepare("SELECT amount FROM bsc_monthly WHERE target_id=? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param('i', $measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();

    if(strlen($amount)>0){
  insertMonth_id($measure_id);
  
    }
    else{

    }
    $stmt->close();
    $conn->close(); 
  }
   function insertMonth($month,$measure_id,$month_id){
  	$conn=dbconnect();

  	$stmt1 = $conn->prepare("UPDATE bsc_monthly SET target_id=?, month=? WHERE id=?");
    $stmt1->bind_param('isi', $measure_id,$month,$month_id);
    $stmt1->execute();
    $stmt1->close();
  
    $stmt= $conn->prepare("SELECT amount FROM bsc_monthly WHERE target_id=? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param('i', $measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();

    if(strlen($amount)>0){
   insertMonth_id($measure_id);
    }
    else{

    }
    $stmt->close();
    $conn->close(); 
  }
  function insertQuarterlyAmount($amount,$measure_id,$quarter_id){
  	$conn=dbconnect();

  	$stmt1 = $conn->prepare("UPDATE bsc_quarterly SET target_id=?, amount=? WHERE id=?");
    $stmt1->bind_param('isi', $measure_id,$amount,$quarter_id);
    $stmt1->execute();
    $stmt1->close();
    sumActual($measure_id,'Q');

    $stmt= $conn->prepare("SELECT amount FROM bsc_quarterly WHERE target_id=? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param('i', $measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();

    if(strlen($amount)>0){
   insertQuarter_id($measure_id);
    }
    else{

    }
    $stmt->close();
    $conn->close(); 
  }
   function insertQuarter($quarter,$measure_id,$quarter_id){
  	$conn=dbconnect();

  	$stmt1 = $conn->prepare("UPDATE bsc_quarterly SET target_id=?, quarter=? WHERE id=?");
    $stmt1->bind_param('isi', $measure_id,$quarter,$quarter_id);
    $stmt1->execute();
    $stmt1->close();
  
    $stmt= $conn->prepare("SELECT amount FROM bsc_quarterly WHERE target_id=? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param('i', $measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();

    if(strlen($amount)>0){
   insertQuarter_id($measure_id);
    }
    else{

    }
    $stmt->close();
    $conn->close(); 
  }
    function insertHalflyAmount($amount,$measure_id,$half_id){
  	$conn=dbconnect();

  	$stmt1 = $conn->prepare("UPDATE bsc_half_yearly SET target_id=?, amount=? WHERE id=?");
    $stmt1->bind_param('isi', $measure_id,$amount,$half_id);
    $stmt1->execute();
    $stmt1->close();
    sumActual($measure_id,'HY');

    $stmt= $conn->prepare("SELECT amount FROM bsc_half_yearly WHERE target_id=? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param('i', $measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();

    if(strlen($amount)>0){
   insertHalf_id($measure_id);
    }
    else{

    }
    $stmt->close();
    $conn->close(); 
  }
   function insertHalf($half,$measure_id,$half_id){
  	$conn=dbconnect();

  	$stmt1 = $conn->prepare("UPDATE bsc_half_yearly SET target_id=?, half=? WHERE id=?");
    $stmt1->bind_param('isi', $measure_id,$half,$half_id);
    $stmt1->execute();
    $stmt1->close();
  
    $stmt= $conn->prepare("SELECT amount FROM bsc_half_yearly WHERE target_id=? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param('i', $measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();

    if(strlen($amount)>0){
   insertHalf_id($measure_id);
    }
    else{

    }
    $stmt->close();
    $conn->close(); 
  }
  function sumActual($measure_id,$reporting_frequency){

  	$conn=dbconnect();
    $empty=' ';

    if($reporting_frequency=='W'){
  	$stmt= $conn->prepare("SELECT COUNT(id), SUM(amount) FROM bsc_weekly WHERE target_id=? AND week !=? AND amount!=?");
     }

    elseif($reporting_frequency=='M'){
    $stmt= $conn->prepare("SELECT COUNT(id), SUM(amount) FROM bsc_monthly WHERE target_id=? AND month!=? AND amount!=?");
   }

   elseif($reporting_frequency=='Q'){
    $stmt= $conn->prepare("SELECT COUNT(id), SUM(amount) FROM bsc_quarterly WHERE target_id=? AND quarter!=? AND amount!=?");
   }

    else{
    $stmt= $conn->prepare("SELECT COUNT(id), SUM(amount) FROM bsc_half_yearly WHERE target_id=? AND half!=? AND amount!=?");
   }
   
    $stmt->bind_param('iss', $measure_id,$empty,$empty);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count, $amount);
    $stmt->fetch();
    $stmt->close();

    $average=$amount/$count;
    
    if($count >=1){
    $stmt = $conn->prepare("UPDATE bsc_targets SET actual=? WHERE id=?");
    $stmt->bind_param('si',$average,$measure_id);
    $stmt->execute();
    $stmt->close();
    }
   
  if($count<1){
    $stmt = $conn->prepare("UPDATE bsc_targets SET actual=? WHERE id=?");
    $stmt->bind_param('si',$empty,$measure_id);
    $stmt->execute();
    $stmt->close();    
  }
    $conn->close(); 
         echo "<script type='text/javascript'>
            window.location.href = 'javascript:history.go(-1)';
            </script>"; 
  }
 

//  function sumActual($measure_id){

//   	$conn=dbconnect();
//   	$empty=' ';
//   	$stmt= $conn->prepare("SELECT COUNT(id), SUM(amount) FROM weekly WHERE target_id=?");
//     $stmt->bind_param('i', $measure_id);
//     $stmt->execute();
//     $stmt->store_result();
//     $stmt->bind_result($count, $amount);
//     $stmt->fetch();
//     $stmt->close();
    
//     $stmt= $conn->prepare("SELECT COUNT(id), SUM(amount) FROM monthly WHERE target_id=?");
//     $stmt->bind_param('i', $measure_id);
//     $stmt->execute();
//     $stmt->store_result();
//     $stmt->bind_result($count1, $amount1);
//     $stmt->fetch();
//     $stmt->close();

//     $stmt= $conn->prepare("SELECT COUNT(id), SUM(amount) FROM quarterly WHERE target_id=?");
//     $stmt->bind_param('i', $measure_id);
//     $stmt->execute();
//     $stmt->store_result();
//     $stmt->bind_result($count2, $amount2);
//     $stmt->fetch();
//     $stmt->close();

//     $stmt= $conn->prepare("SELECT COUNT(id), SUM(amount) FROM half_yearly WHERE target_id=?");
//     $stmt->bind_param('i', $measure_id);
//     $stmt->execute();
//     $stmt->store_result();
//     $stmt->bind_result($count3, $amount3);
//     $stmt->fetch();
//     $stmt->close();


//     $total=$amount+$amount1+$amount2+$amount3; 
//     $mycount = $count+$count1+$count2+$count3;
//     $average=$total/$mycount;
//   //echo "<script language=javascript> alert('$average'); window.location='grades.php?password_error=true'; </script>"; 
//     if($mycount >=1){
//     $stmt = $conn->prepare("UPDATE targets SET actual=? WHERE id=?");
//     $stmt->bind_param('ii',$average,$measure_id);
//     $stmt->execute();
//     $stmt->close();
//     }
   
//   if($mycount<1){
//      $stmt = $conn->prepare("UPDATE targets SET actual=? WHERE id=?");
//     $stmt->bind_param('si',$empty,$measure_id);
//     $stmt->execute();
//     $stmt->close();    
//   }
//     $conn->close(); 
//          echo "<script type='text/javascript'>
//             window.location.href = 'grades.php?average=".$average."';
//             </script>"; 
//   }
 
function removeWeekly($week_id,$measure_id){
  	$conn=dbconnect();
  	$stmt=$conn->prepare("DELETE FROM bsc_weekly WHERE id=?");
  	$stmt->bind_param('i',$week_id);
  	$stmt->execute();
  	$stmt->close();
  	$conn->close();
  	sumActual($measure_id);
  }
   function removeMonthly($month_id,$measure_id){
  	$conn=dbconnect();
  	$stmt=$conn->prepare("DELETE FROM bsc_monthly WHERE id=?");
  	$stmt->bind_param('i',$month_id);
  	$stmt->execute();
  	$stmt->close();
  	$conn->close();
  	sumActual($measure_id);
  }
   function removeQuarterly($quarter_id,$measure_id){
  	$conn=dbconnect();
  	$stmt=$conn->prepare("DELETE FROM bsc_quarterly WHERE id=?");
  	$stmt->bind_param('i',$quarter_id);
  	$stmt->execute();
  	$stmt->close();
  	$conn->close();
  	sumActual($measure_id);
  }
   function removeHalfYearly($half_id,$measure_id){
  	$conn=dbconnect();
  	$stmt=$conn->prepare("DELETE FROM bsc_half_yearly WHERE id=?");
  	$stmt->bind_param('i',$half_id);
  	$stmt->execute();
  	$stmt->close();
  	$conn->close();
  	sumActual($measure_id);
  }
   function deleteMeasure($measure_id,$scorecard_id){
  	$conn=dbconnect();

  	$stmt=$conn->prepare("SELECT goal_id FROM bsc_targets WHERE id=?");
  	$stmt->bind_param('i',$measure_id);
  	$stmt->execute();
  	$stmt->store_result();
  	$stmt->bind_result($goal_id);
  	$stmt->fetch();
  	$stmt->close();
    
    $stmt=$conn->prepare("SELECT COUNT(*) FROM bsc_targets WHERE goal_id=?");
  	$stmt->bind_param('i',$goal_id);
  	$stmt->execute();
  	$stmt->store_result();
  	$stmt->bind_result($count);
  	$stmt->fetch();
  	if($count==1){

    $stmt1=$conn->prepare("DELETE FROM bsc_goals WHERE id=?");
  	$stmt1->bind_param('i',$goal_id);
  	$stmt1->execute();
  	$stmt1->close();
  	}
    $stmt->close();

    $stmt=$conn->prepare("DELETE FROM bsc_targets WHERE id=?");
  	$stmt->bind_param('i',$measure_id);
  	$stmt->execute();
  	$stmt->close();

  	$stmt=$conn->prepare("DELETE FROM bsc_weekly WHERE target_id=?");
  	$stmt->bind_param('i',$measure_id);
  	$stmt->execute();
  	$stmt->close();

  	$stmt=$conn->prepare("DELETE FROM bsc_monthly WHERE target_id=?");
  	$stmt->bind_param('i',$measure_id);
  	$stmt->execute();
  	$stmt->close();
    
    $stmt=$conn->prepare("DELETE FROM bsc_quarterly WHERE target_id=?");
  	$stmt->bind_param('i',$measure_id);
  	$stmt->execute();
  	$stmt->close();

  	$stmt=$conn->prepare("DELETE FROM bsc_half_yearly WHERE target_id=?");
  	$stmt->bind_param('i',$measure_id);
  	$stmt->execute();
  	$stmt->close();

  	$stmt=$conn->prepare("DELETE FROM bsc_comments WHERE measure_id=?");
  	$stmt->bind_param('i',$measure_id);
  	$stmt->execute();
  	$stmt->close();
  	$stmt->close();
  	$conn->close();

  	echo "<script type='text/javascript'>
        window.location.href = 'scorecard/".$scorecard_id."';
        </script>";
  }
  function getEndPeriod($scorecard_id){
  	$conn=dbconnect();

	$stmt=$conn->prepare("SELECT id, date FROM bsc_scorecards WHERE id=? ");
	$stmt ->bind_param('i', $scorecard_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id, $starting_period);
	$stmt->fetch();

    $d = date_parse_from_format("Y-m-d H:i:s", $starting_period);
    $month= $d["month"]; 
//$nextyear= date('Y-m-d H:i:s', strtotime($starting_period .'+1 years')); //added +1 years along with the $date
//$month2= $nextyear["month"]; 
      
$table='<table><tr>';
for($i=$month; $i<13; $i++){
$starting_month= date('F', mktime(0, 0, 0, $i, 10)); 
$table.='<td>'.$starting_month.'</td>'; 
        for($i=0; $i<$month; $i++){
  	if($i>0){
  $end_month= date('F', mktime(0, 0, 0, $i, 10));
$table.='<td>'.$end_month.'</td>';
	
		}
  }

}
  
$table.='</tr>'; 
        $stmt1=$conn->prepare("SELECT monthly.id, month, amount FROM bsc_monthly LEFT JOIN bsc_targets ON target_id=bsc_targets.id LEFT JOIN bsc_goals ON goal_id=bsc_goals.id WHERE scorecard_id=?");
		$stmt1->bind_param('i', $scorecard_id);
		$stmt1->execute();
		$stmt1->store_result();
		$stmt1->bind_result($month_id,$month,$amount);
		$stmt1->fetch();    
$table.='<tr><td>'.$starting_month.'</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';		
		
 $table.='</table>';


  return $table;
  $stmt1->close();
  $stmt->close();
}

function ReportRevenues($scorecard_id){
	$conn=dbconnect();
	$stmt=$conn->prepare("SELECT reporting_frequency FROM bsc_targets WHERE id=?");
	$stmt->bind_param('i',$measure_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($reporting_frequency);
	$stmt->fetch();
	if($reporting_frequency=='W'){
       $table='<table class="table table-bordered table-condensed dataTable js-exportable">
       <tr><th>Week</th><th>Value</th></tr>';

	    $stmt6= $conn->prepare("SELECT COUNT(*) FROM bsc_weekly WHERE target_id=?");
	    $stmt6->bind_param('i', $measure_id);
	    $stmt6->execute();
	    $stmt6->store_result();
	    $stmt6->bind_result($count);
	    $stmt6->fetch();
	    if($count<1){
          insertWeek_id($measure_id);
	    }
	     $stmt6->close();

		$stmt1=$conn->prepare("SELECT id, week, amount FROM bsc_weekly WHERE target_id=?");
		$stmt1->bind_param('i', $measure_id);
		$stmt1->execute();
		$stmt1->store_result();
		$stmt1->bind_result($week_id,$week,$amount);
		While($stmt1->fetch()){
			$table.='<tr><td><input type="week" name="week" value="'.$week.'" onfocusout="autosaveWeek(this.value,'.$measure_id.','.$week_id.')"></td><td><input type="number" name="amount" value="'.$amount.'" onfocusout="autosaveWeeklyAmount(this.value,'.$measure_id.','.$week_id.')"><i class="fa fa-trash-o" aria-hidden="true" onClick="deleteWeek('.$week_id.','.$measure_id.');"> </i></td></tr>';
		}
			$table.='</table>';
		$stmt1->close();
	}
	elseif($reporting_frequency=='M'){
		$table='<table class="table table-bordered table-condensed dataTable js-exportable">
		<tr><th>Month</th><th>Value</th></tr>';

		$stmt6= $conn->prepare("SELECT COUNT(*) FROM bsc_monthly WHERE target_id=?");
	    $stmt6->bind_param('i', $measure_id);
	    $stmt6->execute();
	    $stmt6->store_result();
	    $stmt6->bind_result($count);
	    $stmt6->fetch();
	    if($count<1){
          insertMonth_id($measure_id);
	    }
	     $stmt6->close();
		
		$stmt1=$conn->prepare("SELECT id, month, amount FROM bsc_monthly WHERE target_id=?");
		$stmt1->bind_param('i', $measure_id);
		$stmt1->execute();
		$stmt1->store_result();
		$stmt1->bind_result($month_id,$month,$amount);
		While($stmt1->fetch()){
			$table.='<tr><td><input type="month" name="month" value="'.$month.'" onfocusout="autosaveMonth(this.value,'.$measure_id.','.$month_id.')"></td><td><input type="number" min="1" name="amount" value="'.$amount.'" onfocusout="autosaveMonthlyAmount(this.value,'.$measure_id.','.$month_id.')"><i class="fa fa-trash-o" aria-hidden="true" onClick="deleteMonth('.$month_id.','.$measure_id.');"> </i></td></tr>';
		}
			$table.='</table>';
		$stmt1->close();
	}
		elseif($reporting_frequency=='Q'){
		$table='<table class="table table-bordered table-condensed dataTable js-exportable">
		<tr><th>Quarter</th><th>Value</th></tr>';
		
		$stmt6= $conn->prepare("SELECT COUNT(*) FROM bsc_quarterly WHERE target_id=?");
	    $stmt6->bind_param('i', $measure_id);
	    $stmt6->execute();
	    $stmt6->store_result();
	    $stmt6->bind_result($count);
	    $stmt6->fetch();
	    if($count<1){
          insertQuarter_id($measure_id);
	    }
	     $stmt6->close();

		$stmt1=$conn->prepare("SELECT id, quarter, amount FROM bsc_quarterly WHERE target_id=?");
		$stmt1->bind_param('i', $measure_id);
		$stmt1->execute();
		$stmt1->store_result();
		$stmt1->bind_result($quarter_id,$quarter,$amount);
		While($stmt1->fetch()){
			$table.='<tr><td><input type="number" name="quarter" min="1" max="4" value="'.$quarter.'"onfocusout="autosaveQuarter(this.value,'.$measure_id.','.$quarter_id.')"></td><td><input type="number" name="amount" value="'.$amount.'" onfocusout="autosaveQuarterlyAmount(this.value,'.$measure_id.','.$quarter_id.')"><i class="fa fa-trash-o" aria-hidden="true" onClick="deleteQuarter('.$quarter_id.','.$measure_id.');"> </i></td></tr>';
		}
			$table.='</table>';
		$stmt1->close();
	}
		elseif($reporting_frequency=='HY'){
		$table='<table class="table table-bordered table-condensed dataTable js-exportable">
		<tr><th>Half</th><th>Value</th></tr>';

		$stmt6= $conn->prepare("SELECT COUNT(*) FROM half_yearly WHERE target_id=?");
	    $stmt6->bind_param('i', $measure_id);
	    $stmt6->execute();
	    $stmt6->store_result();
	    $stmt6->bind_result($count);
	    $stmt6->fetch();
	    if($count<1){
          insertHalf_id($measure_id);
	    }
	     $stmt6->close();
		
		$stmt1=$conn->prepare("SELECT id, half, amount FROM bsc_half_yearly WHERE target_id=?");
		$stmt1->bind_param('i', $measure_id);
		$stmt1->execute();
		$stmt1->store_result();
		$stmt1->bind_result($half_id,$half,$amount);
		While($stmt1->fetch()){
			$table.='<tr><td><input type="number" name="half" min="1" max="2" value="'.$half.'" onfocusout="autosaveHalf(this.value,'.$measure_id.','.$half_id.')"></td><td><input type="number" name="amount"'.$amount.'" onfocusout="autosaveHalflyAmount(this.value,'.$measure_id.','.$half_id.')"><i class="fa fa-trash-o" aria-hidden="true" onClick="deleteHalf('.$half_id.','.$measure_id.');"> </i></td></tr>';
		}
			$table.='</table>';
		$stmt1->close();
	}
	else{
$table='<table><tr><td>zero zero</td></tr></table>';
	}
echo $table;
}


   function getDepartmentPerspectiveAVG($department_id,$perspective_id){

    $conn = dbconnect();
    $client_id=$_SESSION['client_id'];

    $stmt1 = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? AND department_id=?");
    $stmt1->bind_param('ii',$client_id,$department_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE client_id=? AND department_id=?");
    $stmt->bind_param('ii',$client_id,$department_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id);
    While($stmt->fetch()){
   $total+=getWR($scorecard_id,$perspective_id);
   
    }
    $stmt->close();
    $conn->close();
    if($count !=0){
    $average=$total/$count;
      
}else{
  $average=0;
}
 return $average;
  }

  function getFilteredDepartmentPerspectiveAVG($department_id,$perspective_id,$month){

    $conn = dbconnect();
    $client_id=$_SESSION['client_id'];

    $stmt1 = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? AND department_id=?");
    $stmt1->bind_param('ii',$client_id,$department_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE client_id=? AND department_id=?");
    $stmt->bind_param('ii',$client_id,$department_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id);
    While($stmt->fetch()){
   $total+=getFilteredWR($scorecard_id,$perspective_id,$month);
   
    }
    $stmt->close();
    $conn->close();
    if($count !=0){
    $average=$total/$count;
      
}else{
  $average=0;
}
 return $average;
  }

//    function getOtherDepartmentsWR($department_id,$perspective_id){

//     $conn = dbconnect();
//     $total=0;
//     $level_id=2;
//     $client_id=$_SESSION['client_id'];

//     $stmt1 = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? AND department_id !=? AND level_id=?");
//     $stmt1->bind_param('iii',$client_id,$department_id, $level_id);
//     $stmt1->execute();
//     $stmt1->store_result();
//     $stmt1->bind_result($count);
//     $stmt1->fetch();
//     $stmt1->close();

//     $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE client_id=? AND department_id !=? AND level_id=?");
//     $stmt->bind_param('iii',$client_id,$department_id, $level_id);
//     $stmt->execute();
//     $stmt->store_result();
//     $stmt->bind_result($scorecard_id);
//     While($stmt->fetch()){
//    $total+=getWR($scorecard_id,$perspective_id);
   
//     }
//     $stmt->close();
//     $conn->close();
//     if($count !=0){
//     $average=round($total/$count,2);
//       return $average;
// }else{
//   return "not available";
// }
 
//   }


     function getDepartmentalAVG($department_id){

    $conn = dbconnect();
    $total=0;
    $client_id=$_SESSION['client_id'];

    $stmt1 = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? AND department_id=?");
    $stmt1->bind_param('ii',$client_id,$department_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE client_id=? AND department_id=?");
    $stmt->bind_param('ii',$client_id,$department_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id);
    While($stmt->fetch()){
    $total+=getTotalWR($scorecard_id);
   
    }
    $stmt->close();
    $conn->close();
    if($count !=0){
    $average=$total/$count;
      return $average;
}else{
  return 0;
}
    }

     function getFilteredDepartmentalAVG($department_id,$month){

    $conn = dbconnect();
    $total=0;
    $client_id=$_SESSION['client_id'];

    $stmt1 = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? AND department_id=?");
    $stmt1->bind_param('ii',$client_id,$department_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE client_id=? AND department_id=?");
    $stmt->bind_param('ii',$client_id,$department_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id);
    While($stmt->fetch()){
    $total+=getFilteredTotalWR($scorecard_id,$month);
   
    }
    $stmt->close();
    $conn->close();
    if($count !=0){
    $average=$total/$count;
      return $average;
}else{
  return 0;
}
    }
    

//   function getOtherDepartmentsTotalWR($department_id){

//     $conn = dbconnect();
//     $total=0;
//     $level_id=2;
//     $client_id=$_SESSION['client_id'];

//     $stmt1 = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? AND department_id !=? AND level_id=?");
//     $stmt1->bind_param('iii',$client_id,$department_id, $level_id);
//     $stmt1->execute();
//     $stmt1->store_result();
//     $stmt1->bind_result($count);
//     $stmt1->fetch();
//     $stmt1->close();

//     $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE client_id=? AND department_id !=? AND level_id=?");
//     $stmt->bind_param('iii',$client_id,$department_id, $level_id);
//     $stmt->execute();
//     $stmt->store_result();
//     $stmt->bind_result($scorecard_id);
//     While($stmt->fetch()){
//    $total+=getTotalWR($scorecard_id);
   
//     }
//     $stmt->close();
//     $conn->close();
//     if($count !=0){
//     $average=round($total/$count,2);
//       return $average;
// }else{
//   return "not available";
// }
  

//   }

   function getCompanyPerspectiveAVG($perspective_id){

    $conn = dbconnect();
    $total=0;
    $client_id=$_SESSION['client_id'];

    $stmt1 = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=?");
    $stmt1->bind_param('i',$client_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE client_id=?");
    $stmt->bind_param('i',$client_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id);
    While($stmt->fetch()){
   $total+=getWR($scorecard_id,$perspective_id);
   
    }
    $stmt->close();
    $conn->close();
    if($count !=0){
    $average=$total/$count;
      return $average;
}else{
  return "not available";
}
}

 function getFilteredCompanyPerspectiveAVG($perspective_id,$month){

    $conn = dbconnect();
    $total=0;
    $client_id=$_SESSION['client_id'];

    $stmt1 = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=?");
    $stmt1->bind_param('i',$client_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE client_id=?");
    $stmt->bind_param('i',$client_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id);
    While($stmt->fetch()){
   $total+=getFilteredWR($scorecard_id,$perspective_id,$month);
   
    }
    $stmt->close();
    $conn->close();
    if($count !=0){
    $average=$total/$count;
      return $average;
}else{
  return "not available";
}
}
   function getCompanyAVG(){

    $conn = dbconnect();
    $total=0;
    $client_id=$_SESSION['client_id'];

    $stmt1 = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=?");
    $stmt1->bind_param('i',$client_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE client_id=?");
    $stmt->bind_param('i',$client_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id);
    While($stmt->fetch()){
   $total+=getTotalWR($scorecard_id);
   
    }
    $stmt->close();
    $conn->close();
    if($count !=0){
    $average=$total/$count;
      return $average;
}else{
  return "not available";
}
}

function getFilteredCompanyAVG($month){

    $conn = dbconnect();
    $total=0;
    $client_id=$_SESSION['client_id'];

    $stmt1 = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=?");
    $stmt1->bind_param('i',$client_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE client_id=?");
    $stmt->bind_param('i',$client_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id);
    While($stmt->fetch()){
   $total+=getFilteredTotalWR($scorecard_id,$month);
   
    }
    $stmt->close();
    $conn->close();
    if($count !=0){
    $average=$total/$count;
      return $average;
}else{
  return "not available";
}
}


// function getAssessment($scorecard_id){
//   $conn=dbconnect();
//   $department_id=getScoreCardDepartment($scorecard_id);

//   for($i=1; $i<5; $i++){
//     $variance= getWR($scorecard_id,$i)-getDepartmentWR($department_id,$i);
//     $variance2= getWR($scorecard_id,$i)-getCompanyWR($i);
//     $variance3=getTotalWR($scorecard_id)-getDepartmentalAVG($department_id);

//     if($variance<0){
//       $variance='<font color="red">'.$variance.'</font>';
//     }else{
//        $variance='<font color="green">'.$variance.'</font>'; 
//     }
//      if($variance2<0){
//       $variance2='<font color="red">'.$variance2.'</font>';
//     }else{
//        $variance2='<font color="green">'.$variance2.'</font>'; 
//     }
//     if($variance3<0){
//       $variance3='<font color="red">'.$variance3.'</font>';
//     }else{
//        $variance3='<font color="green">'.$variance3.'</font>'; 
//     }

//   echo'<tr><td>'.getPerspectiveName($i).'</td><td>'.getWR($scorecard_id,$i).'</td><td>'.$variance.'</td><td>'.getDepartmentWR($department_id,$i).'</td><td>'.$variance2.'</td><td>'.getCompanyWR($i).'</td></tr>';
// }
//  $variance4=getTotalWR($scorecard_id)- getCompanyTotalWR();
//    if($variance4<0){
//       $variance4='<font color="red">'.$variance4.'</font>';
//     }else{
//        $variance4='<font color="green">'.$variance4.'</font>'; 
//     }
// echo '<tr bgcolor="#C0C0C0"><td>Total</td><td>'.getTotalWR($scorecard_id).'</td><td>'.$variance3.'</td><td>'.getDepartmentalAVG($department_id).'</td><td>'.$variance4.'</td><td>'.getCompanyTotalWR().'</td></tr>';

// }

function getVarianceColor($variance){
  $conn=dbconnect();
      if($variance<0){
     return '<font color="red">'.$variance.'%</font>';
    }else{
     return '<font color="green">'.$variance.'%</font>'; 
    }

}


function getPeriodicalAssessment($scorecard_id){
    $conn=dbconnect();
    $department_id=getScoreCardDepartment($scorecard_id);
    //$i=0;
 $count = countClientPerspectives() +1;
$table;
//if(getScoreCardLevel($scorecard_id)==3){
 
       for($i=1; $i<$count; $i++){
    
    
    $variance3=getMonthlyTotalWR($scorecard_id)-getDepartmentalAVG($department_id);


   
    if(isset($_GET['month'])){
      $variance= getMonthlyWR($scorecard_id,$i)-getDepartmentWR($department_id,$i);
      $variance2= getMonthlyWR($scorecard_id,$i)-getCompanyWR($i);
$table.='<tr><td>'.getPerspectiveName($i).'</td><td>'.getMonthlyWR($scorecard_id,$i).'</td><td>'.getVarianceColor($variance).'</td><td>'.getDepartmentWR($department_id,$i).'</td><td>'.getVarianceColor($variance2).'</td><td>'.getCompanyWR($i).'</td></tr>';
       }

  elseif(isset($_GET['quarter'])){
    $variance= getQuarterlyWR($scorecard_id,$i)-getDepartmentWR($department_id,$i);
    $variance2= getQuarterlyWR($scorecard_id,$i)-getCompanyWR($i);
 $table.='<tr><td>'.getPerspectiveName($i).'</td><td>'.getQuarterlyWR($scorecard_id,$i).'</td><td>'.getVarianceColor($variance).'</td><td>'.getDepartmentWR($department_id,$i).'</td><td>'.getVarianceColor($variance2).'</td><td>'.getCompanyWR($i).'</td></tr>';
}

 elseif(isset($_GET['half'])){
 
  $variance= getHalfYearlyWR($scorecard_id,$i)-getDepartmentWR($department_id,$i);
  $variance2= getHalfYearlyWR($scorecard_id,$i)-getCompanyWR($i);
  $table.='<tr><td>'.getPerspectiveName($i).'</td><td>'.getHalfYearlyWR($scorecard_id,$i).'</td><td>'.getVarianceColor($variance).'</td><td>'.getDepartmentWR($department_id,$i).'</td><td>'.getVarianceColor($variance2).'</td><td>'.getCompanyWR($i).'</td></tr>';
}

elseif(isset($_GET['year'])){

  $variance= getYearlyWR($scorecard_id,$i)-getDepartmentWR($department_id,$i);
  $variance2= getYearlyWR($scorecard_id,$i)-getCompanyWR($i);
  $table.='<tr><td>'.getPerspectiveName($i).'</td><td>'.getYearlyWR($scorecard_id,$i).'</td><td>'.getVarianceColor($variance).'</td><td>'.getDepartmentWR($department_id,$i).'</td><td>'.getVarianceColor($variance2).'</td><td>'.getCompanyWR($i).'</td></tr>';
}else{
  $variance= getWR($scorecard_id,$i)-getDepartmentWR($department_id,$i);
  $variance2= getWR($scorecard_id,$i)-getCompanyWR($i);
  $table.='<tr><td>'.getPerspectiveName($i).'</td><td>'.getWR($scorecard_id,$i).'</td><td>'.getVarianceColor($variance).'</td><td>'.getDepartmentWR($department_id,$i).'</td><td>'.getVarianceColor($variance2).'</td><td>'.getCompanyWR($i).'</td></tr>';
}
       }
if(isset($_GET['month'])){

     $table.='<tr><td>Overall</td><td>'.getMonthlyTotalWR($scorecard_id).'</td><td></td><td></td><td></td><td></tr></tr>';
}
if(isset($_GET['quarterly'])){

     $table.='<tr><td>Overall</td><td>'.getQuarterlyTotalWR($scorecard_id).'</td><td></td><td></td><td></td><td></tr></tr>';
}
if(isset($_GET['half'])){

     $table.='<tr><td>Overall</td><td>'.getHalfYearlyTotalWR($scorecard_id).'</td><td></td><td></td><td></td><td></tr></tr>';
}
     
   /*    elseif(isset($_GET['quarter'])){
   for($i=1; $i<5; $i++){
    
 $table.='<tr><td>'.$i.'</td><td>'.getQuarterlyWR($scorecard_id,$i).'</td><td>'.getDepartmentWR($department_id,$i).'</td><td>'.getCompanyWR($i).'</td></tr>';
       }
 $table.='<tr><td>Overall</td><td>'.getQuarterlyTotalWR($scorecard_id).'</td><td>'.getDepartmentTotalWR ($department_id).'</td><td>'.getCompanyTotalWR().'</td></tr>';
       }

       elseif(isset($_GET['half'])){
         for($i=1; $i<5; $i++){
    
$table.='<tr><td>'.$i.'</td><td>'.getHalfYearlyWR($scorecard_id,$i).'</td><td>'.getDepartmentWR($department_id,$i).'</td><td>'.getCompanyWR($i).'</td></tr>';
       }
 $table.='<tr><td>Overall</td><td>'.getHalfYearlyTotalWR($scorecard_id).'</td><td>'.getDepartmentalAVG($department_id).'</td><td>'.getCompanyTotalWR().'</td></tr>';
     
       }

elseif(isset($_GET['year'])){
   for($i=1; $i<5; $i++){
    
$table.='<tr><td>'.$i.'</td><td>'.getYearlyWR($scorecard_id,$i).'</td><td>'.getDepartmentWR($department_id,$i).'</td><td>'.getCompanyWR($i).'</td></tr>';
       }
 $table.='<tr><td>Overall</td><td>'.getTotalWR($scorecard_id).'</td><td>'.getDepartmentalAVG($department_id).'</td><td>'.getCompanyTotalWR().'</td></tr>';

} 
else{
 $table.= getAssessment($scorecard_id);
} 
        
       }

        elseif(getScoreCardLevel($scorecard_id)==2){

     $table='<table class="table table-bordered table-condensed dataTable js-exportable">
       <tr><th>Perspective</th><th>Departmental Score (%)</th><th> Other Departments (%)</th><th>Company Average (%)</th></tr>
       <tr><td>Financial</td><td>'.getDepartmentWR($department_id,1).'</td><td>'.getOtherDepartmentsWR($department_id,1).'</td><td>'.getCompanyWR(1).'</td></tr>

       <tr><td>Customer</td><td>'.getDepartmentWR($department_id,2).'</td><td>'.getOtherDepartmentsWR($department_id,2).'</td><td>'.getCompanyWR(2).'</td></tr>
      
       <tr><td>Internal Business Processes </td><td>'.getDepartmentWR($department_id,3).'</td><td>'.getOtherDepartmentsWR($department_id,3).'</td><td>'.getCompanyWR(3).'</td></tr>

       <tr><td>Learning & growth</td><td>'.getDepartmentWR($department_id,4).'</td><td>'.getOtherDepartmentsWR($department_id,4).'</td><td>'.getCompanyWR(4).'</td></tr>

       <tr><td>Overall</td><td>'.getTotalWR($scorecard_id).'</td><td>'.getOtherDepartmentsTotalWR($department_id).'</td><td>'.getCompanyTotalWR().'</td></tr>
        </table>';
        }else{

        } */
        return $table;
}

function assessIndividual($scorecard_id){
    $conn=dbconnect();

  //$department_id=getScoreCardDepartment($scorecard_id); 

  $stmt=$conn->prepare("SELECT perspective_id FROM bsc_client_perspectives WHERE client_id=?");
  $stmt->bind_param('i',$_SESSION['client_id']);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($id);
  While($stmt->fetch()){

  $variance= getWR($scorecard_id,$id)-getDepartmentWR(14,$id);
  $variance2= getWR($scorecard_id,$id)-getCompanyWR($id);

echo'<tr>
    <td>'.getPerspectiveName($id).'</td>
    <td>'.getWR($scorecard_id,$id).'</td>
    <td>'.getVarianceColor($variance).'</td>
    <td>'.getDepartmentWR(14,$id).'</td>
    <td>'.getVarianceColor($variance2).'</td>
    <td>'.getCompanyWR($id).'</td>
    </tr>';
       }

  $stmt->close();
  $conn->close();
}





    //function to send notifications to people
    function notifyHR(){
        $conn = dbconnect();
        $date=date('d');

        if($date==15 OR $date==30){

        $stmt1 = $conn->prepare("SELECT client_id, email FROM bsc_client_credentials");
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($email);
        while($stmt1->fetch()){

        $stmt=$conn->prepare("SELECT id, client_id, owner, department_id, level_id FROM bsc_scorecards WHERE client_id=?");
        $stmt->bind_param('i', $client_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($scorecard_id,$client_id, $owner,$department_id,$level_id);
        While($stmt->fetch()){

            //send email
            $to = $email; 

            $headers = "From:  Industrial Psychology Consultants" . strip_tags('do_not_reply@ipcjobsportal.com') . "\r\n";
            $headers .= "Reply-To: ". strip_tags('do_not_reply@ipcjobsportal.com') . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            $subject = "RE: Scorecards Performance update";

            $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Industrial psychology consultants</title>
  <style type="text/css">

  img {
    max-width: 600px;
    outline: none;
    text-decoration: none;
    -ms-interpolation-mode: bicubic;
  }

  a {
    border: 0;
    outline: none;
  }

  a img {
    border: none;
  }

  /* General styling */

  td, h1, h2, h3  {
    font-family: Helvetica, Arial, sans-serif;
    font-weight: 400;
  }

  td {
    font-size: 13px;
    line-height: 19px;
    text-align: left;
  }

  body {
    -webkit-font-smoothing:antialiased;
    -webkit-text-size-adjust:none;
    width: 100%;
    height: 100%;
    color: #37302d;
    background: #ffffff;
  }

  table {
    border-collapse: collapse !important;
  }


  h1, h2, h3, h4 {
    padding: 0;
    margin: 0;
    color: #444444;
    font-weight: 400;
    line-height: 110%;
  }

  h1 {
    font-size: 35px;
  }

  h2 {
    font-size: 30px;
  }

  h3 {
    font-size: 24px;
  }

  h4 {
    font-size: 18px;
    font-weight: normal;
  }

  .important-font {
    color: #21BEB4;
    font-weight: bold;
  }

  .hide {
    display: none !important;
  }

  .force-full-width {
    width: 100% !important;
  }

  </style>

  <style type="text/css" media="screen">
      @media screen {
        @import url(http://fonts.googleapis.com/css?family=Open+Sans:400);

        /* Thanks Outlook 2013! */
        td, h1, h2, h3 {
          font-family: "Open Sans", "Helvetica Neue", Arial, sans-serif !important;
        }
      }
  </style>

  <style type="text/css" media="only screen and (max-width: 600px)">
    /* Mobile styles */
    @media only screen and (max-width: 600px) {

      table[class="w320"] {
        width: 320px !important;
      }

      table[class="w300"] {
        width: 300px !important;
      }

      table[class="w290"] {
        width: 290px !important;
      }

      td[class="w320"] {
        width: 320px !important;
      }

      td[class~="mobile-padding"] {
        padding-left: 14px !important;
        padding-right: 14px !important;
      }

      td[class*="mobile-padding-left"] {
        padding-left: 14px !important;
      }

      td[class*="mobile-padding-right"] {
        padding-right: 14px !important;
      }

      td[class*="mobile-padding-left-only"] {
        padding-left: 14px !important;
        padding-right: 0 !important;
      }

      td[class*="mobile-padding-right-only"] {
        padding-right: 14px !important;
        padding-left: 0 !important;
      }

      td[class*="mobile-block"] {
        display: block !important;
        width: 100% !important;
        text-align: left !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        padding-bottom: 15px !important;
      }

      td[class*="mobile-no-padding-bottom"] {
        padding-bottom: 0 !important;
      }

      td[class~="mobile-center"] {
        text-align: center !important;
      }

      table[class*="mobile-center-block"] {
        float: none !important;
        margin: 0 auto !important;
      }

      *[class*="mobile-hide"] {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
        line-height: 0 !important;
        font-size: 0 !important;
      }

      td[class*="mobile-border"] {
        border: 0 !important;
      }
    }
  </style>
</head>
<body class="body" style="padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none" bgcolor="#ffffff">
<table align="center" cellpadding="0" cellspacing="0" width="100%" height="100%">
  <tr>
    <td align="center" valign="top" bgcolor="#ffffff"  width="100%">

    <table cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td style="background:#ffffff" width="100%">

            <table cellspacing="0" cellpadding="0" width="600" class="w320">
              <tr>
                <td valign="top" class="mobile-block mobile-no-padding-bottom mobile-center" width="270" style="background:#ffffff;padding:10px 10px 10px 20px;">
                  <a href="#" style="text-decoration:none;">
                    <img src="https://www.ipcjobsportal.com/images/logo.jpg" width="135" height="80" alt="Our Logo"/>
                  </a>
                </td>
                <td valign="top" class="mobile-block mobile-center" width="270" style="background:#ffffff;padding:10px 15px 10px 10px">
                  <table border="0" cellpadding="0" cellspacing="0" class="mobile-center-block" align="right">
                    <tr>
                      <td align="center">
                        <a href="https://www.facebook.com/IPCConsultants"/>
                        <img src="http://www.ipcjobsportal.com/images/social_facebook.png"  width="30" height="30" alt="social icon"/>
                        </a>
                      </td>
                      <td align="center" style="padding-left:5px">
                        <a href="https://twitter.com/ipcconsultants">
                        <img src="http://www.ipcjobsportal.com/images/social_twitter.png"  width="30" height="30" alt="social icon"/>
                        </a>
                      </td>
                      <td align="center" style="padding-left:5px">
                        <a href="https://www.linkedin.com/company/industrial-psychology-consultants-pvt-ltd/">
                        <img src="http://www.ipcjobsportal.com/images/social_linkedin.png"  width="30" height="30" alt="social icon"/>
                        </a>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>

        </td>
      </tr>
      <tr>
        <td style="border-bottom:1px solid #e7e7e7;">

        
            <table cellpadding="0" cellspacing="0" width="600" class="w320">
              <tr>
                <td align="left" class="mobile-padding" style="padding:20px 20px 0">

                  <table cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                      <td style="padding-top:8px;padding-bottom:10px">
                        <h4>Good day "'.getClientName($client_id).'" Executive</h4>
                      </td>
                    </tr>
                  </table>

                  <div class="textdark">
                   <p> Below is "'.getOwner($scorecard_id).'" \'s Year to date Performance </p>
                   <p>Financial Perspective: "'.getWR($scorecard_id,1).'" </p>
                   <p>Customer Perspective: "'.getWR($scorecard_id,2).'" </p>
                   <p>Internal Business Processes: "'.getWR($scorecard_id,3).'" </p>
                   <p>Learning and growth: "'.getWR($scorecard_id,4).'" </p>
                   <p>Overal Score: "'.getTotalWR($scorecard_id).'"</p>
                  </div>
                  <br>
                  <hr>
                  <div>
                  </div>
                  <br>
                  <hr>
                 <div class="row">
                  <div class="textdark">
                    Regards
                  </div>
                  <hr>
                  <h4><b>Admin</b></h4>
                  <br><br>
              </tr>
            </table>
       

        </td>
      </tr>
      <tr>
        <td style="background-color:#ffffff;">
       
            <table border="0" cellpadding="0" cellspacing="0" width="600" class="w320" style="height:100%;color:#ffffff" bgcolor="#ffffff" >
              <tr>
                <td align="right" valign="middle" class="mobile-padding" style="font-size:12px;padding:20px; background-color:#175ae8; color:#ffffff; text-align:left; ">
                  <a style="color:#ffffff;"  href="http://ipcconsultants.com/contact/">Contact Us</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                  <a style="color:#ffffff;" href="https://www.facebook.com/IPCConsultants/">Facebook</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                  <a style="color:#ffffff;" href="https://twitter.com/ipcconsultants">Twitter</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                  <a style="color:#ffffff;" href="https://www.linkedin.com/company/industrial-psychology-consultants-pvt-ltd/">LinkedIn</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                </td>
              </tr>
            </table>
      
        </td>
      </tr>
    </table>

    </td>
  </tr>
</table>
</body>
</html>';
                        

            mail($to, $subject, $message, $headers);
            }
        }
        }
        $stmt->close();
        $stmt1->close();

        $conn->close();

    }
function compareScores(){
  $conn=dbconnect();
  $table='<table class="table table-bordered table-condensed dataTable js-exportable">
  <thead><tr><th>Owner</th><th>Department</th><th>Financial</th><th>Customer</th><th>Internal B P</th><th>Learning & Gowth</th><th>Overal Score</th><th>Action</th></tr></thead><tbody>';
  $stmt=$conn->prepare("SELECT id, owner, department_id FROM bsc_scorecards WHERE level_id=? AND client_id=?");
  $stmt->bind_param('ii',$level_id,$client_id);
  $level_id=3;
  $client_id=test_input($_SESSION['client_id']);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($scorecard_id,$owner, $department_id);
  While($stmt->fetch()){
  $table.='<tr><td>'.getEmployeeName($owner).'</td><td>'.getDepartmentName($department_id).'</td><td>'.getWR($scorecard_id,1).'%</td><td>'.getWR($scorecard_id,2).'%</td><td>'.getWR($scorecard_id,3).'%</td><td>'.getWR($scorecard_id,4).'%</td><td>'.getTotalWR($scorecard_id).'%</td><td><a href="scorecard/'.$scorecard_id.'"> <button type="button" class="btn btn-info"><i class="fa fa-desktop"></i> View Scorecard</button></a> <a href="assessments/'.$scorecard_id.'"><button type="button" class="btn btn-info"><i class="fa fa-check"></i> Assess Performance</button></a></td></tr>';
  }

  $table.='</tbody></table>';
  echo $table;

}

function compareMonthlyScores(){
  $conn=dbconnect();
  $table='<table class="table table-bordered table-condensed dataTable js-exportable">
  <thead><tr><th>Owner</th><th>Department</th><th>Financial</th><th>Customer</th><th>Internal B P</th><th>Learning & Gowth</th><th>Overal Score</th><th>Action</th></tr></thead><tbody>';
  $stmt=$conn->prepare("SELECT id, owner, department_id FROM bsc_scorecards WHERE level_id=? AND client_id=?");
  $stmt->bind_param('ii',$level_id,$client_id);
  $level_id=3;
  $client_id=test_input($_SESSION['client_id']);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($scorecard_id,$owner, $department_id);
  While($stmt->fetch()){
  $table.='<tr><td>'.getEmployeeName($owner).'</td><td>'.getDepartmentName($department_id).'</td><td>'.getMonthlyWR($scorecard_id,1).'%</td><td>'.getMonthlyWR($scorecard_id,2).'%</td><td>'.getMonthlyWR($scorecard_id,3).'%</td><td>'.getMonthlyWR($scorecard_id,4).'%</td><td>'.getMonthlyTotalWR($scorecard_id).'%</td><td><a href="scorecard/'.$scorecard_id.'"><button type="button" class="btn btn-info"><i class="fa fa-desktop"></i> View Scorecard</button></a> <a href="assessments/'.$scorecard_id.'"><button type="button" class="btn btn-info"><i class="fa fa-check"></i> Assess Performance</button></a></td></tr>';
  }

  $table.='</tbody></table>';
  echo $table;

}
function compareHalfYearlyScores(){
  $conn=dbconnect();
  $table='<table class="table table-bordered table-condensed dataTable js-exportable">
  <thead><tr><th>Owner</th><th>Department</th><th>Financial</th><th>Customer</th><th>Internal B P</th><th>Learning & Gowth</th><th>Overal Score</th><th>Action</th></tr></thead><tbody>';
  $stmt=$conn->prepare("SELECT id, owner, department_id FROM bsc_scorecards WHERE level_id=? AND client_id=?");
  $stmt->bind_param('ii',$level_id,$client_id);
  $level_id=3;
  $client_id=test_input($_SESSION['client_id']);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($scorecard_id,$owner, $department_id);
  While($stmt->fetch()){
  $table.='<tr><td>'.getEmployeeName($owner).'</td><td>'.getDepartmentName($department_id).'</td><td>'.getHalfYearlyWR($scorecard_id,1).'%</td><td>'.getHalfYearlyWR($scorecard_id,2).'%</td><td>'.getHalfYearlyWR($scorecard_id,3).'%</td><td>'.getHalfYearlyWR($scorecard_id,4).'%</td><td>'.getHalfYearlyTotalWR($scorecard_id).'%</td><td><a href="scorecard/'.$scorecard_id.'"><button type="button" class="btn btn-info"><i class="fa fa-desktop"></i> View Scorecard</button></a> <a href="assessments/'.$scorecard_id.'"><button type="button" class="btn btn-info"><i class="fa fa-check"></i> Assess Performance</button></a></td></tr>';
  }

  $table.='</tbody></table>';
  echo $table;
}

function compareYearlyScores(){
  $conn=dbconnect();
  $year=$_GET['year'];
  $table='<table class="table table-bordered table-condensed dataTable js-exportable">
  <thead><tr><th>Owner</th><th>Department</th><th>Financial</th><th>Customer</th><th>Internal B P</th><th>Learning & Gowth</th><th>Overal Score</th><th>Action</th></tr></thead><tbody>';
  $stmt=$conn->prepare("SELECT id, owner, department_id FROM bsc_scorecards WHERE level_id=? AND client_id=? AND SUBSTR(reporting_period,1,4)=?");
  $stmt->bind_param('iis',$level_id,$client_id,$year);
  $level_id=3;
  $client_id=test_input($_SESSION['client_id']);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($scorecard_id,$owner, $department_id);
  While($stmt->fetch()){
  $table.='<tr><td>'.getEmployeeName($owner).'</td><td>'.getDepartmentName($department_id).'</td><td>'.getWR($scorecard_id,1).'%</td><td>'.getWR($scorecard_id,2).'%</td><td>'.getWR($scorecard_id,3).'%</td><td>'.getWR($scorecard_id,4).'%</td><td>'.getTotalWR($scorecard_id).'%</td><td><a href="scorecard/'.$scorecard_id.'"><button type="button" class="btn btn-info"><i class="fa fa-desktop"></i> View Scorecard</button></a> <a href="assessments/'.$scorecard_id.'"><button type="button" class="btn btn-info"><i class="fa fa-check"></i> Assess Performance</button></a></td></tr>';
  }

  $table.='</tbody></table>';
  echo $table;
}

function compareQuarterlyScores(){
  $conn=dbconnect();
  $table='<table class="table table-bordered table-condensed dataTable js-exportable">
  <thead><tr><th>Owner</th><th>Department</th><th>Financial</th><th>Customer</th><th>Internal B P</th><th>Learning & Gowth</th><th>Overal Score</th><th>Action</th></tr></thead><tbody>';
  $stmt=$conn->prepare("SELECT id, owner, department_id FROM bsc_scorecards WHERE level_id=? AND client_id=?");
  $stmt->bind_param('ii',$level_id,$client_id);
  $level_id=3;
  $client_id=test_input($_SESSION['client_id']);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($scorecard_id,$owner, $department_id);
  While($stmt->fetch()){
  $table.='<tr><td>'.getEmployeeName($owner).'</td><td>'.getDepartmentName($department_id).'</td><td>'.getQuarterlyWR($scorecard_id,1).'%</td><td>'.getQuarterlyWR($scorecard_id,2).'%</td><td>'.getQuarterlyWR($scorecard_id,3).'%</td><td>'.getQuarterlyWR($scorecard_id,4).'%</td><td>'.getQuarterlyTotalWR($scorecard_id).'%</td><td><a href="scorecard/'.$scorecard_id.'"><button type="button" class="btn btn-info"><i class="fa fa-desktop"></i> View Scorecard</button></a> <a href="assessments/'.$scorecard_id.'"><button type="button" class="btn btn-info"><i class="fa fa-check"></i> Assess Performance</button></a></td></tr>';
  }

  $table.='</tbody></table>';
  echo $table;
}

function selectMonths(){
  $conn=dbconnect();
  $stmt=$conn->prepare("SELECT DISTINCT(month) FROM bsc_monthly LEFT JOIN bsc_targets ON target_id=bsc_targets.id LEFT JOIN bsc_goals ON goal_id=bsc_goals.id LEFT JOIN bsc_scorecards ON scorecard_id=bsc_scorecards.id WHERE client_id=? AND month !=?");
  $stmt->bind_param('is',$client_id,$null);
  $client_id=test_input($_SESSION['client_id']);
  $null='';
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($month);
  While($stmt->fetch()){
    echo'<option>'.$month.'</option>';
  }
}
function selectQuarter(){
  $conn=dbconnect();
  $stmt=$conn->prepare("SELECT DISTINCT(quarter) FROM bsc_quarterly LEFT JOIN bsc_targets ON target_id=bsc_targets.id LEFT JOIN bsc_goals ON goal_id=bsc_goals.id LEFT JOIN bsc_scorecards ON scorecard_id=bsc_scorecards.id WHERE client_id=? AND quarter!=?");
  $stmt->bind_param('is',$client_id,$null);
  $client_id=test_input($_SESSION['client_id']);
  $null='';
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($quarter);
  While($stmt->fetch()){
    echo'<option>'.$quarter.'</option>';
  }
}
function selectHalf(){
  $conn=dbconnect();
  $stmt=$conn->prepare("SELECT DISTINCT(half) FROM bsc_half_yearly LEFT JOIN bsc_targets ON target_id=bsc_targets.id LEFT JOIN bsc_goals ON goal_id=bsc_goals.id LEFT JOIN bsc_scorecards ON scorecard_id=bsc_scorecards.id WHERE client_id=? AND half!=?");
  $stmt->bind_param('is',$client_id,$null);
  $client_id=test_input($_SESSION['client_id']);
  $null='';
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($half);
  While($stmt->fetch()){
    echo'<option>'.$half.'</option>';
  }
}

function selectYear(){
    for($year='2010'; $year<=date('Y'); $year++){
   echo'<option>'.$year.'</option>'; 
    }

}

function getSupporters($company_goal){
  $conn=dbconnect();

                 $table='<table class="table table-bordered table-condensed dataTable js-exportable">
                      <tr><th colspan="2">Supporter</th><th>Goal</th><th>Weighted Rating</th><td>Action</td></tr>';

                  $stmt12=$conn->prepare("SELECT DISTINCT(department_id) FROM bsc_goals LEFT JOIN bsc_scorecards ON bsc_scorecards.id=scorecard_id WHERE company_goal=?");
                  $stmt12->bind_param('i',$company_goal);
                  $stmt12->execute();
                  $stmt12->store_result();
                  $stmt12->bind_result($department_id);
                  While($stmt12->fetch()){
   
                 $stmt13=$conn->prepare("SELECT COUNT(goals.id) FROM bsc_goals LEFT JOIN bsc_scorecards ON bsc_scorecards.id=scorecard_id WHERE company_goal=? AND department_id=?");
                  $stmt13->bind_param('ii',$id,$department_id);
                  $stmt13->execute();
                  $stmt13->store_result();
                  $stmt13->bind_result($count_goals);
                  While($stmt13->fetch()){

                $table.='<tr><td rowspan="'.$count_goals.'">'.getDepartmentName($department_id).'</td>';

                  $stmt14=$conn->prepare("SELECT goals.id,scorecard_id, perspective_id FROM bsc_goals LEFT JOIN bsc_scorecards ON bsc_scorecards.id=scorecard_id WHERE company_goal=? AND department_id=?");
                  $stmt14->bind_param('ii',$company_goal,$department_id);
                  $stmt14->execute();
                  $stmt14->store_result();
                  $stmt14->bind_result($goal_id,$scorecard_id,$perspective_id);
                  While($stmt14->fetch()){
          $table.='<td>'.getOwner($scorecard_id).'</td><td>'.getgoalName($goal_id).'</td><td>'.round(getWR($scorecard_id,$perspective_id),2).'%</td><td><a href="scorecard/'.$scorecard_id.'">Visit SC</a></td></tr>';
                  }
                  $stmt14->close();
                }
               $stmt13->close();
           }
$table.='</table>';
echo $table;
$stmt12->close();

$conn->close();
}

function getChwachwa(){
  $conn=dbconnect();

  $stmt=$conn->prepare("SELECT id, owner FROM bsc_scorecards WHERE level_id=? AND client_id=?");
  $stmt->bind_param('ii',$level_id,$_SESSION['client_id']);
  $level_id=4;
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($scorecard_id,$owner);
  While($stmt->fetch()){

echo "<option value='".$scorecard_id."'>".getOwner($scorecard_id)."</option>";
 
}

}

function getScores(){
  $conn=dbconnect();
  $table='<table class="table table-striped table-bordered table-hover dataTables-example">
          <thead>
          <tr>
          <th>Owner</th>
          <th>Department</th>
          <th>Financial</th>
          <th>Customer</th>
          <th>Internal B P</th>
          <th>Learning & Gowth</th>
          <th>Overal Score</th>
          <th>Action</th>
          </tr>
          </thead><tbody>';
if(countBusinessUnits()>0){
if($_SESSION['account_type']==1){
  $stmt=$conn->prepare("SELECT id, owner, department_id FROM bsc_scorecards WHERE level_id=? AND client_id=?");
  $stmt->bind_param('ii',$level_id,$_SESSION['client_id']);
} elseif($_SESSION['account_type']==2){
   $stmt=$conn->prepare("SELECT id, owner, department_id FROM bsc_scorecards WHERE level_id=? AND client_id=? AND business_unit=?");
  $stmt->bind_param('iii',$level_id,$_SESSION['client_id'],$_SESSION['business_unit']); 
}
 elseif($_SESSION['account_type']==3){
   $stmt=$conn->prepare("SELECT id, owner, department_id FROM bsc_scorecards WHERE level_id=? AND client_id=? AND business_unit=? AND department_id=?");
  $stmt->bind_param('iiii',$level_id,$_SESSION['client_id'],$_SESSION['business_unit'],$_SESSION['department_id']); 
} else{
   $stmt=$conn->prepare("SELECT id, owner, department_id FROM bsc_scorecards WHERE owner=?");
  $stmt->bind_param('i',$_SESSION['user_id']); 
}
}else{

if($_SESSION['account_type']==1){
  $stmt=$conn->prepare("SELECT id, owner, department_id FROM bsc_scorecards WHERE level_id=? AND client_id=?");
  $stmt->bind_param('ii',$level_id,$_SESSION['client_id']);
} 
 elseif($_SESSION['account_type']==3){
   $stmt=$conn->prepare("SELECT id, owner, department_id FROM bsc_scorecards WHERE level_id=? AND client_id=? AND department_id=?");
  $stmt->bind_param('iii',$level_id,$_SESSION['client_id'],$_SESSION['department_id']); 
} else{
   $stmt=$conn->prepare("SELECT id, owner, department_id FROM bsc_scorecards WHERE owner=?");
  $stmt->bind_param('i',$_SESSION['user_id']); 
}
}
  $level_id=4;
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($scorecard_id,$owner, $department_id);
  While($stmt->fetch()){
  $table.='<tr>
           <td>'.getEmployeeName($owner).'</td>
           <td>'.getDepartmentName($department_id).'</td>
           <td>'.getWR($scorecard_id,1).'%</td>
           <td>'.getWR($scorecard_id,2).'%</td>
           <td>'.getWR($scorecard_id,3).'%</td>
           <td>'.getWR($scorecard_id,4).'%</td>
           <td>'.getTotalWR($scorecard_id).'%</td>
           <td>        <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Options</button>
        <ul class="dropdown-menu">
        <li><a href="assessments/'.$scorecard_id.'"><button type="button" class="btn btn-outline-primary"><i class="fa fa-check"></i> Assess</button></a></li>
                     
        <li><a href="scorecard/'.$scorecard_id.'"><button type="button" class="btn btn-outline-primary"><i class="fa fa-search"></i> View </button></a> </li>
        <li><a href="downloads/sid='.$scorecard_id.'" class="btn btn-sm btn-success"><i class="fa fa-download"></i>Download Report</a></li>
                       
        </ul>
        </div></td>
        </tr>';
  }

  $table.='</tbody></table>';
  echo $table;

}

function getPWR($scorecard_id,$perspective_id, $start_date,$end_date){
  $conn=dbconnect();
      $total=0;
      $stmt1 = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE perspective_id=? AND scorecard_id=?");
    $stmt1->bind_param('ii',$perspective_id,$scorecard_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($measure_id);
    While($stmt1->fetch()){
        $total+=getPeriodicalWeightedRating($measure_id, $start_date, $end_date); 
      }
       $stmt1->close();
    return $total;
}

     function getPeriodicalWR($scorecard_id, $start_date, $end_date){

    $conn = dbconnect();
   
  //$variance= getPWR($scorecard_id,$perspective_id, $start_date,$end_date)-getPWR($scorecard_id,$perspective_id, $start_date,$end_date);
  //$variance2= getPWR($scorecard_id,$perspective_id, $start_date,$end_date)-getPWR($scorecard_id,$perspective_id, $start_date,$end_date);

echo'<tr>
    <td>'.getOwner($scorecard_id).'</td>
    <td>'.getPWR($scorecard_id,1, $start_date,$end_date).'</td>
    <td>'.getPWR($scorecard_id,2, $start_date,$end_date).'</td>
    <td>'.getPWR($scorecard_id,3, $start_date,$end_date).'</td>
    <td>'.getPWR($scorecard_id,4, $start_date,$end_date).'</td>
    <td>'.getPWR($scorecard_id,4, $start_date,$end_date).'</td>
    <td> <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Options</button>
        <ul class="dropdown-menu">
        <li><a href="scorecard/'.$scorecard_id.'"><button type="button" class="btn btn-outline-primary"><i class="fa fa-desktop"></i> View</button></a></li>
                     
        <li><a href="assessments/'.$scorecard_id.'"><button type="button" class="btn btn-outline-primary"><i class="fa fa-search"></i> Assess</button></a> </li>
                       
        </ul>
        </div></td>
    </tr>';


  $conn->close();
}

     function getPeriodicalWeightedRating($measure_id, $start_date, $end_date){
  // error_reporting(0);
  $conn=dbconnect();

    $stmt = $conn->prepare("SELECT base_target, stretch_target, allocated_weight FROM bsc_targets WHERE id=?");
    $stmt->bind_param('i',$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($base_target, $stretch_target,$allocated_weight);
   While($stmt->fetch()){
    if(sumPeriodically1($measure_id, $start_date, $end_date)=='' ){
  $weighted_rating='';
    }
    elseif($stretch_target==$base_target){
       $weighted_rating="0"; 
    }
    else{
    $weighted_rating=((sumPeriodically1($measure_id, $start_date, $end_date)-$base_target)/($stretch_target-$base_target))*$allocated_weight;
    if($weighted_rating>$allocated_weight){
      $weighted_rating=$allocated_weight;
    }
    elseif($weighted_rating<-$allocated_weight){
      $weighted_rating=-$allocated_weight;
    }
    else{

    }
  }
}
    $stmt->close();
    $conn->close();

  return $weighted_rating;
    }
     

    function sumPeriodically($measure_id){
    $conn = dbconnect();
    $start_date=test_input($_GET['start_date']);
    $end_date=test_input($_GET['end_date']);

     $stmt = $conn->prepare("SELECT SUM(amount) AS sum FROM bsc_half_yearly WHERE target_id=? AND half>=? AND half<=?");
    $stmt->bind_param('iss',$measure_id,$s_date,$e_date);
    $s_date=substr($start_date,0,7);
    $e_date=substr($end_date,0,7);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($sum1);
    $stmt->fetch();
    $stmt->close();

     $stmt = $conn->prepare("SELECT SUM(amount) AS sum FROM bsc_quarterly WHERE target_id=? AND quarter>=? AND quarter<=?");
    $stmt->bind_param('is',$measure_id,$s_date,$e_date);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($sum2);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT SUM(amount) AS sum FROM bsc_monthly WHERE target_id=? AND month>=? AND month<=?");
    $stmt->bind_param('iss',$measure_id,$s_date,$e_date);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($sum3);
    $stmt->fetch();
    $stmt->close();
 
    $stmt = $conn->prepare("SELECT SUM(amount) AS sum FROM bsc_weekly WHERE target_id=? AND week>=? AND week<=?");
    $stmt->bind_param('iss',$measure_id,$start_week,$end_week); 
    $day = date('N', strtotime($date));
    $start_week = date('Y-m-d', strtotime('-'.($day-1).' days', strtotime($start_date)));
    $end_week = date('Y-m-d', strtotime('+'.(7-$day).' days', strtotime($end_date)));
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($sum4);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
   return $sum1+$sum2+$sum3+$sum4;  

   }

    function sumPeriodically1($measure_id, $start_date, $end_date){
    $conn = dbconnect();
   $start_year= date("Y", strtotime($start_date)); 
   $start_week=date("W", strtotime($start_date));
   $s_week=$start_year.'-W'.$start_week;

   $end_year= date("Y", strtotime($end_date)); 
   $end_week=date("W", strtotime($end_date));
   $e_week=$end_year.'-W'.$end_week;

    /*if($interval->format('%a')<364){
    $stmt = $conn->prepare("SELECT reporting_frequency, actual FROM bsc_targets WHERE id=?");
    $stmt->bind_param('iss',$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($reporting_frequency,$actual);
    $stmt->fetch();
    $stmt->close();
  }
    if($reporting_frequency=='Y'){
    $sum0=$actual;
    }
   else{
    $sum0=0;
     } */

    $stmt = $conn->prepare("SELECT SUM(amount) AS sum FROM bsc_half_yearly WHERE target_id=? AND half>=? AND half<=?");
    $stmt->bind_param('iss',$measure_id,$s_date,$e_date);
    $s_date=substr($start_date,0,7);
    $e_date=substr($end_date,0,7);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($sum1);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT SUM(amount) AS sum FROM bsc_quarterly WHERE target_id=? AND quarter>=? AND quarter<=?");
    $stmt->bind_param('iss',$measure_id,$s_date,$e_date);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($sum2);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT SUM(amount) AS sum FROM bsc_monthly WHERE target_id=? AND month>=? AND month<=?");
    $stmt->bind_param('iss',$measure_id,$s_date,$e_date);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($sum3);
    $stmt->fetch();
    $stmt->close();


   $stmt1 = $conn->prepare("SELECT SUM(amount) AS sum FROM bsc_weekly WHERE target_id=? AND week>=? AND week<=?");
    $stmt1->bind_param('iss',$measure_id,$s_week,$e_week); 
   /* $day = date('N', strtotime($date));
    $start_week = date('Y-m-d', strtotime('-'.($day-1).' days', strtotime($start_date)));
    $end_week = date('Y-m-d', strtotime('+'.(7-$day).' days', strtotime($end_date))); */
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($sum4);
    $stmt1->fetch();
    $stmt1->close();
    $conn->close();
 
   return $sum1+$sum2+$sum3+$sum4;  

   }

 /*  function getOrganogram($company_goal){

 $conn=dbconnect();
                  
                  $stmt1=$conn->prepare("SELECT id, scorecard_id, perspective_id, goal FROM goals WHERE id=? ");
                  $stmt1->bind_param('i',$company_goal);
                  $stmt1->execute();
                  $stmt1->store_result();
                  $stmt1->bind_result($id,$scorecard_id,$perspective_id,$cgoal);
                  While($stmt1->fetch()){ ?>
                    { id: "<?php echo $id; ?>", parentId: null,  scorecard_id: "<?php echo getOwner($scorecard_id); echo "("; echo getWR($scorecard_id,$perspective_id); echo "%)"; ?>", name: "<?php echo $cgoal; ?>", image: "orgchart/demo/images/f-10.jpg" },
               <?php   }
                  $stmt14=$conn->prepare("SELECT id, scorecard_id, perspective_id, goal FROM goals WHERE company_goal=? ");
                  $stmt14->bind_param('i',$company_goal);
                  $stmt14->execute();
                  $stmt14->store_result();
                  $stmt14->bind_result($id,$scorecard_id, $perspective_id,$goal);
                  While($stmt14->fetch()){  ?>

                { id: "<?php echo $id; ?>", parentId: "<?php echo $company_goal; ?>",  scorecard_id: "<?php echo getOwner($scorecard_id); echo "("; echo getWR($scorecard_id,$perspective_id); echo "%)"; ?>", name: "<?php echo $goal; ?>", image: "orgchart/demo/images/f-10.jpg" },

<?php } }

function testchart(){ 
echo '<i class="fa fa-plus-circle" aria-hidden="true" style="color:#175ae8;" data-toggle="modal" data-target="#people">goal</i>';

              echo '<!-- Modal -->
          <div class="modal fade" id="people" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Add Comments </h4>
                </div>
                <div class="modal-body">'; ?>
                 <div id="people"></div>
                 <script type="text/javascript">
        var peopleElement = document.getElementById("people");
        var orgChart = new getOrgChart(peopleElement, {
            primaryFields: ["id","parentId","name", "salary"],
            photoFields: ["image"],
            theme: "helen",
            enableExportToImage: true,
            enableDetailsView: true,
            enableEdit: true,

            dataSource: [

    <?php    $conn=dbconnect();
      $stmt=$conn->prepare("SELECT id, parent_id, name, salary, image FROM chart");
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($id,$parent_id, $name,$salary,$image);
      While($stmt->fetch()){  ?>
                { id: "<?php echo $id; ?>", parentId: "<?php echo $parent_id; ?>", name: "<?php echo $name.' '.'$'.$salary; ?>", image: "<?php echo $image; ?>" },
           <?php } ?> ]
        });
    </script>
      <?php echo'</div>
                </div>
              
            </div>
          </div>';
   
} */
function getOrganogram($scorecard_id,$company_goal){ ?>

      <script>
    
window.onload = function () { 
    var chart = new OrgChart(document.getElementById("tree<?php echo $company_goal; ?>"), {
        toolbar: true,
        menu: {
            pdf: { text: "Export PDF" },
            png: { text: "Export PNG" },
            svg: { text: "Export SVG" },
            csv: { text: "Export CSV" }
        },

        nodeBinding: {
            field_0: "name",
            field_1: "title",
            field_2: "email",
            field_3: "phone",
            field_number_children: "field_number_children"
        },
        nodes: [

    { id: "<?php echo $company_goal; ?>", pid: "", name: "<?php echo getOwner($scorecard_id); ?>", title: "", img: "",email:"<?php echo $company_goal; ?>" }, 

 <?php 
    $conn=dbconnect();

    $stmt14=$conn->prepare("SELECT goals.id,scorecard_id, perspective_id FROM bsc_goals LEFT JOIN bsc_scorecards ON scorecards.id=scorecard_id WHERE company_goal=?");
    $stmt14->bind_param('i',$company_goal);
    $stmt14->execute();
    $stmt14->store_result();
    $stmt14->bind_result($goal_id,$scorecard_id,$perspective_id);
    While($stmt14->fetch()){ ?>
 { id: "<?php echo $goal_id; ?>", pid: "<?php echo $company_goal; ?>", name: "<?php echo     getDepartmentName(getScoreCardDepartment($scorecard_id)); ?>", title: "<?php echo getWR($scorecard_id,$perspective_id); echo "%"; ?>", img: " ", $phone: "<?php echo getgoalName($goal_id); ?>" }, 
     <?php   }

    $stmt14=$conn->prepare("SELECT goals.id,scorecard_id, perspective_id FROM bsc_goals LEFT JOIN bsc_scorecards ON bsc_scorecards.id=scorecard_id WHERE company_goal=?");
    $stmt14->bind_param('i',$goal_id);
    $stmt14->execute();
    $stmt14->store_result();
    $stmt14->bind_result($g_id,$scorecard_id,$perspective_id);
    While($stmt14->fetch()){ ?>
 { id: "<?php echo $g_id; ?>", pid: "<?php echo $goal_id; ?>", name: "<?php echo getOwner($scorecard_id); ?>", title: "<?php echo getWR($scorecard_id,$perspective_id); echo "%"; ?>", img: " ", phone:"<?php echo getgoalName($g_id); ?>" }, 
     <?php   }



      ?>
          ]
    });
};

    </script>    <?php 
echo'<div id="tree'.$company_goal.'"></div>'; 

    
     } 

function getActualTooltip($measure_id){
	$conn=dbconnect();
    if(getReportingFrequency($measure_id)=='Y'){
    $stmt = $conn->prepare("SELECT actual FROM bsc_targets WHERE id=?");
    $stmt->bind_param('i',$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();
    $stmt->close();
     $tooltip=$amount;

    }elseif(getReportingFrequency($measure_id)=='HY'){ 
    $stmt = $conn->prepare("SELECT MAX(half) FROM bsc_half_yearly WHERE target_id=? AND half!=?");
    $stmt->bind_param('is',$measure_id,$halflength);
    $halflength='';
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($half);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT amount FROM bsc_half_yearly WHERE half=? AND target_id=?");
    $stmt->bind_param('si',$half,$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();
    $tooltip=$half.' '.$amount;
    $stmt->close();

    }elseif(getReportingFrequency($measure_id)=='Q'){
    $stmt = $conn->prepare("SELECT MAX(quarter) FROM bsc_quarterly WHERE target_id=? AND quarter!=?");
    $stmt->bind_param('is',$measure_id,$quarterlength);
    $quarterlength='';
    $stmt->execute(); 
    $stmt->store_result();
    $stmt->bind_result($quarter);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT amount FROM bsc_quarterly WHERE quarter=? AND target_id=?");
    $stmt->bind_param('si',$quarter,$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();
    $tooltip=$quarter.' ('.$amount.')';
    $stmt->close(); 

  } elseif(getReportingFrequency($measure_id)=='M'){ 
    $stmt = $conn->prepare("SELECT MAX(month) FROM bsc_monthly WHERE target_id=? AND amount!=?");
    $stmt->bind_param('is',$measure_id,$amt);
    $amt='';
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($month);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT amount FROM bsc_monthly WHERE month=? AND target_id=?");
    $stmt->bind_param('si',$month,$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();
    $tooltip=$month.' ('.$amount.')';
    $stmt->close();

   }elseif(getReportingFrequency($measure_id)=='W'){
    $stmt = $conn->prepare("SELECT MAX(week) FROM bsc_weekly WHERE target_id=? AND week!=?");
    $stmt->bind_param('is',$measure_id,$weeklength);
    $weeklength='';
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($week);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT amount FROM bsc_weekly WHERE week=? AND target_id=?");
    $stmt->bind_param('si',$week,$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();
    $tooltip=$week.' ('.$amount.')';
    $stmt->close();
	}
 else{
 	$tooltip='Nothing to display';
 } 
//}
	return $tooltip;
}

function getTrendIndicator($measure_id){
  $conn=dbconnect();

    $stmt = $conn->prepare("SELECT base_target, stretch_target FROM bsc_targets WHERE id=?");
    $stmt->bind_param('i',$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($base_target, $stretch_target);
    $stmt->fetch();
    $stmt->close();

    if(getReportingFrequency($measure_id)=='W'){
    $stmt = $conn->prepare("SELECT amount FROM bsc_weekly WHERE target_id=? ORDER BY week DESC LIMIT 1");
    $stmt->bind_param('i',$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT AVG(amount) FROM bsc_weekly WHERE target_id=?");
    $stmt->bind_param('i',$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($avg);
    $stmt->fetch();
    $stmt->close();
}

  elseif(getReportingFrequency($measure_id)=='M'){
    $stmt = $conn->prepare("SELECT amount FROM bsc_monthly WHERE target_id=? ORDER BY month DESC LIMIT 1");
    $stmt->bind_param('i',$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT AVG(amount) FROM bsc_monthly WHERE target_id=?");
    $stmt->bind_param('i',$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($avg);
    $stmt->fetch();
    $stmt->close();
}
  elseif(getReportingFrequency($measure_id)=='Q'){
    $stmt = $conn->prepare("SELECT amount FROM bsc_quarterly WHERE target_id=? ORDER BY quarter DESC LIMIT 1");
    $stmt->bind_param('i',$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT AVG(amount) FROM bsc_quarterly WHERE target_id=?");
    $stmt->bind_param('i',$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($avg);
    $stmt->fetch();
    $stmt->close();
}
  elseif(getReportingFrequency($measure_id)=='HY'){
    $stmt = $conn->prepare("SELECT amount FROM bsc_half_yearly WHERE target_id=? ORDER BY half DESC LIMIT 1");
    $stmt->bind_param('i',$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT AVG(amount) FROM bsc_half_yearly WHERE target_id=?");
    $stmt->bind_param('i',$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($avg);
    $stmt->fetch();
    $stmt->close();
}
else{
  $amount=1;
  $avg=1;
}

if($base_target>$stretch_target){

  if($amount>$avg){
    return'<td><i class="fa fa-arrow-down" style="color:red" aria-hidden="true"></i></td>';
    }
  elseif($amount==$avg){
    return'<td><i class="fa fa-arrows-h" style="color:grey" aria-hidden="true"></i></td>';   
   }
  else{
    return'<td><i class="fa fa-arrow-up" style="color:green" aria-hidden="true"></i></td>';
    }

}else{
  if($amount>$avg){
    return'<td><i class="fa fa-arrow-up" style="color:green" aria-hidden="true"></i></td>';
    }
  elseif($amount==$avg){
    return'<td><i class="fa fa-arrows-h" style="color:grey" aria-hidden="true"></i></td>';   
   }
  else{
    return'<td><i class="fa fa-arrow-down" style="color:red" aria-hidden="true"></i></td>';
    }
  }
}

 function getChart($scorecard_id,$perspective_id){
     $conn = dbconnect();

  // $total=0;
  //   $stmt = $conn->prepare("SELECT targets.id FROM targets LEFT JOIN goals ON goals.id=goal_id WHERE perspective_id=? AND scorecard_id=?");
  //   $stmt->bind_param('ii',$perspective_id,$scorecard_id);
  // //  $scorecard_id=getScoreCardID();
  //   $stmt->execute();
  //   $stmt->store_result();
  //   $stmt->bind_result($measure_id);
  //   While($stmt->fetch()){
  //    if($count>0){
  //       $total+=getWeightedRating($measure_id); 
  //       $mytotal=round(($total/getPerspectiveTotalWeight($perspective_id,$scorecard_id))*100,2);

  //     }
  //   }
  //    return $total;
   $total=(getWR($scorecard_id,$perspective_id)/getPerspectiveTotalWeight($perspective_id,$scorecard_id))*100;
   return $total;
     $stmt->close();
     $conn->close(); 
}

function canvas($scorecard_id,$i){
  $conn=dbconnect(); ?>
<canvas data-type="radial-gauge"
    data-width="220"
    data-height="220"
    data-units="% score"
    data-value="<?php echo getChart($scorecard_id,$i); ?>"
    data-title="<?php echo ucFirst(getPerspectiveName($i)); ?>"
    data-color-title="#175ea8"
    data-min-value="-100"
    data-max-value="100"
    data-start-angle="70"
    data-ticks-angle="220"
    data-major-ticks="-100,-75,-50,-25,0,25,50,75,100"
    data-minor-ticks="10"
    data-stroke-ticks="true"
    data-highlights='[
       <?php configCanvas(); ?>
    ]'
    data-value-int="1"
    data-value-dec="1"
    data-color-plate="#fff"
    data-border-shadow-width="2"
    data-borders="true"
    <?php if(getChart($scorecard_id,$i)<0){ ?>
     data-color-value-box-rect="#f00"
    data-color-value-box-rect-end="#f00"   
  <?php  } else{?>
    data-color-value-box-rect="#084"
    data-color-value-box-rect-end="#084"
    <?php } ?>
    data-needle-type="arrow"
    data-needle-width="5"
    data-needle-circle-size="10"
    data-needle-circle-outer="true"
    data-needle-circle-inner="true"
    data-animation-duration="100"
    data-animation-rule="linear"
></canvas>
<?php }

function configCanvas(){ 
   $conn=dbconnect();
     $stmt=$conn->prepare("SELECT id, client_id, platinum, gold,diamond,silver, bronze, nickel FROM bsc_summary_ratings WHERE client_id=?");
   $stmt->bind_param('i',$client_id);
   $client_id=$_SESSION['client_id'];
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result($id, $client_id, $platinum, $gold,$diamond,$silver, $bronze, $nickel);
   While($stmt->fetch()){
}

echo'   {"from": '.$platinum.', "to": 100, "color": "#008542"},
        {"from": '.$gold.', "to": '.$platinum.', "color": "#50c878"},
        {"from": '.$diamond.', "to": '.$gold.', "color": "#00fe00"},
        {"from": '.$silver.', "to": '.$diamond.', "color": "#65ff00"},
        {"from": '.$bronze.', "to": '.$silver.', "color": "#f53c3c"},
        {"from":  -100, "to":  '.$bronze.', "color": "#bb2d42"} ';
}

function testmodal(){
echo'  <p data-toggle="modal" onClick="plotGraphOnModal()" data-target="#goal"></p>';

 echo' <div class="modal fade" id="goal" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">Update Goal </h4>
                </div>
                <div class="modal-body" >
                <form action="../grades.php" method="POST">

                <div id="tree"></div>
                   
                  <div class="form-group" align="right">
                    <button type="submit" class="btn btn-primary" name="savegoal">Save goal</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div> ';
}

function sendFirstReminder($scorecard_id,$diff){
  $conn=dbconnect();

  $stmt = $conn->prepare("SELECT a.email, a.supervisoremail, a.client, level_id, department_id, s.business_unit FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE s.id = ?");
    $stmt->bind_param('i', $scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($owner_email, $supervisor_email, $client_id,$level_id,$department_id,$business_unit);
    while($stmt->fetch()){
      if($level_id==1){
        $name=getClientName($client_id);
        $email=getClientEmail($client_id);
      }
      // elseif($level_id==2){
      //   $email=$supervisor_email;
      //   $name=getBusinessUnitName($business_unit);
      // }
      elseif($level_id==3){
        $email=$supervisor_email;
        $name=getDepartmentName($department_id);
      }else{
        $email=$owner_email;
        $name=getEmailOwnerName($owner_email);
      }        
    $to = $email;
    
    $email2 = $supervisor_email;
    
  $headers = "From: " . strip_tags('admin@masaisai.ac.zw') . "\r\n";
  $headers .= "Reply-To: ". strip_tags('nyasha@ipcconsultants.com') . "\r\n";
  $headers .= "CC: nyashaziwewe@gmail.com\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $subject = "RE: Masaisai Scorecard Updates";

    $message = "<html>
            <body style='color:#1575a7;'>
              <p>Good day <b>".ucwords(getEmailOwnerName($owner_email))."</b>,</p>
              <p>Please note that it is now more than ".$diff." days since your scorecard was created and you are yet to make any updates. The management would want to track progress so may you please update. This message was also sent to the management</p>
              <p><b>Make sure you make necessary updates in a few days to come</b></p>
              
              <p>Regards,</p>
              <p>Admin @ IPCIperform</p>
          </html>";

              $message2 = "<html>
            <body style='color:#1575a7;'>
              <p>Good day <b>".ucwords(getClientName($client_id))." Executive</b>,</p>
              <p>Please note that ".ucwords(getOwner($scorecard_id))."'s scorecard has never been updated since it was created and its now more than ".$diff." days.</p>
              <p>A reminder to the scorecard owner was also sent.</p>
              
              <p>Regards,</p>
              <p>Admin @ IPCIperform</p>
          </html>";
//  email($email,$subject,$message);
//  email($email2,$subject,$message2);
   mail($to, $subject, $message, $headers);
   mail($email2, $subject, $message2, $headers);
      }
    $stmt->close();

    $conn->close();


}

function sendReminder($scorecard_id){
  $conn=dbconnect();

  $stmt = $conn->prepare("SELECT a.email, a.supervisoremail, a.client, level_id, department_id FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE s.id = ?");
    $stmt->bind_param('i', $scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($owner_email, $supervisor_email, $client_id,$level_id,$department_id);
    while($stmt->fetch()){
      if($level_id==1){
        $email=$client_email;
        $name=getClientEmail($client_id);
      }
      elseif($level_id==2){
        $email=$supervisor_email;
        $name=getDepartmentName($department_id);
      }else{
        $email=$owner_email;
        $name=getEmailOwnerName($owner_email);
      }        
    $to = $email;
    
  $headers = "From: " . strip_tags('admin@masaisai.ac.zw') . "\r\n";
  $headers .= "Reply-To: ". strip_tags('nyasha@ipcconsultants.com') . "\r\n";
  $headers .= "CC: nyashaziwewe@gmail.com\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    $email2 = $supervisor_email;

    $subject = "RE: Scorecard Updates";

    $message = "<html>
            <body style='color:#1575a7;'>
              <p>Good day <b>".getEmailOwnerName($owner_email)."</b>,</p>
              <p>Please note that it has been a while from the time you last updated your scorecard. The management would want to track progress.</p>
              <p><b>Make sure you make necessary updates in the next 7 days</b></p>
              
              <p>Regards,</p>
              <p>Admin @ IPCIperform</p>
          </html>";

              $message2 = "<html>
            <body style='color:#1575a7;'>
              <p>Good day <b>".getClientName($client_id)." Executive</b>,</p>
              <p>Please note that it has been a while since ".getEmailOwnerName($owner_email)." last updated his/her scorecard. A reminder was sent.</p>
              <p>You receive this message because at least one measure's reporting_frequency has passed its cycle.</p>
              
              <p>Regards,</p>
              <p>Admin @ IPCIperform</p>
          </html>";
 mail($to,$subject,$message,$headers);
 mail($email2,$subject,$message2,$headers);
      }
    $stmt->close();

    $conn->close();


}

// function email($email,$subject,$message){
//   $conn=dbconnect();
//  //use php mailer to send emails
//   // include '../lib/PHPMailer/PHPMailer/PHPMailerAutoload.php';

//   //Create a new PHPMailer instance
//   $mail = new PHPMailer;


//     //send email to client
//       $mail->IsSMTP();
//       $mail->Host = "mail.ipcconsultants.com";

//       // optional 
//       $mail->SMTPAuth = true;
//       $mail->Username = 'jobevaluation';
//       $mail->Password = 'Redweb2019#';

//       //Set who the message is to be sent from
//       $mail->setFrom('jobevaluation@ipcconsultants.com', 'IPC Iperform');
//       //$mail->AddBCC($email2, 'IPC Iperform');
   
      
//       //Set who the message is to be sent to
//       $mail->addAddress($email, $subject); 
//       $mail->Subject = $subject;

//       $mail->IsHTML(true);
//       $mail->Body  = $message;
//       $mail->AltBody = $message;

//       //send the message, check for errors
//       if (!$mail->send()) {
//           echo "Mailer Error: " . $mail->ErrorInfo;
//       } else {
//           //do nothing after sending email
//       } 

//       $mail->ClearAllRecipients(); 
//       $mail->ClearAttachments();  

//     $conn->close();
// }
 

 function savedata($name,$email,$id){
  $conn=dbconnect();

    $stmt1 = $conn->prepare("UPDATE test SET name=?, email=? WHERE id=? ");
    $stmt1->bind_param('ssi', $name,$email,$id);
    $stmt1->execute();
    $stmt1->close();
    $conn->close();
 }
  function insertdata($name,$email){
  $conn=dbconnect();

     $stmt1 = $conn->prepare("INSERT INTO test (name, email) VALUES (?,?)");
    $stmt1->bind_param('ss', $name,$email);
    $stmt1->execute();
    $stmt1->close();
    $conn->close();
 }

  function deletedata($id){
  $conn=dbconnect();

    $stmt1 = $conn->prepare("DELETE FROM test WHERE id=?");
    $stmt1->bind_param('i', $id);
    $stmt1->execute();
    $stmt1->close();
    $conn->close();
 }

 function updateRow($unit,$reporting_frequency,$target_period,$base_target,$stretch_target,$actual,$allocated_weight,$measure_id){
 $conn=dbconnect();

    $stmt1 = $conn->prepare("UPDATE bsc_targets SET unit=?, reporting_frequency=?, target_period=?, base_target=?, stretch_target=?, actual=?, allocated_weight=? WHERE id=? ");
    $stmt1->bind_param('sssssssi', $unit,$reporting_frequency,$target_period,$base_target,$stretch_target,$actual,$allocated_weight,$measure_id);
    $stmt1->execute();
    $stmt1->close();
    $conn->close();
}

function getRevenues2($measure_id){
  $conn=dbconnect();
  $stmt=$conn->prepare("SELECT reporting_frequency FROM bsc_targets WHERE id=?");
  $stmt->bind_param('i',$measure_id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($reporting_frequency);
  $stmt->fetch();
  if($reporting_frequency=='W'){
       $table='<table class="table table-bordered table-condensed dataTable js-exportable" border="1">
       <tr><th>Week</th><th>Value</th><th>Evidence</th></tr>';

      $stmt6= $conn->prepare("SELECT COUNT(*) FROM bsc_weekly WHERE target_id=?");
      $stmt6->bind_param('i', $measure_id);
      $stmt6->execute();
      $stmt6->store_result();
      $stmt6->bind_result($count);
      $stmt6->fetch();
      if($count<1){
          insertWeek_id($measure_id);
      }
       $stmt6->close();

    $stmt1=$conn->prepare("SELECT id, week, amount, evidence FROM bsc_weekly WHERE target_id=?");
    $stmt1->bind_param('i', $measure_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($week_id,$week,$amount,$evidence);
    While($stmt1->fetch()){
      $table.='<tr>
               <td><input type="week" name="week" value="'.$week.'" onfocusout="autosaveWeek(this.value,'.$measure_id.','.$week_id.')"></td><td><input type="number" step="any" name="amount" value="'.$amount.'" onfocusout="autosaveWeeklyAmount(this.value,'.$measure_id.','.$week_id.')"></td>
               <td>';
               if($evidence<>''){
            $table.='<a href="/iperform/client/evidence/'.$evidence.'">'.$evidence.'</a>';
               }
          else{
            $table.='<form enctype="multipart/form-data" method="POST" id="fileUploadForm'.$week_id.'">
              <input type="file" name="evidence" id="evidence'.$week_id.'" onchange="uploadFile('.$week_id.')" accept="application/pdf"/>
              <input type="hidden" name="file_id" value="'.$week_id.'"> 
              <input type="hidden" name="table" value="weekly">  
              ';
            }
           $table.=' <font color="red"><i class="fa fa-trash-o" aria-hidden="true" onClick="deleteWeek('.$week_id.','.$measure_id.');"> </i></font></form>
                </td>
                </tr>';
    }
      $table.='</table>';
    $stmt1->close();
  }
  elseif($reporting_frequency=='M'){
    $table='<table class=" table order-list">
    <tr><th>Month</th><th>Value</th><th>Evidence</th></tr>';

    $stmt6= $conn->prepare("SELECT COUNT(*) FROM bsc_monthly WHERE target_id=?");
      $stmt6->bind_param('i', $measure_id);
      $stmt6->execute();
      $stmt6->store_result();
      $stmt6->bind_result($count);
      $stmt6->fetch();
      if($count<1){
          insertMonth_id($measure_id);
      }
       $stmt6->close();
    $stmt1=$conn->prepare("SELECT id, month, amount, evidence FROM bsc_monthly WHERE target_id=?");
    $stmt1->bind_param('i', $measure_id);    

    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($month_id,$month,$amount, $evidence);
    While($stmt1->fetch()){
      $table.='<tr>
          <td><input type="month" name="month" value="'.$month.'" onfocusout="autosaveMonth(this.value,'.$measure_id.','.$month_id.')"></td><td><input type="number" step="any" name="amount" value="'.$amount.'" onfocusout="autosaveMonthlyAmount(this.value,'.$measure_id.','.$month_id.')"></td>
          <td>';
          if($evidence<>''){
            $table.='<a href="/iperform/client/evidence/'.$evidence.'">'.$evidence.'</a>';
          }
          else{
            $table.='<form enctype="multipart/form-data" method="POST" id="fileUploadForm'.$month_id.'">
              <input type="file" name="evidence" id="evidence'.$month_id.'" onchange="uploadFile('.$month_id.')" accept="application/pdf"/>
              <input type="hidden" name="file_id" value="'.$month_id.'"> 
              <input type="hidden" name="table" value="monthly">  
              ';
            }
            $table.=' <font color="red"><i class="fa fa-trash-o" aria-hidden="true" onClick="deleteMonth('.$month_id.','.$measure_id.');"> </i></font></form>
              
          </td>
          </tr>';
    }
      $table.='</table>';
    $stmt1->close();
  }
    elseif($reporting_frequency=='Q'){
    $table='<table class="table table-bordered table-condensed dataTable js-exportable">
    <b>NB. Date represents end of quarter</b>
    <tr><th>Quarter</th><th>Value</th><th>Evidence</th></tr>';
    
    $stmt6= $conn->prepare("SELECT COUNT(*) FROM bsc_quarterly WHERE target_id=?");
      $stmt6->bind_param('i', $measure_id);
      $stmt6->execute();
      $stmt6->store_result();
      $stmt6->bind_result($count);
      $stmt6->fetch();
      if($count<1){
          insertQuarter_id($measure_id);
      }
       $stmt6->close();

    $stmt1=$conn->prepare("SELECT id, quarter, amount, evidence FROM bsc_quarterly WHERE target_id=?");
    $stmt1->bind_param('i', $measure_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($quarter_id,$quarter,$amount,$evidence);
    While($stmt1->fetch()){
      $table.='
                <tr>
               <td><input type="month" name="quarter" value="'.$quarter.'"onfocusout="autosaveQuarter(this.value,'.$measure_id.','.$quarter_id.')"></td><td><input type="number" step="any" name="amount" value="'.$amount.'" onfocusout="autosaveQuarterlyAmount(this.value,'.$measure_id.','.$quarter_id.')"></td>
               <td>';
               if($evidence<>''){
            $table.='<a href="/iperform/client/evidence/'.$evidence.'">'.$evidence.'</a>';
          }
          else{
            $table.='<form enctype="multipart/form-data" method="POST" id="fileUploadForm'.$quarter_id.'">
              <input type="file" name="evidence" id="evidence'.$quarter_id.'" onchange="uploadFile('.$quarter_id.')" accept="application/pdf"/>
              <input type="hidden" name="file_id" value="'.$quarter_id.'"> 
              <input type="hidden" name="table" value="quarterly">  
              ';
            }
        $table.='<font color="red"><i class="fa fa-trash-o" aria-hidden="true" onClick="deleteQuarter('.$quarter_id.','.$measure_id.');"> </i></font></form>
               </td></tr>';
    }
      $table.='</table>';
    $stmt1->close();
  }
    elseif($reporting_frequency=='HY'){
    $table='<table class="table table-bordered table-condensed dataTable js-exportable">
    <b>NB. Date represents end of each half</b>
    <tr><th>Half</th><th>Value</th><th>Evidence</th></tr>';

    $stmt6= $conn->prepare("SELECT COUNT(*) FROM bsc_half_yearly WHERE target_id=?");
      $stmt6->bind_param('i', $measure_id);
      $stmt6->execute();
      $stmt6->store_result();
      $stmt6->bind_result($count);
      $stmt6->fetch();
      if($count<1){
          insertHalf_id($measure_id);
      }
       $stmt6->close();
    
    $stmt1=$conn->prepare("SELECT id, half, amount FROM bsc_half_yearly WHERE target_id=?");
    $stmt1->bind_param('i', $measure_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($half_id,$half,$amount);
    While($stmt1->fetch()){
      $table.='<tr>
               <td><input type="month" name="half" value="'.$half.'" onfocusout="autosaveHalf(this.value,'.$measure_id.','.$half_id.')"></td><td><input type="number" step="any" name="amount" value="'.$amount.'" onfocusout="autosaveHalflyAmount(this.value,'.$measure_id.','.$half_id.')"></td>
               <td>';
               if($evidence<>''){
            $table.='<a href="/iperform/client/evidence/'.$evidence.'">'.$evidence.'</a>';
          }
          else{
            $table.='<form enctype="multipart/form-data" method="POST" id="fileUploadForm'.$half_id.'">
              <input type="file" name="evidence" id="evidence'.$half_id.'" onchange="uploadFile('.$half_id.')" accept="application/pdf"/>
              <input type="hidden" name="file_id" value="'.$half_id.'"> 
              <input type="hidden" name="table" value="half_yearly">  
              ';
            }
            $table.=' <font color="red"><i class="fa fa-trash-o" aria-hidden="true" onClick="deleteHalf('.$half_id.','.$measure_id.');"> </i></font></form>
               </td></tr>';
    }
      $table.='</table>';
    $stmt1->close();
  }
  else{
$table='<table><tr><td>Please add allocated weight and save first and reload so that the system decides on which interface to give you</td></tr></table>';
  }
echo $table;
}


function getReadOnlyRevenues2($measure_id){
  $conn=dbconnect();
  $stmt=$conn->prepare("SELECT reporting_frequency FROM bsc_targets WHERE id=?");
  $stmt->bind_param('i',$measure_id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($reporting_frequency);
  $stmt->fetch();
  if($reporting_frequency=='W'){
       $table='<table class="table table-bordered table-condensed dataTable js-exportable">
       <tr><th>Week</th><th>Value</th></tr>';

      $stmt6= $conn->prepare("SELECT COUNT(*) FROM bsc_weekly WHERE target_id=?");
      $stmt6->bind_param('i', $measure_id);
      $stmt6->execute();
      $stmt6->store_result();
      $stmt6->bind_result($count);
      $stmt6->fetch();
      if($count<1){
          insertWeek_id($measure_id);
      }
       $stmt6->close();

    $stmt1=$conn->prepare("SELECT id, week, amount FROM bsc_weekly WHERE target_id=?");
    $stmt1->bind_param('i', $measure_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($week_id,$week,$amount);
    While($stmt1->fetch()){
      $table.='<tr><td>'.$week.'</td><td>'.$amount.'></td></tr>';
    }
      $table.='</table>';
    $stmt1->close();
  }
  elseif($reporting_frequency=='M'){
    $table='<table class=" table order-list">
    <tr><th>Month</th><th>Value</th></tr>';

    $stmt6= $conn->prepare("SELECT COUNT(*) FROM bsc_monthly WHERE target_id=?");
      $stmt6->bind_param('i', $measure_id);
      $stmt6->execute();
      $stmt6->store_result();
      $stmt6->bind_result($count);
      $stmt6->fetch();
      if($count<1){
          insertMonth_id($measure_id);
      }
       $stmt6->close();
    
    $stmt1=$conn->prepare("SELECT id, month, amount FROM bsc_monthly WHERE target_id=?");
    $stmt1->bind_param('i', $measure_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($month_id,$month,$amount);
    While($stmt1->fetch()){
      $table.='<tr><td>'.$month.'</td><td>'.$amount.'</td></tr>';
    }
      $table.='</table>';
    $stmt1->close();
  }
    elseif($reporting_frequency=='Q'){
    $table='<table class="table table-bordered table-condensed dataTable js-exportable">
    <tr><th>Quarter</th><th>Value</th></tr>';
    
    $stmt6= $conn->prepare("SELECT COUNT(*) FROM bsc_quarterly WHERE target_id=?");
      $stmt6->bind_param('i', $measure_id);
      $stmt6->execute();
      $stmt6->store_result();
      $stmt6->bind_result($count);
      $stmt6->fetch();
      if($count<1){
          insertQuarter_id($measure_id);
      }
       $stmt6->close();

    $stmt1=$conn->prepare("SELECT id, quarter, amount FROM bsc_quarterly WHERE target_id=?");
    $stmt1->bind_param('i', $measure_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($quarter_id,$quarter,$amount);
    While($stmt1->fetch()){
      $table.='<tr><td>'.$quarter.'</td><td>'.$amount.'</td></tr>';
    }
      $table.='</table>';
    $stmt1->close();
  }
    elseif($reporting_frequency=='HY'){
    $table='<table class="table table-bordered table-condensed dataTable js-exportable">
    <tr><th>Half</th><th>Value</th></tr>';

    $stmt6= $conn->prepare("SELECT COUNT(*) FROM bsc_half_yearly WHERE target_id=?");
      $stmt6->bind_param('i', $measure_id);
      $stmt6->execute();
      $stmt6->store_result();
      $stmt6->bind_result($count);
      $stmt6->fetch();
      if($count<1){
          insertHalf_id($measure_id);
      }
       $stmt6->close();
    
    $stmt1=$conn->prepare("SELECT id, half, amount FROM bsc_half_yearly WHERE target_id=?");
    $stmt1->bind_param('i', $measure_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($half_id,$half,$amount);
    While($stmt1->fetch()){
      $table.='<tr><td>'.$half.'</td><td>'.$amount.'</td></tr>';
    }
      $table.='</table>';
    $stmt1->close();
  }
  else{
$table='<table><tr><td>Please add allocated weight and save first and reload so that the system decides on which interface to give you</td></tr></table>';
  }
echo $table;
}


function distributeTarget($target_period, $reporting_frequency){
  $conn=dbconnect();

  if($target_period='Y'){
    $target_period=12;
  }
  if($target_period='HY'){
    $target_period=6;
  }
  if($target_period='Q'){
    $target_period=3;
  }
    if($target_period='M'){
    $target_period=1;
  }
    if($target_period='W'){
    $target_period=0.25;
  }


   if($reporting_frequency='Y'){
    $reporting_frequency=12;
   }
    if($reporting_frequency='HY'){
    $reporting_frequency=6;
   }
    if($reporting_frequency='Q'){
    $reporting_frequency=3;
   }
    if($reporting_frequency='M'){
    $reporting_frequency=1;
   }
    if($reporting_frequency='Y'){
    $reporting_frequency=0.25;
   }

}

      
function getBusinessUnits(){
   $conn=dbconnect();

  $conn=dbconnect();
  $stmt = $conn->prepare("SELECT id, name, head FROM bsc_business_units WHERE client_id=?");
  $stmt->bind_param('i',$_SESSION['client_id']);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($id,$name, $head);
  while($stmt->fetch()){ 
echo'<tr><td>'.$name.'</td>
     <td>'.getEmployeeName($head).'</td>
     <td><button class="btn btn-primary" data-toggle="modal" data-target="#myModal'.$id.'"><i class="fa fa-edit"></i>Update</button>
     <a data-toggle="modal" data-target="#delete'.$id.'" class="btn btn-danger">Delete</a>
     </td>

';
echo'                           <div class="modal inmodal fade" id="myModal'.$id.'" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Update Business Unit Information</h4>
                                        </div>
                                        <div class="modal-body">
                                        <input type="text" name="name" id="name'.$id.'" onfocusout="saveBusinessUnit('.$id.');" value="'.$name.'" class="form-control">
                                        <hr>
                                        <select class="form-control" onChange="saveBusinessUnit('.$id.');" name="head" id="head'.$id.'">
                                        <option value="'.$head.'" selected>'.getEmployeeName($head).'</option>';
                                       getEmployeesOfCertainLevel(2);
                               echo'     </select>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class=" update_table btn btn-outline-primary" data-dismiss="modal">Done</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                            
                                           echo '<!-- Modal -->
          <div class="modal fade" id="delete'.$id.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Delete Scorecard </h4>
                </div>
                <div class="modal-body">
                <form action="business_units.php" method="POST">
                 <input type="hidden"  name="business_unit_id" value="'.$id.'">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <p align="center">Are you sure you want to delete this Business Unit </b>?</p>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                  <br/>
                  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                  <button type="submit" class="btn btn-danger" name="delete">Delete</button></a>
           
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>';
    echo '</td></tr>';
  }
  $stmt->close();
  $conn->close();
}

      function listBusinessUnits($client_id){

    $conn = dbconnect();

    $stmt1 = $conn->prepare("SELECT id, name FROM bsc_business_units WHERE client_id=?");
    $stmt1->bind_param('i',$client_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($id,$name);
    while($stmt1->fetch()){
      echo '<option value="'.$id.'">'.$name.'</option>';
    
       }
    $stmt1->close();
    $conn->close();

  }

function saveBusinessUnit($id,$name,$head){
  $conn=dbconnect();
  $stmt=$conn->prepare("UPDATE bsc_business_units SET name=?, head=? WHERE id=?");
  $stmt->bind_param('ssi',$name, $head,$id);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}

function addBusinessUnit($client_id,$name,$head){
  $conn=dbconnect();
  $stmt=$conn->prepare("INSERT INTO bsc_business_units (client_id,name, head) VALUES (?,?,?)");
  $stmt->bind_param('iss',$client_id,$name, $head);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}

     function getCompanyPerspectives(){

    $conn = dbconnect();

    $stmt1 = $conn->prepare("SELECT perspective_id, description FROM bsc_client_perspectives LEFT JOIN bsc_perspectives ON bsc_perspectives.id=perspective_id WHERE client_id=?");
    $stmt1->bind_param('i',$_SESSION['client_id']);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($perspective_id,$description);
    while($stmt1->fetch()){
      echo '
                      <a href="cascaded_performance/'.$perspective_id.'"> <li>
                            <div>
                                <h4>'.getPerspectiveName($perspective_id).'</h4>
                                <p>'.$description.'</p>
                                <a href="#"><i class="fa fa-trash-o "></i></a>
                            </div>
                        </li></a>';
    
       }
    $stmt1->close();
    $conn->close();

  }

  function addPerspective($client_id,$perspective_id){
  $conn=dbconnect();
  $stmt=$conn->prepare("INSERT INTO bsc_client_perspectives (client_id,perspective_id) VALUES (?,?)");
  $stmt->bind_param('ii',$client_id,$perspective_id);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}

     function getProjects($status){

    $conn = dbconnect();
    $client_id=$_SESSION['client_id'];
    
  if($_SESSION['account_type']==1){
        
    $stmt1 = $conn->prepare("SELECT id, name, manager, start_date, end_date, status FROM bsc_projects WHERE client_id =? AND status=?");
    $stmt1->bind_param('ii',$client_id,$status);
    }
   elseif($_SESSION['account_type']==2){
       
    $stmt1 = $conn->prepare("SELECT DISTINCT(bsc_projects.id), name, manager, bsc_projects.start_date, end_date, bsc_projects.status FROM bsc_projects LEFT JOIN bsc_scorecards ON scorecard_id=bsc_scorecards.id WHERE bsc_projects.client_id =? AND business_unit=? AND projects.status=?");
    $stmt1->bind_param('iii',$client_id, $_SESSION['business_unit'],$status);
       
   } 
   elseif($_SESSION['account_type']==3){
    $stmt1 = $conn->prepare("SELECT DISTINCT(bsc_projects.id), name, manager, bsc_projects.start_date, end_date, bsc_projects.status FROM bsc_projects LEFT JOIN bsc_scorecards ON scorecard_id=bsc_scorecards.id WHERE bsc_projects.client_id =? AND department_id=? AND projects.status=? ");
    $stmt1->bind_param('iii',$client_id, $_SESSION['department_id'],$status);
   }else{
       
    $stmt1 = $conn->prepare("SELECT DISTINCT(bsc_projects.id), name, manager, bsc_projects.start_date, end_date, bsc_projects.status FROM bsc_project_tasks LEFT JOIN bsc_projects ON bsc_projects.id=project_id WHERE bsc_projects.status=? AND (manager =? OR assigned=?)");
    $stmt1->bind_param('iii',$status, $_SESSION['user_id'],$_SESSION['user_id']); 
       
   }
    
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($id,$name,$manager,$start_date,$end_date,$statu);
    while($stmt1->fetch()){
      echo '
                           <li class="'.getProjectStatusColor($statu).'-element" id="task1" data-toggle="modal" data-target="#myProjectModal'.$id.'">
                                    '.$name.'
                                    <div class="agile-detail">
                                        <a href="#" class="float-right btn btn-xs btn-white">'.getEmployeeName($manager).'</a>
                                        <i class="fa fa-clock-o"></i> '.$end_date.'
                                    </div>
                                </li>';

      echo' <div class="modal inmodal fade" id="myProjectModal'.$id.'" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4><b>'.ucwords($name).' [Project Progress]</b>   <small>Tasks Involved</small></h4>
                                    
                         <div class="modal-body">
                        <div class="row" id="add_to_me'.$id.'">
                        <ul class="todo-list m-t small-list" style="text-align: left;" id="add_to'.$id.'">';
                          getProjectTasks($id);
                 echo'           </ul>
                        </div>
                          <input type="hidden" id="task_id" value="0" >
                          <br>
                     <div class="row" id="button'.$id.'">
                     <button class="btn btn-primary btn-sm" onclick="addCode('.$id.')">Add Check List</button>
                         </div>
                          <p id="warning'.$id.'" style="color: red;"></p>   
                              </div>
                              
                <div class="modal-footer">
                &nbsp;&nbsp;&nbsp;&nbsp;'; 
                // getProjectStatus($status,$id); 
                echo'
                                       
           
                  <button type="button" onClick="location.reload();" class="btn btn-primary" data-dismiss="modal">Done</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>';
    

       }
    $stmt1->close();
    $conn->close();

  }

       function getPep($employee_id){

    $conn = dbconnect();
    $stmt1 = $conn->prepare("SELECT id, employee_id, reason, description, date FROM bsc_pep WHERE employee_id=?");
    $stmt1->bind_param('i',$employee_id);
    $stmt1->execute(); 
    $stmt1->store_result();
    $stmt1->bind_result($id,$employee_id,$reason,$description,$date);
    while($stmt1->fetch()){
      echo '
                           <li class="primary-element" id="task1" data-toggle="modal" data-target="#myModal'.$id.'">
                                    '.$reason.' : '.$description.'
                                    <div class="agile-detail">
                                        <a href="#" class="float-right btn btn-xs btn-white">'.getEmployeeName($employee_id).'</a>
                                        <i class="fa fa-clock-o"></i> '.$date.'
                                    </div>
                                </li>';

      echo' <div class="modal inmodal fade" id="myModal'.$id.'" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4><b>'.ucwords($reason).'</b>   <small>CheckList</small></h4>

                         <div class="modal-body">
                        <div class="row" id="add_to_me'.$id.'">
                        <ul class="todo-list m-t small-list" style="text-align: left;" id="add_to'.$id.'" >';
                          getPepList($id);
                 echo'           </ul>
                        </div><br>
                            <div class="row" id="button'.$id.'">
                     <button class="btn btn-primary btn-sm" onclick="addCode('.$id.')">Add Check List</button>
                         </div>
                           <p id="warning'.$id.'" style="color: red;"></p>   
                               </div>

                                        <div class="modal-footer">
              </div>
                  <button type="button" onClick="location.reload();" class="btn btn-primary" data-dismiss="modal">Done</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';
    
       }
    $stmt1->close();
    $conn->close();

  }

  function getProjectStatusColor($status){
      $conn = dbconnect();

    $stmt1 = $conn->prepare("SELECT color FROM bsc_project_status WHERE id=?");
    $stmt1->bind_param('i',$status);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($color);
    $stmt1->fetch();
    return $color;
  
}

  function getProjectStatusName($status){
      $conn = dbconnect();

    $stmt1 = $conn->prepare("SELECT status FROM bsc_project_status WHERE id=?");
    $stmt1->bind_param('i',$status);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($name);
    $stmt1->fetch();
    return $name;
  
}

  function getPepStatusName($status){
      $conn = dbconnect();

if($status==0){
$name='Incomplete';
}else{
  $name='Completed';
}
    return $name;
  
}

  function getProjectTasks($project_id){
      $conn = dbconnect();

    $stmt1 = $conn->prepare("SELECT id, task,  due_date, last_updated, status, completion FROM bsc_project_tasks WHERE project_id=?");
    $stmt1->bind_param('i',$project_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($tid,$task,$due_date, $last_updated, $status,$completion);
    While($stmt1->fetch()){
      if($completion!=100){
       echo' 
          <tr><td><span data-toggle="modal" data-target="#deleteTask'.$tid.'" class="badge badge-danger"><i class="fa fa-window-close fa-5em"></i></span></td>';

              if($due_date < date('Y-m-d')){
              echo  '<td style="font-size: 14px; color: red;" contenteditable>'.$task.' </td>';
            }
              else{
              echo  '<td style="font-size: 14px;" contenteditable>'.$task.' </td>';
              }

              echo'<td><p id="completion'.$tid.'"><a onclick="changeCompletion('.$tid.','.$completion.')"><span class="badge"><button>'.$completion.'%</button></span></a></p></td>

                <td><p id="due_date'.$tid.'"><a onclick="changeDueDate('.$tid.')">'.$due_date.'</a></p></td> 
               
                <td><p id="assigned'.$tid.'"><a onclick="changeAssigned('.$tid.')">'.getInitials(getAssigned($tid)).'</a></p>';
          
             echo'         <div class="modal inmodal fade" id="deleteTask'.$tid.'" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h3>Deleting....</h3>
                                             <b> <font color="#175ea8">'.$task.' </font></b>
                            
                                        </div>
                                        <div class="modal-body">
                                  <h5><font color="red">Are you sure you want to delete this task. The process is irrevessible </font></h5>
                                        </div>

                                        <div class="modal-footer">
                                        <button class="btn btn-outline-info" data-dismiss="modal">No</buuton>
                                            <button type="button" class="btn btn-outline-danger" onclick="deleteTask('.$tid.','.$project_id.')"><i class="fa fa-trash"></i> Yes Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </td>
                </div></tr>';
      }else{
echo'    
              <tr><td><div class="i-checks"><label><input type="checkbox" disabled value="" checked=""></div></td>';
                
            if($due_date < $last_updated){
              echo  '<td colspan="2"><span class="m-l-xs todo-completed" style="font-size: 12px; color: red;">'.$task.'</span></td>
                    <td colspan="2"> '.$due_date.'</td>';
            }
              else{
              echo  '<td colspan="2"><span class="m-l-xs todo-completed" style="font-size: 12px; color: green;">'.$task.'"</span>
                    <td colspan="2"> '.$due_date.'</td>
                    </tr>';
              }

       echo'</div>';
    
    }

 
}
}


function getArchivedProjectTasks($project_id){
      $conn = dbconnect();

    $stmt1 = $conn->prepare("SELECT id, task,  due_date, last_updated, status, completion FROM bsc_project_tasks WHERE project_id=?");
    $stmt1->bind_param('i',$project_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($tid,$task,$due_date, $last_updated, $status,$completion);
    While($stmt1->fetch()){
      if($completion!=100){

              if($due_date < date('Y-m-d')){
              echo  '<td style="font-size: 14px; color: red;">'.$task.' </td>';
            }
              else{
              echo  '<td style="font-size: 14px;">'.$task.' </td>';
              }

              echo'<td><span class="badge"><button>'.$completion.'%</button></span></td>

                <td>'.$due_date.'</td> 
               
                <td>'.getInitials(getAssigned($tid)).'</td>
                </tr>';
      }else{
echo'    
              <tr><td><div class="i-checks"><label><input type="checkbox" disabled value="" checked=""></div></td>';
                
            if($due_date < $last_updated){
              echo  '<td colspan="2"><span class="m-l-xs todo-completed" style="font-size: 12px; color: red;">'.$task.'</span></td>
                    <td colspan="2"> '.$due_date.'</td>';
            }
              else{
              echo  '<td colspan="2"><span class="m-l-xs todo-completed" style="font-size: 12px; color: green;">'.$task.'"</span>
                    <td colspan="2"> '.$due_date.'</td>
                    </tr>';
              }

       echo'</div>';
    
    }

 
}
}


  function deleteTask($task_id){

    $conn = dbconnect();

    $stmt = $conn->prepare("DELETE FROM bsc_project_tasks WHERE id = ?");
    $stmt->bind_param('i', $task_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
  }

  function getMeasureTasks($measure_id){
      $conn = dbconnect();

    $stmt1 = $conn->prepare("SELECT id, task,  due_date, last_updated, status FROM bsc_measure_tasks WHERE measure_id=?");
    $stmt1->bind_param('i',$measure_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($id,$task,$due_date, $last_updated, $status);
    While($stmt1->fetch()){
      if($status==0){
        echo' <li>
              <a href="#" style="font-size: 20px; color: #175ea8;" class="check-link"><i class="fa fa-square-o" onClick="updateTaskStatus('.$id.',1);"></i> </a>
              <span class="m-l-xs" style="font-size: 16px;" >'.$task.' ';

              if($due_date < $last_updated){
              echo  ' <b>due:</b> '.$due_date.'';
            }
              else{
              echo  ' <b>due:</b> '.$due_date.'';
              }

              echo'</span>

          </li>';
      }else{
echo'     <li>
              <a href="#" style="font-size: 20px; color: #175ea8; " class="check-link"><i class="fa fa-check-square" onClick="updateTaskStatus('.$id.',0);"></i> </a>';
                
            if($due_date < date('Y-m-d')){
              echo  '<span class="m-l-xs todo-completed" style="font-size: 16px; color: red;">'.$task.' <b>due:</b> '.$due_date.'</span>';
            }
              else{
              echo  '<span class="m-l-xs todo-completed" style="font-size: 16px; color: green;">'.$task.' <b>due:</b> '.$due_date.'</span>';
              }

       echo' </li>';
    }
 
}
}

function getReadOnlyMeasureTasks($measure_id){
      $conn = dbconnect();

    $stmt1 = $conn->prepare("SELECT id, task,  due_date, last_updated, status FROM bsc_measure_tasks WHERE measure_id=?");
    $stmt1->bind_param('i',$measure_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($id,$task,$due_date, $last_updated, $status);
    While($stmt1->fetch()){
      if($status==0){
        echo' <li>
              
              <span class="m-l-xs" style="font-size: 16px;" >'.$task.' ';

              if($due_date < $last_updated){
              echo  ' <b>due:</b> '.$due_date.'';
            }
              else{
              echo  ' <b>due:</b> '.$due_date.'';
              }

              echo'</span>

          </li>';
      }else{
echo'     <li>';
                
            if($due_date < date('Y-m-d')){
              echo  '<span class="m-l-xs todo-completed" style="font-size: 16px; color: red;">'.$task.' <b>due:</b> '.$due_date.'</span>';
            }
              else{
              echo  '<span class="m-l-xs todo-completed" style="font-size: 16px; color: green;">'.$task.' <b>due:</b> '.$due_date.'</span>';
              }

       echo' </li>';
    }
 
}
}

  function getPepList($pep_id){
      $conn = dbconnect();

    $stmt1 = $conn->prepare("SELECT id, pep_id, list, due_date, last_updated, status FROM bsc_pep_check_list WHERE pep_id=?");
    $stmt1->bind_param('i',$pep_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($id,$pep_id,$list,$due_date,$last_updated, $status);
    While($stmt1->fetch()){
      if($status==0){
        echo' <li>
              <a href="#" style="font-size: 20px; color: #175ea8;" class="check-link"><i class="fa fa-square-o" onClick="updateListStatus('.$id.',1);"></i> </a>
              <span class="m-l-xs" style="font-size: 16px;" >'.$list.'';
                   if($due_date < $last_updated){
              echo  ' <b>due:</b> '.$due_date.'';
            }
              else{
                     echo  ' <b>due:</b> '.$due_date.'';
              }

    echo   '</span>
          </li>';
      }else{
echo'     <li>
              <a href="#" style="font-size: 20px; color: #175ea8; " class="check-link"><i class="fa fa-check-square" onClick="updateListStatus('.$id.',0);"></i> </a>';
              if($due_date < date('Y-m-d')){
              echo  '<span class="m-l-xs todo-completed" style="font-size: 16px; color: red;">'.$list.' <b>due:</b> '.$due_date.'</span>';
            }
              else{
              echo  '<span class="m-l-xs todo-completed" style="font-size: 16px; color: green;">'.$list.' <b>due:</b> '.$due_date.'</span>';
              }


     echo'</li>';
    }
 
}
}

   function get360Questions(){

    // Database connection
    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT id, step_id, question FROM 360_questions");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $step_id,$question);
    while($stmt->fetch()){
      echo '<tr>
        <td>'.get360StepName($step_id).'</td>
        <td>'.$question.'</td>
        <td> 
      
        <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Options</button>
        <ul class="dropdown-menu">';
echo'  <li><a href="#"> <button type="button"  class="btn btn-outline-primary" data-toggle="modal" data-target="#editModal'.$id.'"><i class="fa fa-edit"></i> Edit qstn</button></a></li>
                     
        <li><a href="#"><button class="btn btn-outline-danger" data-toggle="modal" data-target="#delete'.$id.'"><font color="red"<i class="fa fa-trash"></i>Delete User</font></button></a></li>
                       
        </ul>
        </div>
        </td>
      </tr>';

      echo'         <div class="modal inmodal fade" id="delete'.$id.'" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h3>Deleting <b> '.$question.' </b></h3>
                            <h5><font color="red">Deleting question Will delete all associated Information about the question</font></h5>
                                        </div>
                                        <div class="modal-body">
                                   <p align="center"> <h3>Are you Sure you want to delete this question?</h3> </p>
                                        </div>

                                        <div class="modal-footer">
                                        <button class="btn btn-outline-info" data-dismiss="modal">No</buuton>
                                            <button type="button" class="btn btn-outline-danger" onclick="deleteQuestion('.$id.')" data-dismiss="modal"><i class="fa fa-trash"></i> Yes Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';

                echo'   <div class="modal inmodal fade" id="editModal'.$id.'" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Update question</h4>
                                        </div>
                                        <div class="modal-body">
                                    
                  <div class="row about-extra">
                 
                 
                      <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
                       <div class="form-group form-float">
                          <div class="form-line">  
                          <label style="color: #175ea8">Question</label>                              
                        <input type="text" id="question'.$id.'" value="'.$question.'" placeholder="Add question here..." class="form-control">
                         </div>
                       </div>
                       </div>
                       </div>
                    <div class="row about-extra">
                   <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                             <label style="color: #175ea8">Stage</label>   
                              <select id="step_id'.$id.'" class="form-control" >
                              <option value="'.$step_id.'">'.get360StepName($step_id).'</option>';
                                    list360Steps(); 
                    echo'          </select>
                          </div>
                      </div>
                    </div>

                    </div>
                  </div>
                                         <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-primary" onclick="saveQuestion('.$id.')" data-dismiss="modal">Done</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';
    }
    $stmt->close();

    //close conn
    $conn->close();

  }

     function getAccessLevels(){

    // Database connection
    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT id, name FROM bsc_access_levels");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name);
    while($stmt->fetch()){
      echo'<option value="'.$id.'">'.$name.'</option>';
    }

  $stmt->close();
  $conn->close();
    }

       function getAccessLevelName($id){

    // Database connection
    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT name FROM bsc_access_levels WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $name;
    }

      function list360Steps(){
    
    $conn = dbconnect();
    $departments;
    $stmt = $conn->prepare("SELECT id, name FROM 360_steps");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name);
    while($stmt->fetch()){

     echo '<option value="'.$id.'">'.$name.'</option>';
    }
    $stmt->close();

    $conn->close();
  }

    function get360StepName($id){

    // Database connection
    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT name FROM 360_steps WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $name;
    }

    function add360Question($question,$step_id){
      $conn=dbconnect();
   
  $stmt=$conn->prepare("INSERT INTO 360_questions (step_id,question) VALUES (?,?)");
  $stmt->bind_param('is',$step_id,$question);
  $stmt->execute();
  $stmt->close();
  $conn->close();
        }

  function update360Question($question_id,$step_id,$question){
      $conn=dbconnect();
   
  $stmt=$conn->prepare("UPDATE 360_questions SET step_id=?,question=? WHERE id=?");
  $stmt->bind_param('isi',$step_id,$question,$question_id);
  $stmt->execute();
  $stmt->close();
  $conn->close();
        }

      function get360StepTabs(){
    
    $conn = dbconnect();
    $departments;
    $stmt = $conn->prepare("SELECT id, name FROM 360_steps");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name);
    while($stmt->fetch()){

     echo '   <h6>'.get360StepName($id).'</h6>
                <section style="height: 400px; overflow: auto;" >';
                    get360ExamQuestions($id);
          echo'</section>';
    }
    $stmt->close();

    $conn->close();
  }

    function get360ExamQuestions($step_id){
    
    $conn = dbconnect();
    $departments;
    $stmt = $conn->prepare("SELECT id, question FROM 360_questions WHERE step_id=?");
    $stmt->bind_param('i',$step_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id,$question);
    while($stmt->fetch()){

     echo '<h3 style="color: #175ea8">'.$question.'</h3><div class="radio-toolbar">';
     get360AnswerScale($id);
  echo'</div><br>';
    }
    $stmt->close();

    $conn->close();
  }

   function get360AnswerScale($question_id){

    $conn = dbconnect();
    //$departments;
    if($_SESSION['account_type']!=1){

    $stmt = $conn->prepare("SELECT id, value, text FROM 360_answer_scale ORDER BY value DESC");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id,$value,$text);
    while($stmt->fetch()){

    if(checkIfUserAlreadyAnswered($question_id)<1){
      echo'  
    <input type="radio" id="answer'.$question_id.$id.'" onclick="addResponse(this.value,'.$question_id.')" name="answer'.$question_id.'" value="'.$value.'">
    <label for="answer'.$question_id.$id.'"><font color="#175ea8">'.$text.'</font></label>
    ';
    }else{
    $stmt1 = $conn->prepare("SELECT id, value FROM 360_responses WHERE user_id=? AND question_id=?");
    $stmt1->bind_param('ii',$_SESSION['user_id'],$question_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($response_id, $thisvalue);
    $stmt1->fetch();
    $stmt1->close();
    if($thisvalue==$value){
       echo'  
    <input type="radio" id="answer'.$question_id.$id.'" onclick="saveResponse(this.value,'.$response_id.')" name="answer'.$question_id.'" value="'.$value.'" checked>
    <label for="answer'.$question_id.$id.'"><font color="#175ea8">'.$text.'</font></label>
    ';
    }else{
       echo'  
    <input type="radio" id="answer'.$question_id.$id.'" onclick="saveResponse(this.value,'.$response_id.')" name="answer'.$question_id.'" value="'.$value.'">
    <label for="answer'.$question_id.$id.'"><font color="#175ea8">'.$text.'</font></label>
    ';
    }
    }
  } 
    $stmt->close();
  }else{
    
  }
  $conn->close();
}

function addResponse($user_id,$client_id,$question_id,$value){
  $conn=dbconnect();

  $stmt=$conn->prepare("INSERT INTO 360_responses (user_id,client_id,question_id,value) VALUES (?,?,?,?)");
  $stmt->bind_param('iiii',$user_id,$client_id,$question_id,$value);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}

function checkIfUserAlreadyAnswered($question_id){
  $conn=dbconnect();

    $user_id=7;
    $stmt1 = $conn->prepare("SELECT COUNT(id) FROM 360_responses WHERE user_id=? AND question_id=?");
    $stmt1->bind_param('ii',$user_id,$question_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();
    $stmt1->close();
    $conn->close();
    return $count;
}

function updateResponse($response_id,$value){
  $conn=dbconnect();
   
  $stmt=$conn->prepare("UPDATE 360_responses SET value=? WHERE id=?");
  $stmt->bind_param('ii',$value,$response_id);
  $stmt->execute();
  $stmt->close();
  $conn->close();

}

function countClientPerspectives(){
  $conn=dbconnect();
   
  $stmt=$conn->prepare("SELECT COUNT(id) FROM bsc_client_perspectives WHERE client_id=?");
  $stmt->bind_param('i',$_SESSION['client_id']);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($count);
  $stmt->fetch();
  $stmt->close();
  $conn->close();
  return $count;

}

function sendMail($recepient,$reply_to,$forward,$subject,$message,$sender){
  $conn=dbconnect();

  $stmt=$conn->prepare("INSERT INTO emails (recepient,reply_to,forwarded,subject,message,sender) VALUES (?,?,?,?,?,?)");
  $stmt->bind_param('ssssss',$recepient,$reply_to,$forward,$subject,$message,$sender);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}
function saveDraft($recepient,$reply_to,$forward,$subject,$message,$sender){
  $conn=dbconnect();

  $stmt=$conn->prepare("INSERT INTO drafts (recepient,reply_to,forwarded,subject,message,sender) VALUES (?,?,?,?,?,?)");
  $stmt->bind_param('ssssss',$recepient,$reply_to,$forward,$subject,$message,$sender);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}

  function countEmails($table,$status){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM  $table WHERE recepient=? AND status=?");
    $stmt->bind_param('si',$_SESSION['email'],$status);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();
    
    $stmt->close();
    $conn->close();
return $count;

  }

  function getUreadMessages(){
    $conn=dbconnect();

    $stmt = $conn->prepare("SELECT id, reply_to, recepient, subject, message, sender, date FROM emails WHERE recepient=? ORDER BY date DESC");
    $stmt->bind_param('s',$_SESSION['email']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $reply_to, $recepient, $subject, $message, $sender,$date);
    while($stmt->fetch()){

      if(getClientEmailName($sender)!=''){
       $name=getClientEmailName($sender);
      }
      elseif(getEmailOwnerName($sender)!=''){
        $name=getEmailOwnerName($sender);
      } else{
        $name="System Admin";
      }

      echo'         <tr class="unread">
                    <td class="mail-ontact">'.$name.'</td>
                    <td class="mail-subject"><a href="mail_details.php?m='.$id.'">'.$subject.'.</a></td>
                    <td class="mail-subject"><a href="mail_details.php?m='.$id.'">'.substr($message,0,50).'...</a></td>
                    <td class="text-right mail-date">'.substr($date,0,16).'</td>
                    </tr>';
  }
  $stmt->close();
  $conn=dbconnect();
}

  function getEmailDetails($id){
    $conn=dbconnect();

    $stmt = $conn->prepare("SELECT id, forwarded, reply_to, recepient, subject, message, sender, date FROM emails WHERE id=?");
    $stmt->bind_param('s',$id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $forwarded, $reply_to, $recepient, $subject, $message, $sender,$date);
    $stmt->fetch();

      if(getClientEmailName($sender)!=''){
       $sname=getClientEmailName($sender);
      }
      elseif(getEmailOwnerName($sender)!=''){
        $sname=getEmailOwnerName($sender);
      } else{
        $sname="System Admin";
      }
            if(getClientEmailName($recepient)!=''){
       $rname=getClientEmailName($recepient);
      }
      elseif(getEmailOwnerName($recepient)!=''){
        $rname=getEmailOwnerName($recepient);
      } else{
        $rname="System Admin";
      }

      echo'     <div class="mail-box-header">
                <div class="float-right tooltip-demo">';
                if($recepient==$_SESSION['email']){
             echo'<button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Reply"><i class="fa fa-reply"></i> Reply</button>';     
                }
                    
        echo'   <button class="btn btn-white btn-sm"><i class="fa fa-print"></i> </button>
                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete</button>
                </div>
                <h3> <input type="hidden" value="'.$id.'" id="reply_to">
                     <input type="hidden" value="'.$sender.'" id="sender">';
                     if($forwarded==1){
                echo'<span class="font-normal">Subject: </span>FW<i class="fa fa-share" aria-hidden="true"></i> '.$subject.'</h3>'; 
                     }else{
                echo' <span class="font-normal">Subject: </span>'.$subject.'</h3>';
                     }
                echo' <div class="mail-tools tooltip-demo m-t-md">
                    <h5>
                        <span class="float-right font-normal">'.substr($date,0).'</span>';
                        if($recepient==$_SESSION['email']){
                          echo'<span class="font-normal">From: </span>'.$sname.'</h5>';
                        }else{
                        echo'<span class="font-normal">To: </span>'.$rname.'</h5>';
                      } 
           echo'</div>
                </div>
                <div class="mail-box">
                <div class="mail-body">           
                '.$message.'
                </div>
             
              <div class="mail-body text-right tooltip-demo">';
              if($recepient==$_SESSION['email']){
    echo'<a href="mail_compose.php?r='.$id.'&e='.$sender.'" class="btn btn-sm btn-white"><i class="fa fa-reply"></i> Reply</a>';
              }
      echo' <a class="btn btn-sm btn-white" href="mail_compose.php?f='.$id.'"><i class="fa fa-arrow-right"></i> Forward</a>
              <button type="button" class="btn btn-sm btn-white"><i class="fa fa-print"></i> Print</button>
              <button class="btn btn-sm btn-white"><i class="fa fa-trash-o"></i> Remove</button>
                        </div>
                        <div class="clearfix"></div>
                </div>';

  $stmt->close();
  $conn->close();
}

 function getEmailToFoward($id){
    $conn=dbconnect();

    $stmt = $conn->prepare("SELECT message FROM emails WHERE id=?");
    $stmt->bind_param('s',$id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($message);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $message;
}
 function getSubjectToFoward($id){
    $conn=dbconnect();

    $stmt = $conn->prepare("SELECT subject FROM emails WHERE id=?");
    $stmt->bind_param('s',$id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($subject);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $subject;
}

  function getsentMessages(){
    $conn=dbconnect();

    $stmt = $conn->prepare("SELECT id, reply_to, recepient, subject, message, sender, date FROM emails WHERE sender=? ORDER BY date DESC");
    $stmt->bind_param('s',$_SESSION['email']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $reply_to, $recepient, $subject, $message, $sender,$date);
    while($stmt->fetch()){

      if(getClientEmailName($recepient)!=''){
       $name=getClientEmailName($recepient);
      }
      elseif(getEmailOwnerName($recepient)!=''){
        $name=getEmailOwnerName($recepient);
      } else{
        $name="System Admin";
      }

      echo'         <tr class="unread">
                    <td class="mail-ontact">'.$name.'</td>
                    <td class="mail-subject"><a href="sent_details.php?m='.$id.'">'.$subject.'.</a></td>
                    <td class="mail-subject"><a href="sent_details.php?m='.$id.'">'.substr($message,0,40).'...</a></td>
                    <td class="text-right mail-date">'.substr($date,0,16).'</td>
                    </tr>';
  }
  $stmt->close();
  $conn=dbconnect();
}

 function getDrafts(){
    $conn=dbconnect();

    $stmt = $conn->prepare("SELECT id, reply_to, recepient, subject, message, sender, date FROM drafts WHERE sender=? ORDER BY date DESC");
    $stmt->bind_param('s',$_SESSION['email']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $reply_to, $recepient, $subject, $message, $sender,$date);
    while($stmt->fetch()){

      if(getClientEmailName($recepient)!=''){
       $name=getClientEmailName($recepient);
      }
      elseif(getEmailOwnerName($recepient)!=''){
        $name=getEmailOwnerName($recepient);
      } else{
        $name="System Admin";
      }

      echo'         <tr class="unread">
                    <td class="mail-ontact">'.$name.'</td>
                    <td class="mail-subject"><a href="sent_details.php?m='.$id.'">'.$subject.'.</a></td>
                    <td class="mail-subject"><a href="sent_details.php?m='.$id.'">'.substr($message,0,40).'...</a></td>
                    <td class="text-right mail-date">'.substr($date,0,16).'</td>
                    </tr>';
  }
  $stmt->close();
  $conn=dbconnect();
}

  function getReadOnlyRevenues($measure_id){
  $conn=dbconnect();
  $stmt=$conn->prepare("SELECT reporting_frequency FROM bsc_targets WHERE id=?");
  $stmt->bind_param('i',$measure_id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($reporting_frequency);
  $stmt->fetch();
  if($reporting_frequency=='W'){
       $table='<table class="table table-bordered table-condensed dataTable js-exportable">
       <tr><th>Week</th><th>Value</th></tr>';

      $stmt6= $conn->prepare("SELECT COUNT(*) FROM bsc_weekly WHERE target_id=?");
      $stmt6->bind_param('i', $measure_id);
      $stmt6->execute();
      $stmt6->store_result();
      $stmt6->bind_result($count);
      $stmt6->fetch();
      if($count<1){
          insertWeek_id($measure_id);
      }
       $stmt6->close();

    $stmt1=$conn->prepare("SELECT id, week, amount FROM bsc_weekly WHERE target_id=?");
    $stmt1->bind_param('i', $measure_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($week_id,$week,$amount);
    While($stmt1->fetch()){
      $table.='<tr>
                  <td>'.$week.'</td>
                  <td>'.$amount.'</td>
               </tr>';
    }
      $table.='</table>';
    $stmt1->close();
  }
  elseif($reporting_frequency=='M'){
    $table='<table class=" table order-list">
    <tr><th>Month</th><th>Value</th></tr>';

    $stmt6= $conn->prepare("SELECT COUNT(*) FROM bsc_monthly WHERE target_id=?");
      $stmt6->bind_param('i', $measure_id);
      $stmt6->execute();
      $stmt6->store_result();
      $stmt6->bind_result($count);
      $stmt6->fetch();
      if($count<1){
          insertMonth_id($measure_id);
      }
       $stmt6->close();
    
    $stmt1=$conn->prepare("SELECT id, month, amount FROM bsc_monthly WHERE target_id=?");
    $stmt1->bind_param('i', $measure_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($month_id,$month,$amount);
    While($stmt1->fetch()){
      $table.='<tr><td>'.$month.'</td>
                   <td>'.$amount.'</td>
                   </tr>';
    }
      $table.='</table>';
    $stmt1->close();
  }
    elseif($reporting_frequency=='Q'){
    $table='<table class="table table-bordered table-condensed dataTable js-exportable">
    <tr><th>Quarter</th><th>Value</th></tr>';
    
    $stmt6= $conn->prepare("SELECT COUNT(*) FROM bsc_quarterly WHERE target_id=?");
      $stmt6->bind_param('i', $measure_id);
      $stmt6->execute();
      $stmt6->store_result();
      $stmt6->bind_result($count);
      $stmt6->fetch();
      if($count<1){
          insertQuarter_id($measure_id);
      }
       $stmt6->close();

    $stmt1=$conn->prepare("SELECT id, quarter, amount FROM bsc_quarterly WHERE target_id=?");
    $stmt1->bind_param('i', $measure_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($quarter_id,$quarter,$amount);
    While($stmt1->fetch()){
      $table.='<tr><td>'.$quarter.'</td>
                   <td>'.$amount.'</td>
                </tr>';
    }
      $table.='</table>';
    $stmt1->close();
  }
    elseif($reporting_frequency=='HY'){
    $table='<table class="table table-bordered table-condensed dataTable js-exportable">
    <tr><th>Half</th><th>Value</th></tr>';

    $stmt6= $conn->prepare("SELECT COUNT(*) FROM bsc_half_yearly WHERE target_id=?");
      $stmt6->bind_param('i', $measure_id);
      $stmt6->execute();
      $stmt6->store_result();
      $stmt6->bind_result($count);
      $stmt6->fetch();
      if($count<1){
          insertHalf_id($measure_id);
      }
       $stmt6->close();
    
    $stmt1=$conn->prepare("SELECT id, half, amount FROM bsc_half_yearly WHERE target_id=?");
    $stmt1->bind_param('i', $measure_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($half_id,$half,$amount);
    While($stmt1->fetch()){
      $table.='<tr><td>'.$half.'</td>
               <td>'.$amount.'</td>
               </tr>';
    }
      $table.='</table>';
    $stmt1->close();
  }
  else{
$table='<table><tr><td>No data</td></tr></table>';
  }
echo $table;
}

  function addTask($project_id,$task,$due_date){
  $conn=dbconnect();

     $stmt1 = $conn->prepare("INSERT INTO bsc_project_tasks (project_id, task,due_date) VALUES (?,?,?)");
    $stmt1->bind_param('sss', $project_id,$task,$due_date);
    $stmt1->execute();
    $stmt1->close();
    $conn->close();
 }

   function addMeasureTask($measure_id,$task,$due_date){
  $conn=dbconnect();

    $stmt1 = $conn->prepare("INSERT INTO bsc_measure_tasks (measure_id, task,due_date) VALUES (?,?,?)");
    $stmt1->bind_param('sss', $measure_id,$task,$due_date);
    $stmt1->execute();
    $stmt1->close();
    
    $stmt = $conn->prepare("SELECT COUNT(id) FROM bsc_measure_tasks WHERE measure_id=?");
    $stmt->bind_param('i',$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT COUNT(id) FROM bsc_measure_tasks WHERE measure_id=? AND status=? AND due_date > last_updated");
    $stmt->bind_param('ii',$measure_id,$status);
    $status=1;
    $stmt->execute(); 
    $stmt->store_result();
    $stmt->bind_result($count2);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("UPDATE bsc_targets SET base_target=?, stretch_target=?, actual=? WHERE id=?");
    $stmt->bind_param('iiii',$count,$count,$count2,$measure_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

 }

   function addPepList($pep_id,$list,$date){
  $conn=dbconnect();

     $stmt1 = $conn->prepare("INSERT INTO bsc_pep_check_list (pep_id, list,due_date) VALUES (?,?,?)");
    $stmt1->bind_param('sss', $pep_id,$list,$date);
    $stmt1->execute();
    $stmt1->close();
    $conn->close();
 }

 function updateTaskStatus($task_id,$status,$scorecard_id,$project_id){
    $conn=dbconnect();

     $stmt1 = $conn->prepare("UPDATE bsc_project_tasks SET status=? WHERE id=?");
    $stmt1->bind_param('ii', $status,$task_id);
    $stmt1->execute();
    $stmt1->close();
    $conn->close();

    if($status==1){
      sendApprovalMessage($scorecard_id,$project_id,$task_id,$status);
    }

 }

  function updateTaskProgress($task_id,$value){
    $conn=dbconnect();

    $stmt1 = $conn->prepare("UPDATE bsc_project_tasks SET completion=? WHERE id=?");
    $stmt1->bind_param('ii', $value,$task_id);
    $stmt1->execute();
    $stmt1->close();
    
    $stmt1 = $conn->prepare("SELECT project_id FROM bsc_project_tasks WHERE id=?");
    $stmt1->bind_param('i',$task_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($project_id);
    $stmt1->fetch();
    $stmt1->close();
    $conn->close();
    $user_id=$_SESSION['user_id'];
    
    if($value==100){
       emailTaskCompletion($user_id, $project_id, $task_id);  
    }

 }

  function updateMeasureTaskStatus($task_id,$status){
    $conn=dbconnect();

     $stmt1 = $conn->prepare("UPDATE bsc_measure_tasks SET status=? WHERE id=?");
    $stmt1->bind_param('ii', $status,$task_id);
    $stmt1->execute();
    $stmt1->close();
    $conn->close();

 }


  function updatePepList($pep_id,$status){
    $conn=dbconnect();

    $stmt1 = $conn->prepare("UPDATE bsc_pep_check_list SET status=? WHERE id=?");
    $stmt1->bind_param('ii', $status,$pep_id);
    $stmt1->execute();
    $stmt1->close();
    $conn->close();

 }

  function updateProjectStatus($project_id,$status){
    $conn=dbconnect();

     $stmt1 = $conn->prepare("UPDATE bsc_projects SET status=? WHERE id=?");
    $stmt1->bind_param('ii', $status,$project_id);
    $stmt1->execute();
    $stmt1->close();
    $conn->close();

 }

function addProject($client_id,$scorecard_id, $project,$description,$manager,$start_date,$end_date){
  $conn=dbconnect();
  $stmt=$conn->prepare("INSERT INTO bsc_projects (client_id,scorecard_id, name, description, manager,start_date, end_dat) VALUES (?,?,?,?,?,?,?)");
  $stmt->bind_param('issssss',$client_id,$scorecard_id, $project,$description,$manager,$start_date,$end_date);
  $stmt->execute();
  $stmt->close();
  $conn->close();
    echo "<script type='text/javascript'>
        window.location.href = 'action_plans/".$scorecard_id."';
        </script>";

}

function getOrganogram2($scorecard_id,$perspective_id){ ?>

      <script>
    
window.onload = function () { 
    var chart = new OrgChart(document.getElementById("tree38"), {
        toolbar: true,
        menu: {
            pdf: { text: "Export PDF" },
            png: { text: "Export PNG" },
            svg: { text: "Export SVG" },
            csv: { text: "Export CSV" }
        },

        nodeBinding: {
            field_0: "name",
            field_1: "title",
            field_2: "email",
            field_3: "phone",
            field_number_children: "field_number_children"
        },
        nodes: [

    { id: "<?php echo $scorecard_id; ?>", pid: "", name: "<?php echo getOwner($scorecard_id); ?>", title: "", img: "",email:"<?php echo $scorecard_id; ?>" }, 

 <?php 
    $conn=dbconnect();

    $stmt14=$conn->prepare("SELECT DISTINCT(id) FROM bsc_scorecards WHERE client_id=? AND level_id=?");
    $stmt14->bind_param('ii',$_SESSION['client_id'],$level_id);
    $level_id=4;
    $stmt14->execute();
    $stmt14->store_result();
    $stmt14->bind_result($scorecard);
    While($stmt14->fetch()){ ?>
 { id: "<?php echo $scorecard; ?>", pid: "<?php echo $scorecard; ?>", name: "<?php echo getDepartmentName(getScoreCardDepartment($scorecard)); ?>", title: "<?php echo getWR($scorecard,1); echo "%"; ?>", img: " ", $phone: "<?php echo $scorecard; ?>" }, 
     <?php   }

      ?>
          ]
    });
};

    </script>    <?php     
     } 

function getCoporateScorecard($client_id){
    $conn=dbconnect();

    $stmt=$conn->prepare("SELECT id FROM bsc_scorecards WHERE level_id=? AND client_id=? AND status=?");
    $stmt->bind_param('iii',$level_id,$client_id,$status);
    $level_id=1;
    $status=1;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $scorecard_id;
  }

  function getCompanyProfilePic(){
    $conn=dbconnect();
    $stmt=$conn->prepare("SELECT profile FROM bsc_client WHERE client_id=?");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($picture);
    $stmt->fetch();
    return $picture;
    $stmt->close();
    $conn->close();
 
  }

   function getClient360Policy(){
    $conn=dbconnect();
    $stmt=$conn->prepare("SELECT mandatory FROM client_360_policy WHERE client_id=?");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($mandatory);
    $stmt->fetch();
      if($mandatory=="1"){
        echo'<input type="checkbox" onChange="updatePolicy(0)" value="checked" class="js-switch" checked />';
      }else{
        echo'<input type="checkbox" onChange="updatePolicy(1)" class="js-switch" />';
      }

    $stmt->close();
    $conn->close();
  }

function updatePolicy($mandatory){
    $conn=dbconnect();

    $stmt1=$conn->prepare("SELECT COUNT(id) FROM client_360_policy WHERE client_id=?");
    $stmt1->bind_param('i',$_SESSION['client_id']);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();

    if($count>0){
    $stmt=$conn->prepare("UPDATE client_360_policy SET mandatory=? WHERE client_id=?");
    $stmt->bind_param('ii',$mandatory,$_SESSION['client_id']);
    $stmt->execute();
    $stmt->close();

  }else{
    $stmt=$conn->prepare("INSERT INTO client_360_policy (client_id, mandatory) VALUES (?,?)");
    $stmt->bind_param('ii',$_SESSION['client_id'],$mandatory);
    $stmt->execute();
    $stmt->close();

  }
      $stmt1->close();
      $conn->close();
  }

function bunits(){                
    $conn=dbconnect();
    
    $count=1;
    $stmt=$conn->prepare("SELECT id, name FROM bsc_business_units WHERE client_id=?");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id,$name);
    While($stmt->fetch()){ ?>
      {
      label: '<?php echo $name; ?>',
      data: [<?php getWR(getCoporateScorecard($_SESSION['client_id']),1); ?>, 2, 3, 4],
      backgroundColor: "<?php echo getChartColors($count) ?>"
    },

 <?php $count++; }
    $stmt->close();
    $conn->close();

  }

function Perspectives(){                
    $conn=dbconnect();
    $perspectives='';
    $stmt=$conn->prepare("SELECT DISTINCT(perspective_id) FROM bsc_client_perspectives WHERE client_id=?");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($perspective_id);
    While($stmt->fetch()){
   $perspectives.= '"';
   $perspectives.= "".getPerspectiveName($perspective_id)."";
   $perspectives.= '"';
   $perspectives.= ",";
   }
    $stmt->close();
    $conn->close();
    return $perspectives;
  }

  function getChartColors($id){                
   if($id==1){
    $color="green";
   } elseif($id==2){
    $color="#175ea8";
   }
    elseif($id==3){
    $color="brown";
   }
 elseif($id==4){
    $color="gray";
   }else{
      $color="yellow";
   }
return $color;

  }

  function saveProject($client_id,$scorecard_id, $project,$description,$manager,$start_date,$end_date){
    $conn=dbconnect();

    $stmt1 = $conn->prepare("INSERT INTO bsc_projects (client_id,scorecard_id, name, description, manager, start_date, end_date) VALUES (?,?,?,?,?,?,?)");
    $stmt1->bind_param('iisssss', $client_id,$scorecard_id,$project,$description,$manager,$start_date,$end_date);
    $stmt1->execute();
    $stmt1->close();
    $conn->close();
    echo "<script type='text/javascript'>
          window.location.href = 'action_plans/".$scorecard_id."';
          </script>";

  }


  function savePlan($employee_id, $scorecard_id,$reason,$description){
    $conn=dbconnect();

    $stmt1 = $conn->prepare("INSERT INTO bsc_pep (employee_id, scorecard_id,reason,description) VALUES (?,?,?,?)");
    $stmt1->bind_param('iss', $employee_id, $scorecard_id,$reason,$description);
    $stmt1->execute();
    $stmt1->close();
    $conn->close();
    echo "<script type='text/javascript'>
          window.location.href = 'pep/".$scorecard_id."';
          </script>";

  }

  function getPriorityGoals(){                
    $conn=dbconnect();
    $count=1;
    $stmt=$conn->prepare("SELECT id, points,goal, description FROM bsc_strategy_priorities WHERE client_id=? ORDER BY points DESC");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id,$points,$goal,$description);
    While($stmt->fetch()){ 

echo'      <div class="col-lg-4">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>'.$goal.'</h5>
                        </div>
                        <div class="ibox-content">

                            <p align="justify">
                            '.substr($description,0,200).'...
                            </p>
                            <div>
                                 <div class="progress progress-mini">
                                    <div style="width: 100%;" class="progress-bar"></div>
                                </div>
                            </div>
                            <div class="row  m-t-sm">
                                <div class="col-sm-6">
                                    <div class="font-bold">RANKING</div>
                                   '.$count.'
                                </div>
                                <div class="col-sm-6 text-right">
                                     <button type="button" class="btn btn-success m-r-sm">'.$points.'</button> <span>Points</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>';
                $count++;
     }
    $stmt->close();
    $conn->close();

  }

  function addPriority($client_id,$goal,$points,$description){
    $conn=dbconnect();
    $stmt1 = $conn->prepare("INSERT INTO bsc_strategy_priorities (client_id, goal, points, description) VALUES (?,?,?,?)");
    $stmt1->bind_param('isss',$client_id,$goal,$points,$description);
    $stmt1->execute();
    $stmt1->close();
    $conn->close();
  }

  function countBusinessUnits(){
  $conn=dbconnect();

    $stmt1 = $conn->prepare("SELECT COUNT(id) FROM bsc_business_units WHERE client_id=?");
    $stmt1->bind_param('i',$_SESSION['client_id']);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();
    $stmt1->close();
    $conn->close();
    return $count;
}

  function getCalendarEvents(){
  $conn=dbconnect();

    // $stmt1 = $conn->prepare("SELECT id, level_id, event, start_date, end_date, description, date FROM events WHERE client_id=?");
    // $stmt1->bind_param('i',$_SESSION['client_id']);
    // $stmt1->execute();
    // $stmt1->store_result();
    // $stmt1->bind_result($id, $level_id, $event, $start_date, $end_date, $description, $date);    
    // While($stmt1->fetch()){ 
      ?>

              {
                    title: 'Birthday Party',
                    start: new Date(y, m, d+1, 19, 0),
                    end: new Date(y, m, d+1, 22, 30),
                    allDay: false
                },
        
 <!-- <div class="modal inmodal fade" id="event<?php// echo $id; ?>" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Add new Perpective</h4>
                                        </div>
                                        <div class="modal-body">
                                        <input type="hidden" name="client_id" id="client_id" value="<?php //echo $_SESSION['client_id']; ?>">
                                    <label>Event</label>
                                   <input type="text" id="event<?php //echo $id; ?>" class="form-control">
                                   <label>Start Date</label>
                                   <input type="text" id="start_date<?php //echo $id; ?>" class="form-control">
                                   <label>End Date</label>
                                   <input type="text" id="end_date<?php //echo $id; ?>" class="form-control">
                                   <label>Description</label>
                                   <textarea class="form-control" rows="5" id="description<?php //echo $id; ?>"></textarea>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class=" update_table btn btn-outline-primary" data-dismiss="modal">Done</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
 -->

  <?php
//  }
 //    $stmt1->close();
 //    $conn->close();
}

function test(){ 
$conn=dbconnect();
    $stmt1 = $conn->prepare("SELECT id, level_id, event, start_date, end_date, description, date FROM bsc_events WHERE client_id=?");
    $stmt1->bind_param('i',$_SESSION['client_id']);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($id, $level_id, $event, $start_date, $end_date, $description, $date); 
    While($stmt1->fetch()){ 
?>


          {
                    title: '<?php echo $event; ?>',
                    start: '<?php echo $start_date; ?>',
                    end: '<?php echo $end_date; ?>',
                    allDay: false
                },
      
<?php }
   $stmt1->close();
   $conn->close();
}

function addEvent($client_id,$level_id,$event,$start_date,$end_date,$description){
  $conn=dbconnect();

     $stmt1 = $conn->prepare("INSERT INTO bsc_events (client_id, level_id, event, start_date, end_date, description) VALUES (?,?,?,?,?,?)");
    $stmt1->bind_param('isssss',$client_id,$level_id,$event,$start_date,$end_date,$description);
    $stmt1->execute();
    $stmt1->close();
    $conn->close();

}

    function getEvents(){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT id, event, start_date, end_date, description, level_id FROM  bsc_events WHERE client_id=? ORDER by date DESC");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $event, $start_date, $end_date, $description, $level_id);
    while($stmt->fetch()){

      echo '<tr>
        <td>'.$event.'</td>
        <td>'.$start_date.'</td>
        <td>'.$end_date.'</td>
        <td>'.substr($description,0,100).'</td>
        <td>'.getAccountTypeName($level_id).'s</td>
        <td>action</td>';
      }
      $stmt->close();
      $conn->close();
    }

    function updateCustodian($custodian,$scorecard_id){
  $conn=dbconnect();
  $stmt=$conn->prepare("UPDATE bsc_scorecards SET owner=? WHERE id=?");
  $stmt->bind_param('ii',$custodian,$scorecard_id);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}

    function updateAssigned($assigned,$task_id){
  $conn=dbconnect();
  $stmt=$conn->prepare("UPDATE bsc_project_tasks SET assigned=? WHERE id=?");
  $stmt->bind_param('ii',$assigned,$task_id);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}

    function updateDueDate($date,$task_id){
  $conn=dbconnect();
  $stmt=$conn->prepare("UPDATE bsc_project_tasks SET due_date=? WHERE id=?");
  $stmt->bind_param('si',$date,$task_id);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}
    function updateCompletion($completion,$task_id){
  $conn=dbconnect();
  $stmt=$conn->prepare("UPDATE bsc_project_tasks SET completion=? WHERE id=?");
  $stmt->bind_param('ii',$completion,$task_id);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}

function achieveCard($project_id){
  $conn=dbconnect();
  $stmt=$conn->prepare("UPDATE bsc_projects SET status=? WHERE id=?");
  $stmt->bind_param('ii',$status,$project_id);
  $status=4;
  $stmt->execute();
  $stmt->close();
  $conn->close();
}

function restoreCard($project_id){
  $conn=dbconnect();
  $stmt=$conn->prepare("UPDATE bsc_projects SET status=? WHERE id=?");
  $stmt->bind_param('ii',$status,$project_id);
  $status=1;
  $stmt->execute();
  $stmt->close();
  $conn->close();
}


  function deleteScorecard($scorecard_id){
    $conn=dbconnect();
    $stmt=$conn->prepare("DELETE FROM bsc_scorecards WHERE id=?");
    $stmt->bind_param('i',$scorecard_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

     echo "<script type='text/javascript'>
          window.location.href = 'myscorecards?deletesuccess=true';
          </script>";
  
  }
  
    function deleteBusinessUnit($business_unit_id){
    $conn=dbconnect();
    $stmt=$conn->prepare("DELETE FROM bsc_business_units WHERE id=?");
    $stmt->bind_param('i',$business_unit_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

     echo "<script type='text/javascript'>
          window.location.href = 'business-units';
          </script>";
  
  }


     function getSMPerspectives(){

    $conn = dbconnect();
    $zlatan='';
    $stmt = $conn->prepare("SELECT perspective_id, description FROM bsc_client_perspectives LEFT JOIN bsc_perspectives ON bsc_perspectives.id=perspective_id WHERE client_id=? ORDER BY perspective_id ASC");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($perspective_id,$description);
    while($stmt->fetch()){

      echo'[{'.$perspective_id.'}'.getPerspectiveName($perspective_id).']';
      ?>
    <br>
    <?php
    }
    //echo $zlatan;
    $stmt->close();
    $conn->close();

  }

       function getSMPerspectives2($perspective_id){

    $conn = dbconnect();  
    $scorecard_id=getCoporateScorecard($_SESSION['client_id']); ?>
   
           {<?php echo $perspective_id; ?>}:
  Layout:
   

  <?php    
    $nyasha='';  
    $stmt1 = $conn->prepare("SELECT bsc_goals.id FROM bsc_goals LEFT JOIN bsc_scorecards ON bsc_goals.scorecard_id=bsc_scorecards.id WHERE scorecard_id=? AND perspective_id=?");
    $stmt1->bind_param('ii',$scorecard_id,$perspective_id);
  
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($goal_id);
    while($stmt1->fetch()){ 

      $nyasha.='['.getgoalName($goal_id).']';

 ?>
 <?php  }
 echo $nyasha;
    $stmt1->close();
?>

Relate:
<?php
    $stmt1 = $conn->prepare("SELECT goal, driver, strength FROM bsc_strategy_map WHERE scorecard_id=? AND perspective_id=?");
    $stmt1->bind_param('ii',$scorecard_id,$perspective_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($goal, $driver,$strength);
    while($stmt1->fetch()){

    $stmt = $conn->prepare("SELECT perspective_id FROM bsc_goals WHERE id =? ");
    $stmt->bind_param('i',$driver);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($perspective);
    $stmt->fetch();
    
    $strength=7;

    if($strength >=0.5){
      $strength='S';
    }else{
       $strength='W';
    }

    if($perspective!=$perspective_id){
     echo'
      ['.getgoalName($goal).']<-['.getPerspectiveName($perspective).'.'.getgoalName($driver).'] " ":"'.$strength.'":" "';
    }else{
      echo'
      ['.getgoalName($goal).']<-['.getgoalName($driver).'] " ":"'.$strength.'":" "';
    }
   
  $stmt->close();
}
  $stmt1->close();
  $conn->close();

  }

       function listPerspectives(){

    $conn = dbconnect();

    $stmt1 = $conn->prepare("SELECT perspective_id FROM bsc_client_perspectives WHERE client_id=?");
    $stmt1->bind_param('i',$_SESSION['client_id']);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($perspective_id);
    while($stmt1->fetch()){
      echo '<option value="'.$perspective_id.'">'.getPerspectiveName($perspective_id).'</option>';
    
       }
    $stmt1->close();
    $conn->close();

  }


       function getMappingGoals($scorecard_id,$perspective_id){

    $conn = dbconnect();

    $stmt1 = $conn->prepare("SELECT id FROM bsc_goals WHERE scorecard_id=? AND perspective_id=?");
    $stmt1->bind_param('ii',$scorecard_id,$perspective_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($goal_id);
    while($stmt1->fetch()){
      echo '<option value="'.$goal_id.'">'.getGoalName($goal_id).'</option>';
    
       }
    $stmt1->close();
    $conn->close();

  }

  function  addLinkGoals($scorecard_id,$perspective_id,$goal_id,$driver){
        $conn = dbconnect();

    //add admin
    $stmt = $conn->prepare("INSERT INTO bsc_strategy_map (scorecard_id, perspective_id, goal, driver) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss',$scorecard_id,$perspective_id,$goal_id,$driver);
    $stmt->execute();
    $stmt->close();
    $conn->close();

     echo "<script type='text/javascript'>
          window.location.href = 'strategy?success=true';
          </script>";

  }

    function getCorrelationRows($scorecard_id){
   $conn=dbconnect(); 
  
    $conn=dbconnect();
    $stmt = $conn->prepare("SELECT start, reporting_period FROM bsc_scorecards WHERE id=?");
    $stmt->bind_param('i',$scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($start_period,$reporting_period);
    $stmt->fetch();
    $stmt->close();
   
        $start = strtotime($start_period);
        $end = strtotime($reporting_period);
        while($start < $end)
        {
            $month = date('F', $start);
            //echo '"'.$month.'",';
             echo'<th data-toggle="tooltip"  data-placement="top" title="'.$month.'">'.$month.'</th>';
             $start = strtotime("+1 month", $start);
        }
  
  echo' </tr>
        </tr>
        </thead>
        <tbody id="table_business_units">';

    $stmt = $conn->prepare("SELECT id, goal FROM bsc_goals WHERE scorecard_id=? ORDER BY id ASC");
    $stmt->bind_param('i',$scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($goal_id1, $goal1);
    while($stmt->fetch()){

// $words1 = explode(" ", $goal1);
// $letters1 = "";
// foreach ($words1 as $value1) {
//     $letters1 .= substr($value1, 0, 1);
// }
if(is_numeric(getGoalWR($goal_id1))){
    echo'<tr><td></td><td data-toggle="popover" data-placement="top" data-content="'.$goal1.'">'.$goal1.'</td>';
 }

        $start = strtotime($start_period);
        $end = strtotime($reporting_period);
        while($start < $end)
        {
            $month = date('Y-m', $start);
            echo'<td>'.round(getFilteredGoalWR($goal_id1,$month),2).'</td>';
             $start = strtotime("+1 month", $start);
        }
 
    echo'</tr>';
    }
      
$stmt->close();
$conn->close();
  }
  
  function correlationCoefficient($X, $Y, $n) { 
    $sum_X = 0;$sum_Y = 0; $sum_XY = 0; 
    $squareSum_X = 0; $squareSum_Y = 0; 
    $n = 3;
    for ($i = 0; $i < $n; $i++) 
    { 
        // sum of elements of array X. 
        $sum_X = $sum_X + $X[$i]; 
  
        // sum of elements of array Y. 
        $sum_Y = $sum_Y + $Y[$i]; 
  
        // sum of X[i] * Y[i]. 
        $sum_XY = $sum_XY + $X[$i] * $Y[$i]; 
  
        // sum of square of array elements. 
        $squareSum_X = $squareSum_X +  
                       $X[$i] * $X[$i]; 
        $squareSum_Y = $squareSum_Y +  
                       $Y[$i] * $Y[$i]; 
    } 
  
    // use formula for calculating correlation coefficient. 
    $corr = (float)($n * $sum_XY - $sum_X * $sum_Y) /  
         sqrt(($n * $squareSum_X - $sum_X * $sum_X) *  
              ($n * $squareSum_Y - $sum_Y * $sum_Y)); 

    if(is_nan($corr)==0){
      return round($corr,2);  
    }else{
      return 0;
    }
   
} 


    function getCorrelationRows2($scorecard_id){
  $conn=dbconnect(); 
  //$scorecard_id=getCoporateScorecard($_SESSION['client_id']);

    $stmt = $conn->prepare("SELECT id, goal FROM bsc_goals WHERE scorecard_id=? ORDER BY id ASC");
    $stmt->bind_param('i',$scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($goal_id,$goal);
    while($stmt->fetch()){

$words = explode(" ", $goal);
$letters = "";
foreach ($words as $value) {
    $letters .= substr($value, 0, 1);
}
if(is_numeric(getGoalWR($goal_id))){
      echo'<th data-toggle="tooltip"  data-placement="top" title="'.$goal.'">'.$goal.'</th>';
  }
    }
  $stmt->close();
  echo' </tr>
        </tr>
        </thead>
        <tbody id="table_business_units">';

    $stmt = $conn->prepare("SELECT id, goal FROM bsc_goals WHERE scorecard_id=? ORDER BY id ASC");
    $stmt->bind_param('i',$scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($goal_id1, $goal1);
    while($stmt->fetch()){

$words = explode(" ", $goal1);
$letters = "";
foreach ($words as $value) {
    $letters .= substr($value, 0, 1);
}
//if(is_numeric(getWeightedRating($measure_id1))){
    echo'<tr><td></td><td data-toggle="popover" data-placement="top" data-content="'.$goal1.'">'.$goal1.'</td>';
//}
    $stmt1 = $conn->prepare("SELECT start, reporting_period FROM bsc_scorecards WHERE id=?");
    $stmt1->bind_param('i',$scorecard_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($start_period,$reporting_period);
    $stmt1->fetch();
    $stmt1->close();
   
        $start = strtotime($start_period);
        $end = strtotime($reporting_period);
        $arrX = array();
     
        while($start < $end)
        {
          $month = date('Y-m', $start);
          $X = round(getFilteredGoalWR($goal_id1,$month),2);
          $start = strtotime("+1 month", $start);
          array_push($arrX, $X);
        }
     $n = sizeof($arrX);

    $stmt1 = $conn->prepare("SELECT id, goal FROM bsc_goals WHERE scorecard_id=? ORDER BY id ASC");
    $stmt1->bind_param('i',$scorecard_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($goal_id2, $goal2);
    while($stmt1->fetch()){
        
        $start = strtotime($start_period);
        $end = strtotime($reporting_period);
        $arrY = array();
     
        while($start < $end)
        {
          $month = date('Y-m', $start);
          $Y = round(getFilteredGoalWR($goal_id2,$month),2);
          $start = strtotime("+1 month", $start);

          array_push($arrY, $Y);
        }
    
       
     echo'<td>'.correlationCoefficient($arrX, $arrY, $n).'</td>';
  //}
    }
    $stmt1->close();
  
    echo'</tr>';
    }
      
$stmt->close();
$conn->close();
  }

function getMeasureType($measure_id){
    $conn=dbconnect();

    $stmt=$conn->prepare("SELECT measure_type FROM bsc_targets WHERE id=?");
    $stmt->bind_param('i',$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($measure_type);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $measure_type;
  }

  function checkScorecardLock(){
    $conn=dbconnect();

    $stmt=$conn->prepare("SELECT status FROM bsc_scorecard_settings WHERE client_id=?");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $status;
}

function lockScorecards($lock){
    $conn=dbconnect();

if($_SESSION['account_type']==1){
    $stmt1=$conn->prepare("SELECT COUNT(id) FROM bsc_scorecard_settings WHERE client_id=?");
    $stmt1->bind_param('i',$_SESSION['client_id']);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();

    if($count>0){
    $stmt=$conn->prepare("UPDATE bsc_scorecard_settings SET status=? WHERE client_id=?");
    $stmt->bind_param('ii',$lock,$_SESSION['client_id']);
    $stmt->execute();
    $stmt->close();

  }else{
    $stmt=$conn->prepare("INSERT INTO bsc_scorecard_settings (client_id, status) VALUES (?,?)");
    $stmt->bind_param('ii',$_SESSION['client_id'],$lock);
    $stmt->execute();
    $stmt->close();

  }
}

if($_SESSION['account_type']==3){
    $stmt1=$conn->prepare("SELECT COUNT(id) FROM bsc_scorecard_settings2 WHERE client_id=? AND department_id=?");
    $stmt1->bind_param('ii',$_SESSION['client_id'],$_SESSION['department_id']);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();

    if($count>0){
    $stmt=$conn->prepare("UPDATE bsc_scorecard_settings2 SET status=? WHERE client_id=? AND department_id=?");
    $stmt->bind_param('iii',$lock,$_SESSION['client_id'],$_SESSION['department_id']);
    $stmt->execute();
    $stmt->close();

  }else{
    $stmt=$conn->prepare("INSERT INTO bsc_scorecard_settings2 (client_id, department_id, status) VALUES (?,?,?)");
    $stmt->bind_param('iii',$_SESSION['client_id'],$_SESSION['department_id'],$lock);
    $stmt->execute();
    $stmt->close();

  }
}

else{
    $stmt=$conn->prepare("UPDATE bsc_scorecards SET lock1=? WHERE owner=?");
    $stmt->bind_param('ii',$lock,$_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
}
      $stmt1->close();
      $conn->close();
  }




 function getClientLocks(){
    $conn=dbconnect();

    if($_SESSION['account_type']==1){
    $stmt=$conn->prepare("SELECT status FROM bsc_scorecard_settings WHERE client_id=?");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($lock);
    $stmt->fetch();
  }

  elseif($_SESSION['account_type']==3){

    $stmt=$conn->prepare("SELECT status FROM bsc_scorecard_settings2 WHERE client_id=? AND department_id=?");
    $stmt->bind_param('ii',$_SESSION['client_id'],$_SESSION['department_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($lock);
    $stmt->fetch();
  }

    else{
    $stmt=$conn->prepare("SELECT lock1 FROM bsc_scorecards WHERE owner=?");
    $stmt->bind_param('i',$_SESSION['user_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($lock);
    $stmt->fetch();
    }
      if($lock==1){
        echo'<input type="checkbox" onChange="lockScorecards(0)" value="checked" class="js-switch" checked />';
      }else{
        echo'<input type="checkbox" onChange="lockScorecards(1)" class="js-switch" />';
      }

    $stmt->close();
    $conn->close();
  }


     function getScorecardsSettings(){
    $conn=dbconnect();

    $stmt=$conn->prepare("SELECT COUNT(id) FROM bsc_scorecard_settings WHERE client_id=?");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    if($count<1){
      $lock= 0;
    }
else{
    $stmt=$conn->prepare("SELECT status FROM bsc_scorecard_settings WHERE client_id=?");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($lock);
    $stmt->fetch();
    $stmt->close();
  }

    $conn->close();

    return $lock;
  }


function getLockedTable(){

  $table = '<table class=" table table-bordered" width="100%" id="myTable">
              <thead>
                <tr>
    <th style="width:6%"><font color="#175ea8"><b>Perspective</b></font></th>
    <th style="width:20%" data-toggle="popover" data-placement="top" data-content="What you actually Want to achieve"><font color="#175ea8"><b>Goal</b></font></th>
    <th style="width:20%" data-toggle="popover" data-placement="top" data-content="Measure of Success"><font color="#175ea8"><b>Measure</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Unit of measurement"><font color="#175ea8"><b>Unit</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Reporting Frequency"><font color="#175ea8"><b>RF</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Target Period"><font color="#175ea8"><b>TP</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Base Target (minimum expected)"><font color="#175ea8"><b>BT</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Stretch target (maximum expected)"><font color="#175ea8" ><b>ST</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Actual Achievement"><font color="#175ea8"><b>Actual</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content=Allocated Weight."><font color="#175ea8"><b>AW</b> </font> </th>  
    <th data-toggle="popover" data-placement="top" data-content="Weighted Rating (automatically Calculated)"><font color="#175ea8"><b>WR</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Trend Indicator (time to time performance Indicator)"><font color="#175ea8"><b>TI</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Specific Comment for this measure"><font color="#175ea8"><b>Comment</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Action plans for task oriented measures."><font color="#175ea8"><b>AP</b></font></th>
                      </tr>
                </thead>
                <tbody>';

   $conn = dbconnect();

    $scorecard_id = test_input($_GET['scorecard']);

    //get the perspectives
    $stmt = $conn->prepare("SELECT perspective_id FROM bsc_client_perspectives WHERE client_id=?");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($perspective_id);
    while($stmt->fetch()){
  
      //get count of measures in selected perspective
      $stmt1 = $conn->prepare("SELECT COUNT(bsc_targets.id) AS total_measures FROM bsc_targets INNER JOIN bsc_goals ON bsc_targets.goal_id = bsc_goals.id WHERE bsc_goals.scorecard_id = ? AND bsc_goals.perspective_id = ?");
      $stmt1 ->bind_param('ii', $scorecard_id, $perspective_id);
      $stmt1->execute();
      $stmt1->store_result();
      $stmt1->bind_result($total_measures);
      $stmt1->fetch();
      $stmt1->close();

      //check if there are no measures
      if($total_measures == 0){

        //get total goals in selected perspective for the goal
        $stmt2 = $conn->prepare("SELECT COUNT(*) AS total_goals FROM bsc_goals WHERE scorecard_id = ? AND perspective_id = ?");
        $stmt2 ->bind_param('ii', $scorecard_id, $perspective_id);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($total_goals);
        $stmt2->fetch();
        $stmt2->close();

        //check if goals are available
        if($total_goals == 0){

          //add the perspective in table row
          $table .= '<tr><td rowspan="2">'.getPerspectiveName($perspective_id).'</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          </tr>';
           $table.='
             <tr>
             <td></td>
              <td colspan="6"></td>
              <td><font color="blue">Total</font></td>
              <td></td>         
              <td></td>
              
              </tr>
            ';

        }else{

          //add the perspective in table row
          $table .= '<tr><td rowspan="'.$total_goals.'">'.getPerspectiveName($perspective_id).'</td>';

          //get the goals for selected perspective
          $stmt1 = $conn->prepare("SELECT id, scorecard_id, goal FROM bsc_goals WHERE scorecard_id = ? AND perspective_id = ?");
          $stmt1 ->bind_param('ii', $scorecard_id, $perspective_id);
          $stmt1->execute();
          $stmt1->store_result();
          $stmt1->bind_result($id, $scorecard_id, $goal);
          while($stmt1->fetch()){

            //add the goal in table row
            $table .= '<td rowspan="1"><p data-toggle="modal" data-target="#goal'.$id.'">'.$goal.'
</p></td>      
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
            </tr>';
            $table.='
             <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
              <td ><font color="blue">Total</font></td>         
              <td ><font color="blue">empty</font></td>
              <td></td>
              
              </tr>
            ';

              echo '<!-- Modal -->
          <div class="modal fade" id="goal'.$id.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">view Goal </h4>
                </div>
                <div class="modal-body" >
                              <div class="row" >
                    <div class="col-lg-12">
                      <div class="form-group">
                        <textarea rows="4" cols="5" name="goal" readonly>'.$goal.'</textarea>
                        <br/><br/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
              
            </div>
          </div>';

              
          }
          $stmt1->close();

        }

      }else{

        //add the perspective in table row
        $total_measures = $total_measures+1;
        $table .= '<div id="div"><tr><td rowspan="'.$total_measures.'">'.getPerspectiveName($perspective_id).'</td>';

        //get the goals for selected perspective
        $stmt1 = $conn->prepare("SELECT id, goal FROM bsc_goals WHERE scorecard_id = ? AND perspective_id = ?");
        $stmt1 ->bind_param('ii', $scorecard_id, $perspective_id);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($id, $goal);
        while($stmt1->fetch()){

          //get total measures in selected perspective for the goal
          $stmt2 = $conn->prepare("SELECT COUNT(bsc_targets.id) AS total_measures FROM bsc_targets INNER JOIN bsc_goals ON bsc_targets.goal_id = bsc_goals.id WHERE bsc_goals.scorecard_id = ? AND bsc_goals.perspective_id = ? AND bsc_goals.id = ?");
          $stmt2 ->bind_param('iii', $scorecard_id, $perspective_id, $id);
          $stmt2->execute();
          $stmt2->store_result();
          $stmt2->bind_result($total_goal_measures);
          $stmt2->fetch();
          $stmt2->close();

          //add the goal in table row
          $table .= '<td rowspan="'.$total_goal_measures.'"><p data-toggle="modal" data-target="#goal'.$id.'">'.$goal.'
</p></td>';

          //counter for the rowspan
          $counter_goals = 0;

          //get measures for the goal
          $stmt2 = $conn->prepare("SELECT bsc_targets.id, measure, measure_type, unit, reporting_frequency, target_period, base_target, stretch_target, actual ,allocated_weight,trend_indicator FROM bsc_targets WHERE goal_id = ?");
          $stmt2 ->bind_param('i', $id);
          $stmt2->execute();
          $stmt2->store_result();
          $stmt2->bind_result($measure_id, $measure, $measure_type, $unit, $reporting_frequency, $target_period, $base_target, $stretch_target, $actual, $allocated_weight,$trend_indicator);
          while($stmt2->fetch()){
            if($counter_goals == 0){
                $table .=  '<form action="../grades.php" method="post" name="myform"><td>';
               if(strlen($measure)>0){
             $table.='<p data-toggle="modal" data-target="#measure'.$measure_id.'">'.$measure.'</p>';
              } else{
                $table.='<i class="fa fa-pencil-square-o" aria-hidden="true" style="color:#175ae8;" data-toggle="modal" data-target="#measure'.$measure_id.'">measure</i>';
              }         
     $table.='</td>
              <td><input type="text" hidden name="scorecard_id" value="'.$_GET['scorecard'].'">
              <input type="text" hidden name="measure_id" value="'.$measure_id.'">
              <input type="text" hidden name="goal_id" value="'.$id.'">
              <select id="unit'.$measure_id.'" name="unit"><option>'.$unit.'</option></select></td>
              <td><select id="reporting_frequency'.$measure_id.'" style="border-color: #175ae8;" name="reporting_frequency"><option>'.$reporting_frequency.'</option></select></td>
              <td><select id="target_period'.$measure_id.'" name="target_period"><option>'.$target_period.'</option></select></td>';
              if(getMeasureType($measure_id)>0){

              $table.=' <td data-toggle="popover" data-placement="top" data-content="Driven from action plans list"><input type="number" id="base_target'.$measure_id.'" name="base_target" step="any" style="width: 5em" value="'.$base_target.'" readonly></td>
              <td><input type="number" id="stretch_target'.$measure_id.'" name="stretch_target" step="any" style="width: 5em" value="'.$stretch_target.'" readonly></td>
               
             <td data-toggle="popover" data-placement="top" data-content="Driven from action plans list" data-title="'.getActualTooltip($measure_id).'"><p data-toggle="modal" data-target="#action_plans'.$measure_id.'"> <input type="number" name="actual" style="width: 5em" step="any" value="'.$actual.'" readonly id="actual'.$measure_id.'"></p></td>';

              }else{
    $table.=' <td><input type="number" id="base_target'.$measure_id.'" name="base_target" step="any" style="width: 5em" value="'.$base_target.'" readonly></td>
              <td><input type="number" id="stretch_target'.$measure_id.'" name="stretch_target" step="any" style="width: 5em" value="'.$stretch_target.'" readonly></td>';
               if(getReportingFrequency($measure_id)=='Y'){
               $table.='<td  data-title="'.getActualTooltip($measure_id).'"><input id="actual'.$measure_id.'" type="number" step="any" name="actual" style="width: 5em" value="'.$actual.'" onfocusout="saverow('.$measure_id.');"></td>';
              }else{
             $table.='<td data-title="'.getActualTooltip($measure_id).'"><p data-toggle="modal" data-target="#select'.$measure_id.'"> <input type="number" name="actual" style="width: 5em" step="any" value="'.$actual.'" readonly id="actual'.$measure_id.'"></p></td>';
              }
            }
          $table.='<td><input id="allocated_weight'.$measure_id.'" type="number" name="allocated_weight" style="width: 3em" max="100" min="1" value="'.$allocated_weight.'" readonly></td>';
             if(getWeightedRating($measure_id)<0){
              $table.='<td><p id="wr'.$measure_id.'"><font color="#FF0000">'.getWeightedRating($measure_id).'%</font></p></td>'; 
              }
        
               elseif(getWeightedRating($measure_id)==0 AND strlen($actual) >0){
              $table.='<td><p id="wr'.$measure_id.'"><font color="green">'.getWeightedRating($measure_id).'%</font></p></td>';
            }
                   elseif(getWeightedRating($measure_id)==""){
              $table.='<td></td>';
            }
             
              else{
               $table.='<td><p id="wr'.$measure_id.'"><font color="green">'.getWeightedRating($measure_id).'%</font></p></td>';
            }
          $table.=getTrendIndicator($measure_id);
       $table.='<td><button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#comment'.$measure_id.'"><i class="fa fa-commenting-o" aria-hidden="true"></i> <font color="#175ea8"><b>'.countComments($measure_id).'</b></font>
</i></button></td>
 </form>';
           $table.='
              </tr>';

              $counter_goals++;
            }else{
              $table .=  '<form action="../grades.php" method="post" name="myform"><tr><td>';
                 if(strlen($measure)>0){
             $table.='<p data-toggle="modal" data-target="#measure'.$measure_id.'">'.$measure.'
            </p>';
              } else{
                $table.='<td><i class="fa fa-pencil-square-o" aria-hidden="true" style="color:#175ae8;" data-toggle="modal" data-target="#measure'.$measure_id.'">measure</i>';
              }
//straightfromscorecard
     $table.='</td>
              <td><input type="text" hidden name="scorecard_id" value="'.$_GET['scorecard'].'"><input type="text" hidden name="measure_id" value="'.$measure_id.'"><input type="text" hidden name="goal_id" value="'.$id.'">
              <select name="unit" id="unit'.$measure_id.'" onChange="saverow('.$measure_id.');"><option>'.$unit.'</option></select></td>
              <td><select id="reporting_frequency'.$measure_id.'" name="reporting_frequency" onChange="saverow('.$measure_id.');"><option>'.$reporting_frequency.'</option></select></td>
              <td><select name="target_period" id="target_period'.$measure_id.'"><option>'.$target_period.'</option></select></td>';

       if(getMeasureType($measure_id)>0){

              $table.=' <td data-toggle="popover" data-placement="top" data-content="Driven from action plans list"><input type="number" id="base_target'.$measure_id.'" name="base_target" step="any" style="width: 5em" value="'.$base_target.'" readonly></td>
              <td data-toggle="popover" data-placement="top" data-content="Driven from action plans list"><input type="number" id="stretch_target'.$measure_id.'" name="stretch_target" step="any" style="width: 5em" value="'.$stretch_target.'" readonly></td>
               
             <td data-title="'.getActualTooltip($measure_id).'"><p data-toggle="modal" data-target="#action_plans'.$measure_id.'"> <input type="number" name="actual" style="width: 5em" step="any" value="'.$actual.'" readonly id="actual'.$measure_id.'"></p></td>';

              }else{
    $table.=' <td><input type="number" id="base_target'.$measure_id.'" name="base_target" step="any" style="width: 5em" value="'.$base_target.'" readonly></td>
              <td><input type="number" id="stretch_target'.$measure_id.'" name="stretch_target" step="any" style="width: 5em" value="'.$stretch_target.'" readonly></td>';
               if(getReportingFrequency($measure_id)=='Y'){
               $table.='<td  data-title="'.getActualTooltip($measure_id).'"><input id="actual'.$measure_id.'" type="number" step="any" name="actual" style="width: 5em" value="'.$actual.'" onfocusout="saverow('.$measure_id.');"></td>';
              }else{
             $table.='<td data-title="'.getActualTooltip($measure_id).'"><p data-toggle="modal" data-target="#select'.$measure_id.'"> <input type="number" name="actual" style="width: 5em" step="any" value="'.$actual.'" readonly id="actual'.$measure_id.'"></p></td>';
              }
            }
            
     $table.='<td><input id="allocated_weight'.$measure_id.'" type="number" name="allocated_weight" style="width: 3em" max="100" min="1" value="'.$allocated_weight.'" readonly></td>';
             if(getWeightedRating($measure_id)<0){
              $table.='<td><p data-toggle="modal" data-target="#chart'.$id.'" id="wr'.$measure_id.'"><font color="#FF0000">'.getWeightedRating($measure_id).'%</font></p></td>'; 
              }
                 elseif(getWeightedRating($measure_id)==0 AND strlen($actual) >0){
              $table.='<td><p id="wr'.$measure_id.'"><font color="green">'.getWeightedRating($measure_id).'%</font></p></td>';
            }
                   elseif(getWeightedRating($measure_id)==""){
              $table.='<td></td>';
            }
              else{
              $table.='<td><p data-toggle="modal" data-target="#chart'.$id.'" id="wr'.$measure_id.'"><font color="green">'.getWeightedRating($measure_id).'%</font></p></td>';
            }
         $table.=getTrendIndicator($measure_id);
  $table.='</select></td><td><button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#comment'.$measure_id.'"><i class="fa fa-commenting-o" aria-hidden="true"></i> <font color="#175ea8"><b>'.countComments($measure_id).'</b></font>
</i></button></td>
</form>';

$table.='   
              </tr></div>
              ';
              $counter_goals++;
            }

                 
      echo' <div class="modal inmodal fade" id="action_plans'.$measure_id.'" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4>Tasks Involved to achieve this.</h4>
                                    
                         <div class="modal-body">
                        <div class="row" id="add_to_me'.$measure_id.'">
                        <ul class="todo-list m-t small-list" style="text-align: left;" id="add_to'.$measure_id.'">';
                          getMeasureTasks($measure_id);
                 echo'           </ul>
                        </div><br>
                     <div class="row" id="button'.$measure_id.'">
                     <button class="btn btn-primary btn-sm" onclick="addCode('.$measure_id.')">Add Check List</button>
                         </div>

                         <form id="uploadForm" action="upload.php" method="post">
                         <input name="evidence" type="file" class="inputFile" />
                           <p id="warning'.$measure_id.'" style="color: red;"></p>   
                               </div>
                              
                <div class="modal-footer">
                                          
           
                  <button type="submit" onClick="location.reload();" class="btn btn-primary" data-dismiss="modal">Done</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                             </div>
';
         
 echo '<!-- Modal -->
          <div class="modal fade bd-example-modal-lg" id="comment'.$measure_id.'" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Add Comments </h4>
                </div>
                <div class="modal-body">';

                     getIndividualComments($measure_id);
                        
                    echo'<div class="row">
                          <div class="col-1"></div>
                          <div class="media-body col-11" style="text-align: right;" id="newcomment'.$measure_id.'">
                            
                            </div>
                          </div>
                       <br> <textarea class="form-control" id="mycomment'.$measure_id.'" placeholder="Write comment..."></textarea><br>
                               
                                <div class="form-group" align="right">
                                    <button type="button" onclick="saveComment('.$scorecard_id.','.$measure_id.')" class="btn btn-primary"><i class="fa fa-send"></i> Send</button>
                                </div>

                    
                   
                  <div class="form-group" align="right">
                 
                    <button type="button" class="btn btn-outline-secondary" style="width: 100%" data-dismiss="modal">Close</button>
                  </div>
              
                </div>
              </div>
              
            </div>
          </div>';
                 
           
             
          
     echo '<!-- Modal -->
          <div class="modal fade" id="goal'.$id.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">View Goal </h4>
                </div>
                <div class="modal-body" >

                  <div class="row" >
                    <div class="col-lg-12">
                      <div class="form-group">

                        <textarea rows="4" cols="5" name="goal" readonly class="form-control">'.$goal.'</textarea>
                        <br/><br/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">

                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
              
                </div>
              </div>
              
            </div>
          </div>';

     echo '<!-- Modal -->
          <div class="modal fade bd-example-modal-lg" id="select'.$measure_id.'" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">Actual Achievements</h4>
                </div>
                <div class="modal-body" >
                 <div class="row" >
                    <div class="col-lg-12">
                      <div id="33'.$measure_id.'" class="form-group">';


             getRevenues2($measure_id);
         
            echo'    
                    </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                      <button type="button" onClick="document.location.reload(true)" class="btn btn-success" data-dismiss="modal"><i class="fa fa-spinner" aria-hidden="true"></i>Process</button>
                  </div>
                </div>
              </div>
              
            </div>
          </div>';
          echo '<!-- Modal -->
          <div class="modal fade" id="measure'.$measure_id.'" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">View Measure </h4>
                </div>
                <div class="modal-body">

                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">

                        <textarea rows="4" cols="10" name="measure" class="form-control" readonly>'.$measure.'</textarea>
                        <br/><br/>
                      </div>
                    </div>
                   
                  </div>
                  <div class="form-group" align="right">
                  <br/>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                
                </div>
              </div>
              
            </div>
          </div>';
    
          }
          $stmt2->close();

        }
         $table.=' 
             <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
             <td><font color="blue">Total</font></td>
             <td ><font color="blue">'.getPerspectiveTotalWeight($perspective_id,$scorecard_id).'</font></td>';
if (getWR($scorecard_id,$perspective_id)<0){
   $table.='<td bgcolor="#FF0000"><font color="#fff">'.getWR($scorecard_id,$perspective_id).'%</font></td>';
   }else{
    $table.='<td bgcolor="green"><font color="#fff">'.getWR($scorecard_id,$perspective_id).'%</font></td>';
   }
       $table.='  <td></td>
                  <td></td>
                  </tr>
            ';
        $stmt1->close();

      }

    }
    $stmt->close();
    
    $conn->close();

    //close table tag
    $table .= '<tr>
    <td colspan="8" align="right"><font color="#175ae8">Overall Achievement</font></td>';
    if (getOverallWeight($scorecard_id)!=100){
        $table.='<td colspan="2" align="right" bgcolor="#FF0000"><font color="#fff">'.getOverallWeight($scorecard_id).'%</font></td>';
        }else{
        $table.='<td colspan="2" align="right" bgcolor="green"><font color="#fff">'.getOverallWeight($scorecard_id).' %</font></td>';
        }
 if (getTotalWR($_GET['scorecard'])<0){
   $table.='<td bgcolor="#FF0000"><font color="#fff">'.getTotalWR($_GET['scorecard']).'%</font></td>';
   }else{
    $table.='<td bgcolor="green"><font color="#fff">'.getTotalWR($_GET['scorecard']).'%</font></td>';
   }

  $table.='  </td>
            <td></td>
            <td></td>
            </tr>
    </tbody></table>';

    echo $table;
    
  }


function getReadOnlyNestedTable(){
 
  $table = '
    <table class="table table-bordered" width="100%" id="myTable">
              <thead>
                <tr>
    <th style="width:6%"><font color="#175ea8"><b>Perspective</b></font></th>
    <th style="width:20%" data-toggle="popover" data-placement="top" data-content="What you actually Want to achieve"><font color="#175ea8"><b>Goal</b></font></th>
    <th style="width:20%" data-toggle="popover" data-placement="top" data-content="Measure of Success"><font color="#175ea8"><b>Measure</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Unit of measurement"><font color="#175ea8"><b>Unit</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Reporting Frequency"><font color="#175ea8"><b>RF</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Target Period"><font color="#175ea8"><b>TP</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Base Target (minimum expected)"><font color="#175ea8"><b>BT</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Stretch target (maximum expected)"><font color="#175ea8" ><b>ST</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Actual Achievement"><font color="#175ea8"><b>Actual</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content=Allocated Weight."><font color="#175ea8"><b>AW</b> </font> </th>  
    <th data-toggle="popover" data-placement="top" data-content="Weighted Rating (automatically Calculated)"><font color="#175ea8"><b>WR</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Trend Indicator (time to time performance Indicator)"><font color="#175ea8"><b>TI</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Specific Comment for this measure"><font color="#175ea8"><b>Comment</b></font></th>
                      </tr>
                </thead>
                <tbody>';

   $conn = dbconnect();

    $scorecard_id = test_input($_GET['scorecard']);

    //get the perspectives
    $stmt = $conn->prepare("SELECT perspective_id FROM bsc_client_perspectives WHERE client_id=?");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($perspective_id);
    while($stmt->fetch()){
  
      //get count of measures in selected perspective
      $stmt1 = $conn->prepare("SELECT COUNT(bsc_targets.id) AS total_measures FROM bsc_targets INNER JOIN bsc_goals ON bsc_targets.goal_id = bsc_goals.id WHERE bsc_goals.scorecard_id = ? AND bsc_goals.perspective_id = ?");
      $stmt1 ->bind_param('ii', $scorecard_id, $perspective_id);
      $stmt1->execute();
      $stmt1->store_result();
      $stmt1->bind_result($total_measures);
      $stmt1->fetch();
      $stmt1->close();

      //check if there are no measures
      if($total_measures == 0){

        //get total goals in selected perspective for the goal
        $stmt2 = $conn->prepare("SELECT COUNT(*) AS total_goals FROM bsc_goals WHERE scorecard_id = ? AND perspective_id = ?");
        $stmt2 ->bind_param('ii', $scorecard_id, $perspective_id);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($total_goals);
        $stmt2->fetch();
        $stmt2->close();

        //check if goals are available
        if($total_goals == 0){

          //add the perspective in table row
          $table .= '<tr><td rowspan="2">'.getPerspectiveName($perspective_id).'</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          </tr>';
           $table.='
             <tr>
             <td></td>
              <td colspan="6"></td>
              <td><font color="blue">Total</font></td>
              <td></td>         
              <td></td>
              
              </tr>
            ';

        }else{

          //add the perspective in table row
          $table .= '<tr><td rowspan="'.$total_goals.'">'.getPerspectiveName($perspective_id).'</td>';

          //get the goals for selected perspective
          $stmt1 = $conn->prepare("SELECT id, scorecard_id, goal FROM bsc_goals WHERE scorecard_id = ? AND perspective_id = ?");
          $stmt1 ->bind_param('ii', $scorecard_id, $perspective_id);
          $stmt1->execute();
          $stmt1->store_result();
          $stmt1->bind_result($id, $scorecard_id, $goal);
          while($stmt1->fetch()){

            //add the goal in table row
            $table .= '<td rowspan="1"><p data-toggle="modal" data-target="#goal'.$id.'">'.$goal.'
</p></td>      
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
            </tr>';
            $table.='
             <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
              <td ><font color="blue">Total</font></td>         
              <td ><font color="blue">empty</font></td>
              <td></td>
              
              </tr>
            ';

              echo '<!-- Modal -->
          <div class="modal fade" id="goal'.$id.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">view Goal </h4>
                </div>
                <div class="modal-body" >
                              <div class="row" >
                    <div class="col-lg-12">
                      <div class="form-group">
                        <textarea rows="4" cols="5" name="goal" readonly>'.$goal.'</textarea>
                        <br/><br/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
              
            </div>
          </div>';

              
          }
          $stmt1->close();

        }

      }else{

        //add the perspective in table row
        $total_measures = $total_measures+1;
        $table .= '<div id="div"><tr><td rowspan="'.$total_measures.'"><span id="mySpan">'.getPerspectiveName($perspective_id).'</span></td>';

        //get the goals for selected perspective
        $stmt1 = $conn->prepare("SELECT id, goal FROM bsc_goals WHERE scorecard_id = ? AND perspective_id = ?");
        $stmt1 ->bind_param('ii', $scorecard_id, $perspective_id);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($id, $goal);
        while($stmt1->fetch()){

          //get total measures in selected perspective for the goal
          $stmt2 = $conn->prepare("SELECT COUNT(bsc_targets.id) AS total_measures FROM bsc_targets INNER JOIN bsc_goals ON bsc_targets.goal_id = bsc_goals.id WHERE bsc_goals.scorecard_id = ? AND bsc_goals.perspective_id = ? AND bsc_goals.id = ?");
          $stmt2 ->bind_param('iii', $scorecard_id, $perspective_id, $id);
          $stmt2->execute();
          $stmt2->store_result();
          $stmt2->bind_result($total_goal_measures);
          $stmt2->fetch();
          $stmt2->close();

          //add the goal in table row
          $table .= '<td rowspan="'.$total_goal_measures.'"><p data-toggle="modal" data-target="#goal'.$id.'">'.$goal.'
</p></td>';

          //counter for the rowspan
          $counter_goals = 0;

          //get measures for the goal
          $stmt2 = $conn->prepare("SELECT bsc_targets.id, measure, measure_type, unit, reporting_frequency, target_period, base_target, stretch_target, actual ,allocated_weight,trend_indicator FROM bsc_targets WHERE goal_id = ?");
          $stmt2 ->bind_param('i', $id);
          $stmt2->execute();
          $stmt2->store_result();
          $stmt2->bind_result($measure_id, $measure, $measure_type, $unit, $reporting_frequency, $target_period, $base_target, $stretch_target, $actual, $allocated_weight,$trend_indicator);
          while($stmt2->fetch()){
            if($counter_goals == 0){
                $table .=  '<td>';
               if(strlen($measure)>0){
             $table.='<p data-toggle="modal" data-target="#measure'.$measure_id.'">'.$measure.'</p>';
              } else{
                $table.='<i class="fa fa-pencil-square-o" aria-hidden="true" style="color:#175ae8;" data-toggle="modal" data-target="#measure'.$measure_id.'">measure</i>';
              }         
     $table.='</td>
              <td>'.$unit.'</td>
              <td>'.$reporting_frequency.'</td>
              <td>'.$target_period.'</td>';
              if(getMeasureType($measure_id)>0){

              $table.=' <td data-toggle="popover" data-placement="top" data-content="Driven from action plans list">'.$base_target.'</td>
              <td>'.$stretch_target.'</td>
               
             <td data-toggle="popover" data-placement="top" data-content="Driven from action plans list" data-title="'.getActualTooltip($measure_id).'"><p data-toggle="modal" data-target="#action_plans'.$measure_id.'">'.$actual.'</p></td>';

              }else{
    $table.=' <td>'.$base_target.'</td>
              <td>'.$stretch_target.'</td>';
               if(getReportingFrequency($measure_id)=='Y'){
               $table.='<td  data-title="'.getActualTooltip($measure_id).'">'.$actual.'</td>';
              }else{
             $table.='<td data-title="'.getActualTooltip($measure_id).'"><p data-toggle="modal" data-target="#select'.$measure_id.'">'.$actual.'</p></td>';
              }
            }
          $table.='<td>'.$allocated_weight.'</td>';
             if(getWeightedRating($measure_id)<0){
              $table.='<td><p id="wr'.$measure_id.'"><font color="#FF0000">'.getWeightedRating($measure_id).'%</font></p></td>'; 
              }
                 elseif(getWeightedRating($measure_id)==0 AND strlen($actual) >0){
              $table.='<td><p id="wr'.$measure_id.'"><font color="green">'.getWeightedRating($measure_id).'%</font></p></td>';
            }
               elseif(getWeightedRating($measure_id)==""){
              $table.='<td></td>';
            }
            
              else{
               $table.='<td><p id="wr'.$measure_id.'"><font color="green">'.getWeightedRating($measure_id).'%</font></p></td>';
            }
          $table.=getTrendIndicator($measure_id);
       $table.='<td><button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#comment'.$measure_id.'"><i class="fa fa-commenting-o" aria-hidden="true"></i> <font color="#175ea8"><b>'.countComments($measure_id).'</b></font>
</i></button></td>
 </form>';

           $table.='
              </tr>';

              $counter_goals++;
            }else{
              $table .=  '<tr><td>';
                 if(strlen($measure)>0){
             $table.='<p data-toggle="modal" data-target="#measure'.$measure_id.'">'.$measure.'
            </p>';
              } else{
                $table.='<td><i class="fa fa-pencil-square-o" aria-hidden="true" style="color:#175ae8;" data-toggle="modal" data-target="#measure'.$measure_id.'">measure</i>';
              }
//straightfromscorecard
     $table.='</td>
              <td>'.$unit.'</td>
              <td>'.$reporting_frequency.'</td>
              <td>'.$target_period.'</td>
              <td>'.$base_target.'</td>
              <td>'.$stretch_target.'</td>';
               if(getReportingFrequency($measure_id)=='Y'){
               $table.='<td>'.$actual.'</td>';
              }else{
             $table.='<td data-title="'.getActualTooltip($measure_id).'"><p data-toggle="modal" data-target="#select'.$measure_id.'">'.$actual.'</p></td>';
              }
          
            
     $table.='<td>'.$allocated_weight.'</td>';
             if(getWeightedRating($measure_id)<0){
              $table.='<td><p id="wr'.$measure_id.'"><font color="#FF0000">'.getWeightedRating($measure_id).'%</font></p></td>'; 
              }
             elseif(getWeightedRating($measure_id)==0 AND strlen($actual) >0){
              $table.='<td><p id="wr'.$measure_id.'"><font color="green">'.getWeightedRating($measure_id).'%</font></p></td>';
            }
               elseif(getWeightedRating($measure_id)==""){
              $table.='<td></td>';
            }
              else{
              $table.='<td><p id="wr'.$measure_id.'"><font color="green">'.getWeightedRating($measure_id).'%</font></p></td>';
            }
         $table.=getTrendIndicator($measure_id);
  $table.='</select></td><td><button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#comment'.$measure_id.'"><i class="fa fa-commenting-o" aria-hidden="true"></i> <font color="#175ea8"><b>'.countComments($measure_id).'</b></font>
</i></button></td>
</form>';

$table.='   
              </tr></div>
              ';
              $counter_goals++;
            }

                 
      echo' <div class="modal inmodal fade" id="action_plans'.$measure_id.'" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4>Tasks Involved to achieve this.</h4>
                                    
                         <div class="modal-body">
                        <div class="row" id="add_to_me'.$measure_id.'">
                        <ul class="todo-list m-t small-list" style="text-align: left;" id="add_to'.$measure_id.'">';
                          getReadOnlyMeasureTasks($measure_id);
                 echo'           </ul>
                        </div><br>
                     <div class="row" id="button'.$measure_id.'">
                         </div>  
                               </div>
                              
                <div class="modal-footer">
                                          
           
                  <button type="button" onClick="location.reload();" class="btn btn-primary" data-dismiss="modal">Done</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
';
         

                 
           
                echo '<!-- Modal -->
          <div class="modal fade bd-example-modal-lg" id="comment'.$measure_id.'" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Add Comments </h4>
                </div>
                <div class="modal-body">';

                     getIndividualComments($measure_id);
                        
                    echo'<div class="row">
                          <div class="col-1"></div>
                          <div class="media-body col-11" style="text-align: right;" id="newcomment'.$measure_id.'">
                            
                            </div>
                          </div>
                       <br> <textarea class="form-control" id="mycomment'.$measure_id.'" placeholder="Write comment..."></textarea><br>
                               
                                <div class="form-group" align="right">
                                    <button type="button" onclick="saveComment('.$scorecard_id.','.$measure_id.')" class="btn btn-primary"><i class="fa fa-send"></i> Send</button>
                                </div>

                    
                   
                  <div class="form-group" align="right">
                 
                    <button type="button" class="btn btn-outline-secondary" style="width: 100%" data-dismiss="modal">Close</button>
                  </div>
              
                </div>
              </div>
              
            </div>
          </div>';
     echo '<!-- Modal -->
          <div class="modal fade" id="goal'.$id.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">View Goal </h4>
                </div>
                <div class="modal-body" >

                  <div class="row" >
                    <div class="col-lg-12">
                      <div class="form-group">

                        <textarea rows="4" cols="5" name="goal" readonly class="form-control">'.$goal.'</textarea>
                        <br/><br/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">

                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
              
                </div>
              </div>
              
            </div>
          </div>';

     echo '<!-- Modal -->
          <div class="modal fade" id="select'.$measure_id.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">Actual Achievements</h4>
                </div>
                <div class="modal-body" >
                <form action="../grades.php" method="POST">
                 <div class="row" >
                    <div class="col-lg-12">
                      <div id="33'.$measure_id.'" class="form-group">';

             getReadOnlyRevenues2($measure_id);
         
            echo'    
                    </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                      <button type="button" onClick="document.location.reload(true)" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>';
          echo '<!-- Modal -->
          <div class="modal fade" id="measure'.$measure_id.'" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">View Measure </h4>
                </div>
                <div class="modal-body">

                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">

                        <textarea rows="4" cols="10" name="measure" class="form-control" readonly>'.$measure.'</textarea>
                        <br/><br/>
                      </div>
                    </div>
                   
                  </div>
                  <div class="form-group" align="right">
                  <br/>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                
                </div>
              </div>
              
            </div>
          </div>';
    
          }
          $stmt2->close();

        }
         $table.=' 
             <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
             <td><font color="blue">Total</font></td>
             <td ><font color="blue">'.getPerspectiveTotalWeight($perspective_id,$scorecard_id).'</font></td>';
if (getWR($scorecard_id,$perspective_id)<0){
   $table.='<td bgcolor="#FF0000"><font color="#fff">'.getWR($scorecard_id,$perspective_id).'%</font></td>';
   }else{
    $table.='<td bgcolor="green"><font color="#fff">'.getWR($scorecard_id,$perspective_id).'%</font></td>';
   }
       $table.='  <td></td>
                  <td></td>
                  </tr>
            ';
        $stmt1->close();

      }

    }
    $stmt->close();
    
    $conn->close();

    //close table tag
    $table .= '<tr>
    <td colspan="8" align="right"><font color="#175ae8">Overall Achievement</font></td>';
    if (getOverallWeight($scorecard_id)!=100){
        $table.='<td colspan="2" align="right" bgcolor="#FF0000"><font color="#fff">'.getOverallWeight($scorecard_id).'%</font></td>';
        }else{
        $table.='<td colspan="2" align="right" bgcolor="green"><font color="#fff">'.getOverallWeight($scorecard_id).' %</font></td>';
        }
 if (getTotalWR($_GET['scorecard'])<0){
   $table.='<td bgcolor="#FF0000"><font color="#fff">'.getTotalWR($_GET['scorecard']).'%</font></td>';
   }else{
    $table.='<td bgcolor="green"><font color="#fff">'.getTotalWR($_GET['scorecard']).'%</font></td>';
   }

  $table.='  </td>
            <td></td>
            <td></td>
            </tr>
    </tbody></table>';

    echo $table;
    
  }

function auditTrail($user_id,$table,$action, $old_value,$new_value){
  $conn=dbconnect();

  $stmt=$conn->prepare("INSERT INTO audit (client_id, user_id, table, action, old_value, new_value) VALUES(?,?,?,?,?,?)");
  $stmt->bind_param('iissss',$_SESSION['client_id'],$user_id,$table,$action, $old_value,$new_value);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}

  function getOutstandingAP(){
      $conn = dbconnect();
    $client_id =$_SESSION['client_id'];  
      
    if($_SESSION['account_type']==1){
        
    $stmt1 = $conn->prepare("SELECT id, name FROM bsc_projects WHERE client_id =?");
    $stmt1->bind_param('i',$client_id);
    }
   elseif($_SESSION['account_type']==2){
       
    $stmt1 = $conn->prepare("SELECT id, name FROM bsc_projects LEFT JOIN bsc_scorecards ON scorecard_id=bsc_scorecards.id WHERE bsc_projects.client_id =? AND business_unit=?");
    $stmt1->bind_param('ii',$client_id, $_SESSION['business_unit']);
       
   } elseif($_SESSION['account_type']==3){
    $stmt1 = $conn->prepare("SELECT id, name FROM bsc_projects LEFT JOIN bsc_scorecards ON scorecard_id=bsc_scorecards.id WHERE bsc_projects.client_id =? AND department_id=?");
    $stmt1->bind_param('ii',$client_id, $_SESSION['department_id']);
   }else{
       
     $stmt1 = $conn->prepare("SELECT DISTINCT(bsc_projects.id), name FROM bsc_project_tasks LEFT JOIN bsc_projects ON bsc_projects.id=project_id WHERE (manager =? OR assigned=?)");
     $stmt1->bind_param('ii',$_SESSION['user_id'], $_SESSION['user_id']); 
       
   }
    
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($project_id,$name);
    While($stmt1->fetch()){

      echo '<b>'.strtoupper($name).'</b>';

    $stmt = $conn->prepare("SELECT id, task,  due_date, last_updated, status FROM bsc_project_tasks WHERE project_id=? AND completion<?");
    $stmt->bind_param('ii',$project_id,$completion);
    $completion=100;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id,$task,$due_date, $last_updated, $completion);
    While($stmt->fetch()){
     
        echo'   <li>';
                
            if($due_date < date('Y-m-d')){
              echo  '<span class="m-l-xs" style="font-size: 16px; color: red;">'.$task.' <b>due:</b> '.$due_date.'</span>';
            }
              else{
              echo  '<span class="m-l-xs" style="font-size: 16px;">'.$task.' <b>due:</b> '.$due_date.'</span>';
              }

       echo' </li>';
}

echo '<br>';
$stmt->close();
}
$stmt1->close();
$conn->close();
}

  function getOutstandingPercentage(){
      $conn = dbconnect();
      $client_id=$_SESSION['client_id'];
      //$status=0;
if($_SESSION['account_type']==1){

    $stmt = $conn->prepare("SELECT COUNT(pt.id) FROM bsc_project_tasks AS pt LEFT JOIN bsc_projects ON bsc_projects.id=project_id WHERE client_id =?");
    $stmt->bind_param('i',$client_id);
}elseif($_SESSION['account_type']==2){
    $stmt = $conn->prepare("SELECT COUNT(pt.id) FROM bsc_project_tasks AS pt LEFT JOIN bsc_projects ON bsc_projects.id=project_id LEFT JOIN bsc_scorecards ON scorecard_id=bsc_scorecards.id WHERE bsc_projects.client_id =? AND business_unit=?");
    $stmt->bind_param('ii',$client_id, $_SESSION['business_unit']);
}
elseif($_SESSION['account_type']==3){
     $stmt = $conn->prepare("SELECT COUNT(pt.id) FROM bsc_project_tasks AS pt LEFT JOIN bsc_projects ON bsc_projects.id=project_id LEFT JOIN bsc_scorecards ON scorecard_id=bsc_scorecards.id WHERE bsc_projects.client_id =? AND department_id=?");
    $stmt->bind_param('ii',$client_id, $_SESSION['department_id']);  
}else{
   $stmt = $conn->prepare("SELECT COUNT(pt.id) FROM bsc_project_tasks AS pt LEFT JOIN bsc_projects ON bsc_projects.id=project_id WHERE manager =? OR assigned=?");
   $stmt->bind_param('ii',$_SESSION['user_id'], $_SESSION['user_id']);    
}
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
 if($_SESSION['account_type']==1){

    $stmt = $conn->prepare("SELECT COUNT(pt.id) FROM bsc_project_tasks AS pt LEFT JOIN bsc_projects ON bsc_projects.id=project_id WHERE client_id =? AND completion <?");
    $stmt->bind_param('ii',$client_id,$completion);
}elseif($_SESSION['account_type']==2){
    $stmt = $conn->prepare("SELECT COUNT(pt.id) FROM bsc_project_tasks AS pt LEFT JOIN bsc_projects ON bsc_projects.id=project_id LEFT JOIN bsc_scorecards ON scorecard_id=bsc_scorecards.id WHERE bsc_projects.client_id =? AND business_unit=? AND completion <?");
    $stmt->bind_param('iii',$client_id, $_SESSION['business_unit'],$completion);
}
elseif($_SESSION['account_type']==3){
     $stmt = $conn->prepare("SELECT COUNT(pt.id) FROM bsc_project_tasks AS pt LEFT JOIN bsc_projects ON bsc_projects.id=project_id LEFT JOIN bsc_scorecards ON scorecard_id=bsc_scorecards.id WHERE bsc_projects.client_id =? AND department_id=? AND completion <?");
    $stmt->bind_param('iii',$client_id, $_SESSION['department_id'],$completion);  
}else{
   $stmt = $conn->prepare("SELECT COUNT(pt.id) FROM bsc_project_tasks AS pt LEFT JOIN bsc_projects ON bsc_projects.id=project_id WHERE (manager =? OR assigned=?) AND completion <?");
   $stmt->bind_param('iii',$_SESSION['user_id'], $_SESSION['user_id'],$completion);    
}  
    $completion=100;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count1);
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    if($count==0 || $count1 ==0){
      $answer=0;
    }
    else{
     $answer=round(($count1/$count)*100,2);  
    }
    if($answer>0){
 return '<div class="stat-percent font-bold text-danger"> &nbsp; '.$count1.' ('.$answer.'%)</div>';
          }
      else{
 return '<div class="stat-percent font-bold text-success"> &nbsp; '.$count1.' ('.$answer.'%)</div>';
      }
   
}

  function getTotalProgress(){
      $conn = dbconnect();
      $client_id=$_SESSION['client_id'];
      //$status=0;
if($_SESSION['account_type']==1){

    $stmt = $conn->prepare("SELECT COUNT(pt.id) FROM bsc_project_tasks AS pt LEFT JOIN bsc_projects ON bsc_projects.id=project_id WHERE client_id =?");
    $stmt->bind_param('i',$client_id);
}elseif($_SESSION['account_type']==2){
    $stmt = $conn->prepare("SELECT COUNT(pt.id) FROM bsc_project_tasks AS pt LEFT JOIN bsc_projects ON bsc_projects.id=project_id LEFT JOIN bsc_scorecards ON scorecard_id=bsc_scorecards.id WHERE bsc_projects.client_id =? AND business_unit=?");
    $stmt->bind_param('ii',$client_id, $_SESSION['business_unit']);
}
elseif($_SESSION['account_type']==3){
     $stmt = $conn->prepare("SELECT COUNT(pt.id) FROM bsc_project_tasks AS pt LEFT JOIN bsc_projects ON bsc_projects.id=project_id LEFT JOIN bsc_scorecards ON scorecard_id=bsc_scorecards.id WHERE bsc_projects.client_id =? AND department_id=?");
    $stmt->bind_param('ii',$client_id, $_SESSION['department_id']);  
}else{
   $stmt = $conn->prepare("SELECT COUNT(pt.id) FROM bsc_project_tasks AS pt LEFT JOIN bsc_projects ON bsc_projects.id=project_id WHERE manager =? OR assigned=?");
   $stmt->bind_param('ii',$_SESSION['user_id'], $_SESSION['user_id']);    
}
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
 if($_SESSION['account_type']==1){

    $stmt = $conn->prepare("SELECT COUNT(pt.id) FROM bsc_project_tasks AS pt LEFT JOIN bsc_projects ON bsc_projects.id=project_id WHERE client_id =? AND completion <?");
    $stmt->bind_param('ii',$client_id,$completion);
}elseif($_SESSION['account_type']==2){
    $stmt = $conn->prepare("SELECT COUNT(pt.id) FROM bsc_project_tasks AS pt LEFT JOIN bsc_projects ON bsc_projects.id=project_id LEFT JOIN bsc_scorecards ON scorecard_id=bsc_scorecards.id WHERE bsc_projects.client_id =? AND business_unit=? AND completion <?");
    $stmt->bind_param('iii',$client_id, $_SESSION['business_unit'],$completion);
}
elseif($_SESSION['account_type']==3){
     $stmt = $conn->prepare("SELECT COUNT(pt.id) FROM bsc_project_tasks AS pt LEFT JOIN bsc_projects ON bsc_projects.id=project_id LEFT JOIN bsc_scorecards ON scorecard_id=bsc_scorecards.id WHERE bsc_projects.client_id =? AND department_id=? AND completion <?");
    $stmt->bind_param('iii',$client_id, $_SESSION['department_id'],$completion);  
}else{
   $stmt = $conn->prepare("SELECT COUNT(pt.id) FROM bsc_project_tasks AS pt LEFT JOIN bsc_projects ON bsc_projects.id=project_id WHERE manager =? OR assigned=? AND completion <?");
   $stmt->bind_param('iii',$_SESSION['user_id'], $_SESSION['user_id'],$completion);    
}  
    $completion=100;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count1);
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    if($count==0 || $count1 ==0){
      $answer=0;
    }
    else{
     $answer=100 -(($count1/$count)*100);  
    }
return $answer;
   
}


function  uploadFile($table,$task_id,$evidence,$scorecard_id){
  $conn=dbconnect();

  $stmt=$conn->prepare("INSERT INTO supporting_documents (table_name, scorecard_id, measure_id, document) VALUES(?,?,?,?)");
  $stmt->bind_param('ssss',$table,$scorecard_id,$task_id,$evidence);
  $stmt->execute();
  $stmt->close();
  $conn->close();

   echo "<script type='text/javascript'>
        window.location.href = 'action_plans/".$scorecard_id."';
        </script>";

}

  function getSupportingDocuments($scorecard_id){
      $conn = dbconnect();

    $stmt1 = $conn->prepare("SELECT id, table_name,measure_id, document FROM bsc_supporting_documents WHERE scorecard_id=?");
    $stmt1->bind_param('i',$scorecard_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($id,$table_name,$measure_id,$document);
    While($stmt1->fetch()){

echo'<div class="col-lg-3">
<div class="card">
  <img src="img/pdf2.jpg" class="card-img-top" alt="View File">
  <div class="card-body">';
  if($table_name <>'targets'){
    echo  '<p class="card-text">'.getTaskName($table_name,$measure_id).'<a href="/iperform/client/evidence/'.$document.'" target="blank"> view file</a></p>';
  }else{
    echo'<p class="card-text">'.getMeasureName($table_name,$measure_id).'<a href="/iperform/client/evidence/'.$document.'" target="blank"> view file</a></p>';
  }
 echo' </div>
</div>
</div>';

    }
    $stmt1->close();
    $conn->close();
  }

  function  getTaskName($table,$task_id){
  $conn=dbconnect();

  $stmt=$conn->prepare("SELECT task FROM $table WHERE id=?");
  $stmt->bind_param('i',$task_id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($task);
  $stmt->fetch();
  $stmt->close();
  $conn->close();
return $task;

}


  function  getMeasureName($table,$task_id){
  $conn=dbconnect();

  $stmt=$conn->prepare("SELECT measure FROM $table WHERE id=?");
  $stmt->bind_param('i',$task_id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($measure);
  $stmt->fetch();
  $stmt->close();
  $conn->close();
return $measure;

}


  function  selectProjectTasks($scorecard_id){
  $conn=dbconnect();

  $stmt=$conn->prepare("SELECT bsc_project_tasks.id, task FROM bsc_project_tasks LEFT JOIN bsc_projects ON bsc_projects.id=project_id WHERE scorecard_id=?");
  $stmt->bind_param('i',$scorecard_id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($id, $task);
  While($stmt->fetch()){
     echo '<option value="'.$id.'">'.$task.'</option>'; 
  }
  $stmt->close();
  $conn->close();
 
}

function selectMeasureTasks($scorecard_id){
  $conn=dbconnect();

 $stmt=$conn->prepare("SELECT bsc_targets.id, measure FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE scorecard_id=?");
  $stmt->bind_param('i',$scorecard_id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($id, $measure);
  While($stmt->fetch()){
  echo '<option value="'.$id.'">'.$measure.'</option>';
  }
  $stmt->close();
  $conn->close();
}

function emailTaskCompletion($user_id, $project_id, $task_id){
    $conn=dbconnect();

    	    $headers = "From:  Industrial Psychology Consultants" . strip_tags('do_not_reply@masaisai.ac.zw') . "\r\n";
			$headers .= "Reply-To: ". strip_tags('nyasha@ipcconsultants.com') . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Cc: nyasha@ipcconsultants.com \r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
       
    //$to = 'ziwewend@gmail.com';
    //$supervisor_emmail = 'nyashaziwewe@gmail.com';
    $supervisor_email = $_SESSION["supervisoremail"];
    $first_name=$_SESSION['first_name'];
    $last_name=$_SESSION['last_name'];


    $subject = "RE: Project Task Completion";

    $message = "<html>
            <body style='color:#1575a7;'>
              <p>Good day ".getEmailOwnerName($supervisor_email).", </p>
              <p align='justify'>

We hope this email finds you well. Please note that ".$first_name." ".$last_name." has completed the following tasks today (".date('Y-m-d H:i:s').")</p>

<b>Tasks completed:</b>
<ol>
 <li> ".getTaskName('project_tasks',$task_id)."</li>
</ol>

<p>Regards,</p>
<p>Admin @ IPCIperform</p>
          </html>";

 mail($supervisor_email,$subject,$message,$headers);

    $stmt->close();

    $conn->close();
}

//   function sendTaskCompletionMessage($scorecard_id,$project,$task){
//   $email=$_SESSION['email'];
//   $owner=getOwner($scorecard_id);

//   if(getScoreCardLevel($scorecard_id)==3 || getScoreCardLevel($scorecard_id)==4){
//   $supervisor_email=$_SESSION['supervisor_email'];
//     }else{
//   $supervisor_email = getClientEmail($_SESSION['client_id']);
//     }

//     $subject = "RE: Task Completion";

//     $message = "<html>
//             <body style='color:#1575a7;'>
//               <p>Good day <b>".getEmailOwnerName($supervisor_email)."</b>,</p>
//               <p>Please note that ".getEmailOwnerName($email)." has completed task: ".$task." on ".$project."</p>
//               <p><b>Please login to the system and approve for it to take effect</b></p>           
//               <p>Regards,</p>
//               <p>Admin @ IPCiPerform</p>
//           </html>";
//  email($supervisor_email,$subject,$message);

      
//     $stmt->close();

//     $conn->close();

// }

function sumImpact($user_id){
  $conn=dbconnect();

    $stmt = $conn->prepare("SELECT SUM(impact) FROM simple_template WHERE user_id = ?");
    $stmt->bind_param('i',$_SESSION['user_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($total);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $total;
}

  function getSimpleTemplate(){

    // Database connection
    $conn = dbconnect();
    $total_score =0;
    $tcf =0;
    $score ='';

    $stmt = $conn->prepare("SELECT id, user_id, activity, measure_of_success, impact, actual, carry_forward, due_date, date FROM simple_template WHERE user_id = ?");
    $stmt->bind_param('i',$_SESSION['user_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $user_id, $activity, $measure_of_success, $impact, $actual, $carry_forward, $due_date, $date);
    while($stmt->fetch()){

      $impct= ($impact/sumImpact($user_id))*100;
      if($actual==0){
        $score=0;
      } else{
         $score= $impct*($actual/10); 
      }
    
      $total_score+=$score;

  echo '<tr>
        <td>'.$activity.'</td>
        <td>'.$measure_of_success.'</td>
        <td>'.$due_date.'</td>
        <td>'.$impact.' ('.round($impct,2).'%)</td>
        <td onClick="changeCell('.$id.')" id="actual'.$id.'">'.$actual.'</td>';
        if($score>=($impct/2)){
        echo'<td><font color="green">'.round($score,2).'%</font></td>';
        }else{
        echo'<td><font color="red">'.round($score,2).'%</font></td>';
        }
        
        if($carry_forward==1){
        $cf = round($impct-$score,2);
        $tcf +=$cf;
        echo'<td>'.$cf.'%</td>'; 
        }else{
         echo'<td>No</td>'; 
        }
     
 echo' 
        <td> 
      
        <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle">Options</button>
        <ul class="dropdown-menu">
        <li><a href="myscorecards?addm3=true"> <button type="button" class="btn btn-outline-primary">Add Scorecard</button></a></li>             
        <li><a href="#"><button class="btn btn-outline-danger" data-toggle="modal" data-target="#delete'.$id.'"><font color="red"<i class="fa fa-trash"></i>Delete Activity</font></button></a></li>
                       
        </ul>
        </div>
        </td>
      </tr>';   
    }

    echo'               <tr>
                          <td colspan="5" align="right"><b>Total</b></td>';
                          if($score<50){
                          echo'<td><b><font color="red">'.round($total_score,2).'%</font></b></td>'; 
                          }else{
                          echo'<td><b><font color="green">'.round($total_score,2).'%</font></b></td>';
                          }
                         echo'<td colspan="2"><b>'.$tcf.'%</b></td>
                        </tr>';

    $stmt->close();

    //close conn
    $conn->close();

  }

    function getOutstandingActionPlans($scorecard_id){
      $conn = dbconnect();
    
    $tasks='';
    $stmt1 = $conn->prepare("SELECT id, name FROM bsc_projects WHERE scorecard_id=?");
    $stmt1->bind_param('i',$scorecard_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($project_id,$name);

    if($stmt1->num_rows <1){ 
       $tasks.='Mr Zlatan Pogbamovic';
    }else{
    While($stmt1->fetch()){


    $tasks.=strtoupper($name);

    $stmt = $conn->prepare("SELECT id, task,  due_date, last_updated, status FROM bsc_project_tasks WHERE project_id=? AND status=?");
    $stmt->bind_param('ii',$project_id,$status);
    $status=0;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id,$task,$due_date, $last_updated, $status);
    While($stmt->fetch()){
     
    $tasks.= $task.'.<w:br/>';

     }

$stmt->close();
}
$stmt1->close();
$conn->close();

}

}

function compare_score($a, $b)
  {
    return strnatcmp($a['score'], $b['score']);
  }

     function getProjectsWorkedOn($scorecard_id){
      $conn = dbconnect();
    
    $tasks='';
    $stmt1 = $conn->prepare("SELECT id, name FROM bsc_projects WHERE scorecard_id=?");
    $stmt1->bind_param('i',$scorecard_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($project_id,$name);
    While($stmt1->fetch()){

    $tasks.=strtoupper($name);

    $stmt = $conn->prepare("SELECT id, task,  due_date, last_updated, status FROM bsc_project_tasks WHERE project_id=? AND status=?");
    $stmt->bind_param('ii',$project_id,$status);
    $status=0;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id,$task,$due_date, $last_updated, $status);
    While($stmt->fetch()){
     
    $tasks.= $task.'.<w:br/>';


}

$stmt->close();
}
$stmt1->close();
$conn->close();


}


  function getNyasha($month){
  //error_reporting(0);
    $conn = dbconnect();

    $scorecard_id=$_GET['sid'];
    $counter=0;
    $weight='';
    $stmt1 = $conn->prepare("SELECT targets.id FROM bsc_targets LEFT JOIN bsc_goals ON goal_id=bsc_goals.id WHERE scorecard_id=? AND reporting_frequency=?");
    $stmt1->bind_param('is',$scorecard_id,$reporting_frequency);
    $reporting_frequency='M';
   // $measure_id=test_input($par1);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($measure_id);
    While($stmt1->fetch()){

     $weighted_rating='';
    $stmt = $conn->prepare("SELECT base_target, stretch_target, allocated_weight, AVG(amount) FROM bsc_monthly LEFT JOIN bsc_targets ON bsc_targets.id=target_id WHERE targets.id=? AND month=?");
    $stmt->bind_param('is',$measure_id,$month);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($base_target, $stretch_target,$allocated_weight, $actual);
    While($stmt->fetch()){
  
 if($stretch_target==$base_target AND $stretch_target==$actual){
       //$weighted_rating+=$allocated_weight; 
    }
     elseif($base_target==$actual){
        //$weighted_rating+=0; 

    }
    else{
     $weighted_rating=(($actual-$base_target)/($stretch_target-$base_target))*$allocated_weight;
    if($weighted_rating>$allocated_weight){
       $weighted_rating+=$allocated_weight;
    }
    elseif($weighted_rating<-$allocated_weight){
      $weighted_rating+=-$allocated_weight;
    }
     else{
    $weighted_rating+=0;
    //$weighted_rating=$weighted_rating;
     }

  }

   $counter++;   
   $weight+= $weighted_rating;
}

     $stmt->close();
 } 
 $answer= round($weight/$counter,2);

 ?>

 { label: "<?php echo $month; ?>", y: <?php echo $answer; ?>, indexLabel: "<?php echo $answer; ?>%"  }, 
   <!-- { label: "Jan2020", y: <?php //echo 10; ?>, indexLabel: "<?php //echo 10; ?>%"  }, -->
<?php   
    $stmt1->close();
    $conn->close();

    }

  


  function sendApprovalMessage($scorecard_id,$project,$task,$status){
  $email=$_SESSION['email'];
  $owner=getOwner($scorecard_id);

  if(getScoreCardLevel($scorecard_id)==3 || getScoreCardLevel($scorecard_id)==4){
  $subbordinate_email=$_SESSION['supervisor_email'];
    }else{
  $supervisor_email = getClientEmail($_SESSION['client_id']);
    }

    $subject = "RE: Task Completion";

    $message = "<html>
            <body style='color:#1575a7;'>
              <p>Good day <b>".getEmailOwnerName($supervisor_email)."</b>,</p>
              <p>Please note that ".getEmailOwnerName($email)." has completed task: ".$task." on ".$project."</p>
              <p><b>Please login to the system and approve for it to take effect</b></p>           
              <p>Regards,</p>
              <p>Admin @ IPCiPerform</p>
          </html>";
 email($supervisor_email,$subject,$message);

      
    $stmt->close();

    $conn->close();

}

     function getGoalWR($goal_id){

    $conn = dbconnect();
    $total=0;
    $stmt = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE goal_id=?");
    $stmt->bind_param('i',$goal_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($measure_id);
    While($stmt->fetch()){
        $total+=getWeightedRating($measure_id); 
      }
    return $total;
  }

function  addAssignment($_user_id,$activity,$measure_of_success,$impact,$cf,$due_date){
    $conn=dbconnect();

  $stmt=$conn->prepare("INSERT INTO simple_template (user_id, activity, measure_of_success, impact, carry_forward, due_date) VALUES(?,?,?,?,?,?)");
  $stmt->bind_param('isssis',$_user_id,$activity,$measure_of_success,$impact,$cf,$due_date);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}

function  changeMailStatus($id){
  $conn=dbconnect();

  $stmt=$conn->prepare("UPDATE emails SET status=? WHERE id=?");
  $stmt->bind_param('ii',$status,$id);
  $status=1;
  $stmt->execute();
  $stmt->close();
  $conn->close();
}

    function getProjectsTable($scope,$status){

    // Database connection
    $conn = dbconnect();

    if($status==4){
         
    if($scope==0){
     $stmt = $conn->prepare("SELECT id, scorecard_id, name, description, measure_of_success, manager, start_date, end_date, reason, status FROM projects WHERE manager = ? ");
    $stmt->bind_param('i',$_SESSION['user_id']);

  }  elseif($scope==1){
     $stmt = $conn->prepare("SELECT projects.id, scorecard_id, name, description, measure_of_success, manager, start_date, end_date, reason, status FROM projects LEFT JOIN project_team ON projects.id=project_id WHERE member=?");
    $stmt->bind_param('i',$_SESSION['user_id']);
  }  
  
  elseif($scope==2){
      $stmt = $conn->prepare("SELECT projects.id, scorecard_id, name, description, measure_of_success, manager, start_date, end_date, reason, status FROM projects LEFT JOIN project_team ON projects.id=project_id WHERE projects.id NOT IN (SELECT DISTINCT (project_id) FROM project_team WHERE member =?) AND manager !=? AND client_id = ?");
    $stmt->bind_param('iii',$_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['client_id']);
  }
  else{
          $stmt = $conn->prepare("SELECT id, scorecard_id, name, description, measure_of_success, manager, start_date, end_date, reason, status FROM projects WHERE client_id = ?");
          $stmt->bind_param('i',$_SESSION['client_id']);
  }
    }



    else{



   if($scope==0){
     $stmt = $conn->prepare("SELECT id, scorecard_id, name, description, measure_of_success, manager, start_date, end_date, reason, status FROM projects WHERE manager = ? AND status=?");
    $stmt->bind_param('ii',$_SESSION['user_id'],$status);

  } 
   elseif($scope==1){
     $stmt = $conn->prepare("SELECT projects.id, scorecard_id, name, description, measure_of_success, manager, start_date, end_date, reason, status FROM projects LEFT JOIN project_team ON projects.id=project_id WHERE member=? AND status=?");
    $stmt->bind_param('ii',$_SESSION['user_id'],$status);
  }  
  
  elseif($scope==2){
      $stmt = $conn->prepare("SELECT projects.id, scorecard_id, name, description, measure_of_success, manager, start_date, end_date, reason, status FROM projects LEFT JOIN project_team ON projects.id=project_id WHERE projects.id NOT IN (SELECT DISTINCT (project_id) FROM project_team WHERE member =?) AND manager !=? AND client_id = ? AND status=?");
    $stmt->bind_param('iiii',$_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['client_id'],$status);
  }
  else{
          $stmt = $conn->prepare("SELECT id, scorecard_id, name, description, measure_of_success, manager, start_date, end_date, reason, status FROM projects WHERE client_id = ? AND status=?");
          $stmt->bind_param('ii',$_SESSION['client_id'],$status);
  }
}

    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $scorecard_id, $name, $description, $measure_of_success, $manager, $start_date, $end_date, $reason, $status);
    while($stmt->fetch()){
      echo '<tr>
        <td>'.$name.'</td>';
        if(getCountTasks($id)>0){

      echo'<td style="cursor: pointer;" class="text-center" data-toggle="collapse" data-target="#demo'.$id.'" title="Click here to view the employees and close the view afterwards"><button><i class="fa fa-search">Tasks <font color="#175ea8"> ('.getCountTasks($id).')</font></i></button>

      <div id="demo'.$id.'" class="collapse">
       <table bordercolor="#175ea8" style="" width="1000px">
          <tbody>';
      getTasksTable($id);
   echo'         
         </tbody>
        </table>
        </div>
      </td>';
    }else{
    echo '<td></td>';
     }
 echo'  <td>'.$measure_of_success.'</td>
        <td>'.$end_date.'</td>
        <td>'.getEmployeeName($manager).'</td>
        <td data-toggle="popover" data-placement="top" data-content="'.$reason.'"><div class="progress"><div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" style="width:'.combineProgress($id).'%">'.round(combineProgress($id),2).'%</div></div></td>
        <td><button data-target="#warning'.$id.'" data-toggle="modal"><font color="#175ea8"><i class="fa fa-play-circle-o fa-lg" aria-hidden="true" ></i></font></button><button data-toggle="modal" data-target="#project'.$id.'">Explore</button></td>';


        echo'<div class="modal fade" id="warning'.$id.'" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">Project Activation</font></h4>

                </div>
                <div class="modal-body" >
                <form action="action_plans.php" method="POST">

                  <div class="row" >
                    <div class="col-lg-12">
           
<h3>Are you sure you want to Activate  <font color="#175ea8">'.$name.'</font>? </h3>
Time will start to count down.
                    </div>
                  </div>
                  <div class="form-group" align="right">
                      <button type="submit" name="activate" class="btn btn-primary">Yes</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>';


      echo' <div class="modal inmodal fade" id="project'.$id.'" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4><b>'.ucwords($name).' [Project Progress]</b>   <small>Tasks Involved</small></h4>
                                    
                         <div class="modal-body">
                        <div class="row" id="add_to_me'.$id.'">
                        <ul class="todo-list m-t small-list" style="text-align: left;" id="add_to'.$id.'">';
                          getProjectTasks($id);
                 echo'           </ul>
                        </div><br>
                     <div class="row" id="button'.$id.'">
                     <button class="btn btn-primary btn-sm" onclick="addCode('.$id.')">Add Check List</button>
                         </div>
                           <p id="warning'.$id.'" style="color: red;"></p>   
                               </div>
                              
                <div class="modal-footer">
                &nbsp;&nbsp;&nbsp;&nbsp;';  getProjectStatus($status,$id); echo'
                                       
           
                  <button type="button" onClick="location.reload();" class="btn btn-primary" data-dismiss="modal">Done</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>';
      }
    }

      function getTasksTable($project_id){
      $conn = dbconnect();
  
    $stmt1 = $conn->prepare("SELECT id, task, measure_of_success, document, start_date, due_date, last_updated, status, completion FROM project_tasks WHERE project_id=?");
    $stmt1->bind_param('i',$project_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($id,$task, $m_o_success, $document, $start_date, $due_date, $last_updated, $status, $completion);
    While($stmt1->fetch()){

    $daysLeft= dateDiff(date('Y-m-d'), $due_date);
    $duration= dateDiff($start_date, $due_date);
    $daysUsed= $duration-$daysLeft;
    $time=($daysUsed/$duration)*100;

      
  echo'
  
        <tr><td align="left">'.$task.'</td><td>'.$m_o_success.'</td><td>'.$due_date.'</td><td>'.$document.'</td><td width="15%">
        <div class="progress">';
        if($time>$completion){
    echo'<div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" style="width:'.$completion.'%">'.$completion.'%</div>';
        }else{
    echo'<div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" style="width:'.$completion.'%">'.$completion.'%</div>';
        }

 echo'   </div>
        </td>';
    if($status==0){
   echo'<td>Not Yet Kicked</td></tr>'; 
    }
    elseif(date('Y-m-d')>$due_date ){
    echo'<td><font color="red">'.abs($daysLeft).' day(s) overdue</font></td></tr>'; 
    }else{
      echo  '<td>'.abs($daysLeft).' days left</td></tr>'; 
    }
       
}
}

  function getCountTasks($id){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM  bsc_project_tasks WHERE project_id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();   
    $stmt->close();
    $conn->close();
return $count;

  }

    function dateDiff($date1, $date2) 
  {
    $date1_ts = strtotime($date1);
    $date2_ts = strtotime($date2);
    $diff = $date2_ts - $date1_ts;
    return round($diff / 86400);
  }

  function combineProgress($project_id){
      $conn = dbconnect();
  
    $stmt1 = $conn->prepare("SELECT AVG(completion) FROM bsc_project_tasks WHERE project_id=?");
    $stmt1->bind_param('i',$project_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($progress);
    $stmt1->fetch();
    $stmt1->close();
    $conn->close();
    return $progress;

  }

      function getClientProjectsTable($scope,$status){

    // Database connection
    $conn = dbconnect();

    if($status==4){
         
    if($scope==0){
     $stmt = $conn->prepare("SELECT id, scorecard_id, name, description, measure_of_success, manager, start_date, end_date, reason, status FROM bsc_projects WHERE manager = ? ");
    $stmt->bind_param('i',$_SESSION['user_id']);

  }  elseif($scope==1){
     $stmt = $conn->prepare("SELECT bsc_projects.id, scorecard_id, name, description, measure_of_success, manager, start_date, end_date, reason, status FROM bsc_projects LEFT JOIN bsc_project_team ON bsc_projects.id=project_id WHERE member=?");
    $stmt->bind_param('i',$_SESSION['user_id']);
  }  
  
  elseif($scope==2){
      $stmt = $conn->prepare("SELECT bsc_projects.id, scorecard_id, name, description, measure_of_success, manager, start_date, end_date, reason, status FROM bsc_projects LEFT JOIN bsc_project_team ON projects.id=project_id WHERE bsc_projects.id NOT IN (SELECT DISTINCT (project_id) FROM bsc_project_team WHERE member =?) AND manager !=? AND client_id = ?");
    $stmt->bind_param('iii',$_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['client_id']);
  }
  else{
          $stmt = $conn->prepare("SELECT id, scorecard_id, name, description, measure_of_success, manager, start_date, end_date, reason, status FROM bsc_projects WHERE client_id = ?");
          $stmt->bind_param('i',$_SESSION['client_id']);
  }
    }



    else{



   if($scope==0){
     $stmt = $conn->prepare("SELECT id, scorecard_id, name, description, measure_of_success, manager, start_date, end_date, reason, status FROM bsc_projects WHERE manager = ? AND status=?");
    $stmt->bind_param('ii',$_SESSION['user_id'],$status);

  } 
   elseif($scope==1){
     $stmt = $conn->prepare("SELECT projects.id, scorecard_id, name, description, measure_of_success, manager, start_date, end_date, reason, status FROM bsc_projects LEFT JOIN bsc_project_team ON projects.id=project_id WHERE member=? AND status=?");
    $stmt->bind_param('ii',$_SESSION['user_id'],$status);
  }  
  
  elseif($scope==2){
      $stmt = $conn->prepare("SELECT projects.id, scorecard_id, name, description, measure_of_success, manager, start_date, end_date, reason, status FROM bsc_projects LEFT JOIN bsc_project_team ON bsc_projects.id=project_id WHERE bsc_projects.id NOT IN (SELECT DISTINCT (project_id) FROM bsc_project_team WHERE member =?) AND manager !=? AND client_id = ? AND status=?");
    $stmt->bind_param('iiii',$_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['client_id'],$status);
  }
  else{
          $stmt = $conn->prepare("SELECT id, scorecard_id, name, description, measure_of_success, manager, start_date, end_date, reason, status FROM bsc_projects WHERE client_id = ? AND status=?");
          $stmt->bind_param('ii',$_SESSION['client_id'],$status);
  }
}

    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $scorecard_id, $name, $description, $measure_of_success, $manager, $start_date, $end_date, $reason, $status);
    while($stmt->fetch()){
      echo '<tr>
        <td>'.$name.'</td>';
        if(getCountTasks($id)>0){

      echo'<td style="cursor: pointer;" class="text-center" data-toggle="collapse" data-target="#demo'.$id.'" title="Click here to view the employees and close the view afterwards"><button><i class="fa fa-search">Tasks <font color="#175ea8"> ('.getCountTasks($id).')</font></i></button>

      <div id="demo'.$id.'" class="collapse">
       <table bordercolor="#175ea8" style="" width="1000px">
          <tbody>';
      getTasksTable($id);
   echo'         
         </tbody>
        </table>
        </div>
      </td>';
    }else{
    echo '<td></td>';
     }
 echo'  <td>'.$measure_of_success.'</td>
        <td>'.$end_date.'</td>
        <td>'.getEmployeeName($manager).'</td>
        <td><div class="progress"><div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" style="width:'.combineProgress($id).'%">'.combineProgress($id).'%</div></div></td>
        <td>'.$reason.'</td>
        <td><button data-target="#warning'.$id.'" data-toggle="modal"><font color="#175ea8"><i class="fa fa-play-circle-o fa-lg" aria-hidden="true" ></i></font></button><button data-toggle="modal" data-target="#project'.$id.'">Explore</button></td>';


        echo'<div class="modal fade" id="warning'.$id.'" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">Project Activation</font></h4>

                </div>
                <div class="modal-body" >
                <form action="action_plans.php" method="POST">

                  <div class="row" >
                    <div class="col-lg-12">
           
<h3>Are you sure you want to Activate  <font color="#175ea8">'.$name.'</font>? </h3>
Time will start to count down.
                    </div>
                  </div>
                  <div class="form-group" align="right">
                      <button type="submit" name="activate" class="btn btn-primary">Yes</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>';


      echo' <div class="modal inmodal fade" id="project'.$id.'" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4><b>'.ucwords($name).' [Project Progress]</b>   <small>Tasks Involved</small></h4>
                                    
                         <div class="modal-body">
                        <div class="row" id="add_to_me'.$id.'">
                        <ul class="todo-list m-t small-list" style="text-align: left;" id="add_to'.$id.'">';
                          getProjectTasks($id);
                 echo'           </ul>
                        </div><br>
                     <div class="row" id="button'.$id.'">
                     <button class="btn btn-primary btn-sm" onclick="addCode('.$id.')">Add Check List</button>
                         </div>
                           <p id="warning'.$id.'" style="color: red;"></p>   
                               </div>
                              
                <div class="modal-footer">
                &nbsp;&nbsp;&nbsp;&nbsp;';  getProjectStatus($status,$id); echo'
                                       
           
                  <button type="button" onClick="location.reload();" class="btn btn-primary" data-dismiss="modal">Done</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>';
      }
    }
    
//   function getMonthlyScore($measure_id){
//   error_reporting(0);
//   $conn=dbconnect();
  
//     $stmt = $conn->prepare("SELECT COUNT(id) FROM monthly WHERE id=?");
//     $stmt->bind_param('i',$measure_id);
//     $stmt->execute();
//     $stmt->store_result();
//     $stmt->bind_result($count);
//     $stmt->close();

//     $stmt = $conn->prepare("SELECT base_target, stretch_target, allocated_weight FROM targets WHERE id=?");
//     $stmt->bind_param('i',$measure_id);
//     $stmt->execute();
//     $stmt->store_result();
//     $stmt->bind_result($base_target, $stretch_target,$allocated_weight);
//     $stmt->fetch();
//     if(sumMonthly($measure_id)=='' ){
//   $weighted_rating='';
//     }
//     elseif($stretch_target==$base_target){
//       $weighted_rating="0"; 
//     }
//     else{
//     $weighted_rating=round(((sumMonthly($measure_id)-$base_target)/($stretch_target-$base_target))*$allocated_weight,2);
//     if($weighted_rating>$allocated_weight){
//       $weighted_rating=$allocated_weight;
//     }
//     elseif($weighted_rating<-$allocated_weight){
//       $weighted_rating=-$allocated_weight;
//     }
//     else{

//     }
//   }

//     $stmt->close();
//     $conn->close();

//   return $weighted_rating;
//     }
    
//     function getMonthlyValues($measure_id){
//     $conn = dbconnect();
        
//     $stmt = $conn->prepare("SELECT amount FROM monthly WHERE target_id=?");
//     $stmt->bind_param('i',$measure_id);
//     $stmt->execute();
//     $stmt->store_result();
//     $stmt->bind_result($sum);
//     While($stmt->fetch()){
//         echo $sum;
//     }
//     $stmt->close();
//     }

     function getGoalWRForMonth($goal_id,$month){

    $conn = dbconnect();
    $total=0;
    $stmt = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE goal_id=?");
    $stmt->bind_param('i',$goal_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($measure_id);
    While($stmt->fetch()){
        $total+=getWeightedRatingForMonth($measure_id,$month); 
      }
    return $total;
  }
  
   function getWeightedRatingForMonth($measure_id,$month){
    error_reporting(0);
    $conn = dbconnect();
    
    $stmt = $conn->prepare("SELECT base_target, stretch_target, allocated_weight FROM bsc_targets WHERE id=?");
    $stmt->bind_param('i',$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($base_target, $stretch_target,$allocated_weight);
    $stmt->fetch();
    $stmt->close();
     
    $stmt = $conn->prepare("SELECT SUM(amount) FROM bsc_monthly WHERE target_id=? AND month=? AND amount <>''");
    $stmt->bind_param('is',$measure_id,$month);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($actual);
    $stmt->fetch();

  if(strlen($actual)<1){
     $weighted_rating=' ';
    }
    elseif($stretch_target==$base_target AND $stretch_target==$actual){
      $weighted_rating=$allocated_weight; 
    }
     elseif($base_target==$actual){
      $weighted_rating=0; 
    }
    else{
    $weighted_rating=(($actual-$base_target)/($stretch_target-$base_target))*$allocated_weight;
    if($weighted_rating>$allocated_weight){
      $weighted_rating=$allocated_weight;
    }
    elseif($weighted_rating<-$allocated_weight){
      $weighted_rating=-$allocated_weight;
    }
    else{
    
    }
  }
    $stmt->close();
    $conn->close();

  return $weighted_rating;
    }


    // TRello functions

  //function to connect to the database'
  function dbconnect2(){

      $sql = "localhost"; 
      $username = "root";
      $password = "";
      $conn = mysqli_connect($sql, $username, $password) or 
      die("Unable to connect to the database");
      $databse = mysqli_select_db($conn, "trello");

      // Return from the function 
      return $conn; 
  }
 //  
  // function addcard($title,$employee_id){
  //   $conn=dbconnect();

  //   $stmt = $conn->prepare("INSERT INTO projects (client_id, name, manager) VALUES (?,?,?)");
  //   $stmt->bind_param('isi',$_SESSION['client_id'], $title,$employee_id);
  //   $stmt->execute();
  //   $stmt->close();

  // }


    function getCards2(){

    // Database connection
    $conn = dbconnect();

  if(countBusinessUnits()>0){
   if($_SESSION['account_type']==1){
     $stmt = $conn->prepare("SELECT id, employee_number, first_name, middle_name, last_name, email, supervisoremail, position, business_unit, department, account_type, date FROM bsc_accounts WHERE client = ? ORDER BY first_name ASC");
    $stmt->bind_param('i',$_SESSION['client_id']);
  }  elseif($_SESSION['account_type']==2){
     $stmt = $conn->prepare("SELECT id, employee_number, first_name, middle_name, last_name, email, supervisoremail, position, business_unit, department, account_type, date FROM bsc_accounts WHERE client = ? AND business_unit=? ORDER BY first_name ASC");
    $stmt->bind_param('ii',$_SESSION['client_id'],$_SESSION['business_unit']);
  }  
  
  else{
      $stmt = $conn->prepare("SELECT id, employee_number, first_name, middle_name, last_name, email, supervisoremail, position, business_unit, department, account_type, date FROM bsc_accounts WHERE department=? AND business_unit=? AND client = ? ORDER BY first_name ASC");
    $stmt->bind_param('iii',$_SESSION['department_id'],$_SESSION['business_unit'],$_SESSION['client_id']);
  }
}
else{

  if($_SESSION['account_type']==1){
     $stmt = $conn->prepare("SELECT id, employee_number, first_name, middle_name, last_name, email, supervisoremail, position, business_unit, department, account_type, date FROM bsc_accounts WHERE client = ? ORDER BY first_name ASC");
    $stmt->bind_param('i',$_SESSION['client_id']);
  }  
  
  else{
      $stmt = $conn->prepare("SELECT id, employee_number, first_name, middle_name, last_name, email, supervisoremail, position, business_unit, department, account_type, date FROM bsc_accounts WHERE department=? AND client = ? ORDER BY first_name ASC");
    $stmt->bind_param('ii',$_SESSION['department_id'],$_SESSION['client_id']);
  } 

}
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($employee_id, $employee_number, $first_name, $middle_name, $last_name, $email, $supervisor_email, $position, $business_unit, $department, $account_type, $date);
    while($stmt->fetch()){

       ?>
                <div class="status-card">
                    <div class="card-header">
                     <?php echo $first_name.' '.$last_name; ?>
                    </div>
                    <ul class="sortable ui-sortable"
                        id="sort<?php echo $employee_id; ?>"
                        data-status-id="<?php echo $employee_id; ?>">
                <?php
         
          $stmt1 = $conn->prepare("SELECT DISTINCT(bsc_projects.id), name, manager, bsc_projects.start_date, end_date, bsc_projects.status  FROM bsc_project_tasks RIGHT JOIN bsc_projects ON bsc_projects.id=project_id WHERE (manager =? OR assigned=?) AND bsc_projects.status <> 4 ORDER BY bsc_projects.id ASC");
          $stmt1->bind_param('ii',$employee_id,$employee_id);    
          $stmt1->execute();
          $stmt1->store_result();
          $stmt1->bind_result($project_id,$project_name,$manager,$start_date,$end_date,$status);
          while($stmt1->fetch()){  
                  
                        ?>
                    
                     <li class="text-row ui-sortable-handle"
                            data-task-id="<?php echo $project_id; ?>" data-toggle="modal" data-target="#myProjectModal<?php echo $project_id; ?>"><?php echo ucfirst($project_name); ?><br>
                            <!--<span><i class="fa fa-comment-o"></i> 2</span> &nbsp;&nbsp;-->
                            <?php if(countAttachments($project_id)>0){
                           echo '<span><i class="fa fa-paperclip"></i> '.countAttachments($project_id).'</span>&nbsp;&nbsp;';
                                 }
                                   if(countAllTasks($project_id)<1){

                                  }elseif(countAllTasks($project_id)==countCompletedTasks($project_id)){
                                 echo '<span class="badge badge-primary"><i class="fa fa-check-square-o"></i> '.countCompletedTasks($project_id).' / '.countAllTasks($project_id).'</span>';   
                                  }else{
                                  echo '<span class="badge badge-warning"><i class="fa fa-check-square-o"></i> '. countCompletedTasks($project_id).' / '.countAllTasks($project_id).'</span>';
                                  }
                            ?>
                            <span style="float: right;" class="badge badge-secondary"><?php echo getInitials(getEmployeeName($manager)); ?></span>&nbsp;   
                     </li>
                   

            <div class="modal inmodal fade" id="myProjectModal<?php echo $project_id; ?>" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 contenteditable="true"><b> <?php echo ucwords($project_name); ?></b></h4>
                                      </div>

                        <div class="modal-body">
                    <div class="container">
                   
                        <div id="add_to_me<?php echo $project_id; ?>" style="overflow-x: auto;" class="table-responsive">
                        
                         <table id="add_to<?php echo $project_id; ?>" class="table table-striped table-bordered table-hover dataTables-example">
                          
                       <?php   getProjectTasks($project_id); ?>
                         </table>  

                    </div>
                    </div>
                          <input type="hidden" id="task_id" value="0" >
                          <br>
                     <div class="row" id="button<?php echo $project_id; ?>">
                     <button class="btn btn-primary btn-sm" onclick="addCode(<?php echo $project_id; ?>)">Add Check List</button>
                         </div>
                          <p id="warning<?php echo $project_id; ?>" style="color: red;"></p>   
                              </div>
                              
                <div class="modal-footer">
                 <!-- getProjectStatus($status,$id);  -->
                                                     
                 <button class="btn btn-warning" data-toggle="modal" data-target="#archieveCard<?php echo $project_id; ?>" style="float: right;">Archieve </button>
                  <button type="button" onClick="location.reload();" class="btn btn-primary" data-dismiss="modal">Done</button>

                  <div class="modal inmodal fade" id="archieveCard<?php echo $project_id; ?>" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h3>Archieving....</h3>
                                             <b> <font color="#175ea8"><?php echo ucfirst($project_name); ?> </font></b>
                            
                                        </div>
                                        <div class="modal-body">
                                  <h5><font color="red">Are you sure? Archieved projects can be found in archieves </font></h5>
                                        </div>

                                        <div class="modal-footer">
                                        <button class="btn btn-outline-info" data-dismiss="modal">No</buuton>
                                            <button type="button" class="btn btn-outline-danger" onclick="achieveCard(<?php echo $project_id; ?>, <?php echo $employee_id; ?>)">Proceed</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                        
                                    </div>
                                    </div>
                                </div>
                            </div>
                            
                <?php
                    }
                    $stmt1->close();
                ?>
                <div class="status-card">

                    <div class="card-header">
                    </div>
           
               <div id="myNewCard<?php echo $employee_id; ?>">
              
               </div>
               <div id="buttons<?php echo $employee_id; ?>">
               

               <button class="btn btn-outline-primary btn-sm" onClick="newCard(<?php echo $employee_id; ?>)"><i class="fa fa-plus"> New Project</i></button>
           
                
                    </div>
                    </div> 
                  </ul>
                </div>
                <?php   
    }
  }
  
    function getCardsFor1($scorecard_id){

    // Database connection
    $conn = dbconnect();
    $owner = getOwnerID($scorecard_id);
 
    $stmt = $conn->prepare("SELECT id, first_name, last_name FROM bsc_accounts WHERE id=?");
    $stmt->bind_param('i',$owner);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($employee_id, $first_name, $last_name);
    $stmt->fetch();
    $stmt->close();

       ?>
                <div class="status-card">
                    <div class="card-header">
                     <?php echo $first_name.' '.$last_name; ?>
                    </div>
                    <ul class="sortable ui-sortable"
                        id="sort<?php echo $employee_id; ?>"
                        data-status-id="<?php echo $employee_id; ?>">
                <?php
         
          $stmt1 = $conn->prepare("SELECT DISTINCT(bsc_projects.id), name, manager, bsc_projects.start_date, end_date, bsc_projects.status  FROM bsc_project_tasks RIGHT JOIN bsc_projects ON bsc_projects.id=project_id WHERE (manager =? OR assigned=?) AND bsc_projects.status <> 4 ORDER BY bsc_projects.id ASC");
          $stmt1->bind_param('ii',$employee_id,$employee_id);    
          $stmt1->execute();
          $stmt1->store_result();
          $stmt1->bind_result($project_id,$project_name,$manager,$start_date,$end_date,$status);
          while($stmt1->fetch()){  
                  
                        ?>
                    
                     <li class="text-row ui-sortable-handle"
                            data-task-id="<?php echo $project_id; ?>" data-toggle="modal" data-target="#myProjectModal<?php echo $project_id; ?>"><?php echo ucfirst($project_name); ?><br>
                            <!--<span><i class="fa fa-comment-o"></i> 2</span> &nbsp;&nbsp;-->
                            <?php if(countAttachments($project_id)>0){
                           echo '<span><i class="fa fa-paperclip"></i> '.countAttachments($project_id).'</span>&nbsp;&nbsp;';
                                 }
                                   if(countAllTasks($project_id)<1){

                                  }elseif(countAllTasks($project_id)==countCompletedTasks($project_id)){
                                 echo '<span class="badge badge-primary"><i class="fa fa-check-square-o"></i> '.countCompletedTasks($project_id).' / '.countAllTasks($project_id).'</span>';   
                                  }else{
                                  echo '<span class="badge badge-warning"><i class="fa fa-check-square-o"></i> '. countCompletedTasks($project_id).' / '.countAllTasks($project_id).'</span>';
                                  }
                            ?>
                            <span style="float: right;" class="badge badge-secondary"><?php echo getInitials(getEmployeeName($manager)); ?></span>&nbsp;   
                     </li>
                   

            <div class="modal inmodal fade" id="myProjectModal<?php echo $project_id; ?>" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 contenteditable="true"><b> <?php echo ucwords($project_name); ?></b></h4>
                                      </div>

                        <div class="modal-body">
                    <div class="container">
                   
                        <div id="add_to_me<?php echo $project_id; ?>" style="overflow-x: auto;" class="table-responsive">
                        
                         <table id="add_to<?php echo $project_id; ?>" class="table table-striped table-bordered table-hover dataTables-example">
                          
                       <?php   getProjectTasks($project_id); ?>
                         </table>  

                    </div>
                    </div>
                          <input type="hidden" id="task_id" value="0" >
                          <br>
                     <div class="row" id="button<?php echo $project_id; ?>">
                     <button class="btn btn-primary btn-sm" onclick="addCode(<?php echo $project_id; ?>)">Add Check List</button>
                         </div>
                          <p id="warning<?php echo $project_id; ?>" style="color: red;"></p>   
                              </div>
                              
                <div class="modal-footer">
                 <!-- getProjectStatus($status,$id);  -->
                                                     
                 <button class="btn btn-warning" data-toggle="modal" data-target="#archieveCard<?php echo $project_id; ?>" style="float: right;">Archieve </button>
                  <button type="button" onClick="location.reload();" class="btn btn-primary" data-dismiss="modal">Done</button>

                  <div class="modal inmodal fade" id="archieveCard<?php echo $project_id; ?>" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h3>Archieving....</h3>
                                             <b> <font color="#175ea8"><?php echo ucfirst($project_name); ?> </font></b>
                            
                                        </div>
                                        <div class="modal-body">
                                  <h5><font color="red">Are you sure? Archieved projects can be found in archieves </font></h5>
                                        </div>

                                        <div class="modal-footer">
                                        <button class="btn btn-outline-info" data-dismiss="modal">No</buuton>
                                            <button type="button" class="btn btn-outline-danger" onclick="achieveCard(<?php echo $project_id; ?>, <?php echo $employee_id; ?>)">Proceed</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                        
                                    </div>
                                    </div>
                                </div>
                            </div>
                            
                <?php
                    }
                    $stmt1->close();
                ?>
                <div class="status-card">

                    <div class="card-header">
                    </div>
           
               <div id="myNewCard<?php echo $employee_id; ?>">
              
               </div>
               <div id="buttons<?php echo $employee_id; ?>">
               

               <button class="btn btn-outline-primary btn-sm" onClick="newCard(<?php echo $employee_id; ?>)"><i class="fa fa-plus"> New Project</i></button>
           
                
                    </div>
                    </div> 
                  </ul>
                </div>
                <?php   
    
  }


   function getArchievedCards(){

    // Database connection
    $conn = dbconnect();


  if(countBusinessUnits()>0){
   if($_SESSION['account_type']==1){
     $stmt = $conn->prepare("SELECT id, employee_number, first_name, middle_name, last_name, email, supervisoremail, position, business_unit, department, account_type, date FROM bsc_accounts WHERE client = ? ORDER BY first_name ASC");
    $stmt->bind_param('i',$_SESSION['client_id']);
  }  elseif($_SESSION['account_type']==2){
     $stmt = $conn->prepare("SELECT id, employee_number, first_name, middle_name, last_name, email, supervisoremail, position, business_unit, department, account_type, date FROM bsc_accounts WHERE client = ? AND business_unit=? ORDER BY first_name ASC");
    $stmt->bind_param('ii',$_SESSION['client_id'],$_SESSION['business_unit']);
  }  
  
  else{
      $stmt = $conn->prepare("SELECT id, employee_number, first_name, middle_name, last_name, email, supervisoremail, position, business_unit, department, account_type, date FROM bsc_accounts WHERE department=? AND business_unit=? AND client = ? ORDER BY first_name ASC");
    $stmt->bind_param('iii',$_SESSION['department_id'],$_SESSION['business_unit'],$_SESSION['client_id']);
  }
}
else{

  if($_SESSION['account_type']==1){
     $stmt = $conn->prepare("SELECT id, employee_number, first_name, middle_name, last_name, email, supervisoremail, position, business_unit, department, account_type, date FROM bsc_accounts WHERE client = ? ORDER BY first_name ASC");
    $stmt->bind_param('i',$_SESSION['client_id']);
  }  
  
  else{
      $stmt = $conn->prepare("SELECT id, employee_number, first_name, middle_name, last_name, email, supervisoremail, position, business_unit, department, account_type, date FROM bsc_accounts WHERE department=? AND client = ? ORDER BY first_name ASC");
    $stmt->bind_param('ii',$_SESSION['department_id'],$_SESSION['client_id']);
  } 

}
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($employee_id, $employee_number, $first_name, $middle_name, $last_name, $email, $supervisor_email, $position, $business_unit, $department, $account_type, $date);
    while($stmt->fetch()){

    $st = $conn->prepare("SELECT COUNT(id) FROM bsc_projects WHERE manager =? AND status = 4");
    $st->bind_param('i',$employee_id);    
    $st->execute();
    $st->store_result();
    $st->bind_result($count);
    $st->fetch();
    $st->close();
    if($count >=1){

       ?>
                <div class="status-card">
                    <div class="card-header">
                     <?php echo $first_name.' '.$last_name; ?>
                    </div>
                    <ul class="sortable ui-sortable"
                        id="sort<?php echo $employee_id; ?>"
                        data-status-id="<?php echo $employee_id; ?>">
                <?php
         
          $stmt1 = $conn->prepare("SELECT DISTINCT(bsc_projects.id), name, manager, bsc_projects.start_date, end_date, bsc_projects.status  FROM bsc_projects LEFT JOIN bsc_project_tasks ON bsc_projects.id=project_id WHERE (manager =? OR assigned=?) AND bsc_projects.status = 4 ORDER BY bsc_projects.id ASC");
          $stmt1->bind_param('ii',$employee_id,$employee_id);    
          $stmt1->execute();
          $stmt1->store_result();
          $stmt1->bind_result($project_id,$project_name,$manager,$start_date,$end_date,$status);
          while($stmt1->fetch()){  
      
                  
                        ?>
                    
                     <li class="text-row ui-sortable-handle"
                            data-task-id="<?php echo $project_id; ?>" data-toggle="modal" data-target="#myProjectModal<?php echo $project_id; ?>"><?php echo ucfirst($project_name); ?><br>
                            <!--<span><i class="fa fa-comment-o"></i> 2</span> &nbsp;&nbsp;-->
                            <?php if(countAttachments($project_id)>0){
                           echo '<span><i class="fa fa-paperclip"></i> '.countAttachments($project_id).'</span>&nbsp;&nbsp;';
                                 }
                                   if(countAllTasks($project_id)<1){

                                  }elseif(countAllTasks($project_id)==countCompletedTasks($project_id)){
                                 echo '<span class="badge badge-primary"><i class="fa fa-check-square-o"></i> '.countCompletedTasks($project_id).' / '.countAllTasks($project_id).'</span>';   
                                  }else{
                                  echo '<span class="badge badge-warning"><i class="fa fa-check-square-o"></i> '. countCompletedTasks($project_id).' / '.countAllTasks($project_id).'</span>';
                                  }
                            ?>
                            <span style="float: right;" class="badge badge-secondary"><?php echo getInitials(getEmployeeName($manager)); ?></span>&nbsp;   
                     </li>
                   

            <div class="modal inmodal fade" id="myProjectModal<?php echo $project_id; ?>" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 contenteditable="true"><b> <?php echo ucwords($project_name); ?></b></h4>
                                      </div>

                        <div class="modal-body">
                    <div class="container">
                   
                        <div id="add_to_me<?php echo $project_id; ?>" style="overflow-x: auto;" class="table-responsive">
                        
                         <table id="add_to<?php echo $project_id; ?>" class="table table-striped table-bordered table-hover dataTables-example">
                          
                       <?php   getArchivedProjectTasks($project_id); ?>
                         </table>  

                    </div>
                    </div>
                              
                <div class="modal-footer">
                 <!-- getProjectStatus($status,$id);  -->
                                                     
                 <button class="btn btn-success" data-toggle="modal" data-target="#restoreCard<?php echo $project_id; ?>" style="float: right;">Restore Card </button>
                  <button type="button" onClick="location.reload();" class="btn btn-primary" data-dismiss="modal">Done</button>

                                        
                                    </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            
                            <div class="modal inmodal fade" id="restoreCard<?php echo $project_id; ?>" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h3>Restoring....</h3>
                                             <b> <font color="#175ea8"><?php echo ucfirst($project_name); ?> </font></b>
                            
                                        </div>
                                        <div class="modal-body">
                                  <h5><font color="green">Are you sure? Project Wil be Active again </font></h5>
                                        </div>

                                        <div class="modal-footer">
                                        <button class="btn btn-outline-info" data-dismiss="modal">No</buuton>
                                            <button type="button" class="ladda-button ladda-button-demo btn btn-success"  data-style="zoom-in"" onclick="restoreCard(<?php echo $project_id; ?>, <?php echo $employee_id; ?>)">Proceed</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                <?php 
                        
                        }
                    $stmt1->close();
                ?>
                    <!--</div> -->
                  </ul>
                </div>
                <?php   
    }
  }
}

  function getSingleCardToAppend($employee_id){
    $conn=dbconnect();

          $stmt1 = $conn->prepare("SELECT DISTINCT(bsc_projects.id), name, manager, bsc_projects.start_date, end_date, bsc_projects.status FROM bsc_project_tasks RIGHT JOIN bsc_projects ON bsc_projects.id=project_id WHERE (manager =? OR assigned=?) AND bsc_projects.status <> 4 ORDER BY bsc_projects.id ASC");
          $stmt1->bind_param('ii',$employee_id,$employee_id);    
          $stmt1->execute();
          $stmt1->store_result();
          $stmt1->bind_result($project_id,$project_name,$manager,$start_date,$end_date,$status);
          while($stmt1->fetch()){  
                  
                        ?>
                
                     <li class="text-row ui-sortable-handle"
                            data-task-id="<?php echo $project_id; ?>" data-toggle="modal" data-target="#myProjectModal<?php echo $project_id; ?>"><?php echo ucfirst($project_name); ?><br>
                            <!--<span><i class="fa fa-comment-o"></i> 2</span> &nbsp;&nbsp;-->
                            <?php if(countAttachments($project_id)>0){
                           echo '<span><i class="fa fa-paperclip"></i> '.countAttachments($project_id).'</span>&nbsp;&nbsp;';
                                 }
                                   if(countAllTasks($project_id)<1){

                                  }elseif(countAllTasks($project_id)==countCompletedTasks($project_id)){
                                 echo '<span class="badge badge-primary"><i class="fa fa-check-square-o"></i> '.countCompletedTasks($project_id).' / '.countAllTasks($project_id).'</span>';   
                                  }else{
                                  echo '<span class="badge badge-warning"><i class="fa fa-check-square-o"></i> '. countCompletedTasks($project_id).' / '.countAllTasks($project_id).'</span>';
                                  }
                            ?>
                            <span style="float: right;" class="badge badge-secondary">NZ</span>&nbsp;   
                     </li>

            <div class="modal inmodal fade" id="myProjectModal<?php echo $project_id; ?>" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 contenteditable="true"><b> <?php echo ucwords($project_name); ?></b></h4>
                                      </div>

                        <div class="modal-body">
                    <div class="container">
  
                        <div id="add_to_me<?php echo $project_id; ?>" style="overflow-x: auto;">
                        <ul style="text-align: left;" id="add_to<?php echo $project_id; ?>">
                          
                       <?php   getProjectTasks($project_id); ?>
                         </ul>
                       

                    </div>
                    </div>
                          <input type="hidden" id="task_id" value="0" >
                          <br>
                     <div class="row" id="button<?php echo $project_id; ?>">
                     <button class="btn btn-primary btn-sm" onclick="addCode(<?php echo $project_id; ?>)">Add Check List</button>
                         </div>
                          <p id="warning<?php echo $project_id; ?>" style="color: red;"></p>   
                              </div>
                              
                <div class="modal-footer">
                 <!-- getProjectStatus($status,$id);  -->
                                                     
                  <button class="btn btn-warning" onclick="achieveCard(<?php echo $project_id; ?>, <?php echo $employee_id; ?>)" style="float: right;">Archieve </button>
                  <button type="button" onClick="location.reload();" class="btn btn-primary" data-dismiss="modal">Done</button>
                                        
                                    </div>
                                    </div>
                                </div>
                            </div>
                            
                <?php
                    }
                    $stmt1->close();
                ?>
                <div class="status-card">

                    <div class="card-header">
                    </div>
           
               <div id="myNewCard<?php echo $employee_id; ?>">
              
               </div>
               <div id="buttons<?php echo $employee_id; ?>">
               

               <button class="btn btn-outline-primary btn-sm" onClick="newCard(<?php echo $employee_id; ?>)"><i class="fa fa-plus"> New card</i></button>
           
                
                    </div>
                    </div> 
<?php
  }

  function countAttachments($project_id){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM  bsc_project_tasks WHERE project_id=? AND document<>''");
    $stmt->bind_param('i',$project_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();   
    $stmt->close();
    $conn->close();
return $count;

  }

    function countCompletedTasks($project_id){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM  bsc_project_tasks WHERE project_id=? AND completion =100");
    $stmt->bind_param('i',$project_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();   
    $stmt->close();
    $conn->close();
return $count;

  }

      function countAllTasks($project_id){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM  bsc_project_tasks WHERE project_id=?");
    $stmt->bind_param('i',$project_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();   
    $stmt->close();
    $conn->close();
return $count;

  }

        function getAssigned($task_id){

    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT assigned FROM bsc_project_tasks WHERE id=?");
    $stmt->bind_param('i',$task_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($assigned);
    $stmt->fetch();   
    $stmt->close();
    
    if(strlen($assigned)<1){

    $stmt = $conn->prepare("SELECT manager FROM bsc_projects RIGHT JOIN bsc_project_tasks ON project_id=bsc_projects.id WHERE bsc_project_tasks.id=?");
    $stmt->bind_param('i',$task_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($assigned);
    $stmt->fetch();   
    $stmt->close();

    }
     $conn->close();
   return getEmployeeName($assigned);

  }

  function getInitials($string){

$words = explode(" ", $string);
$letters = "";
foreach ($words as $value) {
    $letters .= substr($value, 0, 1);
}
return strtoupper($letters);

  }

function setSessions(){

 $conn=dbconnect();

  $stmt=$conn->prepare("SELECT id, client_id, code, start_date, end_date, max_scorecards, last_updated FROM bsc_max_scorecards");
  //$stmt->bind_param('s', $client_code); 
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($id,$client_id,$code, $start_date, $end_date, $max_scorecards,$last_updated);
  While($stmt->fetch()){
   echo '<tr>
     <td>'.getClientName($client_id).'</td>
     <td>'.$start_date.'</td>
     <td>'.$end_date.'</td>
     <td>'.$max_scorecards.'</td>
     <td></td>
     <td></td>
     <td>'.substr($last_updated,0,11).'</td>
     <td><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#update'.$id.'">Update</a>';


      echo'<div class="modal inmodal fade" id="update'.$id.'" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h3> <b> '.getClientName($client_id).' </b></h3>
                                        </div>
                                        <div class="modal-body">
                                        <label>Start Date</label>
                                        <input type="date" id="start_date" class="form-control" value="'.$start_date.'">
                                        <br>
                                         <label>End Date</label>
                                        <input type="date" id="end_date" class="form-control" value="'.$end_date.'">
                                        <br>
                                         <label>Maximum Scorecards</label>
                                        <input type="number" id="max" class="form-control" value="'.$max_scorecards.'" min="1">
                            
                                        </div>

                                        <div class="modal-footer">
                                        <button class="btn btn-outline-info" data-dismiss="modal">Close</buuton>
                                            <button type="button" class="btn btn-outline-danger" onclick="updateMax('.$id.')" data-dismiss="modal">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';
echo' </td>
      </tr>';
  }
  $stmt->close();
  $conn->close();
  }
    //      $_SESSION["start_time"] = date('Y-m-d H:i:s');
      // $_SESSION["client_code"] = $code;
      // $_SESSION["logged"] = true;
     //    $login = true;
     //    break; 

        // session_start();

   function updateScore($measure_id,$actual){
    error_reporting(0);
    $conn = dbconnect();

    $stmt = $conn->prepare("SELECT base_target, stretch_target, allocated_weight FROM bsc_targets WHERE id=?");
    $stmt->bind_param('i',$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($base_target, $stretch_target,$allocated_weight);
    $stmt->fetch();
  
   if(strlen($actual)<1){
     $weighted_rating=' ';
    }
    elseif($stretch_target==$base_target AND $stretch_target==$actual){
      $weighted_rating=$allocated_weight; 
    }
     elseif($base_target==$actual){
      $weighted_rating=0; 
    }
    else{
    $weighted_rating=(($actual-$base_target)/($stretch_target-$base_target))*$allocated_weight;
    if($weighted_rating>$allocated_weight){
      $weighted_rating=$allocated_weight;
    }
    elseif($weighted_rating<-$allocated_weight){
      $weighted_rating=-$allocated_weight;
    }
    else{
    
    }
   }
    $stmt->close();

return $weighted_rating;
   
 }

 function getFilteredWeightedRating($measure_id,$month){
    error_reporting(0);
    $conn = dbconnect();

    $actual = getMonthlyAmount($measure_id, $month);
   
    
    $stmt = $conn->prepare("SELECT base_target, stretch_target, allocated_weight FROM bsc_targets WHERE id=?");
    $stmt->bind_param('i',$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($base_target, $stretch_target,$allocated_weight);
    $stmt->fetch();
  
    if(strlen($actual)<1){
     $weighted_rating=' ';
    }

    elseif($stretch_target==$base_target AND $stretch_target==$actual){
      $weighted_rating=$allocated_weight; 
    }
    elseif($base_target==$actual){
      $weighted_rating=0; 
    }
    else{
      $weighted_rating=(($actual-$base_target)/($stretch_target-$base_target))*$allocated_weight;
        if($weighted_rating>$allocated_weight){
        $weighted_rating=$allocated_weight;
        }
        elseif($weighted_rating<-$allocated_weight){
        $weighted_rating=-$allocated_weight;
        }
        else{
        
        }
    }
    $stmt->close();
    $conn->close();

  return $weighted_rating;
    }

 function getMonthlyAmount($measure_id, $month){
  $conn=dbconnect();
    
   //  $rf = getReportingFrequency($measure_id);
    
   // $y = date('Y', strtotime($month));
   // $w = date('W', strtotime($month));
   // $c = "-W";

   // $st = $y.$c.$w;
   // $ew = $w+3;
   // $end = $y.$c.$ew;


    // if($rf == 'W'){
    //     $stmt = $conn->prepare("SELECT AVG(amount) FROM bsc_weekly WHERE target_id=? AND (week > ? OR week <?)");
    //     $stmt->bind_param('iss',$measure_id,$st,$end); 
    // } 
    // else{
    $stmt = $conn->prepare("SELECT AVG(amount) FROM bsc_monthly WHERE target_id=? AND month=?");
    $stmt->bind_param('is',$measure_id,$month);
    //}
  
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $amount;
 }

      function getFilteredWR($scorecard_id,$perspective_id,$month){

    $conn = dbconnect();
    $total=0;
    $stmt = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE perspective_id=? AND scorecard_id=?");
    $stmt->bind_param('ii',$perspective_id,$scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($measure_id);
    While($stmt->fetch()){
        $total+=getFilteredWeightedRating($measure_id,$month); 
      }
    return $total;
  }

   function getFilteredTotalWR($scorecard_id,$month){

    $conn = dbconnect();
    $total=0;
  
    $stmt = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE scorecard_id=?");
    $stmt->bind_param('i',$scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($measure_id);
    While($stmt->fetch()){
        $total+=getFilteredWeightedRating($measure_id,$month); 
      }
    return $total;
  }


   function getRangedMonthlyAmount($measure_id, $from,$to){
  $conn=dbconnect();
  error_reporting(0);
    //$sum;

    $stmt = $conn->prepare("SELECT AVG(amount) FROM bsc_monthly WHERE target_id=? AND (month <=? AND month >=?)");
    $stmt->bind_param('iss',$measure_id,$to,$from);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($amount);
    $stmt->fetch();
    // while($stmt->fetch()){
      
    //   if($amount !='' OR $amount !=' '){
    //     $sum += $amount; 
    //   }
      
    // }
    $stmt->close();
    $conn->close();
    return $amount;
  }

  function getRangedWeightedRating($measure_id,$from,$to){
   // error_reporting(0);
    $conn = dbconnect();

    $actual = getRangedMonthlyAmount($measure_id, $from,$to);

    $stmt = $conn->prepare("SELECT base_target, stretch_target, allocated_weight FROM bsc_targets WHERE id=?");
    $stmt->bind_param('i',$measure_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($base_target, $stretch_target,$allocated_weight);
    $stmt->fetch();
  
    if(strlen($actual)<1){
     $weighted_rating=' ';
    }
    elseif($stretch_target==$base_target AND $stretch_target==$actual){
      $weighted_rating=$allocated_weight; 
    }
     elseif($base_target==$actual){
      $weighted_rating=0; 
    }
    else{
    $weighted_rating=(($actual-$base_target)/($stretch_target-$base_target))*$allocated_weight;
    if($weighted_rating>$allocated_weight){
      $weighted_rating=$allocated_weight;
    }
    elseif($weighted_rating<-$allocated_weight){
      $weighted_rating=-$allocated_weight;
    }
    else{
    
    }
  }
    $stmt->close();
    $conn->close();

  return $weighted_rating;
    }

   function getRangedWR($scorecard_id,$perspective_id,$from,$to){

    $conn = dbconnect();
    $total=0;
    $stmt = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE perspective_id=? AND scorecard_id=?");
    $stmt->bind_param('ii',$perspective_id,$scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($measure_id);
    While($stmt->fetch()){
        $total+=getRangedWeightedRating($measure_id,$from,$to); 
      }
    return $total;
  }

   function getRangedTotalWR($scorecard_id,$from,$to){

    $conn = dbconnect();
    $total=0;
  
    $stmt = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE scorecard_id=?");
    $stmt->bind_param('i',$scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($measure_id);
    While($stmt->fetch()){
        $total+=getRangedWeightedRating($measure_id,$from,$to); 
      }
    return $total;
  }

   function getRangedDepartmentalAVG($department_id,$from,$to){

    $conn = dbconnect();
    $total=0;
    $client_id=$_SESSION['client_id'];

    $stmt1 = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? AND department_id=?");
    $stmt1->bind_param('ii',$client_id,$department_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE client_id=? AND department_id=?");
    $stmt->bind_param('ii',$client_id,$department_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id);
    While($stmt->fetch()){
    $total+=getRangedTotalWR($scorecard_id,$from,$to);
   
    }
    $stmt->close();
    $conn->close();
    if($count !=0){
    $average=$total/$count;
      return $average;
}else{
  return 0;
}
    }

     function getRangedDepartmentPerspectiveAVG($department_id,$perspective_id,$from,$to){

    $conn = dbconnect();
    $client_id=$_SESSION['client_id'];

    $stmt1 = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=? AND department_id=?");
    $stmt1->bind_param('ii',$client_id,$department_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE client_id=? AND department_id=?");
    $stmt->bind_param('ii',$client_id,$department_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id);
    While($stmt->fetch()){
   $total+=getRangedWR($scorecard_id,$perspective_id,$from,$to);
   
    }
    $stmt->close();
    $conn->close();
    if($count !=0){
    $average=$total/$count;
      
}else{
  $average=0;
}
 return $average;
  }


function getRangedCompanyAVG($from,$to){

    $conn = dbconnect();
    $total=0;
    $client_id=$_SESSION['client_id'];

    $stmt1 = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=?");
    $stmt1->bind_param('i',$client_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE client_id=?");
    $stmt->bind_param('i',$client_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id);
    While($stmt->fetch()){
   $total+=getRangedTotalWR($scorecard_id,$from,$to);
   
    }
    $stmt->close();
    $conn->close();
    if($count !=0){
    $average=$total/$count;
      return $average;
}else{
  return "not available";
}
}

function getRangedCompanyPerspectiveAVG($perspective_id,$from,$to){

    $conn = dbconnect();
    $total=0;
    $client_id=$_SESSION['client_id'];

    $stmt1 = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_scorecards WHERE client_id=?");
    $stmt1->bind_param('i',$client_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $conn->prepare("SELECT id FROM bsc_scorecards WHERE client_id=?");
    $stmt->bind_param('i',$client_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id);
    While($stmt->fetch()){
   $total+=getRangedWR($scorecard_id,$perspective_id,$from,$to);
   
    }
    $stmt->close();
    $conn->close();
    if($count !=0){
    $average=$total/$count;
      return $average;
}else{
  return "not available";
}
}

function countComments($measure_id){
    $conn=dbconnect();
    
    $stmt = $conn->prepare("SELECT COUNT(*) FROM  bsc_comments WHERE measure_id=? AND status =?");
    $stmt->bind_param('ii',$measure_id,$status);
    $status=0;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();   
    $stmt->close();
    $conn->close();
   
    if($count==0){
      return '';
    } else{
      return $count;
    }
    
}


     function getFilteredGoalWR($goal_id,$month){

    $conn = dbconnect();

    $total=0;
    $stmt = $conn->prepare("SELECT bsc_targets.id FROM bsc_targets LEFT JOIN bsc_goals ON bsc_goals.id=goal_id WHERE goal_id=?");
    $stmt->bind_param('i',$goal_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($measure_id);
    While($stmt->fetch()){ 

        $total+=getFilteredWeightedRating($measure_id,$month); 
      }
    return $total;
  }
?>