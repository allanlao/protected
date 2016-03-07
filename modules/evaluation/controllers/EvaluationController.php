<?php

class EvaluationController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '/layouts/column1';
 
    /**
     * @return array action filters
     */
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
                		'index', 
                		'view', 
                		'peerReset', 
                		'peerEvaluation', 
                		'headBySubordinate',
                		'headBySubordinateReset' ,
                		'facultyByHead', 
                		'facultyByHeadReset',
                		'staffByHead', 
                		'staffByHeadReset',
                		'result', 
                		'resetEval',
                		'contractual',
                		'contractualReset',
                		'headevaluation',
                		'headevaluationReset',
                		'facultyByDean',
                		'facultyByDeanReset',
                		
                		),
                'roles' => array('user',),
            ),
           
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    
    public function actionPeerReset($emap_id,$eperiod_id)
    {
    	 $empNumber = Yii::app()->user->getState('empNumber');
    	 //reset evalutors map;	
    	 EvaluatorsMap::model()->updateByPk($emap_id,array('rating'=>null));
    	 
    	 //delete peer evaluation data
    	 //we need empnumber/evaluatedby/semand sy
  	   $sql ="delete from peerEvaluation
            where emap_id = '" .$emap_id ."'"; 
    	 
  	 $result = Yii::app()->db->createCommand($sql)->query();
   	 $this->redirect(array('default/index&id='.$eperiod_id));
    
    }
    
    
    
    
    public function actionPeerEvaluation($emap_id) {
      
    	$emap = EvaluatorsMap::model()->findByPk($emap_id);
        $empNumber = Yii::app()->user->getState('empNumber');
        $answer = null;
        $comments = null;
     
        
        if (isset($_POST['answer'])) {
        	$answer = $_POST['answer'];
        	$comments = $_POST['comments'];
        	//get total number of questions
        	$total_q = count(PeerQuestion::model()->findAll());
        	//get total answer question
        	$total_ans = count($_POST['answer']);
        	
        	
        	if ($total_ans < $total_q)
        	{
        		Yii::app()->user->setFlash('error', 'Incomplete Answer');
        	   $this->render('peer_form', array('emap_id' => $emap_id,'ratee'=>$emap->emp_to_evaluate,
            	            'answer'=>$answer,'comments'=>$comments));
        		Yii::app()->end();
        		
        	}
        	
            $model1 = new PeerEvaluation();
            $model1->emap_id = $emap_id;
            $model1->total = 0;
            $model1->date = date('Y-m-d');
            $model1->comments = $_POST['comments'];
            if ($model1->save()) {
                
                $count = 0;
                $total = 0;
                foreach ($_POST['answer'] as $key => $value) {
                    $model2 = new PeerEvaluationDetails();
                    $count++;
                 
                    $model2->ped_id = uniqid();
                    $model2->emap_id =  $_POST['emap_id'];
                    $model2->question_id = $key;
                    $model2->rating = $value;
                    $total+=$value;
                    $model2->save();
                }
                $ave = $total / $count;
                $model1->total = sprintf("%.2f", $ave);

                //    var_dump($model1); die();
                $model1->save();
                
                //update evaluators map too
                EvaluatorsMap::model()->updateByPk($emap_id,array('rating'=>$ave));
                
                Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have successfully evaluated your peer');
            } else {
				
                Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> There was an error saving the result.');
            }
           $this->redirect(array('default/index&id='.$emap->evaluation_period_id));
        }

        $isDone = PeerEvaluation::model()->findByPk($emap_id);
        if ($isDone) {
            Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> You are attempting to re-evaluate your peer.');
            $this->redirect(array('default/index&id='.$emap->evaluation_period_id));
        } else {
            //  echo $ratee; die();
            $this->render('peer_form', array('emap_id' => $emap_id,'ratee'=>$emap->emp_to_evaluate,
            		
            'answer'=>$answer,'comments'=>$comments));
        }
    }

    public function actionHeadBySubordinateReset($emap_id,$eperiod_id)
    {
    	 $empNumber = Yii::app()->user->getState('empNumber');
    	 //reset evalutors map;	
    	 EvaluatorsMap::model()->updateByPk($emap_id,array('rating'=>null));
    	 
    	 //delete peer evaluation data
    	 //we need empnumber/evaluatedby/semand sy
  	   $sql ="delete from headBySubordinateEvaluation
            where emap_id = '" .$emap_id ."'"; 
    	 
  	 $result = Yii::app()->db->createCommand($sql)->query();
   	 $this->redirect(array('default/index&id='.$eperiod_id));
    
    }
    

    public function actionFacultyByHeadReset($emap_id,$eperiod_id)
    {
    	$empNumber = Yii::app()->user->getState('empNumber');
    	//reset evalutors map;
    	EvaluatorsMap::model()->updateByPk($emap_id,array('rating'=>null));
    
    	//delete peer evaluation data
    	//we need empnumber/evaluatedby/semand sy
    	$sql ="delete from facultyByHeadEvaluation
            where emap_id = '" .$emap_id ."'";
    	
    	$result = Yii::app()->db->createCommand($sql)->query();
    	$this->redirect(array('default/index&id='.$eperiod_id));
    
    }
    
    public function actionFacultyByDeanReset($emap_id,$eperiod_id)
    {
    	$empNumber = Yii::app()->user->getState('empNumber');
    	//reset evalutors map;
    	EvaluatorsMap::model()->updateByPk($emap_id,array('rating'=>null));
    
    	//delete peer evaluation data
    	//we need empnumber/evaluatedby/semand sy
    	$sql ="delete from facultyByDeanEvaluation
            where emap_id = '" .$emap_id ."'";
    	 
    	$result = Yii::app()->db->createCommand($sql)->query();
    	$this->redirect(array('default/index&id='.$eperiod_id));
    
    }
    
    public function actionHeadBySubordinate($emap_id) {
    	$emap = EvaluatorsMap::model()->findByPk($emap_id);
        $empNumber = Yii::app()->user->getState('empNumber');
        $answer = null;
        $comments = null;
     
        
        if (isset($_POST['answer'])) {
        	
        	$answer = $_POST['answer'];
        	$comments = $_POST['comments'];
        	//get total number of questions
        	$total_q = count(HeadBySubordinateQuestion::model()->findAll());
        	//get total answer question
        	$total_ans = count($_POST['answer'],1);
        	 
        	
        	if ($total_ans < $total_q)
        	{
        	
        		$model = HeadBySubordinateQuestionCategory::model()->findAll();
        		  $this->render('headBySubordinate_form', array('emap_id' => $emap_id,'ratee'=>$emap->emp_to_evaluate,
            	            'answer'=>$answer,'comments'=>$comments));
        		Yii::app()->end();
        	
        	}
        	
        	
        	
            $model1 = new HeadBySubordinateEvaluation();
         
            //Save evaluation details
            $model1->emap_id = $emap_id;
            $model1->total = 0;
            $model1->date = date('Y-m-d');
            $model1->comments = $_POST['comments'];

            $tA = 0;
            $tB = 0;

          
            if ($model1->save()) {      //Save details
            	
            	
                $percentage = $_POST['percentage'];
                $grandtotal = 0;

                foreach ($_POST['answer'] as $i => $value) {
                    $questions = $value;
                    $total = 0;
                    $count = 0;
                    $t = 0;

                    foreach ($questions as $key => $r) {
                        $model2 = new HeadBySubordinateEvaluationDetails();
                        $count++;
                       $model2->ped_id = uniqid();
                    $model2->emap_id =  $_POST['emap_id'];
                    $model2->question_id = $key;
                    $model2->rating = $r;
                        $model2->save();

                        if ($key > 0 && $key < 4)
                            $tA+=$r;
                        elseif ($key > 3 && $key < 8)
                            $tB+=$r;
                        elseif ($key > 7)
                            $total+=$r;
                    }
                    $subtotal = ($total / $count) * ($percentage[$i] / 100);
                    $grandtotal+=$subtotal;
                }
                $tA_T = ($tA / 3) * 0.3;
                $tB_T = ($tB / 4) * 0.15;
                $grandtotal+=($tA_T + $tB_T);
                $model1->total = sprintf("%.3f", $grandtotal);
                $model1->save();
                
                //update evaluators map too
                EvaluatorsMap::model()->updateByPk($emap_id,array('rating'=>$grandtotal));
                
                Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have successfully evaluated your Department Head');
            } else {
                Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> There was an error saving the result.');
         		
            }
           $this->redirect(array('default/index&id='.$emap->evaluation_period_id));
        }
          $isDone = HeadBySubordinateEvaluation::model()->findByPk($emap_id);
        if ($isDone) {
            Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> You are attempting to re-evaluate your department head.');
               $this->redirect(array('default/index&id='.$emap->evaluation_period_id));
        } else {
            $model = HeadBySubordinateQuestionCategory::model()->findAll();
            $this->render('headBySubordinate_form', array('emap_id' => $emap_id,'ratee'=>$emap->emp_to_evaluate,
            	            'answer'=>$answer,'comments'=>$comments));
        }
    }

    
    
    
    public function actionFacultyByDean($emap_id) {
    	$emap = EvaluatorsMap::model()->findByPk($emap_id);
    	$empNumber = Yii::app()->user->getState('empNumber');
    	$answer = null;
    	$comments = null;
    	
    	$p[1]= .10;
    	$p[2]= .30;
    	$p[3]= .15;
    	$p[4]= .10;
    	$p[5]= .20;
    	$p[6]= .05;
    	$p[7]= .05;
    	$p[8]= .05;
    	
    
    
    	if (isset($_POST['q'])) {
    		 
    		$answer = $_POST['q'];
    		$comments = $_POST['comments'];
    		//get total number of questions
    	 
    		if (count($answer,1) < 52)
    		{
    			$this->render('facultyByDean_form', array('emap_id' => $emap_id,'ratee'=>$emap->emp_to_evaluate,
    					'answer'=>$answer,'comments'=>$comments));
    			Yii::app()->end();
    			 
    		}
    		$model1 = new FacultyByDeanEvaluation();
    		$model1->emap_id = $emap_id;
    		$model1->total = 0;
    		$model1->date = date('Y-m-d');
    		$model1->comments = $_POST['comments'];
    
    		if ($model1->save()) {      //Save details
    			$avg = 0;
    			$total = 0;
    			
    			foreach ($answer as $key => $value) {
    				$subtotal=0;
    				$count = 0;
    				foreach($value as $qid=>$rating)
    				{
	    				$model2 = new FacultyByDeanEvaluationDetails();
	    
	    				$model2->ped_id = uniqid();
	    				$model2->emap_id =   $emap_id;
	    				$model2->question_id = $key.'-'.$qid ;
	    				$model2->rating = $rating;
	    
	    				 
	    				$model2->save();
	    
	    				$count++;  //count number of items
	    				$subtotal+=$rating;   //get running sum
	    			   
	    			
    				}
    			
    				$total += ($subtotal / $count) * $p[$key];
    				
    			}
    			
    			
    			
    			$model1->total = $total;
    			$model1->save();
    
    			//update evaluators map too
    			EvaluatorsMap::model()->updateByPk($emap_id,array('rating'=>$total));
    
    
    			Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have successfully evaluated your faculty.');
    		}
    		$this->redirect(array('default/index&id='.$emap->evaluation_period_id));
    	}
    	$isDone = FacultyByHeadEvaluation::model()->findByPk($emap_id);
    	if ($isDone) {
    		Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> You are attempting to re-evaluate your faculty.');
    		$this->redirect(array('default/index&id='.$emap->evaluation_period_id));
    	} else {
    		$this->render('facultyByDean_form', array('emap_id' => $emap_id,'ratee'=>$emap->emp_to_evaluate,
    				'answer'=>$answer,'comments'=>$comments));
    		echo $isDone;
    	}
    }
    
    public function actionFacultyByHead($emap_id) {
    $emap = EvaluatorsMap::model()->findByPk($emap_id);
    $empNumber = Yii::app()->user->getState('empNumber');
    	$answer = null;
    	$comments = null;
        
        if (isset($_POST['answer'])) {
        	
        	$answer = $_POST['answer'];
        	$comments = $_POST['comments'];
        	//get total number of questions
        	$total_q = count(FacultyByHeadQuestion::model()->findAll());
        	//get total answer question
        	$total_ans = count($_POST['answer'],1);
        	 
        	
        	if ($total_ans < $total_q)
        	{
        		$this->render('facultyByHead_form', array('emap_id' => $emap_id,'ratee'=>$emap->emp_to_evaluate,
        		              'answer'=>$answer,'comments'=>$comments));
        		Yii::app()->end();
        	
        	}
            $model1 = new FacultyByHeadEvaluation;
            $model1->emap_id = $emap_id;
            $model1->total = 0;
            $model1->date = date('Y-m-d');
            $model1->comments = $_POST['comments'];

            if ($model1->save()) {      //Save details
                $avg = 0;
                $total = 0;
                $count = 0;
                foreach ($_POST['answer'] as $qid => $val) {
                    $model2 = new FacultyByHeadEvaluationDetails;
                    
                    $model2->ped_id = uniqid();
                    $model2->emap_id =  $_POST['emap_id'];
                    $model2->question_id = $qid;
                    $model2->rating = $val;
                    
                   
                    $model2->save();

                    $count++;  //count number of items
                    $total+=$val;   //get running sum
                }
                $avg+=$total / $count;
                $model1->total = $avg;
                $model1->save();
                
                //update evaluators map too
                EvaluatorsMap::model()->updateByPk($emap_id,array('rating'=>$avg));
                
                
                Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have successfully evaluated your faculty.');
            }
            $this->redirect(array('default/index&id='.$emap->evaluation_period_id));
        }
        $isDone = FacultyByHeadEvaluation::model()->findByPk($emap_id);
        if ($isDone) {
            Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> You are attempting to re-evaluate your faculty.');
            $this->redirect(array('default/index&id='.$emap->evaluation_period_id));
        } else {
         	$this->render('facultyByHead_form', array('emap_id' => $emap_id,'ratee'=>$emap->emp_to_evaluate,
        		              'answer'=>$answer,'comments'=>$comments));
            echo $isDone;
        }
    }
    
    public function actionStaffByHeadReset($emap_id,$eperiod_id)
    {
    	$empNumber = Yii::app()->user->getState('empNumber');
    	//reset evalutors map;
    	EvaluatorsMap::model()->updateByPk($emap_id,array('rating'=>null));
    
    	//delete peer evaluation data
    	//we need empnumber/evaluatedby/semand sy
    	$sql ="delete from staffByHeadEvaluation
            where emap_id = '" .$emap_id ."'";
    	
    	$result = Yii::app()->db->createCommand($sql)->query();
    	$this->redirect(array('default/index&id='.$eperiod_id));
    
    
    }

    public function actionStaffByHead($emap_id) {
    	
        $emap = EvaluatorsMap::model()->findByPk($emap_id);
        $empNumber = Yii::app()->user->getState('empNumber');
        $answer = null;
        $comments = null;
       
        if (isset($_POST['answer'])) {
        	
        	$answer = $_POST['answer'];
        	$comments = $_POST['comments'];
        	
        	//var_dump($answer); die();
        	//get total number of questions
        	$total_q = count(StaffByHeadQuestion::model()->findAll());
        	//get total answer question
        	$total_ans = count($_POST['answer']);
        	 
        	 
        	if ($total_ans < $total_q)
        	{
        		Yii::app()->user->setFlash('error', 'Incomplete Answer');
        		        		
        		$this->render('staffByHead_form', array('emap_id' => $emap_id,'ratee'=>$emap->emp_to_evaluate,
        				'answer'=>$answer,'comments'=>$comments));
        		Yii::app()->end();
        	
        	}
        	
            $model = new StaffByHeadEvaluation();
         
            //Save evaluation details
            $model->emap_id = $emap_id;
            $model->total = 0;
            $model->date = date('Y-m-d');
            $model->comments = $_POST['comments'];
           
            if ($model->save()) {
                $grandtotal = 0;
                $pc = $_POST['percentage'];
                foreach ($_POST['answer'] as $key => $value) {
                    $model1 = new StaffByHeadEvaluationDetails();
                    
                    $model1->ped_id = uniqid();
                    $model1->emap_id =  $_POST['emap_id'];
                    $model1->question_id = $key;
                    $model1->rating = $value;
                    
                    $model1->save();
                    $total = $value * ($pc[$key] / 100);
                    $grandtotal+=$total;
                }
                $model->total = sprintf("%.2f", $grandtotal);
                $model->save();
                
                //update evaluators map too
                EvaluatorsMap::model()->updateByPk($emap_id,array('rating'=>$grandtotal));
                
                Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have successfully evaluated the staff.');
            } else {
                Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> There was an error saving the result.');
            }
               $this->redirect(array('default/index&id='.$emap->evaluation_period_id));
        }
         $isDone = StaffByHeadEvaluation::model()->findByPk($emap_id);
        if ($isDone) {
            Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> You are attempting to re-evaluate your staff.');
                 $this->redirect(array('default/index&id='.$emap->evaluation_period_id));
        } else {
          $this->render('staffByHead_form', array('emap_id' => $emap_id,'ratee'=>$emap->emp_to_evaluate,
        				'answer'=>$answer,'comments'=>$comments));
        }
    }

    public function actionContractualReset($emap_id,$eperiod_id)
    {
    	$empNumber = Yii::app()->user->getState('empNumber');
    	 //reset evalutors map;	
    	 EvaluatorsMap::model()->updateByPk($emap_id,array('rating'=>null));
    	 
    	 //delete peer evaluation data
    	 //we need empnumber/evaluatedby/semand sy
  	     $sql ="delete from contractualByHeadEvaluation
              where emap_id = '" .$emap_id ."'"; 
    	 
  	 	 $result = Yii::app()->db->createCommand($sql)->query();
   	 	 $this->redirect(array('default/index&id='.$eperiod_id));
    
    }
    
    public function actionContractual($emap_id) {
    	
   		$emap = EvaluatorsMap::model()->findByPk($emap_id);
        $empNumber = Yii::app()->user->getState('empNumber');
        $answer = null;
        $comments = null;
        
       
        if (isset($_POST['answer'])) {
        	
        	$answer = $_POST['answer'];
        	$comments = $_POST['comments'];
        	
        	//var_dump($answer); die();
        	//get total number of questions
        	$total_q = count(ContractualByHeadQuestion::model()->findAll());
        	//get total answer question
        	$total_ans = count($_POST['answer']);
        	 
        	 
        	if ($total_ans < $total_q)
        	{
        		Yii::app()->user->setFlash('error', 'Incomplete Answer');
        		   $this->render('contractual_form', array('emap_id' => $emap_id,'ratee'=>$emap->emp_to_evaluate,
            	            'answer'=>$answer,'comments'=>$comments));
        		Yii::app()->end();
        	
        	}
        	
            $model = new ContractualByHeadEvaluation();
        
            $model->emap_id = $emap_id;
            $model->total = 0;
            $model->date = date('Y-m-d');
            $model->comments = $_POST['comments'];
            if ($model->save()) {
                $count = 0;
                $total = 0;
                foreach ($_POST['answer'] as $key => $value) {
                    $model1 = new ContractualByHeadEvaluationDetails();
                    $count++;
                    $model1->ped_id = uniqid();
                    $model1->emap_id =  $_POST['emap_id'];
                    $model1->question_id = $key;
                    $model1->rating = $value;
                    $total+=$value;
                    echo $key . "-->" . $value . "<br>";
                    $model1->save();
                }
                $ave = $total / $count;
                $model->total = sprintf("%.2f", $ave);
                //echo sprintf("%.2f", $ave);
                $model->save();
                EvaluatorsMap::model()->updateByPk($emap_id,array('rating'=>$ave));
                 
                Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have successfully evaluated the staff');
            }
            $this->redirect(array('default/index&id='.$emap->evaluation_period_id));
        }

        $isDone = ContractualByHeadEvaluation::model()->findByPk($emap_id);
        if ($isDone) {
            Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> You are attempting to re-evaluate your staff.');
             $this->redirect(array('default/index&id='.$emap->evaluation_period_id));
        } else {
        	
        	 $this->render('contractual_form', array('emap_id' => $emap_id,'ratee'=>$emap->emp_to_evaluate,
            	            'answer'=>$answer,'comments'=>$comments));
        	}
        	
       
        
    }

    public function actionResult() {
        $empNumber = Yii::app()->user->getState('empNumber');
        $emp = Employee::model()->findByPk($empNumber); //get attributes
        $position = Position::model()->findByPk($emp->emp_position_code); //get position
        $type = $position->position_category;
        $status = $emp->emp_status;

        //Evaluation Period and School Year   
        $period = EvaluationPeriod::model()->findAll(array(
            'select' => 'concat(sy,"|",sem) as sy',
            'distinct' => true,
        ));

        $sylist = CHtml::listData($period, 'sy', 'sy');
        if (!isset($_POST['sy']) && !isset($_GET['sy'])) {
            $this->render('_filter', array('sylist' => $sylist, 'selectedPeriod' => ''));
        } else {
            if (isset($_POST['sy'])) {
                $syterm = explode('|', $_POST['sy']);
                $sy = $syterm[0];
                $sem = $syterm[1];
                $selectedPeriod = $_POST['sy'];
            } else {
                $sy = $_GET['sy'];
                $sem = $_GET['sem'];
                $selectedPeriod = $_GET['sy'] . "|" . $_GET['sem'];
            }



            //Generate dataProvider
            if ($type == 'faculty') {
                $sql = "SELECT  
                peer_evaluators, peer_average, head_evaluators, head_average, stud_evaluators, stud_average 
                FROM 
                (SELECT count(total) as peer_evaluators ,avg(total) as peer_average FROM peer_evaluation WHERE emp_number=$empNumber AND sem='$sem' AND sy='$sy'AND total !=0) AS tbl1,
                (SELECT count(total) as head_evaluators ,avg(total) as head_average FROM facultybhead_evaluation WHERE emp_number=$empNumber AND sem='$sem' AND sy='$sy' AND total !=0) AS tbl2,
                (SELECT count(total) as stud_evaluators ,avg(total) as stud_average FROM facultybstudent_evaluation WHERE emp_number=$empNumber AND sem='$sem' AND sy='$sy' AND total !=0) AS tbl3";
            } elseif ($type == 'head') {
                $sql = "SELECT  
                head_evaluators, head_average, sub_evaluators, sub_average  
                FROM 
                (SELECT count(total) as head_evaluators ,avg(total) as head_average FROM head_evaluation WHERE emp_number=$empNumber AND sem='$sem' AND sy='$sy' AND total !=0) AS tbl1,
                (SELECT count(total) as sub_evaluators ,avg(total) as sub_average FROM headbsubordinate_evaluation WHERE emp_number=$empNumber AND sem='$sem' AND sy='$sy' AND total !=0) AS tbl2";
            } elseif ($type == 'staff') {
                if ($status == 'EST000') {
                    $sql = "SELECT  
                peer_evaluators, peer_average, head_evaluators, head_average
                FROM 
                (SELECT count(total) as peer_evaluators ,avg(total) as peer_average FROM peer_evaluation WHERE emp_number=$empNumber AND sem='$sem' AND sy='$sy' AND total !=0) AS tbl1,
                (SELECT count(total) as head_evaluators ,avg(total) as head_average FROM nonteachingbhead_evaluation WHERE emp_number=$empNumber AND sem='$sem' AND sy='$sy' AND total !=0) AS tbl2";
                } else {
                    $sql = "SELECT  count(total) AS head_evaluators ,avg(total) AS head_average 
                FROM contractualbnonteaching_evaluation
                WHERE emp_number = $empNumber AND sem='$sem' AND sy='$sy' AND total !=0";
                }
            }



            $dataProvider = new CSqlDataProvider($sql, array(
                'pagination' => array(
                    'pageSize' => 100,
                ),
            ));


            //Render View     
            $this->render('result', array(
                'dataProvider' => $dataProvider,
                'type' => $type,
                'status' => $status,
                'sylist' => $sylist,
                'sy' => $sy,
                'sem' => $sem,
                'selectedPeriod' => $selectedPeriod,
            ));
        }
    }
    
    public function actionHeadEvaluationReset($emap_id,$eperiod_id)
    {
    		 $empNumber = Yii::app()->user->getState('empNumber');
    	 //reset evalutors map;	
    	 EvaluatorsMap::model()->updateByPk($emap_id,array('rating'=>null));
    	 
    	 //delete peer evaluation data
    	 //we need empnumber/evaluatedby/semand sy
  	   $sql ="delete from headEvaluation
            where emap_id = '" .$emap_id ."'"; 
    	 
  	 $result = Yii::app()->db->createCommand($sql)->query();
   	 $this->redirect(array('default/index&id='.$eperiod_id));
    
    }

    public function actionHeadEvaluation($emap_id) {
       $emap = EvaluatorsMap::model()->findByPk($emap_id);
        $empNumber = Yii::app()->user->getState('empNumber');
        $answer = null;
        $comments = null;
        
        if (isset($_POST['answer'])) {
        	
        	$answer = $_POST['answer'];
        	$comments = $_POST['comments'];
        	//get total number of questions
        	$total_q = count(HeadQuestion::model()->findAll());
        	//get total answer question
        	$total_ans = count($_POST['answer'],1);
        	 
        	
        	if ($total_ans < $total_q)
        	{
        		  $this->render('headEvaluation_form', array('emap_id' => $emap_id,'ratee'=>$emap->emp_to_evaluate,
            	            'answer'=>$answer,'comments'=>$comments));
        		Yii::app()->end();
        	
        	
        	}
            $model = new HeadEvaluation();
          $model->emap_id = $emap_id;
            $model->total = 0;
            $model->date = date('Y-m-d');
            $model->comments = $_POST['comments'];
            if ($model->save()) {
                $percentage = $_POST['percentage'];
                $grandtotal = 0;
                foreach ($_POST['answer'] as $i => $value) {
                    $questions = $value;
                    $total = 0;
                    $count = 0;
                    foreach ($questions as $key => $r) {
                        $model2 = new HeadEvaluationDetails();
                        $count++;
                        $model2->ped_id = uniqid();
                    $model2->emap_id =  $_POST['emap_id'];
                    $model2->question_id = $key;
                    $model2->rating = $r;
                        $total+=$r;
                        $model2->save();
                    }
                    $subtotal = ($total / $count) * ($percentage[$i] / 100);
                    $grandtotal+=$subtotal;
                }

                //printf("Grandtotal is %.2f", $grandtotal);

                $model->total = sprintf("%.2f", $grandtotal);
                $model->save();
                
                //update evaluators map too
                EvaluatorsMap::model()->updateByPk($emap_id,array('rating'=>$grandtotal));
                 
                Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have successfully evaluated the head.');
            } else {
            	
                Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> There was an error saving the result.');
            }

               $this->redirect(array('default/index&id='.$emap->evaluation_period_id));
        }
        $isDone = HeadEvaluation::model()->findByPk($emap_id);
        if ($isDone) {
            Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> You are attempting to re-evaluate your the department head.');
             $this->redirect(array('default/index&id='.$emap->evaluation_period_id));
        } else {
          $this->render('headEvaluation_form', array('emap_id' => $emap_id,'ratee'=>$emap->emp_to_evaluate,
            	            'answer'=>$answer,'comments'=>$comments));
        }
    }

    public function actionHeadEvaluation2($id) {
        //for non teaching head
        $empNumber = Yii::app()->user->getState('empNumber');
        // $period = EvaluationPeriod::model()->find("status='open'");

        if (isset($_POST['answer'])) {
            $model = new HeadEvaluation();
            $eid = uniqid();
            //Save evaluation details
            $model->he_id = $eid;
            $model->emp_number = $_POST['empno'];
            $model->evaluatedby = $empNumber;
            $model->sem = $this->sem;
            $model->sy = $this->sy;
            $model->date = date('Y-m-d');
            $model->total = 0;
            $model->remarks = $_POST['remarks'];
            $model->remarks = $_POST['remarks'];
            if ($model->save()) {
                $grandtotal = 0;
                $pc = $_POST['percentage'];
                foreach ($_POST['answer'] as $key => $value) {
                    $model1 = new HeadEvaluationDetails();
                    $model1->he_id = $eid;
                    $model1->hed_id = uniqid();
                    $model1->hq_id = $key;
                    $model1->rating = $value;
                    $model1->save();
                    $total = $value * ($pc[$key] / 100);
                    $grandtotal+=$total;
                }
                $model->total = sprintf("%.2f", $grandtotal);
                $model->save();
                Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have successfully evaluated the staff.');
            } else {
                Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> There was an error saving the result.');
            }
            $this->redirect(array('menu&id=7'));
        }

        $isDone = HeadEvaluation::model()->findByAttributes(array('emp_number' => $id, 'evaluatedby' => $empNumber, 'sy' => $this->sy, 'sem' => $this->sem));
        if ($isDone) {
            Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> You are attempting to re-evaluate the department head.');
            $this->redirect(array('menu&id=7'));
        } else {
            $this->render('nonteachingByHead_form', array(
                'emp_number' => $id));
        }
    }

    public function actionResetEval($class = "", $id = "", $eval_id, $sy, $sem) {
        //   $period = EvaluationPeriod::model()->find("status='open'");
        $this->sem = $sem;
        $this->sy = $sy;

        $model = call_user_func(array($class, 'model'));

        if ($model->findByPk($eval_id)->delete())
            $this->redirect(array('menu&id=' . $id . '&sy=' . $this->sy . '&sem=' . $this->sem));
    }

}

