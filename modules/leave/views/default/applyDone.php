<h1>Leave No : <?php echo $leave_id;?></h1>
<div>You can go to the Internet Room to print your application for leave</div>
<div>or you can print it now.</div>
<div>Note: Print Settings: Actual Size / Portrait </div>

<?php echo CHtml::link('<h4><i class="icon-print"> Print</i></h4>',array('pdf/leaveForm',
		                   'id'=>$leave_id), array('target'=>'_blank'));?>
                   

                   