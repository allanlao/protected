<?php

/**
 * This is the model class for table "hs_hr_position".
 *
 * The followings are the available columns in table 'hs_hr_position':
 * @property string $position_code
 * @property string $position_desc
 * @property string $position_category
 */
class Position extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Position the static model class
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
		return 'hs_hr_position';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('position_code', 'length', 'max'=>13),
			array('position_desc', 'length', 'max'=>100),
			array('position_category', 'length', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('position_code, position_desc, position_category', 'safe', 'on'=>'search'),
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
			'position_code' => 'Position Code',
			'position_desc' => 'Position Desc',
			'position_category' => 'Position Category',
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

		$criteria->compare('position_code',$this->position_code,true);
		$criteria->compare('position_desc',$this->position_desc,true);
		$criteria->compare('position_category',$this->position_category,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
         public function getpositions() {
         return $list = CHtml::listData($this->model()->findAll(array(
                   
                    'order' => 'position_desc',
                    )),'position_code','position_desc');

       
    }
}