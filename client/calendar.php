<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>
<?php include"top_bar.php"; ?>

    <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Employee Records</h5>
                        <div class="ibox-tools">
                          <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i>Add New</a>
                           <a class="btn btn-primary btn-sm" href="add_multiple.php"><i class="fa fa-plus"></i>Add Multiple Accounts</a>
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



                            <div class="input-group clockpicker" data-autoclose="true">
                                <input type="text" class="form-control" value="09:30" >
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>


                    </div>
                </div>
            </div>
        </div>
    </div>


  
                 
        

   <?php include"footer.php"; ?>                 

    <script>
        $(document).ready(function(){

            $('.clockpicker').clockpicker();

        });
    </script>
