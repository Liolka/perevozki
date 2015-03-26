<?php

/**
 * This is the model class for table "{{transport}}".
 *
 * The followings are the available columns in table '{{transport}}':
 * @property integer $transport_id
 * @property integer $user_id
 * @property integer $name
 * @property integer $foto
 * @property string $carrying
 * @property double $length
 * @property double $width
 * @property double $height
 * @property double $volume
 * @property string $body_type
 * @property string $loading_type
 * @property string $comment
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class Transport extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{transport}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('user_id, foto', 'numerical', 'integerOnly'=>true),
			array('length, width, height, volume', 'numerical'),
			array('carrying', 'length', 'max'=>10),
			array('name, body_type, loading_type, comment', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('transport_id, user_id, name, foto, carrying, length, width, height, volume, body_type, loading_type, comment', 'safe', 'on'=>'search'),
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
			'transport_id' => 'Transport',
			'user_id' => 'User',
			'name' => 'Название',
			'foto' => 'Foto',
			'carrying' => 'Грузоподъёмность',
			'length' => 'Д х Ш х В',
			'width' => 'Width',
			'height' => 'Height',
			'volume' => 'Объём',
			'body_type' => 'Тип кузова',
			'loading_type' => 'Тип загрузки',
			'comment' => 'Комментарий',
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

		$criteria->compare('transport_id',$this->transport_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('name',$this->name);
		$criteria->compare('foto',$this->foto);
		$criteria->compare('carrying',$this->carrying,true);
		$criteria->compare('length',$this->length);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('volume',$this->volume);
		$criteria->compare('body_type',$this->body_type,true);
		$criteria->compare('loading_type',$this->loading_type,true);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Transport the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
