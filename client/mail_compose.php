<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>
    <script>
      $('#message').summernote({
  height: 300,                 // set editor height
  minHeight: null,             // set minimum height of editor
  maxHeight: null,             // set maximum height of editor
  focus: true                  // set focus to editable area after initializing summernote
});
    </script>

<script type="text/javascript">
     function sendMail() {

        var recepient = document.getElementById("recepient").value;
        var subject = document.getElementById("subject").value;
        var reply_to = document.getElementById("reply_to").value;
        var forward = document.getElementById("forward").value;
        var message = $('#message').summernote('code');
        var sender ="<?php echo $_SESSION['email']; ?>";
  //alert(forward+' '+reply_to);
 
  $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
  sendMail: "nyasha",
  recepient,
  forward,
  reply_to,
  subject,
  message,
  sender
  },
  success: function(data){
    $('#message').summernote('code', 'Message Sent');
   }
  });
 
}
</script>

<script type="text/javascript">
     function saveDraft() {

        var recepient = document.getElementById("recepient").value;
        var subject = document.getElementById("subject").value;
        var reply_to = document.getElementById("reply_to").value;
        var forward = document.getElementById("forward").value;
        var message = $('#message').summernote('code');
        var sender ="<?php echo $_SESSION['email']; ?>";
 // alert(sender);
 
  $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
  saveDraft: "nyasha",
  recepient,
  forward,
  reply_to,
  subject,
  message,
  sender
  },
  success: function(data){
    $('#message').summernote('code', 'Draft Saved');
   }
  });
 
}
</script>

        <div class="wrapper wrapper-content">
        <div class="row">

<?php include"mail_side_bar.php"; ?>

            <div class="col-lg-9 animated fadeInRight" style="height: 600px; overflow: auto;">
            <div class="mail-box-header">
                <div class="float-right tooltip-demo">
                    <button onClick="saveDraft()" class="ladda-button btn-white btn-sm"  data-style="expand-right"><i class="fa fa-pencil"></i> Draft</button>
                    <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Discard email"><i class="fa fa-times"></i> Discard</button>
                </div>
                <h2>
                  <?php if(isset($_GET['f'])){
                    echo 'Forward Email';
                  } 
                  elseif(isset($_GET['r'])){
                    echo 'Reply Email';
                  }else{
                    echo'  Compose mail';
                  } ?>                  
                </h2>
            </div>
                <div class="mail-box">


                <div class="mail-body">

                    <form method="get">
                        <div class="form-group row"><label class="col-sm-2 col-form-label">To:</label>
                          <div class="col-sm-10">
                         <?php if(isset($_GET['r'])){
                      echo'<input type="email" id="recepient" class="form-control" value="'.$_GET['e'].'">';
                      echo'<input type="hidden" id="reply_to" value="'.$_GET['r'].'">';
                         } else{
                      echo'<input type="email" id="recepient" class="form-control" placeholder="eg. nyasha@ipcconsultants.com">';
                      echo'<input type="hidden" id="reply_to" value="0">';
                         }
                        if(isset($_GET['f'])){
                      echo'<input type="hidden" id="forward" class="form-control" value="1">';
                        }else{
                      echo'<input type="hidden" id="forward" class="form-control" value="0">';    
                        }
                          ?>
                         </div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Subject:</label>
                            <div class="col-sm-10">
                        <?php if(isset($_GET['f'])){
                        echo'<input type="text" id="subject" class="form-control" value="'.getSubjectToFoward($_GET['f']).'">';
                             }
                             elseif(isset($_GET['r'])){
                        echo'<input type="text" id="subject" class="form-control" value="'.getSubjectToFoward($_GET['r']).'">';
                             }

                             else{
                         echo'<input type="text" id="subject" class="form-control" placeholder="enter your subject">';
                             } ?>

                          </div>
                        </div>
                        </form>

                </div>

                    <div class="mail-text h-200">
                        <div class="summernote" id="message">
                          <?php if(isset($_GET['f'])){
                          echo getEmailToFoward($_GET['f']);
                        }
                            ?>                   
                        </div>
<div class="clearfix"></div>
                        </div>
                    <div class="mail-body text-right tooltip-demo" id="button">
                        <button onclick="sendMail()" class="ladda-button btn-sm btn-success" data-style="contract"><i class="fa fa-send" ></i>Send</button>
                        <button class="btn btn-warning btn-sm"><i class="fa fa-times"></i> Discard</button>
                        <button onClick="saveDraft()" class="ladda-button btn-primary btn-sm"  data-style="expand-right"><i class="fa fa-pencil"></i> Draft</button>
                    </div>
                    <div class="clearfix"></div>



                </div>
            </div>
    </div>
</div>

 <?php include"footer.php"; ?>