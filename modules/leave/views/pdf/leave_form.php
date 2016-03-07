 <?php
 ob_start();

 $department = Department::model()->findByPk($model->empNumber->emp_department_code);
 $position   = Position::model()->findByPk($model->empNumber->emp_position_code);
 
 $array = Yii::app()->db->createCommand('SELECT leave_details_date FROM hs_hr_emp_leaves_details where leave_id = "'.$model->leave_id . '" order by leave_details_date asc')->queryAll();
 
 //$first = EmpLeavesDetails::model()->findByAttributes(array('leave_id'=>$model->leave_id),array('order'=>'leave_details_date asc'));
 //$last = EmpLeavesDetails::model()->findByAttributes(array('leave_id'=>$model->leave_id),array('order'=>'leave_details_date desc'));
 $inclusive_dates = "";
 if (count($array) > 10)
 {
 	$inclusive_dates = date('m-d',strtotime($array[0]['leave_details_date'])) . " - ";
 	$inclusive_dates .= date('m-d',strtotime($array[count($array)-1]['leave_details_date']));	
 }else{
 	
 	$ctr = 0;
 	foreach ($array as $d){
 		if (++$ctr >= 9) $inclusive_dates .= "\n";
 			
 		$inclusive_dates .= date('m-d',strtotime($d['leave_details_date'])) . ",";
 		
 	}
 }
 
 $vl = EmpLeaveCredits::model()->getVlCredits( $model->emp_number,$model->leave_sy) + EmpLeaves::model()->getVlCommitted( $model->emp_number,$model->leave_sy);
 $sl = EmpLeaveCredits::model()->getSlCredits( $model->emp_number,$model->leave_sy) + EmpLeaves::model()->getSlCommitted( $model->emp_number,$model->leave_sy);
 
 $typeList = array('vlp' => 'Vacation Leave with Pay',
 		'slp' => 'Sick Leave with Pay',
 		'elp' => 'Emergency Leave with Pay',
 		'bl' => 'Birthday Leave',
 		'pl' => 'Paternity Leave',
 		'ml' => 'Maternity Leave',
 		'vl' => 'Vacation Leave without Pay',
 		'sl' => 'Sick Leave without Pay',
 		'el' => 'Emergency Leave without Pay',
 
 		 
 );
 
  
$params = array("author" => "Queenie", "title" => "DTR_SUMMARY", "header" => false, "footer" => false, "output" => "leave_form.pdf");
$pdf = Yii::createComponent('application.extensions.tcpdf.tcpdf', 'L', 'cm', 'MEMO', true, 'UTF-8', $params);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("Allan Lao");
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->setMargins(1, .5, 1, true);
$pdf->AliasNbPages();
$pdf->AliasNbPages();
$pdf->AddPage();

$fontFamily = "helvetica";

$pdf->SetFont($fontFamily, "", 8.5);
$html = '<style>
			
		    ul{
            list-style-type: none;
			padding: 0px;
			margin: 0px;
		   
            }
			ul li{
             padding: 0px;
			 margin: 0px;
		   
            }
			span.label
			{
		        font-size:9pt;
		       	line-height:50px;
		    
			}
			span.value
			{
			    margin-left:25px;
			    font-size:11pt;
			   	line-height:50px;
			}
		    b{
		       font-size:8pt;
             }
		    
		  
			tr,td{
				border:0.5px solid #000;
			  
			}
		    .title{
                    text-align:center;
		            font-size:14pt;
              }
	
		
		</style>';
$html .= '<span>HRO.C003.02.0</span><br>';
$html .= '<span class="title">ABRA VALLEY COLLEGE</span>';
$html .= '<div class="title">Application for Leave</div>';
$html .= '<table>
		   <tr>
		      <td>	        
		         
		            <span class="label">Name : <span class="value"> '. $model->empNumber->fullname.'</span></span>
		             <br>
		           
		            <span class="label">Department  :<span class="value"> '. $department->shortname.'</span></span>
		             <br>
		            		        
		     </td>
		    <td>
		          <span class="label">Date Filed :  <span class="value">  '. date('M d, Y',strtotime($model->leave_date_filed)).'</span></span>
		          <span class="label">Leave No :  <span class="value">  '. $model->leave_id .'</span></span>
		             <br>
		         
	         	<span class="label">Position: <span class="value">   '. substr($position->position_desc,0,30).'</span></span>
		             <br>
		            
		
		     </td>
		     
		   </tr>
	
		
		 <tr>
		      <td rowspan="2">	        
		         
		            <span class="label">Type of Leave</span>
		             <br>
		            <span class="value">   '.strtoupper($typeList[$model->leave_type]).'</span>
		             <br>
	            	<span class="label">No. of Days Applied</span>
		             <br>
		            <span class="value">   '.$model->leave_days.' Days</span>
		             <br>
		            <span class="label">Inclusive Dates</span>
		             <br>
		            <span class="label">   '. 
		                      $inclusive_dates
		            .'</span>
		             <br>
		           
					<span class="label"> Reason</span>
		             <br>
		            <span>   '.substr($model->leave_reason,0,140).'</span>
		             <br>
		
		          
	                
		     </td>
		    <td>
		          <span class="label">Certification of Leave Credits</span>
		          <br>
		          <span class="value">  VACATION LEAVE  : '.$vl.'</span>	<br>
		          <span class="value">  SICK LEAVE : '.$sl.'</span>	<br>	  	      
		          
		          <br>
		     </td>
		     
		   </tr>
		<tr>
		
		<td>
		     <span class="label">Employee\'s Signature </span><br><br>
		           
		</td>
		</tr>
		<tr>
		  <td>
		
		           
		    <span class="label">Recommending : ( )Approval ( )Disapproval</span>
		             <br><br>
		             <span>Department Head :_______________________</span>
		             <br><br>
		             <span>Comment/Remarks:_____________________________</span>
		             <br><br>
		             
		             
		  </td>
		
		
		<td>
		   
		             <br>
		             <br>
		             <span class="label">Human Resource Officer____________________</span>
		             <br><br><br>
		            
		  </td>
		</tr>
		    
		
	    	
		 </table>
		 ';

$pdf->writeHTML($html,false, false, false, false, '');



$pdf->Output();

$pdf->Output("leave_form.pdf", "I");