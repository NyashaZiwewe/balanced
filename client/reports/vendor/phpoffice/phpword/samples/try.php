<?php
include_once 'Sample_Header.php';

use PhpOffice\PhpWord\Shared\Converter;

// New Word document
echo date('H:i:s'), ' Create new PhpWord object', EOL;
$phpWord = new \PhpOffice\PhpWord\PhpWord();

// Define styles
$phpWord->addTitleStyle(1, array('size' => 14, 'bold' => true), array('keepNext' => true, 'spaceBefore' => 240));
$phpWord->addTitleStyle(2, array('size' => 14, 'bold' => true), array('keepNext' => true, 'spaceBefore' => 240));

// 2D charts
$section = $phpWord->addSection();
$section = $phpWord->addSection(array('colsNum' => 2, 'breakType' => 'continuous'));

$chartTypes = array('bar');
$twoSeries = array('bar');
$threeSeries = array('bar');
$fourSeries = array('bar');
$categories = array('A');
$series1 = array(1);
$series2 = array(3);
$series3 = array(8);
$series4 = array(2);

foreach ($chartTypes as $chartType) {
    $chart = $section->addChart($chartType, $categories, $series1);
    $chart->getStyle()->setWidth(Converter::inchToEmu(2.5))->setHeight(Converter::inchToEmu(2));
    if (in_array($chartType, $twoSeries)) {
        $chart->addSeries($categories, $series2);
    }
    if (in_array($chartType, $threeSeries)) {
        $chart->addSeries($categories, $series3);
    }
    if (in_array($chartType, $fourSeries)) {
        $chart->addSeries($categories, $series4);
    }
    $section->addTextBreak();
}

// Save file
echo write($phpWord, basename(__FILE__, '.php'), $writers);
if (!CLI) {
    include_once 'Sample_Footer.php';
}
