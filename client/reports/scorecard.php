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

	// Add first page header
	$header = $section->addHeader();
	$header->firstPage();
	$table = $header->addTable();
	$table->addRow();
	$cell = $table->addCell(4500);
	$textrun = $cell->addTextRun();
	$textrun->addText('');



     $sid=$_GET['sid'];

	// Add header for all other pages
	$subsequent = $section->addHeader();
 	$subsequent->addText(getOwner($sid), array('size' => 11, 'bold' => false), array('alignment' => 'right'));

	// Add footer
	$footer = $section->addFooter();
	$footer->addLine(
	    array(
	        'width'       => 600,
	        'height'      => 0,
	        'positioning' => 'absolute',
	        'color'       => '#175EA8',
	        'weight'	  => '3',
	        'spaceAfter' => 0,
	    )
	);
	$footer->addText('Prepared by Industrial Psychology Consultants. Email: ipc@ipcconsultants.com', array('size' => 10, 'bold' => false), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
	$footer->addPreserveText('{PAGE}', array('size' => 11, 'bold' => false), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT));

	//add ipc logo
//	$section->addImage('img/logo.jpg', array('width' => 250, 'height' => 120, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));


	//add the first heading
	$section->addLine(
	    array(
	        'width'       => 600,
	        'height'      => 0,
	        'positioning' => 'absolute',
	        'color'       => '#175EA8',
	        'weight'	  => '2',
	    )
	);
	$textrun = $section->addTextRun('Heading1');
	$textrun->addText('Performance Appraisal Report', array("color" => "175EA8"));
	$section->addLine(
	    array(
	        'width'       => 600,
	        'height'      => 0,
	        'positioning' => 'absolute',
	        'color'       => '#175EA8',
	        'weight'	  => '2',
	    )
	);

	//add the second heading
	$textrun = $section->addTextRun('Heading3');
	$textrun->addText('Confidential', array("color" => "175EA8", 'underline' => 'double', 'size' => 22, 'bold' => false, 'italic' => true));

// 	add the paragraph
	$section->addText(
	    'The information in this report is confidential and must not be made known to anyone other than authorised personnel, unless released by expressed written permission. The Information must be considered together with all information gathered in the assessment process.',
	    null,
	    array('alignment'=>'both', 'widowControl' => false)
	);

	//set the date format
	date_default_timezone_set("Africa/Harare");
	$date=date('Y-m-d');
	$reportingperiod='January to '.getReportingPeriod($sid);

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
	$table->addCell(4000,$styleCell)->addText('<w:br/>Owner Name:',$TfontStyle);
	$table->addCell(6000,$TstyleCell)->addText('<w:br/> '.ucwords(getOwner($_GET['sid'])),$fontStyle);
	$table->addRow();
	$table->addCell(4000,$styleCell)->addText('<w:br/> Period Under Review:',$TfontStyle);
	$table->addCell(6000,$TstyleCell)->addText('<w:br/> '.$reportingperiod,$fontStyle);
	$table->addRow();
	$table->addCell(4000,$styleCell)->addText('<w:br/> Date Extracted:',$TfontStyle);
	$table->addCell(6000,$TstyleCell)->addText('<w:br/> '.$date,$fontStyle);

