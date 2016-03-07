<?php

/**
 * This is the model class for table "headEvaluation".
 *
 * The followings are the available columns in table 'headEvaluation':
 * @property string $emap_id
 * @property string $total
 * @property string $date
 * @property string $comments
 *
 * The followings are the available model relations:
 * @property EvaluatorsMap $emap
 * @property HeadEvaluationDetails[] $headEvaluationDetails
 */
class HeadEvaluation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'headEvaluation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('emap_id, total, date', 'required'),
			array('emap_id', 'length', 'max'=>50),
			array('total', 'length', 'max'=>10),
			array('comments', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('emap_id, total, date, comments', 'safe', 'on'=>'search'),
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
			'emap' => array(self::BELONGS_TO, 'EvaluatorsMap', 'emap_id'),
			'headEvaluationDetails' => array(self::HAS_MANY, 'HeadEvaluationDetails', 'emap_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'emap_id' => 'Emap',
			'total' => 'Total',
			'date' => 'Date',
			'comments' => 'Comments',
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

		$criteria->compare('emap_id',$this->emap_id,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('comments',$this->comments,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HeadEvaluation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
