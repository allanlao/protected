
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



<fieldset>
    <legend>Work Experience</legend>


    <?php echo $form->errorSummary($model); ?>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_number', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'emp_number', array('size' => 20, 'readOnly' => true, 'value' => $emp_number)); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'eexp_employer', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'eexp_employer', array('size' => 60, 'maxlength' => 100)); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'eexp_jobtit', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'eexp_jobtit', array('size' => 60, 'maxlength' => 120)); ?>
            <?php echo "ex. Field Supervisor"; ?>
        </div>
    </div>


    <div class="control-group">
        <?php echo $form->labelEx($model, 'eexp_from_date', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'eexp_from_date',
                'value' => $model->eexp_from_date,
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'fold',
                    'showButtonPanel' => true,
                    'autoSize' => true,
                    'dateFormat' => 'yy-mm-dd',
                    'defaultDate' => $model->eexp_from_date,
                    'readOnly' => false,
                ),
            ));
            echo '(yyyy-mm-dd)'
            ?>

        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'eexp_to_date',array('class' => 'control-label')); ?>
         <div class="controls">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'eexp_to_date',
            'value' => $model->eexp_to_date,
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'fold',
                'showButtonPanel' => true,
                'autoSize' => true,
                'dateFormat' => 'yy-mm-dd',
                'defaultDate' => $model->eexp_to_date,
                'readOnly' => false,
            ),
        ));
        echo '(yyyy-mm-dd)'
        ?>
       </div>
    </div>

       <div class="control-group">

        <?php echo $form->labelEx($model, 'eexp_comments',array('class' => 'control-label')); ?>
           <div class="controls">
        <?php echo $form->textArea($model, 'eexp_comments', array('size' => 80, 'maxlength' => 120)); ?>
       </div>
    </div>

        <div class="control-group">
        <?php echo $form->labelEx($model, 'eexp_internal',array('class' => 'control-label')); ?>
            <div class="controls">
        <?php echo $form->checkBox($model, 'eexp_internal', array('size' => 80, 'maxlength' => 120)); ?>
        <?php echo "(Within this organization)"; ?>
         </div>
    </div>


   
</fieldset>

     <div class="form-actions">

         <button class="btn btn-primary" type="submit"><i class="icon-ok icon-white"></i> Save </button>
      


    </div>

<?php $this->endWidget(); ?>

