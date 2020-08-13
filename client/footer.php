 <script>
    function changePassword(){
        
        var old_password = document.getElementById("old_password").value;
        var new_password = document.getElementById("new_password").value;
        var confirm_password = document.getElementById("confirm_password").value;
        
        if(old_password =='' || new_password=='' || confirm_password==''){
         document.getElementById("error").innerHTML='***All fields are required***';
            return false;   
        }
        
        if(new_password.length <6){
            document.getElementById("error").innerHTML='***Password must be at least 6 characters***';
            return false;
        } 
        //var n = str1.localeCompare(str2);
        if(new_password.localeCompare(confirm_password)!=0){
            document.getElementById("error").innerHTML='***New Password mismatch***';
            return false; 
        }
        
          $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
   change_password: "nyasha",
   old_password,
   new_password
  },
  success: function(data){
    $('#change_password').modal('hide');
    $('#alert').modal('show');
  }
  });
        
    }
</script>   

 
        <div class="footer">
            <div class="float-right">
               Evidence Based Human Capital Solutions
            </div>
            <div>
                <strong>Copyright</strong> @Industrial Psychology Consultants 2019
            </div>
        </div>

        </div>
        </div>
<!-- logout modal -->
<div class="modal inmodal fade" id="logout" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <h2 style="color: #175ea8">Are you sure you want to logout?</h2>
                                        </div>
                                        <div class="modal-footer">
                                        <button class="btn btn-outline-info" data-dismiss="modal">No</buuton>
                                    <a href="/demo/client/logout.php"><button type="button" class="btn btn-outline-danger"><i class="fa fa-sign-out"></i> Yes Logout</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

<div class="modal inmodal fade" tabindex="-1" id="change_password" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md"  role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <form action="index.php" method="post" enctype="multipart/form-data">
      <div class="modal-body">
    
            <label>Old Password:</label>
            <input type="password" class="form-control" id="old_password" placeholder="Old password" aria-label="Old password" aria-describedby="colored-addon1" required>
                    
            <label>New Password:</label>
            <input type="password" class="form-control" id="new_password" placeholder="New password" aria-label="New password" aria-describedby="colored-addon2" required>
                    
            <label>Confirm New Password:</label>
            <input type="password" class="form-control" id="confirm_password" placeholder="Confirm new password" aria-label="Confirm new password" aria-describedby="colored-addon2" required>
             <p id="error" style="color: red" align="center"></p>
      </div>
      <br><br><br>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onClick="changePassword()">Save New Password </button>
      </div>
       </form>
    </div>
  </div>
</div>

<div class="modal inmodal fade" id="alert" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <h2 style="color: #175ea8">Password Successfully Updated</h2>
                                        </div>
                                        <div class="modal-footer">
                                        <button class="btn btn-outline-info" data-dismiss="modal">Close</buuton>
                                        </div>
                                    </div>
                                </div>
                            </div>

   <!-- Mainly scripts -->
    <script src="/demo/client/js/jquery-3.1.1.min.js"></script>
    <script src="/demo/client/js/popper.min.js"></script>
    <script src="/demo/client/js/bootstrap.js"></script>
    <script src="/demo/client/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/demo/client/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="/demo/client/js/plugins/flot/jquery.flot.js"></script>
    <script src="/demo/client/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="/demo/client/js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="/demo/client/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="/demo/client/js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="/demo/client/js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="/demo/client/js/plugins/flot/curvedLines.js"></script>

    <!-- Peity -->
    <script src="/demo/client/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="/demo/client/js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="/demo/client/js/inspinia.js"></script>
    <script src="/demo/client/js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="/demo/client/js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Jvectormap -->
    <script src="/demo/client/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="/demo/client/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <!-- Sparkline -->
    <script src="/demo/client/js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="/demo/client/js/demo/sparkline-demo.js"></script>

    <!-- ChartJS-->
    <script src="/demo/client/js/plugins/chartJs/Chart.min.js"></script>
    <script src="/demo/client/js/demo/chartjs-demo.js"></script>

    <!-- data tables source reference -->
    <script src="/demo/client/js/plugins/dataTables/datatables.min.js"></script>
    <script src="/demo/client/js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
    <!-- end of datatables -->

    <!-- iCheck -->
    <script src="/demo/client/js/plugins/iCheck/icheck.min.js"></script>

        <!-- SUMMERNOTE -->
    <script src="/demo/client/js/plugins/summernote/summernote-bs4.js"></script>

      <!-- Select2 -->
    <script src="/demo/client/js/plugins/select2/select2.full.min.js"></script>

        <!-- Ladda -->
    <script src="/demo/client/js/plugins/ladda/spin.min.js"></script>
    <script src="/demo/client/js/plugins/ladda/ladda.min.js"></script>
    <script src="/demo/client/js/plugins/ladda/ladda.jquery.min.js"></script>

        <!-- Dual Listbox -->
    <script src="/demo/client/js/plugins/dualListbox/jquery.bootstrap-duallistbox.js"></script>
   
    <!-- Sweet alert -->
    <script src="/demo/client/js/plugins/sweetalert/sweetalert.min.js"></script>

        <!-- Touch Punch - Touch Event Support for jQuery UI -->
    <script src="/demo/client/js/plugins/touchpunch/jquery.ui.touch-punch.min.js"></script>

       <!-- Switchery -->
   <script src="/demo/client/js/plugins/switchery/switchery.js"></script>

   <!-- Full Calendar -->
