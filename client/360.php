<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>
<style type="text/css">
    .radio-toolbar label:hover {
  background-color: #dfd;
}

.radio-toolbar {
  margin: 10px;
}

.radio-toolbar input[type="radio"] {
  opacity: 0;
  position: fixed;
  width: 0;
}

.radio-toolbar label {
    display: inline-block;
    background-color: #fff;
    padding: 8px 15px;
    font-family: sans-serif, Arial;
    font-size: 12px;
    border: 1px solid #444;
    border-radius: 15px;
}

.radio-toolbar label:hover {
  background-color: #dfd;
}

.radio-toolbar input[type="radio"]:focus + label {
    border: 1px dashed #444;
}

.radio-toolbar input[type="radio"]:checked + label {
    background-color: #b3b6b9;
    border-color: #4c4;
    border: 3px solid #175ea8;
}
</style>

        <link rel="stylesheet" href="steps/demo/css/jquery.steps.css">
        <script src="steps/lib/jquery-1.9.1.min.js"></script>
        <script src="steps/build/jquery.steps.js"></script>

        <script type="text/javascript">
  function saveResponse(val, val2) {   
       //alert(val +' '+ val2);
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    saveResponse: "nyasha",
    response_id: val2,
    value: val,

  },
  success: function(data){
   // alert(data);
    document.getElementById("questions").innerHTML = data;
  }
  });
  }
</script>
<script type="text/javascript">
  function addResponse(val,val2) {
        // var question = document.getElementById("question").value;
        // var step_id = document.getElementById("step_id").value;
        //alert(val+' '+val2);
        var client_id="<?php echo $_SESSION['client_id']; ?>";
        var user_id= "<?php echo $_SESSION['user_id']; ?>";

     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    addResponse: "Ziwewe",
     user_id,
     client_id,
     question_id: val2,
     value: val

  },
  success: function(data){
   // alert(data);
   //$(".modal-body input").val("");
    document.getElementById("questions").innerHTML = data;
  }
  });
  }
</script>

        <div class="content">
            <h1></h1>

            <script>
                $(function ()
                {
                    $("#wizard").steps({
                        headerTag: "h6",
                        bodyTag: "section",
                        transitionEffect: "slideLeft",
                        stepsOrientation: "vertical"
                    });
                });
            </script>

            <div id="wizard">
         <?php get360StepTabs(); ?>
            </div>
        </div>

  

<?php //include"footer.php"; ?>
 
    <script src="js/popper.min.js"></script>

    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>










