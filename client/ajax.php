
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>

<script type="text/javascript">
    $(document).ready(function () {
    var counter = 0;
for(i=0; i<=10; i++){
    $("#addrow"+i).on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td><input type="text" class="form-control" name="mail' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control" name="phone' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control" name="phone' + counter + '"/></td>';

        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
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
    function savedata(val) {
         //alert(val+' '+val2);
        var name = document.getElementById("name"+val).value;
        var email = document.getElementById("email"+val).value;
         //alert(name+' '+email);
  $.ajax({
  type: "POST",
  url: "ajaxphp.php",
  data:{
    id: val,
   name,
   email


  },
  success: function(data){
  }
  });
}
    function deletedata(val) {
        alert(val);
  $.ajax({
  type: "POST",
  url: "ajaxphp.php",
  data:{
    delid:val,
  },
  success: function(data){
  }
  });
}
</script>
<!-- <script type="text/javascript">
  var url = window.location.pathname;
var id = url.substring(url.lastIndexOf('=') + 1);
alert(id);
</script> -->

<div class="container">
    <form action="" method="post">
    <table id="myTable" class=" table order-list">
    <thead>
        <tr>
            <td>Name</td>
            <td>Gmail</td>
            <td>Phone</td>
        </tr>
    </thead>
    <tbody>
    <tr>
            <td>
                <input type="text" name="name" class="form-control" />
            </td>
            <td>
                <input type="mail" name="mail"  class="form-control"/>
            </td>
            <td>
                <input type="text" name="phone"  class="form-control"/>
            </td>
           <td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>

        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="text-align: left;">
                <input type="button" class="btn btn-lg btn-block " id="addrow2" value="Add Row" />
            </td>
        </tr>
        <tr>
        </tr>
    </tfoot>
</table>
</form>
</div>
<?php include"footer.php"; ?>