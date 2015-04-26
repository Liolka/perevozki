<?php

/**
 * This is the model class for table "{{deals_posts}}".
 *
 * The followings are the available columns in table '{{deals_posts}}':
 * @property integer $id
 * @property integer $deal_id
 * @property integer $user_id
 * @property string $text
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Deals $deal
 */
class DealsPosts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{deals_posts}}';
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
			array('deal_id, user_id, text', 'required'),
			array('deal_id, user_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, deal_id, user_id, text', 'safe', 'on'=>'search'),
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
			'deal' => array(self::BELONGS_TO, 'Deals', 'deal_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'deal_id' => 'Deal',
			'user_id' => 'User',
			'text' => 'Text',
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
		$criteria->compare('deal_id',$this->deal_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('text',$this->text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DealsPosts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	//
	public function getDealsPosts(&$connection, $deal_ids = array() )
	{
		if(count($deal_ids))	{
			$sql = "SELECT dp.`id`, dp.`deal_id`, dp.`user_id`, dp.`created`, dp.`text`, u.`username`, u.`last_activity`, u.`user_type` FROM ".$this->tableName()." AS dp INNER JOIN {{users}} AS u ON dp.`user_id` = u.`id` WHERE `deal_id` IN (".implode(',', $deal_ids).") ORDER by `created` DESC";
			//echo'<pre>';print_r($bid_id);echo'</pre>';
			//echo'<pre>';print_r($sql);echo'</pre>';
			$command = $connection->createCommand($sql);
			//$command->bindParam(":deal_ids", implode(',', $deal_ids));
			$result = $command->queryAll();
		}	else	{
			$result = array();
		}
		//echo'<pre>';print_r($deal_ids);echo'</pre>';
		//echo'<pre>';print_r($result);echo'</pre>';
		return $result;
		
	}
	
}
