
<body class="fixed-sidebar fixed-nav skin-3">
  
    <div id="wrapper" class="toggled">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse" style="height: 100%; overflow-y: auto;">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                <?php 
                if(getCompanyProfilePic()!=''){
// echo'<img alt="image" class="rounded-circle" src="../company/'.getCompanyProfilePic().'" width="100" height="100" />';
echo'<img alt="image" class="rounded-circle" src="/leave/company/'.getCompanyProfilePic().'" width="100" height="100" />';
     }else{
echo'<img alt="image" class="rounded-circle" src="/leave/company/placeholder.png" width="100" height="100" />'; 
     } ?>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="block m-t-xs font-bold"><?php getClientName($_SESSION['client_id']); ?></span>
                        <span class="text-muted text-xs block"><?php echo getClientName($_SESSION['client_id']); ?><b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <!--<li><a class="dropdown-item" href="#">Profile</a></li>-->
                            <!-- <li><a class="dropdown-item" href="/leave/client/contacts.html">Contacts</a></li> -->
                            <!--<li><a class="dropdown-item" href="/leave/client/mailbox.php">Mailbox</a></li>-->
                            <!--<li class="dropdown-divider"></li>-->
                            <li><a class="dropdown-item" href="#"  data-target="#logout" data-toggle="modal">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                <li class="active"><a href="/leave/client/home"><i class="fa fa-tachometer" aria-hidden="true"></i> <span class="nav-label">Dashboard</span> </a></li>
                <li><a href="/leave/client/pending_leaves.php"><i class="fa fa-sitemap" aria-hidden="true"></i> <span class="nav-label">Queued Leaves</span> </a></li>
                <li><a href="/leave/client/my_leave_bank.php"><i class="fa fa-tachometer" aria-hidden="true"></i> <span class="nav-label">My Leave Bank</span> </a></li>                
                <li><a href="/leave/client/leave_history.php"><i class="fa fa-bar-chart-o" aria-hidden="true"></i> <span class="nav-label">Leave History</span> </a></li>
                <li><a href="/leave/client/leave_types.php"><i class="fa fa-sitemap" aria-hidden="true"></i> <span class="nav-label">Leave Types</span> </a></li>
                <li><a href="/leave/client/leave_reports.php"><i class="fa fa-sitemap" aria-hidden="true"></i> <span class="nav-label">Leave Types</span> </a></li>
                       

            </ul>

        </div>
    </nav>