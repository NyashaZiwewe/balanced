<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>
<style type="text/css">
  label{color: #175ea8}
</style>
		<script src='Pinker-master/Pinker.js'></script>
	    <!-- <link rel="stylesheet" type="text/css" href="Test.css" /> -->

    <script type="text/javascript">
      function listen(val){

        if(val==1){
        document.getElementById('og').innerHTML='<label>Select derived Goal</label><select class="form-control" name="goal_id" required><option value="" selected disabled>Select Goal</option><?php getMappingGoals(getCoporateScorecard($_SESSION['client_id']),1); ?></select>';

         document.getElementById('driver').innerHTML='<label>Select deriver Goal</label><select class="form-control" name="driver" required><option value="" selected disabled>Select Goal</option><?php getMappingGoals(getCoporateScorecard($_SESSION['client_id']),2); ?></select>';

        } if(val==2){
        document.getElementById('og').innerHTML='<label>Select derived Goal</label><select class="form-control" name="goal_id" required><option value="" selected disabled>Select Goal</option><?php getMappingGoals(getCoporateScorecard($_SESSION['client_id']),2); ?></select>';

         document.getElementById('driver').innerHTML='<label>Select deriver Goal</label><select class="form-control" name="driver" required><option value="" selected disabled>Select Goal</option><?php getMappingGoals(getCoporateScorecard($_SESSION['client_id']),3); ?></select>';

        }   if(val==3){
        document.getElementById('og').innerHTML='<label>Select derived Goal</label><select class="form-control" name="goal_id" required><option value="" selected disabled>Select Goal</option><?php getMappingGoals(getCoporateScorecard($_SESSION['client_id']),3); ?></select>';

         document.getElementById('driver').innerHTML='<label>Select deriver Goal</label><select class="form-control" name="driver" required><option value="" selected disabled>Select Goal</option><?php getMappingGoals(getCoporateScorecard($_SESSION['client_id']),4); ?></select>'

        }   if(val==4){
        document.getElementById('og').innerHTML='<label>Select derived Goal</label><select class="form-control" name="goal_id" required><option value="" selected disabled>Select Goal</option><?php getMappingGoals(getCoporateScorecard($_SESSION['client_id']),4); ?></select>';

         document.getElementById('driver').innerHTML='<label>Select deriver Goal</label><select class="form-control" name="driver" required><option value="" selected disabled>Select Goal</option><?php getMappingGoals(getCoporateScorecard($_SESSION['client_id']),5); ?></select>';

        }   if(val==5){
        document.getElementById('og').innerHTML='<label>Select derived Goal</label><select class="form-control" name="goal_id" required><option value="" selected disabled>Select Goal</option><?php getMappingGoals(getCoporateScorecard($_SESSION['client_id']),5); ?></select>';

         document.getElementById('driver').innerHTML='<input type="text" readonly value="" placeholder="No deriver goal can be assigned to this perspective" required>';
        }
      
      }
      
    </script>


  <div class="row">
           <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                       <p align="center">  <b> <?php echo getClientName($_SESSION['client_id']); ?> Strategy Map</b></p>
                    <div class="ibox-tools">
                          <!--<a class="btn btn-primary btn-sm" href="correlation.php"><i class="fa fa-table"></i>Correlation Table</a>-->
                          <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-check"></i>Update</a>
                        </div>
                    </div>
                </div>
            </div>   
           </div>

       <div class="row">
         <div class="col-lg-12">
                <div class="ibox ">
                 <div class="ibox-content" align="center">
                  <?php if(isset($_GET['success'])){

                    echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Goals linked successfully.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';

                  } ?>

						<pre id='Source02' class='pinker'>

<!-- Layout: -->

  <!-- [{P} <?php //echo getClientName($_SESSION['client_id']); ?> Strategy Map]  -->

  Layout:
  <?php getSMPerspectives(); ?>
       <br>
<?php  getSMPerspectives2(1); ?>
      <br>
<?php getSMPerspectives2(2); ?>
      <br>
<?php getSMPerspectives2(3); ?>
      <br>
<?php getSMPerspectives2(4); ?>
    <?php 
//     if(countClientPerspectives()>4){
//       getSMPerspectives2(5);
//   } 
   ?>
	


			</pre>
		</div>
</div>
</div>
</div>



         <div class="modal inmodal fade" id="addModal" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Add new Linkages</h4>
                                        </div>
                                        <form  action="nyasha.php" method="post">
                                        <div class="modal-body">

                                        <input type="hidden" name="client_id" id="client_id" value="<?php echo $_SESSION['client_id']; ?>">
                                        <input type="hidden" name="scorecard_id" id="scorecard_id" value="<?php echo getCoporateScorecard($_SESSION['client_id']); ?>">
                                       
                                        <label>Perspective</label>
                                        <select class="form-control" onchange="listen(this.value)" name="perspective_id" required>
                                        <option value="" selected disabled>Select Perspective</option>
                                    <?php listPerspectives(); ?>
                                         </select>
                                   
                                        <div id="og"> </div>
                                      
                                        <div id="driver"></div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" name="add" class="btn btn-outline-primary">Done</button>
                                        </div>
                                      </form>
                                      
                                    </div>
                                </div>
                            </div>
                        


<?php if(isset($_POST['add'])){
   $conn=dbconnect();

   addLinkGoals($_POST['scorecard_id'],$_POST['perspective_id'],$_POST['goal_id'],$_POST['driver']);
   exit;

}?>

<script type='text/javascript'>
  pinker.render();
</script>

<?php include"footer.php"; ?>
