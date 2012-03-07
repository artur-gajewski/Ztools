<?php

/**
 * Create PDF file with given parameters
 */

$pdf = new Ztools_Pdf('testi.pdf');
$pdf->setColor( '#000000' );
$pdf->setPageSize( '#000000' );


$this->_content = $content;
        $this->_color = '#000000';
        $this->_pageSize = Ztools_Pdf::SIZE_A4;
        $this->_fontSize = 8;
        $this->_pageWidth = 143;
        $this->_topMargin = 800;
        $this->_encoding = 'UTF-8';
        $this->_filename = 'myfile.pdf';

$file = Ztools_File::read('mycontent.txt');
$pdf->setContent($file);

$pdfData = $pdf->create(true);

Ztools_File::write('myPdf.pdf', $pdfData);


$pdf = new Ztools_Pdf('myNewFile.pdf');
$pdf->setTemplate( Ztools_Pdf::TEMPLATE_LETTER_LARGE_FONT );

$file = Ztools_File::read('myTextFile.txt');
$pdf->setContent($file);

$pdfData = $pdf->create();

Ztools_File::write('myNewFile.pdf', $pdfData);