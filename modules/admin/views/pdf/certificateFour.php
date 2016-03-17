<?php

$params = array("author" => "Jessie Mique", "title" => "Personnel Information", "header" => false, "footer" => false, "output" => "certificate4.pdf");
$fontFamily = "times";
$pdf = Yii::createComponent('application.extensions.tcpdf.tcpdf', 'P', 'cm', 'LEGAL', true, 'UTF-8', $params);

$gender = $model->emp_gender;
$status = $model->emp_marital_status;
$title = "Mr.";
$termination_date = "present";
$day = date("d");
$month = date("F");
$year = date("Y");

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
$pdf->SetAuthor("Jessie Mique");
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
$pdf->writeHTML("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is to certify that <u>".$title.$model->emp_firstname.' '.$model->emp_lastname."</u> was employed by Lorma Colleges as a Full-time Instructor of the ". $model->department->name." from ". $model->joined_date." to ".$termination_date.".",true,false,false,false,'J');
$pdf->Cell(0, .5, "", 0, 1, 'L');
$pdf->writeHTML("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This certification is issued upon the request of <u>".$title.$model->emp_lastname."</u> for any legal intent and purpose it may serve his/her.",true,false,false,false,'J');
$pdf->Cell(0, .5, "", 0, 1, 'L');
$pdf->writeHTML("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Given this ".$day."th day of ".$month." ".$year." at " . Yii::app()->params['address'],true,false,false,false,'J');
$pdf->Cell(0, 2, "", 0, 1, 'L');
$pdf->SetFont($fontFamily, "B", 12);
$pdf->Cell(0, 0, Yii::app()->params['hr_signatory'], 0, 1, 'R');
$pdf->SetFont($fontFamily, "", 12);
$pdf->Cell(0, 0, Yii::app()->params['hr_position'], 0, 1, 'R');
$pdf->SetFont($fontFamily, "", 12);
$pdf->Cell(0, 2, "*this is issued to resigned employees", 0, 1, 'L');

$pdf->Output();

$pdf->Output("certificate4.pdf", "I");
// return $pdf;
?>