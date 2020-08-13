<script type="text/javascript">
   function addLink(){
        // chart.addClink(233, 169, 'text').draw();
         //}
    <?php
$conn=dbconnect();

    $stmt1 = $conn->prepare("SELECT COUNT(*) FROM bsc_goals WHERE scorecard_id=?");
    $stmt1->bind_param('i',$scorecard_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($count);
    $stmt1->fetch();
    $stmt1->close();
    $xpo = $count * ($count-1);
    $half = $xpo/2;

    $stmt = $conn->prepare("SELECT id, goal FROM bsc_goals WHERE scorecard_id=? ORDER BY id ASC");
    $stmt->bind_param('i',$scorecard_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($goal_id1, $goal1);
    while($stmt->fetch()){

    $stmt1 = $conn->prepare("SELECT start, reporting_period FROM bsc_scorecards WHERE id=?");
    $stmt1->bind_param('i',$scorecard_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($start_period,$reporting_period);
    $stmt1->fetch();
    $stmt1->close();
   
        $start = strtotime($start_period);
        $end = strtotime($reporting_period);
        $arrX = array();
     
        while($start < $end)
        {
          $month = date('Y-m', $start);
          $X = round(getFilteredGoalWR($goal_id1,$month),2);
          $start = strtotime("+1 month", $start);
          array_push($arrX, $X);
        }
     $n = sizeof($arrX);

    $stmt1 = $conn->prepare("SELECT id, goal FROM bsc_goals WHERE scorecard_id=? ORDER BY id DESC");
    $stmt1->bind_param('i',$scorecard_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($goal_id2, $goal2);
    while($stmt1->fetch()){
        
        $start = strtotime($start_period);
        $end = strtotime($reporting_period);
        $arrY = array();
     
        while($start < $end)
        {
          $month = date('Y-m', $start);
          $Y = round(getFilteredGoalWR($goal_id2,$month),2);
          $start = strtotime("+1 month", $start);

          array_push($arrY, $Y);
        } 

    if($goal_id2 <> $goal_id1){
     $xpo--;

     if($xpo>=$half){
        if(!is_infinite(correlationCoefficient($arrX, $arrY, $n)) AND (correlationCoefficient($arrX, $arrY, $n) >= 0.8 OR correlationCoefficient($arrX, $arrY, $n) <= -0.8)){
        ?>
      addClink(<?php echo $goal_id2; ?>, <?php echo $goal_id1; ?>, '<?php echo correlationCoefficient($arrX, $arrY, $n); ?>').draw();  

        <?php }
        elseif(!is_infinite(correlationCoefficient($arrX, $arrY, $n)) AND (correlationCoefficient($arrX, $arrY, $n) <= 0.8 AND correlationCoefficient($arrX, $arrY, $n) >= -0.8 AND correlationCoefficient($arrX, $arrY, $n) <> 0)){
           ?>   
           
      addClink(<?php echo $goal_id2; ?>, <?php echo $goal_id1; ?>, '<?php echo correlationCoefficient($arrX, $arrY, $n); ?>').draw();
           
           <?php 
        } 
        }
     }  
     //echo'<td>'.correlationCoefficient($arrX, $arrY, $n).'</td>';
  //}
    }
    $stmt1->close();
    }
    $stmt->close();
?>
}
</script>