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
<?php if($id > 0){?>

<div class="accordion" id="accordion2">
  <?php $this->renderPartial('_accordion',array('result'=>$result,'id'=>$id));?>
</div>

<?php }
else{
	echo "<h3><i class='icon-warning-sign'></i> Click Evaluation Period to load content</h3>";
}
?>