<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>

<?php


$box = $this->beginWidget ( 'bootstrap.widgets.TbBox', array (
		'title' => 'User List',
		'headerIcon' => 'icon-edit',
		// when displaying a table, if we include bootstrap-widget-table class
		// the table will be 0-padding to the box
		'htmlOptions' => array (
		//'class' => 'bootstrap-widget-table' 
		),
        'headerButtons' => array (
		array (
				'class' => 'bootstrap.widgets.TbButton',
				'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
				'label' => 'Add User',
				'url' => array (
						'default/create'
				),
			//	'size' => 'large'
		))
	)
 );
?>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
        'id'=>'e_contacts-grid',
       // 'dataProvider'=>$dataProvider,
		'dataProvider'=>$model->search(),
		'filter'=>$model,
        'columns'=>array(
                array('header'=>'No.','value'=>'$row + 1'),
                
                'email',
        		'empNumber',
        		// array('header'=>'Employee','value'=>'$data->employee->fullname'),
                'role',
                'status',
              
              
                array(
                        'class'=>'CButtonColumn',
                        'template'=>'{delete}',
                        'deleteButtonUrl'=>'Yii::app()->createUrl("admin/default/delete", array("id" => $data->email))',

                ),

        ),
)); ?>



<?php $this->endWidget(); ?>