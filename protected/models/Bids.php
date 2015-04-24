<?php

/**
 * This is the model class for table "{{bids}}".
 *
 * The followings are the available columns in table '{{bids}}':
 * @property integer $bid_id
 * @property integer $user_id
 * @property string $created
 * @property integer $published
 * @property string $date_transportation
 * @property string $time_transportation
 * @property integer $date_unknown
 * @property integer $price
 * @property string $loading_town
 * @property string $loading_address
 * @property string $add_loading_unloading_town_1
 * @property string $add_loading_unloading_address_1
 * @property string $add_loading_unloading_town_2
 * @property string $add_loading_unloading_address_2
 * @property string $add_loading_unloading_town_3
 * @property string $add_loading_unloading_address_3
 * @property string $unloading_town
 * @property string $unloading_address
 *
 * The followings are the available model relations:
 * @property BidsCargoes[] $bidsCargoes
 */
class Bids extends CActiveRecord
{
	
	const SCENARIO_LOGIN_FORM = 'login_form';
	const SCENARIO_REG_FORM = 'reg_form';
	
	public $bid_email;
	public $bid_phone;
	public $bid_name;
	public $have_account;
	public $login_email;
	public $login_password;
	
	
	public $username;
	public $user_rating;
	public $full_name;
	public $need_porters;

	
	public $total_weight;
	public $total_unit;
	public $total_volume;
	public $deals_count;
	public $bid_foto;
	
