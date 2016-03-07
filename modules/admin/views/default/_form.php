<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<?php
$list = array('user' => 'user', 'hradmin' => 'hradmin');
?>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
     'type'=>'horizontal',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'well form-horizontal'),
        ));
?>

<fieldset>
  
<?php //echo $form->errorSummary($model); ?>

 <?php echo $form->textFieldRow($model, 'email', array('class' => 'span2', 'append' => '@gmail.com')); ?>

<?php echo $form->dropDownListRow($model, 'role', $list); ?>

<?php echo $form->dropDownListRow($model, 'empNumber', Employee::model()->getEmployees()); ?>

<span style="font-size:8pt;">Note :Default Password : 123456</span>
</fieldset>
<div class="form-actions">

  <button class="btn btn-primary" type="submit"><i class="icon-ok icon-white"></i> Save </button>
   
</div>


<?php $this->endWidget(); ?>
