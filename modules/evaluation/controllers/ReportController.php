<?php

class ReportController extends Controller {

    public $desriptive_rating = array(
        '1.00-1.79' => 'Poor',
        '1.80-2.59' => 'Unsatisfactory',
        '2.60-3.59' => 'Satisfactory',
        '3.60-4.39' => 'Very Satisfactory',
        '4.40-5.00' => 'Outstanding',
    );

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
         
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('total', 'create', 'update', 'head_result', 'head_result1', 'head_result2',
                    'faculty_result', 'faculty_result1', 'faculty_result2', 'faculty_result3',
                    'staff_result', 'staff_result1', 'staff_result2', 'contractual_result', 'per_employee',
                    'employee_summary', 'evalstat', 'evalStatDetail', 'staff_py', 'faculty_py',
                    'uploadStudentEval'),
                'roles' => array('admin', 'hrstaff'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'roles' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionUploadStudentEval() {
        
        
        $period = EvaluationPeriod::model()->findAll(array(
            'select' => 'sy',
            'distinct' => true,
        ));
        $sylist = CHtml::listData($period, 'sy', 'sy');

        if (isset($_POST['sem'])) {
            $sy = $_POST['sy'];
            $semester = $_POST['sem'];
        } else {
            $sy = '2011-2012';
            $semester = '1st';
        }


       if ($semester == '1st')
            $sem = '1-Sem';
        else
            $sem = '2-Sem';


        $dataProvider = new CActiveDataProvider('StudentEvaluationSummary', array(
            'criteria' => array(
                'condition' => '(term=:sem and SchoolYear=:sy)',
                'params' => array(':sem' => $sem, ':sy' => $sy),
                'order' => 'employeeID',
            ),
            'pagination' => array(
                'pageSize' => 200,
            ),
        ));
     
        if (count($dataProvider->getData()) > 0) {
            $sql = "insert into facultybstudent_evaluation(fse_id,emp_number,sem,sy,total,date) values ";

            foreach ($dataProvider->getData() as $evaluation) {
                $uid = uniqid();
              
                if ($evaluation->Term == '1-Sem')
                    $term = '1st';
               else
                    $term = '2nd';
                $sql .= "('$uid','$evaluation->EmployeeID','$term','$evaluation->SchoolYear',$evaluation->Total,'$evaluation->Date'),";
               
                
            }
             $sql = substr($sql, 0,  strlen($sql)-1);
        } else {
            $sql = null;
        }

      

        
        if (isset($_POST['btnUploadStudent'])) {
            $sqli = $_POST['sql'];
            $sy = $_POST['sy'];
            $sem = $_POST['sem'];
            if ($sqli != null) {
                   $connection = Yii::app()->db;   
                   
                   //overwrite evaluation
                 //   $sqlDelete = "delete from facultybstudent_evaluation where sem = '$sem' and sy =  '$sy'";
                 //   $command = $connection->createCommand($sqlDelete);
                 //   $rowDeleted = $command->execute();
                  // echo $sqli;
               
                  $command = $connection->createCommand($sqli);
                   $rowCount = $command->execute(); 
                
               Yii::app()->user->setFlash('success', '<strong>Well done!</strong> rows deleted. ' .$rowCount .' Student Evaluation Uploaded...');
              
            }
        }


        $this->render('uploadStudentEval', array('dataProvider' => $dataProvider,
            'sylist' => $sylist,
            'semester' => $semester,
            'sy' => $sy,
            'sql' => $sql));
        
       
        
    }

    public function actionHead_result() {
        $this->layout = '//layouts/column1';
        if (isset($_POST['btnSearch'])) {
            $sy = $_POST['sy'];
            $sem = $_POST['sem'];
        } else {
            $sy = '2011-2012';
            $sem = '1st';
        }
        $sql = "SELECT  CONCAT(emp_lastname, ', ',emp_firstname) AS name, 
                AVG(head_evaluation.total) AS head, 
                AVG(headbsubordinate_evaluation.total) AS subordinate 
                FROM hs_hr_employee 
                LEFT JOIN head_evaluation ON hs_hr_employee.emp_number=head_evaluation.emp_number AND head_evaluation.sy='$sy' AND head_evaluation.sem='$sem' 
                LEFT JOIN headbsubordinate_evaluation ON hs_hr_employee.emp_number=headbsubordinate_evaluation.emp_number AND headbsubordinate_evaluation.sy='$sy' AND headbsubordinate_evaluation.sem='$sem'
                LEFT JOIN hs_hr_position ON  hs_hr_employee.emp_position_code=hs_hr_position.position_code
                WHERE isActive='Y' AND position_category='head'
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
        $this->render('head_result', array('dataProvider' => $dataProvider, 'sylist' => $sylist, 'sy' => $sy, 'sem' => $sem));
    }

    public function actionHead_result1() {
        $this->layout = '//layouts/column1';
        if (isset($_POST['btnSearch'])) {
            $sy = $_POST['sy'];
            $sem = $_POST['sem'];
        } else {
            $sy = '2011-2012';
            $sem = '1st';
        }
        $sql = "SELECT  CONCAT(emp_lastname, ', ',emp_firstname) AS name, 
              AVG(head_evaluation.total) AS head
              FROM hs_hr_employee 
              LEFT JOIN head_evaluation ON head_evaluation.emp_number=hs_hr_employee.emp_number  AND head_evaluation.sy='$sy' AND head_evaluation.sem='$sem'
              LEFT JOIN hs_hr_position ON  hs_hr_employee.emp_position_code=hs_hr_position.position_code 
              WHERE position_category='head' AND isActive='Y'
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
        $this->render('head_result1', array('dataProvider' => $dataProvider, 'sylist' => $sylist, 'sy' => $sy, 'sem' => $sem, 'dr' => $this->desriptive_rating));
    }

    public function actionHead_result2() {
        $this->layout = '//layouts/column1';
        if (isset($_POST['btnSearch'])) {
            $sy = $_POST['sy'];
            $sem = $_POST['sem'];
        } else {
            $sy = '2011-2012';
            $sem = '1st';
        }
        $sql = "SELECT  CONCAT(emp_lastname, ', ',emp_firstname) AS name, 
              AVG(headbsubordinate_evaluation.total) AS subordinate,
              COUNT(headbsubordinate_evaluation.total) AS num
              FROM hs_hr_employee 
              LEFT JOIN headbsubordinate_evaluation ON headbsubordinate_evaluation.emp_number=hs_hr_employee.emp_number  AND headbsubordinate_evaluation.sy='$sy' AND headbsubordinate_evaluation.sem='$sem'
              LEFT JOIN hs_hr_position ON  hs_hr_employee.emp_position_code=hs_hr_position.position_code 
              WHERE position_category='head' AND isActive='Y'
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
        $this->render('head_result2', array('dataProvider' => $dataProvider, 'sylist' => $sylist, 'sy' => $sy, 'sem' => $sem, 'dr' => $this->desriptive_rating));
    }

    public function actionFaculty_result() {
        $this->layout = '//layouts/column2';

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
        } elseif (isset($_GET['sy'])) {
            $sy = $_GET['sy'];
            $sem = $_GET['sem'];
        } else {
            $sy = '';
            $sem = '';
        }
        $having = "";
        if (isset($_POST['print'])) {
            $having = " HAVING student > 0";
        } elseif (isset($_GET['print'])) {
            $having = "HAVING student IS NULL";
        }
        $sql = "SELECT  CONCAT(emp_lAStname, ', ',emp_firstname) AS name, 
                AVG(facultybhead_evaluation.total) AS head, 
                AVG(peer_evaluation.total) AS peer, 
                AVG(facultybstudent_evaluation.total) AS student   
                FROM hs_hr_employee 
                LEFT JOIN facultybhead_evaluation ON hs_hr_employee.emp_number=facultybhead_evaluation.emp_number AND facultybhead_evaluation.sem='$sem' AND  facultybhead_evaluation.sy='$sy'  
                LEFT JOIN peer_evaluation ON hs_hr_employee.emp_number=peer_evaluation.emp_number AND peer_evaluation.sem='$sem' AND  peer_evaluation.sy='$sy' 
                LEFT JOIN facultybstudent_evaluation ON facultybstudent_evaluation.emp_number=hs_hr_employee.emp_number AND facultybstudent_evaluation.sem='$sem' AND  facultybstudent_evaluation.sy='$sy' 
                LEFT JOIN hs_hr_position ON  hs_hr_employee.emp_position_code=hs_hr_position.position_code 
                WHERE emp_department_code=$id AND isActive='Y' AND position_category='faculty'
                GROUP BY name $having ORDER BY name";
    

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
        if (isset($_POST['print'])) {
            $this->render('//pdf/DeptSumPerSemFac', array('departments' => $departments, 'dataProvider' => $dataProvider, 'sylist' => $sylist, 'sy' => $sy, 'sem' => $sem, 'dr' => $this->desriptive_rating, 'deptname' => $deptname));
        } elseif (isset($_GET['print'])) {
            $this->render('//pdf/DeptSumPerSemFac2', array('departments' => $departments, 'dataProvider' => $dataProvider, 'sylist' => $sylist, 'sy' => $sy, 'sem' => $sem, 'dr' => $this->desriptive_rating, 'deptname' => $deptname));
        } else {
            $this->render('faculty_result', array('departments' => $departments, 'dataProvider' => $dataProvider, 'sylist' => $sylist, 'sy' => $sy, 'sem' => $sem, 'dr' => $this->desriptive_rating, 'deptname' => $deptname, 'id' => $id));
        }
    }

