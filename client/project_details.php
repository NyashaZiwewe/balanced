<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>

<script>
  function addCode(val) { 
            document.getElementById("add_to_me"+val).innerHTML +=  
 '<li><div class="input-group"><input type="text" placeholder="Add new task. " class="input form-control form-control"><span class="input-group-btn"> <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i> Add task</button></span></div></li>'; 
        } 
</script>


            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-12">
                    <h2>Action Plans for <b>Iperform Revamp</b> Project</h2>

                </div>
            </div>

        <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-lg-4" id="style-11" style="height: 500px; overflow: auto;">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>To-do List</h3>
                            <p class="small"><i class="fa fa-hand-o-up"></i> Drag task between list</p>

                            <div class="input-group">                              
                                        <button type="button" data-toggle="modal" data-target="addModal" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i> Add Project</button>                             
                            </div>

                            <ul class="sortable-list connectList agile-list" id="todo">
                        <?php getProjects(1); ?>
                    
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" id="style-11" style="height: 500px; overflow: auto;">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>In Progress</h3>
                            <p class="small"><i class="fa fa-hand-o-up"></i> Drag task between list</p>
                            <ul class="sortable-list connectList agile-list" id="inprogress">
    
                          <?php getProjects(2); ?>   
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" id="style-11" style="height: 500px; overflow: auto;">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>Completed</h3>
                            <p class="small"><i class="fa fa-hand-o-up"></i> Drag task between list</p>
                            <ul class="sortable-list connectList agile-list" id="completed">
                              <?php getProjects(4); ?>                                                
                              
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

<?php include"footer.php"; ?>