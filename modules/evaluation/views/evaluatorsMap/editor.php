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
   $this->renderPartial('_options_editor',array(
 'period'=>$period,
 'selected_type'=>$selected_type,));
?>


<table class="table table-hover fixed " id='emp-table'>

	<thead>
		<th>#</th>
		<th>Department ID</th>
		<th>Department</th>
		
		<th>Action</th>


	</thead>
	<tbody>
              <?php 
               $ctr = 0;
              $trow = 1;
              $group = ""; 
     
      	foreach($result as $row)
      	{
               
      		
      		$link =  CHtml::ajaxLink(
      				"Generate",
      				Yii::app()->createUrl( 'evaluation/evaluatorsMap/generate' ),
      				array( // ajaxOptions
      						'type' => 'POST',
      						'beforeSend' => "function( request )
								                     {
								                       // Set up any pre-sending stuff like initializing progress indicators
								                     }",
      						'success' => "function( data )
								                  {
      						                  var id = '#' + data;
      					                 
                                                          alert(data);
								                    
								                  }",
      						'data' => array( 'etype' => $selected_type,'dept_id'=>$row['id'],'period'=>$period )
      				)
      					
      		);
      		?>
      		
      		<tr>
				<td><?php echo ++$ctr;?></td>
				<td><?php echo $row['id'];?></td>
				<td><?php echo $row['name'];?></td>
				
				<td><?php echo $link;?></td>
		    </tr>
      		
  <?php      		
     	}
      	
      	?>
             </tbody>


</table>