    public function actionFaculty_result1() { //by head
        $this->layout = '//layouts/column2';

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

    public function actionFaculty_result2() { //by peers
        $this->layout = '//layouts/column2';

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
                AVG(peer_evaluation.total) AS peer,
                COUNT(peer_evaluation.pe_id) as num
                FROM hs_hr_employee 
                LEFT JOIN peer_evaluation ON hs_hr_employee.emp_number=peer_evaluation.emp_number AND peer_evaluation.sem='$sem' AND peer_evaluation.sy='$sy' 
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
        $this->render('faculty_result2', array('departments' => $departments, 'dataProvider' => $dataProvider, 'sylist' => $sylist, 'sy' => $sy, 'sem' => $sem, 'dr' => $this->desriptive_rating, 'deptname' => $deptname));
    }

    public function actionFaculty_result3() {
        $this->layout = '//layouts/column2';

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
                AVG(facultybstudent_evaluation.total) AS student,
                COUNT(facultybstudent_evaluation.fse_id) as num
                FROM hs_hr_employee 
                LEFT JOIN facultybstudent_evaluation ON hs_hr_employee.emp_number=facultybstudent_evaluation.emp_number AND facultybstudent_evaluation.sem='$sem' AND facultybstudent_evaluation.sy='$sy' 
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
        $this->render('faculty_result3', array('departments' => $departments, 'dataProvider' => $dataProvider, 'sylist' => $sylist, 'sy' => $sy, 'sem' => $sem, 'dr' => $this->desriptive_rating, 'deptname' => $deptname));
    }

    public function actionStaff_result() {
        $this->layout = '//layouts/column2';
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
        $sql = "SELECT  CONCAT(emp_lastname, ', ',emp_firstname) AS name, 
                AVG(nonteachingbhead_evaluation.total) AS head, 
                AVG(peer_evaluation.total) AS peer
                FROM hs_hr_employee 
                LEFT JOIN nonteachingbhead_evaluation ON hs_hr_employee.emp_number=nonteachingbhead_evaluation.emp_number  AND nonteachingbhead_evaluation.sy='$sy' AND nonteachingbhead_evaluation.sem='$sem'
                LEFT JOIN peer_evaluation ON hs_hr_employee.emp_number=peer_evaluation.emp_number AND peer_evaluation.sy='$sy' AND peer_evaluation.sem='$sem'
                LEFT JOIN hs_hr_position ON  hs_hr_employee.emp_position_code=hs_hr_position.position_code
                LEFT JOIN hs_hr_empstat ON hs_hr_employee.emp_status=hs_hr_empstat.estat_code 
                WHERE position_category='staff' AND estat_name='Regular' AND isActive='Y' AND emp_department_code=$id
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
        if (isset($_POST['print'])) {
            $this->render('//pdf/DeptSumPerSem', array('departments' => $departments, 'dataProvider' => $dataProvider, 'sy' => $sy, 'sem' => $sem, 'dr' => $this->desriptive_rating, 'deptname' => $deptname));
        } else {
            $this->render('staff_result', array('departments' => $departments, 'dataProvider' => $dataProvider, 'sylist' => $sylist, 'sy' => $sy, 'sem' => $sem, 'dr' => $this->desriptive_rating, 'deptname' => $deptname));
        }
    }

    public function actionStaff_result1() {
        $this->layout = '//layouts/column2';
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
        $sql = "SELECT  CONCAT(emp_lastname, ', ',emp_firstname) AS name, 
                AVG(nonteachingbhead_evaluation.total) AS head
                FROM hs_hr_employee 
                LEFT JOIN nonteachingbhead_evaluation ON hs_hr_employee.emp_number=nonteachingbhead_evaluation.emp_number  AND nonteachingbhead_evaluation.sy='$sy' AND nonteachingbhead_evaluation.sem='$sem'
                LEFT JOIN hs_hr_position ON  hs_hr_employee.emp_position_code=hs_hr_position.position_code
                LEFT JOIN hs_hr_empstat ON hs_hr_employee.emp_status=hs_hr_empstat.estat_code 
                WHERE position_category='staff' AND estat_name='Regular' AND isActive='Y' AND emp_department_code=$id
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
        $this->render('staff_result1', array('departments' => $departments, 'dataProvider' => $dataProvider, 'sylist' => $sylist, 'sy' => $sy, 'sem' => $sem, 'dr' => $this->desriptive_rating, 'deptname' => $deptname));
    }

    public function actionStaff_result2() {
        $this->layout = '//layouts/column2';
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
        $sql = "SELECT  CONCAT(emp_lastname, ', ',emp_firstname) AS name, 
                AVG(peer_evaluation.total) AS peer,
                COUNT(pe_id) AS num
                FROM hs_hr_employee 
                LEFT JOIN peer_evaluation ON hs_hr_employee.emp_number=peer_evaluation.emp_number AND peer_evaluation.sy='$sy' AND peer_evaluation.sem='$sem'
                LEFT JOIN hs_hr_position ON  hs_hr_employee.emp_position_code=hs_hr_position.position_code
                LEFT JOIN hs_hr_empstat ON hs_hr_employee.emp_status=hs_hr_empstat.estat_code 
                WHERE position_category='staff' AND estat_name='Regular' AND isActive='Y' AND emp_department_code=$id
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
        $this->render('staff_result2', array('departments' => $departments, 'dataProvider' => $dataProvider, 'sylist' => $sylist, 'sy' => $sy, 'sem' => $sem, 'dr' => $this->desriptive_rating, 'deptname' => $deptname));
    }

    public function actionContractual_result() {
        $this->layout = '//layouts/column2';
        $departments = Department::model()->findAll(array('order' => 'shortname'));
        $id = 0;
        $deptname = "Select department.";
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $deptname = Department::model()->findByPk($id)->name;
        }
        if (isset($_POST['btnSearch'])) {
            $sy = $_POST['sy'];
            $sem = $_POST['sem'];
        } else {
            $sy = '2011-2012';
            $sem = '1st';
        }
        $sql = "SELECT  CONCAT(emp_lastname, ', ',emp_firstname) AS name, 
                AVG(contractualbnonteaching_evaluation.total) AS head
                FROM hs_hr_employee 
                LEFT JOIN contractualbnonteaching_evaluation ON hs_hr_employee.emp_number=contractualbnonteaching_evaluation.emp_number AND contractualbnonteaching_evaluation.sy='$sy' AND contractualbnonteaching_evaluation.sem='$sem'
                LEFT JOIN hs_hr_position ON  hs_hr_employee.emp_position_code=hs_hr_position.position_code
                LEFT JOIN hs_hr_empstat ON hs_hr_employee.emp_status=hs_hr_empstat.estat_code 
                WHERE position_category='staff' AND estat_name != 'Regular' AND isActive='Y' AND emp_department_code=$id
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
        if (isset($_POST['print'])) {
            $this->render('//pdf/DeptSumPerSem', array('departments' => $departments, 'dataProvider' => $dataProvider, 'sylist' => $sylist, 'sy' => $sy, 'sem' => $sem, 'dr' => $this->desriptive_rating, 'deptname' => $deptname));
        } else {
            $this->render('contractual_result', array('departments' => $departments, 'dataProvider' => $dataProvider, 'sylist' => $sylist, 'sy' => $sy, 'sem' => $sem, 'dr' => $this->desriptive_rating, 'deptname' => $deptname));
        }
    }

