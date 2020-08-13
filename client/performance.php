<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>
<script src="js/plugins/chartJs/Chart.min.js"></script>

<br>
                    <div class="ibox-title">
                      <a class="btn btn-outline-success" href="360.php">Assess Your Strategy</a>  
                      <a class="btn btn-outline-success" href="360_questions.php">Strategy Review Questions</a> 
                      <a class="btn btn-outline-success" href="360_responses.php">Strategy Review Responses</a> 
                      <a class="btn btn-outline-success" href="360_reports.php">Strategy Review Reports</a>
                    </div>
     

        <div class="wrapper wrapper-content animated fadeIn">

            <div class="row">
                <div class="col-lg-12">           
             
                <div class="ibox ">
                    <div class="ibox-title">
                            <h5>Have an Your Performance Month After Month
                            </h5>
                    </div>
                    <div class="ibox-content">  
                           <canvas id="myChart" height="140"></canvas>
                    </div>
                    </div>
                  </div>
                </div>
    
<script>

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: [<?php echo Perspectives(); ?>],
    datasets: [
    <?php echo bunits(); ?>
   ]
  }
});
</script>
<script src="js/plugins/chartJs/Chart.min.js"></script>
               
</div>
<?php include"footer.php"; ?>