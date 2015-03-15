<?php

class RegistrationController extends Controller
{
	public $defaultAction = 'registration';
	
	public $current_controller = '';
	public $current_action = '';
	public $theme_baseUrl = '';
	public $request_baseUrl = '';
	public $app = null;
	
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
	
	/**
	 * Registration user
	 */
	
	public function actionRegistration() {
        
		if(isset($_POST['user_type']) || isset($_POST['RegistrationForm'])) {
			
            $model = new RegistrationForm;
            $profile = new Profile;
            $profile->regMode = true;
            
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
			{
				echo UActiveForm::validate(array($model,$profile));
				Yii::app()->end();
			}
			
		    if (Yii::app()->user->id) {
		    	$this->redirect(Yii::app()->controller->module->profileUrl);
		    } else {
                $layout = '/user/registration-modal';
		    	if(isset($_POST['RegistrationForm'])) {
					//echo'<pre>';print_r($_POST['RegistrationForm']);echo'</pre>';//die;
					$model->scenario = RegistrationForm::SCENARIO_REGISTRATION;
					
					$model->attributes=$_POST['RegistrationForm'];
					//echo'<pre>';print_r($model->attributes);echo'</pre>';die;
					$profile->attributes=((isset($_POST['Profile'])?$_POST['Profile']:array()));
					if($model->validate()&&$profile->validate())
					{
						$soucePassword = $model->password;
						$model->activkey=UserModule::encrypting(microtime().$model->password);
						$model->password=UserModule::encrypting($model->password);
						$model->verifyPassword=UserModule::encrypting($model->verifyPassword);
						$model->superuser=0;
						$model->status=((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);
						
						$model->user_type = $_POST['user_type'];
						$model->user_status = $_POST['RegistrationForm']['user_status'];
						
						if ($model->save()) {
							$profile->user_id=$model->id;
							$profile->save();
							if (Yii::app()->controller->module->sendActivationMail) {
								$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email));
								UserModule::sendMail($model->email,UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)));
							}
							
							if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
									$identity=new UserIdentity($model->username,$soucePassword);
									$identity->authenticate();
									Yii::app()->user->login($identity,0);
									$this->redirect(Yii::app()->controller->module->returnUrl);
							} else {
								if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
								} elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Login'),Yii::app()->controller->module->loginUrl))));
								} elseif(Yii::app()->controller->module->loginNotActiv) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
								} else {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email."));
								}
								//$this->refresh();
                                //$this->renderPartial($layout, array('model'=>$model,'profile'=>$profile));die;
							}
						}
					} else $profile->validate();
				}
				
				$model->user_status = 1;
                
                switch($_POST['user_type']) {
                    case 1:
                        $form_title = "Грузодатель";
                        break;
                    case 2:
                        $form_title = "Перевозчик";
                        break;
                }
				
				
				
			    $this->renderPartial($layout, array(
                    'model'=>$model,
                    'profile'=>$profile,
                    'form_title'=>$form_title,
                ));
		    }
			
		}	else	{
			$layout = '/user/registration_select_type-modal';
			$this->renderPartial($layout, array());
			
		}
	}
}