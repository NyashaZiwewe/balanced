<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; error_reporting(0); ?>


<script type="text/javascript">
 function CheckSchedulingDates() {
  var SD = document.getElementById('startdate').value;
  var ED = document.getElementById('enddate').value;
    if (Date.parse(SD) >= Date.parse(ED)) {
    alert('The ending date must occur after the starting date.');
    //location.reload();    
    document.getElementById('startdate').value=' ';
    document.getElementById('enddate').value=' ';
    return false;
  }
}


</script>

<script>
  function addCode(val) { 
       myvalue='';

   myvalue+='<div class="input-group"><input type="text" id="task'+val+'" placeholder="Add new item on the check list and due date" class="form-control" ><span class="input-group-append"><input type="date" id="date'+val+'" min="<?php echo date('Y-m-d'); ?>" class="form-control"><button class="btn btn-success btn-sm" onclick="addTask('+val+')"><i class="fa fa-check fa-lg"></i></button></span></div>'; 

document.getElementById("add_to_me"+val).innerHTML += myvalue;
document.getElementById("button"+val).innerHTML = ''; 
 
        } 
    
</script>

<script type="text/javascript">
 function addTask(val) {
       
      var due_date = document.getElementById("date"+val).value;
      var task = document.getElementById("task"+val).value;

      if(due_date=='' || task ==''){
      document.getElementById("warning"+val).innerHTML = 'Please fill out all fields, they are all required***';
      document.getElementById("button"+val).innerHTML = ' ';
      return false;
      }else{
         document.getElementById("warning"+val).innerHTML = ' ';
      }
   
  $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    addTask: "nyasha",
    task,
    project_id: val,
    due_date
  },
  success: function(data){
   
 document.getElementById("add_to"+val).innerHTML = data;
 document.getElementById("task"+val).value ='';
 document.getElementById("date"+val).value ='';

  }
  });
}

 function updateTaskStatus(val,val2,val3) {
        var scorecard_id = "<?php echo $_GET['sid']; ?>";
        //alert(scorecard_id);
        //return false;
        
  $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    updateTaskStatus: "nyasha",
    task_id : val,
    status: val2,
    scorecard_id,
    project_id : val3
  },
  success: function(data){

  }
  });
}

 function updateTaskProgress(val) {

        //alert(val);
        var task_id = document.getElementById('task_id').value;
        //alert(taskID);
       // return false;
        
  $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    updateTaskProgress: "nyasha",
    task_id,
    value : val
  
  },
  success: function(data){
    //alert(data);
  }
  });
}

 function updateProjectStatus(val, val2) {
   // alert(val +' '+val2);
    //return false;
  $.ajax({
  type: "POST",
  url: "autosave.php",
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

<script type="text/javascript">
  function echoTaskId(val){

  if(val=='measure_tasks'){
    document.getElementById('tasklist').innerHTML='<select name="task_id" class="form-control"><option selected disabled>Select Task</option><?php echo selectMeasureTasks($_GET['sid']); ?></select>';
  } else{
     document.getElementById('tasklist').innerHTML='<select name="task_id" class="form-control"><option selected disabled>Select Task</option><?php echo selectProjectTasks($_GET['sid']); ?></select>';  
  }
  }
</script>

<script type="text/javascript">
  function changeProjects(val){
//var scope = document.getElementById('table_tracker').value;
var filter = document.getElementById('filter').value;
var max =4;
      // show me only out of all kids
      for (var i = 0; i < max; i++) {

        if (i==val) {
          //document.getElementById('t'+i).style.display = '';
          document.getElementById('b'+i).style.borderColor = '#175ea8';
          document.getElementById('b'+i).style.borderWidth = 'medium';
          document.getElementById('table_tracker').value=val; 
     
        } else{
       // document.getElementById('t'+i).style.display = 'none';
        document.getElementById('b'+i).style.borderColor = '';
        document.getElementById('b'+i).style.borderWidth = '';

        }
      }
     // alert(val+' '+filter);

        $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    getProjectsTable: "nyasha",
    scope : val,
    status: filter
  },
  success: function(data){
 document.getElementById('table').innerHTML=data; 
  }
  });
    
  }

    function changeFilter(val){
var scope = document.getElementById('table_tracker').value;
//var filter = document.getElementById('filter').value;
var max =5;
      // show me only out of all kids
      for (var i = 0; i < max; i++) {

        if (i==val) {

          document.getElementById('f'+i).style.borderColor = '#175ea8';
          document.getElementById('f'+i).style.borderWidth = 'medium';
          document.getElementById('filter').value=val; 
     
        } else{

        document.getElementById('f'+i).style.borderColor = '';
        document.getElementById('f'+i).style.borderWidth = '';

        }
      }
 $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    getProjectsTable: "nyasha",
    scope,
    status: val
  },
  success: function(data){
 document.getElementById('table').innerHTML=data; 
  }
  });
  }

</script>

