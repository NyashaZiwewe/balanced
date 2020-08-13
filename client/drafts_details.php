<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>

        <div class="wrapper wrapper-content">
        <div class="row">

<?php include"mail_side_bar.php"; ?>

            <div class="col-lg-9 animated fadeInRight" style="height: 600px; overflow: auto;">
         <?php echo getEmailDetails($_GET['m']); ?>
            </div>
        </div>
        </div>
      <?php include"footer.php"; ?>