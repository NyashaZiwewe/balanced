<?php include"functions.php";
require_once "ProjectManagement.php";
//header("refresh: 3"); 
//echo date('H:i:s Y-m-d');  
?>
<html>
<head>
<title>Ipc Trello</title>
<link rel="stylesheet"
    href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/css/bootstrap-modal-bs3patch.css" integrity="sha256-an7lVVGD895TBR8BgUzEUw9dG4+eYrXiGClwunVKGsw=" crossorigin="anonymous" />

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">


    function addCard(val,val2) {
   alert(val+''+val2);
  $.ajax({
  type: "POST",
  url: "addcard.php",
  data:{
    title:val,
    status_id:val2
  },
  success: function(data){
    location.reload();
  // console.log(data);
  // document.getElementById("sort"+val).innerHTML += data;
  }
  });
}
</script>
<script type="text/javascript">
            function showHideDiv(ele) {
                var srcElement = document.getElementById(ele);
                if (srcElement != null) {
                    if (srcElement.style.display == "block") {
                        srcElement.style.display = 'none';
                    }
                    else {
                        srcElement.style.display = 'block';
                    }
                    return false;
                }
            }
        </script>
        <script type="text/javascript">
            <?php for($i=1; $i<5; $i++){ ?>
$(document).ready(function() {
  $("#show-button<?php echo $i; ?>").click(function () {
   $("#hide-button<?php echo $i; ?>").show()
   $("#show-button<?php echo $i; ?>").hide()
  });
  $("#hide-button<?php echo $i; ?>").click(function () {
   $("#show-button<?php echo $i; ?>").show()
   $("#hide-button<?php echo $i; ?>").hide()
  });
 });
<?php } ?>
        </script>
<style>
body {
    font-family: arial;
}
  textarea {
 border:none; 
 font-size: 13px;
 font-weight: bold;

}

.task-board {
    background: #2c7cbc;
    display: inline-block;
    padding: 10px;
    border-radius: 3px;
    width: 98%;
    height: 150%;
    white-space: nowrap;
    min-height: 300px;
    
}

.status-card {
    width: 260px;
    margin-right: 8px;
    background: #e2e4e6;
    border-radius: 3px;
    display: inline-block;
    vertical-align: top;
    font-size: 0.9em;
    max-height: 75%;
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
    border-radius: 3px;
    display: block;
    font-weight: bold;
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
    font-size: 0.9em;
    white-space: normal;
    line-height: 20px;
}

.ui-sortable-placeholder {
    visibility: inherit !important;
    background: transparent;
    border: #666 2px dashed;
}
::-webkit-scrollbar {
    width: 12px;
}
::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px purple; 
}
</style>
</head>
<body>
        <div class="task-board">
            <?php
       getCards();
            ?>
        </div>
    <script>
 $( function() {
     var url = 'edit-status.php';
     $('ul[id^="sort"]').sortable({
         connectWith: ".sortable",
         receive: function (e, ui) {
             var status_id = $(ui.item).parent(".sortable").data("status-id");
             var task_id = $(ui.item).data("task-id");
             $.ajax({
                 url: url+'?status_id='+status_id+'&task_id='+task_id,
                 success: function(response){
                     }
             });
             }
     
     }).disableSelection();
     } );
  </script>
 <!-- Large modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".docs-example-modal-lg">Large modal</button>

<div class="modal fade docs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    hgfjtfjgfjhgjhg
    </div>
  </div>
</div>

</body>
</html>


function getProjectTasks($project_id){
      $conn = dbconnect();

    $stmt1 = $conn->prepare("SELECT id, task,  due_date, last_updated, status, completion FROM project_tasks WHERE project_id=?");
    $stmt1->bind_param('i',$project_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($tid,$task,$due_date, $last_updated, $status,$completion);
    While($stmt1->fetch()){
      if($completion!=100){
       echo' 
          <div><label><span class="badge badge-danger"><i class="fa fa-window-close fa-5em"></i></span>';

              if($due_date < date('Y-m-d')){
              echo  '<span class="m-l-xs check-link" style="font-size: 14px; color: red;" contenteditable>'.$task.' &nbsp; &nbsp;';
            }
              else{
              echo  '<span class="m-l-xs check-link" style="font-size: 14px;" contenteditable>'.$task.' &nbsp; &nbsp;';
              }

              echo'</span><input type="range" id="range'.$tid.'" value="'.$completion.'" min="'.$completion.'" max="100" oninput="disp'.$tid.'.value = range'.$tid.'.value" onmouseleave="getTaskID('.$tid.'); updateTaskProgress(this.value)"><span class="badge"><button><output  id="disp'.$tid.'">'.$completion.'</output>%</button></span><br> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;'; 
              if($due_date==''){  
                echo' <i class="fa fa-calendar"></i>'; 
                } else{ 
                  echo $due_date; 
                } 
              echo '<select><option disabled selected>Assign champion</option>'; getEmployees(); echo'</select>';
           echo' </div><hr>';
      }else{
echo'    
              <div><label> <input type="checkbox" value="" checked="">';
                
            if($due_date < $last_updated){
              echo  '<span class="m-l-xs todo-completed" style="font-size: 12px; color: red;">'.$task.' <b>due:</b> '.$due_date.'</span>';
            }
              else{
              echo  '<span class="m-l-xs todo-completed" style="font-size: 12px; color: green;">'.$task.' <b>due:</b> '.$due_date.'</span>';
              }

       echo'</div>';
    
    }
    echo '<div class="modal fade" id="taskInfo'.$tid.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Add Comments </h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-lg-12">
                  
                    </div>
                  </div>
                  <div class="form-group" align="right">
                  <br/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Done</button>
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>';
 
}
}