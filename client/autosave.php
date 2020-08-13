<?php session_start();
	include"functions.php";
	

if(!empty($_POST['saveBU'])){
	saveBusinessUnit($_POST['id'],$_POST['name'],$_POST['head']);
	echo getBusinessUnits();
	exit;
}


if(!empty($_POST['addBU'])){
	addBusinessUnit($_POST['client_id'],$_POST['name'],$_POST['head']);
	echo getBusinessUnits();
	exit;
}


if(!empty($_POST['addAccount'])){
       addAccount($_POST['client_id'],$_POST['employee_number'], $_POST['first_name'], $_POST['middle_name'], $_POST['last_name'], $_POST['position'], $_POST['supervisor_email'], $_POST['business_unit'], $_POST['department'], $_POST['account_type'],$_POST['email']);
	echo getAccounts();
	exit;
}


if(!empty($_POST['addScorecard'])){
       addEmployeeScorecard($_POST['owner'], $_POST['client_id'],$_POST['department']);
   getEmployeesWithoutScorecards();
  exit;
}


if(!empty($_POST['saveAccount'])){
        getModifyAccount($_POST['id'], $_POST['client_id'], $_POST['employee_number'], $_POST['first_name'], $_POST['middle_name'], $_POST['last_name'], $_POST['position'], $_POST['supervisor_email'],$_POST['business_unit'],$_POST['department'], $_POST['email'], $_POST['account_type']);
  echo getAccounts();
  exit;
}


if(!empty($_POST['deleteAccount'])){
       deleteAccount($_POST['account']);
	echo getAccounts();
	exit;
}

if(!empty($_POST['addQuestion'])){
       add360Question($_POST['question'],$_POST['step_id']);
  echo get360Questions();
  exit;
}
if(!empty($_POST['saveQuestion'])){
       update360Question($_POST['question_id'],$_POST['step_id'],$_POST['question']);
  echo get360Questions();
  exit;
}
if(!empty($_POST['deleteQuestion'])){
       deleteQuestion($_POST['question_id']);
  echo get360Questions();
  exit;
}

if(!empty($_POST['addResponse'])){
       addResponse($_POST['user_id'],$_POST['client_id'],$_POST['question_id'],$_POST['value']);
  echo get360StepTabs();
  exit;
}
if(!empty($_POST['saveResponse'])){
       updateResponse($_POST['response_id'],$_POST['value']);
  echo get360StepTabs();
  exit;
}


if(!empty($_POST['overalComments'])){
      addOveralComments($_POST['id'], $_POST['scorecard_id'],$_POST['scope'],$_POST['comment']);
      }


  if(!empty($_POST['supervisorComments'])){
      addOveralComments($_POST['id'], $_POST['scorecard_id'],$_POST['scope'],$_POST['comment']);
      }


  if(!empty($_POST['addcomment'])){
        addComment($_POST['scorecard_id'],$_POST['measure_id'],$_POST['comment']);
    // echo "zlatan";
      }


  if(!empty($_POST['firstTable'])){
        updateReportingPeriod($_POST['position'],$_POST['r_period'],$_POST['start_period'],$_POST['scorecard_id']);
       
        // echo $_POST['start_period'];
         exit;
      }

  if(!empty($_POST['addPerspective'])){
        addPerspective($_POST['client_id'],$_POST['perspective_id']);
      echo  getCompanyPerspectives();
      }


if(!empty($_POST["wholerow"])) {
    $measure_id=$_POST['measure_id'];
    $unit= $_POST['unit'];
    $reporting_frequency = $_POST['reporting_frequency'];
    $target_period = $_POST['target_period'];
    $base_target = $_POST['base_target'];
    $stretch_target = $_POST['stretch_target'];
    $actual = $_POST['actual'];
    $allocated_weight = $_POST['allocated_weight'];
    $scorecard_id=$_POST['scorecard_id'];
  
   updateRow($unit,$reporting_frequency,$target_period,$base_target,$stretch_target,$actual,$allocated_weight,$measure_id);
   echo getOverallWeight($scorecard_id);
   exit;
  }
  if(!empty($_POST["upper_weights"])) {
    $scorecard_id=$_POST['scorecard_id'];
   echo  getUpperWeights($scorecard_id);
   exit;
  }

