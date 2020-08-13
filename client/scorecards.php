<?php include"header.php"; ?>

<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>
<style type="text/css">
  label{color: #175ea8; }
</style>

<?php
      if(isset($_POST['delete'])){
        deleteScorecard($_POST['scorecard_id']);
      }
?>

<script type="text/javascript">

  function addM2() {
        var business_unit = document.getElementById("business_unit2").value;
 
        var reporting_period = document.getElementById("reporting_period2").value;
        var client_id = "<?php echo $_SESSION['client_id']; ?>";
  
      if(reporting_period=='' || business_unit==''){
          document.getElementById("error2").innerHTML='*** All fields are required ***';
            return false;
      }
       
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    addM2: "Ziwewe",
    client_id,
    business_unit,
    reporting_period

  },
  success: function(data){
            $('#addm2').modal('hide');
   // alert(data);
    document.getElementById("m2").innerHTML = data;
  }
  });
  }
</script>
<script>
  function addM1() {
        var leader = document.getElementById("leader").value;
     
        var start_date = document.getElementById("start_date").value;
        var reporting_period = document.getElementById("reporting_period").value;
        var platinum = document.getElementById("platinum").value;
        var gold = document.getElementById("gold").value;
        var diamond = document.getElementById("diamond").value;
        var silver = document.getElementById("silver").value;
        var bronze = document.getElementById("bronze").value;
        var nickel = document.getElementById("nickel").value;

        var client_id = "<?php echo $_SESSION['client_id']; ?>";
        
        if(start_date=='' || reporting_period=='' || platinum=='' || gold=='' || diamond=='' || silver=='' || bronze==''){
            document.getElementById("error").innerHTML='*** All fields are required ***';
            return false;
        }
      // alert(start_date);
    //return false;
       
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    addM1: "Ziwewe",
    start_date,
    leader,
    reporting_period,
    platinum,
    gold,
    diamond,
    silver,
    bronze,
    nickel,
    client_id

  },
  success: function(data){
       $('#addm1').modal('hide');
      document.getElementById("m1").innerHTML = data;
  }
  });
  }
</script>


</script>
<script type="text/javascript">
  function addM3() {
   
        var department_id = document.getElementById("department").value;
        var business_unit = document.getElementById("business_unit").value;
         // alert(business_unit);
        var reporting_period = document.getElementById("reporting_period").value;
        var owner = document.getElementById("owner").value;
        var client_id = "<?php echo $_SESSION['client_id']; ?>";
        
        if(department_id=='' || business_unit=='' || reporting_period=='' || owner==''){
            document.getElementById("error3").innerHTML='*** All fields are required ***';
            return false;
        }
   // alert(client_id);
       
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    addM3: "Ziwewe",
    client_id,
    business_unit,
    department_id,
    reporting_period,
    owner

  },
  success: function(data){
   // alert(data);
         $('#addm3').modal('hide');
   document.getElementById("m3").innerHTML = data;
   document.getElementById("without_scorecards").innerHTML = data;
  }
  });
  }
</script>

<script type="text/javascript">
  function addM4() {
   
        //var department_id = document.getElementById("department").value;
        var employee = document.getElementById("employee").value;
         // alert(business_unit);
        //var reporting_period = document.getElementById("reporting_period").value;
        var client_id = "<?php echo $_SESSION['client_id']; ?>";
   // alert(client_id);
    //   alert(employee);
       //return false;
       
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    addM4: "Ziwewe",
    client_id,
    employee


  },
  success: function(data){
   // alert(data);
   ///$('#myModal').modal('hide');
//   document.getElementById("without_scorecards").innerHTML = data;
window.location.reload();
  }
  });
  }
</script>

<script type="text/javascript">
  function addM41(val) {
   
        // var department_id = document.getElementById("department").value;
        // var employee = document.getElementById("employee").value;
         // alert(business_unit);
        //var reporting_period = document.getElementById("reporting_period").value;
        var client_id = "<?php echo $_SESSION['client_id']; ?>";
   // alert(client_id);
    //   alert(employee);
       //return false;
       
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    addM4: "Ziwewe",
    client_id,
    employee: val


  },
  success: function(data){
   // alert(data);
   ///$('#myModal').modal('hide');
//   document.getElementById("without_scorecards").innerHTML = data;
window.location.reload();
  }
  });
  }
</script>

