<?php include"header.php"; error_reporting(0); ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>

<style>
    .tags {
  display: inline;
  position: relative;
}

.tags:hover:after {
  background: #333;
  background: rgba(0, 0, 0, .5);
  border-radius: 5px;
  bottom: 40px;
  color: #fff;
  content: attr(glose);
  left: -80%;
  padding: 15px 5px;
  position: absolute;
  z-index: 98;
  /*width: 350px;*/
}

.tags:hover:before {
  border: solid;
  border-color: #333 transparent;
  border-width: 0 6px 6px 6px;
  bottom: -4px;
  content: "";
  left: 50%;
  position: absolute;
  z-index: 99;
}
</style>


    <style type="text/css">  
        input[type='radio'] {
    transform: scale(2);
}
 
      input {sav
     border:none;

    }
    input:active {
        border:1px solid #000;
    }
      select {
       border:none;
      

    }
    select:active {
        border:1px solid #000;
    }
    label{color: #175ea8; }

    div.c {
      font-size: 75%;
    }
    
#mySpan{
writing-mode: vertical-lr; 
transform: rotate(180deg);
}


    </style>

    <script type="text/javascript">
      function saverow(val) {
        // alert(val);
        var unit = document.getElementById("unit"+val).value;
        var reporting_frequency = document.getElementById("reporting_frequency"+val).value;
        var target_period = document.getElementById("target_period"+val).value;
        var base_target = document.getElementById("base_target"+val).value;
        var stretch_target = document.getElementById("stretch_target"+val).value;
        var actual = document.getElementById("actual"+val).value;
        var allocated_weight = document.getElementById("allocated_weight"+val).value;
        var scorecard_id= "<?php echo $_GET['scorecard']; ?>";
        // alert(scorecard_id);
         // alert(val+' '+unit+' '+reporting_frequency+' '+target_period+' '+base_target);
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    wholerow: "nyasha",
    measure_id: val,
    unit,
    reporting_frequency,
    target_period,
    base_target,
    stretch_target,
    actual,
    allocated_weight,
    scorecard_id
  },
  success: function(data){
    //alert(data);
    document.getElementById("ov").value = data;
    document.getElementById("ov1").value = data;
  }

  });
  setTimeout(saverow, 2000);
//another action for updating summary
    $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    upper_weights: "nyasha",
    scorecard_id
  },
  success: function(data){
    document.getElementById("upper_weights").innerHTML = data;
  }
});

//another action for updating summary
    $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    updateWeightedRating: "nyasha",
    measure_id: val
  },
  success: function(data){

    document.getElementById("wr"+val).innerHTML = data +"%";
  }
});

}
</script>

<script type="text/javascript">
     function saveMyComments(val,val2,val3) {
          //alert(val);
        var comment = document.getElementById("comment2").value;
         
         // alert(val+' '+unit+' '+reporting_frequency+' '+target_period+' '+base_target);
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
  overalComments: "nyasha",
   comment,
   id:val,
   scorecard_id:val2,
   scope:val3

  },
  success: function(data){
  }
  });
}
</script>

<script type="text/javascript">
     function superComments() {
        // alert("nyasha");
        var id = document.getElementById("supervisor_comment_id").value;
        var scope = document.getElementById("scope3").value;
        var scorecard_id = document.getElementById("scorecard_id3").value;
        var comment = document.getElementById("supervisor_comment").value;
         
//alert(id+comment+scorecard_id+scope);
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
  supervisorComments: "nyasha",
   id,
   comment,
   scorecard_id,
   scope

  },
  success: function(data){
  }
  });
}
</script>

<script type="text/javascript">
 function saveFirstTable(val) {
        // alert(val);
        var position = document.getElementById("position"+val).value;
        var r_period = document.getElementById("r_period"+val).value;
        var start_period = document.getElementById("start"+val).value;
         
        // alert(start_period);
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    firstTable: "nyasha",
    scorecard_id: val,
    position,
    r_period,
    start_period
  },
  success: function(data){
    //   alert(data);
  }
  });
}
</script>