// 	$section->addTextBreak(1);


		// Begin code
 	$section = $phpWord->addSection();

	if(getScorecardLevel($sid)==4){

		//add the third heading
	$textrun = $section->addTextRun('Heading2');
	$textrun->addText('Relative Performance on each perspective', array("color" => "175EA8", 'size' => 16, 'bold' => true));
	$section->addLine(
	    array(
	        'width'       => 600,
	        'height'      => 0,
	        'positioning' => 'absolute',
	        'color'       => '#175EA8',
	        'weight'	  => '2',
	    )
	);

	//add table
	$tableStyle = array('borderSize' => 1, 'borderColor' => 'white', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0);
	$styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'white','borderLeftSize'=>1,'borderLeftColor' =>'white','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomSize' =>1,'borderBottomColor'=>'white' ,'bgcolor'=> '8EAADB');
	$TstyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'white','borderLeftSize'=>1,'borderLeftColor' =>'white','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomSize' =>1,'borderBottomColor'=>'white' ,'bgcolor'=> 'DEEAf6');
	$fontStyle = array('color'=> 'black', 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left');
	$TfontStyle = array('bold'=>true, 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left', 'color'=>'black');
	$noSpace = array('textBottomSpacing' => -1);        
	$table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => 'white', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0  ));
	$table2 = $section->addTable('myOwnTableStyle');
	$table->addRow(-0.5, array('exactHeight' => -5));
	$table->addCell(10000,$styleCell)->addText('Categories of Rating Scores: <w:br/>',$TfontStyle);
	$table->addRow(-0.5, array('exactHeight' => -5));
	$table->addCell(10000,$TstyleCell)->addListItem('A ranking score below 40% indicates an extremely low level of performance in comparison with the representative sample of employees in the organisation. <w:br/>',0, $fontStyle);
	$table->addRow(-0.5, array('exactHeight' => -5));
	$table->addCell(10000,$TstyleCell)->addListItem('A percentile rank of 25 – 49 reflects a relatively low level of performance in comparison with the representative sample.<w:br/>',0, $fontStyle);
	$table->addRow(-0.5, array('exactHeight' => -5));
	$table->addCell(10000,$TstyleCell)->addListItem('A percentile rank of 50 – 74 reflects a fairly competitive performance by comparing the employee with the representative sample.<w:br/>',0, $fontStyle);
	$table->addRow(-0.5, array('exactHeight' => -5));
	$table->addCell(10000,$TstyleCell)->addListItem('A percentile rank of 75 and above reflects a high level of performance for the individual in question in comparison with the representative sample.<w:br/>',0, $fontStyle);
	$section->addTextBreak(1);

}

    		//add the third heading
	$textrun = $section->addTextRun('Heading2');
	$textrun->addText('Absolute Performance on each perspective', array("color" => "175EA8", 'size' => 16, 'bold' => true));
	$section->addLine(
	    array(
	        'width'       => 600,
	        'height'      => 0,
	        'positioning' => 'absolute',
	        'color'       => '#175EA8',
	        'weight'	  => '2',
	    )
	);

      
 	$table = $section->addTable('myOwnTableStyle3',array('borderSize' => 1, 'borderColor' => 'white', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0  ));

    $table3 = $section->addTable('myOwnTableStyle3');
	$table->addRow(-0.5, array('exactHeight' => -5));
	$table->addCell(10000,$TstyleCell)->addListItem('A negative score (below 0%) indicates an extremely low level of performance. Attention is required in such circumstances <w:br/>',0, $fontStyle);
	$table->addRow(-0.5, array('exactHeight' => -5));
	$table->addCell(10000,$TstyleCell)->addListItem('A percentile rank of 25 – 49 reflects a relatively low level of employee satisfaction on the element in question by comparison with the representative sample.<w:br/>',0, $fontStyle);
	$table->addRow(-0.5, array('exactHeight' => -5));
	$table->addCell(10000,$TstyleCell)->addListItem('A percentile rank of 50 – 74 reflects a fairly condusive environment in respect of the rated element in question by comparing it with the representative sample.<w:br/>',0, $fontStyle);
	$table->addRow(-0.5, array('exactHeight' => -5));
	$table->addCell(10000,$TstyleCell)->addListItem('A percentile rank of 75 and above reflects a high level of performance for the rating element in question in comparison with the representative sample.<w:br/>',0, $fontStyle);
	

	$section->addTextBreak(1);

	// Begin code
	$section = $phpWord->addSection();

	//add the third heading
	$textrun = $section->addTextRun('Heading2');
	$textrun->addText('Summary of Results', array("color" => "175EA8", 'size' => 16, 'bold' => true));
	$section->addLine(
	    array(
	        'width'       => 600,
	        'height'      => 0,
	        'positioning' => 'absolute',
	        'color'       => '#175EA8',
	        'weight'	  => '2',
	    )
	);

	//add table
	$tableStyle = array('borderSize' => 1, 'borderColor' => 'white', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0);
	$styleCell0 = array('borderTopSize'=>2 ,'borderLeftSize'=>1,'borderLeftColor' =>'002060','borderRightSize'=>2,'borderRightColor'=>'002060','borderTopColor'=>'002060' ,'bgcolor'=> 'DDEBF7', 'color'=>'002060');
	$styleCell00 = array('borderLeftSize'=>1,'borderBottomSize' =>1,'borderBottomColor'=>'002060' , 'borderLeftColor' =>'002060','borderRightSize'=>1,'borderRightColor'=>'002060','bgcolor'=> 'DDEBF7', 'color'=>'002060');
	$styleCell = array('borderLeftSize'=>1,'borderLeftColor'=>'002060','borderTopSize'=>1 ,'borderRightSize'=>1,'borderRightColor'=>'002060','borderBottomSize' =>1,'borderBottomColor'=>'808080' , 'borderTopColor'=>'808080' ,'bgcolor'=> 'DDEBF7', 'color'=>'002060');
	$styleCell2 = array('borderTopSize'=>1 ,'borderRightSize'=>1,'borderRightColor'=>'002060','borderBottomSize' =>1,'borderBottomColor'=>'002060' , 'borderTopColor'=>'002060' ,'bgcolor'=> 'DDEBF7', 'color'=>'002060');
	$styleCell1 = array('borderTopSize'=>2,'borderLeftSize'=>2,'borderLeftColor'=>'002060','borderBottomSize' =>1,'borderBottomColor'=>'002060' , 'borderTopColor'=>'002060' ,'bgcolor'=> 'DDEBF7', 'color'=>'002060');
	$styleCell1_2 = array('borderTopSize'=>1 ,'borderBottomSize' =>1,'borderBottomColor'=>'002060' , 'borderTopColor'=>'002060' ,'bgcolor'=> 'DDEBF7', 'color'=>'002060');
	$TstyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'002060','borderLeftSize'=>1,'borderLeftColor' =>'002060','borderRightSize'=>1,'borderRightColor'=>'002060','borderBottomSize' =>1,'borderBottomColor'=>'002060' ,'bgcolor'=> 'green');
	$fontStyle = array('color'=> 'black', 'size'=>10, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left');
	$TfontStyle1 = array('bold'=>true, 'size'=>11, 'italic' => false, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'center', 'color'=>'black');
	$TfontStyle = array('bold'=>false, 'size'=>10, 'italic' => true, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left', 'color'=>'black');
	//for red cells
	$styleCellred = array('borderTopSize'=>1 ,'borderLeftSize'=>1,'borderLeftColor' =>'white','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomSize' =>1,'borderBottomColor'=>'white' , 'borderTopColor'=>'white' ,'bgcolor'=> 'FF0000', 'color'=>'white');
	$styleCellwhite = array('borderTopSize'=>1 ,'borderLeftSize'=>1,'borderLeftColor' =>'002060','borderRightSize'=>1,'borderRightColor'=>'002060','borderBottomSize' =>1,'borderBottomColor'=>'002060' , 'borderTopColor'=>'002060' ,'bgcolor'=> 'white', 'color'=>'white');
	$Tfontred = array('bold'=>true, 'size'=>10, 'alignment'=> 'center', 'color'=>'white');
	$Tfontwhite = array('bold'=>true, 'size'=>12, 'alignment'=> 'center', 'color'=>'white');
	$Tfontblack = array('bold'=>true, 'size'=>10, 'alignment'=> 'center', 'color'=>'white', 'bgcolor' => 'black');
	//for orange cells
	$styleCellorange =  array('borderTopSize'=>1 ,'borderLeftSize'=>1,'borderLeftColor' =>'E0D4B0','borderRightSize'=>1,'borderRightColor'=>'E0D4B0','borderBottomSize' =>1,'borderBottomColor'=>'E0D4B0' , 'borderTopColor'=>'E0D4B0' ,'bgcolor'=> 'FFC000', 'color'=>'black');
	$styleCellorange1 = array('borderTopSize'=>5 ,'borderBottomSize'=>5 ,'borderLeftSize'=>1,'borderLeftColor' =>'white','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomColor'=>'white' , 'borderTopColor'=>'white' ,'bgcolor'=> 'FFC000', 'color'=>'black');
	$Tfontorange = array('bold'=>true, 'size'=>10, 'alignment'=> 'center', 'color'=>'black');
	$noSpace = array('textBottomSpacing' => -1);       
	//for yellow cells
	 $styleCellyellow =   array('borderTopSize'=>1 ,'borderLeftSize'=>1,'borderLeftColor' =>'E0D4B0','borderRightSize'=>1,'borderRightColor'=>'E0D4B0','borderBottomSize' =>1,'borderBottomColor'=>'E0D4B0' , 'borderTopColor'=>'E0D4B0' ,'bgcolor'=> 'FFFF00', 'color'=>'black');
	 $styleCellyellow1 = array('borderTopSize'=>5 ,'borderBottomSize'=>5 ,'borderLeftSize'=>1,'borderLeftColor' =>'white','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomColor'=>'002060' , 'borderTopColor'=>'002060' ,'bgcolor'=> 'FFFF00', 'color'=>'black');
	 $styleCellblack = array('borderTopSize'=>1 ,'borderLeftSize'=>1,'borderLeftColor' =>'002060','borderRightSize'=>1,'borderRightColor'=>'002060','borderBottomSize' =>1,'borderBottomColor'=>'002060' , 'borderTopColor'=>'002060' ,'bgcolor'=> 'black', 'color'=>'white');
	 //for blue cells
	 $styleCellblue =   array('borderTopSize'=>1 ,'borderLeftSize'=>1,'borderLeftColor' =>'E0D4B0','borderRightSize'=>1,'borderRightColor'=>'E0D4B0','borderBottomSize' =>1,'borderBottomColor'=>'E0D4B0' , 'borderTopColor'=>'E0D4B0' ,'bgcolor'=> '#175ea8', 'color'=>'fff');
	 $styleCellblue1 = array('borderTopSize'=>5 ,'borderBottomSize'=>5 ,'borderLeftSize'=>1,'borderLeftColor' =>'white','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomColor'=>'002060' , 'borderTopColor'=>'002060' ,'bgcolor'=> '5B9BD5', 'color'=>'white');
	  //for green cells
	 $styleCellgreen =   array('borderTopSize'=>1 ,'borderLeftSize'=>1,'borderLeftColor' =>'E0D4B0','borderRightSize'=>1,'borderRightColor'=>'E0D4B0','borderBottomSize' =>1,'borderBottomColor'=>'E0D4B0' , 'borderTopColor'=>'E0D4B0' ,'bgcolor'=> '00B050', 'color'=>'white');
	
	$noSpace = array('textBottomSpacing' => -1); 
	$table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => '002060', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0  ));
	$table2 = $section->addTable('myOwnTableStyle');
	$table->addRow(-0.5, array('exactHeight' => -5));
	$table->addCell(1000,$styleCell0)->addText('<w:br/> Perspective score',$TfontStyle1);	
	$table->addCell(1000,$styleCell1)->addText('',$TfontStyle1);	
	$table->addCell(1000,$styleCell1_2)->addText('',$TfontStyle1);	
	$table->addCell(1000,$styleCell1_2)->addText('',$TfontStyle1);	
	$table->addCell(1000,$styleCell1_2)->addText('',$TfontStyle1);
	$table->addCell(1000,$styleCell1_2)->addText('',$TfontStyle1);
	$table->addCell(1000,$styleCell1_2)->addText('',$TfontStyle1);
	$table->addRow(-0.5, array('exactHeight' => -5));
	$table->addCell(1000,$styleCell00)->addText('',$TfontStyle1);	

	$table->addCell(1000,$styleCellred)->addText('Nickel',$Tfontred, array('alignment'=> 'center'));
	$table->addCell(1000,$styleCellorange1)->addText('Bronze',$Tfontorange, array('alignment'=> 'center'));	
	$table->addCell(1000,$styleCellblue1)->addText('Silver',$Tfontred, array('alignment'=> 'center'));	
	$table->addCell(1000,$styleCellgreen)->addText('Diamond',$Tfontred, array('alignment'=> 'center'));
	$table->addCell(1000,$styleCellgreen)->addText('Gold',$Tfontred, array('alignment'=> 'center'));	
	$table->addCell(1000,$styleCellgreen)->addText('Platinum',$Tfontred, array('alignment'=> 'center'));		
   	
     
      $conn=dbconnect();
  $scorecard_id=$_GET['sid'];
  $stmt=$conn->prepare("SELECT DISTINCT(perspective_id) FROM bsc_goals LEFT JOIN bsc_scorecards ON bsc_scorecards.id=scorecard_id WHERE bsc_scorecards.id=?");
  $stmt->bind_param('i',$scorecard_id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($perspective_id);
  While($stmt->fetch()){


		$table->addRow(-0.5, array('exactHeight' => -5));
		$table->addCell(6000,$styleCell)->addText(getPerspectivename($perspective_id),$TfontStyle);
		if(getWR($scorecard_id,$perspective_id) < 0 )   {
			$table->addCell(1000,$styleCellred)->addText(getWR($scorecard_id,$perspective_id).'%',$Tfontblack, array('alignment'=> 'center'));
		}
		else{
			$table->addCell(1000,$styleCellred)->addText('',$Tfontred, array('alignment'=> 'center'));
		}
	    if(getWR($scorecard_id,$perspective_id) >=0 && getWR($scorecard_id,$perspective_id) < 20 ){
			$table->addCell(1000,$styleCellorange1)->addText(getWR($scorecard_id,$perspective_id).'%',$Tfontblack, array('alignment'=> 'center'));
		}
		else{
			$table->addCell(1000,$styleCellorange1)->addText('',$Tfontred, array('alignment'=> 'center'));
		}
		  if(getWR($scorecard_id,$perspective_id) >=20 && getWR($scorecard_id,$perspective_id) < 40 ){
			$table->addCell(1000,$styleCellblue)->addText(getWR($scorecard_id,$perspective_id).'%',$Tfontblack, array('alignment'=> 'center'));
		}
		else{
			$table->addCell(1000,$styleCellblue)->addText('',$Tfontred, array('alignment'=> 'center'));
		}
		  if(getWR($scorecard_id,$perspective_id) >=40 && getWR($scorecard_id,$perspective_id) <60 ){
			$table->addCell(1000,$styleCellgreen)->addText(getWR($scorecard_id,$perspective_id).'%',$Tfontblack, array('alignment'=> 'center'));
		}
		else{
			$table->addCell(1000,$styleCellgreen)->addText('',$Tfontred, array('alignment'=> 'center'));
		}
		  if(getWR($scorecard_id,$perspective_id) >=60 && getWR($scorecard_id,$perspective_id) <80 ){
			$table->addCell(1000,$styleCellgreen)->addText(getWR($scorecard_id,$perspective_id).'%',$Tfontblack, array('alignment'=> 'center'));
		}
		else{
			$table->addCell(1000,$styleCellgreen)->addText('',$Tfontred, array('alignment'=> 'center'));
		}
		  if(getWR($scorecard_id,$perspective_id) >=80 && getWR($scorecard_id,$perspective_id) <=100 ){
			$table->addCell(1000,$styleCellgreen)->addText(getWR($scorecard_id,$perspective_id).'%',$Tfontblack, array('alignment'=> 'center'));
		}
		else{
			$table->addCell(1000,$styleCellgreen)->addText('',$Tfontred, array('alignment'=> 'center'));
		}		
		
}


     
//overal score row
     		$table->addRow(-0.5, array('exactHeight' => -5));
		$table->addCell(6000,$styleCell)->addText('Overall Score',$TfontStyle);
		if($sta < 0 )   {
			$table->addCell(1000,$styleCellred)->addText($sta.'%',$Tfontblack, array('alignment'=> 'center'));
		}
		else{
			$table->addCell(1000,$styleCellred)->addText('',$Tfontred, array('alignment'=> 'center'));
		}
	    if($sta >=0 && $sta < 20 ){
			$table->addCell(1000,$styleCellorange1)->addText($sta.'%',$Tfontblack, array('alignment'=> 'center'));
		}
		else{
			$table->addCell(1000,$styleCellorange1)->addText('',$Tfontred, array('alignment'=> 'center'));
		}
		  if($sta >=20 && $sta < 40 ){
			$table->addCell(1000,$styleCellblue)->addText($sta.'%',$Tfontblack, array('alignment'=> 'center'));
		}
		else{
			$table->addCell(1000,$styleCellblue)->addText('',$Tfontred, array('alignment'=> 'center'));
		}
		  if($sta >=40 && $sta <60 ){
			$table->addCell(1000,$styleCellgreen)->addText($sta.'%',$Tfontblack, array('alignment'=> 'center'));
		}
		else{
			$table->addCell(1000,$styleCellgreen)->addText('',$Tfontred, array('alignment'=> 'center'));
		}
		  if($sta >=60 && $sta <80 ){
			$table->addCell(1000,$styleCellgreen)->addText($sta.'%',$Tfontblack, array('alignment'=> 'center'));
		}
		else{
			$table->addCell(1000,$styleCellgreen)->addText('',$Tfontred, array('alignment'=> 'center'));
		}
		  if($sta >=80 && $sta <=100 ){
			$table->addCell(1000,$styleCellgreen)->addText($sta.'%',$Tfontblack, array('alignment'=> 'center'));
		}
		else{
			$table->addCell(1000,$styleCellgreen)->addText('',$Tfontred, array('alignment'=> 'center'));
		}	
	

 
 $section->addTextBreak(1);

if(getScorecardLevel($sid)==4){
    $textrun = $section->addTextRun('Heading6');
	$textrun->addText(getOwner($sid).'\'s Relative Performance', array("color" => "175EA8", 'size' => 16, 'bold' => true));
	$section->addLine(
	    array(
	        'width'       => 600,
	        'height'      => 0,
	        'positioning' => 'absolute',
	        'color'       => '#175EA8',
	        'weight'	  => '2',
	    )
	);

    $department_score=getTotalWR(getHisDeptScoreCard(getScoreCardDepartment($sid),$_SESSION['client_id']));
    $depart_name = getDepartmentName(getScoreCardDepartment($sid));
    $coporate_score= getTotalWR(getCoporateScorecard($_SESSION['client_id']));
    $diff_score= getTotalWR($sid) - $department_score;
    $diff_score2= getTotalWR($sid) - $coporate_score;
 

	$table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => '002060', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0  ));
	$table2 = $section->addTable('myOwnTableStyle');
	$table->addRow(1, array('exactHeight' => 1));
	
    $table->addCell(1000,$styleCellblue)->addText('Perspective',$Tfontwhite, array('alignment'=> 'center'));
	$table->addCell(1000,$styleCellblue)->addText('Score',$Tfontwhite, array('alignment'=> 'center'));
	$table->addCell(1000,$styleCellblue)->addText('Dept',$Tfontwhite, array('alignment'=> 'center'));	
	$table->addCell(1000,$styleCellblue)->addText('Deviation',$Tfontwhite, array('alignment'=> 'center'));	
	$table->addCell(1000,$styleCellblue)->addText('Company',$Tfontwhite, array('alignment'=> 'center'));
	$table->addCell(1000,$styleCellblue)->addText('Deviation',$Tfontwhite, array('alignment'=> 'center'));	
	// $table->addCell(1000,$styleCell)->addText('Platinum',$Tfontorange, array('alignment'=> 'center'));		
   	
     
     $conn=dbconnect();
  $scorecard_id=$_GET['sid'];
  $stmt=$conn->prepare("SELECT DISTINCT(perspective_id) FROM bsc_goals LEFT JOIN bsc_scorecards ON bsc_scorecards.id=scorecard_id WHERE bsc_scorecards.id=?");
  $stmt->bind_param('i',$scorecard_id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($perspective_id);
  While($stmt->fetch()){

  	 $dept_perspective_score= getWR(getHisDeptScoreCard(getScoreCardDepartment($scorecard_id),$_SESSION['client_id']),$perspective_id);
  	 $client_perspective_score =getWR(getCoporateScorecard($_SESSION['client_id']),$perspective_id);


  $diff_perspective_score= getWR($sid,$perspective_id) - $dept_perspective_score;
  $diff_perspective_score2= getWR($sid,$perspective_id) - $client_perspective_score;

  if($diff_perspective_score>0){
  	$cell = $styleCellgreen;
  } elseif($diff_perspective_score <0){
  	$cell= $styleCellred;
  }else{
  	$cell = $styleCell;
  }

    if($diff_perspective_score2>0){
  	$cell1 = $styleCellgreen;
  } elseif($diff_perspective_score2 <0){
  	$cell1= $styleCellred;
  }else{
  	$cell1 = $styleCell;
  }


		$table->addRow(-0.5, array('exactHeight' => -5));
		$table->addCell(4000,$styleCellwhite)->addText(getPerspectivename($perspective_id),$TfontStyle);
		$table->addCell(2000,$styleCellwhite)->addText(getWR($scorecard_id,$perspective_id).'%',$Tfontorange, array('alignment'=> 'center'));
		$table->addCell(2000,$styleCellwhite)->addText($dept_perspective_score.'%',$Tfontorange, array('alignment'=> 'center'));
		$table->addCell(2000,$cell)->addText($diff_perspective_score.'%',$Tfontorange, array('alignment'=> 'center'));
		$table->addCell(2000,$styleCellwhite)->addText($client_perspective_score.'%',$Tfontorange, array('alignment'=> 'center'));
		$table->addCell(2000,$cell1)->addText($diff_perspective_score2.'%',$Tfontorange, array('alignment'=> 'center'));

}
  $stmt->close();

  if($diff_score>0){
  	$cell = $styleCellgreen;
  } elseif($diff_score <0){
  	$cell= $styleCellred;
  }else{
  	$cell = $styleCell;
  }

    if($diff_score2>0){
  	$cell1 = $styleCellgreen;
  } elseif($diff_score2 <0){
  	$cell1= $styleCellred;
  }else{
  	$cell1 = $styleCell;
  }

		$table->addRow(-0.5, array('exactHeight' => -5));
		$table->addCell(4000,$styleCellwhite)->addText('Overall',$TfontStyle);
		$table->addCell(2000,$styleCellwhite)->addText(getTotalWR($sid).'%',$Tfontorange, array('alignment'=> 'center'));
		$table->addCell(2000,$styleCellwhite)->addText($department_score.'%',$Tfontorange, array('alignment'=> 'center'));
		$table->addCell(2000,$cell)->addText($diff_score.'%',$Tfontorange, array('alignment'=> 'center'));
		$table->addCell(2000,$styleCellwhite)->addText($coporate_score.'%',$Tfontorange, array('alignment'=> 'center'));
		$table->addCell(2000,$cell1)->addText($diff_score2.'%',$Tfontorange, array('alignment'=> 'center'));



	if(getTotalWR($sid) > $department_score){
		$comment='above';
	}elseif(getTotalWR($sid) == $department_score){
		$comment='at par with';
	} else{
		$comment='below';
	}

	$section->addTextBreak();
} 
if(getScorecardLevel($_GET['sid'])==4) {
		//add the paragraph
	$section->addText(
	    getOwner($sid).'\'s overall performance is '.getTotalWR($sid).'% which is '.$comment.' the department\'s performance. '.$depart_name.' has an average score of '.$department_score.'%.', null,
	    array('alignment'=>'both', 'widowControl' => false)
	);
}

    $textrun = $section->addTextRun('Heading7');
	$textrun->addText('Projects Worked on', array("color" => "175EA8", 'size' => 16, 'bold' => true));
	$section->addLine(
	    array(
	        'width'       => 600,
	        'height'      => 0,
	        'positioning' => 'absolute',
	        'color'       => '#175EA8',
	        'weight'	  => '2',
	    )
	);



    $stmt1 = $conn->prepare("SELECT id, name, manager, end_date,status FROM bsc_projects WHERE scorecard_id=?");
    $stmt1->bind_param('i',$scorecard_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($project_id,$name,$manager,$end_date,$status);
      if($stmt1->num_rows <1){ 
        $textrun = $section->addTextRun('Heading5');
      $textrun->addText('No projects were mentioned', array("color" => "ff0000", "bold" => true));
    }else{

    $table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => '#175ea8', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0  ));
	$table2 = $section->addTable('myOwnTableStyle');
	$table->addRow(-0.5, array('exactHeight' => -5));
	
    $table->addCell(6000,$styleCellblue)->addText('Project',$Tfontwhite, array('alignment'=> 'center'));
	$table->addCell(2000,$styleCellblue)->addText('Manager',$Tfontwhite, array('alignment'=> 'center'));
	$table->addCell(2000,$styleCellblue)->addText('Due Date',$Tfontwhite, array('alignment'=> 'center'));	
	$table->addCell(2000,$styleCellblue)->addText('status',$Tfontwhite, array('alignment'=> 'center'));	

    While($stmt1->fetch()){

  		$table->addRow(-0.5, array('exactHeight' => -5));
		$table->addCell(6000,$styleCellwhite)->addText($name,$Tfontorange,$cellColSpan, array('alignment'=> 'center'));
		$table->addCell(2000,$styleCellwhite)->addText(getEmployeeName($manager),$Tfontorange, array('alignment'=> 'center'));
		$table->addCell(2000,$styleCellwhite)->addText($end_date,$Tfontorange, array('alignment'=> 'center'));
		$table->addCell(2000,$styleCellwhite)->addText(getProjectStatusName($status),$Tfontorange, array('alignment'=> 'center'));
     
}
}
$stmt1->close();

	$section->addTextBreak(1);

    $textrun = $section->addTextRun('Heading2');
	$textrun->addText('Outstanding Action plans by project', array("color" => "175EA8", 'size' => 16, 'bold' => true));
	$section->addLine(
	    array(
	        'width'       => 600,
	        'height'      => 0,
	        'positioning' => 'absolute',
	        'color'       => '#175EA8',
	        'weight'	  => '2',
	    )
	);


  	$conn = dbconnect();
    
   if(getScorecardLevel($sid)==4){
    $stmt1 = $conn->prepare("SELECT DISTINCT(bsc_projects.id), name, manager FROM bsc_project_tasks LEFT JOIN bsc_projects ON bsc_projects.id=project_id WHERE scorecard_id=? AND completion <?");
    $stmt1->bind_param('ii',$sid,$complete);
    $complete=100;
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($project_id,$name,$manager);
    if($stmt1->num_rows <1){ 
        $textrun = $section->addTextRun('Heading5');
      $textrun->addText('No outstanding action plans', array("color" => "008140", "bold" => true));
    }else{
    While($stmt1->fetch()){

    $textrun = $section->addTextRun('Heading5');
    $textrun->addText(ucwords($name).' - Manager: '.getEmployeeName($manager), array("color" => "175EA8", "bold" => true));
     //$tasks.=$textrun;

    $stmt = $conn->prepare("SELECT id, task,  due_date, last_updated, status, completion FROM bsc_project_tasks WHERE project_id=? AND completion < ?");
    $stmt->bind_param('ii',$project_id,$complete);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id,$task,$due_date, $last_updated, $status, $completion);
    While($stmt->fetch()){
     
    	$section->addListItem(ucfirst($task .' ('.$completion.'%)'), 0);
   
  }
  $stmt->close();
  }  
}