<script type="text/javascript">
  function changeCustodian(val){

    document.getElementById("custodian"+val).innerHTML = '<select class="form-control" id="cust'+val+'" onChange="custodianChanges('+val+')"><option selected disabled>Select Custodian</option><?php getEmployees(); ?></select>';
   }
 </script>

 <script type="text/javascript">
  function custodianChanges(val){
 
       var custodian = document.getElementById("cust"+val).value;
      // alert(custodian);
      

         $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    custodianChanges: "Ziwewe",
    custodian,
    scorecard_id: val

  },
  success: function(data){
   // alert(data);
    location.reload();
    //document.getElementById("bscorecards").innerHTML = data;
    // document.getElementById("dscorecards").innerHTML = data;
  }
  });

   }
 </script>
 <script type="text/javascript">

    function lockScorecards(val) {   
   //alert(val);
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    lockScorecards: "nyasha",
    lock: val
  },
  success: function(data){
  }
  });
  }
</script>

<?php function width(){
 $conn=dbconnect();
if($_SESSION['account_type']==1){
  $width=3;
}elseif($_SESSION['account_type']==2){
  $width=4;
}
elseif($_SESSION['account_type']==3){
  $width=6;
}else{

} return $width;
}
?>

<?php if($_SESSION['account_type']==4){ ?>

  <div class="row">
           <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                       <p align="center">  <b>View Individual Scorecards</b><font color="#175ea8">Lock Scorecards <?php getClientLocks(); ?></font></p>
               
                    </div>
                </div>
            </div>   
           </div>

       <div class="row">
         <div class="col-lg-12">
                <div class="ibox ">
          
           <div class="ibox-content">

                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                     <thead>
                      <tr>
                          <th>Owner</th>
                          <th>Department</th>
                          <th>Position</th>
                          <th>Reporting Period</th>
                          <th>Score</th>
                          <th>Updated On </th>
                           <th>Action</th>
                          
                      </tr>
                  </thead>
                  <tbody>
                  
               <?php     getMyScorecards(); ?>
                                              
                  </tbody>
                  <tfoot>
                       <tr>
                          <th>Owner</th>
                          <th>Department</th>
                          <th>Position</th>
                          <th>Reporting Period</th>
                          <th>Score</th>
                          <th>Updated On </th>
                           <th>Action</th>
                          
                      </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>


  <?php } else{?>

<div class="wrapper wrapper-content">
<?php if(isset($_GET['bydepartment'])){ ?>


      <div class="row">
           <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                       <p align="center">  <b>Scorecards</b></p>
               
                    </div>
                </div>
            </div>
          
      </div>

      <div class="row">
   

    <?php getScorecardsByDepartments(); ?>
    
    </div>


<?php }
         elseif(isset($_GET['business_units']))  {?>

          <div class="row">
           <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                       <p align="center">  <b>View Business Units Scorecards</b></p>
               
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
                          <th>Business Unit</th>
                          <th>Custodian</th>
                          <th>Reporting Period</th>
                          <th>Level</th>
                          <th>Updated On </th>
                          <th>Action</th>
                          
                      </tr>
                  </thead>
                  <tbody id="bscorecards">
                  
               <?php    getBScorecards(); ?>
                                              
                  </tbody>
                  <tfoot>
                  <tr>    
                      
                          <th>Business Unit</th>
                          <th>Custodian</th>
                          <th>Reporting Period</th>
                          <th>Level</th>
                          <th>Updated On</th>
                          <th>Action</th>
                      </tr>
                    </tfoot>
                    </table>
                        </div>

                    </div>

               </div>

        </div>
    </div>

                
                      <?php }
         elseif(isset($_GET['departmental']))  {?>

          <div class="row">
           <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                       <p align="center">  <b>View Departmental Scorecards</b></p>
             
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
                         <th>Department</th>
                          <th>Custodian</th>
                          <th>Business Unit</th>
                          <th>Reporting Period</th>
                          <th>Level</th>
                          <th>Updated On </th>
                          <th>Action</th>
                          
                      </tr>
                  </thead>
                  <tbody id="dscorecards">
                  
               <?php    getDScorecards(); ?>
                                              
                  </tbody>
                  <tfoot>
                  <tr>    
                      
                          <th>Department</th>
                          <th>Custodian</th>
                          <th>Business Unit</th>
                          <th>Reporting Period</th>
                          <th>Level</th>
                          <th>Updated On</th>
                          <th>Action</th>
                      </tr>
                    </tfoot>
                    </table>
                        </div>

                    </div>

               </div>

        </div>
    </div>

                
                      <?php }
                                  elseif(isset($_GET['individual']))  { ?>

          <div class="row">
           <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                       <p align="center">  <b>View Individual Scorecards</b></p>
               
                    </div>
                </div>
            </div>   
           </div>

       <div class="row">
         <div class="col-lg-12">
                <div class="ibox ">
          
           <div class="ibox-content">

                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                     <thead>
                      <tr>
                          <th>Owner</th>
                          <th>Department</th>
                          <th>Position</th>
                          <th>Reporting Period</th>
                          <th>Level</th>
                          <th>Score</th>
                          <th>Updated On </th>
                           <th></th>
                          
                      </tr>
                  </thead>
                  <tbody>
                  
               <?php     getEScorecards(); ?>
                                              
                  </tbody>
                  <tfoot>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

                
                      <?php }

                 elseif(isset($_GET['coporate']))  {?>

          <div class="row">
           <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                       <p align="center">  <b>View Coporate Scorecards</b></p>
               
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
                          <th>Reporting Period</th>
                          <th>Level</th>
                          <th>Score</th>
                          <th>Updated On </th>
                          <th>Action</th>
                          
                      </tr>
                  </thead>
                  <tbody>
                  
                <?php    getScorecards(); ?>
                                              
                  </tbody>
                  <tfoot>
                  <tr>    
                          <th>Reporting Period</th>
                          <th>Level</th>
                          <th>Score</th>
                          <th>Updated On </th>
                          <th>Action</th>
                      </tr>
                    </tfoot>
                    </table>
                        </div>

                    </div>

               </div>

        </div>
    </div>

                
                      <?php }

else{?>


      <div class="row">
           <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                       <p align="center">  <b>Scorecards by Category</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <font color="#175ea8"> Lock Scorecards <?php getClientLocks(); ?></font></p>
                       
<?php if(isset($_GET['deletesuccess'])){?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success !!!</strong> Scorecard was successfully deleted.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

             <?php  } ?>
               
                    </div>
                </div>
            </div>
          
      </div>

        <div class="row">
          <?php if($_SESSION['account_type']==1){?>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Coporate <font color="#175ea8"><button type="button" class="btn btn-outline-secondary m-r-sm" id="m1"><?php echo countScorecards(1); ?></button></font></h5>
               
                    </div>
                    <div class="ibox-content">
                      <div class="btn-group">
                   <a href="myscorecards?coporate"><button class="btn btn-outline-primary btn-lg" ><i class="fa fa-folder-open"></i> View</button>  </a>
                    <button class="btn btn-outline-primary" data-toggle="modal" data-target="#addm1"> <i class="fa fa-plus-square"></i> Add new</button>
                    </div>

                </div>
                </div>
            </div>
          <?php } if($_SESSION['account_type']==2 || $_SESSION['account_type']==1){?>
            <div class="col-lg-<?php echo width(); ?>">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Business Unit <font color="#175ea8"><button type="button" class="btn btn-outline-secondary m-r-sm" id="m2"><?php echo countScorecards(2); ?></button></font></h5>
                    </div>
                    <div class="ibox-content">
                      <div class="btn-group">
                    <a href="myscorecards?business_units">
                      <button class="btn btn-outline-primary btn-lg"><i class="fa fa-folder-open"></i> View</button>  </a>
                      <button class="btn btn-outline-primary" data-toggle="modal" data-target="#addm2"> <i class="fa fa-plus-square"></i> Add new</button>
                    </div>
                    </div>
                </div>
            </div>
          <?php } ?>
              <div class="col-lg-<?php echo width(); ?>">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Departmental <font color="#175ea8"><button type="button" class="btn btn-outline-secondary m-r-sm" id="m3"><?php echo countScorecards(3); ?></button></font></h5>
               
                    </div>
                    <div class="ibox-content">
                      <div class="btn-group">
                 <a href="myscorecards?departmental"><button class="btn btn-outline-primary btn-lg"><i class="fa fa-folder-open"></i> View</button></a>
                 <button class="btn btn-outline-primary" data-toggle="modal" data-target="#addm3"> <i class="fa fa-plus-square"></i> Add new</button>
                    </div>
                    </div>
                </div>
            </div>

               <div class="col-lg-<?php echo width(); ?>">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Individual <font color="#175ea8"><button type="button" class="btn btn-outline-secondary m-r-sm" id="m4"><?php echo countScorecards(4); ?></button></font>
              
                    </div>
                    <div class="ibox-content">
                      <div class="btn-group">
                 <a href="myscorecards?bydepartment"><button class="btn btn-outline-primary btn-lg"><i class="fa fa-folder-open"></i> View</button> </a> 
                    <!--<a href="add_scorecards.php?level=4" class="btn btn-outline-primary"> <i class="fa fa-plus-square"></i> Add new</a>-->
                     <a data-toggle="modal" data-target="#myModal" class="btn btn-outline-primary"> <i class="fa fa-plus-square"></i> Add new</a>
                    </div>
                    </div>
                </div>
            </div>
        
        </div>

           <div class="row">
           <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <p align="center"><b>Employees with no active Scorecards</b></p>
                                    
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
</div>
<?php }
}
 ?>
 <div class="modal inmodal fade" id="addm1" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <h3>Creating a New Coporate scorecard</h3>
          </div>
          <div class="modal-body">
