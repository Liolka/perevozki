<?php

/**
 * This is the model class for table "{{deals}}".
 *
 * The followings are the available columns in table '{{deals}}':
 * @property integer $id
 * @property integer $bid_id
 * @property integer $user_id
 * @property integer $transport_id
 * @property string $created
 * @property integer $price
 * @property string $deal_date
 * @property string $deal_time
 * @property integer $porters
 * @property string $comment
 * @property integer $accepted
 * @property integer $rejected
 *
 * The followings are the available model relations:
 * @property Transport $transport
 * @property Bids $bid
 * @property Users $user
 */
class Deals extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{deals}}';
	}
	
	public function behaviors()
	{
		return array(
			'CTimestampBehavior' => array(
			'class' => 'zii.behaviors.CTimestampBehavior',
			'createAttribute' => 'created',
			'updateAttribute' => 'modified',
			)
		);
	}	

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('price', 'required'),
			//array('transport_id', 'required', 'message' => 'Укажите транспорт'),
			array('bid_id, user_id, transport_id, price, porters, accepted, rejected', 'numerical', 'integerOnly'=>true),
			array('comment', 'length', 'max'=>255),
			array('deal_date', 'date', 'format' => 'yyyy-MM-dd'),
			array('deal_time', 'date', 'format' => 'HH:mm'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, bid_id, user_id, transport_id, created, price, deal_date, deal_time, porters, comment, accepted, rejected', 'safe', 'on'=>'search'),
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
			'transport' => array(self::BELONGS_TO, 'Transport', 'transport_id'),
			'bid' => array(self::BELONGS_TO, 'Bids', 'bid_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'dealsPosts' => array(self::HAS_MANY, 'DealsPosts', 'deal_id'),
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
			'user_id' => 'User',
			'transport_id' => 'Transport',
			'created' => 'Created',
			'price' => 'За какую цену вы готовы выполнить заказ',
			'deal_date' => 'Дата',
			'deal_time' => 'Время',
			'porters' => 'Грузчики',
			'comment' => 'Комментарий',
			'accepted' => 'Заявка принята',
			'rejected' => 'Заявка отклонена',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('transport_id',$this->transport_id);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('deal_date',$this->deal_date,true);
		$criteria->compare('deal_time',$this->deal_time,true);
		$criteria->compare('porters',$this->porters);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('accepted',$this->accepted);
		$criteria->compare('rejected',$this->rejected);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Deals the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getBidDeals(&$connection, $bid_id)
	{
		$sql = "SELECT d.`id`, d.`bid_id`, d.`user_id`, d.`transport_id`, d.`created`, d.`price`, d.`deal_date`, d.`deal_time`, d.`porters`, d.`comment`, d.`accepted`, d.`rejected`, u.`username`, u.`last_activity`, u.`rating`, u.`reviews_count` FROM ".$this->tableName()." AS d INNER JOIN {{users}} AS u ON d.`user_id` = u.`id` WHERE `bid_id` = :bid_id ORDER BY d.`created` DESC";
		//echo'<pre>';print_r($sql);echo'</pre>';
		$command = $connection->createCommand($sql);
		$command->bindParam(":bid_id", $bid_id, PDO::PARAM_INT);
		return $command->queryAll();		
	}
	
	//возвращает кол-во предложений по каждой заявке
	public function getBidDealsCount(&$connection, $bid_ids)
	{
		$sql = "SELECT `bid_id`, count(`id`) AS bids_count FROM ".$this->tableName()." WHERE `bid_id` IN (".implode(', ', $bid_ids).") GROUP BY `bid_id`";
		//echo'<pre>';print_r($sql);echo'</pre>';
		$command = $connection->createCommand($sql);
		$rows = $command->queryAll();
		$result = array();
		foreach($rows as $row)	{
			$result[$row['bid_id']] = $row['bids_count'];
		}
		
		return $result;
	}
	
	//проверяет присутствие транспорта в предложении
	public function checkTransportInDeals(&$connection, $transport_id)
	{
		$sql = "SELECT `id` FROM ".$this->tableName()." WHERE `transport_id` = :transport_id";
		//echo'<pre>';print_r($sql);echo'</pre>';
		$command = $connection->createCommand($sql);
		$command->bindParam(":transport_id", $transport_id, PDO::PARAM_INT);
		$rows = $command->queryAll();
		if(count($rows) > 0) {
			$result = false;
		}	else	{
			$result = true;
		}
		
		//echo'<pre>';var_dump($rows);echo'</pre>';die;
		return $result;
	}
}
