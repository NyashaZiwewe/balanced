

<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>
 
  <link rel="stylesheet" type="text/css" href="domarrow/domarrow.css" />
  <script type="text/javascript" src="domarrow/domarrow.js"></script>
  <style>
    #d1, #d2 {
      position: absolute;
      width: 50px;
      height: 50px;
    }
  #d1 {
      top: 100px;
      left: 560px;
      background-color: green;
    }
   #d2 {
      top: 200px;
      left: 500px;
      background-color: blue;
    }
  </style>
     

                          <div id="d1" >zzzz</div>
                          <div id="d2" >zlatan</div>
                          <connection from="#d2" to="#d1" color="red" tail></connection> 
