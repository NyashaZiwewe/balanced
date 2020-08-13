<?php

print_r($percentile);
// print_r($associative);

	//include the PHP word files

	require_once 'vendor/autoload.php';



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

	// $section->addImage('../img/reports/logo.png', array('width' => 250, 'height' => 120, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));



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
      	$percentile=80;
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




	//add table

		// Saving the document as OOXML file...
	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
	$repname = 'reports/nyasha/'.getOwner($_GET['sid']).' Performance Report.docx';
	$objWriter->save($repname);

	

?>