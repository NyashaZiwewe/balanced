<?php include"header.php"; ?>
<?php include"side_bar.php"; 
error_reporting(0);?>

<?php include"top_bar.php"; ?>
<style>
    br {
    display: none;
}
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
<?php if(isset($_POST['selectmonth'])){
   echo "<script type='text/javascript'>
        window.location.href = 'performance-reports?monthly&month=".$_POST['month']."';
        </script>";
}
if(isset($_POST['selectquarter'])){
   echo "<script type='text/javascript'>
        window.location.href = 'performance-reports?quaterly&quarter=".$_POST['quarter']."';
        </script>";
}
if(isset($_POST['selecthalf'])){
   echo "<script type='text/javascript'>
        window.location.href = 'performance-reports?half_yearly&half=".$_POST['half']."';
        </script>";
}
if(isset($_POST['selectyear'])){
   echo "<script type='text/javascript'>
        window.location.href = 'performance-reports?yearly&year=".$_POST['year']."';
        </script>";
}

?>

<hr>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Reports</h5>
                        <div class="ibox-tools">
<a href="myscorecards"><button class="btn btn-success btn-sm"><i class="fa fa-book"></i> Scorecards</button></a> <a href="performance-reports?monthly"><button class="btn btn-primary btn-sm"><i class="fa fa-calendar"></i> Monthly </button></a> 
<a href="performance-reports?quarterly"><button class="btn btn-primary btn-sm"><i class="fa fa-calendar"></i> Quarterly </button></a> 
<a href="performance-reports?half_yearly"><button class="btn btn-primary btn-sm"><i class="fa fa-calendar"></i> Half Yearly </button></a> 
<a href="performance-reports?yearly"><button class="btn btn-primary btn-sm"><i class="fa fa-calendar"></i> Yearly </button></a> 
<a href="performance-reports"><button class="btn btn-primary btn-sm"><i class="fa fa-calendar"></i> Year To date</button></a></a> 
<a href="performance-reports?specific"><button class="btn btn-warning btn-sm"><i class="fa fa-check"></i> Select Specific employees to assess</button></a>
                        </div>
                    </div>
                    <div class="ibox-content">
                    <div class="table-responsive">
                    
   
 <?php             
    if(isset($_GET['yearly']) AND !isset($_GET['year'])){
        echo "Select year to assess:<br/>"; ?>
   <form action="" method="post">
     <select name="year">
      <?php selectYear(); ?>
     </select>
     <button name="selectyear" class="btn btn-success btn-sm"><i class="fa fa-spinner"></i> Proceed</button></form>
   <?php    } 
   elseif(isset($_GET['yearly']) AND isset($_GET['year'])){
        echo "Select year to assess:<br/>"; ?>
   <form action="" method="post">
     <select name="year">
      <?php selectYear(); ?>
     </select>
     <button name="selectyear" class="btn btn-success btn-sm"><i class="fa fa-spinner"></i> Proceed</button></form>
   <?php  compareYearlyScores(); 
    } 
   elseif(isset($_GET['half_yearly']) AND !isset($_GET['half'])){
        echo "Select half year to assess:<br/>"; ?>
   <form action="" method="post">
     <select name="half">
      <?php selectHalf(); ?>
     </select>
     <button name="selecthalf" class="btn btn-success btn-sm"><i class="fa fa-spinner"></i> Proceed</button></form>
   <?php    } 
   elseif(isset($_GET['half_yearly']) AND isset($_GET['half'])){
        echo "Select half year to assess:<br/>"; ?>
   <form action="" method="post">
     <select name="half">
      <?php selectHalf(); ?>
     </select>
     <button name="selecthalf" class="btn btn-success btn-sm"><i class="fa fa-spinner"></i> Proceed</button></form>
   <?php  compareHalfYearlyScores(); 
    } 
      elseif(isset($_GET['quarterly']) AND !isset($_GET['quarter'])){
        echo "Select quarter to assess:<br/>"; ?>
   <form action="" method="post">
     <select name="quarter">
      <?php selectQuarter(); ?>
     </select>
     <button name="selectquarter" class="btn btn-success btn-sm"><i class="fa fa-spinner"></i> Proceed</button></form>
   <?php    } 
   elseif(isset($_GET['quarterly']) AND isset($_GET['quarter'])){
        echo "Select quarter to assess:<br/>"; ?>
   <form action="" method="post">
     <select name="quarter">
      <?php selectQuarter(); ?>
     </select>
     <button name="selectquarter" class="btn btn-success btn-sm"><i class="fa fa-spinner"></i> Proceed</button></form>
   <?php  compareQuarterlyScores(); 
    }  
   elseif(isset($_GET['monthly']) AND !isset($_GET['month'])){
        echo "Select month to assess:<br/>"; ?>
   <form action="" method="post">
     <select name="month">
      <?php selectMonths(); ?>
     </select>
     <button name="selectmonth" class="btn btn-success btn-sm"><i class="fa fa-spinner"></i> Proceed</button></form>
   <?php    }   
   elseif(isset($_GET['monthly']) && isset($_GET['month'])){ ?>
     <form action="" method="post">
    <input type="month" name="month" max="<?php echo date("Y-m"); ?>" min="<?php echo date('Y-m', strtotime('-1 year')); ?>">
     <button name="selectmonth" class="btn btn-success btn-sm"><i class="fa fa-spinner"></i> Proceed</button>
   </form>
  <?php    compareMonthlyScores();
      } 

    elseif(isset($_POST['selectspecific'])){
//print_r($_POST);
      //implode array to string
      if(!is_array($_POST['specific'])){
        $users = $_POST['specific'];
      }else{
        $users = implode(" , ", $_POST['specific']);
      }

      ?> <div style="float: right;">
         <form action="reports.php" method="post">    
                    <label>From1</label>
                          <input type="date" id="startdate" onChange="CheckSchedulingDates(this.value)" name="start_date" required>
                         <label for="level">To</label>
                          <input type="date"  name="end_date" id="enddate" onChange="CheckSchedulingDates(this.value)" required>
                         <button type="submit" name="selectspecific" class="btn btn-primary">Filter</button>
                        <input type="hidden" name="specific" value="<?php echo $users; ?>">
                      </form>
</div>
     <br>  <hr/>

 
         <table class="table table-striped table-bordered table-hover dataTables-example">
         <thead>
         <tr>
         <th>Owner</th>
         <th>Financial</th>
         <th>Customer</th>
         <th>Internal B P</th>
         <th>Learning & Growth</th>
         <th>Overal Score</th>
         <th>Action</th>
         </tr>
         </thead>
         <tbody>
 <?php if(is_array($_POST['specific'])){
    $specific = $_POST['specific'];
  }else{
    $specific = explode(" , ", $_POST['specific']);
  }
  //check dates
  if(isset($_POST['start_date']) && isset($_POST['end_date'])){
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
  }else{
    $start_date = "2019-01-01";
    $end_date = "2020-05-08";
  }

      foreach($specific AS $scorecard_id){

getPeriodicalWR($scorecard_id, $start_date, $end_date);

 } ?>
          </tbody>
          </table>

<?php } 

            
   elseif(isset($_GET['specific'])){ ?>
        <form action="reports.php" method="post">
        <select name="specific[]" class="form-control dual_select" multiple>
                <?php getChwachwa(); ?>
        </select>    
                 
        <button type="submit" name="selectspecific" style="float: right;" class="btn btn-primary">proceed</button>
  
        </form>

  <?php }  else  { 
                  getScores();
                   }  
                 
                 ?>                  
         

                    </div>
                </div>
            </div>
            </div>
        </div>
</div>
   
<?php include"footer.php"; ?>




