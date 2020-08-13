<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>

<script type="text/javascript">
  function addPerspective() {
        var perspective_id = document.getElementById("perspective_id").value;
        var client_id = "<?php echo $_SESSION['client_id']; ?>";

        ///alert(name +' '+head+' '+client_id);
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    addPerspective: "Ziwewe",
    client_id,
    perspective_id
  },
  success: function(data){
   // alert(data);
    document.getElementById("notes").innerHTML = data;
  }
  });
  }
</script>



        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Perspectives</h5>
                        <div class="ibox-tools">
                          <?php if($_SESSION['account_type']!=4){ ?>
                        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i>Add New</a>
                         <?php } ?>
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#" class="dropdown-item">Config option 1</a>
                                </li>
                                <li><a href="#" class="dropdown-item">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                 
                <div class="wrapper wrapper-content animated fadeInUp">
                <div class="row">
                 <div class="col-lg-12">
                    <ul class="notes" id="notes">
                      <?php getCompanyPerspectives(); ?>
                    </ul>
                  </div>
                </div>


                </div>
            </div>
            </div>
        </div>

         <div class="modal inmodal fade" id="addModal" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Add new Perspective</h4>
                                        </div>
                                        <div class="modal-body">
                                        <select class="form-control" id="perspective_id">
                                          <option value="" selected disabled>Select perspective</option>
                                    <?php  getPerpectiveOptions(); ?>
                                         </select>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class=" update_table btn btn-outline-primary" onclick="addPerspective()" data-dismiss="modal">Done</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
   



<?php include"footer.php"; ?>


<script type="text/javascript">


</script>


