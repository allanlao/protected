<?php

/**
 * This is the model class for table "hs_hr_emp_education".
 *
 * The followings are the available columns in table 'hs_hr_emp_education':
 * @property integer $edu_id
 * @property integer $emp_number
 * @property string $edu_degree
 * @property string $edu_school
 * @property string $edu_start_date
 * @property string $edu_end_date
 * @property string $edu_comments
 */
class EmpEducation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return EmpEducation the static model class
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
		return 'hs_hr_emp_education';
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
			array('edu_degree', 'length', 'max'=>100),
			array('edu_school', 'length', 'max'=>100),
			array('edu_comments', 'length', 'max'=>150),
				array('edu_type', 'length', 'max'=>50), 
			array('edu_start_date, edu_end_date', 'safe'),
                        array('emp_number, edu_degree, edu_school, edu_start_date, edu_type, edu_end_date','required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('edu_id, emp_number, edu_degree, edu_school, edu_start_date, edu_end_date, edu_comments', 'safe', 'on'=>'search'),
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
			'edu_id' => 'Id',
			'emp_number' => 'Employee Number',
			'edu_degree' => 'Course/Degree',
			'edu_school' => 'School',
			'edu_start_date' => 'Start Year',
			'edu_end_date' => 'End Year',
			'edu_comments' => 'Comments',
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

		$criteria->compare('edu_id',$this->edu_id);
		$criteria->compare('emp_number',$this->emp_number);
		$criteria->compare('edu_degree',$this->edu_degree,true);
		$criteria->compare('edu_school',$this->edu_school,true);
		$criteria->compare('edu_start_date',$this->edu_start_date,true);
		$criteria->compare('edu_end_date',$this->edu_end_date,true);
		$criteria->compare('edu_comments',$this->edu_comments,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}