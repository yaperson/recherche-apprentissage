<?php
require_once '../../../vendor/autoload.php';

// create a header style
$headerStyle = (new \OneSheet\Style\Style())
    ->setFontSize(13)
    ->setFontBold()
    ->setFontColor('FFFFFF')
    ->setFillColor('777777');

// create a data style
$dataStyle1 = (new \OneSheet\Style\Style())
    ->setFontName('Segoe UI')
    ->setFontSize(10);

// create a second data style
$dataStyle2 = (new \OneSheet\Style\Style())
    ->setFontName('Arial')
    ->setFillColor('F7F7F7');

// prepare some dummy header data
$dummyHeader = array('Strings', 'Ints', 'Floats', 'Dates', 'Times', 'Uids');

// prepare some dummy data


// create new OneSheet instance
$onesheet = new \OneSheet\Writer();

// add header with style
$onesheet->addRow($dummyHeader, $headerStyle);

// freeze everything above cell A2 (the first row will be frozen)
$onesheet->setFreezePaneCellId('A2');

// enable autosizing of column widths and row heights
$onesheet->enableCellAutosizing();

// add dummy data row by row and switch between styles
foreach ($dummyData as $key=> $data) {
    if ($key % 2) {
        $onesheet->addRow($data, $dataStyle1);
    } else {
        $onesheet->addRow($data, $dataStyle2);
    }
}

// ignore the coming rows for autosizing
$onesheet->disableCellAutosizing();

// add an oversized dummy row
$onesheet->addRow(array('no one cares about my size and I dont even have a special style!'));

// add the all the dummy rows once more, because we can =)
$onesheet->addRows($dummyData);

// Override column widths for columns 6, 7, 8 (column 0 is the first)
$onesheet->setFixedColumnWidths(array(5 => 10, 6 => 10, 7 => 10));

// write everything to the specified file
$onesheet->writeToFile(str_replace('.php', '_onesheet.xlsx', __FILE__));