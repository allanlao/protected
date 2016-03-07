<?php $this->breadcrumbs=array(
	'Profile'=>array('employee/updatePersonal'),
	'Educational Qualification',
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
   <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div><!-- search-form -->




<div id="box-panel">
    
<?php $this->widget('bootstrap.widgets.TbGridView', array(
        'id'=>'e_contacts-grid',
        'dataProvider'=>$dataProvider,
        'columns'=>array(
                array('header'=>'No.','value'=>'$row + 1'),
                'edu_type',
                array('header'=>'Degree','name'=>'edu_degree','htmlOptions'=>array('width'=>'250')),
                'edu_school',
                'edu_start_date',
                'edu_end_date',
                'edu_comments',
               
              
                array(
                        'class'=>'CButtonColumn',
                        'template'=>'{delete}',
                        'deleteButtonUrl'=>'Yii::app()->createUrl("profile/empEducation/delete", array("id" => $data->edu_id))',

                ),

        ),
)); ?>
</div>