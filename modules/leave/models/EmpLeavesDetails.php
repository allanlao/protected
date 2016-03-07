<?php

/**
 * This is the model class for table "hs_hr_emp_leaves_details".
 *
 * The followings are the available columns in table 'hs_hr_emp_leaves_details':
 * @property string $leave_details_id
 * @property string $leave_id
 * @property string $leave_details_start_date
 * @property string $leave_details_end_date
 * @property string $leave_details_start_ampm
 * @property string $leave_details_end_ampm
 *
 * The followings are the available model relations:
 * @property EmpLeaves $leave
 */
class EmpLeavesDetails extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return EmpLeavesDetails the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hs_hr_emp_leaves_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('leave_details_id, leave_id, leave_details_date, leave_details_ampm', 'required'),
            array('leave_details_id, leave_id', 'length', 'max' => 13),
            array('leave_details_ampm', 'length', 'max' => 4),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('leave_details_id, leave_id, leave_details_date, leave_details_ampm', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'leave' => array(self::BELONGS_TO, 'EmpLeaves', 'leave_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'leave_details_id' => 'Leave Details',
            'leave_id' => 'Leave',
            'leave_details_date' => 'Leave Date',
            'leave_details_ampm' => 'Leave Ampm',
            'leave_credit' => 'Leave Credit',
        );
    }

    public function getLeaveDates($id) {
        $dates_str = "";
        $leave_dates = $this->model()->findAll(array('condition' => 'leave_id=:leave_id', 'order'=>'leave_details_date asc',
            'params' => array(':leave_id' => $id)));

        foreach ($leave_dates as $dates) {
            $d = date('M-d', strtotime($dates->leave_details_date));
            if ($dates->leave_details_ampm == 'wd')
                $dates_str .= $d . " ";
            else
                $dates_str .= $d . " " . $dates->leave_details_ampm . "/";
        }
       
        return  rtrim($dates_str, '/');
    }

    
    
    
    
    
    
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('leave_details_id', $this->leave_details_id, true);
        $criteria->compare('leave_id', $this->leave_id, true);
        $criteria->compare('leave_details_date', $this->leave_details_date, true);
        $criteria->compare('leave_details_ampm', $this->leave_details_ampm, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}