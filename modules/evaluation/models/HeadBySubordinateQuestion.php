<?php

/**
 * This is the model class for table "headBySubordinateQuestion".
 *
 * The followings are the available columns in table 'headBySubordinateQuestion':
 * @property integer $hsq_id
 * @property integer $subcat_id
 * @property string $question
 *
 * The followings are the available model relations:
 * @property HeadBySubordinateEvaluationDetails[] $headBySubordinateEvaluationDetails
 * @property HeadBySubordinateQuestionSubcategory $subcat
 */
class HeadBySubordinateQuestion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'headBySubordinateQuestion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subcat_id', 'numerical', 'integerOnly'=>true),
			array('question', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('hsq_id, subcat_id, question', 'safe', 'on'=>'search'),
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
			'headBySubordinateEvaluationDetails' => array(self::HAS_MANY, 'HeadBySubordinateEvaluationDetails', 'question_id'),
			'subcat' => array(self::BELONGS_TO, 'HeadBySubordinateQuestionSubcategory', 'subcat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hsq_id' => 'Hsq',
			'subcat_id' => 'Subcat',
			'question' => 'Question',
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

		$criteria->compare('hsq_id',$this->hsq_id);
		$criteria->compare('subcat_id',$this->subcat_id);
		$criteria->compare('question',$this->question,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HeadBySubordinateQuestion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
