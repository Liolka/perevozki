<?php

?>


<div class="form modal-dialog">
<?php echo CHtml::beginForm('', 'post', array('class' => 'form-horizontal')); ?>
   <div class="modal-content">
   
        <div class="modal-header clearfix">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">Отменить х</span><span class="sr-only">Отменить х</span>
            </button>           
        </div> 

        <div class="modal-body">
            <h4 class="modal-title">Войти:</h4>

            <div class="form-group">
                <p class="col-sm-12"><?php echo CHtml::activeLabelEx($model,'username'); ?></p>
                <p class="col-sm-12"><?php echo CHtml::activeTextField($model,'username', array('class'=>'width100')) ?></p>
            </div>

            <div class="form-group">
                <p class="col-sm-12"><?php echo CHtml::activeLabelEx($model,'password'); ?></p>
                <p class="col-sm-12"><?php echo CHtml::activePasswordField($model,'password', array('class'=>'width100')) ?></p>
            </div>
            
            <div class="form-group rememberMe">
               <p class="col-sm-12 checkbox-wr">
                <?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
                <?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>
                </p>
            </div>            

            <div class="form-group">
                <p class="col-sm-5"><?php echo CHtml::submitButton('Войти', array('class'=>'loginButton btn-grey-33 width100', 'name'=>'loginButton')); ?> </p>
                <p class="col-sm-7">
                    <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl, array('id'=>'lostPassword')); ?><br>
                    <?php echo CHtml::link("Забыли название учетной записи?",Yii::app()->getModule('user')->recoveryUrl, array('id'=>'lostPassword')); ?>
                </p>
            </div>

        </div>

        <div class="modal-footer">
            <h4 class="modal-title">Вы тут впервые?</h4>
            <?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl, array('class'=>'btn-grey-33 regBtn width100', 'id'=>'regBtn')); ?>
        </div>

        
    </div>
	
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