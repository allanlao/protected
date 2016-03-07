<?php
$this->breadcrumbs = array (
		'Leaves' => array (
				'empLeaves/Add Approved Leave' 
		),
		'New' 
);
?>

<div class="row">
    <div class="span12">
       <?php

			$box = $this->beginWidget ( 'bootstrap.widgets.TbBox', array (
					'title' => 'Add Approved Leave',
					'headerIcon' => 'icon-th-list',
					'htmlOptions' => array (
							'class' => 'bootstrap-widget-table' 
					) 
			) );

   		    $this->renderPartial('_form_admin',array('model'=>$model));
    
 			$this->endwidget();
 		?>

    </div>

</div>



 
 

<div id="grid-pending">
<?php 
   $box = $this->beginWidget ( 'bootstrap.widgets.TbBox', array (
		'title' => 'APPROVED LEAVES',
		'headerIcon' => 'icon-th-list',
		'htmlOptions' => array (
				'class' => 'bootstrap-widget-table' 
		) 
) );
?>
   
   
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id' => 'leave-grid-pending',
        'dataProvider' => $dataProvider,
        'itemsCssClass' => 'table  table-condensed',
        'template' => '{items}',
        'columns' => array(
            array('header' => 'No.', 'value' => '$row + 1'),
        	array('header' => 'Employee', 'value' => '$data->empNumber->fullname'),
            array('header' => 'Date Filed', 'value' => '$data->leave_date_filed'),
            array('header' => 'Leave Days', 'value' => array($this, 'getLeaveDays')),
        	array('header' => 'Total', 'value' => '$data->leave_days'),
            array(
                'header' => 'Leave Type',
                'value' => '$data->typeToStr($data->leave_type)',
            ),
        
          array('header' => 'Reason', 'value' => 'substr($data->leave_reason,0,15)'),
       
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{delete} {print}',
                'htmlOptions'=>array(
				'width'=>80,
				),
                'buttons'=>array(
						'print'=>array(
								'label'=>'<i class="icon-print"></i>',
								'url'=> 'Yii::app()->createUrl("leave/pdf/leaveForm", array("id"=>$data->leave_id))',
								'imageUrl'=>false,
                                'options'=>array('target'=>'_blank'),
						),
                )
                ,

                'deleteButtonUrl' => 'Yii::app()->createUrl("leave/default/delete", array("id"=>$data->leave_id))',
                
            ),
        ),
    ));
    ?> 
    
    <?php $this->endWidget();?>

</div>
 
