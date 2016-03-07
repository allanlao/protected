
<div class="well form-inline">

    <?php echo CHtml::beginForm(); ?>
    <div style="alignment-baseline:5px; ">  
   
        <label>Evaluation Period</label>
        <?php echo CHtml::dropDownList('period', 'period_id',
        		 EvaluationPeriod::model()->getEvaluationPeriods(),
         array('options' => array($selected_period => array('selected' => 'selected'),'class'=>'input-large'))); ?>

    <label > Evaluator</label>
          
        <?php echo CHtml::dropDownList('emp_number', 'categories', CHtml::listData(
         Employee::model()->getGroupedEmployees(), 'emp_number', 'name', 'group'),array('options'=>array($selected_emp=>array('selected'=>'selected'),'class'=>'input-medium'))
         ); ?> 
        <?php echo CHtml::htmlButton('<i class="icon-download icon-white"></i> Load', array('class' => 'btn btn-success', 'type' => 'submit', 'name' => 'submit')); ?>
    </div>
   
    <br>
    
      <div style="alignment-baseline:5px; ">  
   		 <label>Evaluation   _Type</label>
        <?php echo CHtml::dropDownList('etype', 'etype',
        		 EvaluationType::model()->getEvaluationTypes(),
        		array('options' => array($selected_type => array('selected' => 'selected')))
				);
       ?>

   		 <label> Employee to Evaluate </label>
            <?php echo CHtml::dropDownList('ratee', 'categories', CHtml::listData(
         Employee::model()->getGroupedEmployees(), 'emp_number', 'name', 'group'),array('options'=>array($selected_ratee=>array('selected'=>'selected')))
         ); ?> 
      
        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i> Add', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'add')); ?>
   		 </div>
    <?php echo CHtml::endForm(); ?>
</div><!-- form -->



<?php /* $this->widget( 'ext.EChosen.EChosen', array(
  'target' => 'select',
  'useJQuery' => true,
  'debug' => true,
  ));

 */ ?>
 
 
