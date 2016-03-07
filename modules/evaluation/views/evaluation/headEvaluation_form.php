<?php 
	if (!is_null($answer))
	{
		Yii::app()->user->setFlash('error',
		'<h3><i class="icon-warning-sign"></i> Incomplete Answer<h3>');
	}

  $name = Employee::model()->findByPk($ratee)->getFullname();
?>
<h2><?php echo "Employee Name: ".$name; ?></h2>
<div class="form-inline">

    <?php echo CHtml::beginForm(); ?>
    <table class="table table-striped condensed">
    <?php
    $part = HeadQuestionCategory::model()->findAllBySql("SELECT * FROM headQuestion_category");  
    $count=0;
    foreach ($part as $item) { 
        $pid=$item->pid;
        $pc=$item->percentage;
    ?>
        <input type="hidden" name="percentage[<?php echo $pid; ?>]" value="<?php echo $pc; ?>">
        <tr ><th colspan="6">
        <b><?php echo "Part ".(++$count)." ".strtoupper($item->desc); ?></b>
        </th></tr>

     <?php
    $question = HeadQuestion::model()->findAllBySql("SELECT Distinct question FROM headQuestion where pid=$pid");  
    $az=65;
    foreach ($question as $a) { 
        $qid=$a->hq_id;
        $q=$a->question;
        
    ?>
        <tr ><th colspan="6">
        <p style="margin-left: 15px"><?php echo chr($az++).". ".$q; ?></p>
        </th></tr>
     <?php
    $subq = HeadQuestion::model()->findAllBySql("SELECT * FROM headQuestion where question='$q'");  
    $cnt=0;
    foreach ($subq as $b) { 
        $questionid=$b->hq_id;
        if(!($b->sub_question=='')){
    ?>
        
        <tr ><th colspan="6">
        <b style="margin-left: 30px"><?php echo (++$cnt).". ".$b->sub_question; ?></b>
        </th></tr> 
    <?php }?>
    
    
        <tr>
            <td><p style='margin-left:45px;'><?php echo "<input type='radio' checked name='answer[$pid][$questionid]' value='5'><span style='margin-left:15px;'>$b->c1"; ?></span></p></td>
        </tr>
        <tr>
            <td><p style='margin-left:45px;'><?php echo "<input type='radio' name='answer[$pid][$questionid]' value='4'><span style='margin-left:15px;'>$b->c2"; ?></span></p></td>
        </tr>
        <tr>
           <td><p style='margin-left:45px;'><?php echo "<input type='radio' name='answer[$pid][$questionid]' value='3'><span style='margin-left:15px;'>$b->c3"; ?></span></p></td>
        </tr>
        <tr>
            <td><p style='margin-left:45px;'><?php echo "<input type='radio' name='answer[$pid][$questionid]' value='2'><span style='margin-left:15px;'>$b->c4"; ?></span></p></td>
        </tr>
        <?php if(!($b->c5=='')){ ?>
        <tr>
          <td><p style='margin-left:45px;'><?php echo "<input type='radio' name='answer[$pid][$questionid]' value='1'><span style='margin-left:15px;'>$b->c5"; ?></span></p></td>
        </tr>
    
    <?php }}}} ?>
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
