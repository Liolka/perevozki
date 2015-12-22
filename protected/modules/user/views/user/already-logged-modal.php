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
			<div class="flash-message flash-error">
				<?php echo Yii::app()->user->getFlash('registration'); ?>
        	</div>
        </div>

        <div class="modal-footer">
            <?php echo CHtml::link("В кабинет", $this->createUrl('/user/my'), array('class'=>'btn-grey-33 width100')); ?>
        </div>

        
    </div>
	
<?php echo CHtml::endForm(); ?>

</div>