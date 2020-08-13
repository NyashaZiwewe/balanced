<?php include"header.php"; ?>

<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>

<script type="text/javascript">
  function addScorecard(val) {
    //alert(val);
        var department = document.getElementById("department"+val).value;

        var client_id = "<?php echo $_SESSION['client_id']; ?>";
   // alert(client_id);
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    addScorecard: "Ziwewe",
    owner: val,
    client_id,
    department

  },
  success: function(data){
   // alert(data);
    document.getElementById("without_scorecards").innerHTML = data;
  }
  });
  }
</script>

<div class="wrapper wrapper-content">

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Add Scorecards : Selection options are only available to those with no active scorecards for this reporting period</h5>
                        </div>
                        <div class="ibox-content">
                            <form id="form" action="#" class="wizard-big">
                                <select class="form-control dual_select" multiple>
                                  <?php listEmployeesWithoutScorecards(); ?>
                                </select>
                                <hr>
                                <div class="row">
                                <div class="col-lg-8"></div>
                                <div class="col-lg-3">
                                <div class="input-group">
                  
                                .<button submit onclick="addScorecard();" style="float: right;" class="ladda-button btn btn-primary" data-style="expand-right">Submit</button></div>
                            </div>
                            <div class="col-lg-1"></div>
                        </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

      <div class="row">
         <div class="col-lg-12">
                <div class="ibox ">
          
           <div class="ibox-content">

                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Title</th>
                        <th>Department</th>
                        <th>Supervisor</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="without_scorecards">
               <?php getEmployeesWithoutScorecards(); ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Full Name</th>
                        <th>Title</th>
                        <th>Department</th>
                        <th>Supervisor</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    </table>
                        </div>

                    </div>

               </div>

        </div>
    </div>
</div><!-- 
                            <div class="modal inmodal fade" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Individual Score Card</h4>
                                        </div>
                                        <div class="modal-body">
                                     <div class="row">
                                         <div class="col-lg-6">    
                                        <select class="select2_demo_3 form-control" id="my-select">
                                        <option value="" selected disabled="">Select Owner</option>
                                        <?php// getEmployees(); ?>
                                    </select></div>
                                          <div class="col-lg-6"></div>
                                     </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
 -->

<?php include"right_side_bar.php"; ?>
<?php include"footer.php"; ?>