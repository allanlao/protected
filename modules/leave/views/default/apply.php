<?php
$this->breadcrumbs = array (
		'Leaves' => array (
				'empLeaves/create' 
		),
		'New' 
);
?>

<div class="row">
    <div class="span8">
       <?php

			$box = $this->beginWidget ( 'bootstrap.widgets.TbBox', array (
					'title' => 'Apply New Leave',
					'headerIcon' => 'icon-th-list',
					'htmlOptions' => array (
							'class' => 'bootstrap-widget-table' 
					) 
			) );

   		    $this->renderPartial('_form',array('model'=>$model));
    
 			$this->endwidget();
 		?>

    </div>

    <div class="span3">

        <?php
        
        $box = $this->beginWidget ( 'bootstrap.widgets.TbBox', array (
        		'title' => 'Summary ['. $sy .']',
        		'headerIcon' => 'icon-th-list',
        		'htmlOptions' => array (
        				'class' => 'bootstrap-widget-table'
        		)
        ) );
        
        $this->renderPartial('_leavesSummary', array('emp_number' => $emp_number,'sy'=>$sy));
        $this->endWidget();
        ?>




    </div>
</div>



 
 

<div id="grid-pending">
<?php 
   $box = $this->beginWidget ( 'bootstrap.widgets.TbBox', array (
		'title' => 'Leaves for Approval',
		'headerIcon' => 'icon-th-list',
		'htmlOptions' => array (
				'class' => 'bootstrap-widget-table' 
		) 
) );
?>
   
   
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id' => 'leave-grid-pending',
        'dataProvider' => $dataProvider_pending,
        'itemsCssClass' => 'table  table-condensed',
        'template' => '{items}',
        'columns' => array(
         array('header' => 'No.', 'value' => '$row + 1'),
	
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
                'deleteButtonUrl' => 'Yii::app()->createUrl("leave/default/delete", array("id"=>$data->leave_id))',
                'buttons'=>array(
                        'print'=>array(
								'label'=>'<i class="icon-print"></i>',
								'url'=> 'Yii::app()->createUrl("leave/pdf/leaveForm", array("id"=>$data->leave_id))',
								'imageUrl'=>false,
                                'options'=>array('target'=>'_blank'),
						),
 
                 ),
                
            ),
        ),
    ));
    ?> 
    
    <?php $this->endWidget();?>

</div>
 
