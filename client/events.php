<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>
<script type="text/javascript">
  function addEvent() {

        var client_id = document.getElementById("client_id").value;
        var event = document.getElementById("event").value;
        var description = document.getElementById("description").value;                   
        var start_date = document.getElementById("start_date").value; 
        var start_time = document.getElementById("start_time").value;             
        var end_date = document.getElementById("end_date").value;
        var end_time = document.getElementById("end_time").value;  
        var level_id = document.getElementById("level_id").value;

        if(event==''){
        document.getElementById("event_error").innerHTML = 'Please add the event name';
        }
          else if(description==''){

        document.getElementById("description_error").innerHTML = 'Please add the event description';
        }
          else if(start_date==''){

        document.getElementById("start_date_error").innerHTML = 'Please add the start date';
        }
           else if(start_time==''){

        document.getElementById("start_time_error").innerHTML = 'Please add the start_date \'s time';
        }
         else if(end_date==''){

        document.getElementById("end_date_error").innerHTML = 'Please add the end date';
        }
           else if(end_time==''){

        document.getElementById("end_time_error").innerHTML = 'Please add the end_date \'s time';
        }
              else if(level_id==''){

        document.getElementById("level_id_error").innerHTML = 'Please add the level of access';
        }
      

         else{

        ///alert(name +' '+head+' '+client_id);
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    addEvent: "Ziwewe",
    client_id,
    event,
    description,
    start_date,
    end_date,
    level_id,
    start_time,
    end_time
  },
  success: function(data){
// location.reload();
$('#myModal').modal('show')     

  }
  });
  }
}
</script>
<style type="text/css">
  label{
    color: #175ea8;
  }
</style>

<?php if(isset($_GET['add'])) { ?>

    <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
              <div class="col-lg-3"></div>
                <div class="col-lg-6">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Add events</h5>
                        <div class="ibox-tools">
                          <a class="btn btn-primary btn-sm" href="events.php"><i class="fa fa-plus"></i>Back to Events</a>
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

 
                                        <input type="hidden" name="client_id" id="client_id" value="<?php echo $_SESSION['client_id']; ?>">
                                        <label>Event</label>
                                        <input type="text" id="event" class="form-control">
                                        <p id="event_error" style="color: red;"></p>
                                        <label>Description</label>
                                        <textarea class="form-control" id="description" placeholder="Enter description"></textarea>
                                         <p id="description_error" style="color: red;"></p>
                                       
                                        <label>Start date and Time</label>
                                        <div class="row">                               
                                      <div class="col-lg-6">
                            
                                           <input type="date" min="<?php echo date('Y-m-d'); ?>" class="form-control" id="start_date" placeholder="Enter Start Date">
                                            <p id="start_date_error" style="color: red;"></p>
                                      </div>
                                        <div class="col-lg-6">

                                           <div class="input-group clockpicker" data-autoclose="true">
                                        <input type="text" id="start_time" class="form-control" value="" >
                                        <span class="input-group-addon">
                                               <span class="fa fa-clock-o"></span>
                                          </span>
                                         </div>
                                          <p id="start_time_error" style="color: red;"></p>
                                       </div>
                                   </div>

                                   <label>End date and Time</label>
                                        <div class="row">                               
                                      <div class="col-lg-6">
                            
                                           <input type="date" min="<?php echo date('Y-m-d'); ?>" class="form-control" id="end_date" placeholder="Enter End Date">
                                            <p id="end_date_error" style="color: red;"></p>
                                      </div>
                                        <div class="col-lg-6">

                                           <div class="input-group clockpicker" data-autoclose="true">
                                        <input type="text" class="form-control" id="end_time" value=" " >
                                        <span class="input-group-addon">
                                               <span class="fa fa-clock-o"></span>
                                          </span>
                                         </div>
                                          <p id="end_time_error" style="color: red;"></p>
                                       </div>
                                   </div>


                                         <label>Access Level</label>
                                         <select class="form-control" id="level_id">
                                           <option selected disabled value="">Select Minimum Level of Correspondences</option> 
                                           <?php listAccountTypes(); ?> 
                                         </select>
                                          <p id="level_id_error" style="color: red;"></p>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class=" btn btn-outline-primary" onclick="addEvent()">Save New Booking</button>
                
</div>
</div>
</div>
     <div class="col-lg-3"></div>
</div>
</div>
<?php } else {?>


  <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>All events</h5>
                        <div class="ibox-tools">
                          <a class="btn btn-primary btn-sm" href="events.php?add=true"><i class="fa fa-plus"></i>Add New Event</a>
                          <a class="btn btn-primary btn-sm" href="calendar2.php"><i class="fa fa-calendar"></i>View in Calendar</a>
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
                          <th>Event</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>description</th>
                          <th>Minimum Level</th>
                          <th>Action</th>
                        </tr>
                    </tr>
                    </thead>
                    <tbody>
                    <?php    getEvents(); ?>
                    </tbody>
                    <tfoot>
                    <tr>
                             <th>Event</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>description</th>
                          <th>Minimum Level</th>
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

<?php }?>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><font color="green">Event Successfully Added</font></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button"  onClick="location.reload();" class="btn btn-success" data-dismiss="modal"><i class="fa fa-check-square"></i>Ok</button>
      </div>

    </div>
  </div>
</div>

<?php include"footer.php"; ?>

                                <script>
        $(document).ready(function(){

            $('.clockpicker').clockpicker();

        });
    </script>