    public function actionPer_employee() {
        $this->layout = "//layouts/column2";
        $departments = Department::model()->findAll(array('order' => 'shortname'));
        $id = 0;
        $deptname = "Select department.";
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $deptname = Department::model()->findByPk($id)->name;
        }

        $sql = "SELECT emp_number,CONCAT(emp_lastname, ', ',emp_firstname) AS name
                FROM hs_hr_employee 
                Where isActive='Y' AND emp_department_code=$id
                GROUP BY name ORDER BY name";
        $dataProvider = new CSqlDataProvider($sql, array(
            'keyField' => 'name',
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
        /* $model = new Employee('search');
          $model->unsetAttributes();  // clear any default values
          if (isset($_GET['Employee']))
          $model->attributes = $_GET['Employee'];
         */
        $this->render('employee_list', array(
            'dataProvider' => $dataProvider,
            'departments' => $departments,
            'deptcode' => $id,
        ));
    }

    public function actionEvalstat() {
        $this->layout = "//layouts/column2";
        $departments = Department::model()->findAll(array('order' => 'shortname'));
        $id = 0;
        $deptname = "Select department.";
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $deptname = Department::model()->findByPk($id)->name;
        }

        //school year and sem
        if (isset($_POST['sy'])) {
            $sy = $_POST['sy'];
            $sem = $_POST['sem'];
        } else {
            $sy = '2011-2012';
            $sem = '1st';
        }
        $period = EvaluationPeriod::model()->findAll(array(
            'select' => 'sy',
            'distinct' => true,
        ));
        $sylist = CHtml::listData($period, 'sy', 'sy');
        //......

        $sql = "SELECT hs_hr_employee.emp_number,CONCAT(emp_lastname, ', ',emp_firstname) AS name, 
                COUNT(peer_evaluation.pe_id) as num
                FROM hs_hr_employee 
                LEFT JOIN peer_evaluation ON hs_hr_employee.emp_number=peer_evaluation.emp_number AND peer_evaluation.sem='$sem' AND peer_evaluation.sy='$sy' 
                LEFT JOIN hs_hr_position ON  hs_hr_employee.emp_position_code=hs_hr_position.position_code 
                WHERE isActive='Y' AND emp_department_code=$id
                GROUP BY name ORDER BY name";
        $dataProvider = new CSqlDataProvider($sql, array(
            'keyField' => 'name',
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));

        $this->render('evalstat', array(
            'dataProvider' => $dataProvider,
            'departments' => $departments,
            'sylist' => $sylist,
            'sy' => $sy,
            'sem' => $sem,
            'deptname' => $deptname,
        ));
    }

