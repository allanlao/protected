<?php
$this->breadcrumbs=array(
	'Positions'=>array('index'),
	'New',
);

?>

<h2>New Position</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<div>
<?php
	$this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'degree',
		'template'=>'{items}{pager}',
		'dataProvider'=>$dataProvider,
		'htmlOptions'=>array('class'=>'table table-striped'),
		'columns'=>array(
			array('header'=>'No.', 'value'=>'$row+1'),
			'position_desc',
			'position_category',
			array(
				'header'=>'Action',
				'class'=>'CButtonColumn',
				'template'=>'{update}{delete}',
			),
		),
	));
?>

</div>