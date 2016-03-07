<?php $this->widget('bootstrap.widgets.TbAlert'); ?>


<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'employee-form',
     'type'=>'horizontal',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'well form-horizontal'),
        ));
?>

<fieldset>
  
<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'emp_number'); ?>
<?php echo $form->textFieldRow($model, 'emp_lastname'); ?>
<?php echo $form->textFieldRow($model, 'emp_firstname'); ?>
<?php echo $form->dropDownListRow($model, 'emp_department_code', $departmentList); ?>
<?php echo $form->dropDownListRow($model, 'emp_supervisor', $supervisorList); ?>
</fieldset>
<div class="form-actions">

   <button class="btn btn-primary" type="submit"><i class="icon-ok icon-white"></i> Save </button>
    
   
</div>


<?php $this->endWidget(); ?>
