<?php
/* @var $this BidsController */
/* @var $model Bids */

$this->breadcrumbs=array(
	'Заявка на перевозку грузов',
);

$cs = $this->app->clientScript;
$cs->registerCoreScript('ajax-upload');
?>

<h1>Заявка на перевозку грузов</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bids-form',
	'enableAjaxValidation'=>true,
	'action'=>$this->createUrl('/bids/create'),
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
						<a href="javascript:void(0)" class="step1-category-item step1-category-item-<?=$cat['id']; if($cat['id'] == $category_id) echo ' active';?>" data-catid="<?=$cat['id'] ?>">
							<span class="span-wr1"><span class="span-wr2"><?=$cat['name']?></span></span>
						</a>
					</li>
				<? } ?>
				</ul>
				<input type="hidden" name="Cargoes[category_id]" id="category_id" value="<?=$category_id?>" />
			</div>

		</div>
	</div>
	<div id="step2Container">
		<div class="step-container">
			<div class="container pb-20">

				<p class="num-step num-step-green">2</p>
				<p class="step-title">Выберите одну или несколько подкатегорий</p>

				<div class="row">
					<ul class="clearfix">
					<? foreach($categories_list_level2 as $cat) {	?>
						<li class="col-md-3 col-lg-3 step2-list-item">
							<p class="step2-category-item">
								<input type="checkbox" name="Cargoes[category1][]" onchange="change_step2_cat(this)" id="step2-category-item-<?=$cat['id']?>" class="checkbox step2-category-item-checkbox" value="<?=$cat['id']?>"><label for="step2-category-item-<?=$cat['id']?>" class="checkbox-lbl"><?=$cat['name']?></label>
							</p>
						</li>
					<? } ?>
					</ul>
				</div>

			</div>
		</div>		
	</div>
	
	<div id="step3Container"></div>
	
	<div id="step-final-btn-wr" class="buttons text-align-center hide-block">
		<?php echo CHtml::submitButton('Перейти к финальному шагу', array('class'=>'btn-green-52 step-final-btn', 'name' => 'step3')); ?>
	</div>
	
<?php $this->endWidget(); ?>

</div>