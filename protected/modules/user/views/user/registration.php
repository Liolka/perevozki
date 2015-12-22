<h1><?php echo $form_title ?></h4>

<?php if(Yii::app()->user->hasFlash('registration'))	{	?>
	<div class="flash-message flash-success"><?php echo Yii::app()->user->getFlash('registration'); ?></div>
<?php	}	else	{	?>

<div class="blue-border-1 p-20 bg_f4fbfe">
<div class="form">
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'registration-form',
	
	//'enableAjaxValidation'=>true,
	//'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('enctype'=>'multipart/form-data','class'=>'form-horizontal',),
)); ?>
            
            <?php echo $form->errorSummary(array($model,$profile)); ?>

            <div class="form-group">
                <p class="col-sm-12"><?php echo $form->radioButtonList($model, 'user_status', $model->user_status_labels, array('separator'=>' ')); ?></p>
            </div>

            <div class="form-group">
                <p class="col-sm-12"><?php echo $form->labelEx($model,'username'); ?></p>
                <p class="col-sm-12"><?php echo $form->textField($model,'username', array('class'=>'width100')); ?></p>
            </div>

            <div class="form-group">
                <p class="col-sm-12"><?php echo $form->labelEx($model,'email'); ?></p>
                <p class="col-sm-12"><?php echo $form->textField($model,'email', array('class'=>'width100')); ?></p>
            </div>
            
            <div class="form-group passwords-group">
                <p class="col-sm-6">
                    <?php echo $form->labelEx($model,'password'); ?>
                    <?php echo $form->passwordField($model,'password', array('class'=>'width100')); ?>
                </p>
                <p class="col-sm-6">
                    <?php echo $form->labelEx($model,'verifyPassword'); ?>
                    <?php echo $form->passwordField($model,'verifyPassword', array('class'=>'width100')); ?>
                </p>
            </div>
            
            <div class="form-group checkbox-wr">
                <p class="col-sm-12">
            		<?php echo $form->checkBox($model,'accept_rules'); ?>
	            	<?php echo $form->labelEx($model,'accept_rules'); ?> <a href="#" target="_blank">Соглашение</a>
                </p>
            </div>
            
	
            <div class="form-group">
               	<input type="hidden" name="user_type" value="<?=$_POST['user_type']?>" />
               	
                <p class="col-sm-12"><?php echo CHtml::submitButton( UserModule::t("Register"), array('class'=>'registerButton btn-blue-33', 'name'=>'registerButton', 'id'=>'registerButton')); ?> </p>
            </div>
            

        

        
            <h4 class="modal-title">Уже зарегистрированы?</h4>
            <?php echo CHtml::link(UserModule::t("Login"),Yii::app()->getModule('user')->loginUrl, array('class'=>'btn-grey-33 loginBtn')); ?>
        

        
    </div>
	
<?php //echo $form->endForm(); ?>
<?php $this->endWidget(); ?>
</div>
</div>


<?php	}	?>