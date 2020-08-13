<?php

print_r($percentile);
// print_r($associative);

	//include the PHP word files

	require_once '../reports/vendor/autoload.php';



	// Creating the new document

	$phpWord = new \PhpOffice\PhpWord\PhpWord();



	//set default font name

	$phpWord->setDefaultFontName('Palatino Linotype');



	//set the font size and properties

	$phpWord->addTitleStyle(1, array('size' => 36.5, 'bold' => false), array('alignment' => 'center'));

	$phpWord->addTitleStyle(2, array(), array('alignment' => 'left'));

	$phpWord->addTitleStyle(3, array('size' => 13), array('alignment' => 'left'));



	// Begin section in document

	$section = $phpWord->addSection();



	// Add first page header

	$header = $section->addHeader();

	$header->firstPage();

	$table = $header->addTable();

	$table->addRow();

	$cell = $table->addCell(4500);

	$textrun = $cell->addTextRun();

	$textrun->addText('');



	// Add header for all other pages

	$subsequent = $section->addHeader();

	$subsequent->addText($fullname, array('size' => 11, 'bold' => false), array('alignment' => 'right'));



	// Add footer

	$footer = $section->addFooter();

	$footer->addLine(

	  array(

	    'width'    => 600,

	    'height'   => 0,

	    'positioning' => 'absolute',

	    'color'    => '#175EA8',

	    'weight'	 => '3',

	    'spaceAfter' => 0,

	  )

	);

	$footer->addText('Prepared by Memory Nguwi <w:br/>Msc. Occupational Psychology (UZ), Bsc. Hons. Psychology (UZ), DOPs (UZ) <w:br/>Registered Occupational Psychologist - Reg No: AP0056', array('size' => 10, 'bold' => false), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));

	$footer->addPreserveText('{PAGE}', array('size' => 11, 'bold' => false), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT));



	//add ipc logo

	$section->addImage('../img/reports/logo.png', array('width' => 250, 'height' => 120, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));



	//add the first heading

	$section->addLine(

	  array(

	    'width'    => 600,

	    'height'   => 0,

	    'positioning' => 'absolute',

	    'color'    => '#175EA8',

	    'weight'	 => '2',

	  )

	);

	$textrun = $section->addTextRun('Heading1');

	$textrun->addText('Psychometric Test Report', array("color" => "175EA8"));

	$section->addLine(

	  array(

	    'width'    => 600,

	    'height'   => 0,

	    'positioning' => 'absolute',

	    'color'    => '#175EA8',

	    'weight'	 => '2',

	  )

	);



	//add the second heading

	$textrun = $section->addTextRun('Heading3');

	$textrun->addText('Confidential', array("color" => "175EA8", 'underline' => 'double', 'size' => 22, 'bold' => false, 'italic' => true));



	//add the paragraph

	$section->addText(

	  'The information in this report is confidential and must not '

	    . 'be made known to anyone other than Authorised personnel, '

	    . 'unless released by expressed written permission. '

	    . 'The Information must be considered together with all information '

	    . 'gathered in the assessment process. Refer candidate to the writer for feedback.',

	  null,

	  array('alignment'=>'both', 'widowControl' => false)

	);



	//set the date format

	date_default_timezone_set("Africa/Harare");

	$trans_date_time = date("y/m/d");

	$date = $date ? $date : $trans_date_time;

	$d = date_parse_from_format("Y-m-d", $date);

	$day = $d["day"];

	$month = $d["month"];

	$year = $d["year"];

	$dateObj  = DateTime::createFromFormat('!m', $month);

	$monthName = $dateObj->format('F'); // March

	$finaldate = $day.' - '.$monthName.' - '.$year;



	//add table

	$tableStyle = array('borderSize' => 1, 'borderColor' => 'white', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0);

	$styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'white','borderLeftSize'=>1,'borderLeftColor' =>'white','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomSize' =>1,'borderBottomColor'=>'white' ,'bgcolor'=> '175EA8');

	$TstyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'white','borderLeftSize'=>1,'borderLeftColor' =>'white','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomSize' =>1,'borderBottomColor'=>'white' ,'bgcolor'=> 'DEEAF6','spaceBefore' => 10);

	$fontStyle = array('color'=> 'black', 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left');

	$TfontStyle = array('bold'=>true, 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left', 'color'=>'white');

	$noSpace = array('textBottomSpacing' => -1);    

	$table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => 'white', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0 ));

	$table2 = $section->addTable('myOwnTableStyle');

	$table->addRow(-0.5, array('exactHeight' => -5));

	$table->addCell(4000,$styleCell)->addText('<w:br/> Name:',$TfontStyle);

	$table->addCell(6000,$TstyleCell)->addText('<w:br/> '.ucwords(strtolower($fullname)),$fontStyle);

	$table->addRow();

	$table->addCell(4000,$styleCell)->addText('<w:br/> Assessment Date:',$TfontStyle);

	$table->addCell(6000,$TstyleCell)->addText('<w:br/> '.$finaldate,$fontStyle);

	if($position == ''){

		//echo 'Do nothing!';

	}else{

		$table->addRow();

		$table->addCell(4000,$styleCell)->addText('<w:br/> Position:',$TfontStyle);

		$table->addCell(6000,$TstyleCell)->addText('<w:br/> '.$position,$fontStyle);

	}

	$table->addRow();

	$table->addCell(4000,$styleCell)->addText('<w:br/> Organisation:',$TfontStyle);

	$table->addCell(6000,$TstyleCell)->addText('<w:br/> '.$client,$fontStyle);

	$table->addRow();

	$table->addCell(4000,$styleCell)->addText('<w:br/> Purpose:',$TfontStyle);

	$table->addCell(6000,$TstyleCell)->addText('<w:br/> '.$purpose,$fontStyle);

	$section->addTextBreak(1);



	//add table

	$tableStyle = array('borderSize' => 1, 'borderColor' => 'DEEBF7', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0);

	$styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'DEEBF7','borderLeftSize'=>1,'borderLeftColor' =>'DEEBF7','borderRightSize'=>1,'borderRightColor'=>'DEEBF7','borderBottomSize' =>1,'borderBottomColor'=>'DEEBF7' ,'bgcolor'=> 'DEEBF7');

	$TstyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'DEEBF7','borderLeftSize'=>1,'borderLeftColor' =>'DEEBF7','borderRightSize'=>1,'borderRightColor'=>'DEEBF7','borderBottomSize' =>1,'borderBottomColor'=>'DEEBF7' ,'bgcolor'=> 'DEEBF7','spaceBefore' => 10);

	$fontStyle = array('color'=> '1F3864', 'size'=>10, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'both');

	$TfontStyle = array('bold'=>true, 'size'=>10, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left', 'color'=>'1F3864');

	$noSpace = array('textBottomSpacing' => -1);    

	$table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => 'DEEBF7', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0 ));

	$table2 = $section->addTable('myOwnTableStyle');

	$table->addRow(-0.5, array('exactHeight' => -5));

	$table->addCell(10000,$styleCell)->addText('Prepared by:  Memory Nguwi',$TfontStyle);

	$table->addRow();

	$table->addCell(10000,$styleCell)->addText('Msc. Occupational Psychology (UZ), Bsc. Hons. Psychology (UZ), DOPs (UZ) <w:br/>Registered Occupational Psychologist - Reg No: AP0056',$fontStyle);

	$table->addRow();

	$table->addCell(10000,$styleCell)->addText('Disclaimer: These tests should be used as one of the many tools for decision-making, for the selection of new employees, or the development of current employees, or on making promotion decisions for current employees. At no stage should this report be used for disciplinary purposes and or the dismissal of employees. This report should only be used to make decisions for the targeted position which the person was being tested for.',$fontStyle,array('alignment'=> 'both'));

	$section->addTextBreak(1);

	$section->addTextBreak(1);

	 //add the first heading

	$textrun = $section->addTextRun('Heading2');

	$textrun->addText('Integrity Profile using the Honest- Humility and the Moral Disengagement Scales', array("color" => "175EA8", 'size' => 16, 'bold' => true));

	$section->addLine(

	  array(

	    'width'    => 600,

	    'height'   => 0,

	    'positioning' => 'absolute',

	    'color'    => '#175EA8',

	    'weight'	 => '2',

	  )

	);

	//add the paragraph

	$section->addText(

	  'The critical traits to check for integrity of this candidate are the Honest – Humility'

	    . ' trait and the Moral '

	    . 'Disengagement profile. '

	    . 'Related pointers to integrity issues can be'

	    . ' found in Altruism and Emotionality.',

	   array('size'=>11), array('alignment'=>'both', 'widowControl' => false)

	);

	$section->addTextBreak(1);


	 //add the first heading

	$textrun = $section->addTextRun('Heading2');

	$textrun->addText('Interpretation of Results', array("color" => "175EA8", 'size' => 16, 'bold' => true));

	$section->addLine(

	  array(

	    'width'    => 600,

	    'height'   => 0,

	    'positioning' => 'absolute',

	    'color'    => '#175EA8',

	    'weight'	 => '2',

	  )

	);



	//add the second heading

	if($normgroup != 'Zimbabwean'){

		if($normgroup1 == 'Professionals'){

			$norms = 'Norm Group - Zimbabwean Professionals';

		}else{

			$norms = 'Norm Group - Zimbabwean '.$normgroup;

		}

	}else{

		if($normgroup1 == 'Junior/Middle Management'){

			

			$norms = 'Norm Group - Zimbabwean '.$normgroup;

		}else{

			$norms = 'Norm Group - Zimbabwean Professionals';

		}

	}

	$textrun = $section->addTextRun('Heading3');

	$textrun->addText('Norm Group - Zimbabwean Professionals', array("color" => "175EA8"));



	//add the paragraph

	$section->addText(

	  'Standardised tests measure characteristics that are relevant to occupational success. These include both ability factors and aspects of personality that help the candidate perform work-related tasks. '

	    . 'The tests that were used measure persistent and underlying characteristics; this means that they can not only explain current modes of behaviour but may also highlight as yet unrealised potential. '

	    . 'The tests are scientifically based, '

	    . 'objective and valid and are '

	    . 'therefore able to predict success in a particular job.',

	   array('size'=>11), array('alignment'=>'both', 'widowControl' => false)

	);

	$section->addTextBreak(1);



	//add the paragraph

	$section->addText(

	  'Testing enables a candidate’s characteristics and abilities to be compared objectively and fairly with those of other people. '

	    . 'When interpreting test results in '

	    . 'general it should be borne in mind that a person’s performance depends'

	    . ' in part on his or her state of mind on that day and on other influences; '

	    . 'the results are therefore subject to a certain margin of fluctuation.',

	   array('size'=>11), array( 'alignment'=>'both','widowControl' => false)

	);

	$section->addTextBreak(1);



	//add the third heading

	$textrun = $section->addTextRun('Heading3');

	$textrun->addText('Norm Scores ', array("color" => "175EA8"));



	//add the paragraph

	$section->addText(

	  'The candidate’s results in the different areas are quoted in percentile ranks (PR). '

	    . 'The percentile rank indicates what percentage of a particular comparison group achieved the same '

	    . 'or a lower score on the ability or personality characteristic in question. '

	    . 'The comparison group '

	    . 'is a representative sample of the general population. ',

	   array('size'=>11), array( 'alignment'=>'both','widowControl' => false)

	);

	$section->addTextBreak(1);



	$section->addText(

	  'For example, '

	    . 'a percentile rank of PR=70 means that 70% of respondents from the'

	    . ' representative norm sample obtained this'

	    . ' score or a lower one on this characteristic, and 30% '

	    . 'obtained a higher score.',

	   array('size'=>11), array('alignment'=>'both', 'widowControl' => false)

	);


	//add table

	$tableStyle = array('borderSize' => 1, 'borderColor' => 'white', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0);

	$styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'white','borderLeftSize'=>1,'borderLeftColor' =>'white','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomSize' =>1,'borderBottomColor'=>'white' ,'bgcolor'=> '8EAADB');

	$TstyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'white','borderLeftSize'=>1,'borderLeftColor' =>'white','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomSize' =>1,'borderBottomColor'=>'white' ,'bgcolor'=> 'DEEAf6');

	$fontStyle = array('color'=> 'black', 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left');

	$TfontStyle = array('bold'=>true, 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left', 'color'=>'black');

	$noSpace = array('textBottomSpacing' => -1);    

	$table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => 'white', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0 ));

	$table2 = $section->addTable('myOwnTableStyle');

	$table->addRow(-0.5, array('exactHeight' => -5));

	$table->addCell(10000,$styleCell)->addText('<w:br/> Categories of Percentile Scores: <w:br/>',$TfontStyle);

	$table->addRow(-0.5, array('exactHeight' => -5));

	$table->addCell(10000,$TstyleCell)->addListItem('A percentile rank of 25 or less indicates an extremely low level of the ability or personality characteristic in question by comparison with the representative norm sample. <w:br/>',0, $fontStyle);

	$table->addRow(-0.5, array('exactHeight' => -5));

	$table->addCell(10000,$TstyleCell)->addListItem('A percentile rank of 26 – 49 reflects a low level of the ability or personality characteristic in question by comparison with the representative norm sample.<w:br/>',0, $fontStyle);

	$table->addRow(-0.5, array('exactHeight' => -5));

	$table->addCell(10000,$TstyleCell)->addListItem('A percentile rank of 50 – 60 reflects an average range level of the ability or personality characteristic in question by comparison with the representative norm sample.<w:br/>',0, $fontStyle);

	$table->addRow(-0.5, array('exactHeight' => -5));

	$table->addCell(10000,$TstyleCell)->addListItem('A percentile rank of 61 - 80 reflects a high level of the ability or personality characteristic in question by comparison with the representative norm sample.<w:br/>',0, $fontStyle);

	$table->addRow(-0.5, array('exactHeight' => -5));

	$table->addCell(10000,$TstyleCell)->addListItem('A percentile rank of 81 or more indicates an extremely high level of the ability or personality characteristic in question by comparison with the representative norm sample. <w:br/>',0, $fontStyle);

	$section->addTextBreak(1);

	switch ($gender) {

			case 'female':

				$doplease = 'she';

				$because = 'her';

				$herself = 'herself';

				$him = 'her';

				break;

			case 'Female':

				$doplease = 'she';

				$because = 'her';

				$herself = 'herself';

				$him = 'her';

				break;

			case 'male':

				$doplease = 'he';

				$because = 'his';

				$herself = 'himself';

				$him = 'him';

				break;

			case 'Male':

				$doplease = 'he';

				$because = 'his';

				$herself = 'himself';

				$him = 'him';

				break;

			default:

				$doplease = 'he';

				$because = 'his';

				$herself = 'himself';

				$him = 'him';

				break;

		}



		if($gender == 'female' || $gender == 'Female'){

			$doplease = 'she';

			$because = 'her';

			$herself = 'herself';

			$him = 'her';

		}else{

			$doplease = 'he';

			$because = 'his';

			$herself = 'himself';

			$him = 'him';

		}


	if(isset($percentile['Hexaco PI R (100) - Honesty-Humility'])){



		// Begin code

		$section = $phpWord->addSection();



		$textrun = $section->addTextRun('Heading2');

		$textrun->addText('Personality Profile', array("color" => "175EA8", 'size' => 16, 'bold' => true));

		$section->addLine(

		  array(

		    'width'    => 600,

		    'height'   => 0,

		    'positioning' => 'absolute',

		    'color'    => '#175EA8',

		    'weight'	 => '2',

		  )

		);

		//add the graph
		//function to get color of bar
		function getHexacoBarColor($mark){

			if($mark <= 40){
				$color = "#ff0000";
			}else{
				$color = "#175ae8";
			}

			return $color;

		}

		//initialise and set cookie
		$cookie_name = "hexaco";

		//generate the image

		?>

	<script type="text/javascript">
		//google.load("visualization", "1.1", {packages:["bar"]});
      google.load("visualization", "1.1", {packages:["corechart"]});
      google.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ["", "Percentile", { role: "style" }, { role: 'annotation'}],
		    ["Honesty-Humility", <?php echo $percentile['Hexaco PI R (100) - Honesty-Humility']; ?>, "<?php echo getHexacoBarColor($percentile['Hexaco PI R (100) - Honesty-Humility']); ?>", "Honesty-Humility - <?php echo $percentile['Hexaco PI R (100) - Honesty-Humility']; ?>"],
		    ["Emotionality", <?php echo $percentile['Hexaco PI R (100) - Emotionality']; ?>, "<?php echo getHexacoBarColor($percentile['Hexaco PI R (100) - Emotionality']); ?>", "Emotionality - <?php echo $percentile['Hexaco PI R (100) - Emotionality']; ?>"],
		    ["Extraversion", <?php echo $percentile['Hexaco PI R (100) - Extraversion']; ?>, "<?php echo getHexacoBarColor($percentile['Hexaco PI R (100) - Extraversion']); ?>", "Extraversion - <?php echo $percentile['Hexaco PI R (100) - Extraversion']; ?>"],
		    ["Agreeableness", <?php echo $percentile['Hexaco PI R (100) - Agreeableness']; ?>, "<?php echo getHexacoBarColor($percentile['Hexaco PI R (100) - Agreeableness']); ?>", "Agreeableness - <?php echo $percentile['Hexaco PI R (100) - Agreeableness']; ?>"],
		    ["Conscientiousness", <?php echo $percentile['Hexaco PI R (100) - Conscientiousness']; ?>, "<?php echo getHexacoBarColor($percentile['Hexaco PI R (100) - Conscientiousness']); ?>", "Conscientiousness - <?php echo $percentile['Hexaco PI R (100) - Conscientiousness']; ?>"],
		    ["Altruism", <?php echo $percentile['Hexaco PI R (100) - Altruism']; ?>, "<?php echo getHexacoBarColor($percentile['Hexaco PI R (100) - Altruism']); ?>", "Altruism - <?php echo $percentile['Hexaco PI R (100) - Altruism']; ?>"]
        ]);

         var view = new google.visualization.DataView(data);
	      view.setColumns([0, 1,
	                       { calc: "stringify",
	                         sourceColumn: 1,
	                         type: "string",
	                         role: "annotation" },
	                       2]);

        var options = {
        	 hAxis : { 
		        textStyle : {
		            fontSize: 5 // or the number you want
		        }

		    },
          title: '',
          width: 600,
          legend: { position: 'none' },
          chart: { title: '',
                   subtitle: '' },
          bars: 'horizontal', // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: 'top', label: 'Percentage'} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%" }
        };

          //var chart = new google.charts.Bar(document.getElementById('top_x_div'));
          var chartContainer = document.getElementById('dual_x_div');
        var chart = new google.visualization.BarChart(document.getElementById("dual_x_div"));
        // chart.draw(data, options);

        google.visualization.events.addListener(chart, 'ready', function () {
		    var canvas;
		    var domURL;
		    var imageNode;
		    var imageURL;
		    var svgParent;

		    // add svg namespace to chart
		    domURL = window.URL || window.webkitURL || window;
		    svgParent = chartContainer.getElementsByTagName('svg')[0];
		    svgParent.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
		    imageNode = chartContainer.cloneNode(true);
		    imageURL = domURL.createObjectURL(new Blob([svgParent.outerHTML], {type: 'image/svg+xml'}));
		    image = new Image();
		    image.onload = function() {
				canvas = document.getElementById('canvas');
				canvas.setAttribute('width', parseFloat(svgParent.getAttribute('width')));
				canvas.setAttribute('height', parseFloat(svgParent.getAttribute('height')));
				canvas.getContext('2d').drawImage(image, 0, 0);
				console.log(canvas.toDataURL('image/jpg'));
				var data = canvas.toDataURL();
				var fileName = "PersonalityProfile.jpg";
				var strMimeType = 'image/jpg';
				// download(data, fileName, strMimeType);
				save_img(data);
		    }
		    image.src = imageURL;
		  });

		  chart.draw(data, options);
      };

      //to save the canvas image
		function save_img(data){
			//ajax method.
			$.post('process.php', {data: data}, function(res){
				//if the file saved properly, trigger a popup to the user.
				if(res != ''){
					
					//create cookie
					document.cookie = "hexaco="+res;
				}
				else{
					alert('something wrong');
				}
			});
		}

	</script>

	<div id="dual_x_div" class="hidden"></div>
	<canvas class="hidden" id="canvas"></canvas>

