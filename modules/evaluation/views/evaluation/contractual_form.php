<?php 
if (!is_null($answer))
  {
   	Yii::app()->user->setFlash('error', 
   	'<h3><i class="icon-warning-sign"></i> Incomplete Answer</h3>');
  }

  ?>

<?php 
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
    $que = ContractualByHeadQuestion::model()->findAllBySql("SELECT * FROM contractualByHeadQuestion");  
    foreach ($que as $item) { 
        $qid=$item->ncq_id;
    ?>
        <tr ><th colspan="6">
        <b><?php echo strtoupper($item->question); ?></b>
        </th></tr>
        
        
          <!-- use these questions with previous ans -->
                
               <?php  
                   $c1 = ""; $c2=""; $c3=""; $c4=""; $c5="";
                  if(isset($_POST['answer'][$qid])){ 
						$x = "c".$_POST['answer'][$qid]; //$x is c3
						$$x = "checked";
                   }
                  
                 
               	?>
        
        <tr>
            <td><p style='margin-left:50px;'><?php echo "<input type='radio' $c5 name='answer[$qid]' value='5'><span style='margin-left:15px;'>$item->c1"; ?></span></p></td>
        </tr>
        <tr>
            <td><p style='margin-left:50px;'><?php echo "<input type='radio' $c4 name='answer[$qid]' value='4'><span style='margin-left:15px;'>$item->c2"; ?></span></p></td>
        </tr>
        <tr>
           <td><p style='margin-left:50px;'><?php echo "<input type='radio' $c3 name='answer[$qid]' value='3'><span style='margin-left:15px;'>$item->c3"; ?></span></p></td>
        </tr>
        <tr>
            <td><p style='margin-left:50px;'><?php echo "<input type='radio' $c2 name='answer[$qid]' value='2'><span style='margin-left:15px;'>$item->c4"; ?></span></p></td>
        </tr>
        <tr>
          <td><p style='margin-left:50px;'><?php echo "<input type='radio'  $c1 name='answer[$qid]' value='1'><span style='margin-left:15px;'>$item->c5"; ?></span></p></td>
        </tr>
        <?php } ?>

    
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
  
    
    <tr>
        <td colspan="6">
             <input type='hidden' name='emap_id' value='<?php echo $emap_id; ?>'>
            <?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> Submit', array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'Validate()')); ?>
            <?php echo CHtml::htmlButton('<i class="icon-ban-circle"></i> Reset', array('class' => 'btn', 'type' => 'reset')); ?>
        </td>
    </tr>
    
</table>


<?php echo CHtml::endForm(); ?>

</div>
