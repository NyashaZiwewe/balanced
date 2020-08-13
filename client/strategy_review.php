<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>
<br>
                    <div class="ibox-title">
                 <?php if($_SESSION['account_type']!=1){ ?>
                      <a class="btn btn-outline-success" href="360.php">Assess Your Strategy</a> 
                  <?php } ?>
                      <?php if($_SESSION['account_type']!=4){ ?>
                      <a class="btn btn-outline-success" href="360_questions.php">Strategy Review Questions</a> 
                  <?php } ?>
                      <a class="btn btn-outline-success" href="#">Strategy Review Responses</a>
                      <?php if($_SESSION['account_type']!=4){ ?>
                      <a class="btn btn-outline-success" href="360_reports.php">Strategy Review Reports</a>
                  <?php } ?>
                    </div>
     

        <div class="wrapper wrapper-content animated fadeIn">

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                    <h5>Achor points of Success </h5>
                    </div>
                        <div class="ibox-content">

                            <div class="row">
                           
                                <div class="col-lg-3">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            Environmental Analysis
                                        </div>
                                        <div class="panel-body">
                                            <p align="justify">Process of estimating and evaluating significant short-term and long-term effects of variables in the business environment. The Internal and external environement need to be scanned before fomulating strategic objectives.</p>
                                        </div>
                                    </div>
                                </div>

                                 <div class="col-lg-3">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            Strategy Formulation
                                        </div>
                                        <div class="panel-body">
                                        <p align="justify">This is the process by which an organization chooses the most
                                        appropriate courses of action to achieve its defined goals. A strategic plan also enables you to allocate resources and determine the most effective plan to increase ROI.</p>
                                                                            </div>
                                    </div>
                                </div>

                                 <div class="col-lg-3">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            Strategy Implementation
                                        </div>
                                        <div class="panel-body">
                                            <p align="justify">This is a process that puts plans and strategies into action to reach desired goals. Its documentation defines the steps and processes, feedback and reporting needed to reach goals to ensure that the plan is on track..</p>
                                        </div>
                                    </div>
                                </div>

                                 <div class="col-lg-3">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            Evaluation  & Control
                                        </div>
                                        <div class="panel-body">
                                            <p align="justify">This means collecting information about how well the strategic plan is progressing. It is defined as the process of determining the effectiveness of a given strategy in achieving objectives and taking corrective measures wherever required.</p>
                                        </div>
                                    </div>
                                </div>
                          
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>

             <div class="row">
              <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>How it works?</h5>
                        <div class="ibox-tools">
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
                        <div class="scroll_content" style="height: 200px; overflow: auto;">
                            <p align="justify">
                               Every Employee must be able to see the direction of the organisation despite the level. Employees from all levels need to be involved in strategy formulation since strategy implementation heavily lies on their ends. Strategy review need not to be a nightmare to employees. They need feel that the strategy is being appraised not necessarily individuals.
                            </p>

                        
                            <p align="justify">
                               After assesment, the directors will see the reports for each segment of strategy. They may do a deeper research to find actual issues. This will help the organisation in making sure it is moving towards the desired direction.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


            </div>
  <?php include"footer.php"; ?>
