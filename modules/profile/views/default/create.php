<?php
$this->breadcrumbs=array(
	'Employee'=>array('index'),
	'New',
);


?>

<h2>New Employee</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model,'departmentList' => $departmentList, 'supervisorList' => $supervisorList)); ?>