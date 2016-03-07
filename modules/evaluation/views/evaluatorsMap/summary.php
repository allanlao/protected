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
	$this->renderPartial('_summary',array('selected_period'=>$selected_period,
'selected_type'=>$selected_type,

));
	
?>	



<div id="leave-pending">
   

<?php 

  $etype = EvaluationType::model()->findByPk($selected_type);
   $box = $this->beginWidget ( 'bootstrap.widgets.TbBox', array (
		'title' => $etype->title . ' Summary',
		'headerIcon' => 'icon-th-list',
		'htmlOptions' => array (
				'class' => 'bootstrap-widget-table' 
		) 
) );
?>
   
   
    <?php
    
    
    
    $groupGridColumns = array (
    	array('header'=>'No.','value'=>'$row+1'),
		array('header' => 'Name', 'value' => '$data->empToEvaluate->fullname'),
		array('header' => 'Rating', 'value' => 'Yii::app()->numberFormatter->format("###.00",$data->aveRate)'),
		array('header' => 'No. of Evaluators', 'value' => '$data->totalEvaluator'),

    );
    $groupGridColumns[] = array(
		'name' => 'Department',
		'value' => '$data->empToEvaluate->department->name',
		'headerHtmlOptions' => array('style'=>'display:none'),
		'htmlOptions' =>array('style'=>'display:none')
);
    
   $this->widget('bootstrap.widgets.TbGroupGridView', array(
		//'filter'=>$person,
		'type'=>'striped bordered',
		'dataProvider' => $data_provider,
		'template' => "{items}",


		'extraRowColumns'=> array('Department'),
		'extraRowExpression' => '"<b style=\"font-size: 1.5em; color: #333;\">".$data->empToEvaluate->department->name."</b>"',
		'extraRowHtmlOptions' => array('style'=>'padding:10px'),



		'columns' => $groupGridColumns

));

    ?> 
    
    <?php $this->endWidget();?>

</div>
 