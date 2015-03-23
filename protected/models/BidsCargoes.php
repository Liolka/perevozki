<?php

/**
 * This is the model class for table "{{bids_cargoes}}".
 *
 * The followings are the available columns in table '{{bids_cargoes}}':
 * @property integer $id
 * @property integer $bid_id
 * @property integer $cargo_id
 *
 * The followings are the available model relations:
 * @property Cargoes $cargo
 * @property Bids $bid
 */
class BidsCargoes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{bids_cargoes}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bid_id, cargo_id', 'required'),
			array('bid_id, cargo_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, bid_id, cargo_id', 'safe', 'on'=>'search'),
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
			'cargo' => array(self::BELONGS_TO, 'Cargoes', 'cargo_id'),
			'bid' => array(self::BELONGS_TO, 'Bids', 'bid_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'bid_id' => 'Bid',
			'cargo_id' => 'Cargo',
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
		$criteria->compare('bid_id',$this->bid_id);
		$criteria->compare('cargo_id',$this->cargo_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BidsCargoes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	//получает инфу по грузам заявки
	public function getCargoresBids(&$connection, $bid_id = 0)
	{
		$sql = "SELECT `cargo_id`, `name`, `comment`, `weight`, `unit`, `foto`, `porters`,`lift_to_floor`, `floor`, `length`, `width`, `height`, `volume` FROM {{cargoes}} AS c INNER JOIN ".$this->tableName()." AS bc USING (`cargo_id`) WHERE bc.`bid_id` = :bid_id";
		//echo'<pre>';print_r($bid_id);echo'</pre>';
		//echo'<pre>';print_r($sql);echo'</pre>';
		$command = $connection->createCommand($sql);
		$command->bindParam(":bid_id", $bid_id, PDO::PARAM_INT);
		return $command->queryAll();			
		
	}
	
}
