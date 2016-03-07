<?php

class EmpEducationController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/layouts/profile';

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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','suggestDegree'),
				'roles'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'roles'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'roles'=>array('*'),
			),
			array('deny',  // deny all users
				'roles'=>array('*'),
			),
		);
	}

        
        public function actionSuggestDegree()
           {
           if(Yii::app()->request->isAjaxRequest && isset($_GET['q']))
           {
                /* q is the default GET variable name that is used by
                / the autocomplete widget to pass in user input
                */
              $degree = $_GET['q']; 
                        // this was set with the "max" attribute of the CAutoComplete widget
              $limit = min($_GET['limit'], 50); 
              $criteria = new CDbCriteria;
              $criteria->condition = "Description LIKE :des";
              $criteria->params = array(":des"=>"%$degree%");
              $criteria->limit = $limit;
              $userArray = Degree::model()->findAll($criteria);
              $returnVal = '';
              foreach($userArray as $userAccount)
              {
                 $returnVal .= $userAccount->getAttribute('Description').'|'
                                             .$userAccount->getAttribute('Name')."\n";
              }
              echo $returnVal;
           }
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
        $emp_number = Yii::app()->session['profile_no'];
		$model=new EmpEducation;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['EmpEducation']))
		{
			$model->attributes=$_POST['EmpEducation'];
                        
                        $model->edu_degree = ucwords(strtolower($model->edu_degree));
                        $model->edu_school = ucwords(strtolower($model->edu_school));
			if($model->save())
				$this->redirect(array('create','emp_number'=>$emp_number));
		}

                $dataProvider=new CActiveDataProvider('EmpEducation', array(
                        'criteria'=>array(
                                'condition'=>'emp_number=:emp_number',
                                'params'=>array(':emp_number'=>$emp_number)

                        ),
                        'pagination'=>array(
                                'pageSize'=>31,
                        ),
                 ));
                
		$this->render('create',array(
			'model'=>$model,'emp_number'=>$emp_number,'dataProvider'=>$dataProvider,
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

		if(isset($_POST['EmpEducation']))
		{
			$model->attributes=$_POST['EmpEducation'];
                        
                        $model->edu_degree = ucwords(strtolower($model->edu_degree));
                        $model->edu_school = ucwords(strtolower($model->edu_school));
                        
			if($model->save())
				$this->redirect(array('view','id'=>$model->edu_id));
		}

		$this->render('update',array(
			'model'=>$model,
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
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('EmpEducation');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new EmpEducation('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EmpEducation']))
			$model->attributes=$_GET['EmpEducation'];

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
		$model=EmpEducation::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='emp-education-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
