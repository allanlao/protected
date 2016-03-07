<?php

/**
 * This is the model class for table "hs_hr_emp_licenses".
 *
 * The followings are the available columns in table 'hs_hr_emp_licenses':
 * @property integer $licenses_id
 * @property integer $emp_number
 * @property string $licenses_number
 * @property string $licenses_desciption
 * @property string $licenses_date
 * @property string $licenses_renewal_date
 */
class EmpLicenses extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return EmpLicenses the static model class
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
		return 'hs_hr_emp_licenses';
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
			array('licenses_number', 'length', 'max'=>50),
			array('licenses_description', 'length', 'max'=>100),
			array('licenses_date, licenses_renewal_date', 'safe'),
                        array('emp_number, licenses_number, licenses_description, licenses_date','required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('licenses_id, emp_number, licenses_number, licenses_description, licenses_date, licenses_renewal_date', 'safe', 'on'=>'search'),
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
			'licenses_id' => 'Id',
			'emp_number' => 'Employee Number',
			'licenses_number' => 'License Number',
			'licenses_description' => 'License Description',
			'licenses_date' => 'Date Issued',
			'licenses_renewal_date' => 'Renewal Date',
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

		$criteria->compare('licenses_id',$this->licenses_id);
		$criteria->compare('emp_number',$this->emp_number);
		$criteria->compare('licenses_number',$this->licenses_number,true);
		$criteria->compare('licenses_description',$this->licenses_desciption,true);
		$criteria->compare('licenses_date',$this->licenses_date,true);
		$criteria->compare('licenses_renewal_date',$this->licenses_renewal_date,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}