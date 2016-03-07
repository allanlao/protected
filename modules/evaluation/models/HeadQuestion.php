<?php

/**
 * This is the model class for table "headQuestion".
 *
 * The followings are the available columns in table 'headQuestion':
 * @property integer $hq_id
 * @property integer $pid
 * @property string $question
 * @property string $sub_question
 * @property string $c1
 * @property string $c2
 * @property string $c3
 * @property string $c4
 * @property string $c5
 *
 * The followings are the available model relations:
 * @property HeadEvaluationDetails[] $headEvaluationDetails
 * @property HeadQuestionCategory $p
 */
class HeadQuestion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'headQuestion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('question, sub_question, c1, c2, c3, c4, c5', 'required'),
			array('pid', 'numerical', 'integerOnly'=>true),
			array('question, sub_question, c1, c2, c3, c4, c5', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('hq_id, pid, question, sub_question, c1, c2, c3, c4, c5', 'safe', 'on'=>'search'),
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
			'headEvaluationDetails' => array(self::HAS_MANY, 'HeadEvaluationDetails', 'question_id'),
			'p' => array(self::BELONGS_TO, 'HeadQuestionCategory', 'pid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hq_id' => 'Hq',
			'pid' => 'Pid',
			'question' => 'Question',
			'sub_question' => 'Sub Question',
			'c1' => 'C1',
			'c2' => 'C2',
			'c3' => 'C3',
			'c4' => 'C4',
			'c5' => 'C5',
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

		$criteria->compare('hq_id',$this->hq_id);
		$criteria->compare('pid',$this->pid);
		$criteria->compare('question',$this->question,true);
		$criteria->compare('sub_question',$this->sub_question,true);
		$criteria->compare('c1',$this->c1,true);
		$criteria->compare('c2',$this->c2,true);
		$criteria->compare('c3',$this->c3,true);
		$criteria->compare('c4',$this->c4,true);
		$criteria->compare('c5',$this->c5,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HeadQuestion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
