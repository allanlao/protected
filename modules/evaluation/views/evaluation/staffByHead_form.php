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
    $cat = StaffByHeadQuestionCategory::model()->findAllBySql("SELECT distinct description FROM staffByHeadQuestion_category");  
    $count=0;
    foreach ($cat as $item) { 
        $description=addslashes($item->description);
    ?>
        <tr ><th colspan="6">
        <p><?php echo (++$count).". ".$item->description; ?></p>
        
   <?php
    $subcat = StaffByHeadQuestionCategory::model()->findAllBySql("SELECT nhqc_id, subcat FROM staffByHeadQuestion_category where description='$description'");  
    $count1=65;
    foreach ($subcat as $item2) { 
        $catid=$item2->nhqc_id;
        if(!($item2->subcat=='')){
    ?>
    <tr ><th colspan="6"><p style="margin-left: 25px"><?php echo chr($count1++).". ".$item2->subcat; ?></p>
    <?php } ?>
        
    <?php
       $question=  StaffByHeadQuestion::model()->findAllBySql("Select * from staffByHeadQuestion where nhqc_id=$catid"); 
       $count2=0;
       foreach($question as $item3){
           $pc=$item3->percentage;
           $questionid=$item3->nhq_id;
           if(!($item3->question=='')){?>
               <tr ><th colspan="6"><p style="margin-left: 35px"><?php echo (++$count2).". ".$item3->question; ?></p>
          <?php }?>
        <input type="hidden" name="percentage[<?php echo $questionid; ?>]" value="<?php echo $pc; ?>">
        
         <!-- use these questions with previous ans -->
                
               <?php  
                   $c1 = ""; $c2=""; $c3=""; $c4=""; $c5="";
                  if(isset($_POST['answer'][$questionid])){ 
						$x = "c".$_POST['answer'][$questionid]; //$x is c3
						$$x = "checked";
                   }
                  
                 
               	?>
        
        
        
        <tr>           
        <td><p style='margin-left:55px;'><?php echo "<input type='radio' $c5 name='answer[$questionid]' value='5'><span style='margin-left:15px;'>$item3->c1"; ?></span></p></td>
        </tr>
        <tr>
            <td><p style='margin-left:55px;'><?php echo "<input type='radio' $c4 name='answer[$questionid]' value='4'><span style='margin-left:15px;'>$item3->c2"; ?></span></p></td>
        </tr>
        <tr>
           <td><p style='margin-left:55px;'><?php echo "<input type='radio' $c3 name='answer[$questionid]' value='3'><span style='margin-left:15px;'>$item3->c3"; ?></span></p></td>
        </tr>
        <tr>
            <td><p style='margin-left:55px;'><?php echo "<input type='radio' $c2 name='answer[$questionid]' value='2'><span style='margin-left:15px;'>$item3->c4"; ?></span></p></td>
        </tr>
        <tr>
          <td><p style='margin-left:55px;'><?php echo "<input type='radio' $c1 name='answer[$questionid]' value='1'><span style='margin-left:15px;'>$item3->c5"; ?></span></p></td>
        </tr>
        
    <?php }}} ?>
   
   
    <!--<tr>
        <td colspan="6">
            <p>RATEE'S OUTSTANDING ACHIEVEMENTS</p>
        </td>
        <td style="padding-left: 10px;"><input type="text" name="achievements" style="width:500px;"></input>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            <p>SPECIAL ABILITIES</p>
        </td>
        <td style="padding-left: 10px;"><input type="text" name="abilities" style="width:500px;"></input>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            <p>WEAK POINTS</p>
        </td>
        <td style="padding-left: 10px;"><input type="text" name="weakpts" style="width:500px;"></input>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            <p>SUGGESTED IMPROVEMENTS</p>
        </td>
        <td style="padding-left: 10px;"><input type="text" name="sug_improvements" style="width:500px;"></input>
        </td>
    </tr>-->
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
