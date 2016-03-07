<?php

/**
 * This is the model class for table "hs_hr_employee".
 *
 * The followings are the available columns in table 'hs_hr_employee':
 * @property integer $emp_number
 * @property string $emp_lastname
 * @property string $emp_firstname
 * @property string $emp_middle_name
 * @property string $emp_nick_name
 * @property string $emp_birthday
 * @property string $emp_gender
 * @property string $emp_marital_status
 * @property string $emp_sss_num
 * @property string $emp_gsis_num
 * @property string $emp_philhealth_num
 * @property string $emp_peraa_num
 * @property string $emp_hdmf_num
 * @property string $emp_unified_num
 * @property string $emp_tin_num
 * @property string $emp_status
 * @property string $emp_smartcard_num
 * @property string $job_title_code
 * @property string $eeo_cat_code

 * @property string $emp_address
 * @property string $emp_address_current
 * @property string $emp_town
 * @property string $emp_province
 * @property integer $emp_department_code
 * @property string $emp_hm_telephone
 * @property string $emp_mobile
 * @property string $emp_work_telephone
 * @property string $emp_work_email
 * @property string $sal_grd_code
 * @property string $joined_date
 * @property string $emp_oth_email
 * @property string $emp_end_of_contract
 * @property string $terminated_date
 * @property string $termination_reason
 * @property string $isActive
 * @property string $lastEdited
 * @property string $lastEditBy
 */