    public function actionTotal() {
        $this->layout = "//layouts/column2";
        $departments = Department::model()->findAll(array('order' => 'shortname'));
        $id = 0;
        $deptname = "Select department.";
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $deptname = Department::model()->findByPk($id)->name;
        }

        //school year and sem
        if (isset($_POST['sy'])) {
            $sy = $_POST['sy'];
            $sem = $_POST['sem'];
        } else {
            $sy = '2011-2012';
            $sem = '1st';
        }
        $period = EvaluationPeriod::model()->findAll(array(
            'select' => 'sy',
            'distinct' => true,
        ));
        $sylist = CHtml::listData($period, 'sy', 'sy');
        //......

        /*  $sql = "SELECT hs_hr_employee.emp_number,CONCAT(emp_lastname, ', ',emp_firstname) AS name, 
          COUNT(peer_evaluation.pe_id) as num
          FROM hs_hr_employee
          LEFT JOIN peer_evaluation ON hs_hr_employee.emp_number=peer_evaluation.emp_number AND peer_evaluation.sem='$sem' AND peer_evaluation.sy='$sy'
          LEFT JOIN hs_hr_position ON  hs_hr_employee.emp_position_code=hs_hr_position.position_code
          WHERE isActive='Y' AND emp_department_code=$id
          GROUP BY name ORDER BY name";
         * */
        $sql = "select concat(hs_hr_employee.emp_lastname,', ',hs_hr_employee.emp_firstname) as name,count(peer_evaluation.emp_number) as total ,sem, sy
                from peer_evaluation
                inner join hs_hr_employee on peer_evaluation.evaluatedby = hs_hr_employee.emp_number
                where  sem = '$sem' and sy ='$sy' AND emp_department_code=$id
                group by peer_evaluation.evaluatedby
                order by name
             ";

