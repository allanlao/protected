<?php
$this->breadcrumbs=array(
	'Certificates'=>array('index'),
	'Create',
);

?>

<h1>Certificate Generation Panel</h1>

<div class="well form-horizontal">

    <?php echo CHtml::beginForm(); ?>
    	
    	<?php echo CHtml::label('Select Employee', 'emp_number'); ?>
        <?php echo CHtml::dropDownList('emp_number', 'emp_number', Employee::model()->getEmployees()); ?>
        <?php echo CHtml::label('General Purpose Certificate for:', 'certificate_num'); ?>
        <?php echo CHtml::dropDownList('certificate_num', 'certificate_num', array(1 => 'Employment Abroad', 2 => 'Resigned Employees')); ?>
        <?php echo CHtml::submitButton('Search', array('class'=>'btn-primary','name' => 'btnGenerate')); ?>

    <?php echo CHtml::endForm(); ?>


</div>