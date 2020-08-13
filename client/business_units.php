<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>

<script type="text/javascript">
  function saveBusinessUnit(val) {
        var name = document.getElementById("name"+val).value;
        var head = document.getElementById("head"+val).value;

        if(name=''){
            document.getElementById("name_error").innerHTML = 'Please add the event name';
        }else if(head=''){
            document.getElementById("head_error").innerHTML = 'Please add the event Head of BU';
        }
else{
       // alert(val +' '+ name +' '+head);
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    saveBU: "nyasha",
    id: val,
    name,
    head
  },
  success: function(data){
   // alert(data);
    document.getElementById("table_business_units").innerHTML = data;
  }
  });
  }
}
</script>
<script type="text/javascript">
  function addBusinessUnit() {
        var name = document.getElementById("name").value;
        var head = document.getElementById("head").value;
        var client_id = document.getElementById("client_id").value;

        //alert(name +' '+head+' '+client_id);
//       if(name=''){
//             document.getElementById("name_error").innerHTML = 'Please add the event name';
//         }else if(head=''){
//             document.getElementById("head_error").innerHTML = 'Please add the event Head of BU';
//         }
// else{
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    addBU: "Ziwewe",
    client_id,
    name,
    head
  },
  success: function(data){
   // alert(data);
   $('#addModal').modal('hide');
    document.getElementById("table_business_units").innerHTML = data;
  }
  });
  }
// }
</script>

<?php
      if(isset($_POST['delete'])){
        deleteBusinessUnit($_POST['business_unit_id']);
      }
?>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Business Units</h5>
                        <div class="ibox-tools">
                        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i>Add New</a>
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
                    <div class="ibox-content">

                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                    <tr>
                          <th>Name</th>
                          <th>Head</th>
                          <th>Action</th>
                        </tr>
                    </tr>
                    </thead>
                    <tbody id="table_business_units">
                    <?php    getBusinessUnits(); ?>
                    </tbody>
                    <tfoot>
                    <tr>
                          <th>Name</th>
                          <th>Head</th>
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

         <div class="modal inmodal fade" id="addModal" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Add new Business Unit</h4>
                                        </div>
                                        <form  onsubmit="addBusinessUnit()">
                                        <div class="modal-body">

                                        <input type="hidden" name="client_id" id="client_id" value="<?php echo $_SESSION['client_id']; ?>">
                                       
                                        <label>Business Unit Name</label>
                                        <input type="text" id="name" class="form-control" required minlength="3">
                                   

                                        <label>Head of Business Unit</label>
                                        <select class="form-control" id="head" required>
                                          <option value="" selected disabled>Select Head {from those who match the level}</option>
                                    <?php   getEmployeesOfCertainLevel(2); ?>
                                         </select>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class=" update_table btn btn-outline-primary">Done</button>
                                        </div>
                                      </form>
                                    </div>
                                </div>
                            </div>
   



<?php include"footer.php"; ?>



