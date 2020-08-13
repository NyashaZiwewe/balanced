<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>

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

<script>

// const date = document.querySelector('input[type="date"]');

// date.addEventListener('focus', (event) => {
//   event.target.type = 'text';
// });

// date.addEventListener('blur', (event) => {
//    event.target.type = 'number';    
// });


  
  function addCode(val) { 

       myvalue='';
      // var x=1;
  
 myvalue+='<div class="input-group"><input type="text" id="list'+val+'" placeholder="Add new item on the check list and due date" class="form-control" ><span class="input-group-append"><input type="date" id="date'+val+'" min="<?php echo date('Y-m-d'); ?>" class="form-control"><button class="btn btn-success btn-sm" onclick="addTask('+val+')"><i class="fa fa-check fa-lg"></i></button></span></div>'; 
                                           


document.getElementById("add_to_me"+val).innerHTML += myvalue;
document.getElementById("button"+val).innerHTML = ''; 
 
        } 
    
</script>

<script type="text/javascript">
 function addTask(val) {
        
      var due_date = document.getElementById("date"+val).value;
      var list = document.getElementById("list"+val).value;

      if(due_date=='' || list ==''){
      document.getElementById("warning"+val).innerHTML = 'Please fill out all fields, they are all required***';
      document.getElementById("button"+val).innerHTML = ' ';
      return false;
      }else{
         document.getElementById("warning"+val).innerHTML = ' ';
      }
     // alert(due_date);
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    addPepList: "nyasha",
    list,
    pep_id: val,
    due_date

  },
  success: function(data){
    //alert(data);
 document.getElementById("add_to"+val).innerHTML = data;
 document.getElementById("list"+val).value ='';
 document.getElementById("date"+val).value ='';
 //addCode(val);
  }
  });
}

 function updateListStatus(val,val2) {
   
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    updatePepList: "nyasha",
    pep_id : val,
    status: val2,
  },
  success: function(data){
  }
  });
}

 function updateProjectStatus(val, val2) {
   // alert(val +' '+val2);
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    updateProjectStatus: "nyasha",
    project_id : val2,
    status: val,
  },
  success: function(data){
  }
  });
}
</script>

<style type="text/css">
  label{ color: #175ea8; font-weight: bold; }
</style>
<?php
if(isset($_POST['saveplan'])){
 //  $employee_id=$_POST['id'];
 // echo "<script language=javascript> alert('$employee_id'); exit; </script>"; 

  savePlan($_POST['employee_id'], $_POST['scorecard_id'],$_POST['reason'],$_POST['description']);
  exit;
}

?>            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-12">
                    <h2>Performance Improvement Plans for <b><?php echo getOwner($_GET['sid']);  ?></b></h2>

                </div>
            </div>

        <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-lg-12" id="style-11" style="height: 500px; overflow: auto;">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>A check List for Proposed Plans</h3>

                            <div class="input-group">                              
                                        <button type="button" data-toggle="modal" data-target="#project" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i> Add New Plan</button>                             
                            </div>

                            <ul class="sortable-list connectList agile-list" id="todo" >
                        <?php getPep(getOwnerID($_GET['sid'])); ?>
                    
                            </ul>
                        </div>
                    </div>
                </div>



            </div>

          <div class="modal fade" id="project" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">Add Performance Emprovement Plans </h4>
                </div>
                <div class="modal-body" >
                <form action="pep.php" method="POST">

                  <div class="row" >
                    <div class="col-lg-12">
                      <div class="form-group">
                    <input type="text" name="scorecard_id" hidden value="<?php echo $_GET['sid']; ?>">

                     <label>Reason For issuing Performance Improvement Plans</label>
                      <input type="text" class="form-control" name="reason" placeholder="Why Performance Improvement Plans?" required minlength="3">

                       <label>Employee</label>
                      <select name="employee_id" class="form-control" required>
                        <option value="<?php echo getOwnerID($_GET['sid']); ?>" required selected><?php echo getEmployeeName(getOwnerID($_GET['sid'])); ?></option>
                          <option value="">CEO</option>
                      </select> 
                     <label >Description {a short description}</label>
                      <textarea name="description" class="form-control" rows="8" required minlength="10" placeholder="A short description of the main aim"></textarea>
                
                      </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                    <button type="submit" class="btn btn-primary" name="saveplan">Save Plan</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>

<?php //include"right_side_bar.php"; ?>
<?php include"footer.php"; ?>