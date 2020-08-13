<?php include"header.php"; ?>

<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>

<div class="wrapper wrapper-content">


           <div class="row">
           <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <p align="center"><b>Notification Area</b></p>
               
                    </div>
                </div>
            </div>
          
      </div>

      <div class="row">
         <div class="col-lg-12">
                <div class="ibox ">
          
           <div class="ibox-content">

                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                   <?php getMyNotifications(); changeMessageStatus(1,0); ?>
                 
                
                    </tbody>
                    <tfoot>
                    <tr>
                       <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    </table>
                        </div>

                    </div>

               </div>

        </div>
    </div>
</div>



<?php include"right_side_bar.php"; ?>
<?php include"footer.php"; ?>