if(!empty($_POST["updateWeightedRating"])) {
    $measure_id=$_POST['measure_id'];
   echo  getWeightedRating($measure_id);
   exit;
  }

  if(!empty($_POST["sendMail"])) {
  sendMail($_POST['recepient'],$_POST['reply_to'],$_POST['forward'],$_POST['subject'],$_POST['message'],$_POST['sender']);
   exit;
  }

    if(!empty($_POST["saveDraft"])) {
  saveDraft($_POST['recepient'],$_POST['reply_to'],$_POST['forward'],$_POST['subject'],$_POST['message'],$_POST['sender']);
   exit;
  }

      if(!empty($_POST["addTask"])) {
          
  addTask($_POST['project_id'],$_POST['task'],$_POST['due_date']);
  echo getProjectTasks($_POST['project_id']);

   exit;
}
     if(!empty($_POST["updateTaskStatus"])) {
  updateTaskStatus($_POST['task_id'],$_POST['status'],$_POST['scorecard_id'],$_POST['project_id']);

   exit;
  }

       if(!empty($_POST["updateTaskProgress"])) {
  updateTaskProgress($_POST['task_id'],$_POST['value']);
  //echo $_POST['task_id'].' '.$_POST['value'];

   exit;
  }

        if(!empty($_POST["addMeasureTask"])) {
  addMeasureTask($_POST['measure_id'],$_POST['task'],$_POST['due_date']);
   echo getMeasureTasks($_POST['measure_id']);

   exit;
}
     if(!empty($_POST["updateMeasureTaskStatus"])) {
  updateMeasureTaskStatus($_POST['task_id'],$_POST['status']);

   exit;
  }


   if(!empty($_POST["addPepList"])) {
  addPepList($_POST['pep_id'],$_POST['list'],$_POST['due_date']);
   echo getPepList($_POST['pep_id']);
   exit;
}
     
       if(!empty($_POST["updatePepList"])) {
  updatePepList($_POST['pep_id'],$_POST['status']);

   exit;
  }
       if(!empty($_POST["updatePolicy"])) {
  updatePolicy($_POST['mandatory']);
   exit;
  }
       if(!empty($_POST["updateProjectStatus"])) {
  updateProjectStatus($_POST['project_id'],$_POST['status']);

   exit;
  }

  if(!empty($_POST['addPriority'])){
        addPriority($_POST['client_id'],$_POST['goal'],$_POST['points'],$_POST['description']);
      echo  getPriorityGoals();
      }
       if(!empty($_POST["addEvent"])) {
         $start_date=$_POST['start_date'].' '.$_POST['start_time'];
         $end_date=$_POST['end_date'].' '.$_POST['end_time'];

  addEvent($_POST['client_id'],$_POST['level_id'],$_POST['event'],$start_date,$end_date,$_POST['description']);
   exit;
  }

 if(!empty($_POST['addM1'])){
      
        addClientScorecard($_POST['client_id'],$_POST['leader'],$_POST['reporting_period'],$_POST['platinum'],$_POST['gold'],$_POST['diamond'],$_POST['silver'],$_POST['bronze'],$_POST['nickel']);
       echo countScorecards(1);
        exit;
    } 
    if(!empty($_POST['saveSummary'])){
      
        updateSummary($_POST['platinum'],$_POST['gold'],$_POST['diamond'],$_POST['silver'],$_POST['bronze'],$_POST['nickel']);
        exit;
    }
      if(!empty($_POST['addM2'])){
      
        addM2Scorecard($_POST['client_id'],$_POST['reporting_period'],$_POST['business_unit']);
    // echo "nyasha";
    echo countScorecards(2);
        exit;
    } 
    if(!empty($_POST['addM3'])){
      
        addM3Scorecard($_POST['client_id'],$_POST['reporting_period'],$_POST['business_unit'], $_POST['department_id'],$_POST['owner']);
        //echo "zlatan";
        echo countScorecards(3);
        exit;
    } 
    if(!empty($_POST['addM4'])){
      
        addM4Scorecard($_POST['client_id'],$_POST['employee']);
        echo getEmployeesWithoutScorecards();
        exit;
    } 
      if(!empty($_POST['addmyscorecard'])){
      
        addMyScorecard($_POST['client_id'],$_POST['reporting_period'],$_POST['employee'],$_POST['business_unit'],$_POST['department_id']);
        exit;
    } 

       if(!empty($_POST['custodianChanges'])){
      
        updateCustodian($_POST['custodian'],$_POST['scorecard_id']);
        echo getBscorecards();
        exit;
    } 

         if(isset($_POST['assignedChange'])){
      
        updateAssigned($_POST['assigned'],$_POST['task_id']);
         echo getInitials(getEmployeeName($_POST['assigned']));
        exit;
    } 

    
         if(!empty($_POST['dueDateChange'])){
      
        updateDueDate($_POST['date'],$_POST['task_id']);
         echo $_POST['date'];
        exit;
    } 

      if(!empty($_POST['completionChange'])){
      
        updateCompletion($_POST['completion'],$_POST['task_id']);
         echo $_POST['completion'];
        exit;
    } 

          if(!empty($_POST['achieveCard'])){
      
        achieveCard($_POST['project_id']);
        getSingleCardToAppend($_POST['employee_id']);
         //echo $_POST['project_id'];
        exit;
    } 


          if(!empty($_POST['restoreCard'])){
      
        restoreCard($_POST['project_id']);
        getSingleCardToAppend($_POST['employee_id']);
         //echo $_POST['project_id'];
        exit;
    } 

          if(!empty($_POST["lockScorecards"])) {
  lockScorecards($_POST['lock']);
   exit;
  }

      if(!empty($_POST['addAssignment'])){
      
        addAssignment($_POST['user_id'],$_POST['activity'],$_POST['measure_of_success'],$_POST['impact'],$_POST['cf'],$_POST['due_date']);
        exit;
    } 

