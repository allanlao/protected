

<div class="well form-inline">

    <?php echo CHtml::beginForm(); ?>
    <div style="alignment-baseline:5px; ">  
   
        <label>Evaluation Period</label>
        <?php echo CHtml::dropDownList('period', 'period_id',
        		 EvaluationPeriod::model()->getEvaluationPeriods(),
         array('options' => array($period => array('selected' => 'selected'),'class'=>'input-large'))); ?>
         
         <label>Evaluation Type</label>
         <label>Evaluation   _Type</label>
        <?php echo CHtml::dropDownList('etype', 'etype',
        		 EvaluationType::model()->getEvaluationTypes(),
        		array('options' => array($selected_type => array('selected' => 'selected')))
				);
       ?>
         
       <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i> Load', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'add')); ?>
   
     </div>
   
    <?php echo CHtml::endForm(); ?>
</div><!-- form -->

