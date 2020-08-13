<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>
<?php include"top_bar.php"; ?>

    <!--<script src="../orgchart/getorgchart/getorgchart.js"></script>-->
    <!--<link href="../orgchart/getorgchart/getorgchart.css" rel="stylesheet" />-->
    <script src="https://balkangraph.com/js/latest/OrgChart.js"></script>
    <link href="/demo/orgchart/getorgchart/getorgchart.css" rel="stylesheet" />


    <style type="text/css">
  html, body{
  width: 100%;
  height: 100%;
  padding: 0;
  margin:0;
  overflow: hidden;
  font-family: Helvetica;
}
#tree{
  width:100%;
  height:100%;
}

.node.fail rect {
    fill: #FFCA28;
  
}
    .bg-search-table {
        background-color: #2E2E2E !important;
    }

    .bg-search-table input {
        background-color: #2E2E2E !important;
    }
    </style>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <!--<h5>Scorecard Cascading <a href="/demo/client/cascaded_performance" class="btn btn-outline-info">Old Design</a></h5>-->
                        Key: <button style="background-color: #ffca29; color: #175ea8">Poor Performance</button> <button style="background-color: #fff; color: #175ea8">Satisfactory Performance</button>
                    </div>
                    <div class="ibox-content">
               
                          <div id="tree"></div>
               
                    </div>
                </div>
            </div>
            </div>
        </div>

<?php 
$scorecard_id= getCoporateScorecard($_SESSION['client_id']);
$client_id=$_SESSION['client_id'];

  if(getCompanyAVG() < 0){
                  $tag0 ="fail";
              } else{
                  $tag0 ="pass";
              }
$conn=dbconnect();
?>
        <script type="text/javascript">
      
           
         function pdf(nodeId) {
     
             OrgChart.pdfPrevUI.show(chart, {
                filename: "<?php echo getClientName($_SESSION['client_id']); ?> Performance Report.pdf", 
                // expandChildren: true, 
                nodeId: nodeId,
                format: "A4",
                header: '<?php echo getClientName($_SESSION['client_id']); ?> Performance Report',
                footer: 'Prepared by Industrial Pyschology Consultants: <?php echo date('Y-m-d H:i'); ?>. Page {current-page} of {total-pages}'
            });
        }
          OrgChart.templates.ula.size = [200, 60];
          // var field_template = '<text width="230" text-overflow="ellipsis"  style="font-size: 12px;" fill="#757575" x="10" y="100" text-anchor="start">{val}</text>';

          OrgChart.templates.ula.field_4 = '<text width="180" text-overflow="multiline" style="font-size: 12px;" fill="#000" x="10" y="15" text-anchor="start">{val}</text>';
      

        var chart = new OrgChart(document.getElementById("tree"), {

           clinks: [
           <?php $conn=dbconnect();

    $stmt1 = $conn->prepare("SELECT COUNT(*) FROM bsc_goals WHERE scorecard_id=?");
    $stmt1->bind_param('i',$scorecard_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();
    $stmt1->close();
    $xpo = $count * ($count-1);
    $half = $xpo/2;

    $stmt = $conn->prepare("SELECT id, goal FROM bsc_goals WHERE scorecard_id=? ORDER BY id ASC");
    $stmt->bind_param('i',$scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($goal_id1, $goal1);
    while($stmt->fetch()){

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

    if($goal_id2 <> $goal_id1){
     $xpo--;

     if($xpo>=$half){
        if(!is_infinite(correlationCoefficient($arrX, $arrY, $n)) AND (correlationCoefficient($arrX, $arrY, $n) >= 0.8 OR correlationCoefficient($arrX, $arrY, $n) <= -0.8)){
        ?>

           {from: <?php echo $goal_id2; ?>, to: <?php echo $goal_id1; ?>, label: '<?php echo correlationCoefficient($arrX, $arrY, $n); ?>'},  

        <?php } 
        }
     }  
     //echo'<td>'.correlationCoefficient($arrX, $arrY, $n).'</td>';
  //}
    }
    $stmt1->close();
    }
    $stmt->close();
    ?>
                // {from: 1, to: 4, label: 'text'},  
                // {from: 5, to: 2, template: 'blue', label: ' 0.7*' },
                // {from: 6, to: 3, label: '0.24' },
                // {from: 6, to: 5, label: '0.2' },
            ], 
           // OrgChart.templates.ula.min.size =  [250, 60];
             mouseScrool: OrgChart.action.scroll,
            showYScroll: OrgChart.scroll.visible,
            showXScroll: OrgChart.scroll.visible,
     
            collapse: {
                level: 4
            },
            template: "ula",
            
        layout: OrgChart.mixed,
        
           // mouseScrool: OrgChart.action.none,
            menu: {
                export_pdf: {
                    text: "Export PDF",
                    icon: OrgChart.icon.pdf(24, 24, "#7A7A7A"),
                    onClick: pdf
                },

            },
            nodeMenu: {
                export_pdf: {
                    text: "Export PDF",
                    icon: OrgChart.icon.pdf(24, 24, "#7A7A7A"),
                    onClick: pdf
                },
            },
            nodeBinding: {
                    description: "description",
                    // field_0: "name",
                    // field_1: "title",
                    field_4: "name",
                    // img_0: "email",

                    },
            tags: {
              "group": {
                  template: "group",
              },
                },
         nodes: [
         <?php
                $conn = dbconnect();

          $scorecard_id = getScoreCardID();

          $counter=1;
          $stmt = $conn->prepare("SELECT perspective_id FROM bsc_client_perspectives WHERE client_id=? ORDER BY perspective_id ASC");
          $stmt->bind_param('i',$_SESSION['client_id']);
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($perspective_id);
          while($stmt->fetch()){ 
            if($counter==1){ ?>
            { id: <?php echo $perspective_id; ?>, name: "<?php echo getPerspectiveName($perspective_id); ?>", tags: ["<?php echo getPerspectiveName($perspective_id); ?>", "group"], description: "<?php echo getPerspectiveName($perspective_id); ?>" },

           <?php }else{ ?>

            { id: <?php echo $perspective_id; ?>, name: "<?php echo getPerspectiveName($perspective_id); ?>", pid: 1, tags: ["<?php echo getPerspectiveName($perspective_id); ?>", "group"], description: "<?php echo getPerspectiveName($perspective_id); ?>" },

           <?php } ?>
                 
           
            <?php 
            $counter++;

            $stmt1=$conn->prepare("SELECT id, goal FROM bsc_goals WHERE perspective_id=? AND scorecard_id=?");
            $stmt1 ->bind_param('ii', $perspective_id,$scorecard_id);
            $stmt1->execute();
            $stmt1->store_result();
            $stmt1->bind_result($goal_id, $goal);
            while($stmt1->fetch()){ ?>
             
             { id: <?php echo $goal_id; ?>, stpid: "<?php echo $perspective_id; ?>", name: "<?php echo $goal; ?>"},

            <?php }
            $stmt1->close();
          }
          $stmt->close();
          ?>
               
     
            ]
            

        });    

        </script>
  
<?php //include"footer.php"; ?>