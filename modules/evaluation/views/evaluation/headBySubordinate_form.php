<?php 

	if (!is_null($answer))
	{
		Yii::app()->user->setFlash('error',
		'<h3><i class="icon-warning-sign"></i> Incomplete Answer<h3>');
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
    <?php echo CHtml::beginForm(); ?>
    <table class="table table-striped">

        <?php
        $model = HeadBySubordinateQuestionCategory::model()->findAll();
        foreach ($model as $item) {     //CATEGORIES
            ?>
            <tr><th colspan="6">
            <b><?php echo strtoupper($item['description']); ?></b>
            </th>
           </tr>

            <?php
            $per = $item['percentage'];
            $catid = $item['catid'];
            $subcat = HeadBySubordinateQuestionSubcategory::model()->findAll(
                    array('condition' => 'cat_id=:cat_id',
                        'params' => array(':cat_id' => $catid)));
            foreach ($subcat as $item2) { //SUBCATEGRIES
                $subcatid = $item2['subcat_id'];
                if(!$item2['description']==''){
                ?>
                <tr><th colspan="6">        
                    <p><?php echo $item2['description'];?></p>
                </th></tr>
                <?php }?>
                    <input type="hidden" name="percentage[<?php echo $catid ?>]" value="<?php echo $per; ?>">
                <?php
                $question = HeadBySubordinateQuestion::model()->findAll(
                        array('condition' => 'subcat_id=:sub_id',
                            'params' => array(':sub_id' => $subcatid)));
                $counter = 0;
                foreach ($question as $item3) { //QUESTIONS
                    $question_id = $item3['hsq_id'];
                    ?>
                    <tr><td colspan="6">  
                            <p> <?php $counter++;    echo $counter . ". " . $item3['question']; ?></p>
                        </td>
                    </tr>
                    
                     <?php  
                  /* $c1 = ""; $c2=""; $c3=""; $c4=""; $c5="";
                  if(isset($_POST['answer'][$item3->pq_id])){ 
						$x = "c".$_POST['answer'][$item3->pq_id]; //$x is c3
						$$x = "checked";
                   }*/
                  
                 
               	?>
                    <tr>
                        <td>&nbsp;</td>
                        <td><?php echo "<input type='radio' name='answer[$catid][$question_id]' value='5'> Excellent(5)"; ?></td>
                        <td><?php echo "<input type='radio' name='answer[$catid][$question_id]' value='4'> Very Good(4)"; ?></td>
                        <td><?php echo "<input type='radio' name='answer[$catid][$question_id]' value='3'> Good(3)"; ?></td>
                        <td><?php echo "<input type='radio' name='answer[$catid][$question_id]' value='2'> Unsatisfactory(2)"; ?></td>
                        <td><?php echo "<input checked type='radio' name='answer[$catid][$question_id]' value='1'> Poor(1)"; ?></td>
                    </tr>

                    <?php
                }
            }
        }
        ?>
        <tr>
            <td colspan="6">
                <b>Comments</b>
            </td>
        </tr>
        <tr>
            <td colspan="6"  >
                <textarea name="comments" class="span8" rows="7"><?php echo trim($comments);?></textarea>

            </td>
        </tr>
         <input type='hidden' name='emap_id' value='<?php echo $emap_id; ?>'>
        <tr>
            <td colspan="6">
                <?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> Submit', array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'Validate()')); ?>
                <?php echo CHtml::htmlButton('<i class="icon-ban-circle"></i> Reset', array('class' => 'btn', 'type' => 'reset')); ?>
            </td>
        </tr>

    </table>
    <?php echo CHtml::endForm(); ?>
</div>