<?php $this->widget('bootstrap.widgets.TbAlert', array(
		'block'=>true, // display a larger alert block?
		'fade'=>true, // use transitions?
		'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
		
    )); 
?>
<?php

$period = EvaluationPeriod::model()->findByPk($id);

$box = $this->beginWidget ( 'bootstrap.widgets.TbBox', array (
		'title' => 'Peer Evaluation Details [ '. $period->sem . ' SEM SY ' . $period->sy .'  ]',
		'headerIcon' => 'icon-edit',
		// when displaying a table, if we include bootstrap-widget-table class
		// the table will be 0-padding to the box
		'htmlOptions' => array (
		//'class' => 'bootstrap-widget-table' 
		),
		
		
)
 );
?>



<table class="table table-hover fixed">
<thead>
<th>No.</th>
<th>Question</th>
<th>Ave. Rating</th>
</thead>
<tbody>
<?php 
    foreach($result as $row)
    {
    	?>
    	<tr>
    	<td><?php echo $row['question_id']; ?></td>
    	<td><?php echo $row['question']; ?></td>
    	<td><?php echo Yii::app()->numberFormatter->format("###.00", $row['aveRating']);?></td>
    	</tr>
 <?php 
    }
?>
</tbody>
</table>



<?php $this->endWidget(); ?>


<?php 
$box = $this->beginWidget ( 'bootstrap.widgets.TbBox', array (
		'title' => 'Comments [ '. $period->sem . ' SEM SY ' . $period->sy .'  ]',
		'headerIcon' => 'icon-edit',
		// when displaying a table, if we include bootstrap-widget-table class
		// the table will be 0-padding to the box
		'htmlOptions' => array (
		//'class' => 'bootstrap-widget-table' 
		),
		
		
)
 );
?>



<table class="table table-hover fixed">
<thead>
<th>No.</th>
<th>Date</th>
<th>Comment</th>

</thead>
<tbody>
<?php 
$ctr=0;
    foreach($comments as $row)
    {
    	?>
    	<tr>
    	<td><?php echo ++$ctr; ?></td>
    	<td><?php echo $row['date']; ?></td>
    	<td><?php echo $row['comments']; ?></td>
    	</tr>
 <?php 
    }
?>
</tbody>
</table>



<?php $this->endWidget(); ?>
