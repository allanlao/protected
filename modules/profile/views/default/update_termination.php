<?php $this->breadcrumbs=array(
	'Profile'=>array('employee/updatePersonal'),
	'Employment',
);
?>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<?php echo $this->renderPartial('_form_termination', array('model'=>$model)); ?>