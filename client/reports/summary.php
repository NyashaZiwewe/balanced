<?php

	require_once 'vendor/autoload.php';

//include_once 'vendor/phpoffice/phpword/src/PhpWord/Writer/tcpdf/tcpdf.php';

//\PhpOffice\PhpWord\Settings::setPdfRendererPath('vendor/phpoffice/phpword/src/PhpWord/Writer/tcpdf');
//\PhpOffice\PhpWord\Settings::setPdfRendererName('TCPDF');

//$temp = \PhpOffice\PhpWord\IOFactory::load('reports/nyasha/nyasha.docx');
//$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($temp , 'PDF');
//$xmlWriter->save('reports/nyasha/nyasha.pdf', TRUE);

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

// //	add ipc logo
// 	$section->addImage('img/ipc.png', array('width' => 280, 'height' => 120, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));


// 		$section->addTextBreak(1);

// 	//set the date format
// 	date_default_timezone_set("Africa/Harare");
// 	$date=date('Y-m-d');
// 	//$reportingperiod='January to '.getReportingPeriod($sid);

// 	//add table
// 	$tableStyle = array('borderSize' => 1, 'borderColor' => 'white', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0);
// 	$styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'white','borderLeftSize'=>1,'borderLeftColor' =>'white','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomSize' =>1,'borderBottomColor'=>'white' ,'bgcolor'=> '175EA8');
// 	$TstyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'white','borderLeftSize'=>1,'borderLeftColor' =>'white','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomSize' =>1,'borderBottomColor'=>'white' ,'bgcolor'=> 'DEEAF6','spaceBefore' => 10);
// 	$fontStyle = array('color'=> 'black', 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left');
// 	$TfontStyle = array('bold'=>true, 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left', 'color'=>'white');
// 	$noSpace = array('textBottomSpacing' => -1);        
// 	// $table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => 'white', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0  ));
// 	$table = $section->addTable('myOwnTableStyle');
// 	$table->addRow(-0.5, array('exactHeight' => -5));
// 	$table->addCell(4000,$styleCell)->addText('<w:br/>Organisation:',$TfontStyle);
// 	$table->addCell(6000,$TstyleCell)->addText('<w:br/> IPC',$fontStyle);
// 	$table->addRow();
// 	$table->addCell(4000,$styleCell)->addText('<w:br/> Grading System:',$TfontStyle);
// 	$table->addCell(6000,$TstyleCell)->addText('<w:br/> Patterson',$fontStyle);
// 	$table->addRow();
// 	$table->addCell(4000,$styleCell)->addText('<w:br/> Date of Grading:',$TfontStyle);
// 	$table->addCell(6000,$TstyleCell)->addText('<w:br/>15 May 2020',$fontStyle);

// 	 	$section->addTextBreak(1);

// // 	add the paragraph
// 	$section->addText(
// 	    'Please refer below for the job grading results for all positions graded:',
// 	    null,
// 	    array('alignment'=>'both', 'widowControl' => false)
// 	);

//  	$section->addTextBreak(1);

//  	$whiteCell = array('borderTopSize'=>1 ,'borderTopColor' =>'#239fce','borderLeftSize'=>1,'borderLeftColor' =>'#239fce','borderRightSize'=>1,'borderRightColor'=>'#239fce','borderBottomSize' =>1,'borderBottomColor'=>'#239fce' ,'bgcolor'=> 'white','spaceBefore' => 10);
//  	$blueCell = array('borderTopSize'=>1 ,'borderTopColor' =>'#239fce','borderLeftSize'=>1,'borderLeftColor' =>'#239fce','borderRightSize'=>1,'borderRightColor'=>'#239fce','borderBottomSize' =>1,'borderBottomColor'=>'#239fce' ,'bgcolor'=> 'DEEAF6','spaceBefore' => 10);

// 	$table2 = $section->addTable('myOwnTableStyle');
// 	$table2->addRow();
// 	$table2->addCell(7000,$whiteCell)->addText('<w:br/>Position',$fontStyle);
// 	$table2->addCell(3000,$whiteCell)->addText('<w:br/> Grade Patterson',$fontStyle);

// 	for($i=1; $i<11; $i++){ 

//     if(($i %2)==1){
//     	$cell=$blueCell;
//     } else{
//     	$cell=$whiteCell;
//     }
// 	$table2->addRow();
// 	$table2->addCell(7000,$cell)->addText('<w:br/> Head Of Operations',$fontStyle);
// 	$table2->addCell(3000,$cell)->addText('<w:br/> E2',$fontStyle);

	
// 	 } 

// 	// Add footer
// 	$footer = $section->addFooter();
// 	$footer->addImage('img/footer.png', array('width' => 690, 'height' => 50, 'alignment' =>  \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

$rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;
$rendererLibrary = 'tcpdf';
$rendererLibraryPath ='reports/vendor/phpoffice/phpword/' . $rendererLibrary;
if(!\PhpOffice\PhpWord\Settings::setPdfRenderer(
$rendererName,
$rendererLibrary
)){
	die(
		'Notice: Please set rendererNameand rendererLibraryPath values'. 
		'</br>'.
		'At the top of this script appropriate of your library directory structure'
	);
}
 $rendererLibraryPath ='' . $rendererLibrary;

	// Saving the document as OOXML file...
	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
 	$repname = 'nyasha.pdf';
 	$objWriter->save($repname);
?>