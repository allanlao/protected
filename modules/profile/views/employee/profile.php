<?php
$this->breadcrumbs=array(
	'Employee'=>array('index'),
	'Profile',
);


?>

<h2>Employee Profile</h2>



</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.BootGridView', array(
	'id'=>'products-grid',

        'template'=>'{items}{pager}',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'columns'=>array(
         array('name'=>'emp_firstname', 'header'=>'First name'),
         array('name'=>'emp_lastname', 'header'=>'Last name'),
         array('name'=>'emp_number', 'header'=>'Employee Number'),
       
         array(
	          
	            'type' => 'raw',
	            'value' => 'CHtml::link("View Profile", array("employee/updatePersonal&id=".$data->emp_number))',
	     
             'header'=>'Action',
            
             ),
    ),
)); ?>

