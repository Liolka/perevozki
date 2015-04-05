<?php if($this->app->user->hasFlash('success')): ?>
	<div class="flash-message flash-success">
		<?php echo $this->app->user->getFlash('success'); ?>
	</div>
<?php endif; ?>

<?php if($this->app->user->hasFlash('error')): ?>
	<div class="flash-message flash-error">
		<?php echo $this->app->user->getFlash('error'); ?>
	</div>
<?php endif; ?>