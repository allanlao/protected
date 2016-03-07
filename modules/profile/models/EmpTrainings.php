<?php

/**
 * This is the model class for table "hs_hr_emp_trainings".
 *
 * The followings are the available columns in table 'hs_hr_emp_trainings':
 * @property integer $tra_id
 * @property integer $emp_number
 * @property string $tra_title
 * @property string $tra_place
 * @property string $tra_start_date
 * @property string $tra_end_date
 * @property string $tra_comments
 */
class EmpTrainings extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return EmpTrainings the static model class
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
		return 'hs_hr_emp_trainings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('emp_number', 'numerical', 'integerOnly'=>true),
			array('tra_title, tra_comments', 'length', 'max'=>150),
			array('tra_place', 'length', 'max'=>100),
			array('tra_start_date, tra_end_date', 'safe'),
                        array('emp_number, tra_title, tra_place, tra_start_date, tra_end_date','required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tra_id, emp_number, tra_title, tra_place, tra_start_date, tra_end_date, tra_comments', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tra_id' => 'Id',
			'emp_number' => 'Employee Number',
			'tra_title' => 'Training Title',
			'tra_place' => 'Place',
			'tra_start_date' => 'Start Date',
			'tra_end_date' => 'End Date',
			'tra_comments' => 'Comments',
		);
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

		$criteria->compare('tra_id',$this->tra_id);
		$criteria->compare('emp_number',$this->emp_number);
		$criteria->compare('tra_title',$this->tra_title,true);
		$criteria->compare('tra_place',$this->tra_place,true);
		$criteria->compare('tra_start_date',$this->tra_start_date,true);
		$criteria->compare('tra_end_date',$this->tra_end_date,true);
		$criteria->compare('tra_comments',$this->tra_comments,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}