<script type="text/javascript">
 function saveComment(val,val2) {
         // alert(val);
        var comment = document.getElementById("mycomment"+val2).value;
      // var comment = document.getElementById("display"+val2).innerHTML = document.getElementById("mycomment"+val2).value
         
          // alert(val+' '+comment+' '+val2);

  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    addcomment: "nyasha",
    scorecard_id: val,
    measure_id: val2,
    comment
  },
  success: function(data){
 document.getElementById("newcomment"+val2).innerHTML += comment+'<font color="#175ea8"><b> You</b></font><br/><small class="text-muted">Just Now</small>';
 document.getElementById("mycomment"+val2).value='';
        
  }
  });
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
       //alert(val);
      var due_date = document.getElementById("date"+val).value;
     // alert(due_date);
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
  url: "../autosave.php",
  data:{
    addMeasureTask: "nyasha",
    task,
    measure_id: val,
    due_date
  },
  success: function(data){
   
 document.getElementById("add_to"+val).innerHTML = data;
 document.getElementById("task"+val).value ='';
 document.getElementById("date"+val).value ='';

  }
  });
}

 function updateTaskStatus(val,val2) {
   
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    updateMeasureTaskStatus: "nyasha",
    task_id : val,
    status: val2,
  },
  success: function(data){

  }
  });
}

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript">
       
  function uploadFile(val){
  
      // alert(val);
           //stop submit the form, we will post it manually.
        event.preventDefault();

        // Get form
        var form = $('#fileUploadForm'+val)[0];
    // Create an FormData object 
        var data = new FormData(form);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "../process.php",
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
  <script type="text/javascript">
   function changeMonth(val){
     // Trigger the button element with a click
    document.getElementById("myBtn").click();
  }

 </script>


<?php
      if(isset($_POST['savemeasure'])){
         //sumActual($_POST['measure_id']);
        saveMeasure($_POST['measure_id'],$_POST['measure'],$_POST['measure_type'],$_POST['scorecard_id']);
      }

      if(isset($_POST['newmeasure'])){
      
        addMeasure($_POST['goal_id'],$_POST['measure'],$_POST['measure_type'],$_POST['scorecard_id']);
      }
         if(isset($_POST['deletemeasure'])){
        deleteMeasure($_POST['measure_id'],$_POST['scorecard_id']);
      }
     if(isset($_POST['addgoal'])){

        addGoal($_POST['scorecard_id'],$_POST['perspective_id'],$_POST['goal'],$_POST['company_goal']);
      }
   
      if(isset($_POST['savegoal'])){
        saveGoal($_POST['scorecard_id'],$_POST['goal'],$_POST['goal_id']);
      } 
    

?>



<div class="wrapper wrapper-content">


           <div class="row">
           <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title" id="first_table">

                     <?php 
            //           if(getScorecardClientId($_GET['scorecard'])!= $_SESSION['client_id']){ 
            //  echo "<script language=javascript> alert('You are not allowed beyond this area'); window.location='/client/home'; </script>"; 

            //      }
            ?>
              
     <?php if($_GET['scorecard']== ''){ 
                 if($_SESSION['account_type']==1){ ?>
                 <script language=javascript>
                 alert("Your Organisation does not have any active scorecard, Please add");
                 window.location.href = "scorecards.php";
                  </script>"; 
               <?php   }
                  if($_SESSION['account_type']==2){ ?>
                 <script language=javascript>
                 alert("Your Business Unit does not have any active scorecard, Please add");
                 window.location.href = "scorecards.php";
                  </script>"; 
               <?php   }
                  if($_SESSION['account_type']==3){ ?>
                 <script language=javascript>
                 alert("Your department does not have any active scorecard, Please add");
                 window.location.href = "scorecards.php";
                  </script>"; 
               <?php   }
                  if($_SESSION['account_type']==4){ ?>
                 <script language=javascript>
                 alert("You do not have any active scorecard, Please add");
                 window.location.href = "scorecards.php";
                  </script>"; 
               <?php   }
          }
      ?>
        
                        <?php getFirstTable($_GET['scorecard']); ?>
                      
               
                    </div>
                </div>
            </div>
          
      </div>


<div class="row">
   <div class="col-lg-7"></div>
   <div class="col-lg-3">
     <?php if(isset($_POST['month'])){
      $month = $_POST['month'];
      $date = date('F, Y', strtotime($month));
      echo '<font color="#175ea8"><b>'.$date.'</b></font> &nbsp; &nbsp; <a href="../clear_reload.php"><button> Clear <i class="fa fa-filter"></i></button></a>';
     } else{
     echo '<font color="#175ea8"><b>Year to date performance</b></font>';
     }?>

   </div>
   
   <div class="col-lg-2">
    <form action="" method="post">
<input type="month" class="form-control" name="month" style="float: right; width:250px;" max="<?php echo date('Y-m'); ?>" onchange="changeMonth(this.value)" >
<button type="submit" name="change" id="myBtn" hidden>nyasha</button>
</form>
</div>
</div>
<br>



<div class="row">
         <div class="col-lg-12">
                <div class="ibox ">
          
           <div class="ibox-content c" id="nestedTable">

                <?php 
               
        if(getScorecardsSettings()==1){

                        if(getScoreCardLevel($_GET['scorecard'])==1 AND $_SESSION['account_type']==1){
                                    if(isset($_POST['month'])){
                                     require_once("filtered_table.php"); 
                                    }else{
                                    getlockedTable();
                                    }
                             }
                          elseif(getMyScoreCard() == $_GET['scorecard']){
                                    if(isset($_POST['month'])){
                                   require_once("filtered_table.php"); 
                                    }else{
                                    getNestedTable();
                                    }
                             }
                          elseif(getScoreCardLevel($_GET['scorecard'])==2 AND $_SESSION['account_type']==2){
                                    if(isset($_POST['month'])){
                                   require_once("filtered_table.php"); 
                                    }else{
                                    getlockedTable();
                                    }
                            }
                      
                          elseif(getScoreCardLevel($_GET['scorecard'])==3 AND $_SESSION['account_type']==3){
                                    if(isset($_POST['month'])){
                                   require_once("filtered_table.php"); 
                                    }else{
                                    getLockedTable();
                                    }
                           }
                          elseif(getScoreCardLevel($_GET['scorecard'])==4 AND $_SESSION['account_type']==4){
                                    if(isset($_POST['month'])){
                                   require_once("filtered_table.php"); 
                                    }else{
                                    getLockedTable();
                                    }
                           }
                           else{
              
                                 if(isset($_POST['month'])){
                                   require_once("filtered_table.php"); 
                                    }else{
                                    getReadOnlyNestedTable();
                                    }

                           }

        }
         else{
                          if(getScoreCardLevel($_GET['scorecard'])==1 AND $_SESSION['account_type']==1){
                       // echo getScoreCardLevel($_GET['scorecard']);
                                  if(isset($_POST['month'])){
                                   require_once("filtered_table.php"); 
                                    }else{
                                    getNestedTable();
                                    }
                             }
                          elseif(getMyScoreCard() == $_GET['scorecard']){
                                     if(isset($_POST['month'])){
                                   require_once("filtered_table.php"); 
                                    }else{
                                    getNestedTable();
                                    }
                             }
                          elseif(getScoreCardLevel($_GET['scorecard'])==2 AND $_SESSION['account_type']==2){
                                     if(isset($_POST['month'])){
                                   require_once("filtered_table.php"); 
                                    }else{
                                    getNestedTable();
                                    }
                            }
                      
                          elseif(getScoreCardLevel($_GET['scorecard'])==3 AND $_SESSION['account_type']==3){
                                    if(isset($_POST['month'])){
                                   require_once("filtered_table.php"); 
                                    }else{
                                    getNestedTable();
                                    }
                           }
                          elseif(getScoreCardLevel($_GET['scorecard'])==4 AND $_SESSION['account_type']==4){
                                    if(isset($_POST['month'])){
                                   require_once("filtered_table.php"); 
                                    }else{
                                    getNestedTable();
                                    }
                           }
                           else{
              
                               if(isset($_POST['month'])){
                                    
                                   require_once("filtered_table.php"); 
                                    }else{
                                    getReadOnlyNestedTable();
                                    }

                           }

       }

               ?>

                    </div>

               </div>

        </div>
    </div>


 <div class="row">
         <div class="col-lg-12">
                <div class="ibox ">
          
           <div class="ibox-content" id="thirdTable">
       <?php  getThirdTable(); ?>

                    </div>

               </div>

        </div>
    </div>


         <div class="row">
                 <div class="col-lg-6">
                        <div class="ibox ">  
                           <div class="ibox-title">
                        <h5 style="color: #175ea8">Owner's comments</h5>
                    </div>
                          <div class="ibox-content">
                <?php  getOwnerComments(); ?>

                            </div>

                       </div>
                </div>

                  <div class="col-lg-6">
                <div class="ibox ">  
                   <div class="ibox-title">
                        <h5 style="color: #175ea8">Supervisor's comments.</h5>
                    </div>
                  <div class="ibox-content">
        
                    <?php getSupervisorComments(); ?> 
                    </div>

               </div>
              </div>
        </div>
</form>
</div>
















<?php include"footer.php"; ?>