$stmt1->close();
}
elseif(getScorecardLevel($sid)==1){

   $stmt1 = $conn->prepare("SELECT DISTINCT(bsc_projects.id), name, manager FROM bsc_project_tasks LEFT JOIN bsc_projects ON bsc_projects.id=project_id WHERE client_id =? AND completion < ?");
    $stmt1->bind_param('ii',$_SESSION['client_id'],$complete);
    $complete=100;
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($project_id,$name,$manager);
    if($stmt1->num_rows <1){ 
        $textrun = $section->addTextRun('Heading5');
      $textrun->addText('No outstanding action plans', array("color" => "008140", "bold" => true));
    }else{
    While($stmt1->fetch()){

    $textrun = $section->addTextRun('Heading5');
    $textrun->addText(ucwords($name).' - Manager: '.getEmployeeName($manager), array("color" => "175EA8", "bold" => true));
     //$tasks.=$textrun;

    $stmt = $conn->prepare("SELECT id, task,  due_date, last_updated, status, completion FROM bsc_project_tasks WHERE project_id=? AND completion < ?");
    $stmt->bind_param('ii',$project_id,$complete);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id,$task,$due_date, $last_updated, $status, $completion);
    While($stmt->fetch()){
     
    	$section->addListItem(ucfirst($task .' ('.$completion.'%)'), 0);
   
  }
  $stmt->close();
  }  
}

