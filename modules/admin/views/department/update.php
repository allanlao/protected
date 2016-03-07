<?php
$this->breadcrumbs=array(
	'Departments'=>array('create'),
	'Edit',
);

?>

<h2>Edit || <?php echo $model->name; ?></h2>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
     'type'=>'horizontal',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'well form-horizontal'),
        ));
?>

<fieldset>
  
<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'name'); ?>
<?php echo $form->textFieldRow($model, 'shortname'); ?>
<?php echo $form->dropDownListRow($model, 'supervisor', $supervisorList,
	array('options'=>array($model->supervisor=>array('selected'=>'selected')),)
);?>
</fieldset>
<div class="form-actions">

   <button class="btn btn-primary" type="submit"><i class="icon-ok icon-white"></i> Save </button>
   
</div>


<?php $this->endWidget(); ?>
