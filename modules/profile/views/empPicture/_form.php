
<?php
$readOnly = false;
$emp_number = Yii::app()->session['profile_no'];
?>







<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'employee-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'type' => 'horizontal',
    'htmlOptions' => array('class' => 'form-horizontal'),
        ));
?>



<fieldset>
    <legend>Photo</legend>

    <div><img style="width: 200px; height: 200px" alt="banner" src="<?php echo Yii::app()->request->baseUrl . '/images/' . $model->epic_filename; ?>" ></img></div>


    <?php echo $form->errorSummary($model); ?>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'emp_number', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'emp_number', array('size' => 20, 'readOnly' => true, 'value' => $emp_number)); ?>
        </div>
    </div>


    <div class="control-group">
        <?php echo $form->labelEx($model, 'epic_picture', array('class' => 'control-label', 'label' => 'Select picture')); ?>
        <div class="controls">
            <?php echo $form->fileField($model, 'epic_picture'); ?>
        </div>
    </div>

</fieldset>

<div class="form-actions">
    <button class="btn btn-primary" type="submit"><i class="icon-ok icon-white"></i> Save </button>


</div>

<?php $this->endWidget(); ?>