$stmt1->close();    
    
}

	$section->addTextBreak(1);

    $textrun = $section->addTextRun('Heading2');
	$textrun->addText('Performance Improvement plans offered', array("color" => "175EA8", 'size' => 16, 'bold' => true));
	$section->addLine(
	    array(
	        'width'       => 600,
	        'height'      => 0,
	        'positioning' => 'absolute',
	        'color'       => '#175EA8',
	        'weight'	  => '2',
	    )
	);




    $stmt1 = $conn->prepare("SELECT id, reason FROM bsc_pep WHERE scorecard_id=?");
    $stmt1->bind_param('i',$sid);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($pep_id,$reason);
    if($stmt1->num_rows <1){ 
        $textrun = $section->addTextRun('Heading5');
      $textrun->addText('No outstanding performance improvement plans were given', array("color" => "008140", "bold" => true));
    }else{
    While($stmt1->fetch()){

     $textrun = $section->addTextRun('Heading5');
     $textrun->addText('Reason: '.ucfirst($reason), array("color" => "175EA8", "bold" => true));


  // $tasks.=$textrun;
     $table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => '#175ea8', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0  ));
	$table2 = $section->addTable('myOwnTableStyle');

    $stmt = $conn->prepare("SELECT id, list,  due_date, status FROM bsc_pep_check_list WHERE pep_id=?");
    $stmt->bind_param('i',$pep_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id,$list,$due_date, $status);
    While($stmt->fetch()){
     
    	//$section->addListItem(ucfirst($task), 0);
    	$table->addRow(-0.5, array('exactHeight' => -5));
		$table->addCell(6000,$styleCellwhite)->addText($list,$Tfontorange,$cellColSpan, array('alignment'=> 'center'));
		$table->addCell(2000,$styleCellwhite)->addText($due_date,$Tfontorange, array('alignment'=> 'center'));
		$table->addCell(2000,$styleCellwhite)->addText(getPepStatusName($status),$Tfontorange, array('alignment'=> 'center'));

   
  }
         $section->addTextBreak(1);
         $stmt->close(); 
}
}
$stmt1->close();



