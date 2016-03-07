<?php

/**
 * This is the model class for table "hs_hr_emp_dependents".
 *
 * The followings are the available columns in table 'hs_hr_emp_dependents':
 * @property integer $ed_id
 * @property integer $emp_number
 * @property string $ed_name
 * @property string $ed_relationship_type
 * @property string $ed_relationship
 * @property string $ed_date_of_birth
 */
class EmpDependents extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return EmpDependents the static model class
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
		return 'hs_hr_emp_dependents';
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
			array('ed_name, ed_relationship', 'length', 'max'=>100),
                        array('ed_name, ed_relationship', 'required'),
			array('ed_relationship_type', 'length', 'max'=>5),
			array('ed_date_of_birth', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ed_id, emp_number, ed_name, ed_relationship_type, ed_relationship, ed_date_of_birth', 'safe', 'on'=>'search'),
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
			'ed_id' => 'Employee Id',
			'emp_number' => 'Employee Number',
			'ed_name' => 'Name of Dependent',
			'ed_relationship_type' => 'Relationship Type',
			'ed_relationship' => 'Relationship',
			'ed_date_of_birth' => 'Date Of Birth',
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

		$criteria->compare('ed_id',$this->ed_id);
		$criteria->compare('emp_number',$this->emp_number);
		$criteria->compare('ed_name',$this->ed_name,true);
		$criteria->compare('ed_relationship_type',$this->ed_relationship_type,true);
		$criteria->compare('ed_relationship',$this->ed_relationship,true);
		$criteria->compare('ed_date_of_birth',$this->ed_date_of_birth,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}