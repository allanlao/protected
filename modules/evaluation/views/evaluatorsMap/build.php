<?php
/* @var $this DefaultController */

 $this->breadcrumbs=array(
	$this->module->id,
); 
?>
<?php $this->widget('bootstrap.widgets.TbAlert', array(
		'block'=>true, // display a larger alert block?
		'fade'=>true, // use transitions?
		'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
		
    )); 
?>
<?php 
	$this->renderPartial('_form',array('selected_period'=>$selected_period,
'selected_emp'=>$selected_emp,'model'=>$model,

));
	
?>		
