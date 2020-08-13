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
              <div class="col-lg-4"><img src="photos/logo2.png" align="left" width="" height="" hspace="20"></div>
              <div class="col-lg-8">
                <div class="p-5">
                  <div align="right">
                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password? <a href="index.php" class="btn btn-primary">
                      Home
                    </a></h1>
                    <p align="justify">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p>
                  </div>
                  <form action="" method="post">
                    <div class="form-group">
                      <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>
                    <button type="submit" name="resetpass" class="btn btn-primary">
                      Reset Password
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="cregister.php">Create an Account!</a>
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

    </div>

  </div>

<?php include"cfooter.php"; ?>
