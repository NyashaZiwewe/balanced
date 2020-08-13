<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>
<?php include"top_bar.php"; ?>

    <script src="../orgchart/getorgchart/getorgchart.js"></script>
    <link href="../orgchart/getorgchart/getorgchart.css" rel="stylesheet" />
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
      
           OrgChart.templates.ula.field_1 ='<text class="field_1" style="font-size: 14px;" fill="#175ea8" x="125" y="70" text-anchor="middle">{val}</text>';
            OrgChart.templates.ula.field_2 ='<text class="field_2" style="font-size: 14px;" fill="green" x="125" y="90" text-anchor="right">{val}</text>';
           
         function pdf(nodeId) {
            // chart.exportPDF({
            //     filename: "<?php //echo getClientName($_SESSION['client_id']); ?> Performance Report.pdf", 
            //     expandChildren: true, 
            //     nodeId: nodeId,
            //     format: "A4",
            //     header: '<?php //echo getClientName($_SESSION['client_id']); ?> Performance Report',
            //     footer: 'Prepared by Industrial Pyschology Consultants: <?php //echo date('Y-m-d H:i'); ?>. Page {current-page} of {total-pages}'
            // });
             OrgChart.pdfPrevUI.show(chart, {
                filename: "<?php echo getClientName($_SESSION['client_id']); ?> Performance Report.pdf", 
                // expandChildren: true, 
                nodeId: nodeId,
                format: "A4",
                header: '<?php echo getClientName($_SESSION['client_id']); ?> Performance Report',
                footer: 'Prepared by Industrial Pyschology Consultants: <?php echo date('Y-m-d H:i'); ?>. Page {current-page} of {total-pages}'
            });
        }
        
    
        
        // function png(nodeId) {
        //     chart.exportPNG({filename: "MyFileName.png", expandChildren: true, nodeId: nodeId});
        // }
        // function svg(nodeId) {
        //     chart.exportSVG({filename: "MyFileName.svg", expandChildren: true, nodeId: nodeId});
        // }

        
        var chart = new OrgChart(document.getElementById("tree"), {
             mouseScrool: OrgChart.action.scroll,
            showYScroll: OrgChart.scroll.visible,
            showXScroll: OrgChart.scroll.visible,
     
            collapse: {
                level: 2
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
                // export_png: {
                //     text: "Export PNG",
                //     icon: OrgChart.icon.png(24, 24, "#7A7A7A"),
                //     onClick: png
                // },
                // export_svg: {
                //     text: "Export SVG",
                //     icon: OrgChart.icon.svg(24, 24, "#7A7A7A"),
                //     onClick: svg
                // }
            },
            nodeMenu: {
                export_pdf: {
                    text: "Export PDF",
                    icon: OrgChart.icon.pdf(24, 24, "#7A7A7A"),
                    onClick: pdf
                },
                // export_png: {
                //     text: "Export PNG",
                //     icon: OrgChart.icon.png(24, 24, "#7A7A7A"),
                //     onClick: png
                // },
                // export_svg: {
                //     text: "Export SVG",
                //     icon: OrgChart.icon.svg(24, 24, "#7A7A7A"),
                //     onClick: svg
                // }
            },
            nodeBinding: {
                field_0: "name",
                field_1: "title",
                field_2: "score",
                img_0: "img"
            },
         nodes: [
               
    
          { id: <?php echo $client_id; ?>, pid: null, name: "<?php echo getOwner($scorecard_id); ?>", score: "Score: <?php echo round(getCompanyAVG(),2); ?>%",  tags: ["<?php echo $tag0; ?>"], email: "amber@domain.com", img: "../profiles/mn.jpg" },
           <?php 
    if(countBusinessUnits()>0){

      $stmt3=$conn->prepare("SELECT id, business_unit FROM bsc_scorecards WHERE client_id=? AND level_id=?");
      $stmt3->bind_param('ii',$client_id,$level_id);
      $level_id=2;
      $stmt3->execute();
      $stmt3->store_result();
      $stmt3->bind_result($sc, $business_unit);
      While($stmt3->fetch()){ 
            if(getTotalWR($sc) < 0){
                  $tag ="fail";
              } else{
                  $tag ="pass";
              }?>
   
 { id: <?php echo $business_unit; ?>, pid: <?php echo $client_id; ?>, name: "<?php echo getOwner($sc); ?>", score: "Score: <?php echo getTotalWR($sc); ?>%",  tags: ["<?php echo $tag; ?>"], email: "amber@domain.com", img: "https://cdn.balkan.app/shared/1.jpg" },

<?php 
          $stmt12=$conn->prepare("SELECT DISTINCT(id), department_id FROM bsc_scorecards WHERE client_id=? AND level_id=? AND business_unit=?");
          $stmt12->bind_param('iii',$client_id,$level_id,$business_unit);
          $level_id=3;
          $stmt12->execute();
          $stmt12->store_result();
          $stmt12->bind_result($scorecard,$department_id);
          While($stmt12->fetch()){ 
                if(getDepartmentalAVG($department_id) < 0){
                  $tag1 ="fail";
              } else{
                  $tag1 ="pass";
              }?>
        
{ id: <?php echo $department_id; ?>, pid: <?php echo $business_unit; ?>, name: "<?php echo getOwner($scorecard); ?>", score: "Score: <?php echo round(getDepartmentalAVG($department_id),2); ?>%",  tags: ["<?php echo $tag1; ?>"], email: "amber@domain.com", img: "https://cdn.balkan.app/shared/1.jpg" },



<?php 
              $stmt=$conn->prepare("SELECT DISTINCT(id), owner FROM bsc_scorecards WHERE client_id=? AND level_id=? AND department_id=?");
              $stmt->bind_param('iii',$client_id,$level_id,$department_id);
              $level_id=4;
              //$department_id=43;
              $stmt->execute();
              $stmt->store_result();
              $stmt->bind_result($scorecard4,$owner);
              While($stmt->fetch()){ 
             if(getTotalWR($scorecard4) < 0){
                  $tag2 ="fail";
              } else{
                  $tag2 ="pass";
              }
              ?>

     { id: <?php echo $owner; ?>, pid: <?php echo $department_id; ?>, name: "<?php echo getOwner($scorecard4); ?>", score: "Score: <?php echo getTotalWR($scorecard4); ?>%",  tags: ["<?php echo $tag2; ?>"], email: "amber@domain.com", img: "https://cdn.balkan.app/shared/1.jpg" },

 
  <?php  }  
        $stmt->close(); 
         }  
        $stmt12->close(); 
         }  
        $stmt3->close(); 
  } 

  else{
          $stmt12=$conn->prepare("SELECT id, owner, department_id FROM bsc_scorecards WHERE client_id=? AND level_id=?");
          $stmt12->bind_param('ii',$client_id,$level_id);
          $level_id=3;
          $stmt12->execute();
          $stmt12->store_result();
          $stmt12->bind_result($scorecard, $owner, $department_id);
          While($stmt12->fetch()){ 
              if(getDepartmentalAVG($department_id) <0){
                  $tag ="fail";
              } else{
                  $tag ="pass";
              }
              ?>
        
 { id: <?php echo $department_id; ?>, pid: "<?php echo $client_id; ?>", name: "<?php echo getOwner($scorecard); ?>", score: "Score: <?php echo round(getDepartmentalAVG($department_id),2); ?>%",  tags: ["<?php echo $tag; ?>"], img: "../profiles/<?php  getOwnerPhoto($owner); ?>" },

<?php 

              $stmt=$conn->prepare("SELECT id, owner FROM bsc_scorecards WHERE client_id=? AND level_id=? AND department_id=?");
              $stmt->bind_param('iii',$client_id,$level_id,$department_id);
              $level_id=4;
              //$department_id=43;
              $stmt->execute();
              $stmt->store_result();
              $stmt->bind_result($scorecard4,$owner);
              While($stmt->fetch()){ 
             if(getTotalWR($scorecard4)<0){
                  $tag1 ="fail";
              } else{
                  $tag1 ="pass";
              }
              ?>
      
      { id: <?php echo $owner; ?>, pid: <?php echo $department_id; ?>, name: "<?php echo getOwner($scorecard4); ?>", score: "Score: <?php echo getTotalWR($scorecard4); ?>%",  tags: ["<?php echo $tag1; ?>"], email: "amber@domain.com", img: "../profiles/<?php  getOwnerPhoto($owner); ?>" },
      { id: <?php echo $owner; ?>100, pid: <?php echo $owner; ?> },
         <?php
              }
             $stmt->close();
      }  
        $stmt12->close(); 
  }

        $conn->close(); ?> 
     
            ]
            

        });    

        </script>
  
<?php //include"footer.php"; ?>