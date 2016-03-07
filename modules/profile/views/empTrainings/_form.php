
<?php
$readOnly = false;
$emp_number = Yii::app()->session['profile_no'];;
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
    <legend>Trainings and Seminars</legend>


    <?php echo $form->errorSummary($model); ?>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_number', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'emp_number', array('size' => 20, 'readOnly' => true, 'value' => $emp_number)); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'tra_title', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'tra_title', array('size' => 60, 'maxlength' => 100)); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'tra_place',array('class' => 'control-label')); ?>
          <div class="controls">
        <?php echo $form->textField($model, 'tra_place', array('size' => 60, 'maxlength' => 120)); ?>
       </div>
    </div>



     <div class="control-group">
        <?php echo $form->labelEx($model, 'tra_start_date',array('class' => 'control-label')); ?>
           <div class="controls">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'tra_start_date',
            'value' => $model->tra_start_date,
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'fold',
                'showButtonPanel' => true,
                'autoSize' => true,
                'dateFormat' => 'yy-mm-dd',
                'defaultDate' => $model->tra_start_date,
                'readOnly' => false,
            ),
        ));
        echo '(yyyy-mm-dd)'
        ?>
       </div>
    </div>


    <div class="control-group">
        <?php echo $form->labelEx($model, 'tra_end_date',array('class' => 'control-label')); ?>
         <div class="controls">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'tra_end_date',
            'value' => $model->tra_end_date,
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'fold',
                'showButtonPanel' => true,
                'autoSize' => true,
                'dateFormat' => 'yy-mm-dd',
                'defaultDate' => $model->tra_end_date,
                'readOnly' => false,
            ),
        ));
        echo '(yyyy-mm-dd)'
        ?>
       </div>
    </div>

      <div class="control-group">
        <?php echo $form->labelEx($model, 'tra_comments',array('class' => 'control-label')); ?>
              <div class="controls">
        <?php echo $form->textArea($model, 'tra_comments', array('size' => 80, 'maxlength' => 120)); ?>
        </div>
    </div>


</fieldset>


<div class="form-actions">

    <button class="btn btn-primary" type="submit"><i class="icon-ok icon-white"></i> Save </button>



</div>

<?php $this->endWidget(); ?>
