<?php 

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

    <table class="table table-striped">
        <thead>
            <tr ><th colspan="6">
            <b><?php echo "LIDS Principles"; ?></b>
            </th></tr>
        </thead> 
        <tbody>
            <?php
                $question = FacultyByHeadQuestion::model()->findAll();
                $counter = 0;
                foreach ($question as $item) { //QUESTIONS
                    $question_id = $item['id'];
            ?>
                    <tr>
                        <td colspan="6">  
                          <p> <?php 
                            $counter++;
                            echo $counter . ". " . $item['question']; ?>
                          </p>
                        </td>
                    </tr>
                    <tr>
                    
                     <?php  
                  	 $c1 = ""; $c2=""; $c3=""; $c4=""; $c5="";
	                  if(isset($_POST['answer'][$question_id])){ 
							$x = "c".$_POST['answer'][$question_id]; //$x is c3
							$$x = "checked";
	                   }
                	?>
                        <td>&nbsp;</td>
                        <td><?php echo "<input type='radio' name='answer[$question_id]' $c5 value='5'>Excellent (5)</input>"; ?></td>
                        <td><?php echo "<input type='radio' name='answer[$question_id]' $c4 value='4'>Very Good (4)"; ?></td>
                        <td><?php echo "<input type='radio' name='answer[$question_id]' $c3 value='3'>Good (3)"; ?></td>
                        <td><?php echo "<input type='radio' name='answer[$question_id]' $c2 value='2'>Unsatisfactory (2)"; ?></td>
                        <td><?php echo "<input type='radio' name='answer[$question_id]' $c1 value='1'>Poor (1)"; ?></td>
                    </tr>
            <?php
                }
            ?>
   
        <tr>
            <td colspan="6">
                <b>Comments</b>
            </td>
        </tr>
        <tr>
            <td colspan="6"  >
                <textarea name="comments" class="span8" rows="7">
                <?php echo trim($comments);?></textarea>
            </td>
        </tr>
        <input type='hidden' name='emap_id' value='<?php echo $emap_id; ?>'>
        <tr>
            <td colspan="6">
                <?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> Submit', array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
                <?php echo CHtml::htmlButton('<i class="icon-ban-circle"></i> Reset', array('class' => 'btn', 'type' => 'reset')); ?>
            </td>
        </tr>
                </tbody>
    </table>
<?php $this->endWidget(); ?>

</div>
<style type="text/css">
    input[type=radio]{
        vertical-align: middle;
        margin:-5px 5px 0px 0px;
    }
</style>
