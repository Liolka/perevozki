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
class UsersPerevozchik extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{users_perevozchik}}';
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
			array('user_id, file1_checked, file2_checked, file3_checked, file4_checked, file5_checked, file6_checked, file7_checked, file8_checked, file9_checked, file10_checked, file11_checked, file12_checked, file13_checked, file14_checked', 'numerical', 'integerOnly'=>true),
			array('phone1, phone2, phone3, phone4, email, skype, site, 
			company_name, unp, main_office, filials, fio, birthday, country, town, experience,
			file1, file2, file3, file4, file5, file6, file7, file8, file9, file10, file11, file12, file13, file14', 'length', 'max'=>255),
			array('description', 'length', 'max'=>2048),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, phone1, phone2, phone3, phone4, email, skype, site', 'safe', 'on'=>'search'),
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
			'phone1' => 'Телефон 1',
			'phone2' => 'Телефон 2',
			'phone3' => 'Телефон 3',
			'phone4' => 'Телефон 4',
			'phone11' => '1)',
			'phone22' => '2)',
			'phone33' => '3)',
			'phone44' => '4)',
			'email' => 'Email',
			'skype' => 'Skype',			
			'site' => 'Веб-сайт',
			
			'company_name' => 'Название предприятия',
			'unp' => 'УНП/ИНН',
			'main_office' => 'Головной офис',
			'filials' => 'Филиалы',	
			
			'fio' => 'ФИО',
			'birthday' => 'Дата рождения',
			'country' => 'Страна',
			'town' => 'Город',
			'experience' => 'Стаж',
			'description' => 'Дополнительно',
			
			'file1' => 'Пример договора',
			'file2' => 'Свидетельство о постановке на налоговый учет (ИНН)',
			'file3' => 'Свидетельство о регистрации юр. лица',
			'file4' => 'Свидетельство о регистрации ИП',
			'file5' => 'Лицензия',
			'file6' => 'Водительское удостоверение',
			'file7' => 'ПТС',
			'file8' => 'Паспорт',
			'file9' => 'Прописка в паспорте',
			'file10' => 'Реквизиты',
			'file11' => 'Устав',
			'file12' => 'Прайс-лист',
			'file13' => 'Страховка',
			'file14' => 'Коммерческое предложение',
			
			'file1_checked' => 'Проверен',
			'file2_checked' => 'Проверен',
			'file3_checked' => 'Проверен',
			'file4_checked' => 'Проверен',
			'file5_checked' => 'Проверен',
			'file6_checked' => 'Проверен',
			'file7_checked' => 'Проверен',
			'file8_checked' => 'Проверен',
			'file9_checked' => 'Проверен',
			'file10_checked' => 'Проверен',
			'file11_checked' => 'Проверен',
			'file12_checked' => 'Проверен',
			'file13_checked' => 'Проверен',
			'file14_checked' => 'Проверен',
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
	 * @return UsersPerevozchik the static model class
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