	public $performer_name;
	public $review_text;	
	public $review_value;	
	public $rating;	
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{bids}}';
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
			array('loading_town, loading_address, unloading_town, unloading_address', 'required'),
			array('login_email, login_password', 'required', 'on'=>self::SCENARIO_LOGIN_FORM),
			array('bid_email, bid_phone, bid_name', 'required', 'on'=>self::SCENARIO_REG_FORM),
			array('login_email, bid_email', 'email'),
			array('login_password', 'length', 'max'=>128, 'min' => 4),
			array('bid_phone, bid_name', 'length', 'max'=>128),
			array('user_review, performer_review', 'length', 'max'=>400, 'min' => 10),
			//array('date_transportation, time_transportation', 'length', 'max'=>255),
			array('date_transportation, date_transportation_to', 'date', 'format' => 'yyyy-MM-dd'),
			array('time_transportation, time_transportation_to', 'date', 'format' => 'HH:mm'),
			
			array('user_id, category_id, published, date_unknown, price, quickly, performer_id, user_rating, performer_rating', 'numerical', 'integerOnly'=>true),
			array('loading_town, loading_address, add_loading_unloading_town_1, add_loading_unloading_address_1, add_loading_unloading_town_2, add_loading_unloading_address_2, add_loading_unloading_town_3, add_loading_unloading_address_3, unloading_town, unloading_address', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('bid_id, user_id, created, published, date_transportation, time_transportation, date_unknown, price, loading_town, loading_address, add_loading_unloading_town_1, add_loading_unloading_address_1, add_loading_unloading_town_2, add_loading_unloading_address_2, add_loading_unloading_town_3, add_loading_unloading_address_3, unloading_town, unloading_address', 'safe', 'on'=>'search'),
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
            'userInfo' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'category' => array(self::BELONGS_TO, 'Categories', 'category_id'),
            'bidsCargoes' => array(self::HAS_MANY, 'BidsCargoes', 'bid_id'),
        );	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bid_id' => 'Bid',
			'user_id' => 'User',
			'created' => 'Created',
			'published' => 'Published',
			'date_transportation' => 'Дата',
			'time_transportation' => 'Время',
			'date_transportation_to' => 'Дата',
			'time_transportation_to' => 'Время',
			'date_unknown' => 'Дата неизвестна',
			'price' => 'Максимальная цена',
			'loading_town' => 'Город',
			'loading_address' => 'Адрес',
			'add_loading_unloading_town_1' => 'Город',
			'add_loading_unloading_address_1' => 'Адрес',
			'add_loading_unloading_town_2' => 'Город',
			'add_loading_unloading_address_2' => 'Адрес',
			'add_loading_unloading_town_3' => 'Город',
			'add_loading_unloading_address_3' => 'Адрес',
			'unloading_town' => 'Город',
			'unloading_address' => 'Адрес',
			'bid_email' => 'E-mail',
			'bid_phone' => 'Телефон',
			'bid_name' => 'Как вас зовут',
			'have_account' => 'Я уже зарегистрирован на сайте',
			'login_email' => 'E-mail',
			'login_password' => 'Пароль',
			'quickly' => 'Срочно',
			'user_rating' => 'Оценка заказчика',
			'user_review' => 'Отзыв заказчика',
			'performer_rating' => 'Оценка перевозчика',
			'performer_review' => 'Отзыв перевозчика',
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

		$criteria->compare('bid_id',$this->bid_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('published',$this->published);
		$criteria->compare('date_transportation',$this->date_transportation,true);
		$criteria->compare('time_transportation',$this->time_transportation,true);
		$criteria->compare('date_unknown',$this->date_unknown);
		$criteria->compare('price',$this->price);
		$criteria->compare('loading_town',$this->loading_town,true);
		$criteria->compare('loading_address',$this->loading_address,true);
		$criteria->compare('add_loading_unloading_town_1',$this->add_loading_unloading_town_1,true);
		$criteria->compare('add_loading_unloading_address_1',$this->add_loading_unloading_address_1,true);
		$criteria->compare('add_loading_unloading_town_2',$this->add_loading_unloading_town_2,true);
		$criteria->compare('add_loading_unloading_address_2',$this->add_loading_unloading_address_2,true);
		$criteria->compare('add_loading_unloading_town_3',$this->add_loading_unloading_town_3,true);
		$criteria->compare('add_loading_unloading_address_3',$this->add_loading_unloading_address_3,true);
		$criteria->compare('unloading_town',$this->unloading_town,true);
		$criteria->compare('unloading_address',$this->unloading_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Bids the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	//обновляет id перевозчика
	public function updatePerfomer(&$connection, $bid_id, $performer_id)
	{
		$sql = "UPDATE ".$this->tableName()." SET `performer_id` = :performer_id WHERE `bid_id` = :bid_id";
		$command = $connection->createCommand($sql);
		$command->bindParam(":bid_id", $bid_id, PDO::PARAM_INT);
		$command->bindParam(":performer_id", $performer_id, PDO::PARAM_INT);
		$command->execute();
	}
	
	public function getBidsUser(&$connection, $user_id, $model, $where_field = 'user_id', $pageSize = 5, $orderBy = "t.`created` DESC", $filter = 'all')
	{
		$join = array();
		if($where_field == 'performer_id')	{
			$join[] = "INNER JOIN {{users}} AS u ON t.`user_id` = u.`id`";
		}	else	{
			$join[] = "INNER JOIN {{users}} AS u ON t.`performer_id` = u.`id`";
		}
		$criteria = new CDbCriteria;

		$criteria->select = "t.*, u.`username`";		
		$criteria->join = implode(' ', $join);
		$criteria->order = 't.bid_id DESC';
		$criteria->condition = "`$where_field` = $user_id";

		$dataProvider = new CActiveDataProvider('Bids', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>$pageSize,
				'pageVar' =>'page',
			),
		));
		
		//echo'<pre>';print_r($criteria,0);echo'</pre>';
		
		$bid_ids = array();
		foreach($dataProvider->data as $row) {
			$bid_ids[] = $row->bid_id;
		}
		
		$cargoes_info = Cargoes::model()->getCargoresInfo($connection, $bid_ids);
		
		$performer_reviews = ReviewsPerformers::model()->getUserReviews($connection, $user_id);
		
		foreach($dataProvider->data as $row) {
			$cargo_name = array();

			foreach($cargoes_info as $cargo) {
				if($cargo['bid_id'] == $row->bid_id) {
					$cargo_name[] = $cargo['name'];
				}
			}
			
			if(isset($performer_reviews[$row->bid_id]))	{
				$row->review_text = $performer_reviews[$row->bid_id]['text'];
				$row->review_value = $performer_reviews[$row->bid_id]['review_value'];
				$row->rating = $performer_reviews[$row->bid_id]['rating'];
			}	else	{
				$row->review_text = '';
				$row->review_value = 0;
				$row->rating = '';
			}
			
			$row->full_name = implode('. ', $cargo_name);
			if($where_field == 'performer_id')	{
				$row->performer_name = $model->username;
			}	else	{
				$row->performer_name = $row->username;
				$row->username = $model->username;
			}
		}
		
		
		return $dataProvider;
		
	}
	
	public function getBidsGruzodatel(&$connection, $user_id, $model, $where_field = 'user_id', $pageSize = 5, $orderBy = "t.`created` DESC", $filter = 'all')
	{
		$join = array();
		
		$criteria = new CDbCriteria;

		if($orderBy == "review DESC, t.`created` DESC")	{
			$criteria->select = "t.*, (CASE `user_review` WHEN '' THEN '0' ELSE '1' END) AS review";
		}	else	{
			$criteria->select = "t.*";
		}
		
		$condition = array(
			"(`$where_field` = $user_id)",
		);
		
		if($filter != 'all')	{
			$condition[] = "(`published` = 1)";
			
			$actual_date = date('Y-m-d', strtotime("-5 days"));			
			$condition[] = "((t.`date_transportation` = '0000-00-00' OR t.`date_transportation` >= '$actual_date') AND (t.`date_transportation_to` = '0000-00-00' OR t.`date_transportation_to` >= '$actual_date'))";
			
		}

		//$criteria->join = implode(' ', $join);
		$criteria->order = $orderBy;
		$criteria->condition = "`$where_field` = $user_id";
		$criteria->condition = implode(' AND ', $condition);

		$dataProvider = new CActiveDataProvider('Bids', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>$pageSize,
				'pageVar' =>'page',
			),
		));
		
		//echo'<pre>';print_r($criteria,0);echo'</pre>';
		
		$bid_ids = array();
		foreach($dataProvider->data as $row) {
			$bid_ids[] = $row->bid_id;
		}
		
		$cargoes_info = Cargoes::model()->getCargoresInfo($connection, $bid_ids);
		//echo'$cargoes_info<pre>';print_r($cargoes_info,0);echo'</pre>';
		
		$user_ids = array();
		foreach($dataProvider->data as $row) {
			if($row->performer_id != 0) $user_ids[] = $row->performer_id;
		}
		
		$user_names = User::model()->getUserNames($connection, $user_ids);
		//echo'<pre>';print_r($user_names,0);echo'</pre>';
		
		foreach($dataProvider->data as $row) {
			$cargo_name = array();

			foreach($cargoes_info as $cargo) {
				if($cargo['bid_id'] == $row->bid_id) {
					$cargo_name[] = $cargo['name'];
				}
			}
						
			$row->full_name = implode('. ', $cargo_name);
			if($where_field == 'performer_id')	{
				$row->performer_name = $model->username;
			}	else	{
			}
			
			$row->performer_name = isset($user_names[$row->performer_id]) ? $user_names[$row->performer_id]['username'] : '';
			$row->username = $model->username;
			
		}
		
		//echo'<pre>';print_r($dataProvider,0);echo'</pre>';
		
		
		return $dataProvider;
		
	}
	
	//возвращает заявки в которых отписывался перевозчик
	public function getBidsPerevozchik(&$connection, $user_id, $model, $pageSize = 5, $orderBy = "t.`created` DESC", $filter = 'all')
	{
		$join = array();
		$join[] = "INNER JOIN {{deals}} AS d USING(`bid_id`)";
		$join[] = "INNER JOIN {{users}} AS u ON t.`user_id` = u.`id`";
		
		$condition = array();
		$condition[] = "d.`user_id` = $user_id";
		
		if($filter == 'actual')	{
			$condition[] = "(`published` = 1)";
			$actual_date = date('Y-m-d', strtotime("-5 days"));			
			$condition[] = "((t.`date_transportation` = '0000-00-00' OR t.`date_transportation` >= '$actual_date') AND (t.`date_transportation_to` = '0000-00-00' OR t.`date_transportation_to` >= '$actual_date'))";
		}
		
		$criteria = new CDbCriteria;
		
		if($orderBy == "review DESC, t.`created` DESC")	{
			$criteria->select = "t.*, (CASE `user_review` WHEN '' THEN '0' ELSE '1' END) AS review, u.`username`";
		}	else	{
			$criteria->select = "t.*, u.`username`";
		}
				
		$criteria->join = implode(' ', $join);
		$criteria->order = $orderBy;
		
		$criteria->condition = implode(' AND ', $condition);
		
//		echo'<pre>';print_r($filter,0);echo'</pre>';//die;
//		echo'<pre>';print_r($orderBy,0);echo'</pre>';//die;
//		echo'<pre>';print_r($criteria,0);echo'</pre>';//die;
		
		$dataProvider = new CActiveDataProvider('Bids', array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => $pageSize,
				'pageVar' =>'page',
			),
		));
		
		
		
		$bid_ids = array();
		foreach($dataProvider->data as $row) {
			$bid_ids[] = $row->bid_id;
		}
		
		$cargoes_info = Cargoes::model()->getCargoresInfo($connection, $bid_ids);
		
		foreach($dataProvider->data as $row) {
			$cargo_name = array();

			foreach($cargoes_info as $cargo) {
				if($cargo['bid_id'] == $row->bid_id) {
					$cargo_name[] = $cargo['name'];
				}
			}
			
			$row->full_name = implode('. ', $cargo_name);
			
			$row->performer_name = $row->username;
			$row->username = $model->username;
			
		}
		return $dataProvider;
	}
	
	public function getTotalBidsPerevozchik(&$connection, $user_id, $filter = 'all')
	{
		$sql = "SELECT count(`id`) AS count FROM {{deals}} WHERE `user_id` = :user_id";
		//echo'<pre>';print_r($sql);echo'</pre>';
		$command = $connection->createCommand($sql);
		$command->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		return $command->queryScalar();
	}
	
	public function getTotalBidsGruzodatel(&$connection, $user_id)
	{
		$sql = "SELECT count(`bid_id`) AS count FROM ".$this->tableName()." WHERE `user_id` = :user_id";
		//echo'<pre>';print_r($sql);echo'</pre>';
		$command = $connection->createCommand($sql);
		$command->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		return $command->queryScalar();
	}
	
	//получает статистику по отзывам пользователя
	public function getUserReviewsStatistic(&$connection, $user_type = 'user', $user_id = 0)
	{

		$dateTo = date('Y-m-d H:i:s');
		
		$result = array(
			'month' => array(
				'good' => $this->getCountReviewValues($connection, $user_type, $user_id, 'good', date('Y-m-d H:i:s', strtotime("-1 month")), $dateTo),
				'bad' => $this->getCountReviewValues($connection, $user_type, $user_id, 'bad', date('Y-m-d H:i:s', strtotime("-1 month")), $dateTo),
			),
			'half-year' => array(
				'good' => $this->getCountReviewValues($connection, $user_type, $user_id, 'good', date('Y-m-d H:i:s', strtotime("-6 month")), $dateTo),
				'bad' => $this->getCountReviewValues($connection, $user_type, $user_id, 'bad', date('Y-m-d H:i:s', strtotime("-6 month")), $dateTo),
			),
			'total' => array(
				'good' => $this->getCountReviewValues($connection, $user_type, $user_id, 'good', date('Y-m-d H:i:s', strtotime("-50 year")), $dateTo),
				'bad' => $this->getCountReviewValues($connection, $user_type, $user_id, 'bad', date('Y-m-d H:i:s', strtotime("-50 year")), $dateTo),
			),
		);
		
		//echo'<pre>';print_r($result);echo'</pre>';
		
		return $result;
	}
	
	
	//возвращает кол-во отзывов за промежуток времени
	public function getCountReviewValues(&$connection, $user_type = 'user', $u_id = 0, $review_good = 'good', $dateFrom, $dateTo)
	{
		if($review_good == 'good')	{
			$rating_state = ' >= 5';
		}	else	{
			$rating_state = ' < 5';
		}
		$sql = "SELECT count(`bid_id`) FROM ".$this->tableName()." WHERE `".$user_type."_id` = :u_id AND `".$user_type."_rating` $rating_state AND `created` BETWEEN STR_TO_DATE('$dateFrom', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$dateTo', '%Y-%m-%d %H:%i:%s')";
		$command = $connection->createCommand($sql);
		$command->bindParam(":u_id", $u_id, PDO::PARAM_INT);
		return $command->queryScalar();
	}
	
	//возвращает произвольные отзывы
	public function getRandomReviews(&$connection)
	{
		$sql = "SELECT `bid_id`,`user_review`,`performer_review` FROM ".$this->tableName()." WHERE `user_review` <> '' OR `performer_review` <> '' ORDER BY RAND() LIMIT 0, 3";
		$command = $connection->createCommand($sql);
		return $command->queryAll();
	}
	
	public function UnpublishBid(&$connection, $bid_id)
	{
		$sql = "UPDATE ".$this->tableName()." SET `published` = 0 WHERE `bid_id` = :bid_id";
		$command = $connection->createCommand($sql);
		$command->bindParam(":bid_id", $bid_id, PDO::PARAM_INT);
		return $command->execute();
	}
	
	//возвращает кол-во положительных и отрицательных отзывов по пользователю
	public function getCountReviews(&$connection, $user_type = 'user', $u_id = 0)
	{
		$sql = "SELECT count(`bid_id`) FROM ".$this->tableName()." WHERE `performer_id` = :u_id AND `user_rating` >= 5 UNION SELECT count(`bid_id`) FROM ".$this->tableName()." WHERE `performer_id` = :u_id AND `user_rating` < 5 AND `user_rating` > 0";
		//echo'<pre>';print_r($sql,0);echo'</pre>';//die;
		$command = $connection->createCommand($sql);
		$command->bindParam(":u_id", $u_id, PDO::PARAM_INT);
		return $command->queryColumn();
	}
	
}
