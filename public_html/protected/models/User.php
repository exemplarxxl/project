<?php

/**
 * This is the model class for table "{{users}}".
 *
 * The followings are the available columns in table '{{users}}':
 * @property integer $id
 * @property integer $role_id
 * @property string $name
 * @property string $login
 * @property string $password
 * @property string $email
 * @property integer $phone
 * @property string $last_activity
 * @property string $last_visit
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{users}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_id, phone', 'numerical', 'integerOnly'=>true),
			array('name, login, email', 'length', 'max'=>255),
            array('password', 'length', 'min'=>6),
            array('email','email'),
            array('login, email', 'unique'),
			array('last_activity, last_visit, password', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, role_id, name, login, password, email, phone, last_activity, last_visit', 'safe', 'on'=>'search'),
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
            'role' => array(self::BELONGS_TO, 'UserRole', 'role_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'role_id' => 'Роль',
			'name' => 'Имя',
			'login' => 'Логин',
			'password' => 'Пароль',
			'email' => 'Email',
			'phone' => 'Телефон',
			'last_activity' => 'Last Activity',
			'last_visit' => 'Last Visit',
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
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone);
		$criteria->compare('last_activity',$this->last_activity,true);
		$criteria->compare('last_visit',$this->last_visit,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function cryptPassword($password, $salt=567657) {
        return crypt($password, $salt);
    }

    protected function beforeSave() {

        if ( $this->getIsNewRecord() ) {
            $this->password = self::cryptPassword($this->password);
        } else {
            $old_password = self::model()->findByPk($this->id)->password;
            if ( $old_password != $this->password ) {
                $this->password = self::cryptPassword($this->password);
            }
        }
        return parent::beforeSave();
    }
}
