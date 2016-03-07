
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
    <legend>Contact Details</legend>

    <?php echo $form->errorSummary($model); ?>


    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_address', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'emp_address', array('class' => 'span4', 'readOnly' => $readOnly)); ?>
        </div>
    </div>


    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_province', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo $form->dropDownList($model, 'emp_province', CHtml::listData(Province::model()->findAll(array('order' => 'province_name')), 'id', 'province_name'), array(
                'ajax' => array(
                    'type' => 'POST',
                    'url' => CController::createUrl('town/dynamicTowns'),
                    'update' => '#Employee_emp_town'
                ),
                'disabled' => $readOnly,
                'class' => 'span4'
                    )
            );
            ?>
        </div>
    </div>


    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_town', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'emp_town', CHtml::listData(Town::model()->findAll(array('order' => 'town_name')), 'id', 'town_name'), array('class' => 'span4', 'disabled' => $readOnly)); ?>
        </div>
    </div>

    <hr>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_address_current', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'emp_address_current', array('class' => 'span4', 'readOnly' => $readOnly)); ?>
        </div>
    </div>

    <hr>

    <div class="control-group">

        <?php echo $form->labelEx($model, 'emp_hm_telephone', array('class' => 'control-label')); ?>

        <div class="controls">
            <?php
            $this->widget('CMaskedTextField', array('model' => $model, 'attribute' => 'emp_hm_telephone',
                'mask' => '(999) 999-9999',
                'htmlOptions' => array('size' => 40, 'disabled' => $readOnly)));
            ?>  

        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_work_telephone', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('CMaskedTextField', array('model' => $model, 'attribute' => 'emp_work_telephone',
                'mask' => '(999) 999-9999',
                'htmlOptions' => array('size' => 40, 'disabled' => $readOnly)));
            ?>  

        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_mobile', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('CMaskedTextField', array('model' => $model, 'attribute' => 'emp_mobile',
                'mask' => '+63999-999-9999',
                'htmlOptions' => array('size' => 40, 'disabled' => $readOnly)));
            ?>  
        </div>
    </div>

    <hr>
 <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_work_email', array('class' => 'control-label')); ?>
        <div class="controls">
    <?php echo $form->textField($model, 'emp_work_email', array('class' => 'span4', 'readOnly' => $readOnly)); ?>
 </div>
    </div>
    
     <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_oth_email', array('class' => 'control-label')); ?>
        <div class="controls">
    <?php echo $form->textField($model, 'emp_oth_email', array('class' => 'span4', 'readOnly' => $readOnly)); ?>
</div>
    </div>

</fieldset>
<div class="form-actions">
   

  <?php
        echo CHtml::htmlButton('<i class="icon-edit icon-white"></i> Edit', array('class' => 'btn btn-success',
            'type' =>'button',
            'name' => 'edit',
            'id' => 'editButton',
          
        ));
        ?>

       <button class="btn btn-primary" type="submit"  disabled="disabled"><i class="icon-ok icon-white"></i> Save </button>
      



</div>

<?php $this->endWidget(); ?>

