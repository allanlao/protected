

<div class="well form-inline">

    <?php echo CHtml::beginForm(); ?>
    <div style="alignment-baseline:5px; ">  
         <label>Leave No.</label>
        <?php echo CHtml::textField('leave_id',$leave_id); ?>
        <label>Lastname</label>
        <?php echo CHtml::textField('lastname',$lastname); ?>
       

        <?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i> Search', array('class' => 'btn btn-success', 'type' => 'submit', 'name' => 'submit')); ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</div><!-- form -->

