<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; error_reporting(0); ?>
<?php //include"trello/functions.php";
require_once "trello/ProjectManagement.php"; ?>

<script type="text/javascript">

    function addCard(val) {
   alert(val);
       var textarea = document.getElementById('textarea'+val).value;

  $.ajax({
  type: "POST",
  url: "/client/autosave.php",
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
</style>
<script type="text/javascript">


     function restoreCard(val,val2){
     

         $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    restoreCard: "Ziwewe",
    project_id: val,
    employee_id: val2

  },
  success: function(data){
    location.reload();
   $("#restoreCard"+val).modal('hide');
    $("#myProjectModal"+val).modal('hide');
    window.location
   //document.getElementById("myProjectModal"+val).innerHTML = '<li class="text-row ui-sortable-handle" data-task-id="'+val+'"><div class="alert alert-success fade show" role="alert"><strong>Project Successfully restored</strong><button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload();"><span aria-hidden="true">&times;</span></button></div></li>';
    
  }
  });

   }
 </script>



 <div class="wrapper wrapper-content  animated fadeInRight">

<div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
           
                     <a href="actionplans" class="btn btn-outline-secondary" style="float: right;">Action Plans</a>
                    </div>
            
                    <div class="ibox-content">


                     <div class="task-board">
            <?php
      getArchievedCards();
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


