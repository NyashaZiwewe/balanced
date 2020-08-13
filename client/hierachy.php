<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>
<?php include"top_bar.php"; ?>

    <script src="../../orgchart/getorgchart/getorgchart.js"></script>
    <link href="../../orgchart/getorgchart/getorgchart.css" rel="stylesheet" />

    <style type="text/css">
        html, body {
            margin: 0px;
            padding: 0px;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        #people {
            width: 100%;
            height: 100%;
        }
          [node-id] rect {
        fill: #016e25;
    }
    </style>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Scorecard Cascading</h5>
                    </div>
                    <div class="ibox-content">

               
                          <div id="people" ></div>
              
               
                    </div>
                </div>
            </div>
            </div>
        </div>

<?php 
$scorecard_id= getCoporateScorecard($_SESSION['client_id']);
$client_id=$_SESSION['client_id'];
$perspective_id=$_GET['pid'];
$conn=dbconnect();
?>
    <script type="text/javascript">
   var source = [];
    source.push({ id: <?php echo $scorecard_id; ?>, parentId: null, nodeId: "", title: "<?php echo getPerspectiveName($perspective_id); ?> Perspective", other: "<?php echo getOwner($scorecard_id); ?>", score: "Score: <?php echo getWR($scorecard_id,$perspective_id); ?>%"  });

    <?php 
    if(countBusinessUnits()>0){

      $stmt3=$conn->prepare("SELECT id, business_unit FROM bsc_scorecards WHERE client_id=? AND level_id=?");
      $stmt3->bind_param('ii',$client_id,$level_id);
      $level_id=2;
      $stmt3->execute();
      $stmt3->store_result();
      $stmt3->bind_result($sc, $business_unit);
      While($stmt3->fetch()){ ?>
   
source.push({ id: <?php echo $sc; ?>, parentId: <?php echo $scorecard_id; ?>, title: "<?php echo getPerspectiveName($perspective_id);?> Perspective ", other: "<?php echo getOwner($sc); ?> ", score: "Score: <?php echo getWR($sc,$perspective_id); ?>%" });

<?php 
          $stmt12=$conn->prepare("SELECT DISTINCT(id), department_id FROM bsc_scorecards WHERE client_id=? AND level_id=? AND business_unit=?");
          $stmt12->bind_param('iii',$client_id,$level_id,$business_unit);
          $level_id=3;
          $stmt12->execute();
          $stmt12->store_result();
          $stmt12->bind_result($scorecard,$department_id);
          While($stmt12->fetch()){ ?>
        
source.push({ id: <?php echo $scorecard; ?>, parentId: <?php echo $sc; ?>, title: "<?php echo getPerspectiveName($perspective_id);?> Perspective ", other: "<?php echo getOwner($scorecard); ?> ", score: "Score: <?php echo getWR($scorecard,$perspective_id); ?>%" });

<?php 
              $stmt=$conn->prepare("SELECT DISTINCT(id) FROM bsc_scorecards WHERE client_id=? AND level_id=? AND department_id=?");
              $stmt->bind_param('iii',$client_id,$level_id,$department_id);
              $level_id=4;
              //$department_id=43;
              $stmt->execute();
              $stmt->store_result();
              $stmt->bind_result($scorecard4);
              While($stmt->fetch()){ ?>
      
     source.push({ id: <?php echo $scorecard4; ?>, parentId: <?php echo $scorecard; ?>, title: "<?php echo getPerspectiveName($perspective_id);?> Perspective ", other: "<?php echo getOwner($scorecard4); ?> ", score: "Score: <?php echo getWR($scorecard4,$perspective_id); ?>%" });
      
  <?php  }  
        $stmt->close(); 
         }  
        $stmt12->close(); 
         }  
        $stmt3->close(); 
  } 

  else{
 
          $stmt12=$conn->prepare("SELECT DISTINCT(id), department_id FROM bsc_scorecards WHERE client_id=? AND level_id=?");
          $stmt12->bind_param('ii',$client_id,$level_id);
          $level_id=3;
          $stmt12->execute();
          $stmt12->store_result();
          $stmt12->bind_result($scorecard,$department_id);
          While($stmt12->fetch()){ ?>
        
source.push({ id: <?php echo $scorecard; ?>, parentId: <?php echo $scorecard_id; ?>, title: "<?php echo getPerspectiveName($perspective_id);?> Perspective ", other: "<?php echo getOwner($scorecard); ?> ", score: "Score: <?php echo getWR($scorecard,$perspective_id); ?>%" });

<?php 
              $stmt=$conn->prepare("SELECT DISTINCT(id) FROM bsc_scorecards WHERE client_id=? AND level_id=? AND department_id=?");
              $stmt->bind_param('iii',$client_id,$level_id,$department_id);
              $level_id=4;
              //$department_id=43;
              $stmt->execute();
              $stmt->store_result();
              $stmt->bind_result($scorecard4);
              While($stmt->fetch()){ ?>
      
     source.push({ id: <?php echo $scorecard4; ?>, parentId: <?php echo $scorecard; ?>, title: "<?php echo getPerspectiveName($perspective_id);?> Perspective ", other: "<?php echo getOwner($scorecard4); ?> ", score: "Score: <?php echo getWR($scorecard4,$perspective_id); ?>%" });
      
  <?php  }  
        $stmt->close(); 
         }  
        $stmt12->close(); 





  }

        $conn->close(); ?> 

    var orgChart = new getOrgChart(document.getElementById("people"),{
        showYScroll: scroll.visible,

        primaryFields: ["nodeId", "title", "other","score"],
        photoFields: ["image"],
        // enableSearch: false,
        dataSource: source,
    });

    </script>   
<?php include"footer.php"; ?>