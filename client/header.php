<?php

session_start();

  //check for the session variable
    if(!isset($_SESSION['client_id'])){
        header("Location: /leave/signin.php"); 
    } 
    include ("functions.php");
?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>IPC | iPerform</title>


    <link href="/leave/client/css/bootstrap.min.css" rel="stylesheet">
    <link href="/leave/client/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="/leave/client/css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="/leave/client/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="/leave/client/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <link href="/leave/client/css/animate.css" rel="stylesheet">
    <link href="/leave/client/css/style.css" rel="stylesheet">
    
    <link href="/leave/client/css/plugins/iCheck/custom.css" rel="stylesheet">

    <link href="/leave/client/css/plugins/summernote/summernote-bs4.css" rel="stylesheet">

    <link href="/leave/client/css/plugins/select2/select2.min.css" rel="stylesheet">

    <!-- Ladda style -->
    <link href="/leave/client/css/plugins/ladda/ladda-themeless.min.css" rel="stylesheet">

    <link href="/leave/client/css/plugins/dualListbox/bootstrap-duallistbox.min.css" rel="stylesheet">

       <!-- canvas charts for radial-gauges -->
    <script src="gauge/gauge.min.js"></script>

       <!-- Sweet Alert -->
    <link href="/leave/client/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">

    <!--Switchery -->
    <link href="/leave/client/css/plugins/switchery/switchery.css" rel="stylesheet">

    <!-- calendar -->
    <link href="/leave/client/css/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
    <link href="/leave/client/css/plugins/fullcalendar/fullcalendar.print.css" rel='stylesheet' media='print'>

     <!-- Clock picker -->
    <link href="/leave/client/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
    
     
</head>
<script type="text/javascript">
  function updateTextInput(val, val2) {
          document.getElementById('textInput'+val).value=val2; 
        }
</script>
 <script>
    document.addEventListener('DOMContentLoaded', function() {

      var textUniqueVals = new Choices('#choices-text-unique-values', {
        paste: false,
        duplicateItemsAllowed: false,
        editItems: true,
      });
    });
  </script>
<script>
function getState(val) {
  $.ajax({
  type: "POST",
  url: "get_state.php",
  data:'goal_level='+val,
  success: function(data){
    $("#state-list1").html(data);
    $("#state-list2").html(data);
    $("#state-list3").html(data);
    $("#state-list4").html(data);
  }
  });
} 
function selectCountry(val) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
}

/*function trackStListid(id){
  document.getElementById("st-list-id").value = id;
}




function getReportingFrequency(val) {
  $.ajax({
  type: "POST",
  url: "reporting_frequency.php",
  data:'rf='+val,
  success: function(data){
   // alert(data);

    $("#st-list").html(data);
  }
  });
}

function getReportingFrequency1(val) {
  $.ajax({
  type: "POST",
  url: "reporting_frequency.php",
  data:'rf='+val,
  success: function(data){
    //alert(data);
    id = document.getElementById("st-list-id").value;
    $("#11"+id).html(data);

    // document.getElementById("st-list181").innerHTML = data;
  }
  });
} */
function autosave(val,val2) {
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    measure_id:val2,
    rf:val
  },
  success: function(data){
  }
  });
}
function autosaveWeeklyAmount(val,val2,val3) {
  //alert(val+' '+val2);
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    measure_id:val2,
    amount:val,
    week_id:val3
  },
  success: function(data){
  }
  });
}
function autosaveWeek(val,val2,val3) {
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    measure_id:val2,
    week:val,
    week_id:val3
  },
  success: function(data){
  }
  });
}
function autosaveMonthlyAmount(val,val2,val3) {
  // alert(val+' '+val2+' '+val3);
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    measure_id:val2,
    mamount:val,
    month_id:val3
  },
  success: function(data){
     // alert(data);
  }
  });
}
function autosaveMonth(val,val2,val3) {
    
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    measure_id:val2,
    month:val,
    month_id:val3
  },
  success: function(data){
  }
  });
}
function autosaveQuarterlyAmount(val,val2,val3) {
  //alert(val+' '+val2);
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    measure_id:val2,
    qamount:val,
    quarter_id:val3
  },
  success: function(data){
  }
  });
}
function autosaveQuarter(val,val2,val3) {
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    measure_id:val2,
    quarter:val,
    quarter_id:val3
  },
  success: function(data){
  }
  });
}
function autosaveHalflyAmount(val,val2,val3) {
 // alert(val+' '+val2);
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    measure_id:val2,
    hamount:val,
    half_id:val3
  },
  success: function(data){
  }
  });
}
function autosaveHalf(val,val2,val3) {
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    measure_id:val2,
    half:val,
    half_id:val3
  },
  success: function(data){
  }
  });
}
function deleteWeek(val,val2) {
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    deleteWeek:val,
    measure_id:val2,
  },
  success: function(data){
document.location.reload(true);
  }
  });
  /*$.get("actualAchievement.php", function(data, status){
    alert("Data: " + data + "\nStatus: " + status);

    setTimeout(function(){ alert("Hello"); }, 3000);
    document.getElementById(3380).innerHTML = data;
    document.getElementById(3380).innerHTML += '';
  }); */
}
function deleteMonth(val,val2) {
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    deleteMonth:val,
    measure_id:val2,
  },
  success: function(data){
document.location.reload(true);
  }
  });
}
function deleteQuarter(val,val2) {
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    deleteQuarter:val,
    measure_id:val2,
  },
  success: function(data){
document.location.reload(true);
  }
  });
}
function deleteHalf(val,val2) {
  $.ajax({
  type: "POST",
  url: "../autosave.php",
  data:{
    deleteHalf:val,
    measure_id:val2,
  },
  success: function(data){
document.location.reload(true);
  }
  });
}
   $(function() {
            $( "#date" ).datepicker({dateFormat: 'yy'});
         });

</script>

<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

      .center { 
            position: absolute; 
            top: 0; 
            bottom: 0; 
            left: 0; 
            right: 0; 
            margin: auto; 
        }

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

  <!-- <div class="loader center"></div> -->

<!-- <script type="text/javascript">
  document.onreadystatechange = function() { 
    if (document.readyState !== "complete") { 
        document.querySelector("body").style.visibility = "hidden"; 
        document.querySelector("#loader").style.visibility = "visible"; 
    } else { 
        document.querySelector("#loader").style.display = "none"; 
        document.querySelector("body").style.visibility = "visible"; 
    } 
}; 
</script> -->

</head>

