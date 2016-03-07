<?php

class EmpLeavesCreditController extends Controller {

    public $layout = '/layouts/column1';

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'index', 'view', 'update', 'createOne'),
                'roles' => array('admin', 'user'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'roles' => array('admin', 'user'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // uncomment the following code to enable ajax-based validation
        /*
          if(isset($_POST['ajax']) && $_POST['ajax']==='emp-leave-credits-update-form')
          {
          echo CActiveForm::validate($model);
          Yii::app()->end();
          }
         */

        if (isset($_POST['EmpLeaveCredits'])) {
            $model->attributes = $_POST['EmpLeaveCredits'];
            if ($model->save())
                $this->redirect(array('view'));
        }

        $this->render('update', array('model' => $model));
    }

    public function getPendingVl($data, $row) {

          return EmpLeaves::model()->getVlPending($data->emp_number, $data->leave_sy);
    }

   

    public function getPendingSl($data, $row) {

         return EmpLeaves::model()->getSlPending($data->emp_number, $data->leave_sy);
    }

    

    public function getUsedVl($data, $row) {
        return EmpLeaves::model()->getVlUsed($data->emp_number, $data->leave_sy);
    }

    public function getUsedSl($data, $row) {
        return EmpLeaves::model()->getSlUsed($data->emp_number, $data->leave_sy);
    }

    public function getUsedOthers($data, $row) {  
        return EmpLeaves::model()->getOthersUsed($data->emp_number, $data->leave_sy);
    }


    public function actionView() {


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

    public function actionCreate() {



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

    public function loadModel($id) {
        $model = EmpLeaveCredits::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
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

}