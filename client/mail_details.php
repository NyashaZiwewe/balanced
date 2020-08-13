<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>
<script type="text/javascript">
	function changeMailStatus(){
		var mail_id ="<?php echo $_GET['m']; ?>";

		 $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    changeMailStatus: "nyasha",
    mail_id

  },
  success: function(data){

  }
  });
	}

   window.onload = changeMailStatus;
</script>
        <div class="wrapper wrapper-content">
        <div class="row">

<?php include"mail_side_bar.php"; ?>

            <div class="col-lg-9 animated fadeInRight" style="height: 600px; overflow: auto;">
         <?php echo getEmailDetails($_GET['m']); ?>
            </div>
        </div>
        </div>
      <?php include"footer.php"; ?>