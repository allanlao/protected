<?php

class DefaultController extends Controller {

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
                'actions' => array('index', 'view', 'summary', 'onLeave','print','list'),
                'roles' => array('user'),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('approved','apply','add', 'approval','applyDone','approve','disapprove'),
                'users' => array('@'),
                'roles' => array('user'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete','leaveSummary','createAll','createOne','create'),
                'roles' => array('user'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    public function createLeaveCredits($empNumber, $sy) {
    
    	//check if empNumber/Sy exists
    	// EmpLeaveCredits::model()->find()
    
    
    	$model = new EmpLeaveCredits;
    	$model->leave_credit_id = uniqid();
    	$model->emp_number = $empNumber;
    	$model->leave_allocated_sl = 15;
    	$model->leave_allocated_vl = 15;
    	$model->leave_sy = $sy;
    
    	if ($model->save()) {
    
    	} else {
    
    		print_r($model->getErrors());
    	}
    }
    public function actionCreateAll(){


    	if (isset($_POST['selectedItems'])) {
    		//
    			set_time_limit(1000);
    	
    	
    			$sy = $_POST['leave_sy'];
    	
    			foreach ($_POST['selectedItems'] as $deptCode) {
    	
    					//loop thru every department
    					//and delete all entries
    	
    					$employees = Employee::model()->findAll(array(
    					'condition' => 'emp_department_code = :deptCode and isActive = :isActive',
    					'params' => array(':deptCode' => $deptCode, 'isActive' => 'Y'),
    							));
    	
    							//process all employees
    									$ctr = 0;
    											foreach ($employees as $employee) {
    											//check if leave credit exisiting for the school year
    											if (!EmpLeaveCredits::model()->find('emp_number = :emp_number and leave_sy = :leave_sy', array(':emp_number' => $employee->emp_number, ':leave_sy' => $sy))) {
    											$this->createLeaveCredits($employee->emp_number, $sy);
    											}
    											}
    	
    													unset($employees);
    											}
    	
    													set_time_limit(30);
    												flush();
    											}
    	
    	
    	
    	
    											$model = new EmpLeaveCredits();
    												$dataProvider = new CActiveDataProvider('Department', array(
    												'criteria' => array('order' => 'name'),
    												'pagination' => array(
    														'pageSize' => 50,
    												),
    												));
    												$this->render('create', array(
    														'model' => $model, 'dataProvider' => $dataProvider,
    												));
    }

    public function actionCreateOne() {
    
    	$model = new EmpLeaveCredits();
    
    	if (isset($_POST['EmpLeaveCredits'])) {
    		$model->attributes = $_POST['EmpLeaveCredits'];
    		$model->leave_credit_id = uniqid();
    		if (!EmpLeaveCredits::model()->find('emp_number = :emp_number and leave_sy = :leave_sy', array(':emp_number' => $model->emp_number, ':leave_sy' => $model->leave_sy))) {
    			if ($model->save())
    				Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have added a new leave credit');
    		}else {
    			Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> There was an error saving the record.');
    		}
    	}
    
    	$this->render('createOne', array('model' => $model));
    }
    
    public function actionCreate(){
    	
    		$model = new EmpLeaveCredits;
    		$lastname = "%";
    		$firstname = "%";
    	
    		if (isset($_POST['lastname'])) {
    			$lastname = $_POST['lastname'];
    			$firstname = $_POST['firstname'];
    		}
    	
    		$dataProvider = new CActiveDataProvider('EmpLeaveCredits', array(
    				'criteria' => array(
    						'with' => array('empNumber'),
    						'condition' => 'empNumber.emp_lastname like :lastname and empNumber.emp_firstname like :firstname',
    						'order' => 'leave_sy DESC',
    						'params' => array(':lastname' => $lastname . "%", ':firstname' => $firstname . "%"),
    				),
    				'pagination' => array(
    						'pageSize' => 31,
    				),
    		));
    	
    		$this->render('view', array(
    				'model' => $model,
    				'dataProvider' => $dataProvider, 'lastname' => $lastname,
    				'firstname' => $firstname,
    		));
    
    	
    }
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    
    
    public function actionPrint($id)
    {
    	$this->renderPartial('_printDialog');
    	
    }
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function sendMail($email, $subject, $message, $name) {

        $message = urldecode($message);

        if (isset(Yii::app()->params['hr_email']))
            $from = Yii::app()->params['hr_email'];
        else
            $from = "hr@lorma.edu";


        $headers = "From: {$from}\r\nCc: {$from}";

        if (mail($email, $subject, $message, $headers))
            return true;
        else
            return false;
    }

    public function actionApproval() {
        $this->layout = '//layouts/column1';
        $empNumber = Yii::app()->user->getState('empNumber');
        $model = Employee::model()->findByPk($empNumber);


        //  if (Yii::app()->user->role == "head") { anyone can be an oic

        $dataProvider_head1 = new CActiveDataProvider('EmpLeaves', array(
                    'criteria' => array(
                        'with' => array('empNumber'),
                        'together' => true,
                        'condition' => 'head1=:head and head1_action_date is null',
                        'params' => array(':head' => $empNumber,)
                    ),
                    'pagination' => array(
                        'pageSize' => 31,
                    ),
                ));


        $dataProvider_head2 = new CActiveDataProvider('EmpLeaves', array(
                    'criteria' => array(
                        'with' => array('empNumber'),
                        'together' => true,
                        'condition' => 'head2=:head and head2_action_date is null and
                                            ((head1_action=:action and hr_head_action=:action and clinic_head_action=:action and leave_type=:leave_type and leave_days>1) ||
                                             (head1_action=:action and hr_head_action=:action and  leave_type!=:leave_type) ||
                                             (head1_action=:action and hr_head_action=:action and  leave_type=:leave_type and leave_days<=1) 
                                             )',
                        'params' => array(':head' => $empNumber,
                            ':action' => 'recommended',
                            ':leave_type' => 'slp')
                    ),
                    'pagination' => array(
                        'pageSize' => 300,
                    ),
                ));


        $dataProvider_hr = new CActiveDataProvider('EmpLeaves', array(
                    'criteria' => array(
                        'with' => array('empNumber'),
                        'together' => true,
                        'condition' => 'hr_head=:head and hr_head_action_date is null and
                                            ((head1_action=:action and clinic_head_action=:action and leave_type=:leave_type and leave_days>1) ||
                                             (head1_action=:action and leave_type!=:leave_type) ||
                                             (head1_action=:action and leave_type=:leave_type and leave_days<=1) 
                                             )',
                        'params' => array(':head' => $empNumber,
                            ':action' => 'recommended',
                            ':leave_type' => 'slp')
                    ),
                    'pagination' => array(
                        'pageSize' => 300,
                    ),
                ));


        $dataProvider_clinic = new CActiveDataProvider('EmpLeaves', array(
                    'criteria' => array(
                        //  'with' => array('empNumber'),
                        //  'together' => true,
                        'condition' => '(clinic_head=:head) and (head1_action=:action) and  (clinic_head_action_date is null) and leave_type=:leave_type and leave_days>1',
                        'params' => array(':head' => $empNumber,
                            ':action' => 'Recommended',
                            ':leave_type' => 'slp'),
                    ),
                    'pagination' => array(
                        'pageSize' => 31,
                    ),
                ));

        //    }



        if (Yii::app()->user->role == "head") {
            $this->render('approval', array(
                'dataProvider_head1' => $dataProvider_head1,
                'dataProvider_head2' => $dataProvider_head2,
                'dataProvider_hr' => $dataProvider_hr,
                'dataProvider_clinic' => $dataProvider_clinic,
            ));
        } else {
            $this->render('approval', array(
                'dataProvider_head1' => $dataProvider_head1,
                'dataProvider_hr' => $dataProvider_hr,
                'dataProvider_clinic' => $dataProvider_clinic,
            ));
        }
    }

    public function actionOnLeave() {
        $dataProvider_onLeave = new CActiveDataProvider('EmpLeaves', array(
                    'criteria' => array(
                        'with' => array('empNumber'),
                        'together' => true,
                        'condition' => 't.head2_action=:status',
                        'params' => array(':status' => 'approved')
                    ),
                    'pagination' => array(
                        'pageSize' => 100,
                    ),
                ));

        $this->render('onLeave', array(
            'dataProvider_onLeave' => $dataProvider_onLeave,
        ));
    }

    public function actionSummary() {
        $emp_number = Yii::app()->user->getState('empNumber');
        $model = new EmpLeaves;

        $dataProvider_done = new CActiveDataProvider('EmpLeaves', array(
                    'criteria' => array(
                        'condition' => 'emp_number=:emp_number and 
                                        (head1_action=:status or 
                                         hr_head_action =:status or 
                                         clinic_head_action =:status or
                                         head2_action is not null
                                        )',
                        'params' => array(':emp_number' => $emp_number, ':status' => 'disapproved',)
                    ),
                    'pagination' => array(
                        'pageSize' => 31,
                    ),
                ));

        $dataProvider_credits = new CActiveDataProvider('EmpLeaveCredits', array(
                    'criteria' => array(
                        'condition' => 'emp_number=:emp_number ',
                        'params' => array(':emp_number' => $emp_number)
                    ),
                    'pagination' => array(
                        'pageSize' => 31,
                    ),
                ));

        $dataProvider_pending = new CActiveDataProvider('EmpLeaves', array(
                    'criteria' => array(
                        'condition' => 'emp_number=:emp_number and head2_action_date is null and
                                        head1_action!=:status and hr_head_action !=:status and clinic_head_action !=:status',
                        'params' => array(':emp_number' => $emp_number, ':status' => 'disapproved',)
                    ),
                    'pagination' => array(
                        'pageSize' => 31,
                    ),
                ));

        $this->render('summary', array(
            'model' => $model, 'emp_number' => $emp_number,
            'dataProvider_done' => $dataProvider_done,
            'dataProvider_credits' => $dataProvider_credits,
            'dataProvider_pending' => $dataProvider_pending,
        ));
    }

    
    public function actionAdd() {
    
    	
    	//prepare values for approving heads/oics
    	$model = new EmpLeaves;
    
    	
    
    	// Uncomment the following line if AJAX validation is needed
    	// $this->performAjaxValidation($model);
    
    	if (isset($_POST['EmpLeaves'])) {
    		$model->attributes = $_POST['EmpLeaves'];
    		//$model->emp_number = $emp_number;
    		$model->leave_status = 'Approved';
    		$model->leave_date_filed = date('Y-m-d');
    
    		//generate leave id
    		 $lastRec = EmpLeaves::model()->find(array(
            		'select'=>'leave_id',
            		'condition'=>'length(leave_id)=7',
            		'order'=>'leave_id desc',
            ));
    		if (strlen($lastRec->leave_id) == 7)
    		{
    			$lastId = $lastRec->leave_id;
    		}else
    		{
    			$lastId = date('y') . '-0000';
    		}
    		
    		 
    		$model->leave_id = ++$lastId;
    
    		$avail_vl = EmpLeaveCredits::model()->getVlCredits($model->emp_number, $model->leave_sy);
    		$avail_sl = EmpLeaveCredits::model()->getSlCredits($model->emp_number, $model->leave_sy);
    
    		$leave_desc = $model->typeToStr($model->leave_type);
    
    		$with_credits = 1;
    
    		//chk with leave credits
    		if ($model->leave_type == "vlp" || $model->leave_type == "elp") {
    			if (($avail_vl - $model->leave_days) < 0)
    				$with_credits = 0;
    			else
    				$with_credits = 1;
    		}else if ($model->leave_type == "slp") {
    			//if sick leave and <= 1 day no need for clinic approval
    			if (($avail_sl - $model->leave_days) < 0)
    				$with_credits = 0;
    			else
    				$with_credits = 1;
    		}
    
    
    		if ($with_credits) {
    
    			if ($model->save()) {
    
    
    				//save all dates
    				foreach ($_POST['datesList'] as $val) {
    					$leaveDateModel = new EmpLeavesDetails;
    					$leaveDateModel->leave_id = $model->leave_id;
    					$a = explode(" ", $val);
    
    
    					$leaveDateModel->leave_details_date = $a[0];
    					$leaveDateModel->leave_details_ampm = $a[1];
    					$leaveDateModel->leave_details_id = uniqid();
    
    					if ($leaveDateModel->leave_details_ampm == 'wd')
    						$leaveDateModel->leave_credit = 1.0;
    					else
    						$leaveDateModel->leave_credit = 0.5;
    
    					$leaveDateModel->save();
    				}
    
    			
    			} else {
    				Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> There was an error saving the record.');
    			}
    		} else {
    			Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> You dont have enough leave credits left.');
    		}
    	}
    
     
    	$dataProvider = new CActiveDataProvider('EmpLeaves', array(
            'criteria' => array(
                'condition' => 'leave_status =  :status',
                'params' => array(':status' => 'Approved',),
                'order' => 'leave_date_created DESC',
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    
    
   
    	//  $sy = '2012-2013';
    	$year = date('Y');
    	if (date('m') < '05') {
    		//if May
    		$sy = $year - 1 . '-' . $year;
    	} else {
    		$sy = $year . '-' . ($year + 1);
    	}
    
    
    	$this->render('add', array(
    			'model' => $model,
    			'dataProvider' => $dataProvider,    			
    			'sy' => $sy,
    	));
    }
    
    
    
    
    
    public function actionList()
    {
    	$emp_number = Yii::app()->user->getState('empNumber');
    	$dataProvider_pending = new CActiveDataProvider('EmpLeaves', array(
    			'criteria' => array(
    					'condition' => 'emp_number=:emp_number and leave_status="pending"',
    					'params' => array(':emp_number' => $emp_number, )
    			),
    			'pagination' => array(
    					'pageSize' => 100,
    			),
    	));
    	
    	$dataProvider_approved = new CActiveDataProvider('EmpLeaves', array(
    			'criteria' => array(
    					'condition' => 'emp_number=:emp_number and leave_status!="pending"',
    					'params' => array(':emp_number' => $emp_number, )
    			),
    			'pagination' => array(
    					'pageSize' => 100,
    			),
    	));
    	
    	
    	$this->render('list',array('dataProvider_pending'=>$dataProvider_pending,'dataProvider_approved'=>$dataProvider_approved));
    }
    
    
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionApply() {

//prepare values for approving heads/oics
        $model = new EmpLeaves;
    
        $emp_number = Yii::app()->user->getState('empNumber');
        $emp = Employee::model()->findByPk($emp_number);
      
        
        if (isset($_POST['EmpLeaves'])) {
            $model->attributes = $_POST['EmpLeaves'];
            $model->emp_number = $emp_number;
            $model->leave_status = 'pending';
            $model->leave_date_filed = date('Y-m-d');

            //generate leave id
            $lastRec = EmpLeaves::model()->find(array(
            		'select'=>'leave_id',
            		'condition'=>'length(leave_id)=7',
            		'order'=>'leave_id desc',
            ));
            
            
            if (!is_null($lastRec))
            {
            	$lastId = $lastRec->leave_id;
            }else
            {
            	$lastId = date('y') . '-0000';
            }
           
            $model->leave_id = ++$lastId;

            $avail_vl = EmpLeaveCredits::model()->getVlCredits($emp_number, $model->leave_sy);
            $avail_sl = EmpLeaveCredits::model()->getSlCredits($emp_number, $model->leave_sy);

            $leave_desc = $model->typeToStr($model->leave_type);

            $with_credits = 1;

//chk with leave credits
            if ($model->leave_type == "vlp" || $model->leave_type == "elp") {
                if (($avail_vl - $model->leave_days) < 0)
                    $with_credits = 0;
                else
                    $with_credits = 1;
            }else if ($model->leave_type == "slp") {
                //if sick leave and <= 1 day no need for clinic approval
                if (($avail_sl - $model->leave_days) < 0)
                    $with_credits = 0;
                else
                    $with_credits = 1;
            }


            if ($with_credits) {

                if ($model->save()) {


                    //save all dates
                    foreach ($_POST['datesList'] as $val) {
                        $leaveDateModel = new EmpLeavesDetails;
                        $leaveDateModel->leave_id = $model->leave_id;
                        $a = explode(" ", $val);


                        $leaveDateModel->leave_details_date = $a[0];
                        $leaveDateModel->leave_details_ampm = $a[1];
                        $leaveDateModel->leave_details_id = uniqid();

                        if ($leaveDateModel->leave_details_ampm == 'wd')
                            $leaveDateModel->leave_credit = 1.0;
                        else
                            $leaveDateModel->leave_credit = 0.5;

                        $leaveDateModel->save();
                    }
                   //redirect
                    $this->redirect(array('applyDone', 'leave_id' => $model->leave_id));
                    
                } else {
                    Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> There was an error saving the record.');
                }
            } else {
                Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> You dont have enough leave credits left.');
            }
        }

       

        $dataProvider_pending = new CActiveDataProvider('EmpLeaves', array(
                    'criteria' => array(
                        'condition' => 'emp_number=:emp_number and (leave_status!=:status and leave_status!=:disstatus)',
                        'params' => array(':emp_number' => $emp_number, ':status' => 'approved', ':disstatus' => 'disapproved')
                    ),
                    'pagination' => array(
                        'pageSize' => 100,
                    ),
                ));


  //  $sy = '2012-2013';
        $year = date('Y');
        if (date('m') < '06') {
            //if May
            $sy = $year - 1 . '-' . $year;
        } else {
            $sy = $year . '-' . ($year + 1);
        }

      
        $this->render('apply', array(
            'model' => $model, 'emp_number' => $emp_number,
            'dataProvider_pending' => $dataProvider_pending,
          //  'dataProvider_credits' => $dataProvider_credits,
            'sy' => $sy,
        ));
    }

    public function actionApplyDone($leave_id){
    	
    	$this->render('applyDone',array('leave_id'=>$leave_id));
    	
    }

    public function actionApprove($id)
    {
    
    		$model = $this->loadModel($id);
            $model->leave_status = 'Approved';    		
    	   if ($model->save()) {
      
              
            }
// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
       
    	
    }
    
    public function actionDisapprove($id)
    {
    	
    		$model = $this->loadModel($id);
    		$model->leave_status = 'Disapproved';
    		if ($model->save()) {
    
    
    		}
    		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    		if (!isset($_GET['ajax']))
    			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    	
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
//delete related records first
//$leaveDetails = EmpLeavesDetails::m
//$this->loadModel($id)->empLeaveDetails->delete();
            $model = $this->loadModel($id);
            $days = $model->leave_days;
            $emp_number = $model->emp_number;
            $sy = $model->leave_sy;
            if ($model->delete()) {
      
                $this->redirect(array('apply', 'emp_number' => $emp_number));
            }


// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function getLeaveDays($data, $row) {
        $res = "";


        $days = EmpLeavesDetails::model()->findAll('leave_id=:id', array(':id' => $data->leave_id));
        foreach ($days as $row) {

            $res .= date('M-d', strtotime($row['leave_details_date'])) . " " . $row['leave_details_ampm'];
            $res .= "\n";
        }

        return $res;
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('EmpLeaves');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

   

    
    public function actionDynamicEmployees()
    {
    
    	$empNumber = $_POST['EmpLeaves']['emp_number'];
    
    
    	$data = CHtml::listData( Employee::model()->with('empPosition')->findAll(array(
    			'order' => 'emp_lastname',
    			'condition' => 'isActive=:isActive and position_category=:position_category',
    			'params' => array(':isActive' => 'Y', 'position_category' => 'head'),
    	)), 'emp_number', 'fullname');
    
    	$model = Employee::model()->findByPk((int)$empNumber);
    	foreach($data as $id => $value)
    	{
    		if ($id == $model->emp_supervisor)
    			echo CHtml::tag('option',array('value' => $id,'selected'=>'selected'),CHtml::encode($value),true);
    		else
    			echo CHtml::tag('option',array('value' => $id),CHtml::encode($value),true);
    
    	}
    	 
    	 
    
    }
    
    public function actionAdmin() {
    
    
    	$model = new EmpLeaves;
    	$lastname = "%";
    	$leave_id = "%";
    
    	if (isset($_POST['lastname'])) {
    		$lastname = $_POST['lastname'];
    		$leave_id = $_POST['leave_id'];
    	}
    
    	$dataProvider = new CActiveDataProvider('EmpLeaves', array(
    			'criteria' => array(
    					'with' => array('empNumber'),
    					'condition' => 'empNumber.emp_lastname like :lastname and leave_id like :leave_id and (leave_status!=:status and leave_status!=:disstatus)',
    					'params' => array(':lastname' => $lastname . "%",':leave_id' => $leave_id. "%", ':status' => 'approved', ':disstatus' => 'disapproved'),
    					
    			),
    			'pagination' => array(
    					'pageSize' => 31,
    			),
    	));
    
    	$this->render('admin', array(
    			'model' => $model,
    			'dataProvider' => $dataProvider,
    			'lastname'=>$lastname,
    			'leave_id'=>$leave_id,
    	));
    }
    
    
    public function actionApproved() {
    
    
    	$model = new EmpLeaves;
    	$lastname = "%";
    	$firstname = "%";
    
    	if (isset($_POST['lastname'])) {
    		$lastname = $_POST['lastname'];
    		$firstname = $_POST['firstname'];
    	}
    
    	$dataProvider = new CActiveDataProvider('EmpLeaves', array(
    			'criteria' => array(
    					'with' => array('empNumber'),
    					'condition' => 'empNumber.emp_lastname like :lastname and empNumber.emp_firstname like :firstname',
    					'order' => 'leave_date_created DESC',
    					'params' => array(':lastname' => $lastname . "%", ':firstname' => $firstname . "%"),
    			),
    			'pagination' => array(
    					'pageSize' => 31,
    			),
    	));
    
    	$this->render('approvedLeaves', array(
    			'model' => $model,
    			'dataProvider' => $dataProvider,
    			'lastname'=>$lastname,
    			'firstname'=>$firstname,
    	));
    }
    
    
    public function actionLeaveSummary(){
    	$sy = '';
    	$year= date('Y');
    	if (isset($_POST['sy']))
    	{
    		$sy = $_POST['sy'];
    	}else
    	{
    		if (date('m') < '06') {
    			//if May
    			$sy = $year - 1 . '-' . $year;
    		} else {
    			$sy = $year . '-' . ($year + 1);
    		}
    	}
    	
    	$sql="select d.leave_allocated_sl as slc,d.leave_allocated_vl as vlc, l.emp_number,c.shortname,b.emp_lastname,b.emp_firstname,
    	sum( if(l.leave_type ='slp',  l.leave_days,0)) as slp,
    	sum( if(l.leave_type ='vlp',  l.leave_days,0)) as vlp,
    	sum( if(l.leave_type ='elp',  l.leave_days,0)) as elp,
    	sum( if(l.leave_type ='vl',  l.leave_days,0)) as vl,
    	sum( if(l.leave_type ='sl',  l.leave_days,0)) as sl,
    	sum( if(l.leave_type ='el',  l.leave_days,0)) as el,
    	sum( if(l.leave_type ='ml',  l.leave_days,0)) as ml,
    	sum( if(l.leave_type ='mlc',  l.leave_days,0)) as mlc,
    	sum( if(l.leave_type ='pl',  l.leave_days,0)) as pl
    	from hs_hr_emp_leaves as l
    	inner join hs_hr_employee as b on b.emp_number = l.emp_number
    	inner join hs_hr_department as c on c.id = b.emp_department_code
    	inner join hs_hr_emp_leave_credits as d on d.emp_number = b.emp_number and d.leave_sy = '$sy'
    	where l.leave_sy = '$sy' and b.isActive = 'Y'
    	
    	group by emp_number
    	order by c.shortname asc, b.emp_lastname
    	";
    	
    	

    	$result = Yii::app()->db->createCommand($sql)->query();
    	$this->render('summary',array(
    			'result'=>$result,'sy'=>$sy,
    	));
    	
    }
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = EmpLeaves::model()->with('headx', 'heady', 'empLeavesDetails')->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'emp-leaves-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
