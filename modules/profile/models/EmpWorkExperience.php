<?php

/**
 * This is the model class for table "hs_hr_emp_work_experience".
 *
 * The followings are the available columns in table 'hs_hr_emp_work_experience':
 * @property integer $eexp_id
 * @property integer $emp_number
 * @property string $eexp_employer
 * @property string $eexp_jobtit
 * @property string $eexp_from_date
 * @property string $eexp_to_date
 * @property string $eexp_comments
 * @property integer $eexp_internal
 */
class EmpWorkExperience extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return EmpWorkExperience the static model class
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
		return 'hs_hr_emp_work_experience';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('emp_number, eexp_internal', 'numerical', 'integerOnly'=>true),
			array('eexp_employer', 'length', 'max'=>100),
			array('eexp_jobtit', 'length', 'max'=>120),
			array('eexp_comments', 'length', 'max'=>200),
			array('eexp_from_date, eexp_to_date', 'safe'),
                        array('emp_number, eexp_employer, eexp_jobtit, eexp_from_date, eexp_to_date','required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('eexp_id, emp_number, eexp_employer, eexp_jobtit, eexp_from_date, eexp_to_date, eexp_comments, eexp_internal', 'safe', 'on'=>'search'),
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
			'eexp_id' => 'Work Experience Id',
			'emp_number' => 'Employee Number',
			'eexp_employer' => 'Employer',
			'eexp_jobtit' => 'Job Title',
			'eexp_from_date' => 'Start of Employment',
			'eexp_to_date' => 'End of Employment',
			'eexp_comments' => 'Comments',
			'eexp_internal' => 'Internal',
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

		$criteria->compare('eexp_id',$this->eexp_id);
		$criteria->compare('emp_number',$this->emp_number);
		$criteria->compare('eexp_employer',$this->eexp_employer,true);
		$criteria->compare('eexp_jobtit',$this->eexp_jobtit,true);
		$criteria->compare('eexp_from_date',$this->eexp_from_date,true);
		$criteria->compare('eexp_to_date',$this->eexp_to_date,true);
		$criteria->compare('eexp_comments',$this->eexp_comments,true);
		$criteria->compare('eexp_internal',$this->eexp_internal);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}