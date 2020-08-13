<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>


        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                          <div class="tooltip-demo">
                        <h5>Strategy Map Correlation Table</h5>
<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Tooltip on left">Tooltip on left</button>
</div>
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
                    <table class="table table-striped table-bordered table-hover dataTables-example" id="example">
                    <thead>
                    <tr>  <th colspan="2"></th>

                          <?php getCorrelationRows(1); ?>
                    </tbody>
                    <tfoot>
                
                    </tfoot>
                    </table>
                    </div>

                      <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                    <tr>  <th colspan="2"></th>

                          <?php getCorrelationRows2(1); ?>
                    </tbody>
                    <tfoot>
                
                    </tfoot>
                    </table>
                    </div>

                    </div>
                </div>
            </div>
            </div>
        </div>

  



<?php include"footer.php"; ?>



