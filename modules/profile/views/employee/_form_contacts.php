
<?php
$readOnly = true;
$emp_number = Yii::app()->user->getState('empNumber');

$province = new Province;
$town = new Town;
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



    <?php echo $form->textFieldRow($model, 'emp_address', array('class' => 'span4', 'readOnly' => $readOnly)); ?>


    <?php
    echo $form->dropDownListRow($model, 'emp_province', CHtml::listData(Province::model()->findAll(array('order' => 'province_name')), 'id', 'province_name'), array(
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


    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_town', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'emp_town', CHtml::listData(Town::model()->findAll(array('order' => 'town_name')), 'id', 'town_name'), array('class' => 'span4', 'disabled' => $readOnly)); ?>
        </div>
    </div>

 <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_address_current', array('class' => 'control-label')); ?>
        <div class="controls">
    <?php echo $form->textField($model, 'emp_address_current', array('class' => 'span4', 'readOnly' => $readOnly)); ?>
 </div>
    </div>

       <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'emp_hm_telephone'); ?>
        </div>
        <div class="controls">
            <?php
            $this->widget('CMaskedTextField', array('model' => $model, 'attribute' => 'emp_hm_telephone',
                'mask' => '(999) 999-9999',
                'htmlOptions' => array('size' => 40, 'disabled' => $readOnly)));
            ?>  

        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'emp_work_telephone'); ?>
        </div>
        <div class="controls">
            <?php
            $this->widget('CMaskedTextField', array('model' => $model, 'attribute' => 'emp_work_telephone',
                'mask' => '(999) 999-9999',
                'htmlOptions' => array('size' => 40, 'disabled' => $readOnly)));
            ?>  

        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'emp_mobile'); ?>
        </div>
        <div class="controls">
            <?php
            $this->widget('CMaskedTextField', array('model' => $model, 'attribute' => 'emp_mobile',
                'mask' => '+63999-999-9999',
                'htmlOptions' => array('size' => 40, 'disabled' => $readOnly)));
            ?>  

        </div>
    </div>

    <hr>

    <?php echo $form->textFieldRow($model, 'emp_work_email', array('class' => 'span4', 'readOnly' => $readOnly)); ?>

    <?php echo $form->textFieldRow($model, 'emp_oth_email', array('class' => 'span4', 'readOnly' => $readOnly)); ?>


</fieldset>
<div class="form-actions">
    <?php
    $this->widget('zii.widgets.jui.CJuiButton', array(
        'name' => 'button',
        'caption' => 'Edit',
        'value' => 'btnEdit',
        'onclick' => 'js:function(){
                       
                        objElems = document.getElementById("employee-form").elements;
                          for(i=0;i<objElems.length;i++){
                            objElems[i].readOnly = false;
                          }
                      
                        document.getElementById("Employee_emp_province").disabled = false;
                        document.getElementById("Employee_emp_town").disabled = false;
                        document.getElementById("Employee_emp_address").readOnly = false;
                        document.getElementById("Employee_emp_town").readOnly = false;
                        document.getElementById("Employee_emp_province").readOnly = false;
                        document.getElementById("Employee_emp_hm_telephone").disabled = false;
                        document.getElementById("Employee_emp_work_telephone").disabled = false;
                        document.getElementById("Employee_emp_mobile").disabled = false;
                        
                        document.getElementById("Employee_emp_work_email").readOnly = false;
                        document.getElementById("Employee_emp_oth_email").readOnly = false;
                     
                       
                        this.disabled = true;
                        
                        return false;
                        }',
            )
    );
    ?>

    <?php // echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> Save', array('class' => 'btn btn-success', 'type' => 'submit', 'name' => 'submit')); ?>

    <button class="btn btn-primary" type="submit"><i class="icon-ok icon-white"></i> Save </button>

</div>

<?php $this->endWidget(); ?>

