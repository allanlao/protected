<?php

/**
 * This is the model class for table "evaluators_map".
 *
 * The followings are the available columns in table 'evaluators_map':
 * @property integer $id
 * @property integer $evaluation_period_id
 * @property integer $employee_id
 * @property integer $emp_to_evaluate
 * @property integer $evaluation_type
 *
 * The followings are the available model relations:
 * @property HsHrEmployee $empToEvaluate
 * @property EvaluationPeriod $evaluationPeriod
 * @property EvaluationType $evaluationType
 * @property HsHrEmployee $employee
 */
class EvaluatorsMap extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	
	public $aveRate;
	public $totalEvaluator;
	public function tableName()
	{
		return 'evaluators_map';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('evaluation_period_id, employee_id, emp_to_evaluate, evaluation_type', 'required'),
			array('evaluation_period_id, employee_id, emp_to_evaluate, evaluation_type', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('emap_id, evaluation_period_id, employee_id, emp_to_evaluate, evaluation_type', 'safe', 'on'=>'search'),
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
			'empToEvaluate' => array(self::BELONGS_TO, 'Employee', 'emp_to_evaluate'),
			'evaluationPeriod' => array(self::BELONGS_TO, 'EvaluationPeriod', 'evaluation_period_id'),
			'evaluationType' => array(self::BELONGS_TO, 'EvaluationType', 'evaluation_type'),
			'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'emp_id' => 'ID',
			'evaluation_period_id' => 'Evaluation Period',
			'employee_id' => 'Employee',
			'emp_to_evaluate' => 'Emp To Evaluate',
			'evaluation_type' => 'Evaluation Type',
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
		$criteria->compare('evaluation_period_id',$this->evaluation_period_id);
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('emp_to_evaluate',$this->emp_to_evaluate);
		$criteria->compare('evaluation_type',$this->evaluation_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EvaluatorsMap the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