        $dataProvider = new CSqlDataProvider($sql, array(
            'keyField' => 'name',
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));

        $this->render('total', array(
            'dataProvider' => $dataProvider,
            'departments' => $departments,
            'sylist' => $sylist,
            'sy' => $sy,
            'sem' => $sem,
            'deptname' => $deptname,
        ));
    }

    public function actionEvalStatDetail() {
        $this->layout = "//layouts/blank";
        if (isset($_POST['emp_number'])) {
            $emp_number = $_POST['emp_number'];
            $sy = $_POST['sy'];
            $sem = $_POST['sem'];
            $deptno = $_POST['id'];
        }

        $sql = "SELECT hs_hr_employee.emp_number,CONCAT(emp_lastname, ', ',emp_firstname) AS name, 
               IF(peer_evaluation.evaluatedby IS NULL,'not_done','done') as stat
               FROM hs_hr_employee 
               LEFT JOIN peer_evaluation ON hs_hr_employee.emp_number=peer_evaluation.evaluatedby AND peer_evaluation.sem='$sem' AND peer_evaluation.sy='$sy' AND peer_evaluation.emp_number=$emp_number
               LEFT JOIN hs_hr_position ON  hs_hr_employee.emp_position_code=hs_hr_position.position_code 
               WHERE isActive='Y' AND emp_department_code=$deptno AND hs_hr_employee.emp_number != $emp_number
               GROUP BY NAME ORDER BY name";
        $dataProvider = new CSqlDataProvider($sql, array(
            'keyField' => 'name',
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));

        $this->render('evalstat_detail', array(
            'dataProvider' => $dataProvider,
            'emp_number' => $emp_number,
        ));
    }

    public function actionEmployee_summary($id, $dept) {
        $empNumber = $id;
        $emp = Employee::model()->findByPk($empNumber); //get attributes
        $position = Position::model()->findByPk($emp->emp_position_code); //get position
        $type = $position->position_category;
        $status = $emp->emp_status;

        $sy = '2011-2012';
        $sem = '1st';
        //GET School Year and Semester
        if (isset($_POST['sy'])) {
            $sy = $_POST['sy'];
            $sem = $_POST['sem'];
        }

        //Generate dataProvider
        if ($type == 'faculty') {
            $sql = "SELECT  
                peer_evaluators, peer_average, head_evaluators, head_average, stud_evaluators, stud_average 
                FROM 
                (SELECT count(total) as peer_evaluators ,avg(total) as peer_average FROM peer_evaluation WHERE emp_number=$empNumber AND sem='$sem' AND sy='$sy'AND total !=0) AS tbl1,
                (SELECT count(total) as head_evaluators ,avg(total) as head_average FROM facultybhead_evaluation WHERE emp_number=$empNumber AND sem='$sem' AND sy='$sy' AND total !=0) AS tbl2,
                (SELECT count(total) as stud_evaluators ,avg(total) as stud_average FROM facultybstudent_evaluation WHERE emp_number=$empNumber AND sem='$sem' AND sy='$sy' AND total !=0) AS tbl3";
        } elseif ($type == 'head') {
            $sql = "SELECT  
                head_evaluators, head_average, sub_evaluators, sub_average  
                FROM 
                (SELECT count(total) as head_evaluators ,avg(total) as head_average FROM head_evaluation WHERE emp_number=$empNumber AND sem='$sem' AND sy='$sy' AND total !=0) AS tbl1,
                (SELECT count(total) as sub_evaluators ,avg(total) as sub_average FROM headbsubordinate_evaluation WHERE emp_number=$empNumber AND sem='$sem' AND sy='$sy' AND total !=0) AS tbl2";
        } elseif ($type == 'staff') {
            if ($status == 'EST000') {
                $sql = "SELECT  
                peer_evaluators, peer_average, head_evaluators, head_average
                FROM 
                (SELECT count(total) as peer_evaluators ,avg(total) as peer_average FROM peer_evaluation WHERE emp_number=$empNumber AND sem='$sem' AND sy='$sy' AND total !=0) AS tbl1,
                (SELECT count(total) as head_evaluators ,avg(total) as head_average FROM nonteachingbhead_evaluation WHERE emp_number=$empNumber AND sem='$sem' AND sy='$sy' AND total !=0) AS tbl2";
            } else {
                $sql = "SELECT  count(total) AS head_evaluators ,avg(total) AS head_average 
                FROM contractualbnonteaching_evaluation
                WHERE emp_number = $empNumber AND sem='$sem' AND sy='$sy' AND total !=0";
            }
        }



        $dataProvider = new CSqlDataProvider($sql, array(
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));

        //Evaluation Period and School Year   
        $period = EvaluationPeriod::model()->findAll(array(
            'select' => 'sy',
            'distinct' => true,
        ));
        $sylist = CHtml::listData($period, 'sy', 'sy');

        //Render View  
        if (isset($_POST['print'])) {
            if ($_POST['type'] == 'faculty') {
                $head_comment = new CSqlDataProvider("SELECT remarks  FROM facultybhead_evaluation Where remarks != '' AND sy='$sy' AND sem='$sem' AND emp_number=$empNumber");
                $peer_comment = new CSqlDataProvider("SELECT remarks  FROM peer_evaluation Where remarks != '' AND sy='$sy' AND sem='$sem' AND emp_number=$empNumber");
                $stud_comment = new CSqlDataProvider("SELECT remark1, remark2 from facultybstudent_evaluation left join facultybstudent_evaluation_details on facultybstudent_evaluation.fse_id=facultybstudent_evaluation_details.fse_id where remark1!='' and remark2!='' and emp_number=$empNumber AND sy='$sy' AND sem='$sem'");
                if ($_POST['stud'] > 0) {
                    $this->render('//pdf/IndSumPerDeptFac', array('head_comment' => $head_comment, 'peer_comment' => $peer_comment, 'stud_comment' => $stud_comment, 'empNumber' => $empNumber, 'deptname' => $_POST['dept'], 'data' => $dataProvider->getData(), 'sy' => $sy, 'sem' => $sem, 'dr' => $this->desriptive_rating));
                } else {
                    $this->render('//pdf/IndSumPerDeptFac2', array('head_comment' => $head_comment, 'peer_comment' => $peer_comment, 'stud_comment' => $stud_comment, 'empNumber' => $empNumber, 'deptname' => $_POST['dept'], 'data' => $dataProvider->getData(), 'sy' => $sy, 'sem' => $sem, 'dr' => $this->desriptive_rating));
                }
            } else {
                $head_comment = new CSqlDataProvider("SELECT achievements,weakpts, sug_improvements, abilities,remarks from nonteachingbhead_evaluation where sy='$sy' and sem='$sem' and emp_number=$empNumber");
                $peer_comment = new CSqlDataProvider("SELECT remarks  FROM peer_evaluation Where remarks != '' AND sy='$sy' AND sem='$sem' AND emp_number=$empNumber");
                $this->render('//pdf/IndSumPerDeptStaff', array('head_comment' => $head_comment, 'peer_comment' => $peer_comment, 'empNumber' => $empNumber, 'deptname' => $_POST['dept'], 'data' => $dataProvider->getData(), 'sy' => $sy, 'sem' => $sem, 'dr' => $this->desriptive_rating));
            }
        } else {
            $this->render('result', array('empNumber' => $empNumber, 'dataProvider' => $dataProvider, 'type' => $type, 'status' => $status, 'sylist' => $sylist, 'sy' => $sy, 'sem' => $sem, 'deptcode' => $dept));
        }
    }

    public function actionFaculty_py() {
        $this->layout = '//layouts/column2';
        $departments = Department::model()->findAll(array('order' => 'shortname'));
        $id = 0;
        $deptname = "Select department.";
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $deptname = Department::model()->findByPk($id)->name;
        }
        $sy = EvaluationPeriod::model()->findByAttributes(array('status' => 'open'))->sy;

        $sql = "SELECT  t1.empNumber, t1.name,emp_status, head1, peer1, student1, head2, peer2, student2 FROM (SELECT hs_hr_employee.emp_number as empNumber, CONCAT(emp_lAStname, ', ',emp_firstname) AS name, 
                AVG(facultybhead_evaluation.total) AS head1, 
                AVG(peer_evaluation.total) AS peer1, 
                AVG(facultybstudent_evaluation.total) AS student1,
                emp_status 
                FROM hs_hr_employee 
                LEFT JOIN facultybhead_evaluation ON hs_hr_employee.emp_number=facultybhead_evaluation.emp_number AND facultybhead_evaluation.sem='1st' AND  facultybhead_evaluation.sy='$sy'  
                LEFT JOIN peer_evaluation ON hs_hr_employee.emp_number=peer_evaluation.emp_number AND peer_evaluation.sem='1st' AND  peer_evaluation.sy='$sy' 
                LEFT JOIN facultybstudent_evaluation ON facultybstudent_evaluation.emp_number=hs_hr_employee.emp_number AND facultybstudent_evaluation.sem='1st' AND  facultybstudent_evaluation.sy='$sy' 
                LEFT JOIN hs_hr_position ON  hs_hr_employee.emp_position_code=hs_hr_position.position_code 
                WHERE emp_department_code=$id AND isActive='Y' AND position_category='faculty'
                GROUP BY empNumber) as t1 LEFT JOIN
                (SELECT  hs_hr_employee.emp_number as empNumber,
                AVG(facultybhead_evaluation.total) AS head2, 
                AVG(peer_evaluation.total) AS peer2, 
                AVG(facultybstudent_evaluation.total) AS student2   
                FROM hs_hr_employee 
                LEFT JOIN facultybhead_evaluation ON hs_hr_employee.emp_number=facultybhead_evaluation.emp_number AND facultybhead_evaluation.sem='2nd' AND  facultybhead_evaluation.sy='$sy'  
                LEFT JOIN peer_evaluation ON hs_hr_employee.emp_number=peer_evaluation.emp_number AND peer_evaluation.sem='2nd' AND  peer_evaluation.sy='$sy' 
                LEFT JOIN facultybstudent_evaluation ON facultybstudent_evaluation.emp_number=hs_hr_employee.emp_number AND facultybstudent_evaluation.sem='2nd' AND  facultybstudent_evaluation.sy='$sy' 
                LEFT JOIN hs_hr_position ON  hs_hr_employee.emp_position_code=hs_hr_position.position_code 
                WHERE emp_department_code=$id AND isActive='Y' AND position_category='faculty'
                GROUP BY empNumber) as t2
                On t1.empNumber = t2.empNumber
                GROUP BY    t1.empNumber ORDER BY t1.name";

        $dataProvider = new CSqlDataProvider($sql, array(
            'keyField' => 'name',
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));

        if (isset($_POST['print'])) {
            $this->render('//pdf/DeptSumPerYearFac', array('departments' => $departments, 'dataProvider' => $dataProvider, 'sy' => $sy, 'dr' => $this->desriptive_rating, 'deptname' => $deptname));
        } else {
            $this->render('faculty_peryear', array('departments' => $departments, 'dataProvider' => $dataProvider, 'sy' => $sy, 'dr' => $this->desriptive_rating, 'deptname' => $deptname));
        }
    }

    public function actionStaff_py() {
        $this->layout = '//layouts/column2';
        $departments = Department::model()->findAll(array('order' => 'shortname'));
        $id = 0;
        $deptname = "Select department.";
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $deptname = Department::model()->findByPk($id)->name;
        }
        $sy = EvaluationPeriod::model()->findByAttributes(array('status' => 'open'))->sy;

        $sql = "SELECT t1.empNumber, name, head1, peer1, head2, peer2 FROM
                (SELECT hs_hr_employee.emp_number as empNumber, CONCAT(emp_lastname, ', ',emp_firstname) AS name, 
                AVG(nonteachingbhead_evaluation.total) AS head1, 
                AVG(peer_evaluation.total) AS peer1
                FROM hs_hr_employee 
                LEFT JOIN nonteachingbhead_evaluation ON hs_hr_employee.emp_number=nonteachingbhead_evaluation.emp_number  AND nonteachingbhead_evaluation.sy='$sy' AND nonteachingbhead_evaluation.sem='1st'
                LEFT JOIN peer_evaluation ON hs_hr_employee.emp_number=peer_evaluation.emp_number AND peer_evaluation.sy='$sy' AND peer_evaluation.sem='1st'
                LEFT JOIN hs_hr_position ON  hs_hr_employee.emp_position_code=hs_hr_position.position_code
                lEFT JOIN hs_hr_empstat ON hs_hr_employee.emp_status=hs_hr_empstat.estat_code 
                WHERE position_category='staff' AND estat_name='Regular' AND isActive='Y' AND emp_department_code=$id GROUP BY name) AS t1 LEFT JOIN 
                (SELECT hs_hr_employee.emp_number as empNumber, 
                AVG(nonteachingbhead_evaluation.total) AS head2, 
                AVG(peer_evaluation.total) AS peer2
                FROM hs_hr_employee 
                LEFT JOIN nonteachingbhead_evaluation ON hs_hr_employee.emp_number=nonteachingbhead_evaluation.emp_number  AND nonteachingbhead_evaluation.sy='$sy' AND nonteachingbhead_evaluation.sem='2nd'
                LEFT JOIN peer_evaluation ON hs_hr_employee.emp_number=peer_evaluation.emp_number AND peer_evaluation.sy='$sy' AND peer_evaluation.sem='2nd'
                LEFT JOIN hs_hr_position ON  hs_hr_employee.emp_position_code=hs_hr_position.position_code
                lEFT JOIN hs_hr_empstat ON hs_hr_employee.emp_status=hs_hr_empstat.estat_code 
                WHERE position_category='staff' AND estat_name='Regular' AND isActive='Y' AND emp_department_code=$id GROUP BY empNumber) AS t2 ON t1.empNumber=t2.empNumber
                GROUP BY t1.name ORDER BY t1.name";

        $dataProvider = new CSqlDataProvider($sql, array(
            'keyField' => 'name',
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));

        if (isset($_POST['print'])) {
            $this->render('//pdf/DeptSumPerYear', array('departments' => $departments, 'dataProvider' => $dataProvider, 'sy' => $sy, 'dr' => $this->desriptive_rating, 'deptname' => $deptname));
        } else {
            $this->render('staff_peryear', array('departments' => $departments, 'dataProvider' => $dataProvider, 'sy' => $sy, 'dr' => $this->desriptive_rating, 'deptname' => $deptname));
        }
    }

    public function computeStaffYear($head1, $peer1, $head2, $peer2) {
        $total = 0;
        $first = 0;
        $second = 0;
        //1st sem
        if ($head1 > 0 && $peer1 > 0)
            $first = ($head1 * .6) + ($peer1 * .3);
        elseif ($head1 > 0 && $peer1 == 0)
            $first = $head1;
        else
            $first = $peer1;

        //2nd sem
        if ($head2 > 0 && $peer2 > 0)
            $second = ($head2 * .7) + ($peer2 * .3);
        elseif ($head2 > 0 && $peer2 == 0)
            $second = $head2;
        else
            $second = $peer2;

        //total
        if ($first > 0 && $second > 0)
            $total = ($first + $second) / 2;
        elseif ($first > 0 && $second == 0)
            $total = $first;
        else
            $total = $second;

        return array(
            "first" => $first == 0 ? "n/a" : round($first, 2),
            "second" => $second == 0 ? "n/a" : round($second, 2),
            "total" => $total == 0 ? "n/a" : round($total, 2),
        );
    }

    public function computeFacYear($head1, $peer1, $stud1, $head2, $peer2, $stud2) {
        $total = 0;
        $first = 0;
        $second = 0;
        //1st sem
        if ($head1 > 0 && $peer1 > 0 && $stud1 > 0)
            $first = ($head1 * .6) + ($stud1 * .3) + ($peer1 * .1);
        elseif ($head1 > 0 && $peer1 > 0 && $stud1 == 0)
            $first = ($head1 * .7) + ($peer1 * .3);
        elseif ($head1 > 0 && $peer1 == 0 && $stud1 > 0)
            $first = ($head1 * .7) + ($stud1 * .3);
        else
            $first = $head1;


        //2nd sem
        if ($head2 > 0 && $peer2 > 0 && $stud2 > 0)
            $second = ($head2 * .6) + ($stud2 * .3) + ($peer2 * .1);
        elseif ($head2 > 0 && $peer2 > 0 && $stud2 == 0)
            $second = ($head2 * .7) + ($peer2 * .3);
        elseif ($head2 > 0 && $peer2 == 0 && $stud2 > 0)
            $second = ($head2 * .7) + ($stud2 * .3);
        else
            $second = $head2;

        $first = round($first, 2);
        $second = round($second, 2);

        //total
        if ($first > 0 && $second > 0)
            $total = (round($first, 2) + round($second, 2)) / 2;
        elseif ($first > 0 && $second == 0)
            $total = $first;
        else
            $total = $second;

        return array(
            "first" => $first == 0 ? "n/a" : round($first, 2),
            "second" => $second == 0 ? "n/a" : round($second, 2),
            "total" => $total == 0 ? "n/a" : round($total, 2),
        );
    }

}
