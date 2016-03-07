<?php

class DefaultController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '/layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
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
                'actions' => array('create', 'update','index', 'view'),
                'roles' => array('admin','user'),
              
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'roles' => array('admin','user'),
               
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
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new JobPosting();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['JobPosting']))
		{
			$model->attributes=$_POST['JobPosting'];
                        $model->status='active';
                        $model->posted_by = Yii::app()->user->getState('empNumber');
                        $model->date_posted = date('Y-m-d');

			  if ($model->save()) {
                                Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have create a new Job Posting');
                                $model->unsetAttributes();
                            }
		}

      /* $supervisors = Employee::model()->with(array(
                    'empPosition' => array(
                        // we don't want to select posts
                        'select' => false,
                        // but want to get only users with published posts
                        'joinType' => 'INNER JOIN',
                        //'condition' => 'empPosition.position_category="head"',
                        'order'=>'emp_lastname'
                    ),
                ))->findAll(); */

                $positions = Position::model()->findAll();
                $positionList = CHtml::listData($positions, 'position_code', 'position_desc');

                $departments = Department::model()->findAll();
                $departmentList =  CHtml::listData($departments, 'shortname', 'name');
       
       
        $dataProvider=new CActiveDataProvider('JobPosting',array(
        
        	'pagination'=>array(
        		'pageSize'=>15,
        	),
        ));
        $this->render('create', array(
            'model' => $model, 
            'positionList' => $positionList,
            'departmentList'=> $departmentList,
             'dataProvider'=>$dataProvider,
        ));
      
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['JobPosting']))
		{
			$model->attributes=$_POST['JobPosting'];
			if($model->save())
				$this->redirect(array('create'));
		}

		
               $positions = Position::model()->findAll();
                $positionList = CHtml::listData($positions, 'position_code', 'position_desc');

                $departments = Department::model()->findAll();
                $departmentList =  CHtml::listData($departments, 'shortname', 'name');
       
       
        $dataProvider=new CActiveDataProvider('JobPosting',array(
        
        	'pagination'=>array(
        		'pageSize'=>15,
        	),
        ));
        $this->render('update', array(
            'model' => $model, 
            'positionList' => $positionList,
            'departmentList'=> $departmentList,
             'dataProvider'=>$dataProvider,
        ));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{


   
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('create'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

			
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('JobPosting');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Department('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Department']))
			$model->attributes=$_GET['JobPosting'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=JobPosting::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='department-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
