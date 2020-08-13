<?php

    $conn=dbconnect();

    $scorecard_id=$_GET['scorecard'];
    $department_id=getScoreCardDepartment($scorecard_id);
    //$i=0;
 $count = countClientPerspectives() + 1;
 $table;

if(isset($_POST['month'])){
    $month = $_POST['month'];

    $variance_from_department=getFilteredTotalWR($scorecard_id,$month)- getFilteredDepartmentalAVG($department_id,$month);
    $variance_from_company=getFilteredTotalWR($scorecard_id,$month)-getFilteredCompanyAVG($month);
    
    for($perspective_id=1; $perspective_id<$count; $perspective_id++){
    
    $Perspective_variance_from_department=getFilteredWR($scorecard_id,$perspective_id,$month)-getFilteredDepartmentPerspectiveAVG($department_id,$perspective_id,$month);
    $Perspective_variance_from_company=getFilteredWR($scorecard_id,$perspective_id,$month)-getFilteredCompanyPerspectiveAVG($perspective_id,$month);

    $table.='<tr><td></td>
             <td>'.getPerspectiveName($perspective_id).'</td>
             <td>'.round(getFilteredWR($scorecard_id,$perspective_id,$month),2).'</td>
             <td>'.round(getFilteredDepartmentPerspectiveAVG($department_id,$perspective_id,$month),2).'</td>
             <td>'.getVarianceColor(round($Perspective_variance_from_department,2)).'</td>
             <td>'.round(getFilteredCompanyPerspectiveAVG($perspective_id,$month),2).'</td>
             <td>'.getVarianceColor(round($Perspective_variance_from_company,2)).'</td>
             </tr>';
       
       }
    $table.='<tr style="background-color:#babab2">
             <td></td>
             <td><b>Overall</td>
             <td>'.round(getFilteredTotalWR($scorecard_id,$month),2).'</td>
             <td>'.round(getFilteredDepartmentalAVG($department_id,$month),2).'</td>
             <td>'.getVarianceColor(round($variance_from_department,2)).'</td>
             <td>'.round(getFilteredCompanyAVG($month),2).'</td>
             <td>'.getVarianceColor(round($variance_from_company,2)).'</b></td>
             </tr>';

} elseif(isset($_POST['btnRange'])){
   $from = $_POST['from'];
   $to = $_POST['to'];

   $variance_from_department=getRangedTotalWR($scorecard_id,$from,$to)- getRangedDepartmentalAVG($department_id,$from,$to);
    $variance_from_company=getRangedTotalWR($scorecard_id,$from,$to)-getRangedCompanyAVG($from,$to);

    for($perspective_id=1; $perspective_id<$count; $perspective_id++){
    
    $Perspective_variance_from_department=getRangedWR($scorecard_id,$perspective_id,$from,$to)-getFilteredDepartmentPerspectiveAVG($department_id,$perspective_id,$from,$to);
    $Perspective_variance_from_company=getRangedWR($scorecard_id,$perspective_id,$from,$to)-getFilteredCompanyPerspectiveAVG($perspective_id,$from,$to);

    $table.='<tr><td></td>
             <td>'.getPerspectiveName($perspective_id).'</td>
             <td>'.round(getRangedWR($scorecard_id,$perspective_id,$from,$to),2).'</td>
             <td>'.round(getRangedDepartmentPerspectiveAVG($department_id,$perspective_id,$from,$to),2).'</td>
             <td>'.getVarianceColor(round($Perspective_variance_from_department,2)).'</td>
             <td>'.round(getRangedCompanyPerspectiveAVG($perspective_id,$from,$to),2).'</td>
             <td>'.getVarianceColor(round($Perspective_variance_from_company,2)).'</td>
             </tr>';
       
       }
    $table.='<tr style="background-color:#babab2">
             <td></td>
             <td><b>Overall</td>
             <td>'.round(getRangedTotalWR($scorecard_id,$from,$to),2).'</td>
             <td>'.round(getFilteredDepartmentalAVG($department_id,$from,$to),2).'</td>
             <td>'.getVarianceColor(round($variance_from_department,2)).'</td>
             <td>'.round(getFilteredCompanyAVG($from,$to),2).'</td>
             <td>'.getVarianceColor(round($variance_from_company,2)).'</b></td>
             </tr>';

}
else{

    $variance_from_department=getTotalWR($scorecard_id)- getDepartmentalAVG($department_id);
 
    $variance_from_company=getTotalWR($scorecard_id)-getCompanyAVG();
    
       for($perspective_id=1; $perspective_id<$count; $perspective_id++){
    
    $Perspective_variance_from_department=getWR($scorecard_id,$perspective_id)-getDepartmentPerspectiveAVG($department_id,$perspective_id);
    $Perspective_variance_from_company=getWR($scorecard_id,$perspective_id)-getCompanyPerspectiveAVG($perspective_id);

    $table.='<tr>
             <td></td>
             <td>'.getPerspectiveName($perspective_id).'</td>
             <td>'.round(getWR($scorecard_id,$perspective_id),2).'</td>
             <td>'.round(getDepartmentPerspectiveAVG($department_id,$perspective_id),2).'</td>
             <td>'.getVarianceColor(round($Perspective_variance_from_department,2)).'</td>
             <td>'.round(getCompanyPerspectiveAVG($perspective_id),2).'</td>
             <td>'.getVarianceColor(round($Perspective_variance_from_company,2)).'</td>
             </tr>';
       
       }
    $table.='<tr style="background-color:#babab2">
            <td></td>
             <td><b>Overall</td>
             <td>'.round(getTotalWR($scorecard_id),2).'</td>
             <td>'.round(getDepartmentalAVG($department_id),2).'</td>
             <td>'.getVarianceColor(round($variance_from_department,2)).'</td>
             <td>'.round(getCompanyAVG(),2).'</td>
             <td>'.getVarianceColor(round($variance_from_company,2)).'</b></td>
             </tr>';
   }
        echo $table;



?>