<?php
$this->breadcrumbs = array (
		'Leaves' => array (
				'list' 
		),
		'Summary' 
);

?>

<?php  $this->renderPartial('_sy',array('sy'=>$sy));?>

<?php

$box = $this->beginWidget ( 'bootstrap.widgets.TbBox', array (
		'title' => 'Summary of Leaves',
		'headerIcon' => 'icon-leaf',
		// when displaying a table, if we include bootstra-widget-table class
		// the table will be 0-padding to the box
		'htmlOptions' => array (
			//	'class' => 'bootstrap-widget-table' 
		),
		
		/* 'headerButtons' => array (
				array (
						'class' => 'bootstrap.widgets.TbButton',
						'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
						'label' => 'Print',
						'url' => array (
								'report/admin' 
						),
						'size' => 'small' 
				)
				 
		)  */
)
 ); 
?>

<table class="table table-hover fixed">
	<caption>
		<h3>Summary of Leaves for SY <?php echo $sy;?></h3>
		<h5 style="color:red;">(Some leaves filed before May 31 were counted for the next SY because they have chosen diff SY during filing)</h5>
		<h5 style="color:red;">(For now please check leave details ifthere is discrepancy)</h5>
	</caption>

	<tbody>
	             
	                  <?php 
	                  $crow = "";
	                  foreach ($result as $row)
	                  {
	                  	
	                  	if($crow != $row['shortname']){
							$crow =  $row['shortname'];
	                  		?>
	                  		
	                  		<tr>
	                  		<td colspan="10"><h3><?php echo $crow;?></h3></td>
	                  		</tr>
	                  		
	                  		<tr>
	                  		<th>Name</th>
							<th>VLCredit</th>
							<th>VSCredit</th>
							<th>VLP</th>
							<th>SLP</th>
							<th>ELP</th>
							<th>VL</th>
							<th>SL</th>
							<th>ML</th>
							<th>PL</th>
	                  		</tr>
	                  		<?php 
	                  	}
	                  echo	"<tr>";
	                  
	                   $ml = $row['ml'] + $row['mlc'];
	                 
                       ?>
	                  	 
	                  		<td><?php echo $row['emp_lastname'] . ", ".$row['emp_firstname'];?></td>
	                  		<td><?php echo $row['vlc'];?></td>
	                  		<td><?php echo $row['slc'];?></td>
	                  		<td><?php echo $row['vlp'];?></td>
	                  		<td><?php echo $row['slp'];?></td>
	                  		<td><?php echo $row['elp'];?></td>
	                  		<td><?php echo $row['vl'];?></td>
	                  		<td><?php echo $row['sl'];?></td>
	                  		<td><?php echo $ml;?></td>
	                  		<td><?php echo $row['pl'];?></td>
	                  		
	                  		<?php 
	                  
	                  echo	"</tr>";
	                  }
	                  	?>					
						
		
					</tbody>


</table>


<?php $this->endWidget(); ?>