class Employee extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Employee the static model class
     */
    //public $image;
    
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hs_hr_employee';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('emp_number,emp_lastname,emp_firstname,emp_supervisor', 'required'),
            array('emp_number','unique'),
            array('emp_number,emp_supervisor, emp_department_code', 'numerical', 'integerOnly' => true),
            array('emp_lastname, emp_firstname, emp_middle_name, emp_nick_name, emp_sss_num, emp_gsis_num, emp_address, emp_address_current, emp_town, emp_province', 'length', 'max' => 100),
            array('emp_gender', 'length', 'max' => 6),
            array('emp_marital_status, emp_philhealth_num, emp_peraa_num, emp_hdmf_num, emp_unified_num, emp_tin_num, emp_smartcard_num', 'length', 'max' => 20),
            array('emp_status, emp_position_code', 'length', 'max' => 13),
            array('emp_hm_telephone, emp_mobile, emp_work_telephone, lastEditBy', 'length', 'max' => 50),
            array('termination_reason', 'length', 'max' => 256),
            array('isActive', 'length', 'max' => 1),
            array('emp_work_email,emp_oth_email',  'email'),
            array('picture', 'file','types'=>'jpg, gif, png','allowEmpty'=>true),
            array('emp_birthday, joined_date, emp_end_of_contract, terminated_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('picture,emp_number, emp_lastname, emp_firstname, emp_middle_name, emp_nick_name, emp_birthday, emp_gender, emp_marital_status, emp_sss_num, emp_gsis_num, emp_philhealth_num, emp_peraa_num, emp_hdmf_num, emp_unified_num, emp_tin_num, emp_status, emp_smartcard_num,  emp_position_code, work_station, emp_address, emp_address_current, emp_town, emp_province, emp_department_code, emp_hm_telephone, emp_mobile, emp_work_telephone, emp_work_email,  joined_date, emp_oth_email, emp_end_of_contract, terminated_date, termination_reason, isActive, lastEdited, lastEditBy', 'safe', 'on' => 'search'),
        );
    }

   /**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'departments' => array(self::BELONGS_TO, 'Department', 'supervisor'),
			'department' => array(self::BELONGS_TO, 'Department', 'emp_department_code'),
			'empAffiliations' => array(self::HAS_MANY, 'EmpAffiliation', 'emp_number'),
			'empAttachments' => array(self::HAS_MANY, 'EmpAttachment', 'emp_number'),
			'empDependents' => array(self::HAS_MANY, 'EmpDependents', 'emp_number'),
			'empEducations' => array(self::HAS_MANY, 'EmpEducation', 'emp_number'),
			'empEmergencyContacts' => array(self::HAS_MANY, 'EmpEmergencyContacts', 'emp_number'),
			'empLeaveCredits' => array(self::HAS_MANY, 'EmpLeaveCredits', 'emp_number'),
			'empLeaves' => array(self::HAS_MANY, 'EmpLeaves', 'emp_number'),
			'empLeaves1' => array(self::HAS_MANY, 'EmpLeaves', 'head1'),
			'empLeaves2' => array(self::HAS_MANY, 'EmpLeaves', 'head2'),
			'empLicenses' => array(self::HAS_MANY, 'EmpLicenses', 'emp_number'),
			//'empPicture' => array(self::HAS_ONE, 'EmpPicture', 'emp_number'),
			'empSchedules' => array(self::HAS_MANY, 'EmpSchedule', 'emp_number'),
			'empTrainings' => array(self::HAS_MANY, 'EmpTrainings', 'emp_number'),
			'empWorkExperiences' => array(self::HAS_MANY, 'EmpWorkExperience', 'emp_number'),
			'empStatus' => array(self::BELONGS_TO, 'Empstat', 'emp_status'),
			'empPosition' => array(self::BELONGS_TO, 'Position', 'emp_position_code'),
                        'empEvaluation'=> array(self::HAS_MANY,'Evaluation','emp_number'),
                        
                       
			'hsHrWorkshifts' => array(self::MANY_MANY, 'Workshift', 'hs_hr_employee_workshift(emp_number, workshift_id)'),
		);
	}
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'emp_supervisor'=>'Supervisor',
            'emp_number' => 'Employee Number',
            'emp_lastname' => 'Lastname',
            'emp_firstname' => 'Firstname',
            'emp_middle_name' => 'Middle Name',
            'emp_nick_name' => 'Nick Name',
            'emp_birthday' => 'Birthday',
            'emp_gender' => 'Gender',
            'emp_marital_status' => 'Marital Status',
            'emp_sss_num' => 'SSS Number',
            'emp_gsis_num' => 'GSIS Number',
            'emp_philhealth_num' => 'Philhealth Number',
            'emp_peraa_num' => 'PERAA Number',
            'emp_hdmf_num' => 'PAG-IBIG Number',
            'emp_unified_num' => 'Unified Number',
            'emp_tin_num' => 'TIN Number',
            'emp_status' => 'Status',
            'emp_smartcard_num' => 'Smartcard Number',
            'emp_positon_code' => 'Position',
            'emp_address' => 'Address',
            'emp_address_current' => 'Current Address',
            'emp_town' => 'Town',
            'emp_province' => 'Province',
            'emp_department_code' => 'Department',
            'emp_hm_telephone' => 'Home Phone',
            'emp_mobile' => 'Mobile Phone',
            'emp_work_telephone' => 'Work Phone',
            'emp_work_email' => 'Work Email',
            'sal_grd_code' => 'Salary Grade Code',
            'joined_date' => 'Date Joined',
            'emp_oth_email' => 'Other Email',
            'emp_end_of_contract' => 'End Of Contract',
            'terminated_date' => 'Date Terminated ',
            'termination_reason' => 'Termination Reason',
            'isActive' => 'Is Active',
            'lastEdited' => 'Last Edited',
            'lastEditBy' => 'Last Edit By',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('emp_number', $this->emp_number);
        $criteria->compare('emp_lastname', $this->emp_lastname, true);
        $criteria->compare('emp_firstname', $this->emp_firstname, true);
        $criteria->compare('emp_middle_name', $this->emp_middle_name, true);
        $criteria->compare('emp_nick_name', $this->emp_nick_name, true);
        $criteria->compare('emp_birthday', $this->emp_birthday, true);
        $criteria->compare('emp_gender', $this->emp_gender, true);
        $criteria->compare('emp_marital_status', $this->emp_marital_status, true);
        $criteria->compare('emp_sss_num', $this->emp_sss_num, true);
        $criteria->compare('emp_gsis_num', $this->emp_gsis_num, true);
        $criteria->compare('emp_philhealth_num', $this->emp_philhealth_num, true);
        $criteria->compare('emp_peraa_num', $this->emp_peraa_num, true);
        $criteria->compare('emp_hdmf_num', $this->emp_hdmf_num, true);
        $criteria->compare('emp_unified_num', $this->emp_unified_num, true);
        $criteria->compare('emp_tin_num', $this->emp_tin_num, true);
        $criteria->compare('emp_status', $this->emp_status, true);
        $criteria->compare('emp_smartcard_num', $this->emp_smartcard_num, true);
        $criteria->compare('emp_position_code', $this->emp_position_code, true);
        $criteria->compare('emp_address', $this->emp_address, true);
        $criteria->compare('emp_address_current', $this->emp_address_current, true);
        $criteria->compare('emp_town', $this->emp_town, true);
        $criteria->compare('emp_province', $this->emp_province, true);
        $criteria->compare('emp_department_code', $this->emp_department_code);
        $criteria->compare('emp_hm_telephone', $this->emp_hm_telephone, true);
        $criteria->compare('emp_mobile', $this->emp_mobile, true);
        $criteria->compare('emp_work_telephone', $this->emp_work_telephone, true);
        $criteria->compare('emp_work_email', $this->emp_work_email, true);
        $criteria->compare('sal_grd_code', $this->sal_grd_code, true);
        $criteria->compare('joined_date', $this->joined_date, true);
        $criteria->compare('emp_oth_email', $this->emp_oth_email, true);
        $criteria->compare('emp_end_of_contract', $this->emp_end_of_contract, true);
        $criteria->compare('terminated_date', $this->terminated_date, true);
        $criteria->compare('termination_reason', $this->termination_reason, true);
        $criteria->compare('isActive', $this->isActive, true);
        $criteria->compare('lastEdited', $this->lastEdited, true);
        $criteria->compare('lastEditBy', $this->lastEditBy, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getFullname() {

        return $this->emp_lastname . ', ' . $this->emp_firstname;
    }
    
       public function getEmployees() {
         return $list = CHtml::listData($this->model()->findAll(array(
             'order' => 'emp_lastname',
             'condition'=>'isActive=:isActive',
             'params'=>array(':isActive'=>'Y'),
                    )),'emp_number','fullname');

       
    }
    
    public function getDepartmentHead($dept_id) {
    	$connection = Yii::app()->db;
    	$sql = "select emp_number,emp_supervisor from hs_hr_employee
    			where isActive='Y' and
    			emp_supervisor not in (select emp_number from hs_hr_employee where emp_department_code =". $dept_id." )
    			and
    			emp_department_code =". $dept_id;
    
    
    	$t = $connection->createCommand($sql)->queryRow();
    	return $t;
    }
    
    public function getActiveEmployeesPerDepartmentWithoutHead($dept_id) {
    	$connection = Yii::app()->db;
    	$sql = "select emp_number,emp_supervisor from hs_hr_employee 
    			where isActive='Y' and 
                        emp_number not in ( 	select supervisor from hs_hr_department where id =".$dept_id.")
    			and
    			emp_department_code =". $dept_id;
 
    	$t = $connection->createCommand($sql)->queryAll();
    	return $t;
    }
     public function getEmployeeHeads() {
         return $list = CHtml::listData($this->model()->with('empPosition')->findAll(array(
             'order' => 'emp_lastname',
             'condition'=>'isActive=:isActive and position_category=:position_category',
             'params'=>array(':isActive'=>'Y','position_category'=>'head'),
                    )),'emp_number','fullname');

       
    }
    public function getGroupedEmployees() {
    	$connection = Yii::app()->db;
    	$sql = "select hs_hr_employee.emp_number ,concat(hs_hr_employee.emp_lastname,', ',hs_hr_employee.emp_firstname) as name, hs_hr_department.shortname as 'group' from hs_hr_department
inner join hs_hr_employee
on hs_hr_employee.emp_department_code = hs_hr_department.id
where hs_hr_employee.isActive = 'Y'
order by hs_hr_department.shortname,name asc";
    
    	$t = $connection->createCommand($sql)->queryAll();
    	return $t;
    }

}