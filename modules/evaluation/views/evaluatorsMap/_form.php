
<div class="well form-inline">

    <?php echo CHtml::beginForm(); ?>
    <div style="alignment-baseline:5px; ">  
    <label>Evaluation Period</label>
        <?php echo CHtml::dropDownList('etype', 'etype',
        		 EvaluationType::model()->getEvaluationTypes());
       ?>

    <label> Employee</label>
            <?php echo CHtml::dropDownList('emp_number', 'categories', CHtml::listData(
         Employee::model()->getGroupedEmployees(), 'emp_number', 'name', 'group'),array('options'=>array($selected_emp=>array('selected'=>'selected')))
         ); ?> 
      
        <?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i> Add', array('class' => 'btn btn-success', 'type' => 'submit', 'name' => 'add')); ?>
    </div>
    <input type
    <?php echo CHtml::endForm(); ?>
</div><!-- form -->



<?php /* $this->widget( 'ext.EChosen.EChosen', array(
  'target' => 'select',
  'useJQuery' => true,
  'debug' => true,
  ));

 */ ?>
 
 
