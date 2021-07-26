<?php
/**
/**
 * appRain CMF
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.opensource.org/licenses/mit-license.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@apprain.com so we can send you a copy immediately.
 *
 * @copyright  Copyright (c) 2010 appRain, Team. (http://www.apprain.com)
 * @license    http://www.opensource.org/licenses/mit-license.php MIT license
 *
 * HELP
 *
 * Official Website
 * http://www.apprain.com/
 *
 * Download Link
 * http://www.apprain.com/download
 *
 * Documents Link
 * http ://www.apprain.com/docs
 */

class Component_Appreport_Helpers_Download extends Component_Appreport_Helpers_PDF_FPDF
{
	##PDF#################################################################
    public $b = 0;
	public $cellheight = 6;
	public $border = 0;
	public $rowwidth = 50;

	public $fontFamily = 'Courier';
	public $TxnRowCnt = 1;
	public $line = 0;
	public $RW = 0;
	public $Orientation = 'l';
	public $commonHeader = array();
	public $commonFooter = array();
	
	
	private function LineCount(){
		$this->line++;
		if($this->line%2==1)$this->SetFillColor(234, 242, 251);
		else $this->SetFillColor(255,255,255);
		
		$lcnt = ($this->Orientation == 'l') ?  30 : 45;
		
		if($this->line% $lcnt == 0){
			$this->PrintCotinue();
			$this->AddNewPage();
			$this->PrintCotinue(true);
		}
	}
	private function AddNewPage(){
	
		$this->SetTopMargin(10);
		$this->SetLeftMargin(6);
		$this->SetAutoPageBreak(1);
		$this->AddPage($this->Orientation);		
		$this->SetFillColor(255,255,255);
		$this->SetFont($this->fontFamily,null,9); 		
		$this->SetTextColor(0, 0, 0);		
	}
	
	private function PrintCotinue($bottom=false){
		if($bottom){
			if(!empty($this->commonHeader)){
				foreach($this->commonHeader as $row){
					$this->lineCount();
					$this->Cell($this->RW,$this->cellheight ,$row,0,1,'C',1);
				}
			}	
		}
		else{	
			if(!empty($this->commonFooter)){
				foreach($this->commonFooter as $row){
					$this->lineCount();
					$this->Cell($this->RW,$this->cellheight ,$row,0,1,'C',1);
				}		
			}
			$this->setY(-10);
			$this->SetFillColor(255,255,255);
			$this->Cell($this->RW,$this->cellheight ,'[Page ' . $this->page .  ']',0,1,'C',1);

		}
	}
	
	public function setCommonHeader($code=null){
		if(!strstr($code,'{AUTOHEADER-START}')){
			return ;
		}
		if(!strstr($code,'{AUTOHEADER-END}')){
			return ;
		}		
		$array = preg_split('/\{AUTOHEADER-START\}|\{AUTOHEADER-END\}/',$code);
		$this->commonHeader = explode("\n",trim($array[1]));
	}
	
	public function setCommonFooter($code=null){
		if(!strstr($code,'{AUTOFOOTER-START}')){
			return ;
		}
		if(!strstr($code,'{AUTOFOOTER-END}')){
			return ;
		}		
		$array = preg_split('/\{AUTOFOOTER-START\}|\{AUTOFOOTER-END\}/',$code);
		$this->commonFooter = explode("\n",trim($array[1]));
	}
	
	public function downloadPDF($id,$o='l'){
	
		$code = App::Component('appReport')->Helper('Data')->Report($id,'code');		
		
		$this->setCommonHeader($code);
		$this->setCommonFooter($code);

		$output = App::Helper('Utility')->parsePHP(trim($code));
		$output = str_replace('</pre>',"\n",$output);
		$output = strip_tags($output);

		$list = explode("\n",$output);
		$this->Orientation = $o;
		$this->RW = ($this->Orientation == 'l') ?  280 : 200;
		$this->AddNewPage();
		foreach($list as $key=>$row){
			$this->lineCount();			
			$this->Cell($this->RW,$this->cellheight ,$row,$this->border,1,'C',1);
		}		
		$this->setY(-10);
		$this->SetFillColor(255,255,255);
		$this->Cell($this->RW,$this->cellheight ,'[Page ' . $this->page .  ']',0,1,'C',1);
		$this->Output();
		
	
	}
	##TXT#################################################################
	public function downloadTXT($id,$o='l'){	
		
		$code = App::Component('appReport')->Helper('Data')->Report($id,'code');	
		$output = App::Helper('Utility')->parsePHP($code);
		$output = str_replace('</pre>',"\n",$output);
		$finalStr = strip_tags($output);
		if($o == 'st'){
			$list = explode("\n",$finalStr);
			$finalStr = '';
			foreach($list as $row){	
				if(strstr($row,'|')){
					$finalStr .= str_replace("|","\t",$row) . "\n";
				}
			}
			
		}
		App::Utility()->downloadInline($finalStr,"REPORT-{$id}.txt");
		exit;
	}
	#########################################################################
	
	public function ReportById($id,$o='l'){		
	
		if($o == 'l' || $o == 'p'){
			$this->downloadPDF($id,$o);
		}
		else{
			$this->downloadTXT($id,$o);
		}
		
		exit;
	}
	
}