
<div class="well form-inline">

    <?php echo CHtml::beginForm(); ?>
     <label>Evaluation Period</label>
        <?php echo CHtml::dropDownList('period', 'period_id',
        		 EvaluationPeriod::model()->getAllEvaluationPeriods(),
         array('options' => array($selected_period => array('selected' => 'selected'),'class'=>'input-large'))); ?>

    

   		 <label>Evaluation   _Type</label>
        <?php echo CHtml::dropDownList('etype', 'etype',
        		 EvaluationType::model()->getEvaluationTypes(),
        		array('options' => array($selected_type => array('selected' => 'selected')))
				);
       ?>
   <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i> Submit', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit')); ?>
   	
      
    <?php echo CHtml::endForm(); ?>
</div><!-- form -->



<?php /* $this->widget( 'ext.EChosen.EChosen', array(
  'target' => 'select',
  'useJQuery' => true,
  'debug' => true,
  ));

 */ ?>
 
 
