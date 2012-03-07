<?php

/**
 * Create PDF file with a specific template.
 * This way you have less paramters to define.
 */

$pdf = new Ztools_Pdf('myNewFile.pdf');
$pdf->setTemplate( Ztools_Pdf::TEMPLATE_LETTER_LARGE_FONT );

$file = Ztools_File::read('myTextFile.txt');
$pdf->setContent($file);

$pdfData = $pdf->create();

Ztools_File::write('myNewFile.pdf', $pdfData);