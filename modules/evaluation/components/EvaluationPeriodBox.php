<?php
 class EvaluationPeriodBox extends CWidget
 {
 	public $dataProvider;
 	
 	public function init()
 	{
 		 		
 		$this->dataProvider = EvaluationPeriod::model()->findAll(array(
                               'condition'=>'status=:status',
   							 'params'=>array(':status'=>'open'),
                              'order' => 'sy',
 				
                        ));
 	}
 	
 
 	
 	
 	public function run()
 	{
 		$this->render('eval_period', array('dataProvider'=>$this->dataProvider));
 	}
 	
 }
?>