if(!empty($_POST["changeMailStatus"])) {
  changeMailStatus($_POST['mail_id']);
   exit;
  }




if(!empty($_POST["rf"])) {
	  $reporting_frequency = $_POST['rf'];
	  $measure_id=$_POST['measure_id'];
	 update_rf($reporting_frequency,$measure_id);
	 exit;
	} 
  // update weekly
    if(isset($_POST["amount"])) {
    $measure_id=$_POST['measure_id'];
    $amount=$_POST['amount'];
    $week_id=$_POST['week_id'];
    insertWeeklyAmount($amount,$measure_id,$week_id);
    exit;
   }
    if(!empty($_POST["week"])) {
    $measure_id=$_POST['measure_id'];
    $week=$_POST['week'];
    $week_id=$_POST['week_id'];
    insertWeek($week,$measure_id,$week_id);
    exit;
   } 
   // update monthly
    if(isset($_POST["mamount"])) {
    $measure_id=$_POST['measure_id'];
    $amount=$_POST['mamount'];
    $month_id=$_POST['month_id'];
    echo $amount;
    insertMonthlyAmount($amount,$measure_id,$month_id);
    exit;
   }
    if(!empty($_POST["month"])) {
    $measure_id=$_POST['measure_id'];
    $month=$_POST['month'];
    $month_id=$_POST['month_id'];
    insertMonth($month,$measure_id,$month_id);
    exit;
   } 
  // update quarterly
    if(isset($_POST["qamount"])) {
    $measure_id=$_POST['measure_id'];
    $amount=$_POST['qamount'];
    $quarter_id=$_POST['quarter_id'];
    insertQuarterlyAmount($amount,$measure_id,$quarter_id);
    exit;
   }
    if(!empty($_POST["quarter"])) {
    $measure_id=$_POST['measure_id'];
    $quarter=$_POST['quarter'];
    $quarter_id=$_POST['quarter_id'];
    insertQuarter($quarter,$measure_id,$quarter_id);
    exit;
   } 
   // update half yearly
     if(isset($_POST["hamount"])) {
    $measure_id=$_POST['measure_id'];
    $amount=$_POST['hamount'];
    $half_id=$_POST['half_id'];
    insertHalflyAmount($amount,$measure_id,$half_id);
    exit;
   }
    if(!empty($_POST["half"])) {
    $measure_id=$_POST['measure_id'];
    $half=$_POST['half'];
    $half_id=$_POST['half_id'];
    insertHalf($half,$measure_id,$half_id);
    exit;
   } 
   //delete functions
    if(!empty($_POST["deleteWeek"])) {
    $week_id=$_POST['deleteWeek'];
    $measure_id=$_POST['measure_id'];

    removeWeekly($week_id,$measure_id);
    exit;
   } 

    if(!empty($_POST["deleteMonth"])) {
    $month_id=$_POST['deleteMonth'];
    $measure_id=$_POST['measure_id'];

    removeMonthly($month_id,$measure_id);
    exit;
   } 
      if(!empty($_POST["deleteQuarter"])) {
    $quarter_id=$_POST['deleteQuarter'];
    $measure_id=$_POST['measure_id'];

    removeQuarterly($quarter_id,$measure_id);
    exit;
   } 
      if(!empty($_POST["deleteHalf"])) {
    $half_id=$_POST['deleteHalf'];
    $measure_id=$_POST['measure_id'];

    removeHalfYearly($half_id,$measure_id);
    exit;
   } 

   if(!empty($_POST['uploadFile'])){

  if($_FILES['evidence']['error']==0){

 $evidence = rand(1000,100000)."-".$_FILES['evidence']['name'];
 $location = $_FILES['evidence']['tmp_name'];
 $size = $_FILES['evidence']['size'];
 $type = $_FILES['evidence']['type'];
 $folder="../evidence/";
 $link= "../evidence";
 $evidence="$link/".$evidence;
 move_uploaded_file($location,$folder.$evidence);
 updateActionPlans($_POST['scorecard_id'],$_POST['goal_id'], $_POST['activity'], $_POST['measure'], $_POST['deadline'], $_POST['employee'],$_POST['status'], $evidence, $_POST['goal_id']);
}



   }



if(!empty($_POST['getProjectsTable'])){

 echo getProjectsTable($_POST['scope'],$_POST['status']);

}

if(!empty($_POST["employee_id"])) {

    $title = $_POST['title'];
    $employee_id = $_POST['employee_id'];
   //addcard($title,$employee_id);
    $conn=dbconnect();
    $stmt = $conn->prepare("INSERT INTO bsc_projects (client_id, name, manager) VALUES (?,?,?)");
    $stmt->bind_param('isi',$_SESSION['client_id'], $title,$employee_id);
    $stmt->execute();
    $stmt->close();
    // $card_id = $conn->insert_id;
   
   getSingleCardToAppend($employee_id);  
   exit;
  }

  if(!empty($_POST['deleteTask'])){
       deleteTask($_POST['task_id']);
  echo getProjectTasks($_POST['project_id']);
  exit;
}

  if(isset($_POST['setSessions'])){
     echo  setSessions($_POST['client_code']);
 // echo getProjectTasks($_POST['project_id']);
  exit;
}

  
    if(isset($_POST['change_password'])){

          passwordChange($_POST['old_password'], $_POST['new_password']);
 
    exit(); 

  }
?>