<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<?php
$list = array('faculty' => 'faculty', 'staff' => 'staff', 'head' => 'head', 'director' => 'director');
?>
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

<?php echo $form->textFieldRow($model, 'position_desc'); ?>
<?php echo $form->dropDownListRow($model, 'position_category', $list); ?>
</fieldset>
<div class="form-actions">

    <?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> Save', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit')); ?>
   
</div>


<?php $this->endWidget(); ?>
