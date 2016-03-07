<?php

/**
 * This is the model class for table "hs_hr_emp_picture".
 *
 * The followings are the available columns in table 'hs_hr_emp_picture':
 * @property integer $emp_number
 * @property string $epic_picture
 * @property string $epic_filename
 * @property string $epic_type
 * @property string $epic_file_size
 */
class EmpPicture extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return EmpPicture the static model class
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
		return 'hs_hr_emp_picture';
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
			array('epic_filename', 'length', 'max'=>100),
			array('epic_type', 'length', 'max'=>50),
			array('epic_file_size', 'length', 'max'=>20),
			array('epic_picture', 'file', 'types'=>'jpg, gif, png'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('emp_number, epic_picture, epic_filename, epic_type, epic_file_size', 'safe', 'on'=>'search'),
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
			'emp_number' => 'Emp Number',
			'epic_picture' => 'Epic Picture',
			'epic_filename' => 'Epic Filename',
			'epic_type' => 'Epic Type',
			'epic_file_size' => 'Epic File Size',
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
		$criteria->compare('epic_picture',$this->epic_picture,true);
		$criteria->compare('epic_filename',$this->epic_filename,true);
		$criteria->compare('epic_type',$this->epic_type,true);
		$criteria->compare('epic_file_size',$this->epic_file_size,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}