<?php
class Builder extends CFormModel{
	public $e_period;
	public $e_type;
	public $e_evaluator;
	public $e_toEvaluate;
	
	public function attributeLabels()
	{
		return array(
				'e_period' => 'Choose Evaluation Period',
				'e_type'=> 'Choose Evaluation Tool',
		);
	}
	
}
?>