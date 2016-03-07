<?php $this->widget('bootstrap.widgets.TbAlert', array(
		'block'=>true, // display a larger alert block?
		'fade'=>true, // use transitions?
		'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
		
    )); 
?>
<?php

$period = EvaluationPeriod::model()->findByPk($id);

$box = $this->beginWidget ( 'bootstrap.widgets.TbBox', array (
		'title' => 'Evaluation Result [ '. $period->sem . ' SEM SY ' . $period->sy .'  ]',
		'headerIcon' => 'icon-edit',
		// when displaying a table, if we include bootstrap-widget-table class
		// the table will be 0-padding to the box
		'htmlOptions' => array (
		//'class' => 'bootstrap-widget-table' 
		),
		
		
)
 );
?>



<table class="table table-hover fixed">
<thead>
<th>Evaluation Tool</th>
<th>Average</th>
<th>No. of Evaluators</th>
<th>Details</th>
</thead>
<tbody>
<?php 
    foreach($result as $row)
    {
    	$action='peerResult';
    	if ($row['evaluation_type'] == 1)
    	$action = 'peerResult';
    	else if($row['evaluation_type'] == 2)
    		$action = 'facultyByDeanResult';
    	?>
    	<tr>
    	<td><?php echo $row['title']; ?></td>
    
    	<td><?php echo Yii::app()->numberFormatter->format("###.00", $row['average']);?></td>
    	<td><?php echo $row['total']; ?></td>
    	<td><?php echo CHtml::link('Details',
					array(Yii::app()->controller->id .'/'.$action,
                                         'id'=>$id)); ?></td>
    	</tr>
 <?php 
    }
?>
</tbody>
</table>



<?php $this->endWidget(); ?>
