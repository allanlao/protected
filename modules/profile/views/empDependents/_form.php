
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
        ));
?>



<fieldset >
    <legend>Dependents</legend>


    <?php echo $form->errorSummary($model); ?>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_number', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'emp_number', array('size' => 20, 'readOnly' => true, 'value' => $emp_number)); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'ed_name', array('class' => 'control-label')); ?>
        <div class="controls">
    <?php echo $form->textField($model, 'ed_name', array('size' => 60, 'maxlength' => 100)); ?>
   </div>
    </div>
    
    <div class="control-group">
        <?php echo $form->labelEx($model, 'ed_relationship', array('class' => 'control-label')); ?>
        <div class="controls">
    <?php echo $form->dropDownList($model, 'ed_relationship', array('Child' => 'Child', 'Parent' => 'Parent', 'Other' => 'Other'), array('disabled' => $readOnly)); ?>
    <?php echo $form->error($model, 'ed_relationship'); ?>
</div>
    </div>

        <div class="control-group">
                   <?php echo $form->labelEx($model, 'ed_date_of_birth',array('class' => 'control-label')); ?>
               <div class="controls">
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'ed_date_of_birth',
                'value' => $model->ed_date_of_birth,
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'fold',
                    'showButtonPanel' => true,
                    'autoSize' => true,
                    'dateFormat' => 'yy-mm-dd',
                    'defaultDate' => $model->ed_date_of_birth,
                    'readOnly' => false,
                ),
            ));
            echo '(yyyy-mm-dd)'
            ?>
            <?php echo $form->error($model, 'ed_date_of_birth'); ?>
        </div>
    </div>

</fieldset>

<div class="form-actions">


     <button class="btn btn-primary" type="submit"><i class="icon-ok icon-white"></i> Save </button>
      


</div>

<?php $this->endWidget(); ?>

