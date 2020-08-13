<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>
<?php error_reporting(0); ?>
<style type="text/css">
  br {display:none}
  td {
    text-align: center;
  }
  
</style>

<script type="text/javascript">
 function CheckSchedulingDates() {
  var SD = document.getElementById('startdate').value;
  var ED = document.getElementById('enddate').value;
    if (Date.parse(SD) >= Date.parse(ED)) {
    alert('The ending date must occur after the starting date.');
    location.reload();    
  }
}

</script>

<script type="text/javascript">
 function getPeriodicalWR() {

        var start_date = document.getElementById("startdate").value;
        var end_date = document.getElementById("enddate").value;
        var scorecard_id="<?php echo $_GET['scorecard']; ?>";
        alert(scorecard_id);
   $.ajax({
   type: "POST",
   url: "autosave.php",
   data:{
    getPeriodicalWR: "nyasha",
    scorecard_id: val,
    measure_id: val2,
    comment
  },
  success: function(data){
  }
  });
}
</script>

<script type="text/javascript">
  function changefilters(){

    var f = document.getElementById('f').value;
    var t = document.getElementById('t').value;
    if(f==''){
    document.getElementById('f1').style.borderColor="#bb2d42";
    }else if(t==''){
     document.getElementById('t1').style.borderColor="#bb2d42";
    }
    else{
  document.getElementById('btnRange').click()
  }
  }
</script>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Have an Insight of <font color="blue"><?php echo getOwner($_GET['scorecard']); ?>'s </font> performance </h5>
                        <div class="ibox-tools">
                <a href="scorecard/<?php echo $_GET['scorecard']; ?>"><button class="btn btn-outline-secondary"><i class="fa fa-search"></i> Scorecard</button></a>
  
                <a href="/demo/client/performance-reports"><button class="btn btn-outline-secondary"><i class="fa fa-balance-scale" aria-hidden="true"></i> Compare With Others</button></a> 
                        </div>
                    </div>
                 <hr>
                 

                  <div class="row">

                    <?php if(isset($_GET['range'])) { ?>
                          <div class="col-4" style="text-align: center; color: #175ea8">
                             <?php if(isset($_POST['btnRange'])) {
                                       echo '<b>'. $date = date('F, Y', strtotime($_POST['from'])).' - '. $date = date('F, Y', strtotime($_POST['to'])).'</b>';
                                      } ?>
                          </div>
                          <div class="col-2">
                        
                        <a onclick="location.replace(location.pathname);" href="#">Clear Range Filter</a></div>
                         
                        <form action="" method="POST">
                          <input type="month" name="from" id="f" hidden>
                           <input type="month" name="to" id="t" hidden>
                          <button type="submit" name="btnRange" id="btnRange" hidden>ziwewe</button>
                        </form> 

                          <div class="col-3"> 
                              <div class="input-group m-b">
                                <div class="input-group-prepend">
                                  <span class="input-group-addon">From</span>
                                </div>
                                <input type="month" class="form-control" id="f1" required oninput="document.getElementById('f').value = this.value;">
                              </div>
                          </div>

                          <div class="col-3"> 
                              <div class="input-group m-b">
                                <div class="input-group-prepend">
                                  <span class="input-group-addon">To</span>
                                </div>
                                <input type="month" class="form-control" id="t1" required oninput="document.getElementById('t').value = this.value;">&nbsp;&nbsp;
                                <div class="input-group-append">
                                                <span class="input-group-addon" type="submit" style="border-color: #175ea8;" onclick="changefilters()"><i class="fa fa-filter"></i></span>
                                </div>
                                
                              </div>
                          </div>
                       

                        <?php } else{ ?>

                              <div class="col-6" style="text-align: center; color: #175ea8"> 
                              <?php if(isset($_POST['month'])) {
                                       echo '<b>'. $date = date('F, Y', strtotime($_POST['month'])).'</b>';
                                      }else{
                                        echo "<b>Year to date performance</b>";
                                      } ?>
                                      </div>
                              <div class="col-3 "><a onclick="location.search = 'range';" href="#">Use date range</a></div>

                              <div class="col-3"> 
                              <div class="input-group m-b">
                                <div class="input-group-prepend">
                                  <span class="input-group-addon">Month</span>
                                </div>
                                <form action="" method="POST">
                                <input type="month" name="month" onchange="document.getElementById('myBtn').click()" class="form-control">
                                <button type="submit" id="myBtn" hidden>nyasha</button>
                                </form>
                              </div>
                              </div>


                            <?php  }?>
                         
                    </div>

                    <div class="ibox-content">              
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Perspective</th>
                          <th>Score (%)</th>
                          <th>Departmental AVG (%)</th>
                          <td>Variation from Dept</td>
                          <th>Company AVG (%)</th>
                          <td>Variation from co</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php  //echo  getPeriodicalAssessment($_GET['scorecard']); 
                    require_once("periodical_assessment.php"); ?>
                      </tbody>
                    </table>
                        </div>

                    </div>
                </div>
            </div>
            </div>
        </div>

    
<?php include"footer.php"; ?>




