<?php include"header.php"; ?>
<?php include"side_bar.php"; ?>

<?php include"top_bar.php"; ?>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"> </script> 
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src='/Pinker-master/Pinker.js'></script>

        
  <?php     $sta= getTotalWR($_GET['sid']);
           // $outstanding_action_plans= getOutstandingActionPlans($_GET['sid']);


        include 'reports/scorecard.php';
          // include 'reports/save_report_image.php';

?>  


         <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-12">
                     <h1 class="h3 mb-2 text-gray-800">Download Report for <font color="blue"> <?php echo getOwner($_GET['sid']); ?></font></h1> 

                </div>
            </div>
            


             <div class="row wrapper border-bottom white-bg page-heading">
          
                   

                      <div class="col-lg-6">
                        <div class="ibox">
                            <div class="ibox-content">
                           
                            </div>
                         </div>
                       </div>

                      <div class="col-lg-6" >
                        <div class="ibox">
                            <div class="ibox-content">
                              <div class="row">
                           	<a href="../reports/nyasha/<?php echo getOwner($_GET['sid']); ?> Performance Report.docx" download class="btn btn-success"><i class="fa fa-download"></i> Download Report</a>
                               </div>
                            </div>
                         </div>
                       </div>
                </div>
                <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>

                <div id="watchlist">
                  
                  <div id="chartContainer" style="height: 360px; width: 100%;"></div>
                  <div id="imageContainer">

                  <img id="chartImage" width="96%" height="460px">
                </div>
                </div>


          <script> 

            function createFile(){
                html2canvas($("#watchlist"), { 
                    onrendered: function(canvas) { 
                        var imgsrc = canvas.toDataURL("image/png"); 
                        var name ="<?php echo "overalscore".$_GET['sid'];?>";
                        var dataURL = canvas.toDataURL(); 
                        $.ajax({ 
                            type: "POST", 
                            url: "../script.php", 
                            data: { 
                                imgBase64: dataURL, 
                                name 
                            } 
                        }).done(function(o) { 
                            // console.log('saved'); 
                        }); 
                    } 
                }); 
            }
            window.onload = createFile;
     
    </script> 






<script type="text/javascript">
  var chart = new CanvasJS.Chart("chartContainer",
{
    title: {
      text: "Performance Over Time"
    },
      axisX: {
    valueFormatString: "YY"
  },
      axisY: {
    title: "Score (in %)",
    includeZero: false,
    suffix: " %"
  },
    data: [
    {
      name: "Monthly Score in %",
      type: "spline",
      showInLegend: true,
      dataPoints: [ 

     <?php for($i=1; $i<13; $i++){
      if($i>9){
      getNyasha('2020-'.$i); 
      }else{
      getNyasha('2020-0'.$i); 
    }
  }
    ?>

        // { label: "Jan", y: 14, indexLabel: "14%"  }, 
        // { label: "Feb", y: 27, indexLabel: "Highest : 27%" },
        // { label: "Mar", y: -2, indexLabel: "Lowest : -2%"  },
        // { label: "Apr", y: 63, indexLabel: "63%"  },
        // { label: "May", y: 55, indexLabel: "55%"  },
        // { label: "Jun", y: 43, indexLabel: "43%"  },
        // { label: "Jul", y: 83, indexLabel: "83%"  },
        // { label: "Aug", y: 23, indexLabel: "23%"  },
        // { label: "Sep", y: 13, indexLabel: "13%"  },
        // { label: "Oct", y: 43, indexLabel: "43%"  },
        // { label: "Nov", y: 33, indexLabel: "33%"  },
        // { label: "Dec", y: 73, indexLabel: "73%"  }
      ]
    }
    ]
});

chart.render();

var base64Image = chart.canvas.toDataURL();
document.getElementById('chartContainer').style.display = 'none';
document.getElementById('chartImage').src = base64Image;
</script>

          <pre id='Source02' class='pinker'>


  Layout:
  <?php getSMPerspectives(); ?>
       <br>
  <?php  getSMPerspectives2(1); ?>
      <br>
    <?php getSMPerspectives2(2); ?>
      <br>
    <?php getSMPerspectives2(3); ?>
      <br>
    <?php getSMPerspectives2(4); ?>
    <?php if(countClientPerspectives()>4){
      getSMPerspectives2(5);
   } ?>
  
      </pre>

      <script type='text/javascript'>
  pinker.render();
</script>


          <script> 

            function createFile2(){
                html2canvas($("#Source02"), { 
                    onrendered: function(canvas) { 
                        var imgsrc = canvas.toDataURL("image/png"); 
                        var name ="<?php echo "strategymap".$_GET['sid'];?>";
                        var dataURL = canvas.toDataURL(); 
                        $.ajax({ 
                            type: "POST", 
                            url: "../script.php", 
                            data: { 
                                imgBase64: dataURL, 
                                name 
                            } 
                        }).done(function(o) { 
                            // console.log('saved'); 
                        }); 
                    } 
                }); 
            }
            window.onload = createFile2;
     
    </script>

      <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">

       <div class="table-responsive" id="correlation">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                    <tr>  <th colspan="2"></th>

                          <?php //getCorrelationRows($_GET['sid'],$_GET['sid']); ?>
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

          <script> 

            function createFile3(){
                html2canvas($("#correlation"), { 
                    onrendered: function(canvas) { 
                        var imgsrc = canvas.toDataURL("image/png"); 
                        var name ="<?php echo "correlation".$_GET['sid'];?>";
                        var dataURL = canvas.toDataURL(); 
                        $.ajax({ 
                            type: "POST", 
                            url: "../script.php", 
                            data: { 
                                imgBase64: dataURL, 
                                name 
                            } 
                        }).done(function(o) { 
                            // console.log('saved'); 
                        }); 
                    } 
                }); 
            }
            window.onload = createFile3;
     
    </script>

    <?php// compareMonthlyScores(); ?>
      <?php include"footer.php"; ?>
   
