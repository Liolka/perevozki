<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
$this->breadcrumbs=array(
	UserModule::t("Login"),
);
?>

<h1><?php echo UserModule::t("Login"); ?></h1>

<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

<div class="success">
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>

<?php endif; ?>

<div class="blue-border-1 p-20 bg_f4fbfe">
<? /* <p class="mb-20"><?php echo UserModule::t("Please fill out the following form with your login credentials:"); ?></p> */ ?>

<div class="form-login">
<?php echo CHtml::beginForm(); ?>
   

            <div class="row mb-20">
                <p class="col-sm-12 mb-5"><?php echo CHtml::activeLabelEx($model,'username', array('class'=>'bold')); ?></p>
                <p class="col-sm-12"><?php echo CHtml::activeTextField($model,'username', array('class'=>'width25')) ?></p>
            </div>

            <div class="row mb-20">
                <p class="col-sm-12 mb-5"><?php echo CHtml::activeLabelEx($model,'password', array('class'=>'bold')); ?></p>
                <p class="col-sm-12"><?php echo CHtml::activePasswordField($model,'password', array('class'=>'width25')) ?></p>
            </div>
            
            <div class="row rememberMe mb-20">
               <p class="col-sm-12 checkbox-wr">
                <?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
                <?php echo CHtml::activeLabelEx($model,'rememberMe', array('class'=>'bold')); ?>
                </p>
            </div>            

            <div class="row mb-40">
                <p class="col-sm-3"><?php echo CHtml::submitButton('Войти', array('class'=>'loginButton btn-grey-33 width100', 'name'=>'loginButton')); ?> </p>
                <p class="col-sm-7">
                    <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl, array('id'=>'lostPassword')); ?><br>
                    <?php echo CHtml::link("Забыли название учетной записи?",Yii::app()->getModule('user')->recoveryUrl, array('id'=>'lostPassword')); ?>
                </p>
            </div>


            <p class="narrow-bold-24 mb-10">Вы тут впервые?</p>
            <div class="row">
            	<p class="col-sm-3">
            		<?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl, array('class'=>'btn-grey-33 regBtn width100', 'id'=>'regBtn')); ?>
				</p>
            </div>
            

        

<?/*
	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
	
	<?php echo CHtml::errorSummary($model); ?>
	
	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'username'); ?>
		<?php echo CHtml::activeTextField($model,'username') ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'password'); ?>
		<?php echo CHtml::activePasswordField($model,'password') ?>
	</div>
	
	<div class="row">
		<p class="hint">
		<?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
		</p>
	</div>
	
	<div class="row rememberMe">
		<?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
		<?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>
	</div>

	<div class="row submit">
		<?php echo CHtml::submitButton(UserModule::t("Login")); ?>
	</div>
*/?>	
<?php echo CHtml::endForm(); ?>
</div><!-- form -->


<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>
</div>