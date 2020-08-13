<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>

<script type="text/javascript">
  function addAssignment() {
       
        //var user_id = "<?php //echo $_SESSION['user_id']; ?>";
        var user_id=6;
        var activity = document.getElementById("activity").value;    
        var measure_of_success = document.getElementById("measure_of_success").value;
        var impact = document.getElementById("impact").value;
        var cf = document.getElementById("cf").value;
        var due_date = document.getElementById("due_date").value;
         //alert(cf);
     
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    addAssignment: "nyasha",
    user_id,
    activity,
    measure_of_success,
    impact,
    cf,
    due_date
  },
  success: function(data){
    // alert(data);
    //document.getElementById("accounts").innerHTML = data;
  }
  });
  }
</script>
<script type="text/javascript">
  function addAccount() {
        var client_id = document.getElementById("client_id").value;
        var employee_number = document.getElementById("employee_number").value;
        var first_name = document.getElementById("first_name").value;
        var last_name = document.getElementById("last_name").value;
        var middle_name = document.getElementById("middle_name").value;
        var email = document.getElementById("email").value;
        var supervisor_email = document.getElementById("supervisor_email").value;
        var account_type = document.getElementById("account_type").value;
        var position = document.getElementById("position").value;
        var department = document.getElementById("department").value;
        var business_unit = document.getElementById("business_unit").value;

     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    addAccount: "Ziwewe",
    client_id,
    employee_number,
    first_name,
    middle_name,
    last_name,
    email,
    supervisor_email,
    account_type,
    position,
    business_unit,
    department

  },
  success: function(data){
   // alert(data);
      $(".modal-body input").val("");
    document.getElementById("accounts").innerHTML = data;
  }
  });
  }
</script>
<script type="text/javascript">
  function deleteAccount(val) {
    alert(val);
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    deleteAccount: "Nyengerai",
    account: val

  },
  success: function(data){
   // alert(data);
    document.getElementById("accounts").innerHTML = data;
  }
  });
  }

    function changeCell(val) {
    //alert(val);
    document.getElementById("actual"+val).innerHTML ='<input type="number" onmouseover="this.focus();" min="0" id="actualvalue'+val+'">';
  }
</script>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Simplified Score Sheet</h5>
                        <div class="ibox-tools">
                          <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i>Add New</a>
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#" class="dropdown-item">Config option 1</a>
                                </li>
                                <li><a href="#" class="dropdown-item">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                    <tr>
                          <th>Activity/Goal</th>
                          <th>Measure of success</th>
                          <th>Due</th>
                          <th>Impact</th>
                          <th>Actual</th>
                          <th>Score</th>
                          <th>CF</th>
                          <th>Action</th>
                        </tr>
                    </tr>
                    </thead>
                    <tbody>
                    <?php    getSimpleTemplate(); ?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                    </table>
                        </div>

                    </div>
                </div>
            </div>
            </div>
        </div>

                 <div class="modal inmodal fade" id="addModal" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Add new Assignment</h4>
                                        </div>
                                        <form  onsubmit="addAssignment()">
                                        <div class="modal-body">
                                      

           

                  <div class="row about-extra">
                    <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12"> 
                    <div class="form-group form-float">
                          <div class="form-line">
                            <input type="hidden" id="client_id" value="<?php echo $_SESSION['client_id']; ?>">
                              <input type="text" id="activity" class="form-control" placeholder="Assignment to be completed" >
                          </div>
                      </div>                  
                     </div>
                  </div>

                  <div class="row about-extra">
               
                    <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                              <input type="text" id="measure_of_success" class="form-control" placeholder="Measure of Success">
                          </div>
                      </div>
                    </div>


                       </div>
                       
                    <div class="row about-extra">

                    <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                              <select id="cf" class="form-control" required>
                                 <option selected disabled value="">Indicate wether the duty can be caried over to the next peiod</option>
                                 <option value="1">Yes</option>
                                 <option value="0">No</option>
                              </select>
                          </div>
                      </div>
                    </div>
                       </div>

                   <div class="row about-extra">

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                   <div class="form-group form-float">
                          <div class="form-line">                                
                        <input type="number" id="impact" min="1" max="10" class="form-control" placeholder="Impact 1 to 10" required>
                         </div>
                       </div>
                    </div>
                 
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                       <div class="form-group form-float">
                          <div class="form-line">                                
                        <input type="date" id="due_date" min="<?php echo date('Y-m-d'); ?>" class="form-control" title="Due Date" required>
                         </div>
                       </div>
                       </div>

              
                       </div>
               
            
                  </div>
                                         <div class="modal-footer">
                                            <button type="submit" class="update_table btn btn-outline-primary">Done</button>
                                        </div>
                                      </form>
                                    </div>
                                </div>
                            </div>




<?php include"footer.php"; ?>




