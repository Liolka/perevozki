<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class RegistrationForm extends User {
	public $verifyPassword;
	//public $verifyCode;
	public $accept_rules;
	
	const SCENARIO_REGISTRATION = 'scenario_registration';
	
	public function rules() {
		$rules = array(
			array('username, password, verifyPassword, email', 'required'),
			array('user_status', 'required', 'message' => 'Укажите Ваш статус'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
			array('user_status', 'numerical', 'integerOnly'=>true),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			//array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")),
			array('username', 'match', 'pattern' => '/^[А-Яа-яA-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('accept_rules', 'required', 'requiredValue' => '1', 'on'=>self::SCENARIO_REGISTRATION, 'message' => 'Ознакомьтесь с правилами'),
		);
        /*
		if (!(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')) {
			array_push($rules,array('verifyCode', 'captcha', 'allowEmpty'=>!UserModule::doCaptcha('registration')));
		}
        */
		
		array_push($rules,array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")));
		return $rules;
	}
	
}