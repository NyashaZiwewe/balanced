<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; error_reporting(0); ?>
<?php //include"trello/functions.php";
require_once "trello/ProjectManagement.php"; ?>

<script type="text/javascript">

    function addCard(val) {
  // alert(val);
       var textarea = document.getElementById('textarea'+val).value;

  $.ajax({
  type: "POST",
 url: "/demo/client/autosave.php",
  data:{
    title: textarea,
    employee_id:val,
  },
  success: function(data){
    
    //location.reload();
  // console.log(data);
   document.getElementById("sort"+val).innerHTML = data;
  }
  });
}
</script>


<script type="text/javascript">

  function newCard(val){
    //alert(val);
    document.getElementById('myNewCard'+val).innerHTML='<li class="text-row ui-sortable-handle" id="row'+val+'"><textarea id="textarea'+val+'" style="width: 100%;" rows="3" placeholder="Enter Project Name"></textarea></li>';

    document.getElementById('buttons'+val).innerHTML='<button class="btn btn-outline-success btn-sm" onClick="addCard('+val+');">Save card</button>';
  }

</script>



<style type="text/css">
 textarea {
 border:none; 
 font-size: 13px;
 font-weight: bold;

}

.task-board {
    /*background: #2c7cbc;*/
    display: inline-block;
    padding: 10px;
    border-radius: 3px;
    width: 98%;
    height: 150%;
    white-space: nowrap;
    min-height: 550px;
    /*max-height: 550px;*/
    overflow-x: auto;
    
}

.status-card {
    width: 320px;
    margin-right: 8px;
    /*background: #e2e4e6;*/
    background: #ebecf0;
    border-radius: 3px;
    display: inline-block;
    vertical-align: top;
    /*font-size: 0.9em;*/
    font-size: 14px;
    max-height: 570px;
    overflow-x: hidden;
    overflow-y: scroll;

    
}
.status-card:last-child {
    margin-right: 0px;

}

.card-header {
    width: 100%;
    padding: 10px 10px 0px 10px;
    box-sizing: border-box;
    border-radius: 5px;
    display: block;
    font-weight: bold;
    border-bottom: none;
    /*position: fixed;*/
}

.card-header-text {
    display: block;
}

ul.sortable {
    padding-bottom: 10px;
}

ul.sortable li:last-child {
    margin-bottom: 0px;
}

ul {
    list-style: none;
    margin: 0;
    padding: 0px;
}

.text-row {
    padding: 15px 10px;
    margin: 10px;
    background: #fff;
    box-sizing: border-box;
    border-radius: 3px;
    border-bottom: 1px solid #ccc;
    cursor: pointer;
    /*font-size: 0.9em;*/
    font-size: 14px;
    white-space: normal;
    line-height: 30px;
}

.ui-sortable-placeholder {
    visibility: inherit !important;
    background: transparent;
    border: #666 2px dashed;
}
::-webkit-scrollbar {
    width: 9px;
}
::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px #175ae8; 
}