<?php
		setcookie($cookie_name);
		print_r($_COOKIE);

		//add image for the test
		$section->addImage('../img/reports/graphimg/'.$_COOKIE['hexaco'].'.jpg', array('width' => 600, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

		$textrun = $section->addTextRun('Heading3');

		$textrun->addText('Deception Scale', array("color" => "175EA8", "bold" => true));



		//case of the deception score

		switch ($percentile['Hexaco PI R (100) - Deception Score']) {

			case $percentile['Hexaco PI R (100) - Deception Score'] = 3:

				$code = 'low';

				break;

			case $percentile['Hexaco PI R (100) - Deception Score'] = 1:

				$code = 'low';

				break;

			case $percentile['Hexaco PI R (100) - Deception Score'] = 2:

				$code = 'low';

				break;

			case $percentile['Hexaco PI R (100) - Deception Score'] = 0:

				$code = 'low';

				break;

			case $percentile['Hexaco PI R (100) - Deception Score'] = 4:

				$code = 'high';

				break;

			case $percentile['Hexaco PI R (100) - Deception Score'] = 5:

				$code = 'high';

				break;

		}



		$tableStyle = array('borderSize' => 1, 'borderColor' => '8EAADB', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0);

		$styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'8EAADB','borderLeftSize'=>1,'borderLeftColor' =>'8EAADB','borderRightSize'=>1,'borderRightColor'=>'8EAADB','borderBottomSize' =>1,'borderBottomColor'=>'8EAADB' ,'bgcolor'=> '8EAADB');

		$TstyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'8EAADB','borderLeftSize'=>1,'borderLeftColor' =>'8EAADB','borderRightSize'=>1,'borderRightColor'=>'8EAADB','borderBottomSize' =>1,'borderBottomColor'=>'8EAADB' ,'bgcolor'=> '8EAADB','spaceBefore' => 10);

		$fontStyle = array('color'=> 'black', 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'both', 'italic' => false);

		$TfontStyle = array('bold'=>true, 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left', 'color'=>'175EA8');

		$noSpace = array('textBottomSpacing' => -1);        

		$table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => '8EAADB', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0  ));

		$table2 = $section->addTable('myOwnTableStyle');



		if($gender == 'female' || $gender == 'Female'){

			switch ($percentile['Hexaco PI R (100) - Deception Score']) {

				case $percentile['Hexaco PI R (100) - Deception Score'] == 0:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' had a deception scale of '.$percentile['Hexaco PI R (100) - Deception Score'].'. This implies that there is a very '.$code.' likelihood that '.ucfirst(strtolower($name)).' attempted to “fake” some of her responses.',$fontStyle);

					$section->addTextBreak(1);

					break;

				case $percentile['Hexaco PI R (100) - Deception Score'] == 1:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' had a deception scale of '.$percentile['Hexaco PI R (100) - Deception Score'].'. This implies that there is a '.$code.' likelihood that '.ucfirst(strtolower($name)).' attempted to “fake” some of her responses.',$fontStyle);

					$section->addTextBreak(1);

					break;

				case $percentile['Hexaco PI R (100) - Deception Score'] == 2:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' had a deception scale of '.$percentile['Hexaco PI R (100) - Deception Score'].'. This implies that there is a '.$code.' likelihood that '.ucfirst(strtolower($name)).' attempted to “fake” some of her responses.',$fontStyle);

					$section->addTextBreak(1);

					break;

				case $percentile['Hexaco PI R (100) - Deception Score'] == 3:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' had a deception scale of '.$percentile['Hexaco PI R (100) - Deception Score'].'. This implies that there is a moderate likelihood that '.ucfirst(strtolower($name)).' attempted to “fake” some of her responses.',$fontStyle);

					$section->addTextBreak(1);

					break;

				case $percentile['Hexaco PI R (100) - Deception Score'] == 4:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' had a deception scale of '.$percentile['Hexaco PI R (100) - Deception Score'].'. This implies that there is a '.$code.' likelihood that '.ucfirst(strtolower($name)).' attempted to “fake” some of her responses.',$fontStyle);

					$section->addTextBreak(1);

					break;

				case $percentile['Hexaco PI R (100) - Deception Score'] == 5:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' had a deception scale of '.$percentile['Hexaco PI R (100) - Deception Score'].'. This implies that there is a very '.$code.' likelihood that '.ucfirst(strtolower($name)).' attempted to “fake” some of her responses.',$fontStyle);

					$section->addTextBreak(1);

					break;

				

				default:

					# code...

					break;

			}

		}else{

			switch ($percentile['Hexaco PI R (100) - Deception Score']) {

				case $percentile['Hexaco PI R (100) - Deception Score'] == 0:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' had a deception scale of '.$percentile['Hexaco PI R (100) - Deception Score'].'. This implies that there is a very '.$code.' likelihood that '.ucfirst(strtolower($name)).' attempted to “fake” some of his responses.',$fontStyle);

					$section->addTextBreak(1);

					break;

				case $percentile['Hexaco PI R (100) - Deception Score'] == 1:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' had a deception scale of '.$percentile['Hexaco PI R (100) - Deception Score'].'. This implies that there is a '.$code.' likelihood that '.ucfirst(strtolower($name)).' attempted to “fake” some of his responses.',$fontStyle);

					$section->addTextBreak(1);

					break;

				case $percentile['Hexaco PI R (100) - Deception Score'] == 2:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' had a deception scale of '.$percentile['Hexaco PI R (100) - Deception Score'].'. This implies that there is a '.$code.' likelihood that '.ucfirst(strtolower($name)).' attempted to “fake” some of his responses.',$fontStyle);

					$section->addTextBreak(1);

					break;

				case $percentile['Hexaco PI R (100) - Deception Score'] == 3:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' had a deception scale of '.$percentile['Hexaco PI R (100) - Deception Score'].'. This implies that there is a moderate likelihood that '.ucfirst(strtolower($name)).' attempted to “fake” some of his responses.',$fontStyle);

					$section->addTextBreak(1);

					break;

				case $percentile['Hexaco PI R (100) - Deception Score'] == 4:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' had a deception scale of '.$percentile['Hexaco PI R (100) - Deception Score'].'. This implies that there is a '.$code.' likelihood that '.ucfirst(strtolower($name)).' attempted to “fake” some of his responses.',$fontStyle);

					$section->addTextBreak(1);

					break;

				case $percentile['Hexaco PI R (100) - Deception Score'] == 5:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' had a deception scale of '.$percentile['Hexaco PI R (100) - Deception Score'].'. This implies that there is a very '.$code.' likelihood that '.ucfirst(strtolower($name)).' attempted to “fake” some of his responses.',$fontStyle);

					$section->addTextBreak(1);

					break;

				

				default:

					# code...

					break;

			}

		}
		

		$textrun = $section->addTextRun('Heading3');

		$textrun->addText('Honesty-Humility', array("color" => "175EA8", "bold" => true));


		$tableStyle = array('borderSize' => 1, 'borderColor' => '8EAADB', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0);

		$styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'8EAADB','borderLeftSize'=>1,'borderLeftColor' =>'8EAADB','borderRightSize'=>1,'borderRightColor'=>'8EAADB','borderBottomSize' =>1,'borderBottomColor'=>'8EAADB' ,'bgcolor'=> '8EAADB');

		$TstyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'8EAADB','borderLeftSize'=>1,'borderLeftColor' =>'8EAADB','borderRightSize'=>1,'borderRightColor'=>'8EAADB','borderBottomSize' =>1,'borderBottomColor'=>'8EAADB' ,'bgcolor'=> '8EAADB','spaceBefore' => 10);

		$fontStyle = array('color'=> 'black', 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'both', 'italic' => true);

		$TfontStyle = array('bold'=>true, 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left', 'color'=>'175EA8');

		$noSpace = array('textBottomSpacing' => -1);    

		$table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => '8EAADB', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0 ));

		$table2 = $section->addTable('myOwnTableStyle');



		switch ($percentile['Hexaco PI R (100) - Honesty-Humility']) {

				case $percentile['Hexaco PI R (100) - Honesty-Humility'] <= 40:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					if($percentile['Hexaco PI R (100) - Honesty-Humility'] <= 0){

						$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Honesty-Humility']).' percentile, meaning '.$doplease.' scored better than none of the people in the norm sample. '

						    . 'The candidate is in the low range when compared to individuals from the norm sample. '.ucfirst(strtolower($name))

						    . ' is likely to flatter others to get what '.$doplease.' want and '.$doplease.' is inclined to break rules for personal profit. '

						    . 'This score suggests that '.ucfirst(strtolower($name)).' is motivated by material gain and feels a strong sense of self-importance.',$fontStyle);

					}else{

						$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Honesty-Humility']).' percentile, meaning '.$doplease.' scored better than '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Honesty-Humility']).'% of the people in the norm sample. '

						    . 'The candidate is in the low range when compared to individuals from the norm sample. '.ucfirst(strtolower($name))

						    . ' is likely to flatter others to get what '.$doplease.' want and '.$doplease.' is inclined to break rules for personal profit. '

						    . 'This score suggests that '.ucfirst(strtolower($name)).' is motivated by material gain and feels a strong sense of self-importance.',$fontStyle);

					}

					$section->addTextBreak(1);

					break;

				case $percentile['Hexaco PI R (100) - Honesty-Humility'] > 40:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Honesty-Humility']).' percentile, meaning '.$doplease.' scored better than '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Honesty-Humility']).'% of the people in the norm sample. '

						    . 'The candidate is in the high range when compared to individuals from the norm sample. '.ucfirst(strtolower($name))

						    . ' is likely to avoid manipulating others for personal gain and '.$doplease.' feels little temptation to break rules. '

						    . 'This score suggests that '.ucfirst(strtolower($name)).' is uninterested in lavish wealth and luxuries, and feels no special entitlement to elevated social status.',$fontStyle);

					$section->addTextBreak(1);

					break;

				default:

					# code...

					break;

			}



		$textrun = $section->addTextRun('Heading3');

		$textrun->addText('Emotionality', array("color" => "175EA8", "bold" => true));



		$tableStyle = array('borderSize' => 1, 'borderColor' => '8EAADB', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0);

		$styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'8EAADB','borderLeftSize'=>1,'borderLeftColor' =>'8EAADB','borderRightSize'=>1,'borderRightColor'=>'8EAADB','borderBottomSize' =>1,'borderBottomColor'=>'8EAADB' ,'bgcolor'=> '8EAADB');

		$TstyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'8EAADB','borderLeftSize'=>1,'borderLeftColor' =>'8EAADB','borderRightSize'=>1,'borderRightColor'=>'8EAADB','borderBottomSize' =>1,'borderBottomColor'=>'8EAADB' ,'bgcolor'=> '8EAADB','spaceBefore' => 10);

		$fontStyle = array('color'=> 'black', 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'both', 'italic' => true);

		$TfontStyle = array('bold'=>true, 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left', 'color'=>'175EA8');

		$noSpace = array('textBottomSpacing' => -1);    

		$table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => '8EAADB', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0 ));

		$table2 = $section->addTable('myOwnTableStyle');



		switch ($percentile['Hexaco PI R (100) - Emotionality']) {

				case $percentile['Hexaco PI R (100) - Emotionality'] <= 40:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					if($percentile['Hexaco PI R (100) - Emotionality'] <= 0){

						$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Emotionality']).' percentile, meaning '.$doplease.' scored better than none of the people in the norm sample. '

					    . 'The candidate is in the low range when compared '

					    . 'to individuals from the norm sample. '

					    . 'This score suggests that '.ucfirst(strtolower($name)).' to not be deterred by the prospect of physical harm and feels little worry even in stressful situations. '.ucfirst($doplease).' has little needs to share his concerns with others and feels emotionally detached from others.',$fontStyle);

					}else{

						$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Emotionality']).' percentile, meaning '.$doplease.' scored better than '.$percentile['Hexaco PI R (100) - Emotionality'].'% of the people in the norm sample. '

					    . 'The candidate is in the low range when compared '

					    . 'to individuals from the norm sample. '

					     . 'This score suggests that '.ucfirst(strtolower($name)).' to not be deterred by the prospect of physical harm and feels little worry even in stressful situations. '.ucfirst($doplease).' has little needs to share his concerns with others and feels emotionally detached from others.',$fontStyle);

					}

					$section->addTextBreak(1);

					break;

				case $percentile['Hexaco PI R (100) - Emotionality'] > 40:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Emotionality']).' percentile, meaning '.$doplease.' scored better than '.$percentile['Hexaco PI R (100) - Emotionality'].'% of the people in the norm sample. '

					    . 'The candidate is in the high range when compared '

					    . 'to individuals from the norm sample. '

					    . 'This score suggests that '.ucfirst(strtolower($name)).' experiences fear of physical dangers and anxiety in response to life`s stresses. '.ucfirst($doplease).' feels a need for emotional support from others and feels empathy and sentimental attachments with others.',$fontStyle);

					$section->addTextBreak(1);

					break;

				default:

					# code...

					break;

			}



		$textrun = $section->addTextRun('Heading3');

		$textrun->addText('Extraversion', array("color" => "175EA8", "bold" => true));



		$tableStyle = array('borderSize' => 1, 'borderColor' => '8EAADB', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0);

		$styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'8EAADB','borderLeftSize'=>1,'borderLeftColor' =>'8EAADB','borderRightSize'=>1,'borderRightColor'=>'8EAADB','borderBottomSize' =>1,'borderBottomColor'=>'8EAADB' ,'bgcolor'=> '8EAADB');

		$TstyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'8EAADB','borderLeftSize'=>1,'borderLeftColor' =>'8EAADB','borderRightSize'=>1,'borderRightColor'=>'8EAADB','borderBottomSize' =>1,'borderBottomColor'=>'8EAADB' ,'bgcolor'=> '8EAADB','spaceBefore' => 10);

		$fontStyle = array('color'=> 'black', 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'both', 'italic' => true);

		$TfontStyle = array('bold'=>true, 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left', 'color'=>'175EA8');

		$noSpace = array('textBottomSpacing' => -1);    

		$table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => '8EAADB', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0 ));

		$table2 = $section->addTable('myOwnTableStyle');



		switch ($percentile['Hexaco PI R (100) - Extraversion']) {

				case $percentile['Hexaco PI R (100) - Extraversion'] <= 40:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					if($percentile['Hexaco PI R (100) - Extraversion'] <= 0){

						$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Extraversion']).' percentile, meaning '.$doplease.' scored better than none of the people in the norm sample. '

					    . 'The candidate is in the low range when compared '

					    . 'to individuals from the norm sample. '

					    . 'This score suggests that '.ucfirst(strtolower($name)).' is likely to consider '.$herself.' unpopular and feel awkward when '.$doplease.' is the centre of social attention. '.ucfirst(strtolower($name)).' feels less lively and optimistic that others do.',$fontStyle);

					}else{

						$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Extraversion']).' percentile, meaning '.$doplease.' scored better than '.$percentile['Hexaco PI R (100) - Extraversion'].'% of the people in the norm sample. '

					    . 'The candidate is in the low range when compared '

					    . 'to individuals from the norm sample. '

					     . 'This score suggests that '.ucfirst(strtolower($name)).' is likely to consider '.$herself.' unpopular and feel awkward when '.$doplease.' is the centre of social attention. '.ucfirst(strtolower($name)).' feels less lively and optimistic that others do.',$fontStyle);

					}

					$section->addTextBreak(1);

					break;

				case $percentile['Hexaco PI R (100) - Extraversion'] > 40:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Extraversion']).' percentile, meaning '.$doplease.' scored better than '.$percentile['Hexaco PI R (100) - Extraversion'].'% of the people in the norm sample. '

					    . 'The candidate is in the high range when compared '

					    . 'to individuals from the norm sample. '

					    . 'This score suggests that '.ucfirst(strtolower($name)).' is likely feel positive about himself and feel confident when leading or addressing groups of people. '.ucfirst($doplease).' enjoys social gatherings and interactions and experiences positive feelings of enthusiasm and energy.',$fontStyle);

					$section->addTextBreak(1);

					break;

				default:

					# code...

					break;

			}



		$textrun = $section->addTextRun('Heading3');

		$textrun->addText('Agreeableness', array("color" => "175EA8", "bold" => true));



		$tableStyle = array('borderSize' => 1, 'borderColor' => '8EAADB', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0);

		$styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'8EAADB','borderLeftSize'=>1,'borderLeftColor' =>'8EAADB','borderRightSize'=>1,'borderRightColor'=>'8EAADB','borderBottomSize' =>1,'borderBottomColor'=>'8EAADB' ,'bgcolor'=> '8EAADB');

		$TstyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'8EAADB','borderLeftSize'=>1,'borderLeftColor' =>'8EAADB','borderRightSize'=>1,'borderRightColor'=>'8EAADB','borderBottomSize' =>1,'borderBottomColor'=>'8EAADB' ,'bgcolor'=> '8EAADB','spaceBefore' => 10);

		$fontStyle = array('color'=> 'black', 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'both', 'italic' => true);

		$TfontStyle = array('bold'=>true, 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left', 'color'=>'175EA8');

		$noSpace = array('textBottomSpacing' => -1);    

		$table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => '8EAADB', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0 ));

		$table2 = $section->addTable('myOwnTableStyle');



		switch ($percentile['Hexaco PI R (100) - Agreeableness']) {

				case $percentile['Hexaco PI R (100) - Agreeableness'] <= 40:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					if($percentile['Hexaco PI R (100) - Agreeableness'] <= 0){

						$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Agreeableness']).' percentile, meaning '.$doplease.' scored better than none of the people in the norm sample. '

					    . 'The candidate is in the low range when compared '

					    . 'to individuals from the norm sample. '

					    . 'This score suggests that '.ucfirst(strtolower($name)).' n is likely to hold grudges against those who have harmed '.$him.' and is rather critical of others shortcomings. The score suggests that '.$doplease.' is stubborn in defending '.$because.' point of view and feels anger readily in response to mistreatment.',$fontStyle);

					}else{

						$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Agreeableness']).' percentile, meaning '.$doplease.' scored better than '.$percentile['Hexaco PI R (100) - Agreeableness'].'% of the people in the norm sample. '

					    . 'The candidate is in the low range when compared '

					    . 'to individuals from the norm sample. '

					    . 'This score suggests that '.ucfirst(strtolower($name)).' n is likely to hold grudges against those who have harmed '.$him.' and is rather critical of others shortcomings. The score suggests that '.$doplease.' is stubborn in defending '.$because.' point of view and feels anger readily in response to mistreatment.',$fontStyle);

					}

					$section->addTextBreak(1);

					break;

				case $percentile['Hexaco PI R (100) - Agreeableness'] > 40:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Agreeableness']).' percentile, meaning '.$doplease.' scored better than '.$percentile['Hexaco PI R (100) - Agreeableness'].'% of the people in the norm sample. '

					    . 'The candidate is in the high range when compared '

					    . 'to individuals from the norm sample. '

					    . 'This score suggests that '.ucfirst(strtolower($name)).' is likely to forgive the wrongs that '.$doplease.' has suffered and is lenient in judging others. '.ucfirst($doplease).' is willing to compromise and cooperate with others and can easily control '.$him.' temper.',$fontStyle);

					$section->addTextBreak(1);

					break;
				default:

					# code...

					break;

			}



		$textrun = $section->addTextRun('Heading3');

		$textrun->addText('Openness to Experience ', array("color" => "175EA8", "bold" => true));



		$tableStyle = array('borderSize' => 1, 'borderColor' => '8EAADB', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0);

		$styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'8EAADB','borderLeftSize'=>1,'borderLeftColor' =>'8EAADB','borderRightSize'=>1,'borderRightColor'=>'8EAADB','borderBottomSize' =>1,'borderBottomColor'=>'8EAADB' ,'bgcolor'=> '8EAADB');

		$TstyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'8EAADB','borderLeftSize'=>1,'borderLeftColor' =>'8EAADB','borderRightSize'=>1,'borderRightColor'=>'8EAADB','borderBottomSize' =>1,'borderBottomColor'=>'8EAADB' ,'bgcolor'=> '8EAADB','spaceBefore' => 10);

		$fontStyle = array('color'=> 'black', 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'both', 'italic' => true);

		$TfontStyle = array('bold'=>true, 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left', 'color'=>'175EA8');

		$noSpace = array('textBottomSpacing' => -1);    

		$table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => '8EAADB', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0 ));

		$table2 = $section->addTable('myOwnTableStyle');



		switch ($percentile['Hexaco PI R (100) - Openness to Experience']) {

				case $percentile['Hexaco PI R (100) - Openness to Experience'] <= 40:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					if($percentile['Hexaco PI R (100) - Openness to Experience'] <= 0){

						$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Openness to Experience']).' percentile, meaning '.$doplease.' scored better than none of the people in the norm sample. '

					    . 'The candidate is in the low range when compared '

					    . 'to individuals from the norm sample. '

					    . 'This score suggests that '.ucfirst(strtolower($name)).' is likely to be unimpressed by most works of art and feels little intellectual curiosity. '.ucfirst($doplease).' avoids creative pursuits and feels little attraction towards ideas that may seem radical or unconventional.',$fontStyle);

					}else{

						$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Openness to Experience']).' percentile, meaning '.$doplease.' scored better than '.$percentile['Hexaco PI R (100) - Openness to Experience'].'% of the people in the norm sample. '

					    . 'The candidate is in the low range when compared '

					    . 'to individuals from the norm sample. '

					    . 'This score suggests that '.ucfirst(strtolower($name)).' is likely to be unimpressed by most works of art and feels little intellectual curiosity. '.ucfirst($doplease).' avoids creative pursuits and feels little attraction towards ideas that may seem radical or unconventional.',$fontStyle);

					}

					$section->addTextBreak(1);

					break;

				case $percentile['Hexaco PI R (100) - Openness to Experience'] > 40:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Openness to Experience']).' percentile, meaning '.$doplease.' scored better than '.$percentile['Hexaco PI R (100) - Openness to Experience'].'% of the people in the norm sample. '

					    . 'The candidate is in the high range when compared '

					    . 'to individuals from the norm sample. '

					    . 'This score suggests that '.ucfirst(strtolower($name)).' is likely to become absorbed in the in the beauty of art and nature and is inquisitive about various domains of knowledge. '.ucfirst($doplease).' uses '.$him.' imagination freely in everyday life and takes an interest in unusual ideas or people.' ,$fontStyle);

					$section->addTextBreak(1);

					break;

				default:

					# code...

					break;

			}



		$textrun = $section->addTextRun('Heading3');

		$textrun->addText('Conscientiousness ', array("color" => "175EA8", "bold" => true));



		$tableStyle = array('borderSize' => 1, 'borderColor' => '8EAADB', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0);

		$styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'8EAADB','borderLeftSize'=>1,'borderLeftColor' =>'8EAADB','borderRightSize'=>1,'borderRightColor'=>'8EAADB','borderBottomSize' =>1,'borderBottomColor'=>'8EAADB' ,'bgcolor'=> '8EAADB');

		$TstyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'8EAADB','borderLeftSize'=>1,'borderLeftColor' =>'8EAADB','borderRightSize'=>1,'borderRightColor'=>'8EAADB','borderBottomSize' =>1,'borderBottomColor'=>'8EAADB' ,'bgcolor'=> '8EAADB','spaceBefore' => 10);

		$fontStyle = array('color'=> 'black', 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'both', 'italic' => true);

		$TfontStyle = array('bold'=>true, 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left', 'color'=>'175EA8');

		$noSpace = array('textBottomSpacing' => -1);    

		$table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => '8EAADB', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0 ));

		$table2 = $section->addTable('myOwnTableStyle');



		switch ($percentile['Hexaco PI R (100) - Conscientiousness']) {

				case $percentile['Hexaco PI R (100) - Conscientiousness'] <= 40:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					if($percentile['Hexaco PI R (100) - Conscientiousness'] <= 0){

						$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Conscientiousness']).' percentile, meaning '.$doplease.' scored better than none of the people in the norm sample. '

					    . 'The candidate is in the extremely low range when compared '

					    . 'to individuals from the norm sample. '

					    . ''.ucfirst(strtolower($name)).' tends to be unconcerned with orderly surroundings or schedules and '.$doplease.' avoids difficult tasks or challenging goals. The score suggests that '.$doplease.' is satisfied with work that contains some errors and makes decisions on impulse or with little reflection. ',$fontStyle);

					}else{

						$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Conscientiousness']).' percentile, meaning '.$doplease.' scored better than '.$percentile['Hexaco PI R (100) - Conscientiousness'].'% of the people in the norm sample. '

					    . 'The candidate is in the extremely low range when compared '

					    . 'to individuals from the norm sample. '

					     . ''.ucfirst(strtolower($name)).' tends to be unconcerned with orderly surroundings or schedules and '.$doplease.' avoids difficult tasks or challenging goals. The score suggests that '.$doplease.' is satisfied with work that contains some errors and makes decisions on impulse or with little reflection. ',$fontStyle);

					}

					$section->addTextBreak(1);

					break;

				case $percentile['Hexaco PI R (100) - Conscientiousness'] > 40:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Conscientiousness']).' percentile, meaning '.$doplease.' scored better than '.$percentile['Hexaco PI R (100) - Conscientiousness'].'% of the people in the norm sample. '

					    . 'The candidate is in the high range when compared '

					    . 'to individuals from the norm sample. '

					     . ''.ucfirst(strtolower($name)).' organises '.$because.' time and physical surroundings and work in a disciplined way toward '.$because.' goals. '.ucfirst($doplease).' strives for accuracy and perfection in '.$because.' tasks and deliberates carefully when making decisions.',$fontStyle);

					$section->addTextBreak(1);

					break;

				default:

					# code...

					break;

			}



		$textrun = $section->addTextRun('Heading3');

		$textrun->addText('Altruism', array("color" => "175EA8", "bold" =>true));



		$tableStyle = array('borderSize' => 1, 'borderColor' => '8EAADB', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0);

		$styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'8EAADB','borderLeftSize'=>1,'borderLeftColor' =>'8EAADB','borderRightSize'=>1,'borderRightColor'=>'8EAADB','borderBottomSize' =>1,'borderBottomColor'=>'8EAADB' ,'bgcolor'=> '8EAADB');

		$TstyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'8EAADB','borderLeftSize'=>1,'borderLeftColor' =>'8EAADB','borderRightSize'=>1,'borderRightColor'=>'8EAADB','borderBottomSize' =>1,'borderBottomColor'=>'8EAADB' ,'bgcolor'=> '8EAADB','spaceBefore' => 10);

		$fontStyle = array('color'=> 'black', 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'both', 'italic' => true);

		$TfontStyle = array('bold'=>true, 'size'=>11, 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'alignment'=> 'left', 'color'=>'175EA8');

		$noSpace = array('textBottomSpacing' => -1);    

		$table = $section->addTable('myOwnTableStyle',array('borderSize' => 1, 'borderColor' => '8EAADB', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0 ));

		$table2 = $section->addTable('myOwnTableStyle');



	switch ($percentile['Hexaco PI R (100) - Altruism']) {

				case $percentile['Hexaco PI R (100) - Altruism'] <= 40:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					if($percentile['Hexaco PI R (100) - Altruism'] <= 0){

						$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Altruism']).' percentile, meaning '.$doplease.' scored better than none of the people in the norm sample. '

					    . 'The candidate is in the low range when compared '

					    . 'to individuals from the norm sample. '

					    . 'This score suggests that '.ucfirst(strtolower($name)).' is not upset by the prospect of hurting others and may be seen as hard-hearted.',$fontStyle);

					}else{

						$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Altruism']).' percentile, meaning '.$doplease.' scored better than '.$percentile['Hexaco PI R (100) - Altruism'].'% of the people in the norm sample. '

					    . 'The candidate is in the low range when compared '

					    . 'to individuals from the norm sample. '

					    . 'This score suggests that '.ucfirst(strtolower($name)).' is not upset by the prospect of hurting others and may be seen as hard-hearted.',$fontStyle);

					}

					$section->addTextBreak(1);

					break;

				case $percentile['Hexaco PI R (100) - Altruism'] > 40:

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText('Result:',$TfontStyle);

					$table->addRow(-0.5, array('exactHeight' => -5));

					$table->addCell(10000,$styleCell)->addText(ucfirst(strtolower($name)).' scored in the '.addOrdinalNumberSuffix($percentile['Hexaco PI R (100) - Altruism']).' percentile, meaning '.$doplease.' scored better than '.$percentile['Hexaco PI R (100) - Altruism'].'% of the people in the norm sample. '

					    . 'The candidate is in the high range when compared '

					    . 'to individuals from the norm sample. '

					    . 'This score suggests that '.ucfirst(strtolower($name)).' is likely to avoid causing harm and react with generosity towards those who are weak or in need of help.',$fontStyle);

					$section->addTextBreak(1);

					break;

				default:

					# code...

					break;

			}



		}



		// Begin code

		$section = $phpWord->addSection();



		$textrun = $section->addTextRun('Heading2');

		$textrun->addText('Propensity to Morally Disengage', array("color" => "175EA8", 'size' => 16, 'bold' => true));

		$section->addLine(

		  array(

		    'width'    => 600,

		    'height'   => 0,

		    'positioning' => 'absolute',

		    'color'    => '#175EA8',

		    'weight'	 => '2',

		  )

		);

		//add the graph
		//function to get color of bar
		function getDisengageBarColor($mark){

			if($mark <= 50){
				$color = "#ff0000";
			}else{
				$color = "#175ae8";
			}

			return $color;

		}

		//initialise and set cookie
		$cookie_name = "disengage";

		//generate the image

		?>

	<script type="text/javascript">
		//google.load("visualization", "1.1", {packages:["bar"]});
      google.load("visualization", "1.1", {packages:["corechart"]});
      google.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ["", "Percentile", { role: "style" }, { role: 'annotation'}],
		    ["Attribution of Blame", <?php echo $percentile['Moral Disengagement - Attribution of Blame']; ?>, "<?php echo getDisengageBarColor($percentile['Moral Disengagement - Attribution of Blame']); ?>", "Attribution of Blame - <?php echo $percentile['Moral Disengagement - Attribution of Blame']; ?>"],
		    ["Dehumanisation", <?php echo $percentile['Moral Disengagement - Dehumanisation']; ?>, "<?php echo getDisengageBarColor($percentile['Moral Disengagement - Dehumanisation']); ?>", "Emotionality - <?php echo $percentile['Moral Disengagement - Dehumanisation']; ?>"],
		    ["Distortion of Consequences", <?php echo $percentile['Moral Disengagement - Distortion of Consequences']; ?>, "<?php echo getDisengageBarColor($percentile['Moral Disengagement - Distortion of Consequences']); ?>", "Distortion of Consequences - <?php echo $percentile['Moral Disengagement - Distortion of Consequences']; ?>"],
		    ["Diffusion of Responsibility", <?php echo $percentile['Moral Disengagement - Diffusion of Responsibility']; ?>, "<?php echo getDisengageBarColor($percentile['Moral Disengagement - Diffusion of Responsibility']); ?>", "Diffusion of Responsibility - <?php echo $percentile['Moral Disengagement - Diffusion of Responsibility']; ?>"],
		    ["Displacement of Responsibility", <?php echo $percentile['Moral Disengagement - Displacement of Responsibility']; ?>, "<?php echo getDisengageBarColor($percentile['Moral Disengagement - Displacement of Responsibility']); ?>", "Displacement of Responsibility - <?php echo $percentile['Moral Disengagement - Displacement of Responsibility']; ?>"],
		    ["Advantageous Comparison", <?php echo $percentile['Moral Disengagement - Advantageous Comparison']; ?>, "<?php echo getDisengageBarColor($percentile['Moral Disengagement - Advantageous Comparison']); ?>", "Advantageous Comparison - <?php echo $percentile['Moral Disengagement - Advantageous Comparison']; ?>"],
		    ["Euphemistic Labelling", <?php echo $percentile['Moral Disengagement - Euphemistic Labelling']; ?>, "<?php echo getDisengageBarColor($percentile['Moral Disengagement - Euphemistic Labelling']); ?>", "Euphemistic Labelling - <?php echo $percentile['Moral Disengagement - Euphemistic Labelling']; ?>"],
		    ["Moral Justification", <?php echo $percentile['Moral Disengagement - Moral Justification']; ?>, "<?php echo getDisengageBarColor($percentile['Moral Disengagement - Moral Justification']); ?>", "Moral Justification - <?php echo $percentile['Moral Disengagement - Moral Justification']; ?>"],
		    ["Total Score", <?php echo $percentile['Moral Disengagement - Total Score']; ?>, "<?php echo getDisengageBarColor($percentile['Moral Disengagement - Total Score']); ?>", "Total Score - <?php echo $percentile['Moral Disengagement - Total Score']; ?>"]
        ]);

         var view = new google.visualization.DataView(data);
	      view.setColumns([0, 1,
	                       { calc: "stringify",
	                         sourceColumn: 1,
	                         type: "string",
	                         role: "annotation" },
	                       2]);

        var options = {
        	 hAxis : { 
		        textStyle : {
		            fontSize: 5 // or the number you want
		        }

		    },
          title: '',
          width: 600,
          legend: { position: 'none' },
          chart: { title: '',
                   subtitle: '' },
          bars: 'horizontal', // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: 'top', label: 'Percentage'} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%" }
        };

          //var chart = new google.charts.Bar(document.getElementById('top_x_div'));
          var chartContainer = document.getElementById('dual_x_div1');
        var chart = new google.visualization.BarChart(document.getElementById("dual_x_div1"));
        // chart.draw(data, options);

        google.visualization.events.addListener(chart, 'ready', function () {
		    var canvas;
		    var domURL;
		    var imageNode;
		    var imageURL;
		    var svgParent;

		    // add svg namespace to chart
		    domURL = window.URL || window.webkitURL || window;
		    svgParent = chartContainer.getElementsByTagName('svg')[0];
		    svgParent.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
		    imageNode = chartContainer.cloneNode(true);
		    imageURL = domURL.createObjectURL(new Blob([svgParent.outerHTML], {type: 'image/svg+xml'}));
		    image = new Image();
		    image.onload = function() {
				canvas = document.getElementById('canvas1');
				canvas.setAttribute('width', parseFloat(svgParent.getAttribute('width')));
				canvas.setAttribute('height', parseFloat(svgParent.getAttribute('height')));
				canvas.getContext('2d').drawImage(image, 0, 0);
				console.log(canvas.toDataURL('image/jpg'));
				var data = canvas.toDataURL();
				var fileName = "PersonalityProfile.jpg";
				var strMimeType = 'image/jpg';
				// download(data, fileName, strMimeType);
				save_img(data);
		    }
		    image.src = imageURL;
		  });

		  chart.draw(data, options);
      };

      //to save the canvas image
		function save_img(data){
			//ajax method.
			$.post('process.php', {data: data}, function(res){
				//if the file saved properly, trigger a popup to the user.
				if(res != ''){
					
					//create cookie
					document.cookie = "disengage="+res;
				}
				else{
					alert('something wrong');
				}
			});
		}

	</script>

	<div id="dual_x_div1" class="hidden"></div>
	<canvas class="hidden" id="canvas1"></canvas>

