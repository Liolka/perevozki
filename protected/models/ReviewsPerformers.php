<?php

/**
 * This is the model class for table "{{reviews_performers}}".
 *
 * The followings are the available columns in table '{{reviews_performers}}':
 * @property integer $id
 * @property string $created
 * @property string $modified
 * @property integer $performer_id
 * @property integer $author_id
 * @property string $text
 * @property integer $review_value
 * @property integer $bad
 * @property double $rating
 */
class ReviewsPerformers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{reviews_performers}}';
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
			//array('bid_id, performer_id, author_id, text, review_value, bad, rating', 'required'),
			array('bid_id, performer_id, author_id, text, review_value', 'required'),
			array('bid_id, performer_id, author_id, review_value', 'numerical', 'integerOnly'=>true),
			array('rating', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, created, modified, bid_id, performer_id, author_id, text, review_value, rating', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'created' => 'Created',
			'modified' => 'Modified',
			'performer_id' => 'User',
			'author_id' => 'Author',
			'text' => 'Text',
			'review_value' => 'review_value',
			'bad' => 'Bad',
			'rating' => 'Rating',
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
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('performer_id',$this->performer_id);
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('review_value',$this->review_value);
		$criteria->compare('bad',$this->bad);
		$criteria->compare('rating',$this->rating);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReviewsPerformers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	//получает инфу по отзывам о перевозчике
	public function getPerfomerReviews(&$connection, $performer_id = 0)
	{
		$sql = "SELECT `id`, `bid_id`, `performer_id`, `author_id`, `text`, `review_value`, `rating` FROM ".$this->tableName()." WHERE `performer_id` = :performer_id";
		//echo'<pre>';print_r($bid_id);echo'</pre>';
		//echo'<pre>';print_r($sql);echo'</pre>';
		$command = $connection->createCommand($sql);
		$command->bindParam(":performer_id", $performer_id, PDO::PARAM_INT);
		$rows = $command->queryAll();
		$res = array();
		foreach($rows as $row)	{
			$res['bid_id'] = $row;
		}
		
		return $res;
		
	}
	
	//получает инфу по отзывам пользователя
	public function getUserReviews(&$connection, $author_id = 0)
	{
		$sql = "SELECT `id`, `bid_id`, `performer_id`, `author_id`, `text`, `review_value`, `rating` FROM ".$this->tableName()." WHERE `author_id` = :author_id";
		//echo'<pre>';print_r($bid_id);echo'</pre>';
		//echo'<pre>';print_r($sql);echo'</pre>';
		$command = $connection->createCommand($sql);
		$command->bindParam(":author_id", $author_id, PDO::PARAM_INT);
		$rows = $command->queryAll();
		//echo'<pre>';print_r($rows);echo'</pre>';
		$res = array();
		foreach($rows as $row)	{
			$res[$row['bid_id']] = $row;
		}
		return $res;		
	}
	
	//получает статистику по отзывам пользователя
	public function getUserReviewsStatistic(&$connection, $performer_id = 0)
	{

		$dateTo = date('Y-m-d H:i:s');
		
		$result = array(
			'month' => array(
				'good' => $this->getCountReviewValues($connection, $performer_id, 1, date('Y-m-d H:i:s', strtotime("-1 month")), $dateTo),
				'bad' => $this->getCountReviewValues($connection, $performer_id, -1, date('Y-m-d H:i:s', strtotime("-1 month")), $dateTo),
			),
			'half-year' => array(
				'good' => $this->getCountReviewValues($connection, $performer_id, 1, date('Y-m-d H:i:s', strtotime("-6 month")), $dateTo),
				'bad' => $this->getCountReviewValues($connection, $performer_id, -1, date('Y-m-d H:i:s', strtotime("-6 month")), $dateTo),
			),
			'total' => array(
				'good' => $this->getCountReviewValues($connection, $performer_id, 1, date('Y-m-d H:i:s', strtotime("-50 year")), $dateTo),
				'bad' => $this->getCountReviewValues($connection, $performer_id, -1, date('Y-m-d H:i:s', strtotime("-50 year")), $dateTo),
			),
		);
		
		//echo'<pre>';print_r($result);echo'</pre>';
		
		return $result;
	}
	
	
	//возвращает кол-во отзывов за промежуток времени
	public function getCountReviewValues(&$connection, $performer_id = 0, $review_value = 1, $dateFrom, $dateTo)
	{
		$sql = "SELECT count(`id`) FROM ".$this->tableName()." WHERE `performer_id` = :performer_id AND `review_value` = :review_value AND `created` BETWEEN STR_TO_DATE('$dateFrom', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('$dateTo', '%Y-%m-%d %H:%i:%s')";
		$command = $connection->createCommand($sql);
		$command->bindParam(":performer_id", $performer_id, PDO::PARAM_INT);
		$command->bindParam(":review_value", $review_value, PDO::PARAM_INT);
		return $command->queryScalar();
	}
	
	
}
