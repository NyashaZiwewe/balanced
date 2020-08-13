<?php include"functions.php"; ?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>IPC | Iperform</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">

    <link href="css/plugins/summernote/summernote-bs4.css" rel="stylesheet">

    <link href="css/plugins/select2/select2.min.css" rel="stylesheet">   
     
</head>


<body class="fixed-sidebar fixed-nav">
  
    <div id="wrapper" class="toggled">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
<img alt="image" class="rounded-circle" src="img/placeholder.png" width="100" height="100" />
     
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="block m-t-xs font-bold"></span>
                        <span class="text-muted text-xs block"><b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <!-- <li><a class="dropdown-item" href="contacts.html">Contacts</a></li> -->
                            <li><a class="dropdown-item" href="mailbox.php">Mailbox</a></li>
                            <li class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"  data-target="#logout" data-toggle="modal">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                <li class="active"><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> <span class="nav-label">Dashboard</span> </a></li>
            
            </ul>

        </div>
    </nav>




 <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-fixed-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-outline-info" href="#"><b>Click here to hide Side bar</b> </a>
            
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                <a href="javascript: history.go(-1)" class="btn btn-sm btn-outline-info"><i class="fa fa-backward"> Go Back </i></a>
                </li>&nbsp; &nbsp;
                 <li>
                <a onclick="location.reload();" class="btn btn-outline-info"> <i class="fa fa-refresh"> Refresh </i></a>
                </li>
                <li>
                    <a href="#" data-target="#logout" data-toggle="modal">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
                <li>
                    <a class="right-sidebar-toggle">
                        <i class="fa fa-tasks"></i>
                    </a>
                </li>
            </ul>

        </nav>
        </div>

                <script type="text/javascript">
        	function setSessions(){
          
                var client_code = document.getElementById("client_code").value;
                alert(client_code);
              

  $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    setSessions: "Nyengerai",
    client_code

  },
  success: function(data){
    alert(data);
    document.getElementById("table").innerHTML = data;

  }
  });

          $.ajax({
  type: "POST",
  url: "mx.php",
  data:{
    setSession: "Nyengerai",
    code: client_code

  },
  success: function(data){
  }
  });

  }
   
 </script>

 <?php if(isset($_POST['setSession'])){

$_SESSION['client_code'] = $_POST['code'];

session_start();
 }
?>

  <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Employee Records  
                      <?php if(isset($_SESSION['client_code'])){
                         echo $_SESSION['client_code']; 
                        } ?>  </h5>

                        <div class="ibox-tools">
                          <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i>Add New</a>
                           <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#upload"><i class="fa fa-plus"></i>Insert Client Code</a> 
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
                   
                    <input type="text" id="client_code" class="form-control" onkeypress="setSessions()">
                    <hr>

                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                    <tr>
                           <th>Client</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Max Scorecards</th>
                          <th>Total</th>
                          <th>Balance</th>
                          <th>Last Updated</th>
                          <th>Action</th>
                        </tr>
                    </tr>
                    </thead>
                    <tbody id="table">
                    <?php setSessions(); ?>
                    </tbody>
                    <tfoot>
                    <tr>
                          <th>Client</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Max Scorecards</th>
                          <th>Total</th>
                          <th>Balance</th>
                          <th>Last Updated</th>
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



 <?php include"footer.php"; ?>