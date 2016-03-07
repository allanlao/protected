<?php

/**
 * This is the model class for table "hs_hr_emp_leave_credits".
 *
 * The followings are the available columns in table 'hs_hr_emp_leave_credits':
 * @property string $leave_credit_id
 * @property integer $emp_number
 * @property string $leave_sy
 * @property integer $leave_allocated_vl
 * @property integer $leave_allocated_sl
 * @property string $leave_used_vl
 * @property string $leave_used_sl
 * @property string $leave_used_others
 *
 * The followings are the available model relations:
 * @property Employee $empNumber
 */
class EmpLeaveCredits extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return EmpLeaveCredits the static model class
     */
    public $avail_vl_credits;
    public $avail_sl_credits;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hs_hr_emp_leave_credits';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('emp_number, leave_sy, leave_allocated_vl, leave_allocated_sl', 'required'),
            array('emp_number, leave_allocated_vl, leave_allocated_sl', 'numerical', 'integerOnly' => true),
            array('leave_credit_id', 'length', 'max' => 13),
            array('leave_sy', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('leave_credit_id, emp_number, leave_sy, leave_allocated_vl, leave_allocated_sl', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'leave_credit_id' => 'Leave Credit',
            'emp_number' => 'Emp Number',
            'leave_sy' => 'Leave Sy',
            'leave_allocated_vl' => 'Allocated VL',
            'leave_allocated_sl' => 'Allocated SL',
           
        );
    }

    
    
 public function getVlCredits($emp_number, $leave_sy) {

        $criteria = new CDbCriteria();
        $criteria-> alias = 'hs_hr_emp_leave_credits';
        $criteria->select = array('(leave_allocated_vl - COALESCE((
				   select sum(leave_days) from hs_hr_emp_leaves
				   where (leave_type = "vlp" or leave_type = "elp")
					       and leave_sy =:leave_sy
					       and emp_number =:emp_number
        		           and leave_status != "Disapproved"
					),0)) as avail_vl_credits');
     
        $criteria->condition = 'hs_hr_emp_leave_credits.emp_number = :emp_number and hs_hr_emp_leave_credits.leave_sy=:leave_sy 
                               ';
        $criteria->params = array(':emp_number' => $emp_number, ':leave_sy' => $leave_sy);
        $result = EmpLeaveCredits::model()->find($criteria);
        if (!is_null($result))
            return $result->avail_vl_credits;
        else
            return null;
    }

    public function getSlCredits($emp_number, $leave_sy) {

        $criteria = new CDbCriteria();
           $criteria-> alias = 'hs_hr_emp_leave_credits';
        $criteria->select = array('(leave_allocated_sl - COALESCE((
				   select sum(leave_days) from hs_hr_emp_leaves
				   where leave_type = "slp" 
					       and leave_sy =:leave_sy
					       and emp_number =:emp_number
        		           and leave_status != "Disapproved"
					),0)) as avail_sl_credits');
     
        $criteria->condition = 'hs_hr_emp_leave_credits.emp_number = :emp_number and hs_hr_emp_leave_credits.leave_sy=:leave_sy 
                               ';
        $criteria->params = array(':emp_number' => $emp_number, ':leave_sy' => $leave_sy);
        $result = EmpLeaveCredits::model()->find($criteria);
        if (!is_null($result))
            return $result->avail_sl_credits;
        else
            return null;
    }
    
   
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('leave_credit_id', $this->leave_credit_id, true);
        $criteria->compare('emp_number', $this->emp_number);
        $criteria->compare('leave_sy', $this->leave_sy, true);
        $criteria->compare('leave_allocated_vl', $this->leave_allocated_vl);
        $criteria->compare('leave_allocated_sl', $this->leave_allocated_sl);
     

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}