<?php

class DefaultController extends Controller
{
    public $layout = '/layouts/column2';
    
    public function filters() {
    	return array(
    			'accessControl', // perform access control for CRUD operations
    	);
    }
    
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
    	return array(
    			array('allow', // allow all users to perform 'index' and 'view' actions
    					'actions' => array(
    							'index','result','peerResult'
    					),
    					'roles' => array('user',),
    			),
    			 
    			array('deny', // deny all users
    					'users' => array('*'),
    			),
    	);
    }
    
    
	
	public function actionIndex()
	{
		
		if (isset($_GET['load'])){
			//load peers in the department
			
			
		}
		
		
		if (isset($_GET['id']))
		  $id = $_GET['id'];
		else
	      $id=0;
		
		
		$emp_number = Yii::app()->user->getState('empNumber');
		if ($emp_number == "") $emp_number = 0;
		//get list of employee to evaluate
	
	$sql = "select hs_hr_employee.emp_lastname,
		hs_hr_employee.emp_firstname,
		evaluators_map.emp_to_evaluate,evaluators_map.rating,evaluators_map.emap_id,
evaluators_map.evaluation_type,evaluation_type.title ,evaluation_period.sy,evaluation_period.sem
from evaluators_map
join hs_hr_employee on evaluators_map.emp_to_evaluate = hs_hr_employee.emp_number
join evaluation_type on evaluators_map.evaluation_type = evaluation_type.etype_id
join evaluation_period on evaluation_period.id = $id
where evaluation_period_id= $id
and evaluators_map.employee_id = $emp_number 

order by evaluation_type.title";

	
		$result = Yii::app()->db->createCommand($sql)->query();
		
		
		$this->render('index',array('id'=>$id,'result'=>$result));
		
	}
	
	
	
	public function actionResult()
	{
		
		if (isset($_GET['id']))
			$id = $_GET['id'];
		else
			$id=0;
		
		
		$emp_number = Yii::app()->user->getState('empNumber');
		if ($emp_number == "") $emp_number = 0;
		//get list of evaluation result
		$sql ="select evaluation_type,evaluation_type.title, avg(rating) as average, sum(if(evaluators_map.rating is not null,1,0))  as total
		from evaluators_map 
		join evaluation_type on evaluators_map.evaluation_type = evaluation_type.etype_id
		where evaluators_map.evaluation_period_id  = $id
		and  evaluators_map.emp_to_evaluate = $emp_number
		group by evaluation_type
		order by evaluation_type.title";
	
		
		$result = Yii::app()->db->createCommand($sql)->query();
		
		
		$this->render('result',array('id'=>$id,'result'=>$result));
		
	}
	
	public function actionPeerResult(){

		if (isset($_GET['id']))
			$id = $_GET['id'];
		else
			$id=0;
		$emp_number = Yii::app()->user->getState('empNumber');
		if ($emp_number == "") $emp_number = 0;
		
		$sql = "select question_id,question,avg(peerEvaluation_details.rating) as aveRating from evaluators_map
				join peerEvaluation_details on evaluators_map.emap_id = peerEvaluation_details.emap_id
				join peerQuestion on peerEvaluation_details.question_id = peerQuestion.pq_id
				where emp_to_evaluate =  $emp_number
				and evaluation_type=1
				and evaluation_period_id= $id
				group by question_id";
		
		$result = Yii::app()->db->createCommand($sql)->query();

		$sql = "select date,comments from evaluators_map
				join peerEvaluation on evaluators_map.emap_id = peerEvaluation.emap_id
				where emp_to_evaluate =$emp_number
				and evaluation_type=1
				and evaluation_period_id=$id
				and comments != ''";
		$comments = Yii::app()->db->createCommand($sql)->query();
		
		$this->render('peer_result',array('id'=>$id,'result'=>$result,'comments'=>$comments));
		
	}
	
	public function actionFacultyByDeanResult(){
	
		if (isset($_GET['id']))
			$id = $_GET['id'];
		else
			$id=0;
		$emp_number = Yii::app()->user->getState('empNumber');
		if ($emp_number == "") $emp_number = 0;
	
		$sql = "select question_id,question,avg(peerEvaluation_details.rating) as aveRating from evaluators_map
		join peerEvaluation_details on evaluators_map.emap_id = peerEvaluation_details.emap_id
		join peerQuestion on peerEvaluation_details.question_id = peerQuestion.pq_id
		where emp_to_evaluate =  $emp_number
		and evaluation_type=1
		and evaluation_period_id= $id
		group by question_id";
	
		$result = Yii::app()->db->createCommand($sql)->query();
	
		$sql = "select date,comments from evaluators_map
		join peerEvaluation on evaluators_map.emap_id = peerEvaluation.emap_id
		where emp_to_evaluate =$emp_number
		and evaluation_type=1
		and evaluation_period_id=$id
		and comments != ''";
		$comments = Yii::app()->db->createCommand($sql)->query();
	
		$this->render('peer_result',array('id'=>$id,'result'=>$result,'comments'=>$comments));
	
	}
	
}