<?php

/**
 * This is the model class for table "hs_hr_emp_affiliation".
 *
 * The followings are the available columns in table 'hs_hr_emp_affiliation':
 * @property integer $mem_id
 * @property integer $emp_number
 * @property string $mem_name
 * @property string $mem_place
 * @property string $mem_start_date
 * @property string $mem_end_date
 * @property string $mem_comments
 */
class EmpAffiliation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return EmpAffiliation the static model class
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
		return 'hs_hr_emp_affiliation';
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
			array('mem_name, mem_comments', 'length', 'max'=>150),
                        array('mem_name,mem_place','required'),
			array('mem_place', 'length', 'max'=>100),
			array('mem_start_date, mem_end_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mem_id, emp_number, mem_name, mem_place, mem_start_date, mem_end_date, mem_comments', 'safe', 'on'=>'search'),
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
			'mem_id' => 'Id',
			'emp_number' => 'Employee Number',
			'mem_name' => 'Name of Organization',
			'mem_place' => 'Place',
			'mem_start_date' => 'Start Date',
			'mem_end_date' => 'End Date',
			'mem_comments' => 'Comments',
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

		$criteria->compare('mem_id',$this->mem_id);
		$criteria->compare('emp_number',$this->emp_number);
		$criteria->compare('mem_name',$this->mem_name,true);
		$criteria->compare('mem_place',$this->mem_place,true);
		$criteria->compare('mem_start_date',$this->mem_start_date,true);
		$criteria->compare('mem_end_date',$this->mem_end_date,true);
		$criteria->compare('mem_comments',$this->mem_comments,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}