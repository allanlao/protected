<?php
$sem=array('1st'=>'First Semester','2nd'=>'Second Semester');
$status=array('open'=>'Open','closed'=>'Closed');
$sy=array();
for ($i=-1; $i <=2 ; $i++) {
    $tmp= (date('Y')+$i)."-".(date('Y')+$i+1);
    $sy[$tmp]=$tmp;
}

?>
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'schedperiod-form',
    'type'=>'search',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'well'),
        ));
?>
<span>Create period</span>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->dropDownList($model, 'sy', $sy); ?>
<?php echo $form->dropDownList($model, 'sem', $sem); ?>
<?php //echo $form->dropDownListRow($model,'status',$status);?>
   <button class="btn btn-search" type="submit"><i class="icon-ok"></i> Save </button>

<?php $this->endWidget(); ?>
