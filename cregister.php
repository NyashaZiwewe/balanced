<?php include"cheader.php"; ?>


<body class="bg-gradient-grey">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-4"><img src="photos/logo2.png" align="left" width="" height="" hspace="20"></div>
          <div class="col-lg-8">
            <div class="p-5">
              <div align="right">
                <h1 class="h4 text-gray-900 mb-4">Create an Account! <a href="index.php" class="btn btn-primary">
                      Home
                    </a></h1>
              </div>
              
            <?php if(isset($_GET['email'])){ ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Acount Exists!</strong> There is an account associated with this email. Please check your spelling or go to sign in
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php } ?>

              <form id="signupForm" action="postSignUp.php" method="post">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                      <label for="first_name">First Name</label>
                      <input name="first_name" type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter first name" required>
 
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     
                      <label for="last_name">Last Name</label>
                      <input name="last_name" type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter last name" required>

                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <label for="email">Email Address</label>
                      <input name="email" type="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email address" required>

                    </div>
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
       
                      <label for="last_name">Level</label>
                      <select name="account_type" class="form-control" aria-describedby="emailHelp" placeholder="Enter last name" required>
                        <option value="3">Business Unit Manager</option>
                        <option value="3">Department Manager</option>
                        <option value="4">Employee</option>
                      </select>
                    </div>
                  </div>
                      
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <label for="client">Company</label>
                      <select name="client_id" class="form-control" aria-describedby="emailHelp" required>
                          <option value="" selected disabled>Select your Company</option>
                        <?php getcompany(); ?>
                      </select>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <label for="last_name">Department</label>
                      <select name="department_id" class="form-control" aria-describedby="emailHelp" placeholder="Enter last name" required>
                        <option selected disabled value="">Select your department</option>
                        <?php getDepartments(); ?>
                      </select>

                    </div>
                  </div>
                     <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <small id="emailHelp" class="form-text text-muted">Leave us a message on our contact page if your company name is not on the list.</small>
              
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            
                    <label for="last_name">Business Unit</label>
                      <select name="business_unit" class="form-control" aria-describedby="emailHelp">
                        <option selected disabled value="">Select your Business Unit</option>
                        <option value="">N/A</option>
    <?php   $conn = dbconnect();

    $stmt1 = $conn->prepare("SELECT id, name FROM bsc_business_units");
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($id,$name);
    while($stmt1->fetch()){
      echo '<option value="'.$id.'">'.$name.'</option>';
    
       }
    $stmt1->close();
    $conn->close();
    ?>
                      </select>   

                    </div>
                  </div>
                  
           <hr>       
               <div class="row"> 
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="business_unit">
                      
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                <input type="submit" name="submit" class="btn btn btn-primary"  value="Sign Up"/>
                 </div>
                 </div>
            </form>
       
              <div class="text-center">
                <a class="small" href="cforgot-password.php">Forgot Password?</a>
              </div>
              <div class="text-center">
                <a class="small" href="signin.php">Already have an account? Login!</a>
              </div>
                     <hr>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

<?php include"cfooter.php"; ?>
