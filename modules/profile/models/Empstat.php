<?php

/**
 * This is the model class for table "hs_hr_empstat".
 *
 * The followings are the available columns in table 'hs_hr_empstat':
 * @property string $estat_code
 * @property string $estat_name
 *
 * The followings are the available model relations:
 * @property Employee[] $employees
 * @property JobTitle[] $hsHrJobTitles
 */
class Empstat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Empstat the static model class
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
		return 'hs_hr_empstat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('estat_code', 'length', 'max'=>13),
			array('estat_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('estat_code, estat_name', 'safe', 'on'=>'search'),
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
			'employees' => array(self::HAS_MANY, 'Employee', 'emp_status'),
			'hsHrJobTitles' => array(self::MANY_MANY, 'JobTitle', 'hs_hr_jobtit_empstat(estat_code, jobtit_code)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'estat_code' => 'Estat Code',
			'estat_name' => 'Estat Name',
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

		$criteria->compare('estat_code',$this->estat_code,true);
		$criteria->compare('estat_name',$this->estat_name,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public function getEmpStats() {
         return $list = CHtml::listData($this->model()->findAll(array('order' => 'estat_code')),'estat_code','estat_name');

       
    }
}