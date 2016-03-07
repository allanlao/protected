

<h2>Leave Credit</h2>
<br>
<?php
$this->renderPartial("_search",array('lastname'=>$lastname,'firstname'=>$firstname));
?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submitLink', 
            'type'=>'primary', 
            'icon'=>'white',
            'label'=>'Add New',
            'htmlOptions'=>array(
              'submit'=>Yii::app()->createUrl("leave/empLeavesCredit/createOne"), 
             
            ),
)); ?>

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
                'name' => 'leave_used_vl',
                'header' => 'Used VL',
               'value' => array($this,'getUsedVl'),
            ),
            
           array(
                'name' => 'leave_used_sl',
                'header' => 'Used SL',
              'value' => array($this,'getUsedSl'),
            ),
            
                array(
                'name' => 'leave_vl_committed',
                'header' => 'Pending VL',
                'value' => array($this,'getPendingVl'),
            ),
           array(
                'name' => 'leave_sl_committed',
                'header' => 'Pending SL',
               'value' => array($this,'getPendingSl'),
            ),
            
           array(
                'name' => 'leave_used_others',
                'header' => 'Used Other',
                 'value' => array($this,'getUsedOthers'),
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