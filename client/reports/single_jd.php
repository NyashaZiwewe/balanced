<?php

	require_once 'vendor/autoload.php';

	// Creating the new document...
	$phpWord = new \PhpOffice\PhpWord\PhpWord();

//set default font name
 	$phpWord->setDefaultFontName('Palatino Linotype');
 	$phpWord->setDefaultFontSize(12);
     $phpWord->setDefaultParagraphStyle(array('align' => 'both'));

 	$phpWord->addTitleStyle(1, array('size' => 36.5, 'bold' => false), array('alignment' => 'center'));
 	$phpWord->addTitleStyle(2, array(), array('alignment' => 'left'));
 	$phpWord->addTitleStyle(3, array('size' => 13), array('alignment' => 'left'));


		// Begin code
	$section = $phpWord->addSection();

//	add ipc logo
	$section->addImage('img/ipc.png', array('width' => 250, 'height' => 120, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));

	   $grading_system=$_GET['system'];
	   $grade=$_GET['grade'];
   //$justification='';
if($grading_system=='Castellion'){
	   if($grade==1){

	   	$justification='The incumbent is part of the Senior executives and professionals entrusted with the overall control of the organisation and the attainment of financial and performance objectives. Discretion is given to draw one’s own objectives, to set priorities and develop the resources of the organisation. Included are top professional advisors, responsible for interpreting a key speciality to a Board of Council as well as formulating long range plans and providing long range evaluations extending well over three years. Group of senior executives in direct contact with the Board or Council, entrusted with the operations of the organisation and holding ultimate responsibility for critical functions. Broadly speaking, the incumbent is in charge of a group which is charged with the interpretation of organisational and national demands, assessing the performance contribution and value of the institution and deciding what overall objectives will meet these demands and ensure the survival of the organisation. 
	        <w:br/><w:br/>
	        Period of discretion is beyond three years.';

	   }elseif($grade==2){

	   $justification='The incumbent is part of the Senior executives and professionals entrusted with the overall control of the organisation and the attainment of financial and performance objectives. Discretion is given to draw one’s own objectives, to set priorities and develop the resources of the organisation. Included are top professional advisors, responsible for interpreting a key speciality to a Board of Council as well as formulating long range plans and providing long range evaluations extending well over three years. Group of senior executives in direct contact with the Board or Council, entrusted with the operations of the organisation and holding ultimate responsibility for critical functions. Broadly speaking, the incumbent is part of a group which is charged with the interpretation of organisational and national demands, assessing the performance contribution and value of the institution and deciding what overall objectives will meet these demands and ensure the survival of the organisation. 
	        <w:br/><w:br/>
	       Period of discretion is beyond three years.';
	   
	   }
	   elseif($grade==3){

	   $justification='The incumbent is part of senior, professional and managerial positions. They involve either the control of a self-contained department, or else encompass expertise in a complex and important function. Current policy is critically evaluated, new procedures are innovated within own area of control or expertise and broad objectives are translated into specific plans of action. Complex objectives may be set 
	         <w:br/><w:br/>
	       Period of discretion up to three years';
	   }
	   elseif($grade==4){

	   $justification='The incumbent has scope for independent decisions and becoming involved in risks for which one is accountable. Risks are taken and decisions are recommended within broad constraints. Substantial professional competence may be required as there are often no organisational backstops. 
	         <w:br/><w:br/>
	       Period of discretion up to eighteen months.';
	   }
	   elseif($grade==5){

	   $justification='The incumbent requires professional competence and managerial skills - a number of activities are performed which combine into the independent exercise of a special function. These activities cannot be encompassed in detail by the reviewing person. Objectives involve the specialised application of broad objectives set for departments and the organisation as a whole and they are reviewed in consequence by one or, at the most, two organisation levels. 
	        <w:br/><w:br/>
	       Period of discretion up to one year';
	   }
	   elseif($grade==6){

	   $justification='Job incumbents holding positions at this level accept the inevitability of risks posed by operating with uncertain data and unclear precedent. Included in this grade are positions requiring expert knowledge in a limited area of professional competence. Objectives would include some responsibility for the control as well as the development of people. 
	         <w:br/><w:br/>
	       Period of discretion up to nine months';
	   }
	   elseif($grade==7){

	   $justification='Job incumbents holding positions at this level accept the inevitability of risks posed by operating with uncertain data and unclear precedent. Included in this grade are positions requiring expert knowledge in a limited area of professional competence. Objectives would include some responsibility for the control as well as the development of people. 
	         <w:br/><w:br/>
	       Period of discretion up to nine months';
	   }
	   elseif($grade==8){

	   $justification='Positions at this level independent action and the willingness to take limited risks. Objectives become intricate and cover such activities as experimenting with new systems, supervising complex activities and ensuring the productive use of tangible and intangible resources.';
	   }
	   elseif($grade==9){

	   $justification='Tasks at this level vary somewhat from day to day and even within the same day. Some re-planning may be  necessary, skills are more substantial, are acquired over a number of years and require the interpretation of principles which are systematically derived';
	   }
	   elseif($grade==10){

	   $justification='Tasks are varied and complex. They group themselves into objectives of a limited nature, requiring some initiative. Skills based on practical know-how with little or no theoretical background. Estimates are usually reasoned out or problems thought through on the basis of accumulated past experience ';
	   }
	   elseif($grade==11){

	   $justification='Tasks are broadly repetitive, but have become somewhat more complex. They require the co-ordination of data, the interpretation of instructions and the development of work procedures around some basic skills';
	   }
	   elseif($grade==12){

	   $justification='Tasks are variable but not very complicated. They require acquisition of elementary skills which the worker exercises on his own. There is a choice between lines of action (they vary somewhat from each other, but are fairly clearly defined). There is not much scope for discretion - decisions characterised by the use of simple check lists.';
	   }elseif($grade >=13 && $grade<=16){

	   	$justification='Jobs requiring little education, but a definite period of on-the-job-training of up to three months. Worker acquires elementary appreciation of technical procedures - or shows competence in longer, varied tasks, but these are essentially repetitive.';
	   }
	   else{
	   $justification='Grade not Recognised';
	   }
  }

  elseif ($grading_system='Patterson') {

  	  if($grade=='E'){

	   $justification='The complexity of work at this level arises from the need as a management team, to optimise resource allocation/utilisation across the company, and to translate strategy into action and performance. Teamwork and leadership are key components to effectiveness at the senior management level. The senior management team develops the long-term plan (normally 5 plus years) for the organisation as a whole. The team decides on priorities and operational objectives for major functions, the relationship between major functions, the co-ordination of action and the allocation of new/exiting resources across the major functions and amongst departments and projects.';
	   }
	   elseif($grade=='D'){

	   $justification='The incumbent makes interpretive decisions. Understands the detailed operations/ processes of own business/ function area, and where necessary, the operational coordination and integration of other related functions of the business within the organisation. The complexity of the work is the coordinated development of work design, organisation, operational/ business plans, budget and the management of the day to day operations.';
	   }
	   elseif($grade=='C'){

	   $justification='The incumbent makes routine decisions. Once the rules have been set by the interpretive decision, execution begins. What is to be done has already been decided and the next level of decision – routine – is the choice of way in which it is to be carried out from established processes, practise, systems, trade knowledge and rules and regulations. People taking these decisions can decide which process to use. The job incumbents know the operations. The job incumbents must decide’ how, where and when.';
	   }
	   elseif($grade=='B'){

	   $justification='The incumbent makes automatic decisions. This involves work in which the processes are defined and freedom of choice is restricted to operations. Within the routines and procedures of the job – the ‘how’ the worker can decide where and when he carries out the operations that constitute the process.';
	   }elseif($grade =='A'){

	   	$justification='The job incumbent is told what is to be done, why, where and when. The work usually involves using basic tools and/or equipment to fulfil parts of the operation. Work is normally carried under direct supervision, and the job incumbent rarely has to understand the interrelationship of his/her job with others.';
	   }
	   else{
	   $justification='Grade not Recognised';
	   }

  	
  }
  else{

   $justification='Incompatible Grading System. The system only have reports for Patterson and Castellion.';
  }

 	$section->addTextBreak(1);

