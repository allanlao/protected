<?php

/**
 * This is the model class for table "job_posting".
 *
 * The followings are the available columns in table 'job_posting':
 * @property integer $id
 * @property string $position_code
 * @property string $department
 * @property integer $qty
 * @property string $job_type
 * @property string $status
 * @property string $date_posted
 * @property string $posted_by
 *
 * The followings are the available model relations:
 * @property HsHrPosition $positionCode
 */
class JobPosting extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'job_posting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('position_code, department, qty, job_type, status, date_posted, posted_by', 'required'),
			array('qty', 'numerical', 'integerOnly'=>true),
			array('position_code', 'length', 'max'=>13),
			array('department, job_type, status, posted_by', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, position_code, department, qty, job_type, status, date_posted, posted_by', 'safe', 'on'=>'search'),
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
			'positionCode' => array(self::BELONGS_TO, 'Position', 'position_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'position_code' => 'Position Code',
			'department' => 'Department',
			'qty' => 'No. of Vacancy',
			'job_type' => 'Job Type',
			'status' => 'Status',
			'date_posted' => 'Date Posted',
			'posted_by' => 'Posted By',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('position_code',$this->position_code,true);
		$criteria->compare('department',$this->department,true);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('job_type',$this->job_type,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('date_posted',$this->date_posted,true);
		$criteria->compare('posted_by',$this->posted_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JobPosting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
