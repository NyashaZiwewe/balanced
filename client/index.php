<?php include"header.php"; ?>

<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>
<?php error_reporting(0); ?>

        <div class="wrapper wrapper-content">
        <div class="row">
         
            <div class="col-lg-3">
            <a href="myscorecards">
                <!--<div class="widget style1 navy-bg">-->
                <div class="ibox">
                 <div class="ibox-title">
                     <!--<span class="label label-success float-right"></span>-->
                     <h5>Scorecards</h5>
                 </div>   
                 <div class="ibox-content">
                     <h4 class="no-margins"> <span class="label label-success"><?php echo getTotalScorecards(); ?></span></h4>
                     <div class="stat-percent font-bold text-success">
                           <?php
                          if(getTotalAccounts()<1)
                                {
                             $count='';
                                }else{
                          $accounts = getTotalAccounts();
                          $count= (getTotalScorecards()/$accounts)*100; 
                         }
                          echo round($count,2); 
                         
                        ?>% 
                     </div>
                     <small>Total Scorecards</small>
                 </div>
                </div>
                 </a> 
            </div>
            
               <div class="col-lg-3">
            <a href="mywatchlist">
                <!--<div class="widget style1 navy-bg">-->
                <div class="ibox">
                 <div class="ibox-title">
                     <!--<span class="label label-success float-right">Monthly</span>-->
                     <h5><font color="red">Watch List</font></h5>
                 </div>   
                 <div class="ibox-content">
                     <h4 class="no-margins"> <span class="label label-success"><?php echo getCountWatchList(); ?></span></h4>
                     <div class="stat-percent font-bold text-danger">
                       <?php if(getCountWatchList()!=0 || countScorecards(4)!=0){

                $answer=(getCountWatchList()/countScorecards(4))*100;
                echo round($answer,2).'%';
                }   ?>
                     </div>
                     <small>Less performers</small>
                 </div>
                </div>
                 </a> 
            </div>
            
        <div class="col-lg-3">
            <a href="actionPlans">
                <!--<div class="widget style1 navy-bg">-->
                <div class="ibox">
                 <div class="ibox-title">
                     <!--<span class="label label-success float-right">Monthly</span>-->
                     <h5>Action Plans</h5>
                 </div>   
                 <div class="ibox-content">
                     <h4 class="no-margins"> <span class="label label-success"></span></h4>
                     <div class="stat-percent font-bold text-success">
                 <?php 
                     $scorecard= getScoreCardID();
    
                 echo getOutstandingPercentage();?>
                     </div>
                     <small>Outstanding tasks</small>
                 </div>
                </div>
                 </a> 
            </div>
            
               <div class="col-lg-3">
            <a href="strategy">
                <!--<div class="widget style1 navy-bg">-->
                <div class="ibox">
                 <div class="ibox-title">
                     <!--<span class="label label-success float-right">Monthly</span>-->
                     <h5>Strategy</h5>
                 </div>   
                 <div class="ibox-content">
                     <h4 class="no-margins">
                          <span class="label label-success"></span></h4>
                     <div class="stat-percent font-bold text-success">
                         Strategy Map
                     </div>
                     <small>Strategic objectives</small>
                 </div>
                </div>
                 </a> 
            </div>
            </div>
            
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                   <div class="ibox-title">                                   
                            <h3 class="font-bold no-margins">
                             <b>Year to date Performance</b>
                           
                           
                           
   <a href="scorecard/<?php echo getScoreCardID();?>"> 

<?php $range= getTotalWR(getScoreCardID());

if($range < 0){
  
    echo ' <button type="button" class="btn btn-outline-danger m-r-sm">Overall Score: <b>'.$range.'%</b></button>';
}else{
    
 echo ' <button type="button" class="btn btn-outline-primary m-r-sm">Overall Score: <font color="green"><b>'.$range.'%</b></font></button>';
}
  ?>
   </a> </h3>
                        </div>
                         <div class="ibox-content" style="text-align: center">
                        
     <a href="new-design">
     
 <?php
 $scorecard_id=getScoreCardID();
  $count = countClientPerspectives() +1;
  for($i=1; $i<$count; $i++){
  canvas($scorecard_id,$i); echo "<font color='#fff'>......</font>";
 }
 ?></a>
                        
                     </div>
                    </div>
                </div>
            </div>
            
      <div class="col-lg-12">
        <div class="ibox">
        <div class="ibox-title">
            <h5>Strategy Implementation Progress </h5>
            <!--<div class="ibox-tools">-->
    <?php $range= round(getTotalProgress(),2);
    if($range >= 70){
        $class='progress-bar-primary';
    }elseif($range <70 && $range >=40){
        $class='progress-bar-warning';
    }else{
       $class='progress-bar-danger';  
    }
 
