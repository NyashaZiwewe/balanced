<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>

<script type="text/javascript">
  function addPriority() {
        var goal = document.getElementById("goal").value;
        var client_id = document.getElementById("client_id").value;
        var points = document.getElementById("points").value;
        var description = document.getElementById("description").value;

       // alert(description);
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    addPriority: "nyasha",
    goal,
    client_id,
    points,
    description
  },
  success: function(data){
   // alert(data);
    document.getElementById("priority").innerHTML = data;
  }
  });
  }
</script>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Strategy Guide
                  <?php if($_SESSION['account_type']!=4){ ?>
                     <a class="btn btn-primary btn-sm" style="float: right;" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i>Add New</a>
                   <?php } ?>
                   
                    <a href="nyasha.php?sid=38" class="btn btn-primary btn-sm" style="float: right;"><i class="fa fa-plus"></i>Strategy MAp</a>
                   </h2>
                </div>
            </div>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row" id="priority">
          <?php getPriorityGoals(); ?>         
     
            </div>
            </div>


          <div class="modal inmodal fade" id="addModal" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Add A Strategy Goal</h4>
                                        </div>
                                        <form onsubmit="addPriority()">
                                        <div class="modal-body">
                                        <input type="hidden" name="client_id" id="client_id" value="<?php echo $_SESSION['client_id']; ?>">
                                      <label>Goal</label>
                                      <input type="text" id="goal" class="form-control" placeholder="Type Goal" required minlength="3">
                                      <label>Points</label>
                                      <input type="number" min="1" max="100" id="points" class="form-control" placeholder="Priority points" required>
                                      <label>Description</label>
                                      <textarea class="form form-control" id="description" placeholder="Description" required></textarea>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-outline-primary">Done</button>
                                        </div>
                                      </form>
                                    </div>
                                </div>
                            </div>
<?php include"footer.php"; ?>
