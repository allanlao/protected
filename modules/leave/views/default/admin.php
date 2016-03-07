<?php Yii::app()->clientScript->registerScript('leave', "
jQuery('#approve').live('click',function() { if(!confirm('Are you sure you want to approve this leave?')) return false;
        var th=this;
        var afterDelete=function(){};
        $.fn.yiiGridView.update('leave-grid', {
                type:'POST',
                url:$(this).attr('href'),
                success:function(data) {
                        $.fn.yiiGridView.update('leave-grid');
                        afterDelete(th,true,data);
                },
                error:function(XHR) {
                        return afterDelete(th,false,XHR);
                }
        });
        return false;
		
});
");
?>

<?php Yii::app()->clientScript->registerScript('leave', "
jQuery('#disapprove').live('click',function() { if(!confirm('Are you sure you want to disapprove this leave?')) return false;
        var th=this;
        var afterDelete=function(){};
        $.fn.yiiGridView.update('leave-grid', {
                type:'POST',
                url:$(this).attr('href'),
                success:function(data) {
                        $.fn.yiiGridView.update('leave-grid');
                        afterDelete(th,true,data);
                },
                error:function(XHR) {
                        return afterDelete(th,false,XHR);
                }
        });
        return false;
		
});
");
?>

<h2>Approval</h2>
<h4>(Use this to update status of filed leaves or print leave form)</h4>
<br>
<?php
   $this->renderPartial("_search_admin",array('lastname'=>$lastname,'leave_id'=>$leave_id));
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
    				'name'=>'leave_id',
    				'header' => 'Leave No',
    				'value' => '$data->leave_id',
    		),
       array(
            'name'=>'emp_number',
            'header' => 'Employee Name',
            'value' => '$data->empNumber->fullname',
        ),
       
        array(
            'name'=>'leave_date_filed',
            'header' => 'Date Filed',
            'value' => 'date("M d, Y",strtotime($data->leave_date_filed))',
        ),
        'leave_days',
       
         array(
            'name'=>'leave_type',
            'header' => 'Leave Type',
            'value' => '$data->typeToStr($data->leave_type)',
        ),
         array(
                'header' => 'Dates',
                'value' => 'EmpLeavesDetails::model()->getLeaveDates($data->leave_id)',
            ),
     
      
        'leave_status',
        array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{print} {approve} {disapprove}',
               
        		'buttons'=>array(
        				'print'=>array(
        						'label'=>'',
        						'url'=> 'Yii::app()->createUrl("leave/pdf/leaveForm", array("id"=>$data->leave_id))',
        						'imageUrl'=>false,
        						'options'=>array('class'=>'icon-print','target'=>'_blank','title'=>'print'),
        				),
        				'approve'=>array(
        						'label'=>'',
        						'url'=> 'Yii::app()->createUrl("leave/default/approve", array("id"=>$data->leave_id))',
        						'imageUrl'=>false,
        						'options'=>array('id'=>'approve' ,'class'=>'icon-thumbs-up','title'=>'Approve Leave'),
        						
        				),
						'disapprove'=>array(
								'label'=>'',
								'url'=> 'Yii::app()->createUrl("leave/default/disapprove", array("id"=>$data->leave_id))',
								'imageUrl'=>false,
								'options'=>array('id'=>'disapprove' ,'class'=>'icon-thumbs-down','title'=>'Approve Leave'),
						
						),
        		
        		),
              
            ),
       
    ),
));
?>
</div>