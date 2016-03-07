

<h2>Leaves</h2>
<br>
<?php
   $this->renderPartial("_search",array('lastname'=>$lastname,'firstname'=>$firstname));
?>
<div id="grid-leaves">
<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'leave-grid',
    'dataProvider' => $dataProvider,
    'template' => '{items}{pager}',
    'columns' => array(
        array('header' => 'No.', 'value' => '$row + 1'),
    'leave_id',
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
                'template' => '{delete}',
                'deleteButtonUrl' => 'Yii::app()->createUrl("leave/default/delete", array("id"=>$data->leave_id))',
              
            ),
       
    ),
));
?>
</div>