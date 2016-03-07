<?php $this->breadcrumbs=array(
	'Profile'=>array('employee/updatePersonal'),
	'Dependents',
);
?>


<?php
Yii::app()->clientScript->registerScript('add', "

$('.add-button').click(function(){
	$('.new-form').toggle('fast');
        if (  $('.add-button').text() == 'hide form')
           $('.add-button').text('show form');
        else
           $('.add-button').text('hide form');
        return false;
});

");


?>




<div>
<?php echo CHtml::link('hide form','#',array('class'=>'add-button')); ?>
</div>
<br>
<div class="new-form" >
   <?php echo $this->renderPartial('_form', array('model'=>$model,'emp_num')); ?>
</div><!-- search-form -->




<div id="box-panel">
    
<?php $this->widget('bootstrap.widgets.TbGridView', array(
        'id'=>'e_contacts-grid',
        'dataProvider'=>$dataProvider,
        'columns'=>array(
                array('header'=>'No.','value'=>'$row + 1'),
                array('header'=>'Name of Dependent','name'=>'ed_name','htmlOptions'=>array('width'=>'120')),
              
                'ed_relationship',
                'ed_date_of_birth',
               
               array(
                        'class'=>'CButtonColumn',
                        'template'=>'{delete}',
                        'deleteButtonUrl'=>'Yii::app()->createUrl("profile/empDependents/delete", array("id" => $data->ed_id))',

                ),
            
        ),
)); ?>
</div>