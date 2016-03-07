
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
    <legend>Awards</legend>


    <?php echo $form->errorSummary($model); ?>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_number', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'emp_number', array('size' => 20, 'readOnly' => true, 'value' => $emp_number)); ?>
        </div>
    </div>

   <div class="control-group">
        <?php echo $form->labelEx($model, 'award_description',array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo $form->textField($model, 'award_description', array('size' => 60, 'maxlength' => 100)); ?>
        </div>
    </div>

   <div class="control-group">
        <?php echo $form->labelEx($model, 'awarding_body',array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo $form->textField($model, 'awarding_body', array('size' => 60, 'maxlength' => 120)); ?>
       </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'award_date',array('class' => 'control-label')); ?>
          <div class="controls">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'award_date',
            'value' => $model->award_date,
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'fold',
                'showButtonPanel' => true,
                'autoSize' => true,
                'dateFormat' => 'yy-mm-dd',
                'defaultDate' => $model->award_date,
                'readOnly' => false,
            ),
        ));
        echo '(yyyy-mm-dd)'
        ?>
         </div>
    </div>

     <div class="control-group">
        <?php echo $form->labelEx($model, 'award_comments',array('class' => 'control-label')); ?>
          <div class="controls">
        <?php echo $form->textArea($model, 'award_comments', array('size' => 80, 'maxlength' => 120)); ?>
         </div>
    </div>



   </fieldset>


    <div class="form-actions">

         <button class="btn btn-primary" type="submit"><i class="icon-ok icon-white"></i> Save </button>
      


    </div>

<?php $this->endWidget(); ?>

