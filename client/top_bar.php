 <script type="text/javascript">
//      function redirect(val){
//         window.location.href = "mail_details.php?m="+val;
//      }
  </script>

 <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-fixed-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-outline-info" href="#"><i class="fa fa-tasks"></i></a>
            
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                <a href="javascript: history.go(-1)" class="btn btn-sm btn-outline-info"><i class="fa fa-backward"> Go Back </i></a>
                </li>&nbsp; &nbsp;
                 <li>
                <a onclick="location.reload();" class="btn btn-outline-info"> <i class="fa fa-refresh"> Refresh </i></a>
                </li>
                <li>&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;</li>
                <li>
                    <span class="m-r-sm text-muted welcome-message"> <b>  <?php if($_SESSION['account_type']==1){
            echo ucfirst(getClientName($_SESSION['client_id']));
                    }else{
            echo ucfirst($_SESSION['first_name']).' '.ucfirst($_SESSION['last_name']);
                    } ?></b></span>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning"><?php echo countEmails('bsc_emails',0); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages" >
                      <!--   <li>
                            <div class="dropdown-messages-box">
                                <a class="dropdown-item float-left" href="profile.html">
                                    <img alt="image" class="rounded-circle" src="img/a7.jpg">
                                </a>
                                <div>
                                    <small class="float-right">46h ago</small>
                                    <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-divider"></li> -->
                        <?php getNewMessages(); ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary"><?php echo getNotificationsCount(0); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                      <?php getNewNotifications(); ?>
                    </ul>
                </li>

                 <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>Account
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                           <a href="#" data-target="#logout" data-toggle="modal">
                               <i class="fa fa-sign-out"></i> Log out
                           </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <a href="#" data-target="#change_password" data-toggle="modal">
                            <i class="fa fa-cogs" aria-hidden="true"></i> Passowrd
                        </a>
                       </li>
                    </ul>
                </li>


              <!--   <li>
                    <a href="#" data-target="#logout" data-toggle="modal">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li> -->
                <li>
                    <a class="right-sidebar-toggle">
                        <i class="fa fa-tasks"></i>
                    </a>
                </li>
            </ul>

        </nav>
        </div>


       <!-- <div class="loader center"></div> -->
    <!-- </div> -->
