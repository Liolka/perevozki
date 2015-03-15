<div class="form modal-dialog">
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'registration-form',
	
	//'enableAjaxValidation'=>true,
	//'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('enctype'=>'multipart/form-data','class'=>'form-horizontal',),
)); ?>
  
   <div class="modal-content">
   
        <div class="modal-header clearfix">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">Отменить х</span><span class="sr-only">Отменить х</span>
            </button>           
        </div> 

        <div class="modal-body">
            <h4 class="modal-title"><?php echo $form_title ?></h4>
            
            <?php if(Yii::app()->user->hasFlash('registration')): ?>
                <div class="flash-message flash-success"><?php echo Yii::app()->user->getFlash('registration'); ?></div>
            <?php else: ?>
            
            <?php echo $form->errorSummary(array($model,$profile)); ?>

            <div class="form-group">
                <p class="col-sm-12"><?php echo $form->radioButtonList($model, 'user_status', $model->user_status_labels, array('separator'=>' ')); ?></p>
            </div>

            <div class="form-group">
                <p class="col-sm-12"><?php echo $form->labelEx($model,'username'); ?></p>
                <p class="col-sm-12"><?php echo $form->textField($model,'username'); ?></p>
            </div>

            <div class="form-group">
                <p class="col-sm-12"><?php echo $form->labelEx($model,'email'); ?></p>
                <p class="col-sm-12"><?php echo $form->textField($model,'email'); ?></p>
            </div>
            
            <div class="form-group passwords-group">
                <p class="col-sm-6">
                    <?php echo $form->labelEx($model,'password'); ?>
                    <?php echo $form->passwordField($model,'password'); ?>
                </p>
                <p class="col-sm-6">
                    <?php echo $form->labelEx($model,'verifyPassword'); ?>
                    <?php echo $form->passwordField($model,'verifyPassword'); ?>
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
               	
                <p class="col-sm-12"><?php echo CHtml::submitButton( UserModule::t("Register"), array('class'=>'registerButton btn-blue-33 width100', 'name'=>'registerButton', 'id'=>'registerButton')); ?> </p>
            </div>
            
             <?php endif; ?>

        </div>

        <div class="modal-footer">
            <h4 class="modal-title">Уже зарегистрированы?</h4>
            <?php echo CHtml::link(UserModule::t("Login"),Yii::app()->getModule('user')->loginUrl, array('class'=>'btn-grey-33 loginBtn width100', 'id'=>'loginBtn')); ?>
        </div>

        
    </div>
	
<?php //echo $form->endForm(); ?>
<?php $this->endWidget(); ?>
</div>