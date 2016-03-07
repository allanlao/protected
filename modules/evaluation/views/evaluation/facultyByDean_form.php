<?php 

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/eval.css');

  if (!is_null($answer))
  {
  	Yii::app()->user->setFlash('error', 
   	'<h3><i class="icon-warning-sign"></i> Incomplete Answer</h3>');
  }

   $name = Employee::model()->findByPk($ratee)->getFullname();
?>


<?php $this->widget('bootstrap.widgets.TbAlert', array(
		'block'=>true, // display a larger alert block?
		'fade'=>true, // use transitions?
		'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
		
    )); 
?>

    <h2><?php echo "Employee Name: ".$name; ?></h2>
    
<div class="form-inline">
    <?php 
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'eval_form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'htmlOptions' => array('class' => 'form-horizontal'),
        ));
    ?>


    <?php 
     $this->renderPartial('_facultyByDean_html',array('answer'=>$answer,'comments'=>$comments));
    ?>
    
    
    
    
    
<?php $this->endWidget(); ?>

</div>
<style type="text/css">
    input[type=radio]{
        vertical-align: middle;
        margin:-5px 5px 0px 0px;
    }
</style>
