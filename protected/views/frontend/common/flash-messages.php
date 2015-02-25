<?php if($app->user->hasFlash('success')): ?>
	<div class="flash-message flash-success"><?php echo $app->user->getFlash('success'); ?></div>
<?php endif; ?>

<?php if($app->user->hasFlash('error')): ?>
	<div class="flash-message flash-error"><?php echo $app->user->getFlash('error'); ?></div>
<?php endif; ?>

<?php if($app->user->hasFlash('warning')): ?>
	<div class="flash-message flash-warning"><?php echo $app->user->getFlash('warning'); ?></div>
<?php endif; ?>