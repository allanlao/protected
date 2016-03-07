
<?php
$readOnly = true;
?>




<?php
$maritalStatus = array('Single' => 'Single', 'Married' => 'Married', 'Separated' => 'Separated', 'Divorced' => 'Divorced', 'Widowed' => 'Widowed', 'Others' => 'Others');
$gender = array('Male' => 'Male', 'Female' => 'Female');
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
    <legend>Personal Details</legend>

    <?php echo $form->errorSummary($model); ?>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_number', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'emp_number', array('size' => 20, 'maxlength' => 50, 'readOnly' => true)); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_smartcard_num', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'emp_smartcard_num', array('size' => 40, 'maxlength' => 20, 'readOnly' => true)); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_lastname', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'emp_lastname', array('size' => 40, 'maxlength' => 100, 'readOnly' => $readOnly)); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_firstname', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'emp_firstname', array('size' => 40, 'maxlength' => 100, 'readOnly' => $readOnly)); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_middle_name', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'emp_middle_name', array('size' => 40, 'maxlength' => 100, 'readOnly' => $readOnly)); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_nick_name', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'emp_nick_name', array('size' => 40, 'maxlength' => 100, 'readOnly' => $readOnly)); ?>
        </div>
    </div>




    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'emp_birthday'); ?>
        </div>
        <div class="controls">
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'emp_birthday',
                'value' => $model->emp_birthday,
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'fold',
                    'showButtonPanel' => true,
                    'autoSize' => true,
                    'dateFormat' => 'yy-mm-dd',
                    'defaultDate' => $model->emp_birthday,
                    'readOnly' => $readOnly,
                ),
            ));
            echo '(yyyy-mm-dd)'
            ?>
            <?php echo $form->error($model, 'emp_birthday'); ?>
        </div>
    </div>


    <?php echo $form->dropDownListRow($model, 'emp_gender', $gender, array('disabled' => $readOnly)); ?>
    <?php echo $form->error($model, 'emp_gender'); ?>





    <?php echo $form->dropDownListRow($model, 'emp_marital_status', $maritalStatus, array('disabled' => $readOnly)); ?>
    <?php echo $form->error($model, 'emp_marital_status'); ?>


    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'emp_sss_num'); ?>
        </div>
        <div class="controls">
            <?php
            $this->widget('CMaskedTextField', array('model' => $model, 'attribute' => 'emp_sss_num',
                'mask' => '99-9999999-9',
                'htmlOptions' => array('size' => 40, 'disabled' => $readOnly)));
            ?>  
            <?php echo $form->error($model, 'emp_sss_num'); ?>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'emp_gsis_num'); ?>
        </div>
        <div class="controls">
            <?php
            $this->widget('CMaskedTextField', array('model' => $model, 'attribute' => 'emp_gsis_num',
                'mask' => '99999999999',
                'htmlOptions' => array('size' => 40, 'disabled' => $readOnly)));
            ?>  
            <?php echo $form->error($model, 'emp_gsis_num'); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'emp_philhealth_num'); ?>
        </div>
        <div class="controls">
            <?php
            $this->widget('CMaskedTextField', array('model' => $model, 'attribute' => 'emp_philhealth_num',
                'mask' => '999999999999',
                'htmlOptions' => array('size' => 40, 'disabled' => $readOnly)));
            ?>  
            <?php echo $form->error($model, 'emp_philhealth_num'); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'emp_peraa_num'); ?>
        </div>
        <div class="controls">
            <?php
            $this->widget('CMaskedTextField', array('model' => $model, 'attribute' => 'emp_peraa_num',
                'mask' => '999999',
                'htmlOptions' => array('size' => 40, 'disabled' => $readOnly)));
            ?>  
            <?php echo $form->error($model, 'emp_peraa_num'); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'emp_hdmf_num'); ?>
        </div>
        <div class="controls">
            <?php
            $this->widget('CMaskedTextField', array('model' => $model, 'attribute' => 'emp_hdmf_num',
                'mask' => '99-99999999-99',
                'htmlOptions' => array('size' => 40, 'disabled' => $readOnly)));
            ?>  
            <?php echo $form->error($model, 'emp_hdmf_num'); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'emp_unified_num'); ?>
        </div>
        <div class="controls">
            <?php
            $this->widget('CMaskedTextField', array('model' => $model, 'attribute' => 'emp_unified_num',
                'mask' => '999-9999-999-9',
                'htmlOptions' => array('size' => 40, 'disabled' => $readOnly)));
            ?>  
            <?php echo $form->error($model, 'emp_unified_num'); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'emp_tin_num'); ?>
        </div>
        <div class="controls">

            <?php
            $this->widget('CMaskedTextField', array('model' => $model, 'attribute' => 'emp_tin_num',
                'mask' => '999-999-999',
                'htmlOptions' => array('size' => 40, 'disabled' => $readOnly)));
            ?>  
            <?php echo $form->error($model, 'emp_tin_num'); ?>
        </div>
    </div>
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
                      
                        document.getElementById("Employee_emp_number").readOnly =true;
                        document.getElementById("Employee_emp_smartcard_num").readOnly =true;
                        document.getElementById("Employee_emp_sss_num").disabled = false;
                        document.getElementById("Employee_emp_philhealth_num").disabled = false;
                        document.getElementById("Employee_emp_hdmf_num").disabled = false;
                        document.getElementById("Employee_emp_gsis_num").disabled = false;
                        document.getElementById("Employee_emp_tin_num").disabled = false;
                        document.getElementById("Employee_emp_peraa_num").disabled = false;
                        document.getElementById("Employee_emp_unified_num").disabled = false;
                        
                        document.getElementById("Employee_emp_marital_status").disabled = false;
                        document.getElementById("Employee_emp_gender").disabled = false;
                     
                       
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

