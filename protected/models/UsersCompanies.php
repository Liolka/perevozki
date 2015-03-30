<?php

/**
 * This is the model class for table "{{users_companies}}".
 *
 * The followings are the available columns in table '{{users_companies}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $phone1
 * @property string $phone2
 * @property string $phone3
 * @property string $phone4
 * @property string $email
 * @property string $skype
 * @property string $site
 * @property string $type
 * @property string $year
 * @property integer $count_auto
 * @property integer $count_staff
 * @property string $main_office
 * @property string $filials
 * @property string $terminals
 *
 * The followings are the available model relations:
 * @property Users $id0
 */
class UsersCompanies extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{users_companies}}';
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
			array('phone1, phone2, phone3, phone4, email, skype, site, type, year, main_office, filials, terminals', 'length', 'max'=>255),
			array('count_auto, count_staff', 'length', 'max'=>128),
			array('description', 'length', 'max'=>2048),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, phone1, phone2, phone3, phone4, email, skype, site, type, year, count_auto, count_staff, main_office, filials, terminals', 'safe', 'on'=>'search'),
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
			'id0' => array(self::BELONGS_TO, 'Users', 'id'),
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
			'type' => 'Тип компании',
			'year' => 'Год основания',
			'count_auto' => 'Кол-во авто',
			'count_staff' => 'Количество сотрудников',
			'main_office' => 'Головной офис',
			'filials' => 'Филиалы',
			'terminals' => 'Склады и терминалы',
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
		$criteria->compare('site',$this->site,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('year',$this->year,true);
		$criteria->compare('count_auto',$this->count_auto);
		$criteria->compare('count_staff',$this->count_staff);
		$criteria->compare('main_office',$this->main_office,true);
		$criteria->compare('filials',$this->filials,true);
		$criteria->compare('terminals',$this->terminals,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersCompanies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/*
    protected function beforeSave()
    {
        if(parent::beforeSave())
        {
            
			//$this->purified_text = $this->purify($this->text);
			//echo'<pre>';print_r($this->attributes);echo'</pre>';//die;			
			foreach($this->attributes as $attr) {
				$attr = strip_tags($attr);
				//echo'<pre>';print_r($attr);echo'</pre>';//die;

			}
			$this->description = strip_tags($this->description);
			//die;
			
            return true;
        }
        else
            return false;
    }
	*/
}