// 	add the paragraph
	$section->addText(
	    'Please refer below for the job grading result for the position:',
	    null,
	    array('alignment'=>'both', 'widowControl' => false)
	);

	//set the date format
	date_default_timezone_set("Africa/Harare");
	$date=date('Y-m-d');
	//$reportingperiod='January to '.getReportingPeriod($sid);

	//add table
	$tableStyle = array('borderSize' => 1, 'borderColor' => 'white', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0);
	$styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'white','borderLeftSize'=>1,'borderLeftColor' =>'white','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomSize' =>1,'borderBottomColor'=>'white' ,'bgcolor'=> '175EA8');
	$TstyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'white','borderLeftSize'=>1,'borderLeftColor' =>'white','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomSize' =>1,'borderBottomColor'=>'white' ,'bgcolor'=> 'DEEAF6','spaceBefore' => 10);
	$fontStyle = array('color'=> 'black', 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left');
	$TfontStyle = array('bold'=>true, 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left', 'color'=>'white');
	$noSpace = array('textBottomSpacing' => -1);        
	$table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => 'white', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0  ));
	$table2 = $section->addTable('myOwnTableStyle');
	$table->addRow(-0.5, array('exactHeight' => -5));
	$table->addCell(2000,$styleCell)->addText('<w:br/>Job Title',$TfontStyle);
	$table->addCell(8000,$TstyleCell)->addText('<w:br/> Head of Agribusiness',$fontStyle);
	$table->addRow();
	$table->addCell(2000,$styleCell)->addText('<w:br/> Organisation',$TfontStyle);
	$table->addCell(8000,$TstyleCell)->addText('<w:br/> IPC',$fontStyle);
	$table->addRow();
	$table->addCell(2000,$styleCell)->addText('<w:br/> Grade',$TfontStyle);
	$table->addCell(8000,$TstyleCell)->addText('<w:br/> '.$grade,$fontStyle);
	$table->addRow();
	$table->addCell(2000,$styleCell)->addText('<w:br/> Grading System',$TfontStyle);
	$table->addCell(8000,$TstyleCell)->addText('<w:br/>'.$grading_system,$fontStyle);
    $table->addRow();
	$table->addCell(2000,$styleCell)->addText('<w:br/> Justification',$TfontStyle);
	$table->addCell(8000,$TstyleCell)->addText('<w:br/>'.$justification,$fontStyle);

 	$section->addTextBreak(1);

	// Add footer
	$footer = $section->addFooter();
	$footer->addImage('img/footer.png', array('width' => 690, 'height' => 50, 'alignment' =>  \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

	// Saving the document as OOXML file...
	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
 	$repname = 'reports/jds/Head of Agribusiness - IPC.docx';
 	$objWriter->save($repname);
?>