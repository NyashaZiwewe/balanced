<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>

<script type="text/javascript">
  function saveAccount(val) {
    
        var employee_number = document.getElementById("employee_number"+val).value;
           alert(employee_number);
        var first_name = document.getElementById("first_name"+val).value;
        var last_name = document.getElementById("last_name"+val).value;
        var middle_name = document.getElementById("middle_name"+val).value;
        var email = document.getElementById("email"+val).value;
        var supervisor_email = document.getElementById("supervisor_email"+val).value;
        var account_type = document.getElementById("account_type"+val).value;
        var position = document.getElementById("position"+val).value;
        var department = document.getElementById("department"+val).value;
        var client_id = <?php echo $_SESSION['client_id']; ?>
    
       // alert(val +' '+ name +' '+head);
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    saveAccount: "nyasha",
    id: val,
    employee_number,
    client_id,
    first_name,
    middle_name,
    last_name,
    email,
    supervisor_email,
    account_type,
    position,
    department
  },
  success: function(data){
   // alert(data);
    document.getElementById("accounts").innerHTML = data;
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
    department

  },
  success: function(data){
   // alert(data);
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
</script>


        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Employee Records</h5>
                        <div class="ibox-tools">
                          <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i>Add New</a>
                           <a class="btn btn-primary btn-sm" href="add_multiple.php"><i class="fa fa-plus"></i>Add Multiple Accounts</a>
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
                          <th>Full Name</th>
                          <th>Email</th>
                          <th>Job Title</th>
                          <th>Department</th>
                          <th>Supervisor</th>
                          <th>Account Type</th>
                          <th>Action</th>
                        </tr>
                    </tr>
                    </thead>
                    <tbody>
                    <?php    getAccounts(); ?>
                    </tbody>
                    <tfoot>
                    <tr>
                          <th>Full Name</th>
                          <th>Email</th>
                          <th>Job Title</th>
                          <th>Department</th>
                          <th>Supervisor</th>
                          <th>Account Type</th>
                          <th>Action</th>
                    </tr>
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
                                            <h4 class="modal-title">Add new Employee</h4>
                                        </div>
                                        <div class="modal-body">
                                      

           


                  <div class="row about-extra">
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                    <div class="form-group form-float">
                          <div class="form-line">
                          </div>
                      </div>                  
                     </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                    <div class="form-group form-float">
                          <div class="form-line">
                            <input type="hidden" id="client_id" value="<?php echo $_SESSION['client_id']; ?>">
                              <input type="text" id="employee_number" class="form-control" placeholder="Employee Number" >
                          </div>
                      </div>                  
                     </div>
                        </div>


                          <div class="row about-extra">
                     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                              <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name" required>
                          </div>
                      </div>
                    </div>
               
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                              <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name" required>
                          </div>
                      </div>
                      </div>
                       </div>

                         <div class="row about-extra">
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                              <input type="text" id="middle_name" name="middle_name" class="form-control" placeholder="Midle Name">
                          </div>
                      </div>
                    </div>
                 
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                       <div class="form-group form-float">
                          <div class="form-line">                                
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email Address" required>
                         </div>
                       </div>
                       </div>
                       </div>


                             <div class="row about-extra">
                   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                              <select id="supervisor_email" class="form-control" >
                                 <?php    getSupervisors(); ?>
                              </select>
                          </div>
                      </div>
                    </div>
                    
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                             <select class="form-control show-tick" id="account_type" required>
                          <option value="" selected disabled>Account Type</option>
                             <?php     getAccessLevels(); ?>
                          </select>
                          </div>
                      </div>
                      </div>
                      </div>


                         <div class="row about-extra">
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                           <input type="text" id="position" name="position" class="form-control" placeholder="Job Title" required>
                          </div>
                      </div>
                    </div>
                  
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                       <div class="form-group form-float">
                          <div class="form-line">
                              <select id="department" name="department" class="form-control" placeholder="Department" required>
                                <?php  getDepartments();  ?>
                              </select>
                          </div>
                      </div>
                    </div>
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      </div>
                    </div>

                </div>
                                         <div class="modal-footer">
                                            <button type="button" class="update_table btn btn-outline-primary" onclick="addAccount()" data-dismiss="modal">Done</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


<?php include"footer.php"; ?>