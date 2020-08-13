<?php include"cheader.php"; ?>

<body class="bg-gradient-grey">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-4"> <img src="photos/logo2.png" align="left" width="" height="" hspace="20"></div>
              <div class="col-lg-8">
                <div class="p-5">
                  <div align="right">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back User<a href="index.php" class="btn btn-primary">
                      Home
                    </a> </h1>
                  </div>
                 
<?php if(isset($_GET['failure'])){ ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Authentication Error!</strong> Please check your email and password and try again.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php } ?>
<?php if(isset($_GET['success'])){ ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Registration Successfull</strong> Please check your email for your credentials and log in.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php } ?>

                     <form action="postSignin.php" method="post">
                    <div class="form-group">
                      <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary">
                      Login
                    </button>
                    <hr>
                  </form>
             
                  <div class="text-center">
                    <a class="small" href="cforgot-password.php">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="cregister.php">Create an Account!</a>
                  </div>
                       <hr>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <?php include"cfooter.php"; ?>
