<?php

$params = array("author" => "J", "title" => "Personnel Information", "header" => false, "footer" => false, "output" => "certicate2.pdf");
$fontFamily = "times";
$pdf = Yii::createComponent('application.extensions.tcpdf.tcpdf', 'P', 'cm', 'LEGAL', true, 'UTF-8', $params);


$gender = $model->emp_gender;
$status = $model->emp_marital_status;
$title = "Mr.";
$termination_date = "present";
$day = date("d");
$month = date("F");
$year = date("Y");
$basic = $model->salary->basic;
$basic_annual = $basic * 12;
$travel = $model->salary->travel;
$travel_annual = $travel * 12;
$total_pay = $travel_annual + $basic + $basic_annual;

if($gender == "Female")
{
	if($status == "Married"){
		$title = "Mrs.";
	}else{
		$title = "Ms.";	
	}
}

if($model->terminated_date != Null){
	$termination_date = $model->terminated_date;
}

$pdf->SetCreator(PDF_CREATOR);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->setMargins(2, 1, 2, true);
$pdf->AliasNbPages();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Cell(0, 4, "", 0, 1, 'L');
$pdf->SetFont($fontFamily, "BI", 22);
$pdf->Cell(0, 0, "CERTIFICATION", 0, 1, 'C');
$pdf->Cell(0, 2, "", 0, 1, 'L');

$pdf->SetFont($fontFamily, "B", 12);
$pdf->Cell(0, 0, "To Whom It May Concern", 0, 1, 'L');
$pdf->Cell(0, 0.5, "", 0, 1, 'L');

$pdf->SetFont($fontFamily, "", 12);
$pdf->writeHTML("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is to certify that <u>".$title.$model->emp_firstname.' '.$model->emp_lastname."</u> is employed at Lorma Colleges as a Full-time Instructor in the ". $model->departments->name." from ".$model->joined_date." to ".$termination_date.".",true,false,false,false,'J');
$pdf->Cell(0, .5, "", 0, 1, 'L');
$pdf->writeHTML("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;It is further certified that he/she is being given the following compensation benefits:",true,false,false,false,'J');
$pdf->Cell(0, .5, "", 0, 1, 'L');
$pdf->SetFont($fontFamily, "", 10);
$pdf->SetLeftMargin(3);
$pdf->writeHTML("<table>
						<tbody>
							<tr>
								<td>Basic Salary (Monthly)</td>
								<td>P    ".number_format($basic ,$decimals = 0 ,$dec_point = '.' ,$thousands_sep = ',' )."</td>
								<td></td>
							</tr>
							<tr>
								<td>Basic Salary (Annual)</td>
								<td></td>
								<td>P    ".number_format($basic_annual ,$decimals = 0 ,$dec_point = '.' ,$thousands_sep = ',' )."</td>
							</tr>
							<tr>
								<td>13th month pay</td>
								<td></td>
								<td>P    ".number_format($basic ,$decimals = 0 ,$dec_point = '.' ,$thousands_sep = ',' )."</td>
							</tr>
							<tr>
								<td>Travel Allowance (Monthly</td>
								<td>P     ".number_format($travel ,$decimals = 0 ,$dec_point = '.' ,$thousands_sep = ',' )."</td>
								<td></td>
							</tr>
							<tr>
								<td>Travel Allowance (Annual)</td>
								<td></td>
								<td>P    ".number_format($travel_annual ,$decimals = 0 ,$dec_point = '.' ,$thousands_sep = ',' )."</td>
							</tr>
							<tr>
								<td><b>TOTAL</b></td>
								<td></td>
								<td><b>P   ".number_format($total_pay ,$decimals = 0 ,$dec_point = '.' ,$thousands_sep = ',' )."</b></td>
							</tr>
						</tbody>
					</table>",true,false,false,true,'L');
$pdf->Cell(0, .5, "", 0, 1, 'L');
$pdf->SetLeftMargin(2);
$pdf->SetFont($fontFamily, "", 12);
$pdf->writeHTML("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This certification is issued upon the request of <u>".$title.$model->emp_lastname."</u> to support his/her application for a (credit card or loan). ",true,false,false,false,'J');
$pdf->Cell(0, .5, "", 0, 1, 'L');
$pdf->writeHTML("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Given this ".$day."th day of ".$month." ".$year." at Carlatan, San Fernando City, La Union.",true,false,false,false,'J');
$pdf->Cell(0, 2, "", 0, 1, 'L');

$pdf->SetFont($fontFamily, "B", 12);
$pdf->Cell(0, 0, Yii::app()->params['hr_signatory'], 0, 1, 'R');

$pdf->SetFont($fontFamily, "", 12);
$pdf->Cell(0, 0, Yii::app()->params['hr_position'], 0, 1, 'R');

$pdf->Output();

$pdf->Output("certificate2.pdf", "I");
// return $pdf;
?>