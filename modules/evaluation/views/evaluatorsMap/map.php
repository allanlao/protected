<?php
/* @var $this DefaultController */

 $this->breadcrumbs=array(
	$this->module->id,
); 
?>
<?php $this->widget('bootstrap.widgets.TbAlert', array(
		'block'=>true, // display a larger alert block?
		'fade'=>true, // use transitions?
		'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
		
    )); 
?>
<?php 
	$this->renderPartial('_map',array('selected_period'=>$selected_period,
'selected_dept'=>$selected_dept,

));
	
?>	



<div id="leave-pending">
   

<?php 

  $etype = EvaluationType::model()->findByPk($selected_dept);
   $box = $this->beginWidget ( 'bootstrap.widgets.TbBox', array (
		'title' => ' Summary',
		'headerIcon' => 'icon-th-list',
		'htmlOptions' => array (
				'class' => 'bootstrap-widget-table' 
		) 
) );
?>
   
<table class="table table-hover fixed">
<thead>
<th>Evaluation Type</th>
<th>Employee</th>
<th>Employee to Evaluate</th>
<th>Date</th>
</thead>
<tbody>
<?php 
    foreach($result as $row)
    {
    	$date = 'No Evaluation';
    	$etype ='';
    	if ($row['evaluation_type'] == 1)
    	{
    		$etype ='Peer';
    		$model=PeerEvaluation::model()->findByPk($row['emap_id']);
    			if ($model)
    			$date= $model->date;
    	}elseif ($row['evaluation_type'] == 2)
		{
			$etype ='Faculty by Dean';
			$model=FacultyByDeanEvaluation::model()->findByPk($row['emap_id']);
			if ($model)
				$date= $model->date;
		
    	}elseif ($row['evaluation_type'] == 3)
		{
			$etype ='Staff by Head';
			$model=StaffByHeadEvaluation::model()->findByPk($row['emap_id']);
			if ($model)
				$date= $model->date;
		
    	}elseif ($row['evaluation_type'] == 4)
		{
			$etype ='Head by Subordinate';
			$model=HeadBySubordinateEvaluation::model()->findByPk($row['emap_id']);
			if ($model)
				$date= $model->date;
		
    	}elseif ($row['evaluation_type'] == 5)
		{
			$etype ='Contractual by Head';
			$model=ContractualByHeadEvaluation::model()->findByPk($row['emap_id']);
			if ($model)
				$date= $model->date;
		
    	}elseif ($row['evaluation_type'] == 6)
		{
			$etype ='Acad Head By Acad. Affairs';
			$model=HeadEvaluation::model()->findByPk($row['emap_id']);
			if ($model)
				$date= $model->date;
		
    	}elseif ($row['evaluation_type'] == 7)
		{
			$etype ='Faculty by Dean (old)';
			$model=FacultyByHeadEvaluation::model()->findByPk($row['emap_id']);
			if ($model)
				$date= $model->date;
		
    	}
    	$name = Employee::model()->findByPk($row['emp_to_evaluate']);
    	?>
    	<tr>
        <td><?php echo $etype; ?></td>
    	<td><?php echo $row['name']; ?></td>
    	<td><?php echo $name->getFullName(); ?></td>
    	<td><?php echo $date;?></td>
    	</tr>
 <?php 
    }
?>
</tbody>
</table>
   
   

    
    <?php $this->endWidget();?>

</div>
 