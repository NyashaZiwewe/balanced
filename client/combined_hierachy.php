<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>
<?php include"top_bar.php"; ?>

    <script src="../orgchart/getorgchart/getorgchart.js"></script>
    <link href="../orgchart/getorgchart/getorgchart.css" rel="stylesheet" />

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
                        <h5>Scorecard Cascading  <a href="/demo/client/new-design" class="btn btn-outline-info">New Design</a></h5>
                    </div>
                    <div class="ibox-content">

               
                          <div id="people" ></div>
                     <?php //error_reporting(0);
                     //echo getOrganogram(38,116); ?>
               
                    </div>
                </div>
            </div>
            </div>
        </div>

<?php 
$scorecard_id= getCoporateScorecard($_SESSION['client_id']);
$client_id=$_SESSION['client_id'];
//$perspective_id=$_GET['pid'];
$conn=dbconnect();
?>
    <script type="text/javascript">
   var source = [];
    source.push({ id: <?php echo $scorecard_id; ?>, parentId: null, nodeId: "", other: "<?php echo getOwner($scorecard_id); ?>", score: "Score: <?php echo getTotalWR($scorecard_id); ?>%"  });

    <?php 
    if(countBusinessUnits()>0){

      $stmt3=$conn->prepare("SELECT id, business_unit FROM bsc_scorecards WHERE client_id=? AND level_id=?");
      $stmt3->bind_param('ii',$client_id,$level_id);
      $level_id=2;
      $stmt3->execute();
      $stmt3->store_result();
      $stmt3->bind_result($sc, $business_unit);
      While($stmt3->fetch()){ ?>
   
source.push({ id: <?php echo $sc; ?>, parentId: <?php echo $scorecard_id; ?>, other: "<?php echo getOwner($sc); ?> ", score: "Score: <?php echo getTotalWR($sc); ?>%" });

<?php 
          $stmt12=$conn->prepare("SELECT DISTINCT(id), department_id FROM bsc_scorecards WHERE client_id=? AND level_id=? AND business_unit=?");
          $stmt12->bind_param('iii',$client_id,$level_id,$business_unit);
          $level_id=3;
          $stmt12->execute();
          $stmt12->store_result();
          $stmt12->bind_result($scorecard,$department_id);
          While($stmt12->fetch()){ ?>
        
source.push({ id: <?php echo $scorecard; ?>, parentId: <?php echo $sc; ?>, other: "<?php echo getOwner($scorecard); ?> ", score: "Score: <?php echo getTotalWR($scorecard); ?>%" });

<?php 
              $stmt=$conn->prepare("SELECT DISTINCT(id) FROM bsc_scorecards WHERE client_id=? AND level_id=? AND department_id=?");
              $stmt->bind_param('iii',$client_id,$level_id,$department_id);
              $level_id=4;
              //$department_id=43;
              $stmt->execute();
              $stmt->store_result();
              $stmt->bind_result($scorecard4);
              While($stmt->fetch()){ ?>
      
     source.push({ id: <?php echo $scorecard4; ?>, parentId: <?php echo $scorecard; ?>, other: "<?php echo getOwner($scorecard4); ?> ", score: "Score: <?php echo getTotalWR($scorecard4); ?>%" });
      
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
        
source.push({ id: <?php echo $scorecard; ?>, parentId: <?php echo $scorecard_id; ?>, other: "<?php echo getOwner($scorecard); ?> ", score: "Score: <?php echo getTotalWR($scorecard); ?>%" });

<?php 
              $stmt=$conn->prepare("SELECT DISTINCT(id) FROM bsc_scorecards WHERE client_id=? AND level_id=? AND department_id=?");
              $stmt->bind_param('iii',$client_id,$level_id,$department_id);
              $level_id=4;
              //$department_id=43;
              $stmt->execute();
              $stmt->store_result();
              $stmt->bind_result($scorecard4);
              While($stmt->fetch()){ ?>
      
     source.push({ id: <?php echo $scorecard4; ?>, parentId: <?php echo $scorecard; ?>, other: "<?php echo getOwner($scorecard4); ?> ", score: "Score: <?php echo getTotalWR($scorecard4); ?>%" });
      
  <?php  }  
        $stmt->close(); 
         }  
        $stmt12->close(); 





  }

        $conn->close(); ?> 

    var orgChart = new getOrgChart(document.getElementById("people"),{
          collapse: {
                level: 2
            },
     
         showYScroll: scroll.visible,

        primaryFields: ["nodeId", "other","score"],
        photoFields: ["image"],
        // enableSearch: false,
        dataSource: source,
        
        
       
    });

    </script>   
<?php include"footer.php"; ?>

   