
<?php
$readOnly = false;
$emp_number = Yii::app()->session['profile_no'];
?>







<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'employee-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'type' => 'horizontal',
    'htmlOptions' => array('class' => 'form-horizontal'),
        ));
?>




<fieldset >
    <legend>Emergency Contacts</legend>


    <?php echo $form->errorSummary($model); ?>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_number', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'emp_number', array('size' => 20, 'readOnly' => true, 'value' => $emp_number)); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'eec_name', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'eec_name', array('size' => 60, 'maxlength' => 100)); ?>
            <?php echo "ex. Kris Aquino"; ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'eec_relationship', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'eec_relationship', array('Spouse' => 'Spouse', 'Parent' => 'Parent', 'Child' => 'Child', 'Relative' => 'Relative'), array('disabled' => $readOnly)); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'eec_home_no', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('CMaskedTextField', array('model' => $model, 'attribute' => 'eec_home_no',
                'mask' => '(999) 999-9999',
                'htmlOptions' => array('size' => 40, 'disabled' => $readOnly)));
            ?>  
            <?php echo $form->error($model, 'eec_home_no'); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'eec_office_no', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('CMaskedTextField', array('model' => $model, 'attribute' => 'eec_office_no',
                'mask' => '(999) 999-9999',
                'htmlOptions' => array('size' => 40, 'disabled' => $readOnly)));
            ?>  
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'eec_mobile_no', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('CMaskedTextField', array('model' => $model, 'attribute' => 'eec_mobile_no',
                'mask' => '+63999-999-9999',
                'htmlOptions' => array('size' => 40, 'disabled' => $readOnly)));
            ?>  

        </div>
    </div>


</fieldset>
<div class="form-actions">

    <button class="btn btn-primary" type="submit"><i class="icon-ok icon-white"></i> Save </button>

</div>

<?php $this->endWidget(); ?>



