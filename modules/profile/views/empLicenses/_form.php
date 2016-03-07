
<?php
$readOnly = false;
$emp_number = Yii::app()->session['profile_no'];
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
    <legend>Licenses</legend>


    <?php echo $form->errorSummary($model); ?>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_number', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'emp_number', array('size' => 20, 'readOnly' => true, 'value' => $emp_number)); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'licenses_number', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'licenses_number', array('size' => 40, 'maxlength' => 50)); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'licenses_description', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'licenses_description', array('size' => 60, 'maxlength' => 100)); ?>
            <?php echo "(ex. Electrical Engineer)" ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'licenses_date', array('class' => 'control-label')); ?>
         <div class="controls">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'licenses_date',
            'value' => $model->licenses_date,
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'fold',
                'showButtonPanel' => true,
                'autoSize' => true,
                'dateFormat' => 'yy-mm-dd',
                'defaultDate' => $model->licenses_date,
                'readOnly' => false,
            ),
        ));
        echo '(yyyy-mm-dd)'
        ?>
         </div>
    </div>

     <div class="control-group">
        <?php echo $form->labelEx($model, 'licenses_renewal_date', array('class' => 'control-label')); ?>
          <div class="controls">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'licenses_renewal_date',
            'value' => $model->licenses_renewal_date,
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'fold',
                'showButtonPanel' => true,
                'autoSize' => true,
                'dateFormat' => 'yy-mm-dd',
                'defaultDate' => $model->licenses_renewal_date,
                'readOnly' => false,
            ),
        ));
        echo '(yyyy-mm-dd)'
        ?>
           </div>
   </div>

    </fieldset>


    <div class="form-actions">

         <button class="btn btn-primary" type="submit"><i class="icon-ok icon-white"></i> Save </button>
      


    </div>

<?php $this->endWidget(); ?>

