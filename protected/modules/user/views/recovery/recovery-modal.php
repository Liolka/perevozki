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
            <h4 class="modal-title"><?php echo UserModule::t("Restore"); ?></h4>
            
            <?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
                <div class="flash-message flash-success"><?php echo Yii::app()->user->getFlash('recoveryMessage'); ?></div>
            <?php else: ?>

            <div class="form-group">
                <p class="col-sm-12"><?php echo CHtml::activeLabel($form,'login_or_email'); ?></p>
                <p class="col-sm-12"><?php echo CHtml::activeTextField($form,'login_or_email', array('class'=>'width100')) ?></p>
                <p class="col-sm-12 hint"><?php echo UserModule::t("Please enter your login or email addres."); ?></p>
            </div>

            <div class="form-group">
                <p class="col-sm-12"><?php echo CHtml::submitButton( UserModule::t("Restore"), array('class'=>'restoreButton btn-blue-33 width100', 'name'=>'restoreButton', 'id'=>'restoreButton')); ?> </p>
            </div>
            
             <?php endif; ?>

        </div>

        <div class="modal-footer">
            <h4 class="modal-title">Вы тут впервые?</h4>
            <?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl, array('class'=>'btn-grey-33 regBtn width100', 'id'=>'regBtn')); ?>
        </div>

        
    </div>
	
<?php echo CHtml::endForm(); ?>

</div><!-- form -->

