<?php 

/**
 * This is the model class for table "{{cargoes}}".
 *
 * The followings are the available columns in table '{{cargoes}}':
 * @property integer $cargo_id
 * @property string $name
 * @property string $comment
 * @property double $weight
 * @property integer $unit
 * @property string $foto
 * @property integer $porters
 * @property integer $lift_to_floor
 * @property integer $floor
 * @property double $length
 * @property double $width
 * @property double $height
 * @property double $volume
 *
 * The followings are the available model relations:
 * @property BidsCargoes[] $bidsCargoes
 * @property CargoesCategories[] $cargoesCategories
 */
class Cargoes extends CActiveRecord
{
	
	const SCENARIO_SAVE_CARGO = 'save_cargo';
	
	public $DropDownUnitsList;
	public $SelectedUnitsList;
	
	public $UnitsListArray = array(
		1 => array('id' => 1, 'name' => 'кг'),
		2 => array('id' => 2, 'name' => 'тонн'),
	);
	
	public $category_id;
	
	public $category1;
	public $cargo_id1;
	public $name1;
	public $comment1;
	public $unit1;
	public $selected_unit1;
	public $porters1;
	public $lift_to_floor1;
	public $lift1;
	public $floor1;
	public $weight1;
	public $length1;
	public $width1;
	public $height1;
	public $volume1;
	public $foto1;
	public $passengers_qty1;
	public $time1;
	
	public $category2;
	public $cargo_id2;
	public $name2;
	public $comment2;
	public $unit2;
	public $selected_unit2;
	public $porters2;
	public $lift_to_floor2;
	public $lift2;
	public $floor2;
	public $weight2;
	public $length2;
	public $width2;
	public $height2;
	public $volume2;
	public $foto2;
	public $passengers_qty2;
	public $time2;	
	
	public $category3;
	public $cargo_id3;
	public $name3;
	public $comment3;
	public $unit3;
	public $selected_unit3;
	public $porters3;
	public $lift_to_floor3;
	public $lift3;
	public $floor3;
	public $weight3;
	public $length3;
	public $width3;
	public $height3;
	public $volume3;
	public $foto3;
	public $passengers_qty3;
	public $time3;	
	
	
	public $category4;
	public $cargo_id4;
	public $name4;
	public $comment4;
	public $unit4;
	public $selected_unit4;
	public $porters4;
	public $lift_to_floor4;
	public $lift4;
	public $floor4;
	public $weight4;
	public $length4;
	public $width4;
	public $height4;
	public $volume4;
	public $foto4;
	public $passengers_qty4;
	public $time4;	
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cargoes}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('name, comment, weight, unit, foto, porters, lift_to_floor, floor, length, width, height, volume', 'required'),
			array('name', 'required', 'on'=>self::SCENARIO_SAVE_CARGO),
			array(
				'unit, porters, lift_to_floor, floor, lift,
				 unit1, porters1, lift_to_floor1, floor1, lift1,
				 unit2, porters2, lift_to_floor2, floor2, lift2,
				 unit3, porters3, lift_to_floor3, floor3, lift3,
				 unit4, porters4, lift_to_floor4, floor4', 
				'numerical', 'integerOnly'=>true
			),
			array(
				'weight, length, width, height, volume, 
				 weight1, length1, width1, height1, volume1, 
				 weight2, length2, width2, height2, volume2, 
				 weight3, length3, width3, height3, volume3, 
				 weight4, length4, width4, height4, volume4', 
				'numerical'
			),
			array(
				'name, foto, passengers_qty, time,
				 name1, foto1, passengers_qty1, time1,
				 name2, foto2, passengers_qty2, time2,
				 name3, foto3, passengers_qty3, time3,
				 name4, foto4, passengers_qty4, time4', 
				'length', 'max'=>255
			),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			/*
			array(
				'cargo_id, name, comment, weight, unit, foto, porters, lift_to_floor, floor, length, width, height, volume, 
				 cargo_id1, name1, comment1, weight1, unit1, foto1, porters1, lift_to_floo1r, floor1, length1, width1, heigh1t, volume1,
				 cargo_id2, name2, comment2, weight2, unit2, foto2, porters2, lift_to_floor2, floor2, length2, width2, height2, volume2,
				 cargo_id3, name3, comment3, weight3, unit3, foto3, porters3, lift_to_floor3, floor3, length3, width3, height3, volume3,
				 cargo_id4, name4, comment4, weight4, unit4, foto4, porters4, lift_to_floor4, floor4, length4, width4, height4, volume4', 
				'safe', 'on'=>'search'),
			*/
			array(
				'cargo_id, name, comment, weight, unit, foto, porters, lift_to_floor, floor, length, width, height, volume, passengers_qty, time,
				 cargo_id1, name1, comment1, weight1, unit1, foto1, porters1, lift_to_floo1r, floor1, length1, width1, heigh1t, volume1, passengers_qty1, time1,
				 cargo_id2, name2, comment2, weight2, unit2, foto2, porters2, lift_to_floor2, floor2, length2, width2, height2, volume2, passengers_qty2, time2,
				 cargo_id3, name3, comment3, weight3, unit3, foto3, porters3, lift_to_floor3, floor3, length3, width3, height3, volume3, passengers_qty3, time3,
				 cargo_id4, name4, comment4, weight4, unit4, foto4, porters4, lift_to_floor4, floor4, length4, width4, height4, volume4, passengers_qty4, time4,', 
				'safe'),
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
			'bidsCargoes' => array(self::HAS_MANY, 'BidsCargoes', 'cargo_id'),
			'cargoesCategories' => array(self::HAS_MANY, 'CargoesCategories', 'cargo_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cargo_id' => 'Cargo',
			'name' => 'Можете дополнить название груза',
			'comment' => 'Ваш комментарий к грузу',
			'weight' => 'Примерный вес',
			'unit' => ' ',
			'foto' => 'Загрузить фото ',
			'porters' => 'На погрузку выгрузку',
			'lift_to_floor' => 'Подъем на этаж',
			'lift' => 'Лифт',
			'floor' => 'Этаж',
			'length' => 'Примерные габариты',
			'width' => 'Width',
			'height' => 'Height',
			'volume' => 'Volume',
			'passengers_qty' => 'Количество пассажиров',
			'time' => 'На сколько нужна машина',
			
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

		$criteria->compare('cargo_id',$this->cargo_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('unit',$this->unit);
		$criteria->compare('foto',$this->foto,true);
		$criteria->compare('porters',$this->porters);
		$criteria->compare('lift_to_floor',$this->lift_to_floor);
		$criteria->compare('floor',$this->floor);
		$criteria->compare('length',$this->length);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('volume',$this->volume);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cargoes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	function getDropDownUnitsList()
	{
		$result = CHtml::listData($this->UnitsListArray, 'id', 'name');
		return $result;
	}
	
	public function getCargoresInfo(&$connection, $bid_ids = array())
	{
		if(count($bid_ids))	{
			$sql = "SELECT bc.`bid_id`, c.`cargo_id`, c.`name`, c.`foto`, c.`porters`, c.`weight`, c.`unit`, c.`volume` FROM ".$this->tableName()." as c INNER JOIN {{bids_cargoes}} AS bc USING(`cargo_id`) WHERE bc.`bid_id` IN(".implode(',', $bid_ids).") ORDER BY bc.`bid_id`";
			//echo'<pre>';print_r($sql);echo'</pre>';
			$command = $connection->createCommand($sql);
			return $command->queryAll();			
		}	else	{
			return array();
		}
	}
	
	
}