<script type="text/javascript">
  function changeTasks(val){
   // alert(val);
    //var i ="<?php //echo getProjectsTable(0); ?>";

document.getElementById('div').innerHTML=i;

  }
</script>



<style type="text/css">
  label{ color: #175ea8; font-weight: bold; }
</style>
<?php
if(isset($_POST['saveproject'])){
  saveProject($_POST['client_id'],$_POST['scorecard_id'], $_POST['project'],$_POST['description'],$_POST['manager'],$_POST['start_date'],$_POST['end_date']);
  exit;
}

if (isset($_POST['upload'])){

if($_FILES['evidence']['error']==0){

 $evidence = rand(1000,100000)."-".$_FILES['evidence']['name'];
 $location = $_FILES['evidence']['tmp_name'];
 $size = $_FILES['evidence']['size'];
 $type = $_FILES['evidence']['type'];
 $folder="evidence/";
 $link= "";
 $evidence="$link".$evidence;
 move_uploaded_file($location,$folder.$evidence);
 uploadFile($_POST['table'],$_POST['task_id'],$evidence,$_POST['scorecard_id']);
 exit;
}
else{

}
}

if(isset($_GET['sid'])){
  ?>     


       <div class="row wrapper border-bottom white-bg page-heading">
          
                   

                      <div class="col-lg-6">
                        <div class="ibox">
                            <div class="ibox-content">
                               <a href="action_plans.php"><button>Change View</button></a>
                                <h2>Action Plans for <b><?php echo getOwner($_GET['sid']);  ?></b></h2>
                            </div>
                         </div>
                       </div>

                      <div class="col-lg-6" >
                        <div class="ibox">
                            <div class="ibox-content">
                              <div class="row">
                              <button class="btn btn-outline-info" data-toggle="modal" data-target="#documents"> <i class="fa fa-file"> Supporting Documents</i></button>
                              <button class="btn btn-outline-info" data-toggle="modal" data-target="#upload"> <i class="fa fa-upload"> Upload center</i></button>
                                <a class="btn btn-outline-info" data-toggle="modal" data-target="#outstanding">Overdue Action plans 
                                 <?php echo getOutstandingPercentage();?></a>
                               </div>
                            </div>
                         </div>
                       </div>

                </div>


        <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-lg-4" id="style-11" style="height: 500px; overflow: auto;">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>To-do List</h3>
                            <p class="small"><i class="fa fa-hand-o-up"></i> Drag task between list</p>

                            <div class="input-group">                              
                                        <button type="button" data-toggle="modal" data-target="#project" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i> Add Project</button>                             
                            </div>

                            <ul class="sortable-list connectList agile-list" id="todo" >
                        <?php getProjects(0); getProjects(2); ?>
                    
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" id="style-11" style="height: 500px; overflow: auto;">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>In Progress</h3>
                            <p class="small"><i class="fa fa-hand-o-up"></i> Drag task between list</p>
                            <ul class="sortable-list connectList agile-list" id="inprogress" ondrop="alert(1);">
    
                          <?php getProjects(1); ?>   
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" id="style-11" style="height: 500px; overflow: auto;">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>Completed</h3>
                            <p class="small"><i class="fa fa-hand-o-up"></i> Drag task between list</p>
                            <ul class="sortable-list connectList agile-list" id="completed">
                              <?php getProjects(3); ?>                                                
                              
                            </ul>
                        </div>
                    </div>
                </div>

            </div>  

            <?php

             }else{ ?>
 <div class="wrapper wrapper-content  animated fadeInRight">

<div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                         <a href="action_plans.php?sid=<?php echo getScoreCardID(); ?>"><button>Change View</button></a>
                        <div class="ibox-tools">

                          <?php if($_SESSION['account_type']==4){?>
                          <input type="hidden" id="table_tracker" value="0">
                          <button class="btn btn-primary kid btn-sm" id="b0" onclick="changeProjects(0)">My Projects</button>
                          <a class="btn btn-primary btn-sm" id="b1" onclick="changeProjects(1)">My Team's Projects</a>
                          <a class="btn btn-primary btn-sm" id="b2" onclick="changeProjects(2)">Other teams' Projects</a>
                          <a class="btn btn-primary btn-sm" id="b3" onclick="changeProjects(3)">All Projects</a>
                        <?php }else{?>
                             <input type="hidden" id="table_tracker" value="3">
                         <?php } ?>
                        </div>
                    </div>
                      <div class="ibox-title">
                        <div class="ibox-tools">
     
                          <input type="hidden" id="filter" value="0" >
                          <button class="btn btn-primary btn-sm" id="f0" onclick="changeFilter(0)">New <i class="fa fa-filter"></i></button>
                          <button class="btn btn-primary btn-sm" id="f1" onclick="changeFilter(1)">In Progress <i class="fa fa-filter"></i></button>
                          <button class="btn btn-warning btn-sm" id="f2" onclick="changeFilter(2)">On Hold <i class="fa fa-filter"></i></button>
                          <button class="btn btn-success btn-sm" id="f3" onclick="changeFilter(3)">Completed <i class="fa fa-filter"></i></button>
                          <button class="btn btn-sm" id="f4" onclick="changeFilter(4)">All <i class="fa fa-filter"></i></button>
                        </div>
                    </div>
                    <div class="ibox-content">

                    <div class="table-responsive">
                    <table class="table table-hover dataTables-example">
                    <thead>
                    <tr>
                          <th>Project</th>
                          <th>Activities</th>
                          <th>Measure of Success</th>
                          <th>Due Date</th>
                          <th>Manager</th>
                          <th>Progress</th>
                          <th>Triger</th>
                        </tr>
                    </thead>
      
                   
               <tbody  id="table" >
       <?php   echo getProjectsTable(3,4); ?>
                     </tbody>          

                   </table>
                  </div>
                 </div>
                </div>
               </div>
             </div>
     

           <?php }  ?>

          <div class="modal fade" id="project" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">Add Project </h4>
                </div>
                <div class="modal-body" >
                <form action="action_plans.php" method="POST">

                  <div class="row" >
                    <div class="col-lg-12">
                      <div class="form-group">
                    <input type="text" name="client_id" hidden value="<?php echo $_SESSION['client_id']; ?>">
                    <input type="text" name="scorecard_id" hidden value="<?php echo getScorecardID(); ?>">

                     <label>Project Name</label>
                      <input type="text" class="form-control" name="project" placeholder="Project Name" required minlength="3">

                       <label>Project Manager</label>
                      <select name="manager" class="form-control" required>
                        <option value="" required selected disabled>Select Project Manager</option>
                        <?php getEmployees(); ?>
                      </select>

                      <label>Start Date</label>
                    <input type="date" id="startdate" onChange="CheckSchedulingDates(this.value)" class="form-control" name="start_date" required >

                       <label>End Date</label>
                    <input type="date" min="<?php echo date('Y-m-d'); ?>" id="enddate" onChange="CheckSchedulingDates(this.value)" class="form-control" name="end_date" required>   

                     <label >Description</label>
                      <textarea name="description" class="form-control" rows="8" required minlength="10"></textarea>
                
                      </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                    <button type="submit" class="btn btn-primary" name="saveproject">Save Project</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>



          <div class="modal fade" id="outstanding" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">Outstanding action plans for <?php echo getOwner($_GET['sid']).' As at <font color="#175ea8">'. date('Y-m-d'); ?></font></h4>
                  
                  

                         <div class="ibox-tools">
                          <button class="btn btn-secondary"><i class="fa fa-print"></i></button> 
                           <button class="btn btn-secondary"><i class="fa fa-download"></i></button>                       
                       
                        </div>

                </div>
                <div class="modal-body" >
                <form action="action_plans.php" method="POST">

                  <div class="row" >
                    <div class="col-lg-12">
                   <ul class="list-unstyled"> 
                <?php getOutStandingAP(); ?>
                  </ul>
                    </div>
                  </div>
                  <div class="form-group" align="right">
               
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>


          <div class="modal fade" id="modal" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content" >
        
                <div class="modal-body" >
           

                  <div class="form-group" align="right">
               
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
              
            </div>
          </div>



          <div class="modal fade" id="upload" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">Upload Center for <?php echo getOwner($_GET['sid']); ?></h4>

                </div>
                <div class="modal-body" >
                <form action="action_plans.php" method="POST" enctype="multipart/form-data">

                  <div class="row" >
                    <div class="col-lg-12">
                      <select name="table" class="form-control" onChange="echoTaskId(this.value)">
                        <option selected disabled>Select Type of Item</option>
                        <option value="project_tasks">Project Specific</option>
                        <option value="targets">Measure Specific</option>
                      </select>
                      <input type="hidden" name="scorecard_id" value="<?php echo getScorecardID(); ?>">
                    <label>Task referenced</label>
                    <!-- <select name="task_id" class="form-control"> -->
                        <!-- <option selected disabled>Select Task</option> -->
                       <!-- echo selectProjectTasks(getScorecardID()); -->
                    <!-- </select> -->
                        
                    <div id="tasklist">
                 <input type="text" placeholder="Select Type of Item" readonly class="form-control">
                   </div>
                      <label>Supporting Document</label>
                  <input type="file" name="evidence" class="form-control" placeholder="choose document to upload" accept="application/pdf">

                    </div>
                  </div>
                  <div class="form-group" align="right">
               
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" name="upload" class="btn btn-success">Upload</button>
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>



          <div class="modal fade" id="documents" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">All Supporting Documents : <?php echo getOwner($_GET['sid']); ?></h4>

                </div>
                <div class="modal-body" >


                  <div class="row" >
<?php getSupportingDocuments($_GET['sid']); ?>


</div>


         </div>
                  <div class="form-group" align="right">
               
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>

  <script type="text/javascript">
  function getTaskID(val){

document.getElementById('task_id').value = val;
}
</script>


<?php //include"right_side_bar.php"; ?>
<?php include"footer.php"; ?>


