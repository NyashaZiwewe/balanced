<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>
<script src="js/plugins/chartJs/Chart.min.js"></script>

<br>
                    <div class="ibox-title">
                        <?php if($_SESSION['account_type']!=1){
                       echo'<a class="btn btn-outline-success" href="360.php">Assess Your Strategy</a>';     
                        } ?>                       
                      <a class="btn btn-outline-success" href="360_questions.php">Strategy Review Questions</a> 
                      <a class="btn btn-outline-success" href="#">Strategy Review Responses</a> 
                      <a class="btn btn-outline-success" href="360_reports.php">Strategy Review Reports</a>
                    </div>
     

        <div class="wrapper wrapper-content animated fadeIn">

            <div class="row">
                <div class="col-lg-12">           
             
                <div class="ibox ">
                    <div class="ibox-title">
                            <h5>Overal Analysis of Your <b>Strategy Fomulation Process</b> for the year 2019
                            </h5>
                    </div>
                    <div class="ibox-content">  
                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    </div>
                    </div>
                  </div>
                </div>
              
<?php
 
$dataPoints = array(
    array("y" => 2, "label" => "Very Poor"),
    array("y" => 15, "label" => "Poor"),
    array("y" => 50, "label" => "Good"),
    array("y" => 37, "label" => "Very Good"),
    array("y" => 5, "label" => "Excellent")
);
 
?>

<script>


window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
    title: {
        // text: "Push-ups Over a Week"
    },
    axisY: {
        title: "Score in %"
    },
    data: [{
        type: "line",
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    }]
});
chart.render();
 
}
</script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
               
</div>
<?php include"footer.php"; ?>