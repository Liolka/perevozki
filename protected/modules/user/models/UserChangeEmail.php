<?php
/**
 * UserChangePassword class.
 * UserChangePassword is the data structure for keeping
 * user change password form data. It is used by the 'changepassword' action of 'UserController'.
 */
class UserChangeEmail extends CFormModel {
	public $newEmail;
	public $password;
	
	public function rules() {
		return array(
			array('password, newEmail', 'required'),
			array('newEmail', 'email'),
			array('password, newEmail', 'length', 'max'=>128, 'min' => 4),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'newEmail'=>'Новый E-mail',
			'password'=>UserModule::t("password"),
		);
	}
	
	/**
	 * Verify Old Password
	 */
	 public function verifyOldPassword($attribute, $params)
	 {
		 if (User::model()->notsafe()->findByPk(Yii::app()->user->id)->password != Yii::app()->getModule('user')->encrypting($this->$attribute))
			 $this->addError($attribute, UserModule::t("Old Password is incorrect."));
	 }
}