<h2>Add new Leave Credit</h2>

  <?php $this->widget('bootstrap.widgets.TbAlert'); ?>

<?php
 
   $year = date('Y');
   $sy1 = $year - 1 . '-' . $year;
   $sy2 = $year . '-' . ($year + 1);
   $syList = array($sy1 => $sy1, $sy2 => $sy2);
    /*
        if (date('m') < '05') {
            //if May
            $sy = $year - 1 . '-' . $year;
            $syList = array($sy => $sy);
        } else if ((date('m') >= '05') && (date('m') <= '05')) {
            $sy1 = $year - 1 . '-' . $year;
            $sy2 = $year . '-' . ($year + 1);
            $syList = array($sy1 => $sy1, $sy2 => $sy2);
        } else {
            $sy1 = $year . '-' . ($year + 1);
            $syList = array($sy1 => $sy1);
        }
     
     */

?>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'employee-form',
     'type'=>'horizontal',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'well form-horizontal'),
        ));
?>
<fieldset>
  
<?php echo $form->errorSummary($model); ?>
<?php echo $form->dropDownListRow($model, 'emp_number', Employee::model()->getEmployees()); ?>
    
<?php echo $form->dropDownListRow($model,'leave_sy', $syList); ?>    
<?php echo $form->textFieldRow($model, 'leave_allocated_vl'); ?>
<?php echo $form->textFieldRow($model, 'leave_allocated_sl'); ?>

</fieldset>
<div class="form-actions">

   <button class="btn btn-primary" type="submit"><i class="icon-ok icon-white"></i> Save </button>
    
   
</div>
<?php $this->endWidget(); ?>


    
    