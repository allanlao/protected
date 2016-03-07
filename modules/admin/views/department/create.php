<?php
$this->breadcrumbs=array(
	'Departments'=>array('create'),
	'New',
);


?>

<h2>New Department</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'supervisorList' => $supervisorList)); ?>

<div>
<?php
	$this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'depts',
		'template'=>'{items}{pager}',
		'dataProvider'=>$dataProvider,
		'htmlOptions'=>array('class'=>'table table-striped'),
		'columns'=>array(
			array('header'=>'No.', 'value'=>'$row+1'),
			'name',
			'shortname',
			array('header'=>'Supervisor','value'=>'$data->empSupervisor->Fullname'),
			array(
				'header'=>'Action',
				'class'=>'CButtonColumn',
				'template'=>'{update}{delete}',
			),
		),
	));
?>
</div>