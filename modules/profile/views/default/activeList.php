<?php

$box = $this->beginWidget ( 'bootstrap.widgets.TbBox', array (
		'title' => 'List of Active Employees',
		'headerIcon' => 'icon-wrench',
		// when displaying a table, if we include bootstra-widget-table class
		// the table will be 0-padding to the box
		'htmlOptions' => array (
			//	'class' => 'bootstrap-widget-table' 
		),
		
		'headerButtons' => array (
				array (
						'class' => 'bootstrap.widgets.TbButton',
						'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
						'label' => 'Print',
						'url' => array (
								'default/printActive' 
						),
						//'size' => 'small' 
				)
				 
		)  
)
 ); 
?>

<?php


$groupGridColumns = array (
		array('header'=>'No',
				'value' => '$row+1',
				'htmlOptions'=>array('style'=>'text-align:left'),
		),
		array('header'=>'Name',
				'value' => '$data->fullname',
				'htmlOptions'=>array('style'=>'text-align:left'),
		),
		
	
);

$groupGridColumns[] = array(
		'name' => 'department',
		'value' => '$data->emp_department_code',
		'headerHtmlOptions' => array('style'=>'display:none'),
		'htmlOptions' =>array('style'=>'display:none')
);



$this->widget('bootstrap.widgets.TbAlert');

$this->widget('bootstrap.widgets.TbGroupGridView', array(
		//'filter'=>$person,
		'type'=>'striped bordered',
		'dataProvider' => $data_provider,
		'template' => "{items}",
		
		
		'extraRowColumns'=> array('department'),
		'extraRowExpression' => '"<b style=\"font-size: 1.5em; color: #333;\">".$data->department->shortname."</b>"',
		'extraRowHtmlOptions' => array('style'=>'padding:10px'),
		
		
		
		'columns' => $groupGridColumns

));




?>


<?php $this->endWidget(); ?>




