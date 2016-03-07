<?php

/**
 * This is the model class for table "hs_hr_emp_leaves".
 *
 * The followings are the available columns in table 'hs_hr_emp_leaves':
 * @property string $leave_id
 * @property integer $leave_type_id
 * @property integer $emp_number
 * @property string $leave_reason
 * @property string $leave_status
 * @property string $leave_days
 * @property integer $leave_approved_by
 * @property string $leave_date_filed
 * @property string $leave_date_created
 * @property string $leave_date_approved
 *
 * The followings are the available model relations:
 * @property Employee $empNumber
 * @property Employee $leaveApprovedBy
 * @property Leavetype $leaveType
 * @property EmpLeavesDetails[] $empLeavesDetails
 */
class EmpLeaves extends CActiveRecord {
	
	public $total = 0;

    /**
     * Returns the static model of the specified AR class.
     * @return EmpLeaves the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hs_hr_emp_leaves';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('leave_id,leave_type, leave_sy, leave_reason,  leave_days,  leave_date_filed, ', 'required'),
            array('emp_number,head1,head2,clinic_head,hr_head', 'numerical', 'integerOnly' => true),
            array('leave_id', 'length', 'max' => 13),
            array('leave_reason', 'length', 'max' => 255),
            array('leave_status', 'length', 'max' => 20),
            array('leave_days','numerical','min'=>0.5 ),
        	array('leave_id','unique'),
        
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('leave_id, leave_type, emp_number, leave_reason, leave_status, leave_days, head1, leave_date_filed, leave_date_approved_by_head1,leave_date_approved_by_head2', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'empNumber' => array(self::BELONGS_TO, 'Employee', 'emp_number'),
            'headx' => array(self::BELONGS_TO, 'Employee', 'head1'),
            'heady' => array(self::BELONGS_TO, 'Employee', 'head2'),
            'head_clinic' => array(self::BELONGS_TO, 'Employee', 'clinic_head'),
            'head_hr' => array(self::BELONGS_TO, 'Employee', 'hr_head'),
            'empLeavesDetails' => array(self::HAS_MANY, 'EmpLeavesDetails', 'leave_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'leave_id' => 'Leave ID',
            'leave_type' => 'Leave Type',
            'emp_number' => 'Employee Number',
            'leave_reason' => 'Reason',
            'leave_status' => 'Status',
            'leave_days' => 'Number of Days',
            'leave_sy' => 'SY',
            'head1' => 'Head/OIC',
            'head2' => 'Director/OIC',
            'clinic_head' => 'Clinic Head',
            'hr_head' => 'HR Head',
            'leave_date_filed' => 'Date Filed',
            'leave_date_created' => 'Date Created',
            'head1_action_date' => 'Head Action Date',
            'head2_action_date' => 'Director Action Date',
            'hr_head_action_date' => 'HR Head Action Date',
            'clinic_head_action_date' => 'Clinic Head Action Date',
            
            'head1_action' => 'Head Action',
            'head2_action' => 'Director Action',
            'clinic_head_action' => 'Clinic Head Action',
            'hr_head_action' => 'HR Head Action',
            'remarks' => 'Remarks',
        );
    }

    public function typeToStr($type) {
        $str = '';
        switch ($type) {
            case 'vlp': $str = 'Vacation Leave with Pay';
                break;
            case 'slp': $str = 'Sick Leave with Pay';
                break;
            case 'elp': $str = 'Emergency Leave with Pay';
                break;
            case 'bl': $str = 'Birthday Leave';
                break;
            case 'pl': $str = 'Paternity Leave';
                break;
            case 'ml': $str = 'Maternity Leave';
                break;
             case 'vl': $str = 'Vacation Leave without Pay';
                break;
            case 'sl': $str = 'Sick Leave without Pay';
                break;
            case 'el': $str = 'Emergency Leave without Pay';
                break;
            case 'cl': $str = 'Christmas Leave with Pay (For Faculty only)';
                break;
            
        
            
            default:$str = 'Vacation Leave with Pay';
                break;
        }
        return $str;
    }

    public function wpToStr($wp) {
        if ($wp == 0)
            return 'No';
        else
            return 'Yes';
    }

    /* public function getTotalLeave($empId,$type) {
      $total = $this->model()->find(array(
      'select'=>'sum(totalDays)',
      'condition'=>'empId=:empId and type=:type',
      'params'=>array(':empId'=>$empId,':type'=>$type)
      ));

      return $total;
      } */

    /*  public function getTotalLeave($empId,$type) {
      $total = $this->model()->findBySql("select sum(totalDays) as total
      from tbl_leave
      where empId=:empId and type=:type",
      array(':empId'=>$empId,':type'=>$type)
      );

      return $total;
      } */

