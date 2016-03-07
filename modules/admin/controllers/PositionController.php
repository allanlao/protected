<?php

class PositionController extends Controller {

   public $layout = '/layouts/column1';

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
                'actions' => array('index', 'view'),
                'roles' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'changeRole','update'),
                'roles' => array('user'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'roles' => array('user'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionCreate() {
        $model = new Position;

        if (isset($_POST['Position'])) {
            $model->attributes = $_POST['Position'];
            $model->position_code=uniqid();
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have create a new position');
                $model->unsetAttributes();
            }
        }

        $dataProvider=new CActiveDataProvider('Position', array(
            'criteria'=>array(
                'order'=>'position_desc',

                ),
            'pagination'=>array(
                'pageSize'=>15,

                ),
        ));

       $this->render('create', array(
            'model' => $model,
            'dataProvider'=>$dataProvider,
        ));
    }

    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Position']))
        {
            $model->attributes=$_POST['Position'];
            if($model->save())
                $this->redirect(array('create'));
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



    public function loadModel($id)
    {
        $model=Position::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }  

}