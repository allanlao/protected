<?php

class EmployeeController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '/layouts/profile';
    public $eid;

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
                'actions' => array('index', 'view'),
                'roles' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'profile', 'updatePersonal', 'updateContacts', 'updateJob', 'updatePersonal','subordinates','updateIsActive','dynamicEmployees'),
                'roles' => array('admin', 'user'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'updateSupervisor', 'updatePosition', 'changeSupervisor', 'changePosition', 'deactivate','updateIsActive'),
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
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionGridEdit() {
        $this->layout = '//layouts/secondary';
        $dataProvider = new CActiveDataProvider('Employee', array(
                    'criteria' => array(
                    //  'condition' => 'emp_number=:emp_number ',
                    //   'params' => array(':emp_number' => $emp_number)
                    ),
                    'pagination' => array(
                        'pageSize' => 200,
                    ),
                ));
        $this->render('gridEdit', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
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


        $this->render('create', array(
            'model' => $model, 'departmentList' => $departmentList, 'supervisorList' => $supervisorList,
        ));
    }

    public function actionUpdateSupervisor() {
        if (Yii::app()->request->isAjaxRequest && isset($_POST['id'])) {

            $id = trim($_POST['id']);
            $model = Employee::model()->findByPk($id);
            $model->emp_supervisor = trim($_POST['supervisor']);


            if ($model->save()) {
                //Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have changed user role.');
                echo "ok";
            }

            else
                echo "bad";
        }
    }

    public function actionUpdatePosition() {
        if (Yii::app()->request->isAjaxRequest && isset($_POST['id'])) {

            $id = trim($_POST['id']);
            $model = Employee::model()->findByPk($id);
            $model->emp_position_code = trim($_POST['position']);


            if ($model->save()) {
                //Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have changed user role.');
                echo "ok";
            }

            else
                echo "bad";
        }
    }

    public function actionChangeSupervisor() {
        $this->layout = '/layouts/position';
        $departments = Department::model()->findAll();
        $id = 0;

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }


        $dataProvider = new CActiveDataProvider('Employee', array(
                    'criteria' => array(
                        'condition' => '(emp_department_code=:deptCode and isActive=:isActive)',
                        'params' => array(':deptCode' => $id, ':isActive' => 'Y'),
                        'order' => 'emp_lastname',
                    ),
                    'pagination' => array(
                        'pageSize' => 200,
                    ),
                ));

        $this->render('changeSupervisor', array('departments' => $departments, 'dataProvider' => $dataProvider));
    }

    public function actionChangePosition() {
        $this->layout = '/layouts/position';
        $departments = Department::model()->findAll();
        $id = 0;

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }


        $dataProvider = new CActiveDataProvider('Employee', array(
                    'criteria' => array(
                        'condition' => '(emp_department_code=:deptCode and isActive=:isActive)',
                        'params' => array(':deptCode' => $id, ':isActive' => 'Y'),
                    ),
                    'pagination' => array(
                        'pageSize' => 200,
                    ),
                ));

        $this->render('changePosition', array('departments' => $departments, 'dataProvider' => $dataProvider));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionProfile() {
        $model = new Employee('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Employee']))
            $model->attributes = $_GET['Employee'];

        $this->render('profile', array(
            'model' => $model,
        ));
    }

    public function actionUpdatePersonal() {

        $this->layout = '//layouts/profile';

        if (isset($_GET['id'])) {
            $emp_id = $_GET['id'];
            Yii::app()->session['emp_id'] = $emp_id;
        } else {
            $emp_id = Yii::app()->session['emp_id'];
        }




        $model = $this->loadModel($emp_id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Employee'])) {

            $model->attributes = $_POST['Employee'];

            $model->emp_lastname = ucwords(strtolower($model->emp_lastname));
            $model->emp_firstname = ucwords(strtolower($model->emp_firstname));
            $model->emp_middle_name = ucwords(strtolower($model->emp_middle_name));




            // $model->lastEdited = Date();
            //  $model->lastEditBy = Yii::app()->user->getState('email');


            if ($model->save())
                $this->redirect(array('updatePersonal'));
        }


        $this->render('update_personal', array(
            'model' => $model,
        ));
    }

    public function actionUpdateContacts() {

        $this->layout = '//layouts/profile';

        $emp_id = Yii::app()->session['emp_id'];
        $model = $this->loadModel($emp_id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Employee'])) {
            $model->attributes = $_POST['Employee'];

            $model->emp_address_current = ucwords(strtolower($model->emp_address_current));
            $model->emp_work_email = strtolower($model->emp_work_email);
            $model->emp_oth_email = strtolower($model->emp_oth_email);

            if ($model->save())
                $this->redirect(array('updateContacts'));
        }

        $this->render('update_contacts', array(
            'model' => $model,
        ));
    }

    public function actionUpdateJob() {
        $this->layout = '//layouts/profile';

        $emp_id = Yii::app()->session['emp_id'];
        $model = $this->loadModel($emp_id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);


        if (isset($_POST['Employee'])) {
            $model->attributes = $_POST['Employee'];

            echo $model->emp_department_code;
            if ($model->save())
                $this->redirect(array('updateJob'));
        }

        $this->render('update_job', array(
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
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Employee');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
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

    //the following functions are for  grid editing
    public function actionIsActive() {
        if (isset($_POST['isActive'])) {
            $id = $_POST['isActive']['id'];
            $value = $_POST['isActive']['value'];
            $model = $this->loadModel($id);

            $model->isActive = strtoupper($value);

            if ($model->save()) {
                echo $value;
            }
        }
    }

    public function actionDeactivate() {
        $this->layout = '/layouts/position';
        $departments = Department::model()->findAll();
        $id = 0;

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }


        $dataProvider = new CActiveDataProvider('Employee', array(
                    'criteria' => array(
                        'condition' => '(emp_department_code=:deptCode)',
                        'params' => array(':deptCode' => $id),
                        'order' => 'emp_lastname',
                    ),
                    'pagination' => array(
                        'pageSize' => 200,
                    ),
                ));

        $this->render('deactivate', array('departments' => $departments, 'dataProvider' => $dataProvider));
    }

    public function actionUpdateIsActive() {
        if (Yii::app()->request->isAjaxRequest && isset($_POST['isActive'])) {
            $id = trim($_POST['id']);
            $model = Employee::model()->findByPk($id);
            $model->isActive = trim($_POST['isActive']);

            if ($model->save()) {
                //Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have changed user role.');
                echo "ok";
            }

            else
                echo "bad";
        }
    }

    public function actionSubordinates() {

      //  $data = Employee::model()->findAll('emp_supervisor=:emp_supervisor', array('order'=>'emp_lastname',':emp_supervisor' => (int) $_POST['Oic']['emp_number']));

        $data = Employee::model()->findAll(array(
            'condition'=>'emp_supervisor=:emp_supervisor',
            'order'=>'emp_lastname',
            'params'=>array(':emp_supervisor'=>(int) $_POST['Oic']['emp_number']),
        ));
        $data = CHtml::listData($data, 'emp_number', 'fullname');
        foreach ($data as $id => $value) {
            echo CHtml::tag('option', array('value' => $id), CHtml::encode($value), true);
        }
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

}
