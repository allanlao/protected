
<?php
$readOnly = false;
$emp_number = Yii::app()->user->getState('empNumber');
$model->password_repeat = "";

?>






    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'employee-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'form-horizontal'),
        ));
?>



    <fieldset>
        <legend>Change Password</legend>

        <?php echo $form->errorSummary($model); ?>

         <div class="control-group">
        <?php echo $form->labelEx($model, 'password_repeat', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo $form->passwordField($model, 'password_repeat', array('size' => 20)); ?>
  </div>
    </div>
        
         <div class="control-group">
        <?php echo $form->labelEx($model, 'new_password', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo $form->passwordField($model, 'new_password', array('size' => 20)); ?>
 </div>
    </div>
        
         <div class="control-group">
        <?php echo $form->labelEx($model, 'new_password_repeat', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo $form->passwordField($model, 'new_password_repeat', array('size' => 20)); ?>
</div>
    </div>
        
    </fieldset>
    <div class="form-actions">

        
        <?php // echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> Submit', array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'Validate()')); ?>
            <button class="btn btn-primary" type="submit"><i class="icon-ok icon-white"></i> Save </button>
       
         <?php echo CHtml::htmlButton('<i class="icon-repeat"></i> Reset', array('class' => 'btn btn-warning', 'type' => 'reset')); ?>

    </div>

    <?php $this->endWidget(); ?>
