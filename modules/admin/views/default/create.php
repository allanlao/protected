<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'New',
);


?>

<h2>New User</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>