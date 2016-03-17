<?php
$params = array("author" => "a", "title" => "Personnel Information", "header" => false, "footer" => false, "output" => "biodata.pdf");
$fontFamily = "Helvetica";
$pdf = Yii::createComponent('application.extensions.tcpdf.tcpdf', 'P', 'cm', 'LEGAL', true, 'UTF-8', $params);


$pdf->SetCreator(PDF_CREATOR);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->setMargins(2, 1, 2, true);
$pdf->AliasNbPages();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont($fontFamily, "", 11);

$pdf->Cell(0, 0, Yii::app()->params['company'], 0, 1, 'C');
$pdf->Cell(0, 0, 'List of Active Employees' , 0, 1, 'C');
$pdf->Cell(0, 1, "", 0, 1, 'L');

$ctr=0;
$dep="";

$tbl =	'<style>
			th{
				font-weight:bold;
			}
			td{
				font-weight:regular;
			}
		</style>
		<table cellspacing=0 cellpadding=0>
		<tr>
		    <th width="10%">No.</th>
 			<th width="60%">Name</th>
 			<th width="30%">Position</th>
		</tr>'
		;


     foreach($employees as $employee)
     {

            if($employee->department->name != $dep){
			$tbl .= 		
		 
		    '<tr>
		    	<th colspan="2" bgcolor="beige">'.$employee->department->name.'</th>
		    </tr>';

            $dep =$employee->department->name;
            $ctr = 1;
            }

            	if (is_null($employee->empPosition)){
            $position =  "";
                 }else{
                 	 $position = $employee->empPosition->position_desc;
                 }

          

     		$tbl .= 		
		 
		    '<tr>
		        <td>'.$ctr.'</td>
		    	<td>'.$employee->fullname.'</td>
		    	<td>'.$position.'</td>
		    </tr>';
		    $ctr += 1;
     }

		


$tbl .= "</table>";

$pdf->writeHTML($tbl);

$pdf->Cell(0, 0, "Approved by:", 0, 1, 'L');
$pdf->Cell(0, 1, "", 0, 1, 'L');

$tbl_signatories = "
					<table>
						<tbody>
							<tr>
								<td>_________________________<br/>HR Office</td>
			
								<td>_________________________<br/>President</td>
							</tr>
						</tbody>
					</table>
				   ";

$pdf->writeHTML($tbl_signatories);


$html = <<<EOD
	<style>
		p{font-size:7pt;}
		i {font-weight:bold;font-style:normal;}
	</style>
	<p>
	<hr>

	<p>
EOD;
$pdf->writeHTMLCell($w=0, $h=0, $x='2', $y='32', $html, $border=0, $ln=0, $fill=0, $reseth=true, $align='L', $autopadding=false);

$pdf->Output();

$pdf->Output("ActiveEmployees.pdf", "I");