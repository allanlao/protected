<?php

/**
 * This is the model class for table "hs_hr_oic".
 *
 * The followings are the available columns in table 'hs_hr_oic':
 * @property string $id
 * @property integer $emp_number
 * @property integer $assigned_to
 * @property string $start_date
 * @property string $end_date
 * @property string $reason
 * @property string $date_added
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property Employee $empNumber
 * @property Employee $assignedTo
 * @property Employee $createdBy
 */
class Oic extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Oic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hs_hr_oic';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, emp_number, assigned_to, start_date, end_date', 'required'),
			array('emp_number, assigned_to, created_by', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>13),
			array('reason', 'safe'),
                     
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, emp_number, assigned_to, start_date, end_date, reason, date_added, created_by', 'safe', 'on'=>'search'),
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
			'empNumber' => array(self::BELONGS_TO, 'Employee', 'emp_number'),
			'assignedTo' => array(self::BELONGS_TO, 'Employee', 'assigned_to'),
			'createdBy' => array(self::BELONGS_TO, 'Employee', 'created_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'emp_number' => 'Head',
			'assigned_to' => 'Assigned To',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'reason' => 'Reason',
			'date_added' => 'Date Added',
			'created_by' => 'Created By',
		);
	}
        
        
        public function getOic($empNumber)
        {
          $date = date('Y-m-d');
          return  $oic = $this->model()->find(array(
             'select'=>'assigned_to',
             'condition'=>'emp_number=:emp_number and :date >= start_date and :date <= end_date',
             'params'=>array(':emp_number'=>$empNumber,':date'=>$date),
                    ));
            
           
        }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('emp_number',$this->emp_number);
		$criteria->compare('assigned_to',$this->assigned_to);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('date_added',$this->date_added,true);
		$criteria->compare('created_by',$this->created_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}