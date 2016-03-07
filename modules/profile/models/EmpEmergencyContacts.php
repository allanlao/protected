<?php

/**
 * This is the model class for table "hs_hr_emp_emergency_contacts".
 *
 * The followings are the available columns in table 'hs_hr_emp_emergency_contacts':
 * @property integer $emp_number
 * @property string $eec_id //primary key
 * @property string $eec_name
 * @property string $eec_relationship
 * @property string $eec_home_no
 * @property string $eec_mobile_no
 * @property string $eec_office_no
 *
 * The followings are the available model relations:
 * @property Employee $empNumber
 */
class EmpEmergencyContacts extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return EmpEmergencyContacts the static model class
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
		return 'hs_hr_emp_emergency_contacts';
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
			array('eec_id', 'length', 'max'=>2),
                        array('eec_name, eec_relationship','required'),
			array('eec_name, eec_relationship, eec_home_no, eec_mobile_no, eec_office_no', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('emp_number, eec_id, eec_name, eec_relationship, eec_home_no, eec_mobile_no, eec_office_no', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'emp_number' => 'Employee Number',
			'eec_id' => 'Id',
			'eec_name' => 'Name',
			'eec_relationship' => 'Relation',
			'eec_home_no' => 'Home Telephone',
			'eec_mobile_no' => 'Mobile Number',
			'eec_office_no' => 'Office Telephone',
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

		$criteria->compare('emp_number',$this->emp_number);
		$criteria->compare('eec_id',$this->eec_id,true);
		$criteria->compare('eec_name',$this->eec_name,true);
		$criteria->compare('eec_relationship',$this->eec_relationship,true);
		$criteria->compare('eec_home_no',$this->eec_home_no,true);
		$criteria->compare('eec_mobile_no',$this->eec_mobile_no,true);
		$criteria->compare('eec_office_no',$this->eec_office_no,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}