if(getScorecardLevel($sid)==1){

// Lists
    $textrun = $section->addTextRun('Heading2');
	$textrun->addText('Top Ten performers', array("color" => "175EA8", 'size' => 16, 'bold' => true));
	$section->addLine(
	    array(
	        'width'       => 600,
	        'height'      => 0,
	        'positioning' => 'absolute',
	        'color'       => '#175EA8',
	        'weight'	  => '2',
	    )
	);


    $stmt = $conn->prepare("SELECT s.id, first_name, last_name, email, supervisoremail, position, department FROM bsc_scorecards AS s LEFT JOIN bsc_accounts AS a ON a.id=owner WHERE level_id=? AND client_id=?");
    $stmt->bind_param('ii',$level_id,$_SESSION['client_id']);
    $level_id=4;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($scorecard_id, $first_name, $last_name, $email, $supervisor_email,$postion,$department);
    $arr = array();
    while($stmt->fetch()){
    //   if(getTotalWR($scorecard_id)>-100){  
   

    //  $my[] = array('first_name'=>$first_name, 'last_name'=>$last_name, 'score'=>getTotalWR($scorecard_id));



    // }

    	$arr[] = array('first_name'=>$first_name, 'last_name'=>$last_name, 'score'=>getTotalWR($scorecard_id));
  }

   $nyasha= sort($arr);

//   //print_r($arr);
// // $sorted = usort($my, 'compare_score');

	
// // $it = sizeof($my)-1;

// // for ($i=$it; $i >= 0; $i--) { 


// // 	$section->addListItem($my[$i]['first_name'].' '.$my[$i]['last_name']. '  Score: '.$my[$i]['score'].'%', 0, null, $multilevelNumberingStyleName);
// // }


// //     $textrun = $section->addTextRun('Heading2');
// // 	$textrun->addText('Bottom Ten', array("color" => "175EA8", 'size' => 16, 'bold' => true));
// // 	$section->addLine(
// // 	    array(
// // 	        'width'       => 600,
// // 	        'height'      => 0,
// // 	        'positioning' => 'absolute',
// // 	        'color'       => '#175EA8',
// // 	        'weight'	  => '2',
// // 	    )
// // 	);



// // $multilevelNumberingStyleName = 'multilevel';
// // $phpWord->addNumberingStyle(
// //     $multilevelNumberingStyleName,
// //     array(
// //         'type'   => 'multilevel',
// //         'levels' => array(
// //             array('format' => 'decimal', 'text' => '%1.', 'left' => 360, 'hanging' => 360, 'tabPos' => 360),
// //             array('format' => 'upperLetter', 'text' => '%2.', 'left' => 720, 'hanging' => 360, 'tabPos' => 720),
// //         ),
// //     )
// // );


// // 	for ($i=0; $i<=$it; $i++) { 

// // 	$section->addListItem($my[$i]['first_name'].' '.$my[$i]['last_name']. '  Score: '.$my[$i]['score'].'%', 0, null, $multilevelNumberingStyleName);
// // }


// //asort($score);
     $stmt->close();
//     //close conn
     $conn->close();

 }
