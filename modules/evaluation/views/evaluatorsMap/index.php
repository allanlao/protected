<?php
/* @var $this DefaultController */

 $this->breadcrumbs=array(
	$this->module->id,
); 
?>
<?php $this->widget('bootstrap.widgets.TbAlert', array(
		'block'=>true, // display a larger alert block?
		'fade'=>true, // use transitions?
		'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
		
    )); 
?>
<?php 
	$this->renderPartial('_options',array('selected_period'=>$selected_period,
'selected_emp'=>$selected_emp,
'selected_type'=>$selected_type,
'selected_ratee'=>$selected_ratee,
));
	
?>		

<table class="table table-hover fixed " id='emp-table'>
	
	<thead>
		<th>#</th>	
		<th>Employee Name</th>
		<th>Rating</th>
		<th>Action</th>
	

	</thead>
	<tbody>
              <?php 
               $ctr = 0;
              $trow = 1;
              $group = ""; 
     
      	foreach($result as $row)
      	{
      		
      	  //if company changes add a new header row
      		if ($group != $row['title'])
      		{
      			$group = $row['title'];
      			
      		echo "<tr>
				  <td colspan='11' style='background-color:beige'>".$group."</td>
				  </tr>";	
      		       ++$trow;
      		}
      	   
      		$link =  CHtml::ajaxLink(
								  "Delete",
								  Yii::app()->createUrl( 'evaluation/evaluatorsMap/delete' ),
								  array( // ajaxOptions
								    'type' => 'POST',
								    'beforeSend' => "function( request )
								                     {
								                       // Set up any pre-sending stuff like initializing progress indicators
								                     }",
								    'success' => "function( data )
								                  {
								                    // delete the row
								  	            if (data == '500')
								  		         {
								  		           alert('Cannot delete employee with existing evaluation!');
      	                                         }else
								  		         {
								                //  document.getElementById('emp-table').deleteRow(data);
								  			var row = document.getElementById(data);
												row.parentNode.removeChild(row); 
											     } 
								                  }",
								    'data' => array( 'emap_id' => $row['emap_id'],'trow'=>$trow )
								  )
								 
								);
      		
      		++$trow;
      		?>
            <tr id="<?php echo $row['emap_id']?>">
			<td><?php echo ++$ctr;?></td>
			
			<td><?php echo $row['emp_lastname'] . ', ' . $row['emp_firstname'];?></td>
			<td  id="<?php echo 'rating'. $row['emap_id']?>"><?php echo $row['rating'];?></td>
			<td  ><?php echo $link;?></td>
			
		    </tr>
          <?php 
      	
      	    }
          ?> 	
             </tbody>


</table>
