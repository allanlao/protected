<?php
$this->breadcrumbs=array(
	'Employee'=>array('index'),
	'Profile',
);


?>

<h2>Employee List</h2>



</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'products-grid',

        'template'=>'{items}{pager}',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'columns'=>array(
         array('name'=>'emp_firstname', 'header'=>'First name'),
         array('name'=>'emp_lastname', 'header'=>'Last name'),
         array('name'=>'emp_number', 'header'=>'Employee Number'),
       
       
        		array(
        				'class' => 'bootstrap.widgets.TbButtonColumn',
        				'template' => '{update} | {delete}',
        				'updateButtonUrl' => 'Yii::app()->createUrl("profile/default/updatePersonal", array("id"=>$data->emp_number))',
        				'deleteButtonUrl' => 'Yii::app()->createUrl("profile/default/delete", array("id"=>$data->emp_number))',
        		),
        	
    ),
)); ?>

