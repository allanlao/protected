<?php

class PdfController extends Controller {

    public $layout = '//layouts/column1';

    public function actionIndex() {
        $this->render('index');
    }

   public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('leaveForm'),
                'roles' => array('user'),
            ),
         
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }


    
    public function actionLeaveForm($id){
        $model = EmpLeaves::model()->with('empNumber')->findByPk($id);
        $this->renderPartial('leave_form', array('model'=>$model));
    }



}