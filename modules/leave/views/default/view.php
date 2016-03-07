

<h2>Leave Credit</h2>
<br>
<?php
$this->renderPartial("_search",array('lastname'=>$lastname,'firstname'=>$firstname));
?>

<?php 


$box = $this->beginWidget ( 'bootstrap.widgets.TbBox', array (
		'title' => 'Summary of Leave Credits',
		'headerIcon' => 'icon-leaf',
		// when displaying a table, if we include bootstra-widget-table class
		// the table will be 0-padding to the box
		'htmlOptions' => array (
				//	'class' => 'bootstrap-widget-table'
		),

		 'headerButtons' => array (
		 array (
		 		'class' => 'bootstrap.widgets.TbButton',
		 		'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		 		'label' => 'Add New',
		 		'url' => array (
		 				'default/createOne'
		 		),
		 		'size' => 'small'
		 )
					
		)  
)
);

 ?>

<div id="grid-leaves">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id' => 'leave-grid',
        'dataProvider' => $dataProvider,
        'template' => '{items}{pager}',
        'columns' => array(
            array('header' => 'No.', 'value' => '$row + 1'),
            array(
                'name' => 'emp_number',
                'header' => 'Employee Name',
                'value' => '$data->empNumber->fullname',
            ),
            array(
                'name' => 'leave_sy',
                'header' => 'SchoolYear',
                'value' => '$data->leave_sy',
            ),
            array(
                'name' => 'leave_allocated_vl',
                'header' => 'VL',
                'value' => '$data->leave_allocated_vl',
            ),
            array(
                'name' => 'leave_allocated_sl',
                'header' => 'SL',
                'value' => '$data->leave_allocated_sl',
            ),
            
           
          
           
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{update}',
                'updateButtonUrl' => 'Yii::app()->createUrl("leave/empLeavesCredit/update", array("id"=>$data->leave_credit_id))',
            ),
        ),
    ));
    ?>
</div>


<?php $this->endWidget(); ?>