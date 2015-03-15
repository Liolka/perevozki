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
            <h4 class="modal-title">Регистрация:</h4>

            <div class="form-group">
                <p class="col-sm-12 select-user-type-lbl">Выберите кто вы:</p>
            </div>
            
            <div class="form-group">
               <input type="hidden" name="user_type" id="user_type" value="0" />
                <p class="col-sm-5">
                    <a href="javascript:void(0)" data-type="1" class="btn-green-52 select-user-type width100">Грузодатель</a>  
                </p>
                <p class="col-sm-2 select-user-type-lbl" style="line-height:52px;">или</p>
                <p class="col-sm-5">                    
                    <a href="javascript:void(0)" data-type="2" class="btn-blue-52 select-user-type width100">Перевозчик</a>
                </p>
                
            </div>

        </div>

        <div class="modal-footer">
            <h4 class="modal-title">Уже зарегистрированы?</h4>
            <?php echo CHtml::link("Войти", Yii::app()->getModule('user')->loginUrlModal, array('class'=>'btn-grey-33 loginBtn width100', 'id'=>'loginBtn')); ?>
        </div>

        
    </div>
	
<?php echo CHtml::endForm(); ?>

</div>