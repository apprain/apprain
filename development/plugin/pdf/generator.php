<?php
class Development_Plugin_PDF_Generator extends Development_Plugin_PDF_FPDF
{
	//Load data
	function LoadData($file)
	{
		//Read file lines
		$lines=file($file);
		$data=array();
		foreach($lines as $line)
			$data[]=explode(';',chop($line));
		return $data;
	}

	//Simple table
	function BasicTable($header,$data)
	{
		$this->SetFont('Helvetica','');
		$rowOpts = $this->getRowOpts();

		$preHeader = $this->getPreHeader();
		foreach($preHeader as $msg)
		{
			$this->Cell(300,6 ,$msg );
			$this->Ln();
		}
			
		$this->Cell(300,6 ,'');
		$this->Ln();

		$this->SetFont('Helvetica','B');
		//Header
		foreach($header as $key=>$col)
		{
			$this->Cell($rowOpts[$key]['width'],7,$col,1);
		}
		$this->Ln();
		//Data
		$this->SetFont('Helvetica','');
		foreach($data as $row)
		{
			foreach($row as $key=>$col)
				$this->Cell($rowOpts[$key]['width'],6,$col,1);
			$this->Ln();
		}
	}

	
	//Colored table
	function Render()
	{


		$header= $this->getHeader();
	    $data = $this->getData();

		$this->SetFont('Helvetica','',9);
		$this->AddPage("p");
		$this->BasicTable($header,$data);
		

		if( $this->getDownload())
		{
			$this->Output(DATA .'/original.pdf');
			header('Content-type: application/pdf');
			header('Content-Disposition: attachment; filename="' . $this->getReportTitle() . '_'  . App::Helper('Date')->dateFormated(null,'long') . '.pdf"');
			readfile(DATA .'/original.pdf');
		}
		else
		{
			$this->Output();
		}
		exit;
	}
	
}