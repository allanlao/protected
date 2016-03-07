<?php

/**
 * This is the model class for table "peerQuestion".
 *
 * The followings are the available columns in table 'peerQuestion':
 * @property integer $pq_id
 * @property string $category
 * @property string $sub_category
 * @property string $question
 *
 * The followings are the available model relations:
 * @property PeerEvaluationDetails[] $peerEvaluationDetails
 */
class PeerQuestion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'peerQuestion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category, sub_category, question', 'required'),
			array('category, sub_category', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pq_id, category, sub_category, question', 'safe', 'on'=>'search'),
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
			'peerEvaluationDetails' => array(self::HAS_MANY, 'PeerEvaluationDetails', 'question_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pq_id' => 'Pq',
			'category' => 'Category',
			'sub_category' => 'Sub Category',
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

		$criteria->compare('pq_id',$this->pq_id);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('sub_category',$this->sub_category,true);
		$criteria->compare('question',$this->question,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PeerQuestion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