// $section->addPageBreak();
// $section= $phpWord->addSection(array('orientation' => 'landscape'));
// $section->addImage('images/overalscore'.$sid.'.png', array('width' => 900, 'height' => 440, 'align' => 'center'));
// $section->addTextBreak(2);


if(getScorecardLevel($sid)==1){
$section->addPageBreak();
  $textrun = $section->addTextRun('Heading2');
	//$textrun->addText('Original Strategy Map', array("color" => "175EA8", 'size' => 16, 'bold' => true));
	$section->addLine(
	    array(
	        'width'       => 600,
	        'height'      => 0,
	        'positioning' => 'absolute',
	        'color'       => '#175EA8',
	        'weight'	  => '2',
	    )
	);

// $section->addImage('images/strategymap'.$sid.'.png', array('width' => 900, 'height' => 440, 'align' => 'center'));


 $section->addPageBreak();

  $textrun = $section->addTextRun('Heading2');
	$textrun->addText('Correlation on goals over time', array("color" => "175EA8", 'size' => 16, 'bold' => true));
	$section->addLine(
	    array(
	        'width'       => 600,
	        'height'      => 0,
	        'positioning' => 'absolute',
	        'color'       => '#175EA8',
	        'weight'	  => '2',
	    )
	);

// $section->addImage('images/correlation'.$sid.'.png', array('width' => 900, 'height' => 440, 'align' => 'center'));
// $section->addTextBreak(2);
 }
	// Saving the document as OOXML file...
	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
 	$repname = 'reports/nyasha/'.getOwner($_GET['sid']).' Performance Report.docx';
 	$objWriter->save($repname);
?>