    public function getTotalLeave($empId, $type) {
        return $this->getDbConnection()->createCommand("select sum(totalDays) as total
                                            from tbl_leave
                                            where empId='$empId' and type='$type'")->queryScalar();
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function isUniqueId($id) {
        $rs = $this->getDbConnection()->createCommand("select id from tbl_leave
                                            where id='$id'")->queryScalar();

        return $rs;
    }

    
    public function getVlCommitted( $emp_number,$leave_sy) {
    
    	$criteria = new CDbCriteria();
    	$criteria->alias = 'hs_hr_emp_leaves';
    	$criteria->select = array('sum(leave_days)  as total');
      	$criteria->condition = 'emp_number = :emp_number 
				      		
				      			and leave_sy=:leave_sy
                                and (leave_type = "vlp" or leave_type = "elp") 
      			                and leave_status != "Disapproved"
                                and leave_status != "Approved" ';
    	$criteria->params = array(':emp_number' => $emp_number, ':leave_sy' => $leave_sy);
    	$result = EmpLeaves::model()->find($criteria);
    	if (!is_null($result))
    		return $result->total;
    	else
    		return 0;
    }
    
    
    
      public function getSlCommitted( $emp_number,$leave_sy) {
    
    $criteria = new CDbCriteria();
    $criteria->alias = 'hs_hr_emp_leaves';
    $criteria->select = array('sum(leave_days)  as total');
    $criteria->condition = 'emp_number = :emp_number
    and leave_sy=:leave_sy
    and leave_type = "slp"
    and leave_status != "Disapproved"
    and leave_status != "Approved" ';
    $criteria->params = array(':emp_number' => $emp_number, ':leave_sy' => $leave_sy);
    $result = EmpLeaves::model()->find($criteria);
    if (!is_null($result))
    	return $result->total;
    else
    	return 0;
    } 
    



    public function getOtherCommitted( $emp_number,$leave_sy) {
    
    
    	$criteria = new CDbCriteria();
    	$criteria->alias = 'hs_hr_emp_leaves';
    	$criteria->select = array('sum(leave_days)  as total');
    	$criteria->condition = 'emp_number = :emp_number 
    			                and leave_sy=:leave_sy 
                                and leave_type != "slp"
                                and leave_type != "vlp"
                                and leave_type != "elp"
                                and leave_status != "Disapproved"
                                and leave_status = "Approved" ';
    	$criteria->params = array(':emp_number' => $emp_number, ':leave_sy' => $leave_sy);
    	$result = EmpLeaves::model()->find($criteria);
    	if (!is_null($result))
    		return $result->total;
    	else
    		return 0;
    }
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('leave_id', $this->leave_id, true);
        $criteria->compare('leave_type', $this->leave_type);
        $criteria->compare('emp_number', $this->emp_number);
        $criteria->compare('leave_reason', $this->leave_reason, true);
        $criteria->compare('leave_status', $this->leave_status, true);
        $criteria->compare('leave_days', $this->leave_days, true);

        $criteria->compare('leave_date_filed', $this->leave_date_filed, true);
        $criteria->compare('leave_date_created', $this->leave_date_created, true);


        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }




    public function getVlUsed($emp_number, $leave_sy) {

        $criteria = new CDbCriteria();
        $criteria->select = array('sum(leave_days) as total');
        $criteria->condition = 'emp_number = :emp_number and leave_sy=:leave_sy 
                                and (leave_type = "vlp" or leave_type = "elp") and leave_status = "Approved" ';
        $criteria->params = array(':emp_number' => $emp_number, ':leave_sy' => $leave_sy);
        $result = EmpLeaves::model()->find($criteria);
        if (!is_null($result))
            return $result->total;
        else
            return 0;
    }

     public function getSlUsed($emp_number, $leave_sy) {

        $criteria = new CDbCriteria();
        $criteria->select = array('sum(leave_days) as total');
        $criteria->condition = 'emp_number = :emp_number and leave_sy=:leave_sy 
                                and leave_type = "slp" and leave_status = "Approved" ';
        $criteria->params = array(':emp_number' => $emp_number, ':leave_sy' => $leave_sy);
        $result = EmpLeaves::model()->find($criteria);
        if (!is_null($result))
            return $result->total;
        else
            return 0;
    }






 public function getSlPending($emp_number, $leave_sy) {

        $criteria = new CDbCriteria();
        $criteria->select = array('sum(leave_days) as total');
        $criteria->condition = 'emp_number = :emp_number and leave_sy=:leave_sy 
                                and leave_type = "slp" and leave_status != "Approved" and leave_status != "Disapproved"';
        $criteria->params = array(':emp_number' => $emp_number, ':leave_sy' => $leave_sy);
        $result = EmpLeaves::model()->find($criteria);
        if (!is_null($result))
            return $result->total;
        else
            return 0;
    }
    
     public function getVlPending($emp_number, $leave_sy) {

        $criteria = new CDbCriteria();
        $criteria->select = array('sum(leave_days) as total');
        $criteria->condition = 'emp_number = :emp_number and leave_sy=:leave_sy 
                                and (leave_type = "vlp" or leave_type = "elp") and leave_status != "Approved" and leave_status != "Disapproved" ';
        $criteria->params = array(':emp_number' => $emp_number, ':leave_sy' => $leave_sy);
        $result = EmpLeaves::model()->find($criteria);
        if (!is_null($result))
            return $result->total;
        else
            return 0;
    }

    public function getOthersUsed($emp_number, $leave_sy) {

        $criteria = new CDbCriteria();
        $criteria->select = array('sum(leave_days) as total');
        $criteria->condition = 'emp_number = :emp_number and leave_sy=:leave_sy 
                                and leave_type != "vlp" 
                                and leave_type != "elp"
                                and leave_type != "slp"
                                and leave_status = "Approved" ';
        $criteria->params = array(':emp_number' => $emp_number, ':leave_sy' => $leave_sy);
        $result = EmpLeaves::model()->find($criteria);
        if (!is_null($result))
            return $result->total;
        else
            return 0;
    }







}