echo'<a href="actionplans"><div class="progress" style="height:30px">
  <div class="progress-bar '.$class.' progress-bar-striped progress-bar-animated" role="progressbar"
  aria-valuenow="'.$range.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$range.'%;height:30px">
    <font color="#000000"><b>'.$range.'% Complete </b></font>
  </div>
</div></a>';

  ?>
        </div>
        </div>
        </div>
        
        
        
        <div class="row">
            
                <div class="col-lg-6">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Month on month performance</h5>
                        </div>
                        <div class="ibox-content">
                            <div>
                                <canvas id="mybarChart" height="140"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                 <div class="col-lg-6">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Perspective weighting bias</h5>
                        </div>
                        <div class="ibox-content">
                            <div>
                                <canvas id="myradarChart" height="140"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

        </div> 

      
</div>


<?php //include"right_side_bar.php"; ?>
<?php include"footer.php"; ?>

 <script type="text/javascript">
   var ctx = document.getElementById('myradarChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'radar',

    // The data for our dataset
 data: {
   
     labels: [
    <?php 
    $scorecard_id=getScoreCardID();
    $conn=dbconnect();
    $stmt = $conn->prepare("SELECT perspective_id FROM bsc_client_perspectives WHERE client_id=? ORDER BY perspective_id ASC");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($perspective_id);
    while($stmt->fetch()){
    echo '"'.getPerspectiveName($perspective_id).'",';
    }
    $stmt->close();
    ?>
     ],
        datasets: [
            {
                label: "Allocated weights",
                backgroundColor: "rgba(220,220,220,0.2)",
                // borderColor: "rgba(220,220,220,4)",
                borderColor: "#175ea8",
                data: [
    <?php
    $stmt = $conn->prepare("SELECT perspective_id FROM bsc_client_perspectives WHERE client_id=? ORDER BY perspective_id ASC");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($perspective);
    while($stmt->fetch()){
    echo getPerspectiveTotalWeight($perspective,$scorecard_id).',';
    }
    $stmt->close();
    ?>

                ]
            },
            {
                label: "Scores",
                backgroundColor: "rgba(26,179,148,0.2)",
                borderColor: "rgba(26,179,148,2)",
                data: [
    <?php
    $stmt = $conn->prepare("SELECT perspective_id FROM bsc_client_perspectives WHERE client_id=? ORDER BY perspective_id ASC");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($pers);
    while($stmt->fetch()){

     echo getWR($scorecard_id,$pers);
     echo ',';
    }
    $stmt->close();
    ?>


                 // 45, 2, 16, 4,-5
                ]
            }
        ]
},

    // Configuration options go here
    options: {
        responsive: true,

            scale: {
        angleLines: {
            display: false
        },
        ticks: {
            suggestedMin: -25,
            suggestedMax: 40
        }
    }
    }
    
});
 </script>

<script type="text/javascript">
   var ctx = document.getElementById('mybarChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
 data: {
   
     labels: [
    <?php 

     $scorecard_id=getScoreCardID();
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
            echo '"'.$month.'",';
            $start = strtotime("+1 month", $start);
        }
    ?>
     ],
        datasets: [
            {
                 label: "Monthly Scores",
                backgroundColor: "rgba(26,179,148,0.8)",
                borderColor: "rgba(26,179,148,1)",
                data: [
               
               <?php 
              
                $s = strtotime($start_period);
                $e = strtotime($reporting_period);
             
            while($s < $e)
            {

             $month = date('Y-m', $s);
  
                echo round(getFilteredTotalWR($scorecard_id,$month),2).',';
               $s = strtotime("+1 month", $s);
            }

               ?>
                ]
            },

        ]
},

    // Configuration options go here
    options: {
        responsive: true,

            scale: {
        angleLines: {
            display: false
        },
    //     ticks: {
    //         suggestedMin: -25,
    //         suggestedMax: 40
    //     }
    }
    }
    
});
 </script>

