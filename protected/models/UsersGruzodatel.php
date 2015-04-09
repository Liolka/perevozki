<?php

/**
 * This is the model class for table "{{users_gruzodatel}}".
 *
 * The followings are the available columns in table '{{users_gruzodatel}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $phone1
 * @property string $phone2
 * @property string $phone3
 * @property string $phone4
 * @property string $email
 * @property string $skype
 * @property integer $site
 * @property string $name
 * @property string $fio
 * @property string $post
 * @property string $details
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class UsersGruzodatel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{users_gruzodatel}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('phone1, phone2, phone3, phone4, email, skype, site, name, fio, post, details', 'length', 'max'=>255),
			array('description', 'length', 'max'=>2048),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, phone1, phone2, phone3, phone4, email, skype, site, name, fio, post, details, description', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'phone1' => '1)',
			'phone2' => '2)',
			'phone3' => '3)',
			'phone4' => '4)',
			'email' => 'Email',
			'skype' => 'Skype',
			'site' => 'Веб-сайт',
			'name' => 'Наименование компании',
			'fio' => 'ФИО контактного лица',
			'post' => 'Должность контактного лица',
			'details' => 'Реквизиты',
			'description' => 'Дополнительно',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('phone1',$this->phone1,true);
		$criteria->compare('phone2',$this->phone2,true);
		$criteria->compare('phone3',$this->phone3,true);
		$criteria->compare('phone4',$this->phone4,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('skype',$this->skype,true);
		$criteria->compare('site',$this->site);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('fio',$this->fio,true);
		$criteria->compare('post',$this->post,true);
		$criteria->compare('details',$this->details,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersGruzodatel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
