<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>

<script type="text/javascript">
    $(document).ready(function () {
    var counter = 1;
for(i=1; i<=100; i++){
    $("#addrow"+i).on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td><input type="text" class="form-control" id="employee_number' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control" id="first_name' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control" id="last_name' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control" id="email' + counter + '"/></td>';
        cols += '<td><select class="form-control" id="supervisor_email' + counter + '" ><option></option><?php echo getSupervisors(); ?></select></td>';
        cols += '<td><select class="form-control" id="department' + counter + '"><option></option><?php echo getDepartments(); ?></select></td>';
        cols += '<td><input type="text" class="form-control" id="position' + counter + '"></td>';
        cols += '<td><select class="form-control" id="account_type' + counter + '"><option></option><?php echo listAccountTypes(); ?></select></td>';

        cols += '<td><button type="button" class="btn btn-outline-danger btn-sm ibtnDel"> <i class="fa fa-trash"></i>Delete</button></td>';
        newRow.append(cols);
        $("table.order-list").append(newRow);
        counter++;
    })};



    $("table.order-list").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
    });


});
</script>

<script type="text/javascript">
  function saveEmployee(val) {
        var name = document.getElementById("name"+val).value;
        var head = document.getElementById("head"+val).value;

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
</script>
<script type="text/javascript">
  function addAccount() {
        var client_id = document.getElementById("client_id").value;
        var employee_number = document.getElementById("employee_number").value;
        var first_name = document.getElementById("first_name").value;
        var last_name = document.getElementById("last_name").value;
        var middle_name = document.getElementById("middle_name").value;
        var email = document.getElementById("email").value;
        var supervisor_email = document.getElementById("supervisor_email").value;
        var account_type = document.getElementById("account_type").value;
        var position = document.getElementById("position").value;
        var department = document.getElementById("department").value;
    //alert(department);
        // alert(client_id +' '+employee_number+' '+first_name+''+last_name+' '+middle_name+' '+email+' '+supervisor_email+' '+account_type+' '+position+' '+department);
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    addAccount: "Ziwewe",
    client_id,
    employee_number,
    first_name,
    middle_name,
    last_name,
    email,
    supervisor_email,
    account_type,
    position,
    department

  },
  success: function(data){
   // alert(data);
    document.getElementById("accounts").innerHTML = data;
  }
  });
  }
</script>
<script type="text/javascript">
  function deleteAccount(val) {
    alert(val);
     $.ajax({
  type: "POST",
  url: "autosave.php",
  data:{
    deleteAccount: "Nyengerai",
    account: val

  },
  success: function(data){
   // alert(data);
    document.getElementById("accounts").innerHTML = data;
  }
  });
  }
</script>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Adding Multiple Employee Records</h5>
                        <div class="ibox-tools">
                          <a class="btn btn-primary btn-sm" href="accounts.php">Back To Employee Records</a>
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
                      <table id="myTable" class=" table order-list">
    <thead>
        <tr>
            <td width="7%">Emp#</td>
            <td>First Name</td>
            <td>Last Name</td>
            <td>Email</td>
            <td>Supervisor</td>
            <td>Department</td>
            <td>Position</td>
            <td>Account Type</td>
            <td>Action</td>
        </tr>
    </thead>
    <tbody>
    <tr>
            <td >
                <input type="text" id="employee_number0" class="form-control" />
            </td>
            <td>
                <input type="text" id="first_name0" class="form-control" />
            </td>
            <td>
                 <input type="text" id="last_name0" class="form-control" />
            </td>
            <td>
                <input type="text" id="email0" class="form-control" />
            </td>
            <td>
                <select id="supervisor_email0" class="form-control"><option></option><?php getSupervisors(); ?></select>
            </td>
            <td>
                <select id="department0"  class="form-control"><option></option><?php getDepartments(); ?></select>
            </td>
            <td>
                <input type="text" id="position0"  class="form-control"/>
            </td>
            <td>
                <select id="account_type0" class="form-control"><option></option><?php echo listAccountTypes(); ?></select>
            </td>
           <td><button type="button" class="btn btn-outline-danger btn-sm ibtnDel"> <i class="fa fa-trash"></i>Delete</button></td>

        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="9" style="text-align: left;">
                <input type="button" class="btn btn-lg btn-block " id="addrow2" value="Add Row" />
            </td>
        </tr>
        <tr>
        </tr>
    </tfoot>
</table>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>

<?php include"footer.php"; ?>