<div class="row">
  
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                    <div class="form-group form-float"><label>Title of the responsible Person</label>
                      <div class="form-line">
                              <input type="text" id="client_id" name="client_id" class="form-control" placeholder="client" value="<?php echo $_SESSION['client_id']; ?>" hidden>
                              <input type="text" id="leader"  name="leader" class="form-control" placeholder="Specify Who is responsible for your organisational scorecard" required>
                      </div>
                    </div>                  
              </div>
              <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12"> 
                <div class="form-group form-float"><label>Start Date</label>
                  <div class="form-line">
                    <input type="date" id="start_date"  name="start_date" class="form-control" min="<?php echo date('Y-m-d'); ?>"  placeholder="Reporting Period" required>
                  </div>
                </div>                  
              </div>
                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12"> 
                <div class="form-group form-float"><label>End Date</label>
                  <div class="form-line">
                    <input type="date" id="reporting_period"  name="reporting_period" class="form-control" min="<?php echo date('Y-m-d'); ?>"  placeholder="Reporting Period" required>
                  </div>
                </div>                  
              </div>

</div>

                 <h4><font color="#175ae8">May you specify how your organisation will rate scores in terms of respective minerals:</font></h4>
                  <hr>
          <div class="row about-extra">
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                    <div class="form-group form-float"><label>Platinum</label>
                          <div class="form-line">
                              <input type="number" min="50" max="100" id="platinum" name="platinum" class="form-control" placeholder="minimum score (60 recommended)">
                              
                          </div>
                      </div>                  
              </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                    <div class="form-group form-float"><label>Gold</label>
                          <div class="form-line">
                              <input type="number" min="30" max="59" id="gold" name="gold" class="form-control" placeholder="minimum score (40 recommmended)">

                          </div>
                    </div>                  
                </div>
              </div>

              <div class="row about-extra">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                  <div class="form-group form-float"><label>Diamond</label>
                      <div class="form-line">
                              <input type="number" min="10" max="40" id="diamond" name="diamond" class="form-control" placeholder="minimum score (20 recommended)">
                              
                      </div>
                      </div>                  
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                    <div class="form-group form-float"><label>Silver</label>
                          <div class="form-line">
                              <input type="number" min="0"  max="20" id="silver" name="silver" class="form-control" placeholder="minimum score (0 recommended)">

                          </div>
                      </div>                  
                     </div>
                   </div>

                  <div class="row about-extra">
                  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                    <div class="form-group form-float"><label>Bronze</label>
                          <div class="form-line">
                              <input type="number" min="-100" max="-1" id="bronze" name="bronze" class="form-control" placeholder="minimum score (-30 recommended)">
                              
                          </div>
                      </div>                  
                     </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                    <div class="form-group form-float"><label>Nickel</label>
                          <div class="form-line">
                              <input type="number" value="-100" id="nickel" name="nickel" class="form-control" placeholder="minimum score" readonly>

                          </div>
                      </div>                  
                     </div>
                    </div>  
                    
                    <p align="center" id="error" style="color: red"></p>
                   </div>

                                        <div class="modal-footer">
                                     <button type="reset" class="btn btn-danger m-t-15 waves-effect"><i class="fa fa-refresh"></i> Reset Form</button>
                                            <button type="submit" class="ladda-button ladda-button-demo btn btn-primary m-t-15 waves-effect" onClick="addM1()"><i class="fa fa-save" ></i> Save New Scorecard</button>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>

                       
  <div class="modal inmodal fade" id="addm3" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <h3>Creating a New Departmental scorecard</h3>
          </div>
          <div class="modal-body">

           <div class="row about-extra">
                     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                    <div class="form-group form-float"><label>Scorecard Department</label>
                          <div class="form-line">
                            <input type="text" id="client_id" name="client_id" value="<?php echo $_SESSION['client_id']; ?>" class="form-control" placeholder="client" hidden>
                             <select id="department" class="form-control" required>
                              <?php if($_SESSION['account_type']==3){
                             echo'<option value="'.$_SESSION['department_id'].'">'.getDepartmentName($_SESSION['department_id']).'</option>';
                              }else{ ?>
                                <option selected disabled>Select Department</option>
                              <?php }
                               getDepartments(); ?>
                               </select>
                               <label>Business Unit</label>
                                  <select id="business_unit" class="form-control" required>
                                <?php if($_SESSION['account_type']!=1){
                             echo'<option value="'.$_SESSION['business_unit'].'">'.getBusinessUnitName($_SESSION['business_unit']).'</option>';
                              }else{ ?>
                                <option selected disabled>Select Business Unit</option>
                              <?php }
                               listBusinessUnits($_SESSION['client_id']); ?>
                               </select>
                          </div>
                      </div>                  
                     </div>  
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                    <div class="form-group form-float">
                        <label>Custodian</label>
                          <div class="form-line">
                              <select id="owner" name="owner" class="form-control" required>
                                  <option value="" selected disabled>Select Owner</option>
                                  <?php   getSupervisors(); ?>
                              </select>
                          </div>
                      <label>Reporting Period</label>
                          <div class="form-line">
                              <input type="date" id="reporting_period" name="reporting_period" class="form-control" min="<?php echo date('Y-m-d'); ?>"  placeholder="Reporting Period" required>

                          </div>
                      </div>
                     </div>                
            </div>
                      <p align="center" id="error3" style="color: red"></p>
         
                   </div>
                                        <div class="modal-footer">
                                     <button type="reset" class="btn btn-danger m-t-15 waves-effect"><i class="fa fa-refresh"></i> Reset Form</button>
                                            <button class="ladda-button ladda-button-demo btn btn-primary m-t-15 waves-effect" onClick="addM3()" data-dismiss="modal" ><i class="fa fa-save" ></i> Save New Scorecard</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
  
   <div class="modal inmodal fade" id="addm2" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <h3>Creating a New Business Unit scorecard</h3>
          </div>
          <div class="modal-body">

           <div class="row about-extra">
                     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                    <div class="form-group form-float"><label>Business Unit</label>
                          <div class="form-line">
                            <input type="text" id="client_id" name="client_id" value="<?php echo $_SESSION['client_id']; ?>" class="form-control" placeholder="client" hidden>
                             <select id="business_unit2" class="form-control" required>
                                <option selected disabled>Select Business Unit</option>
                                <?php listBusinessUnits($_SESSION['client_id']); ?>
                               </select>
                          </div>
                      </div>                  
                     </div>  
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                    <div class="form-group form-float"><label>Reporting Period</label>
                          <div class="form-line">
                              <input type="date" id="reporting_period2" value="" class="form-control" min="<?php echo date('Y-m-d'); ?>"  placeholder="Reporting Period" required>

                          </div>
                      </div>                  
                     </div>   

            </div>
                     
                     <p align="center" id="error2" style="color: red"></p>
                   </div>
                                        <div class="modal-footer">
                                     <button type="reset" class="btn btn-danger m-t-15 waves-effect"><i class="fa fa-refresh"></i> Reset Form</button>
                                            <button class="ladda-button ladda-button-demo btn btn-primary m-t-15 waves-effect" onClick="addM2()" data-dismiss="modal" ><i class="fa fa-save" ></i> Save New Scorecard</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                  


  <div class="modal inmodal fade" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Create Individual Score Card</h4>
                                        </div>
                                        <div class="modal-body">
                                     <div class="row">
                                         <div class="col-lg-12">    
                                        <select class="form-control" id="employee">
                                        <option value="" selected disabled="">Select Owner (only those without active scorecards)</option>
                                        <?php listEmployeesWithoutScorecards(); ?>
                                    </select></div>
                                          
                                     </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                            <button type="button" onClick="addM4()" class="btn btn-primary">Create Scorecard</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

<?php //include"right_side_bar.php"; ?>
<?php include"footer.php"; ?>

 <script>
        $(document).ready(function(){
            var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, { color: '#1AB394' });
        });
  

   </script>