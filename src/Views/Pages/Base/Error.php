<?php ob_start(); ?>
<h1><?= $h1; ?></h1>
<p><?= $message; ?></p>
<?php $content = ob_get_clean(); ?>