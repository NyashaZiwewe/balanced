<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>

<script type="text/javascript">
  function saveQuestion(val) {
    
        var question = document.getElementById("question"+val).value;
        var step_id = document.getElementById("step_id"+val).value;
    
       // alert(val +' '+ question +' '+step_id);
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    saveQuestion: "nyasha",
    step_id,
    question_id: val,
    question

  },
  success: function(data){
   // alert(data);
    document.getElementById("questions").innerHTML = data;
  }
  });
  }

   function updatePolicy(val) {   
   //alert(val);
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    updatePolicy: "nyasha",
    mandatory: val
  },
  success: function(data){
  }
  });
  }
</script>
<script type="text/javascript">
  function addQuestion() {
        var question = document.getElementById("question").value;
        var step_id = document.getElementById("step_id").value;
       // alert(question+' '+step_id);
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    addQuestion: "Ziwewe",
     step_id,
    question

  },
  success: function(data){
   // alert(data);
   $(".modal-body input").val("");
    document.getElementById("questions").innerHTML = data;
  }
  });
  }
</script>
<script type="text/javascript">
  function deleteQuestion(val) {
    alert(val);
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    deleteQuestion: "Nyengerai",
    question_id: val

  },
  success: function(data){
   // alert(data);
    document.getElementById("questions").innerHTML = data;
  }
  });
  }
</script>


        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Strategy Evaluation Questions</h5>
                        <div class="ibox-tools">
                        <b>Make It Mandatory to answer</b>
                         <?php getClient360Policy(); ?>
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
                          <th>Strategy Step</th>
                          <th>Question</th>
                          <th>Action</th>
                        </tr>
                    </tr>
                    </thead>
                    <tbody id="questions">
                    <?php    get360Questions(); ?>
                    </tbody>
                    <tfoot>
                    <tr>
                         <th>Strategy Step</th>
                          <th>Question</th>
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
                                            <h4 class="modal-title">Add new question</h4>
                                        </div>
                                        <div class="modal-body">
                         <form id="myForm">           
                  <div class="row about-extra">
                 
                 
                      <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
                       <div class="form-group form-float">
                          <div class="form-line">   
                      <label style="color: #175ea8">Question</label>                             
                        <input type="text" id="question" placeholder="Add question here..." class="form-control">
                         </div>
                       </div>
                       </div>
                       </div>
                    <div class="row about-extra">
                   <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group form-float">
                          <div class="form-line">
                            <label style="color: #175ea8">Stage</label>
                              <select id="step_id" class="form-control" >
                                 <?php    list360Steps(); ?>
                              </select>
                          </div>
                      </div>
                    </div>

                    </div></form>
                  </div>
                                         <div class="modal-footer">
                                            <button type="reset" class="btn btn-outline-primary" onclick="addQuestion()" data-dismiss="modal">Done</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

<?php include"footer.php"; ?>

 <script>
        $(document).ready(function(){
            var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, { color: '#1AB394' });
        });
  

   </script>


