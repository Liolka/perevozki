<?php

/**
 * This is the model class for table "{{reviews_performers}}".
 *
 * The followings are the available columns in table '{{reviews_performers}}':
 * @property integer $id
 * @property string $created
 * @property string $modified
 * @property integer $user_id
 * @property integer $author_id
 * @property string $text
 * @property integer $good
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

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bid_id, user_id, author_id, text, good, bad, rating', 'required'),
			array('bid_id, user_id, author_id, good, bad', 'numerical', 'integerOnly'=>true),
			array('rating', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, created, modified, bid_id, user_id, author_id, text, good, bad, rating', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'author_id' => 'Author',
			'text' => 'Text',
			'good' => 'Good',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('good',$this->good);
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
	public function getPerfomerReviews(&$connection, $user_id = 0)
	{
		$sql = "SELECT `id`, `bid_id`, `user_id`, `author_id`, `text`, `good`, `bad`,`rating` FROM ".$this->tableName()." WHERE `user_id` = :user_id";
		//echo'<pre>';print_r($bid_id);echo'</pre>';
		//echo'<pre>';print_r($sql);echo'</pre>';
		$command = $connection->createCommand($sql);
		$command->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$rows = $command->queryAll();
		$res = array();
		foreach($rows as $row)	{
			$res['bid_id'] = $row;
		}
		
		return $res;
		
	}
	
}
