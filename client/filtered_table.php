<?php


// function getReadOnlyNestedTable(){


  $table = '
    <table class=" table table-striped" width="100%" id="myTable">
              <thead>
                <tr>
    <th style="width:6%"><font color="#175ea8"><b>Perspective</b></font></th>
    <th style="width:20%" data-toggle="popover" data-placement="top" data-content="What you actually Want to achieve"><font color="#175ea8"><b>Goal</b></font></th>
    <th style="width:20%" data-toggle="popover" data-placement="top" data-content="Measure of Success"><font color="#175ea8"><b>Measure</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Unit of measurement"><font color="#175ea8"><b>Unit</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Reporting Frequency"><font color="#175ea8"><b>RF</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Target Period"><font color="#175ea8"><b>TP</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Base Target (minimum expected)"><font color="#175ea8"><b>BT</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Stretch target (maximum expected)"><font color="#175ea8" ><b>ST</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Actual Achievement"><font color="#175ea8"><b>Actual</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Allocated Weight."><font color="#175ea8"><b>AW</b> </font> </th>  
    <th data-toggle="popover" data-placement="top" data-content="Weighted Rating (automatically Calculated)"><font color="#175ea8"><b>WR</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Trend Indicator (time to time performance Indicator)"><font color="#175ea8"><b>TI</b></font></th>
    <th data-toggle="popover" data-placement="top" data-content="Specific Comment for this measure"><font color="#175ea8"><b>Comment</b></font></th>
                      </tr>
                </thead>
                <tbody>';

   $conn = dbconnect();

    $scorecard_id = test_input($_GET['scorecard']);

    //get the perspectives
    $stmt = $conn->prepare("SELECT perspective_id FROM bsc_client_perspectives WHERE client_id=?");
    $stmt->bind_param('i',$_SESSION['client_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($perspective_id);
    while($stmt->fetch()){
  
      //get count of measures in selected perspective
      $stmt1 = $conn->prepare("SELECT COUNT(bsc_targets.id) AS total_measures FROM bsc_targets INNER JOIN bsc_goals ON bsc_targets.goal_id = bsc_goals.id WHERE bsc_goals.scorecard_id = ? AND bsc_goals.perspective_id = ?");
      $stmt1 ->bind_param('ii', $scorecard_id, $perspective_id);
      $stmt1->execute();
      $stmt1->store_result();
      $stmt1->bind_result($total_measures);
      $stmt1->fetch();
      $stmt1->close();

      //check if there are no measures
      if($total_measures == 0){

        //get total goals in selected perspective for the goal
        $stmt2 = $conn->prepare("SELECT COUNT(*) AS total_goals FROM bsc_goals WHERE scorecard_id = ? AND perspective_id = ?");
        $stmt2 ->bind_param('ii', $scorecard_id, $perspective_id);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($total_goals);
        $stmt2->fetch();
        $stmt2->close();

        //check if goals are available
        if($total_goals == 0){

          //add the perspective in table row
          $table .= '<tr><td rowspan="2">'.getPerspectiveName($perspective_id).'</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          </tr>';
           $table.='
             <tr>
             <td></td>
              <td colspan="6"></td>
              <td><font color="blue">Total</font></td>
              <td></td>         
              <td></td>
              
              </tr>
            ';

        }else{

          //add the perspective in table row
          $table .= '<tr><td rowspan="'.$total_goals.'">'.getPerspectiveName($perspective_id).'</td>';

          //get the goals for selected perspective
          $stmt1 = $conn->prepare("SELECT id, scorecard_id, goal FROM bsc_goals WHERE scorecard_id = ? AND perspective_id = ?");
          $stmt1 ->bind_param('ii', $scorecard_id, $perspective_id);
          $stmt1->execute();
          $stmt1->store_result();
          $stmt1->bind_result($id, $scorecard_id, $goal);
          while($stmt1->fetch()){

            //add the goal in table row
            $table .= '<td rowspan="1"><p data-toggle="modal" data-target="#goal'.$id.'">'.$goal.'
</p></td>      
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
            </tr>';
            $table.='
             <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
              <td ><font color="blue">Total</font></td>         
              <td ><font color="blue">empty</font></td>
              <td></td>
              
              </tr>
            ';

              echo '<!-- Modal -->
          <div class="modal fade" id="goal'.$id.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">view Goal </h4>
                </div>
                <div class="modal-body" >
                              <div class="row" >
                    <div class="col-lg-12">
                      <div class="form-group">
                        <textarea rows="4" cols="5" name="goal" readonly>'.$goal.'</textarea>
                        <br/><br/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
              
            </div>
          </div>';

              
          }
          $stmt1->close();

        }

      }else{

        //add the perspective in table row
        $total_measures = $total_measures+1;
        $table .= '<div id="div"><tr><td rowspan="'.$total_measures.'"><span id="mySpan">'.getPerspectiveName($perspective_id).'</span></td>';

        //get the goals for selected perspective
        $stmt1 = $conn->prepare("SELECT id, goal FROM bsc_goals WHERE scorecard_id = ? AND perspective_id = ?");
        $stmt1 ->bind_param('ii', $scorecard_id, $perspective_id);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($id, $goal);
        while($stmt1->fetch()){

          //get total measures in selected perspective for the goal
          $stmt2 = $conn->prepare("SELECT COUNT(bsc_targets.id) AS total_measures FROM bsc_targets INNER JOIN bsc_goals ON bsc_targets.goal_id = bsc_goals.id WHERE bsc_goals.scorecard_id = ? AND bsc_goals.perspective_id = ? AND bsc_goals.id = ?");
          $stmt2 ->bind_param('iii', $scorecard_id, $perspective_id, $id);
          $stmt2->execute();
          $stmt2->store_result();
          $stmt2->bind_result($total_goal_measures);
          $stmt2->fetch();
          $stmt2->close();

          //add the goal in table row
          $table .= '<td rowspan="'.$total_goal_measures.'"><p data-toggle="modal" data-target="#goal'.$id.'">'.$goal.'
</p></td>';

          //counter for the rowspan
          $counter_goals = 0;

          //get measures for the goal
          $stmt2 = $conn->prepare("SELECT bsc_targets.id, measure, measure_type, unit, reporting_frequency, target_period, base_target, stretch_target, actual ,allocated_weight,trend_indicator FROM bsc_targets WHERE goal_id = ?");
          $stmt2 ->bind_param('i', $id);
          $stmt2->execute();
          $stmt2->store_result();
          $stmt2->bind_result($measure_id, $measure, $measure_type, $unit, $reporting_frequency, $target_period, $base_target, $stretch_target, $actual, $allocated_weight,$trend_indicator);
          while($stmt2->fetch()){
            if($counter_goals == 0){
                $table .=  '<td>';
               if(strlen($measure)>0){
             $table.='<p data-toggle="modal" data-target="#measure'.$measure_id.'">'.$measure.'</p>';
              } else{
                $table.='<i class="fa fa-pencil-square-o" aria-hidden="true" style="color:#175ae8;" data-toggle="modal" data-target="#measure'.$measure_id.'">measure</i>';
              } 
            
     $table.='</td>
              <td>'.$unit.'</td>
              <td>'.$reporting_frequency.'</td>
              <td>'.$target_period.'</td>
              <td>'.$base_target.'</td>
              <td>'.$stretch_target.'</td>';
               if(getReportingFrequency($measure_id)=='Y'){
               $table.='<td  data-title="'.getActualTooltip($measure_id).'">'.getMonthlyAmount($measure_id, $month).'</td>';
              }else{
             $table.='<td data-title="'.getActualTooltip($measure_id).'"><p data-toggle="modal" data-target="#select'.$measure_id.'">'.getMonthlyAmount($measure_id, $month).'</p></td>';
              }
            
          $table.='<td>'.$allocated_weight.'</td>';
             if(getFilteredWeightedRating($measure_id,$month)<0){
              $table.='<td><p id="wr'.$measure_id.'"><font color="#FF0000">'.round(getFilteredWeightedRating($measure_id,$month),2).'%</font></p></td>'; 
              }
                 elseif(getFilteredWeightedRating($measure_id,$month)==0 AND strlen($actual) >0){
              $table.='<td><p id="wr'.$measure_id.'"><font color="green">'.round(getFilteredWeightedRating($measure_id,$month),2).'%</font></p></td>';
            }
               elseif(getFilteredWeightedRating($measure_id,$month)==""){
              $table.='<td></td>';
            }
            
              else{
               $table.='<td><p id="wr'.$measure_id.'"><font color="green">'.round(getFilteredWeightedRating($measure_id,$month),2).'%</font></p></td>';
            }
          $table.=getTrendIndicator($measure_id);
       $table.='<td><button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#comment'.$measure_id.'"><i class="fa fa-commenting-o" aria-hidden="true"></i> <font color="#175ea8"><b>'.countComments($measure_id).'</b></font>
</i></button></td>
 </form>';

           $table.='
              </tr>';

              $counter_goals++;
            }else{
              $table .=  '<tr><td>';
                 if(strlen($measure)>0){
             $table.='<p data-toggle="modal" data-target="#measure'.$measure_id.'">'.$measure.'
            </p>';
              } else{
                $table.='<td><i class="fa fa-pencil-square-o" aria-hidden="true" style="color:#175ae8;" data-toggle="modal" data-target="#measure'.$measure_id.'">measure</i>';
              }
//straightfromscorecard
     $table.='</td>
              <td>'.$unit.'</td>
              <td>'.$reporting_frequency.'</td>
              <td>'.$target_period.'</td>
              <td>'.$base_target.'</td>
              <td>'.$stretch_target.'</td>';
               if(getReportingFrequency($measure_id)=='Y'){
               $table.='<td>'.$actual.'</td>';
              }else{
             $table.='<td data-title="'.getActualTooltip($measure_id).'"><p data-toggle="modal" data-target="#select'.$measure_id.'">'.getMonthlyAmount($measure_id, $month).'</p></td>';
              }
          
            
     $table.='<td>'.$allocated_weight.'</td>';
             if(getFilteredWeightedRating($measure_id,$month)<0){
              $table.='<td><p id="wr'.$measure_id.'"><font color="#FF0000">'.round(getFilteredWeightedRating($measure_id,$month),2).'%</font></p></td>'; 
              }
             elseif(getFilteredWeightedRating($measure_id,$month)==0 AND strlen($actual) >0){
              $table.='<td><p id="wr'.$measure_id.'"><font color="green">'.round(getFilteredWeightedRating($measure_id,$month),2).'%</font></p></td>';
            }
               elseif(getFilteredWeightedRating($measure_id,$month)==""){
              $table.='<td></td>';
            }
              else{
              $table.='<td><p id="wr'.$measure_id.'"><font color="green">'.round(getFilteredWeightedRating($measure_id,$month),2).'%</font></p></td>';
            }
         $table.=getTrendIndicator($measure_id);
  $table.='</select></td><td><button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#comment'.$measure_id.'"><i class="fa fa-commenting-o" aria-hidden="true"></i> <font color="#175ea8"><b>'.countComments($measure_id).'</b></font>
</i></button></td>
</form>';

$table.='   
              </tr></div>
              ';
              $counter_goals++;
            }

                 
      echo' <div class="modal inmodal fade" id="action_plans'.$measure_id.'" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4>Tasks Involved to achieve this.</h4>
                                    
                         <div class="modal-body">
                        <div class="row" id="add_to_me'.$measure_id.'">
                        <ul class="todo-list m-t small-list" style="text-align: left;" id="add_to'.$measure_id.'">';
                          getReadOnlyMeasureTasks($measure_id);
                 echo'           </ul>
                        </div><br>
                     <div class="row" id="button'.$measure_id.'">
                         </div>  
                               </div>
                              
                <div class="modal-footer">
                                          
           
                  <button type="button" onClick="location.reload();" class="btn btn-primary" data-dismiss="modal">Done</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
';
         

                 
           
                 echo '<!-- Modal -->
          <div class="modal fade bd-example-modal-lg" id="comment'.$measure_id.'" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Add Comments </h4>
                </div>
                <div class="modal-body">';

                     getIndividualComments($measure_id);
                        
                    echo'<div class="row">
                          <div class="col-1"></div>
                          <div class="media-body col-11" style="text-align: right;" id="newcomment'.$measure_id.'">
                            
                            </div>
                          </div>
                       <br> <textarea class="form-control" id="mycomment'.$measure_id.'" placeholder="Write comment..."></textarea><br>
                               
                                <div class="form-group" align="right">
                                    <button type="button" onclick="saveComment('.$scorecard_id.','.$measure_id.')" class="btn btn-primary"><i class="fa fa-send"></i> Send</button>
                                </div>

                    
                   
                  <div class="form-group" align="right">
                 
                    <button type="button" class="btn btn-outline-secondary" style="width: 100%" data-dismiss="modal">Close</button>
                  </div>
              
                </div>
              </div>
              
            </div>
          </div>';
     echo '<!-- Modal -->
          <div class="modal fade" id="goal'.$id.'" role="dialog">+

            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">View Goal </h4>
                </div>
                <div class="modal-body" >

                  <div class="row" >
                    <div class="col-lg-12">
                      <div class="form-group">

                        <textarea rows="4" cols="5" name="goal" readonly class="form-control">'.$goal.'</textarea>
                        <br/><br/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">

                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
              
                </div>
              </div>
              
            </div>
          </div>';

     echo '<!-- Modal -->
          <div class="modal fade" id="select'.$measure_id.'" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header">
                  <h4 class="modal-title">Actual Achievements</h4>
                </div>
                <div class="modal-body" >
                <form action="../grades.php" method="POST">
                 <div class="row" >
                    <div class="col-lg-12">
                      <div id="33'.$measure_id.'" class="form-group">';

             getReadOnlyRevenues2($measure_id);
         
            echo'    
                    </div>
                    </div>
                  </div>
                  <div class="form-group" align="right">
                      <button type="button" onClick="document.location.reload(true)" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </form>
                </div>
              </div>
              
            </div>
          </div>';
          echo '<!-- Modal -->
          <div class="modal fade" id="measure'.$measure_id.'" role="dialog">
            <div class="modal-dialog modal-lg">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">View Measure </h4>
                </div>
                <div class="modal-body">

                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">

                        <textarea rows="4" cols="10" name="measure" class="form-control" readonly>'.$measure.'</textarea>
                        <br/><br/>
                      </div>
                    </div>
                   
                  </div>
                  <div class="form-group" align="right">
                  <br/>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                
                </div>
              </div>
              
            </div>
          </div>';
    
          }
          $stmt2->close();

        }
         $table.=' 
             <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
             <td><font color="blue">Total</font></td>
             <td ><font color="blue">'.getPerspectiveTotalWeight($perspective_id,$scorecard_id).'</font></td>';
if (getFilteredWR($scorecard_id,$perspective_id,$month)<0){
   $table.='<td bgcolor="#FF0000"><font color="#fff">'.round(getFilteredWR($scorecard_id,$perspective_id,$month),2).'%</font></td>';
   }else{
    $table.='<td bgcolor="green"><font color="#fff">'.round(getFilteredWR($scorecard_id,$perspective_id,$month),2).'%</font></td>';
   }
       $table.='  <td></td>
                  <td></td>
                  </tr>';
        $stmt1->close();

      }

    }
    $stmt->close();
    
    $conn->close();

    //close table tag
    $table .= '<tr>
    <td colspan="8" align="right"><font color="#175ae8">Overall Achievement</font></td>';
    if (getOverallWeight($scorecard_id)!=100){
        $table.='<td colspan="2" align="right" bgcolor="#FF0000"><font color="#fff">'.getOverallWeight($scorecard_id).'%</font></td>';
        }else{
        $table.='<td colspan="2" align="right" bgcolor="green"><font color="#fff">'.getOverallWeight($scorecard_id).' %</font></td>';
        }
 if (getFilteredTotalWR($scorecard_id,$month)<0){
   $table.='<td bgcolor="#FF0000"><font color="#fff">'.round(getFilteredTotalWR($scorecard_id,$month),2).'%</font></td>';
   }else{
    $table.='<td bgcolor="green"><font color="#fff">'.round(getFilteredTotalWR($scorecard_id,$month),2).'%</font></td>';
   }

  $table.='  </td>
            <td></td>
            <td></td>
            </tr>
    </tbody></table>';

    echo $table;
    
  // }

?>