<?php
		setcookie($cookie_name);
	// /	print_r($_COOKIE);

		//add image for the test
		$section->addImage('../img/reports/graphimg/'.$_COOKIE['disengage'].'.jpg', array('width' => 600, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

		//add the paragraph

	$section->addText(

	  'The way an individual cognitively process decisions and behavior with ethical import '

	    . 'that '

	    . 'allows those inclined '

	    . 'to morally disengage to behave unethically without '

	    . 'feeling distress. ',

	   array('size'=>11), array('alignment'=>'both', 'widowControl' => false)

	);

	//add the graph

	//add the paragraph

	$section->addText(

	  'Moral Justification - Engaging '

	    . 'in bad or unethically behavior '

	    . 'because there is a moral '

	    . 'justification for it. So worth ends are used to justify unethical'

	    . ' means.',

	   array('size'=>11), array('alignment'=>'both', 'widowControl' => false)

	);

	$section->addText(

	  'Euphemistic Labelling – Assesses'

	    . ' the extent to which individuals use sanitised or convoluted '

	    . 'language for unethical or bad behavior in order to make the practices personally and socially '

	    . 'acceptable. High scorers tend to act unethically by sugar-coating harmful activities in '

	    . 'innocuous language.',

	   array('size'=>11), array('alignment'=>'both', 'widowControl' => false)

	);

	$section->addText(

	  'Advantageous Comparison - Assesses '

	    . 'the extent to which individuals want to make bad '

	    . 'behavior or unethical conduct seem of little consequence by comparing it to much worse '

	    . 'behavior. '

	    . 'High scorers tend to act unethically. ',

	   array('size'=>11), array('alignment'=>'both', 'widowControl' => false)

	);

	$section->addText(

	  'Displacement of Responsibility - Assess '

	    . 'the extent to which the individual attribute the '

	    . 'responsibility for one’s actions to authority figures who may have tacitly condoned or '

	    . 'explicitly directed behavior for example giving the excuse that “I am just following orders.” '

	    . 'People view their actions as stemming from the dictates of authorities rather than being personally responsible for them. High scorers tend to act unethically.',

	   array('size'=>11), array('alignment'=>'both', 'widowControl' => false)

	);

	$section->addText(

	  'Diffusion of Responsibility - Assesses the extent to which personal accountability for one’s '

	    . 'contribution to harmful activities is reduced by group decision making and group action so '

	    . 'no one really feels personally responsible. Evident when people engage in unethical conduct '

	    . 'or bad behavior because people can’t be blamed for doing things that are technically wrong '

	    . 'when all their colleagues are doing it too. High scorers tend to engage in unethical conduct. ',

	   array('size'=>11), array('alignment'=>'both', 'widowControl' => false)

	);

	$section->addText(

	  'Attribution of Blame - Assess '

	    . 'the extent to which a person feels caused to transgress against '

	    . 'another due to forceful provocation by the victim or by compelling circumstances. As a result, '

	    . 'perpetrators consider themselves victims of circumstance rather than being culpable for their '

	    . 'actions. High scorers tend to act unethically.',

	   array('size'=>11), array('alignment'=>'both', 'widowControl' => false)

	);
	$section->addText(

	  'Distortion of Consequences - Assess '

	    . 'the extent to which '

	    . 'the individual’s detrimental '

	    . 'consequences of harmful conduct are ignored, minimized or distorted. High scorers tend to '

	    . 'act unethically. ',

	   array('size'=>11), array('alignment'=>'both', 'widowControl' => false)

	);

	$section->addText(

	  'Dehumanization – Assess '

	    . 'the extent to which an individual denigrate the victim of their '

	    . 'action by redefining them as less human. Any time anyone reduces an individual to a single '

	    . 'characteristic especially negative they are already dehumanizing. High Scorers tend to act '

	    . 'unethically.',

	   array('size'=>11), array('alignment'=>'both', 'widowControl' => false)

	);

	$section->addTextBreak(1);


	if($normgroup == 'Senior Management/Executive'){



		$levels = 'senior managers ';



	}else{



		$levels = 'junior managers ';



	}



	$textrun = $section->addTextRun('Heading2');

	$textrun->addText('Our Observations', array("color" => "175EA8", 'size' => 16, 'bold' => true));

	$section->addLine(

	  array(

	    'width'    => 600,

	    'height'   => 0,

	    'positioning' => 'absolute',

	    'color'    => '#175EA8',

	    'weight'	 => '2',

	  )

	);

	if(isset($percentile['Hexaco PI R (100) - Honesty-Humility'])){

		switch ($percentile['Hexaco PI R (100) - Honesty-Humility']) {

				case $percentile['Hexaco PI R (100) - Honesty-Humility'] <= 40:

					//add text

					$section->addText(

					  'It is very likely that '

					    . ucfirst(strtolower($name)).' is going to flatter others to get what '.$doplease.' want and '.$doplease.' is '

					    . 'inclined to break rules for personal profit. '

					    . ucfirst(strtolower($name)).' is motivated by material gain and '

					    . 'feels a strong sense of self-importance.',

					  array('size'=>11, 'alignment'=>'both'), array('widowControl' => false, 'alignment'=> 'both')

					);

					break;

				case $percentile['Hexaco PI R (100) - Honesty-Humility'] > 40:

					//add text

					$section->addText(

					  'It is very likely that '

					    . ucfirst(strtolower($name)).' avoids manipulating others for personal gain and '.$doplease.' '

					    . 'feels little temptation to break rules. '

					    . ucfirst(strtolower($name)).' is uninterested in lavish wealth and luxuries, and feels no special entitlement '

					    . 'to elevated social status.',

					  array('size'=>11, 'alignment'=>'both'), array('widowControl' => false, 'alignment'=> 'both')

					);

					break;

				default:

					# code...

					break;

			}

		}

	if(isset($percentile['Hexaco PI R (100) - Altruism'])){

		switch ($percentile['Hexaco PI R (100) - Altruism']) {

				case $percentile['Hexaco PI R (100) - Altruism'] <= 40:

					//add text

					$section->addText(

					  'It is very likely that '

					    . ucfirst(strtolower($name)).' is not upset by the prospect of hurting '

					    . 'others '

					    . 'and may be seen as '

					    . 'hard-hearted.',

					  array('size'=>11, 'alignment'=>'both'), array('widowControl' => false, 'alignment'=> 'both')

					);

					break;

				case $percentile['Hexaco PI R (100) - Altruism'] > 40:

					//add text

					$section->addText(

					  'It is very likely that '

					    . ucfirst(strtolower($name)).' avoids causing harm and '

					    . 'react with generosity '

					    . 'towards those who are weak or '

					    . 'in need of help.',

					  array('size'=>11, 'alignment'=>'both'), array('widowControl' => false, 'alignment'=> 'both')

					);

					break;

				default:

					# code...

					break;

			}

		}

	if(isset($percentile['Moral Disengagement - Total Score'])){

		if($percentile['Moral Disengagement - Total Score'] >= 50){

			$section->addText(

			  'It is very likely that '

			    . ucfirst(strtolower($name)).' has an above average tendency to morally disengage '

			    . 'which '

			    . 'may nudge '.$him.' to behave'

			    . ' unethical in some circumstances.',

			  array('size'=>11, 'alignment'=>'both'), array('widowControl' => false, 'alignment'=> 'both')

			);

		}

		// switch ($percentile['Moral Disengagement - Total Score']) {

		// 		case $percentile['Moral Disengagement - Total Score'] >= 50:

		// 			//add text

		// 			$section->addText(

		// 			  'It is very likely that '

		// 			    . ucfirst(strtolower($name)).' has an above average tendency to morally disengage '

		// 			    . 'which '

		// 			    . 'may nudge '.$him.' to behave'

		// 			    . ' unethical in some circumstances.',

		// 			  array('size'=>11, 'alignment'=>'both'), array('widowControl' => false, 'alignment'=> 'both')

		// 			);

		// 			break;

		// 		default:

		// 			# code...

		// 			break;

		// 	}

		}


		if($normgroup == 'Senior Management/Executive'){

// Saving the document as OOXML file...

	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

	$repname = '../reports/senior/'.$fullname.'_'.$client.'.docx';

	$objWriter->save($repname);



		}else{

			// Saving the document as OOXML file...

	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

	$repname = '../reports/junior/'.$fullname.'_'.$client.'.docx';

	$objWriter->save($repname);

		}



	

?>