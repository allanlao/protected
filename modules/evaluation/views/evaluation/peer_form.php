

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


<h4><?php echo "Employee Name: ".$name; ?></h4>
<div class="well form-inline" >
       <?php echo CHtml::beginForm(); ?>
    <table class="table table-striped">
     
<?php
     $cat = PeerQuestion::model()->findAllBySql("SELECT Distinct category FROM peerQuestion");  
     foreach($cat as $item){       //Categories                           ?>  
         <tr><th colspan="5">
               <p><?php echo strtoupper($item->category); ?></p>
         </th></tr>
<?php 
         $subcat = PeerQuestion::model()->findAllBySql("SELECT Distinct sub_category FROM peerQuestion where category='$item->category'");
         foreach ($subcat as $item2) {  //Sub_Categories                           ?>  
             <tr ><th colspan="5">
               <b><?php echo $item2->sub_category; ?></b>
             </th></tr>
<?php 
          $question = PeerQuestion::model()->findAllBySql("SELECT pq_id,question FROM peerQuestion where sub_category='$item2->sub_category'");
          $count=0;
          foreach($question as $item3){ $count++; //Questions              ?>
                <tr ><td colspan="5">
                <p><?php echo "$count. $item3->question"; ?></p>
                </td></tr>
                <!-- use these questions with previous ans -->
                
               <?php  
                   $c1 = ""; $c2=""; $c3=""; $c4=""; $c5="";
                  if(isset($_POST['answer'][$item3->pq_id])){ 
						$x = "c".$_POST['answer'][$item3->pq_id]; //$x is c3
						$$x = "checked";
                   }
                  
                 
               	?>
                <tr><td colspan="5">
                    <p class="offset1"><?php echo "<input type='radio' $c5 name='answer[$item3->pq_id]' value='5'><span style='margin-left:10px;'>Always does this, outstanding(5)</span>"; ?></p>
                </td></tr>
                <tr><td colspan="5">
                    <p class="offset1"><?php echo "<input type='radio' $c4 name='answer[$item3->pq_id]' value='4'><span style='margin-left:10px;'>Usually does this, very good(4)</span>"; ?></p>
                </td></tr>
                <tr><td colspan="5">
                    <p class="offset1"><?php echo "<input type='radio' $c3 name='answer[$item3->pq_id]' value='3'><span style='margin-left:10px;'>Sometimes does this, good(3)</span>"; ?></p>
                </td></tr>
                <tr><td colspan="5">
                    <p class="offset1"><?php echo "<input type='radio' $c2 name='answer[$item3->pq_id]' value='2'><span style='margin-left:10px;'>Seldom does this, unsatisfactory(2)</span>"; ?></p>
                </td></tr>
                <tr><td colspan="5">
                    <p class="offset1"><?php echo "<input type='radio' $c1 name='answer[$item3->pq_id]' value='1'><span style='margin-left:10px;'>Hardly does this, poor(1)</span>"; ?></p>
                </td></tr>
              
<?php             
          }
        }
    }
?>
                 <tr>
                    <td colspan="5">
                        <b>Comments</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="5"  >
                        <textarea name="comments" class="span8" rows="7"><?php echo trim($comments);?></textarea>
           
                    </td>
                </tr>
                 <tr>
                     <td colspan="5">
                          <input type='hidden' name='emap_id' value='<?php echo $emap_id; ?>'>
                         <?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> Submit', array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'Validate()')); ?>
                         <?php echo CHtml::htmlButton('<i class="icon-ban-circle"></i> Reset', array('class' => 'btn', 'type' => 'reset')); ?>
                     </td>
                 </tr>
           
 </table>
     <?php echo CHtml::endForm(); ?>
</div>
