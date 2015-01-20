<?php

/**
 * This is the model class for table "employee".
 *
 * The followings are the available columns in table 'employee':
 * @property integer $id
 * @property integer $departmentId
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property integer $ext
 * @property string $hireDate
 * @property string $leaveDate
 *
 * The followings are the available model relations:
 * @property Department $department
 */
class Employee extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'employee';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('departmentId, firstName, lastName, email, hireDate', 'required'),
			array('departmentId, ext', 'numerical', 'integerOnly'=>true),
			array('firstName', 'length', 'max'=>20),
			array('lastName', 'length', 'max'=>40),
			array('email', 'length', 'max'=>60),
                        array('email', 'email'),
                        array('email', 'uniqueEmail'),
//                    array('email', 'unique', 'message'=>'Email already exists!'),
			array('leaveDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, departmentId, firstName, lastName, email, ext, hireDate, leaveDate', 'safe', 'on'=>'search'),
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
			'department' => array(self::BELONGS_TO, 'Department', 'departmentId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'departmentId' => 'Department',
			'firstName' => 'First Name',
			'lastName' => 'Last Name',
			'email' => 'Email',
			'ext' => 'Ext',
			'hireDate' => 'Hire Date',
			'leaveDate' => 'Leave Date',
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
		$criteria->compare('departmentId',$this->departmentId);
		$criteria->compare('firstName',$this->firstName,true);
		$criteria->compare('lastName',$this->lastName,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('ext',$this->ext);
		$criteria->compare('hireDate',$this->hireDate,true);
		$criteria->compare('leaveDate',$this->leaveDate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Employee the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        function uniqueEmail($attribute) {
//            exit($this->$attribute);
            $connection = Yii::app()->db;
            $where = "";
            if(isset($this->id) && $this->id != "") 
                $where = " AND id != " . $this->id;
            
            $command = $connection->createCommand('SELECT * FROM employee WHERE email = "' . $this->$attribute . '" ' . $where);
            $row = $command->queryRow(); 
            if($row) {
                $this->addError('email','Email already exists');
            }
        }
}
