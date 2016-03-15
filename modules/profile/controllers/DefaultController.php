<?php

class DefaultController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '/layouts/profile';
  
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
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'updateContacts', 'updatePersonal', 'updatePicture','index'),
                'roles' => array('user'),
            ),
        		array('allow', // allow authenticated user to perform 'create' and 'update' actions
        				'actions' => array( 'updateJob','delete','active','updateTermination'),
        				'roles' => array('hradmin'),
        		),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
 public function actionCreate() {
 	   $this->layout = '/layouts/column1';
        $model = new Employee;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Employee'])) {
            $model->attributes = $_POST['Employee'];

            $model->emp_lastname = ucwords(strtolower($model->emp_lastname));
            $model->emp_firstname = ucwords(strtolower($model->emp_firstname));
            $model->emp_middle_name = ucwords(strtolower($model->emp_middle_name));


            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have create a new user');
                //  $this->redirect(array('view', 'id' => $model->emp_number));
            }
        }



        $departments = Department::model()->findAll(
                array('order' => 'name'));

        $supervisors = Employee::model()->with(array(
                    'empPosition' => array(
                        // we don't want to select posts
                        'select' => false,
                        // but want to get only users with published posts
                        'joinType' => 'INNER JOIN',
                        'condition' => 'empPosition.position_category="head"',
                    ),
                ))->findAll();
        $departmentList = CHtml::listData($departments, 'id', 'name');
        $supervisorList = CHtml::listData($supervisors, 'emp_number', 'fullname');


        $lastNumber = Employee::model()->find(array('select'=>'emp_number','order'=>'emp_number desc'));
      
        $model->emp_number = $lastNumber->emp_number + 1;

        $this->render('create', array(
            'model' => $model, 'departmentList' => $departmentList, 'supervisorList' => $supervisorList,
        ));
    }
    

    public function actionUpdatePicture() {
    
       $emp_number = Yii::app()->session['profile_no'];
    	
        $model = $this->loadModel($emp_number);
        $path = dirname(Yii::app()->getBasePath()) . "/profile_pics/";

        if (isset($_POST['Employee'])) {
            $model->picture = CUploadedFile::getInstance($model, 'picture');

            // $file = CUploadedFile::getInstance($model, 'picture');
            //check file type here
            // $model->picture->maxWidth = 600;
            //  $model->picture->maxHeight = 300;
            //  if ($file->saveAs($path . $emp_number . '.' . $ext)) {
            //       $model->picture = $emp_number . '.' . $ext;

            if ($model->validate()) {
                //then rename pic save field and save file itself
                $ext = $model->picture->extensionName;
                $filename = $path . $emp_number . '.' . $ext;
                $model->picture->saveAs($filename);
                $image = Yii::app()->image->load($filename);
                $image->resize(300, 250,Image::AUTO);
                $image->save();

                $model->picture = $emp_number . '.' . $ext;
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have uploaded a new Profile Picture');
                }
            }
        }


        $this->render('update_picture', array('model' => $model));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdatePersonal() {
       if (isset($_GET['id']))
    		$emp_number = $_GET['id'];  
    		else
            $emp_number = Yii::app()->user->getState('empNumber');

    		Yii::app()->session['profile_no'] = $emp_number;
    		
        if (empty($emp_number)) {
            $this->redirect(array('site/login'));
        }
        $model = $this->loadModel($emp_number);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Employee'])) {

            $model->attributes = $_POST['Employee'];

            $model->emp_lastname = ucwords(strtolower($model->emp_lastname));
            $model->emp_firstname = ucwords(strtolower($model->emp_firstname));
            $model->emp_middle_name = ucwords(strtolower($model->emp_middle_name));

            // $model->lastEdited = Date();
            //  $model->lastEditBy = Yii::app()->user->getState('email');


            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have updated your profile.');
                $this->redirect(array('updatePersonal'));
            }
        }


        $this->render('update_personal', array(
            'model' => $model,
        ));
    }

    public function actionUpdateContacts() {
    	
        $emp_number = Yii::app()->session['profile_no'];
    		
        $model = $this->loadModel($emp_number);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Employee'])) {
            $model->attributes = $_POST['Employee'];

            $model->emp_address_current = ucwords(strtolower($model->emp_address_current));
            $model->emp_work_email = strtolower($model->emp_work_email);
            $model->emp_oth_email = strtolower($model->emp_oth_email);

            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have updated your Contacts.');
                $this->redirect(array('updateContacts'));
            }
        }

        $this->render('update_contacts', array(
            'model' => $model,
        ));
    }

    public function actionUpdateJob() {
        $emp_number = Yii::app()->session['profile_no'];
    		
        $model = $this->loadModel($emp_number);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);


        if (isset($_POST['Employee'])) {
            $model->attributes = $_POST['Employee'];

            echo $model->emp_department_code;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have updated your Job Profile.');
                $this->redirect(array('updateJob'));
            }
        }

        $this->render('update_job', array(
            'model' => $model,
        ));
    }


    public function actionUpdateTermination() {
        $emp_number = Yii::app()->session['profile_no'];
            
        $model = $this->loadModel($emp_number);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);


        if (isset($_POST['Employee'])) {
            $model->attributes = $_POST['Employee'];

            echo $model->emp_department_code;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have updated the Termination Details.');
                $this->redirect(array('updateTermination'));
            }
        }

        $this->render('update_termination', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            
            try {
            	$this->loadModel($id)->delete();
            	
            	// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            	if (!isset($_GET['ajax']))
            		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            } catch (Exception $e) {
            	throw new CHttpException(400, 'Invalid request. Employee cannot be deleted.');
            	
            }
	           
        
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
    	$this->layout = '/layouts/column1';
    	
    	$model = new Employee('search');
    	$model->unsetAttributes();  // clear any default values
    	if (isset($_GET['Employee']))
    		$model->attributes = $_GET['Employee'];
    	
    	$this->render('index', array(
    			'model' => $model,
    	));
    	
    
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Employee('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Employee']))
            $model->attributes = $_GET['Employee'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Employee::model()->findByPk((int) $id);
        if ($model === null)
            throw new CHttpException(404, 'No Profile has been created for this employee number. Please contact HR');
        return $model;
    }

    public function actionSubordinates() {

        $data = Employee::model()->findAll('emp_supervisor=:emp_supervisor', array(':emp_supervisor' => (int) $_POST['Oic']['emp_number']));

        $data = CHtml::listData($data, 'emp_number', 'fullname');
        foreach ($data as $id => $value) {
            echo CHtml::tag('option', array('value' => $id), CHtml::encode($value), true);
        }
    }

    
    public function actionActive(){
       $this->layout = "/layouts/column1";
    	$data_provider = new CActiveDataProvider('Employee', array(
    			'criteria' => array(
    					'join'=>'join hs_hr_department as b on t.emp_department_code = b.id',
    					'condition'=>'isActive = "Y"',
    					'order'=>'b.shortname, t.emp_lastname',
    	
    	
    			),
    			'pagination' => array(
    					'pageSize' => 500,
    						
    			),
    	));
    	
    	
    	
    	$this->render('activeList',array(
    			'data_provider'=>$data_provider,
    	));
    }
    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employee-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
