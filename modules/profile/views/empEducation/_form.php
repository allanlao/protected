
<?php
$readOnly = false;
$emp_number = Yii::app()->session['profile_no'];
$edu_types = array('Masters' => 'Masteral', 'Doctors' => 'Doctorate',
                   'Bachelor' => 'Bachelor', 'Vocational' => 'Vocational',
                   'Elementary' => 'Elementary', 'Secondary' => 'Secondary',
                   'Others' => 'Others'
            );
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
    <legend>Education</legend>

    <?php echo $form->errorSummary($model); ?>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_number', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'emp_number', array('size' => 20, 'readOnly' => true, 'value' => $emp_number)); ?>
        </div>
    </div>

    
    <div class="control-group">
        <?php echo $form->labelEx($model, 'edu_type', array('class' => 'control-label')); ?>
        <div class="controls">
           <?php echo $form->dropDownList($model, 'edu_type', $edu_types); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'edu_degree', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('CAutoComplete', array(
                //name of the html field that will be generated
                'model' => $model,
                'attribute' => 'edu_degree',
                //      'name' => 'degree',
                //replace controller/action with real ids
                'url' => array('suggestDegree'),
                'max' => 10, //specifies the max number of items to display
                //specifies the number of chars that must be entered 
                //before autocomplete initiates a lookup
                'minChars' => 2,
                'delay' => 500, //number of milliseconds before lookup occurs
                'matchCase' => false, //match case when performing a lookup?
                //any additional html attributes that go inside of 
                //the input field can be defined here
                'htmlOptions' => array('size' => '60'),
                    // 'methodChain'=>".result(function(event,item){\$(\"#user_id\").val(item[1]);})",
            ));
            ?>
            <?php echo "ex. Bachelor of Science in.."; ?>

        </div>
    </div>


    <div class="control-group">
        <?php echo $form->labelEx($model, 'edu_school', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'edu_school', array('size' => 60, 'maxlength' => 120)); ?>
        </div>
    </div>


    <div class="control-group">
        <?php echo $form->labelEx($model, 'edu_start_date', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('CMaskedTextField', array('model' => $model, 'attribute' => 'edu_start_date',
                'mask' => '9999',
                'htmlOptions' => array('size' => 10, 'disabled' => $readOnly)));
            ?>  
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'edu_end_date', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('CMaskedTextField', array('model' => $model, 'attribute' => 'edu_end_date',
                'mask' => '9999',
                'htmlOptions' => array('size' => 10, 'disabled' => $readOnly)));
            ?>  
        </div>
    </div>


    <div class="control-group">
        <?php echo $form->labelEx($model, 'edu_comments', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'edu_comments', array('size' => 80, 'maxlength' => 120)); ?>
        </div>
    </div>


</fieldset>


<div class="form-actions">

    <button class="btn btn-primary" type="submit"><i class="icon-ok icon-white"></i> Save </button>



</div>



<?php $this->endWidget(); ?>