<script src="/demo/client/js/plugins/fullcalendar/moment.min.js"></script>
<script src="/demo/client/js/plugins/fullcalendar/fullcalendar.min.js"></script>

    <!-- Clock picker -->
 <script src="/demo/client/js/plugins/clockpicker/clockpicker.js"></script>

        <script>
        $(document).ready(function(){

            $("#todo, #inprogress, #completed").sortable({
                connectWith: ".connectList",
                update: function( event, ui ) {

                    var todo = $( "#todo" ).sortable( "toArray" );
                    var inprogress = $( "#inprogress" ).sortable( "toArray" );
                    var completed = $( "#completed" ).sortable( "toArray" );
                    $('.output').html("ToDo: " + window.JSON.stringify(todo) + "<br/>" + "In Progress: " + window.JSON.stringify(inprogress) + "<br/>" + "Completed: " + window.JSON.stringify(completed));
                }
            }).disableSelection();

        });
    </script>
    

    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>

    <script>
        $(document).ready(function(){

            $('.summernote').summernote();

        });

    </script>

        <script>

    
        $(document).ready(function(){

           $(".select2_demo_3").select2({
               // dropdownParent: $('#myModal');
                placeholder: "Select Employee",
                allowClear: true,
              
              });
             });
         </script>


          <script>
        $(document).ready(function(){

            $('.dual_select').bootstrapDualListbox({
                selectorMinimalHeight: 160
            });
                });
            </script>


    <script>
        $(document).ready(function() {


            var d1 = [[1262304000000, 6], [1264982400000, 3057], [1267401600000, 20434], [1270080000000, 31982], [1272672000000, 26602], [1275350400000, 27826], [1277942400000, 24302], [1280620800000, 24237], [1283299200000, 21004], [1285891200000, 12144], [1288569600000, 10577], [1291161600000, 10295]];
            var d2 = [[1262304000000, 5], [1264982400000, 200], [1267401600000, 1605], [1270080000000, 6129], [1272672000000, 11643], [1275350400000, 19055], [1277942400000, 30062], [1280620800000, 39197], [1283299200000, 37000], [1285891200000, 27000], [1288569600000, 21000], [1291161600000, 17000]];

            var data1 = [
                { label: "Data 1", data: d1, color: '#17a084'},
                { label: "Data 2", data: d2, color: '#127e68' }
            ];
            $.plot($("#flot-chart1"), data1, {
                xaxis: {
                    tickDecimals: 0
                },
                series: {
                    lines: {
                        show: true,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 1
                            }, {
                                opacity: 1
                            }]
                        },
                    },
                    points: {
                        width: 0.1,
                        show: false
                    },
                },
                grid: {
                    show: false,
                    borderWidth: 0
                },
                legend: {
                    show: false,
                }
            });

            var lineData = {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [
                    {
                        label: "Example dataset",
                        backgroundColor: "rgba(26,179,148,0.5)",
                        borderColor: "rgba(26,179,148,0.7)",
                        pointBackgroundColor: "rgba(26,179,148,1)",
                        pointBorderColor: "#fff",
                        data: [48, 48, 60, 39, 56, 37, 30]
                    },
                    {
                        label: "Example dataset",
                        backgroundColor: "rgba(220,220,220,0.5)",
                        borderColor: "rgba(220,220,220,1)",
                        pointBackgroundColor: "rgba(220,220,220,1)",
                        pointBorderColor: "#fff",
                        data: [65, 59, 40, 51, 36, 25, 40]
                    }
                ]
            };

            var lineOptions = {
                responsive: true
            };


            var ctx = document.getElementById("lineChart").getContext("2d");
            new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});


        });
    </script>

<!-- data tables script -->
   <script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });

    </script>

<!-- end of data table script -->

<script>

    $(document).ready(function (){

        // Bind normal buttons
        Ladda.bind( '.ladda-button',{ timeout: 2000 });

        // Bind progress buttons and simulate loading progress
        Ladda.bind( '.progress-demo .ladda-button',{
            callback: function( instance ){
                var progress = 0;
                var interval = setInterval( function(){
                    progress = Math.min( progress + Math.random() * 0.1, 1 );
                    instance.setProgress( progress );

                    if( progress === 1 ){
                        instance.stop();
                        clearInterval( interval );
                    }
                }, 200 );
            }
        });


        var l = $( '.ladda-button-demo' ).ladda();

        l.click(function(){
            // Start loading
            l.ladda( 'start' );

            // Timeout example
            // Do something in backend and then stop ladda
            setTimeout(function(){
                l.ladda('stop');
            },12000)


        });

    });

</script>





        
</body>

<!-- Mirrored from webapplayers.com/inspinia_admin-v2.9.2/dashboard_4_1.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 26 Aug 2019 09:25:21 GMT -->
</html>
