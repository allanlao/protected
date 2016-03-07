<?php

/**
 * This is the model class for table "headBySubordinateQuestion_subcategory".
 *
 * The followings are the available columns in table 'headBySubordinateQuestion_subcategory':
 * @property integer $subcat_id
 * @property integer $cat_id
 * @property string $description
 * @property integer $percentage
 *
 * The followings are the available model relations:
 * @property HeadBySubordinateQuestion[] $headBySubordinateQuestions
 * @property HeadBySubordinateQuestionCategory $cat
 */
class HeadBySubordinateQuestionSubcategory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'headBySubordinateQuestion_subcategory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cat_id, percentage', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('subcat_id, cat_id, description, percentage', 'safe', 'on'=>'search'),
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
			'headBySubordinateQuestions' => array(self::HAS_MANY, 'HeadBySubordinateQuestion', 'subcat_id'),
			'cat' => array(self::BELONGS_TO, 'HeadBySubordinateQuestionCategory', 'cat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'subcat_id' => 'Subcat',
			'cat_id' => 'Cat',
			'description' => 'Description',
			'percentage' => 'Percentage',
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

		$criteria->compare('subcat_id',$this->subcat_id);
		$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('percentage',$this->percentage);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HeadBySubordinateQuestionSubcategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
