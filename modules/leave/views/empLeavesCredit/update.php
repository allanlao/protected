<?php
/* @var $this EmpLeaveCreditsController */
/* @var $model EmpLeaveCredits */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'emp-leave-credits-update-form',
	'enableAjaxValidation'=>false,
)); ?>

    
    <div class="row">
        <h1> Update Leave Credits </h1>
    </div>
    <div class="row">
        <h2> 
            <?php
             echo $model->empNumber->fullname;
            ?>
         </h2>
        <h3> 
            <?php
             echo "School Year : " .$model->leave_sy;
            ?>
         </h3>
    </div>
    
       
    
	<?php echo $form->errorSummary($model); ?>

    
        <div class="control-group">
		<?php echo $form->labelEx($model,'leave_allocated_vl',array('class' => 'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'leave_allocated_vl'); ?>
		</div>
	</div>
	
        <div class="control-group">
		<?php echo $form->labelEx($model,'leave_allocated_sl',array('class' => 'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'leave_allocated_sl'); ?>
		</div>
	</div>
	


	<div class="row buttons">
		
            <button id="save" class="btn btn-primary" type="submit"> <i class="icon-ok icon-white"></i> Save </button>

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->