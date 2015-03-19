<?php
/* @var $this BidsController */
/* @var $model Bids */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bids-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<?php if($this->app->user->hasFlash('registration')): ?>
		<div class="success flash-message flash-success">
			<?php echo $this->app->user->getFlash('registration'); ?>
		</div>
	<?php endif; ?>

	<?php if($this->app->user->hasFlash('bidMessageSuccess')): ?>
		<div class="success flash-message flash-success">
			<?php echo $this->app->user->getFlash('bidMessageSuccess'); ?>
		</div>
	<?php endif; ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="step-container">
		<div class="container ">

			<p class="num-step num-step-green">1</p>
			<p class="step-title">Выберите категорию перевозки</p>

			<div class="row">
				<ul class="clearfix">
				<? foreach($categories_list_level1 as $cat) {	?>
					<li class="col-md-2 col-lg-2 step1-list-item">
						<a href="javascript:void(0)" class="step1-category-item step1-category-item-<?=$cat['id']?>" data-catid="<?=$cat['id'] ?>">
							<span class="span-wr1"><span class="span-wr2"><?=$cat['name']?></span></span>
						</a>
					</li>
				<? } ?>
				</ul>
				<input type="hidden" name="Cargoes[category_id]" id="category_id" value="<?=$category_id?>" />
			</div>

		</div>
	</div>
	<div id="step2Container"></div>
	
	<div id="step3Container"></div>
	
	<div id="step-final-btn-wr" class="buttons text-align-center hide-block">
		<?php echo CHtml::submitButton('Перейти к финальному шагу', array('class'=>'btn-green-52 step-final-btn', 'name' => 'step3')); ?>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->