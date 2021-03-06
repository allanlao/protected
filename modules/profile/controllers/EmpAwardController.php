<?php

class EmpAwardController extends Controller
{
	public $layout='/layouts/profile';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'roles'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'roles'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'roles'=>array('*'),
			),
		);
	}

	public function actionCreate()
	{
		$model=new EmpAwards;
         $emp_number = Yii::app()->session['profile_no'];

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['EmpAwards']))
		{
			$model->attributes=$_POST['EmpAwards'];
                        
                        $model->award_description = ucwords( strtolower($model->award_description));
                        $model->awarding_body = ucwords(strtolower($model->awarding_body));
                        
			if($model->save())
				$this->redirect(array('create','emp_number'=>$emp_number));
		}

                $dataProvider=new CActiveDataProvider('EmpAwards', array(
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


	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function loadModel($id)
	{
		$model=EmpAwards::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}