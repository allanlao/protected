<?php $this->widget('bootstrap.widgets.TbAlert', array(
		'block'=>true, // display a larger alert block?
		'fade'=>true, // use transitions?
		'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
		
    )); 
?>
<?php

$period = EvaluationPeriod::model()->findByPk($id);

$box = $this->beginWidget ( 'bootstrap.widgets.TbBox', array (
		'title' => 'List of Employee to Evaluate [ '. $period->sem . ' SEM SY ' . $period->sy .'  ]',
		'headerIcon' => 'icon-edit',
		// when displaying a table, if we include bootstrap-widget-table class
		// the table will be 0-padding to the box
		'htmlOptions' => array (
		//'class' => 'bootstrap-widget-table' 
		),
		
		
)
 );
?>

<table class="table table-hover fixed ">
	
	<thead>
		<th>#</th>	
		<th>Employee Name</th>
		<th>Rating</th>
		<th>Action</th>

	</thead>
	<tbody>
              <?php 
              $ctr = 0;
             
              $group = ""; 
     
      	foreach($result as $row)
      	{
      		
      		
      	  //if company changes add a new header row
      		if ($group != $row['title'])
      		{
      			$group = $row['title'];
      			
      		echo "<tr>
				  <td colspan='11' style='background-color:beige'>".$group."</td>
				  </tr>";	
      		
      		}
      		$link = "none";
      		$action = "";
      		$actionReset = "";
      		//what controller to use?
      		if ($row['evaluation_type'] == 1) //peer
      		{
      			$action = "evaluation/peerEvaluation";
      			$actionReset = "evaluation/peerReset";
      			
      		
      		}else if ($row['evaluation_type'] == 2) //faculty by dean (2031)
      		{
      			
      			$action = "evaluation/facultyByDean";
      			$actionReset = "evaluation/facultyByDeanReset";
      			
      			
      		}else if ($row['evaluation_type'] == 3) //staff by head
      		{
      			$action = "evaluation/staffByHead";
      			$actionReset = "evaluation/staffByHeadReset";
      			
      			
      		}else if ($row['evaluation_type'] == 4) //head by subordinate
      		{
      			
      			$action = "evaluation/headBySubordinate";
      			$actionReset = "evaluation/headBySubordinateReset";
      		}
      		
      		else if ($row['evaluation_type'] == 5) //contractual by head
      		{
      			 
      			$action = "evaluation/contractual";
      			$actionReset = "evaluation/contractualReset";
      		}
      		else if ($row['evaluation_type'] == 6) //Academics Heads by Academic Affairs
      		{
      		
      			$action = "evaluation/headEvaluation";
      			$actionReset = "evaluation/headEvaluationReset";
      		}
      		
      		else if ($row['evaluation_type'] == 7) //faculty by Dean (Old)
      		{
      		
      			$action = "evaluation/facultyByHead";
      			$actionReset = "evaluation/facultyByHeadReset";
      		}
      		
      		
      		
      		
      		
      		if ($row['rating'] == null || $row['rating'] <=0)
      		{
      			$link =CHtml::link('Evaluate',array($action,
      					'emap_id'=>$row['emap_id'],
      			));
      		}else{
      			/*$link = CHtml::link('Reset',"#", array("submit"=>array($actionReset,
      					'emap_id'=>$row['emap_id'],'eperiod_id'=>$id
      					
      					 
      			), 'confirm' => 'Are you sure you want to reset your evaluation?'));
      			 */
      		}
      		
      		?>
            <tr>
			<td><?php echo ++$ctr;?></td>
			
			<td><?php echo $row['emp_lastname'] . ', ' . $row['emp_firstname'];?></td>
			<td  id="<?php echo 'rating'. $row['emap_id']?>"><?php echo $row['rating'];?></td>
			<td  id="<?php echo 'link'.$row['emap_id']?>"><?php echo $link;?></td>
			
		    </tr>
          <?php 
      	
      	    }
          ?> 	
             </tbody>


</table>





<?php $this->endWidget(); ?>
