<?php

class EvaluationPeriodController extends Controller
{
	public $layout='/layouts/column1';

	public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

	public function accessRules()
	{
		return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'roles' => array('user'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create',  'update','index','delete','close','open'),
                'roles' => array('admin', 'hradmin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
	}

	public function actionIndex()
	{
		$model = new EvaluationPeriod();
        if (isset($_POST['EvaluationPeriod'])) {
            $model = new EvaluationPeriod();
            $model->attributes = $_POST['EvaluationPeriod'];
            $model->status="closed";
            if ($model->save()) {
                $model->unsetAttributes();
            }
        }

        $dataProvider=new CActiveDataProvider('EvaluationPeriod', array(
            'pagination'=>array(
                'pageSize'=>30,
            ),
        ));

        $this->render('index', array(
            'model' => $model,
            'dataProvider'=>$dataProvider,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }	

    public function actionClose($id) {
        if (Yii::app()->request->isPostRequest) {
            $model=$this->loadModel($id);
            $model->status='closed';
            $model->save();

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }   

    public function actionOpen($id) {
        if (Yii::app()->request->isPostRequest) {
           

            $model=$this->loadModel($id);
            $model->status='open';
            $model->save();

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }   


    public function loadModel($id) {
        $model = EvaluationPeriod::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Invalid request! No record found.');
        return $model;
    }

    
}