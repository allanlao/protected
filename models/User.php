<?php

/**
 * This is the model class for table "hs_hr_user".
 *
 * The followings are the available columns in table 'hs_hr_user':
 * @property string $email
 * @property string $password
 * @property string $role
 * @property integer $empNumber
 */
class User extends CActiveRecord {

    public $password_repeat;
    public $new_password_repeat;
    public $new_password;

    /**
     * Returns the static model of the specified AR class.
     * @return User the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hs_hr_user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('empNumber', 'numerical', 'integerOnly' => true),
            array('email, password', 'length', 'max' => 50),
        	array('email','unique'),
        	array('empNumber,email','required'),	
            array('new_password, new_password_repeat', 'length', 'min' => 5,'on'=>'update'),
            array('role', 'length', 'max' => 10),
            array('password,email', 'required', 'on' => 'login'),
            array('password,new_password,new_password_repeat', 'required', 'on' => 'update'),
            array('new_password_repeat', 'compare','compareAttribute'=>'new_password', 'on' => 'update'),
            array('email','exist', 'on'=>'update'),
            array('password', 'compare', 'on' => 'update'),
           // array('new_password,password_')
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        		'employee' => array(self::BELONGS_TO, 'Employee', 'empNumber'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'email' => 'Username',
            'password_repeat' => 'Old Password',
            'new_password' => 'New Password',
            'new_password_repeat' => 'Confirm New Password',
            'role' => 'Role',
            'empNumber' => 'Emp Number',
        	'status'=>'Status',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('role', $this->role, true);
        $criteria->compare('empNumber', $this->empNumber);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

    public function getEmpNumber($id) {

        $row = $this->model()->findByPk($id);

        return $row['empNumber'];
    }
/*
    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            $this->password =  md5($this->new_password);
            $this->password_repeat = md5($this->new_password);
        }
        return true;
    }
   

    public function beforeValidate() {
        if (parent::beforeValidate()) {
            $this->password_repeat = md5( $this->password_repeat);    
           //    var_dump($this);
        }
        return true;
    }
    
  */
    

}