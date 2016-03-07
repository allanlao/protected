<?php

/**
 * This is the model class for table "hs_hr_emp_awards".
 *
 * The followings are the available columns in table 'hs_hr_emp_awards':
 * @property integer $award_id
 * @property integer $emp_number
 * @property string $award_description
 * @property string $awarding_body
 * @property string $award_date
 * @property string $award_comments
 */
class EmpAwards extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hs_hr_emp_awards';
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
			array('award_description,award_date','required'),
			array('award_description, awarding_body, award_comments', 'length', 'max'=>150),
			array('award_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('award_id, emp_number, award_description, awarding_body, award_date, award_comments', 'safe', 'on'=>'search'),
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
			'award_id' => 'Award',
			'emp_number' => 'Emp Number',
			'award_description' => 'Award Description',
			'awarding_body' => 'Awarding Body',
			'award_date' => 'Award Date',
			'award_comments' => 'Award Comments',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('award_id',$this->award_id);
		$criteria->compare('emp_number',$this->emp_number);
		$criteria->compare('award_description',$this->award_description,true);
		$criteria->compare('awarding_body',$this->awarding_body,true);
		$criteria->compare('award_date',$this->award_date,true);
		$criteria->compare('award_comments',$this->award_comments,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EmpAwards the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
