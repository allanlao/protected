<?php $this->breadcrumbs=array(
	'Profile'=>array('employee/updatePersonal'),
	'Work Experience',
);
?>


<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'emp_num')); ?>



<div id="box-panel">
    
<?php $this->widget('bootstrap.widgets.TbGridView', array(
        'id'=>'e_work-grid',
        'dataProvider'=>$dataProvider,
        'columns'=>array(
                array('header'=>'No.','value'=>'$row + 1'),
                array('header'=>'Employer','name'=>'eexp_employer','htmlOptions'=>array('width'=>'140')),
                'eexp_jobtit',
                'eexp_from_date',
                'eexp_to_date',
                'eexp_comments',
                'eexp_internal',
              
                array(
                        'class'=>'CButtonColumn',
                        'template'=>'{delete}',
                        'deleteButtonUrl'=>'Yii::app()->createUrl("profile/empWorkExperience/delete", array("id" => $data->eexp_id))',

                ),

        ),
)); ?>
</div>

