<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
     'type'=>'horizontal',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'well form-horizontal'),
        ));
?>

<fieldset>
  
<?php echo $form->errorSummary($model); ?>
<?php echo $form->dropDownListRow($model, 'position_code', $positionList);?>
<?php echo $form->dropDownListRow($model, 'department', $departmentList);?>
<?php echo $form->dropDownListRow($model, 'job_type', array('Permanent'=>'Permanent','Contractual'=>'Contractual'));?>
<?php echo $form->textFieldRow($model, 'qty'); ?>

</fieldset>
<div class="form-actions">

   <button class="btn btn-primary" type="submit"><i class="icon-ok icon-white"></i> Save </button>
   
</div>


<?php $this->endWidget(); ?>
