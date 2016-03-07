<?php

class EvaluatorsMapController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '/layouts/column1';

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
                'actions' => array(
                    'index', 'delete', 'summary', 'map', 'editor', 'generate'
                ),
                'roles' => array('hradmin', 'admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function generateFacultyByDean($dept_id, $period, $etype) {
        $prefix = " INSERT IGNORE INTO evaluators_map (emap_id, evaluation_period_id,
    			    employee_id,emp_to_evaluate,evaluation_type) VALUES ";

      

        $employees = Employee::model()->getActiveEmployeesPerDepartmentWithoutHead($dept_id);

     
        foreach ($employees as $employee) {


            $emap_id = $period . '-' .$employee['emp_supervisor'] . '-' . $employee['emp_number'] . '-' . $etype;
            $value = "('";
            $value .= $emap_id . "',";
            $value .= $period . ",";
         
            $value .= $employee['emp_supervisor'] . ",";
            $value .= $employee['emp_number'] . ",";
            $value .= $etype;
            $value .= "),";

            $prefix .= $value;
           
        }
         $prefix_fin = substr($prefix, 0, strlen($prefix) - 1);

        try{
         Yii::app()->db->createCommand($prefix_fin)->execute();
        echo "success";
        }catch (Exception $e){
               echo $e->getMessage();
        }
    }

    public function generateHeadBySubordinate($dept_id, $period, $etype) {
        $prefix = " INSERT IGNORE INTO evaluators_map (emap_id, evaluation_period_id,
    			    employee_id,emp_to_evaluate,evaluation_type) VALUES ";

        $withEntry = 0;

        $employees = Employee::model()->getActiveEmployeesPerDepartmentWithoutHead($dept_id);

        $peers = Employee::model()->getDepartmentHead($dept_id);

        foreach ($employees as $employee) {

     

              
                    $emap_id = $period . '-' . $employee['emp_number'] . '-' . $employee['emp_supervisor'] . '-' . $etype;
                    $value = "('";
                    $value .= $emap_id . "',";
                    $value .= $period . ",";
                    $value .= $employee['emp_number'] . ",";
                    $value .= $employee['emp_supervisor'] . ",";
                    $value .= $etype;
                    $value .= "),";

                    $prefix .= $value;
                    $withEntry = 1;
             
            
        }
        $prefix_fin = substr($prefix, 0, strlen($prefix) - 1);
        $result = 0;
     
        if ($withEntry) {
            $result = Yii::app()->db->createCommand($prefix_fin)->execute();
        }
        echo $withEntry;
    }

    public function generatePeer($dept_id, $period, $etype) {
        $prefix = " INSERT IGNORE INTO evaluators_map (emap_id, evaluation_period_id,
    			    employee_id,emp_to_evaluate,evaluation_type) VALUES ";

        //	$withEntry = 0;

        $employees = Employee::model()->getActiveEmployeesPerDepartmentWithoutHead($dept_id);

        $peers = $employees;

        foreach ($employees as $employee) {

            foreach ($peers as $peer) {

                if ($employee['emp_number'] != $peer['emp_number']) {
                    $emap_id = $period . '-' . $employee['emp_number'] . '-' . $peer['emp_number'] . '-' . $etype;
                    $value = "('";
                    $value .= $emap_id . "',";
                    $value .= $period . ",";
                    $value .= $employee['emp_number'] . ",";
                    $value .= $peer['emp_number'] . ",";
                    $value .= $etype;
                    $value .= "),";

                    $prefix .= $value;
                    //  $withEntry = 1;
                }
            }
        }


        $prefix_fin = substr($prefix, 0, strlen($prefix) - 1);

        try{
         Yii::app()->db->createCommand($prefix_fin)->execute();
        echo "success";
        }catch (Exception $e){
               echo $e->getMessage();
        }
   
    }

     public function generateStaffByHead($dept_id, $period, $etype) {
        $prefix = " INSERT IGNORE INTO evaluators_map (emap_id, evaluation_period_id,
    			    employee_id,emp_to_evaluate,evaluation_type) VALUES ";

      

        $employees = Employee::model()->getActiveEmployeesPerDepartmentWithoutHead($dept_id);

     
        foreach ($employees as $employee) {


            $emap_id = $period . '-' .$employee['emp_supervisor'] . '-' . $employee['emp_number'] . '-' . $etype;
            $value = "('";
            $value .= $emap_id . "',";
            $value .= $period . ",";
         
            $value .= $employee['emp_supervisor'] . ",";
            $value .= $employee['emp_number'] . ",";
            $value .= $etype;
            $value .= "),";

            $prefix .= $value;
           
        }
         $prefix_fin = substr($prefix, 0, strlen($prefix) - 1);

        try{
         Yii::app()->db->createCommand($prefix_fin)->execute();
        echo "success";
        }catch (Exception $e){
               echo $e->getMessage();
        }
    }

    
    public function actionGenerate() {

        //for peer evaluation
        if ($_POST['etype'] == 1) {
            $this->generatePeer($_POST['dept_id'], $_POST['period'], $_POST['etype']);
        } else if ($_POST['etype'] == 2) {

            $this->generateFacultyByDean($_POST['dept_id'], $_POST['period'], $_POST['etype']);
            
        }else if ($_POST['etype'] == 3) {

            $this->generateStaffByHead($_POST['dept_id'], $_POST['period'], $_POST['etype']);
        } 
        else if ($_POST['etype'] == 4) {

            $this->generateHeadBySubordinate($_POST['dept_id'], $_POST['period'], $_POST['etype']);
        }
    }

    public function actionEditor() {
        if (isset($_POST['period'])) {
            $period = $_POST['period'];
            $selected_type = $_POST['etype'];
        } else {
            $period = 4;
            $selected_type = 1;
        }

        $sql = "select id,name from hs_hr_department order by name";

        $result = Yii::app()->db->createCommand($sql)->query();
        $this->render('editor', array('period' => $period,
            'selected_type' => $selected_type,
            'result' => $result,
        ));
    }

    public function actionIndex() {

        if (isset($_GET['id']))
            $id = $_GET['id'];
        else
            $id = 0;

        //if (!isset)
        if (!isset($_POST['submit']) && !isset($_POST['add'])) {
            $selected_period = $id;
            $selected_emp = 0;
            $selected_type = 1;
            $selected_ratee = 0;
            $this->render('_options', array('selected_period' => $selected_period,
                'selected_emp' => $selected_emp,
                'selected_type' => $selected_type,
                'selected_ratee' => $selected_ratee,
            ));
        } else {

            if (isset($_POST['add'])) {
                $model = new EvaluatorsMap();
                $model->emap_id = trim($_POST['period']) . '-' . trim($_POST['emp_number']) . '-' . trim($_POST['ratee']) . '-' . $_POST['etype'];
                $model->evaluation_period_id = $_POST['period'];
                $model->evaluation_type = $_POST['etype'];
                $model->employee_id = $_POST['emp_number'];
                $model->emp_to_evaluate = $_POST['ratee'];

                try {
                    $model->save();
                    Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have successfully added a new entry');
                } catch (Exception $e) {
                    Yii::app()->user->setFlash('error', 'There was an error saving record, errno - ' . $e->getCode());
                }
            }

            $selected_emp = $_POST['emp_number'];
            $selected_period = $_POST['period'];
            $selected_ratee = $_POST['ratee'];
            $selected_type = $_POST['etype'];
            //get list of employee to evaluate

            $sql = "select hs_hr_employee.emp_lastname,
				hs_hr_employee.emp_firstname,
				evaluators_map.emp_to_evaluate,evaluators_map.rating,evaluators_map.emap_id,
				evaluators_map.evaluation_type,evaluation_type.title ,evaluation_period.sy,evaluation_period.sem
				from evaluators_map
				join hs_hr_employee on evaluators_map.emp_to_evaluate = hs_hr_employee.emp_number
				join evaluation_type on evaluators_map.evaluation_type = evaluation_type.etype_id
				join evaluation_period on evaluation_period.id = $selected_period
				where evaluation_period_id= $selected_period
				and evaluators_map.employee_id = $selected_emp
				
				order by evaluation_type.title, hs_hr_employee.emp_lastname";

            $result = Yii::app()->db->createCommand($sql)->query();

            $model = new EvaluatorsMap();

            $this->render('index', array('result' => $result,
                'selected_period' => $selected_period,
                'selected_emp' => $selected_emp,
                'selected_type' => $selected_type,
                'selected_ratee' => $selected_ratee,
                'model' => $model,
            ));
        }


        //	$result = Yii::app()->db->createCommand($sql)->query();
    }

    public function actionMap() {

        if (!isset($_POST['submit'])) {
            $selected_period = 0;
            $selected_dept = 1;
        } else {
            $selected_period = $_POST['period'];
            $selected_dept = $_POST['id'];
        }


        $sql = "select concat(hs_hr_employee.emp_lastname,', ',emp_firstname) as name ,evaluators_map.* from evaluators_map
join hs_hr_employee on hs_hr_employee.emp_number = employee_id
where evaluation_period_id = $selected_period and emp_department_code = $selected_dept
order by emp_lastname,evaluation_type,emp_to_evaluate
		";

        $result = Yii::app()->db->createCommand($sql)->query();


        $this->render('map', array(
            'selected_period' => $selected_period,
            'selected_dept' => $selected_dept, 'result' => $result,
        ));
    }

    public function actionSummary() {

        if (!isset($_POST['submit'])) {
            $selected_period = 0;
            $selected_type = 1;
        } else {
            $selected_period = $_POST['period'];
            $selected_type = $_POST['etype'];
        }

        $data_provider = new CActiveDataProvider('EvaluatorsMap', array(
            'criteria' => array(
                'select' => 'avg(rating) as aveRate,count(rating) as totalEvaluator, t.*',
                'with' => 'empToEvaluate',
                'condition' => 'evaluation_period_id=:period and evaluation_type=:type',
                'group' => 'emp_to_evaluate',
                'order' => 'emp_department_code,emp_lastname',
                'params' => array(':type' => $selected_type, ':period' => $selected_period),
            ), 'pagination' => array(
                'pageSize' => 500,
            ),
        ));


        $this->render('summary', array(
            'selected_period' => $selected_period,
            'selected_type' => $selected_type, 'data_provider' => $data_provider,
        ));
    }

    public function actionDelete() {
        if (isset($_POST['emap_id'])) {
            $emap_id = $_POST['emap_id'];
            $trow = $_POST['trow'];
        } else {
            $emap_id = 0;
        }

        try {
            EvaluatorsMap::model()->deleteByPk($emap_id);
            echo $emap_id;
        } catch (Exception $e) {
            echo "500";
        }
    }

}

?>