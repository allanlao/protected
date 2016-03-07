<?php
  $box = $this->beginWidget ('bootstrap.widgets.TbBox', array (
		'title' => 'Evaluation Period',
		'headerIcon' => 'icon-th-list',
		// when displaying a table, if we include bootstrap-widget-table class
		// the table will be 0-padding to the box
		'htmlOptions' => array (
				'class' => 'bootstrap-widget-table',
				'style'=>'margin: 10px;margin-bottom:20px;',
		),
	
)
 );
?>

<table class="table table-hover fixed">
	<thead>
		<tr>
			<th>Id</th>
			<th>Period</th>
			
		</tr>
	</thead>
	<tbody>
	 <?php 
	    foreach($dataProvider as $row)
	    {
	 ?>
		<tr>
		  
			<td><?php echo $row->id;?></td>
			<td><?php echo CHtml::link($row->getPeriodName(),
					array(Yii::app()->controller->id .'/'.Yii::app()->controller->action->id,
                                         'id'=>$row->id)); ?></td>
			
		
		</tr>
		<?php 
		}
		?>
	</tbody>

</table>

<?php $this->endWidget(); ?>
