<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>

<style>
    
nav > .nav.nav-tabs{

  border: none;
    color:#fff;
    background:#656870;
    border-radius:0;

}
nav > div a.nav-item.nav-link,
nav > div a.nav-item.nav-link.active
{
  border: none;
    padding: 9px 12px;
    color:#fff;
    background:#656870; 
    border-radius:0;
}

nav > div a.nav-item.nav-link.active:after
 {
  content: "";
  position: relative;
  bottom: -60px;
  left: -10%;
  border: 15px solid transparent;
  border-top-color: #175ea8;
}
.tab-content{
    /*border-top:5px solid #175ea8;*/

}

nav > div a.nav-item.nav-link:hover,
nav > div a.nav-item.nav-link:focus
{

    background: #175ea8;
    color:#fff;
    transition:background 0.20s linear;
}
</style>



        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Watch List</h5>
    
                  <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                      <a class="nav-item nav-link" id="nav-home-tab"  href="#" role="tab" ><b>WATCH LIST</b></a>
                      <!--<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Combined Watchlist</a>-->
                      <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true">Watch List By Scores (<?php echo getCountWatchList(); ?>)</a>
                      <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Watch List By Action Plans</a>
                      <a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">By Scores + Action Plans</a>
                    </div>
                  </nav>
                    </div>
                    <div class="ibox-content">
                        

                <div class="col-xs-12 ">
           
                  <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                      At et consectetur ipsum labore excepteur est proident excepteur ad velit occaecat qui minim occaecat veniam. Fugiat veniam incididunt anim aliqua enim pariatur veniam sunt est aute sit dolor anim. Velit non irure adipisicing aliqua ullamco irure incididunt irure non esse consectetur nostrud minim non minim occaecat. Amet duis do nisi duis veniam non est eiusmod tempor incididunt tempor dolor ipsum in qui sit. Exercitation mollit sit culpa nisi culpa non adipisicing reprehenderit do dolore. Duis reprehenderit occaecat anim ullamco ad duis occaecat ex.
                    </div>
                    
                    
                    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                       <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" id="image">
                    <thead>
                    <tr>
                          <th>Full Name</th>
                          <th>Job Title</th>
                          <th>Department</th>
                          <th>Supervisor</th>
                          <th>Score</th>
                          <th>Action</th>
                        </tr>
                    </tr>
                    </thead>
                    <tbody>
                         <?php getWatchList();  ?>
                    </tbody>
                    <tfoot>
                    <tr>
                          <th>Full Name</th>
                          <th>Job Title</th>
                          <th>Department</th>
                          <th>Supervisor</th>
                          <th>Score</th>
                          <th>Action</th>
                    </tr>
                    </tfoot>
                    </table>
                        </div>
                    </div>
                    
                    
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" id="image">
                    <thead>
                    <tr>
                          <th>Full Name</th>
                          <th>Job Title</th>
                          <th>Department</th>
                          <th>Supervisor</th>
                          <th>Completion</th>
                          <th>Action</th>
                        </tr>
                    </tr>
                    </thead>
                    <tbody>
                         <?php getWatchListByActionPlans();  ?>
                    </tbody>
                    <tfoot>
                    <tr>
                          <th>Full Name</th>
                          <th>Job Title</th>
                          <th>Department</th>
                          <th>Supervisor</th>
                          <th>Completion</th>
                          <th>Action</th>
                    </tr>
                    </tfoot>
                    </table>
                        </div>
                    </div>
                    
                    
                    
                    <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                               <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" id="image">
                    <thead>
                    <tr>
                          <th>Full Name</th>
                          <th>Job Title</th>
                          <th>Department</th>
                          <th>Supervisor</th>
                          <th>Score</th>
                          <th>Action</th>
                        </tr>
                    </tr>
                    </thead>
                    <tbody>
                         <?php getBothWatchLists();  ?>
                    </tbody>
                    <tfoot>
                    <tr>
                          <th>Full Name</th>
                          <th>Job Title</th>
                          <th>Department</th>
                          <th>Supervisor</th>
                          <th>Score</th>
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


                    </div>
                </div>
            </div>
       
        
        
   


<?php include"footer.php"; ?>





