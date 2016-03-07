<?php $this->breadcrumbs=array(
	'Profile'=>array('default/updatePersonal'),
	'Personal Details',
);
?>

<?php $this->widget('bootstrap.widgets.TbAlert'); ?>

<?php echo $this->renderPartial('_form_personal', array('model'=>$model)); ?>