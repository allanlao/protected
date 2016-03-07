<?php $this->breadcrumbs=array(
	'Profile'=>array('employee/updatePersonal'),
	'Contact Details',
);
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $this->renderPartial('_form_contacts', array('model'=>$model)); ?>