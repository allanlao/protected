
<?php
$readOnly = true;
$emp_number = Yii::app()->session['profile_no'];

$province = new Province;
$town = new Town;
?>




<?php
Yii::app()->clientScript->registerScript('add', "
$('#editButton').click(function(){
	       
        $('#employee-form').find('input, textarea, button, select').removeAttr('disabled');
        $('#employee-form').find('input, textarea, button, select').removeAttr('readOnly');
        
        $('#Employee_emp_number').attr('readOnly','readOnly');
        $(this).attr('disabled','disabled');
      return false;
 });
                       
");
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
    <legend>Termination Details</legend>

    <?php echo $form->errorSummary($model); ?>

    

    <div class="control-group">
        <?php echo $form->labelEx($model, 'termination_reason', array('class' => 'control-label')); ?>
        <div class="controls">
          <?php echo $form->textField($model, 'emp_address_current', array('class' => 'span4', 'readOnly' => $readOnly)); ?>
        
        </div>
    </div>


     

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'terminated_date'); ?>
        </div>
        <div class="controls">
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'terminated_date',
                'value' => $model->terminated_date,
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'fold',
                    'showButtonPanel' => true,
                    'autoSize' => true,
                    'dateFormat' => 'yy-mm-dd',
                    'defaultDate' => $model->terminated_date,
                //  'disabled' => $readOnly,
                ),
            ));
            ?>
        </div>
    </div>

     <div class="control-group">
        <?php echo $form->labelEx($model, 'isActive', array('class' => 'control-label')); ?>
        <div class="controls">
          <?php echo $form->checkBox($model, 'isActive', array( 'readOnly' => $readOnly)); ?>
        
        </div>
    </div>

    

</fieldset>

 <?php
   if (Yii::app()->user->checkAccess('hradmin'))
   {
 ?>

<div class="form-actions">
  
  <?php
        echo CHtml::htmlButton('<i class="icon-edit icon-white"></i> Edit', array('class' => 'btn btn-success',
            'type' =>'button',
            'name' => 'edit',
            'id' => 'editButton',
          
        ));
        ?>

    <?php // echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> Save', array('class' => 'btn btn-success', 'type' => 'submit', 'name' => 'submit')); ?>

 <button class="btn btn-primary" type="submit" disabled="disabled"><i class="icon-ok icon-white"></i> Save </button>
   <?php 
   }
   ?>
</div>

<?php $this->endWidget(); ?>