.upload_button {
  display: inline-block;
}
.upload_button input[type=file] {
  display:none;
}
</style>

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
 url: "/demo/client/autosave.php",
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
 url: "/demo/client/autosave.php",
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

  function changeAssigned(val){

    document.getElementById("assigned"+val).innerHTML = '<select class="form-control" id="assign'+val+'" onChange="assignedChanges('+val+')"><option selected disabled>Assign Champion</option><?php getEmployees(); ?></select>';
   }
 

  function assignedChanges(val){
 
       var assigned = document.getElementById("assign"+val).value;
       //   if($assigned==''){
       //  return false;
       // }

         $.ajax({
  type: "POST",
 url: "/demo/client/autosave.php",
  data:{
    assignedChange: "Ziwewe",
    assigned,
    task_id: val

  },
  success: function(data){

    document.getElementById("assigned"+val).innerHTML = data;

  }
  });

   }

     function changeDueDate(val){

    document.getElementById("due_date"+val).innerHTML = '<input type="date" class="form-control" id="due'+val+'" onfocusout="dueDateChanges('+val+')">';
   }
 

  function dueDateChanges(val){
 
       var date = document.getElementById("due"+val).value;
       if($date==''){
        return false;
       }

         $.ajax({
  type: "POST",
 url: "/demo/client/autosave.php",
  data:{
    dueDateChange: "Ziwewe",
    date,
    task_id: val

  },
  success: function(data){

    document.getElementById("due_date"+val).innerHTML = data;

  }
  });
 }

   function changeCompletion(val,val2){

    document.getElementById("completion"+val).innerHTML = '<input type="range" id="range'+val+'" value="'+val2+'" min="'+val2+'" max="100" oninput="disp'+val+'.value = range'+val+'.value" onfocusout="getTaskID('+val+'); updateTaskProgress(this.value); completionChanges('+val+')"><span class="badge"><button><output  id="disp'+val+'">'+val2+'</output>%</button></span>';
   }
 

  function completionChanges(val){
 
       var completion = document.getElementById("range"+val).value;

         $.ajax({
  type: "POST",
 url: "/demo/client/autosave.php",
  data:{
    completionChange: "Ziwewe",
    completion,
    task_id: val

  },
  success: function(data){

    document.getElementById("completion"+val).innerHTML = '<a onclick="changeCompletion('+val+','+data+')"><span class="badge"><button>'+data+'%</button></span></a>';

  }
  });

   }

     function achieveCard(val,val2){
       //alert(val);
       //var employee_id = document.getElementById("range"+val).value;

         $.ajax({
  type: "POST",
 url: "/demo/client/autosave.php",
  data:{
    achieveCard: "Ziwewe",
    project_id: val,
    employee_id: val2

  },
  success: function(data){
    //document.getElementById("sort"+val2).innerHTML = data;
    //alert(data);
    document.getElementById("myProjectModal"+val).innerHTML = '<li class="text-row ui-sortable-handle" data-task-id="'+val+'"><div class="alert alert-success fade show" role="alert"><strong>Project Successfully Achieved</strong><button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload();"><span aria-hidden="true">&times;</span></button></div></li>';
    
  }
  });

   }


     function restoreCard(val,val2){
       //alert(val);
       //var employee_id = document.getElementById("range"+val).value;

         $.ajax({
  type: "POST",
 url: "/demo/client/autosave.php",
  data:{
    restoreCard: "Ziwewe",
    project_id: val,
    employee_id: val2

  },
  success: function(data){
    //document.getElementById("sort"+val2).innerHTML = data;
    //alert(data);
    document.getElementById("myProjectModal"+val).innerHTML = '<li class="text-row ui-sortable-handle" data-task-id="'+val+'"><div class="alert alert-success fade show" role="alert"><strong>Project Successfully restored</strong><button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload();"><span aria-hidden="true">&times;</span></button></div></li>';
    
  }
  });

   }
 
  function getTaskID(val){

document.getElementById('task_id').value = val;
}

 function updateTaskProgress(val) {

        //alert(val);
        var task_id = document.getElementById('task_id').value;
        //alert(taskID);
       // return false;
        
  $.ajax({
  type: "POST",
 url: "/demo/client/autosave.php",
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
 url: "/demo/client/autosave.php",
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
  function deleteTask(val,val2) {
   // alert(val);
     $.ajax({
  type: "POST",
 url: "/demo/client/autosave.php",
  data:{
    deleteTask: "Nyengerai",
    task_id: val,
    project_id: val2

  },
  success: function(data){
    //alert(val2);
    document.getElementById("add_to"+val2).innerHTML = data;
    $('#deleteTask'+val).modal('hide');
  }
  });
  }
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript">
       
  function uploadFile(val){
  
       alert(val);
           //stop submit the form, we will post it manually.
        event.preventDefault();

        // Get form
        var form = $('#fileUploadForm'+val)[0];
    // Create an FormData object 
        var data = new FormData(form);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "process.php",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
            alert(data);
     
                console.log("SUCCESS : ", data);
      
            },
            error: function (e) {

                console.log("ERROR : ", e);

            }
        });
  }

 </script>




 <div class="wrapper wrapper-content  animated fadeInRight">

<div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                <a href="/demo/client/archives" class="btn btn-outline-secondary" style="float: right;">Archives</a>
                
        <!--<input type="file" name="evidence" id="evidence'.$tid.'" onchange="uploadFile('.$tid.')" accept="application/pdf"/>-->
                  
                    </div>
            
                    <div class="ibox-content">


                     <div class="task-board">
            <?php if(isset($_GET['scorecard'])){
                   
                   getCardsFor1($_GET['scorecard']);
                   
                    }else{
                       getCards2();  
                    }
      
            ?>
        </div>
    <script>
 $( function() {
     var url = 'trello/edit-status.php';
     $('ul[id^="sort"]').sortable({
         connectWith: ".sortable",
         receive: function (e, ui) {
             var employee_id = $(ui.item).parent(".sortable").data("status-id");
             var project_id = $(ui.item).data("task-id");
             $.ajax({
                 url: url+'?employee_id='+employee_id+'&project_id='+project_id,
                 success: function(response){
                     }
             });
             }
     
     }).disableSelection();
     } );
  </script>


                 </div>
                </div>
               </div>
             </div>
     
  
         





<?php //include"right_side_bar.php"; ?>
<?php include"footer.php"; ?>


