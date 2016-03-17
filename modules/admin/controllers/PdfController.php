<?php

class PdfController extends Controller {

    public $layout = '/layouts/column1';

    public function actionIndex() {
        $this->render('index');
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'printbio'),
                'roles' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'roles' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'roles' => array('admin'),
            ),
            array('deny', // deny all users
                'roles' => array('*'),
            ),
        );
    }


    public function actionFaculty_result1() { //by head
        $this->layout = '/layouts/column2';

        $departments = Department::model()->findAll(array('order' => 'shortname'));
        $id = 0;
        $deptname = "Select department.";
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $deptname = Department::model()->findByPk($id)->name;
        }
        if (isset($_POST['sy'])) {
            $sy = $_POST['sy'];
            $sem = $_POST['sem'];
        } else {
            $sy = '2011-2012';
            $sem = '1st';
        }
        $sql = "SELECT CONCAT(emp_lastname, ', ',emp_firstname) AS name, 
                AVG(facultybhead_evaluation.total) AS head 
                FROM hs_hr_employee 
                LEFT JOIN facultybhead_evaluation ON hs_hr_employee.emp_number=facultybhead_evaluation.emp_number AND facultybhead_evaluation.sem='$sem' AND  facultybhead_evaluation.sy='$sy' 
                LEFT JOIN hs_hr_position ON  hs_hr_employee.emp_position_code=hs_hr_position.position_code 
                WHERE position_category='faculty' AND isActive='Y' AND emp_department_code=$id
                GROUP BY name ORDER BY name";

        $dataProvider = new CSqlDataProvider($sql, array(
            'keyField' => 'name',
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
        $period = EvaluationPeriod::model()->findAll(array(
            'select' => 'sy',
            'distinct' => true,
        ));

        $sylist = CHtml::listData($period, 'sy', 'sy');
        $this->render('faculty_result1', array('departments' => $departments, 'dataProvider' => $dataProvider, 'sylist' => $sylist, 'sy' => $sy, 'sem' => $sem, 'dr' => $this->desriptive_rating, 'deptname' => $deptname));
    }


    public function actionPrintbio() {
       
        $id = 524;
        $model = $this->loadmodel($id);
       /* $pic = $this->getPicName($id);
        $empWork = $this->loadWork($id);
        $empContact = $this->loadContacts($id);
        $empEduc = $this->loadEducation($id);
        $empTraining = $this->loadTrainings($id);
        $empLic = $this->loadLicenses($id);
        $empDependents = $this->loadDependents($id);
        $empAffiliation = $this->loadAffiliation($id);*/

        $this->render('biodata', array('model' => $model));
    }

    public function actionCertificates(){

        if (isset($_POST['btnGenerate'])) {

            $id = $_POST['emp_number'];
            $certificate = $_POST['certificate_num'];

            switch ($certificate) {

                case 1:
                    $this->actionCertificateOne($id);
                    break;
               
                case 2:
                    $this->actionCertificateFour($id);
                    break;
            }

        }else{
            $model = Employee::model()->findAll();
            $this->render('certificates', array('model' => $model,));
        }
    }
    
    public function actionCertificateOne($id){
        $model = Employee::model()->with('department')->findByPk($id);

        $this->render('certificateOne', array('model' => $model));
    }

    public function actionCertificateTwo($id){
        $model = Employee::model()->with('department','salary')->findByPk($id);
        $this->render('certificateTwo', array('model' => $model));
        
    }
    
    public function actionCertificateThree($id){
        $model = Employee::model()->with('department','position')->findByPk($id);
        $this->render('certificateThree', array('model' => $model));
        
    }
    
    public function actionCertificateFour($id){
        $model = Employee::model()->with('department')->findByPk($id);
        $this->render('certificateFour', array('model' => $model));
        
    }

    public function actionOtAuth(){
        $this->render('otauth');
        
    }

    public function actionDeptSumPerYearStaff(){
        $this->render('DeptSumPerYear');
        
    }

    public function actionDeptSumPerYearFac(){
        $this->render('DeptSumPerYearFac'); 
    }

    public function actionDeptSumPerSemStaff(){
        $this->render('DeptSumPerSem');
        
    }

    public function actionDeptSumPerSemFac(){
        $this->render('DeptSumPerSemFac'); 
    }
    
    public function actionIndSumPerDeptStaff(){
        $this->render('IndSumPerDeptStaff');
    }

    public function actionIndSumPerDeptFac(){
        $this->render('IndSumPerDeptFac');
    }

    public function actionBiodata() {
        //$this->render('biodata');

        $model = new Employee('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Employee']))
            $model->attributes = $_GET['Employee'];

        $this->render('viewemployee', array(
            'model' => $model,
        ));
    }
    

    // Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */

    public function loadModel($id) {
        $model = Employee::model()->findByPk((int) $id);
        
        if ($model === null)
            throw new CHttpException(404, 'No Profile has been created for this employee number. Please contact HR');
        return $model;
    }

    public function getPicName($id) {

        $row = EmpPicture::model()->findByPk($id);

        return $row['epic_filename'];
    }

   

    public function loadContacts($id) {
        // $model=EmpWorkExperience::model()->findByPk($id);
        //return $model; 
        $con = Yii::app()->db;
        $command = $con->createCommand("Select * from hs_hr_emp_emergency_contacts where emp_number=" . $id);
        return $command->query();
    }

    public function loadEducation($id) {
        // $model=EmpWorkExperience::model()->findByPk($id);
        //return $model; 
        $con = Yii::app()->db;
        $command = $con->createCommand("Select * from hs_hr_emp_education where emp_number=" . $id);
        return $command->query();
    }

    public function loadTrainings($id) {
        // $model=EmpWorkExperience::model()->findByPk($id);
        //return $model; 
        $con = Yii::app()->db;
        $command = $con->createCommand("Select * from hs_hr_emp_trainings where emp_number=" . $id);
        return $command->query();
    }

    public function loadLicenses($id) {
        // $model=EmpWorkExperience::model()->findByPk($id);
        //return $model; 
        $con = Yii::app()->db;
        $command = $con->createCommand("Select * from hs_hr_emp_licenses where emp_number=" . $id);
        return $command->query();
    }
    
     public function loadDependents($id) {
        // $model=EmpWorkExperience::model()->findByPk($id);
        //return $model; 
        $con = Yii::app()->db;
        $command = $con->createCommand("Select * from hs_hr_emp_dependents where emp_number=" . $id);
        return $command->query();
    }
    
      public function loadAffiliation($id) {
        // $model=EmpWorkExperience::model()->findByPk($id);
        //return $model; 
        $con = Yii::app()->db;
        $command = $con->createCommand("Select * from hs_hr_emp_affiliation where emp_number=" . $id);
        return $command->query();
    }

}