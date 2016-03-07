<?php
$this->breadcrumbs=array(
	'Evaluation Period',
);?>


<div>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
	$this->widget('bootstrap.widgets.TbGridView', array(
		'id'=>'period-grid',
		'template'=>'{items}',
		'dataProvider'=>$dataProvider,
		'htmlOptions'=>array('class'=>'table table-striped'),
		'columns' => array(
			array('header'=>'No.', 'value'=> '$row+1'),
			'sy',
			array('header'=>'Semester','value'=>'$data["sem"]'),
			array('header'=>'Status','value'=>'$data["status"]'),
			array(
				  'header'=>'Action',
                  'class'=>'CButtonColumn',
                  'template'=>'{delete}{close}{open}',
                  'buttons'=>array(
                  		'close'=>array(
                  			'visible'=>'$data->status =="open"',
                  			'label'=>'Close period',
                  			'imageUrl'=>Yii::app()->request->baseUrl.'/images/p_off.png',
                  			'url'=>'Yii::app()->createUrl("evaluation/EvaluationPeriod/close", array("id"=>$data["id"]))',
			                'options'=>array(
			                	'ajax'=>array(
			                		'type'=>'POST',
			                		'url'=>'js:$(this).attr("href")',
			                		'beforeSend'=>'function(){
			                			return confirm("Are you sure you want to close this period?");
			                		}',
			                		'success'=>'function(data,textStatus, XMLHttpRequest){
			                			$("#period-grid").yiiGridView.update("period-grid");
			                		}'
			                	)
			                )
                  		), 

                  		'open'=>array(
                  			'visible'=>'$data->status =="closed"',
                  			'label'=>'Open period',
                  			'imageUrl'=>Yii::app()->request->baseUrl.'/images/p_on.png',
                  			'url'=>'Yii::app()->createUrl("evaluation/EvaluationPeriod/open", array("id"=>$data["id"]))',
                  			'options'=>array(
			                	'ajax'=>array(
			                		'type'=>'POST',
			                		'url'=>'js:$(this).attr("href")',
			                		
			                		'success'=>'function(data,textStatus, XMLHttpRequest){
			                			$("#period-grid").yiiGridView.update("period-grid");
			                		}'
			                	)
			                )
                  		)
                  	),
                  
            )
		)
	))


?>
</div>











