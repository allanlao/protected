<?php $this->breadcrumbs=array(
	'Profile'=>array('employee/updatePersonal'),
	'Personal Details',
);
?>

<?php $this->widget('bootstrap.widgets.TbAlert'); ?>

<?php echo $this->renderPartial('_form_personal', array('model'=>$model)); ?>