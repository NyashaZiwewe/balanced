<?php  include"functions.php";



function getFirstTable(){
  $conn=dbconnect();
  $scorecard_id=38;
  echo'<form name="period" action="grades.php" method="post">
  <div class="row">
  <div class="col-lg-4">
    
  <table width="100%" border="0">

  <tr>
    <td><font color="#175ea8">Owner</font> </td>
    <td>
    <input type="text" name="owner" class="form-control" value="'.getOwner($scorecard_id).'" readonly/>
    </td>
  </tr>
  <tr>
    <td><font color="#175ea8">Position</font></td>
    <td>
    <input id="position'.$scorecard_id.'" onfocusout="saveFirstTable('.$scorecard_id.')" type="text" name="position" class="form-control" value="'.getOwnerPosition().'"/>
    </td>
  </tr>
  <tr>
  <td><font color="#175ea8">Reporting Period</font> </td>
    <td>
    <input type="text" name="scorecard_id" value="'.$scorecard_id.'" hidden ?>
    <input id="r_period'.$scorecard_id.'" type="date" name="r_period" onfocusout="saveFirstTable('.$scorecard_id.')" class="form-control" value="'.getReportingPeriod($scorecard_id).'"/>
    </td>
    </tr>
  </table>
  </div>
  <div class="col-lg-4">

  <table width="100%" border="0">
  <tr>
    <td align="right" colspan="2"> <font color="#175ea8"><strong>Total Allocated Weight (%)</strong></font> </td> 
  </tr>
  <tr>
   <td align="right">
       <a href="assessments.php?scorecard='.$scorecard_id.'"><span class="btn btn-outline-primary">Assess Performance</span></a>
       </td>';
    if(getOverallWeight($_GET['scorecard'])<>100){
  echo' <td style="background-color:red"><font color="red"> <input type="text" readonly name="owner" class="form-control" value="'.getOverallWeight($_GET['scorecard']).' %"></td>';  
    } else{
  echo' <td style="background-color:green"><font color="#ffffff">'.getOverallWeight($_GET['scorecard']).'%</font></td>';
    }
  echo'
  </tr>
  </table>
</div>

  <div class="col-lg-4">
  <table width="100%" border="0">';

  $conn=dbconnect();
  $scorecard_id=$_GET['scorecard'];
  $stmt=$conn->prepare("SELECT DISTINCT(perspective_id) FROM goals LEFT JOIN scorecards ON scorecard_id=scorecards.id WHERE scorecard_id=?");
  $stmt->bind_param('i',$scorecard_id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($perspective_id);
  While($stmt->fetch()){

 echo' <tr>
           <td align="right"><font color="#175ea8">'.ucwords(getPerspectiveName($perspective_id)).'</font></td> 
           <td width="5%"></td>
           <td> <font color="#175ea8"><b>'.getPerspectiveTotalWeight($perspective_id,$scorecard_id).'%</b></font></td>
      </tr>
';
  }
$stmt->close();
$conn->close();
 echo' </table>
  </div>
  </div>

 </form>
  
  
  ';
} ?>