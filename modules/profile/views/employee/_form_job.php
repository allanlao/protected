
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
    <legend>Job Details</legend>

    <?php echo $form->errorSummary($model); ?>


    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_status', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'emp_status', Empstat::model()->getEmpStats(), array('class' => 'span4', 'disabled' => $readOnly)); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_position_code', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'emp_position_code', Position::model()->getPositions(), array('class' => 'span4', 'disabled' => $readOnly)); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_department_code', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'emp_department_code', Department::model()->getDepartments(), array('class' => 'span4', 'disabled' => $readOnly)); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_supervisor', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'emp_supervisor', Employee::model()->getEmployeeHeads(), array('class' => 'span4', 'disabled' => $readOnly)); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'joined_date'); ?>
        </div>
        <div class="controls">
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'joined_date',
                'value' => $model->joined_date,
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'fold',
                    'showButtonPanel' => true,
                    'autoSize' => true,
                    'dateFormat' => 'yy-mm-dd',
                    'defaultDate' => $model->joined_date,
                //  'disabled' => $readOnly,
                ),
            ));
            ?>
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model, 'emp_end_of_contract'); ?>
        </div>
        <div class="controls">
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'emp_end_of_contract',
                'value' => $model->emp_end_of_contract,
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'fold',
                    'showButtonPanel' => true,
                    'autoSize' => true,
                    'dateFormat' => 'yy-mm-dd',
                    'defaultDate' => $model->emp_end_of_contract,
                // 'disabled' => $readOnly,
                ),
            ));
            ?>
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
                      
                    
                        document.getElementById("Employee_emp_status").disabled = false;
                        document.getElementById("Employee_emp_position_code").disabled = false;
                        document.getElementById("Employee_emp_department_code").disabled = false;
                        document.getElementById("Employee_emp_supervisor").disabled = false;
                        document.getElementById("Employee_joined_date").disabled = false;
                        document.getElementById("Employee_emp_end_of_contract").disabled = false;
                     
                     
                       
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

