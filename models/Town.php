<?php

/**
 * This is the model class for table "hs_hr_town".
 *
 * The followings are the available columns in table 'hs_hr_town':
 * @property integer $id
 * @property string $town_name
 * @property integer $province_code
 * @property string $zip_code
 */
class Town extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Town the static model class
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
		return 'hs_hr_town';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('town_name', 'required'),
			array('province_code', 'numerical', 'integerOnly'=>true),
			array('town_name', 'length', 'max'=>40),
			array('zip_code', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, town_name, province_code, zip_code', 'safe', 'on'=>'search'),
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
                      'province' => array(self::BELONGS_TO, 'Province', 'province_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'town_name' => 'Town Name',
			'province_code' => 'Province Code',
			'zip_code' => 'Zip Code',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('town_name',$this->town_name,true);
		$criteria->compare('province_code',$this->province_code);
		$criteria->compare('zip_code',$this->zip_code,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
         public function getTownsByProvince($id) {
         return $list = CHtml::listData($this->model()->findAll(array(
                   
                    'condition' => 'province_code=:pCode',
                    'params' => array(':pCode' => $id)    )),'id','town_name');

       
    }
        
}