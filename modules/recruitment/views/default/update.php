

<?php
$this->breadcrumbs=array(
	'Job Posting'=>array('create'),
	'Update',
);


?>



<?php echo $this->renderPartial('_form', array('model'=>$model,'positionList'=>$positionList ,'departmentList'=>$departmentList)); ?>

<div>
<?php
	$this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'depts',
		'template'=>'{items}{pager}',
		'dataProvider'=>$dataProvider,
		'htmlOptions'=>array('class'=>'table table-striped'),
		'columns'=>array(
			array('header'=>'No.', 'value'=>'$row+1'),
			array('header'=>'Position','value'=>'$data->positionCode->position_desc'),
			'department',
		
			'qty',
			'job_type',
			
			array(
				'header'=>'Action',
				'class'=>'CButtonColumn',
				'template'=>'{update}{delete}',
			),
		),
	));
?>
</div>