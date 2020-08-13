<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>


        <div class="wrapper wrapper-content">
        <div class="row">

<?php include"mail_side_bar.php"; ?>

            <div class="col-lg-9 animated fadeInRight" style="height: 600px; overflow: auto;">
            <div class="mail-box-header">

                <h2>
                  Drafts
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">
                    <button class="btn btn-white btn-sm" onclick="location.reload();"><i class="fa fa-refresh"></i> Refresh</button>

                </div>
            </div>
                <div class="mail-box">

                <table class="table table-hover table-mail">
                <tbody>
                    <?php getDrafts(); ?>
        
                </tbody>
                </table>


                </div>
            </div>
        </div>
        </div>
   
   <?php include"footer.php"; ?>